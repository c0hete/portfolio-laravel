#!/usr/bin/env bash
#
# Colector ETL — IPs baneadas por fail2ban (alimenta el widget de seguridad).
#
# Corre EN EL HOST del hub (vía cron, como root o con sudo: la DB de fail2ban es
# root-only). Lee los baneos del jail sshd desde la sqlite de fail2ban, los
# geolocaliza con la base GeoIP local (DB-IP Lite, mmdblookup), ENMASCARA la IP
# (no se guarda la IP completa) y los persiste invocando el comando artisan
# dentro del container del portafolio. Patrón ETL: host extrae+geolocaliza, Laravel carga.
#
# Requisitos en el host:
#   - mmdblookup (paquete: libmaxminddb-dev / mmdb-bin) + base GeoIP en GEOIP_DB.
#   - acceso root a /var/lib/fail2ban/fail2ban.sqlite3
#
# Instalar en cron (root, cada 15 min). Definir el salt en la línea de cron:
#   */15 * * * * BANNED_HASH_SALT='<valor-secreto>' /home/master/sites/portafolio/deploy/registrar-baneos.sh >> /home/master/logs/registrar-baneos.log 2>&1
#
set -euo pipefail

F2B_DB="/var/lib/fail2ban/fail2ban.sqlite3"
GEOIP_DB="/usr/share/GeoIP/dbip-country-lite.mmdb"
APP_SERVICE="app"
COMPOSE_FILE="docker-compose.prod.yml"
APP_DIR="/home/master/sites/portafolio"
# Salt para el hash de dedupe de IPs. Se lee de la env var BANNED_HASH_SALT
# (definida en el entorno del cron / .env del server), NUNCA hardcodeada en el
# repo público — así el hash no es atacable por diccionario con el salt conocido.
# El fallback solo aplica en local/dev; en producción debe venir del entorno.
HASH_SALT="${BANNED_HASH_SALT:-dev-only-local-salt}"

[ -r "$F2B_DB" ] || { echo "[$(date -Is)] ERROR: no puedo leer $F2B_DB (¿root?)"; exit 1; }

# Enmascara una IPv4 (a.b.c.d -> a.b.x.x). IPv6 -> primer bloque + ::x.
mask_ip() {
  local ip="$1"
  if [[ "$ip" == *:* ]]; then
    echo "${ip%%:*}::x"
  else
    echo "$ip" | awk -F. '{print $1"."$2".x.x"}'
  fi
}

# País de una IP vía base GeoIP local (vacío si no resuelve).
geo_country() {
  local ip="$1"
  if command -v mmdblookup >/dev/null 2>&1 && [ -r "$GEOIP_DB" ]; then
    mmdblookup --file "$GEOIP_DB" --ip "$ip" country iso_code 2>/dev/null \
      | grep -oE '"[A-Z]{2}"' | head -1 | tr -d '"'
  fi
}

# Baneos del jail sshd (sqlite de fail2ban). Por IP: count REAL de baneos +
# fecha del último. El COUNT(*) es cuántas veces fail2ban baneó esa IP (dato
# verdadero), NO cuántas veces corrió este cron.
ROWS=$(sqlite3 "$F2B_DB" "SELECT ip, COUNT(*), datetime(MAX(timeofban),'unixepoch') FROM bips WHERE jail='sshd' GROUP BY ip;" 2>/dev/null || true)

[ -n "$ROWS" ] || { echo "[$(date -Is)] sin baneos que registrar"; exit 0; }

# Construir array JSON.
JSON="["
first=1
while IFS='|' read -r ip bans banned_at; do
  [ -z "$ip" ] && continue
  masked=$(mask_ip "$ip")
  country=$(geo_country "$ip")
  hash=$(printf '%s%s' "$HASH_SALT" "$ip" | sha256sum | cut -d' ' -f1)
  [ $first -eq 0 ] && JSON+=","
  first=0
  JSON+=$(printf '{"ip_masked":"%s","ip_hash":"%s","country":"%s","jail":"sshd","bans":%s,"banned_at":"%s"}' \
    "$masked" "$hash" "$country" "${bans:-1}" "$banned_at")
done <<< "$ROWS"
JSON+="]"

cd "$APP_DIR"
docker compose -f "$COMPOSE_FILE" exec -T "$APP_SERVICE" \
  php artisan infra:registrar-baneos --json="$JSON"

echo "[$(date -Is)] OK"
