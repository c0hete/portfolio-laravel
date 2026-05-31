#!/usr/bin/env bash
#
# Colector ETL — sondeos a la infraestructura (alimenta el widget de seguridad).
#
# Corre EN EL HOST del hub (vía cron). Cuenta los accesos rechazados en los logs
# del reverse-proxy NPM (container proxy-app-1) y persiste el resultado en la DB
# del portafolio invocando el comando artisan `infra:contar-sondeos` dentro de su
# container. Patrón ETL: el host EXTRAE (tiene docker), Laravel CARGA (DB).
#
# Instalar en cron (cada hora):
#   0 * * * * /home/master/sites/portafolio/deploy/contar-sondeos-infra.sh >> /home/master/logs/contar-sondeos.log 2>&1
#
set -euo pipefail

PROXY_CONTAINER="proxy-app-1"
APP_SERVICE="app"   # nombre del SERVICIO en el compose (no el del container)
COMPOSE_FILE="docker-compose.prod.yml"
APP_DIR="/home/master/sites/portafolio"

# 1) EXTRAER: total de sondeos = líneas en los logs de acceso del fallback de NPM
#    (peticiones a hosts/paths no servidos = escaneo de bots). Incluye los .gz rotados.
TOTAL=$(docker exec -i "$PROXY_CONTAINER" sh -c \
  'cat /data/logs/fallback_http_access.log /data/logs/fallback_http_access.log.*.gz 2>/dev/null | zcat -f 2>/dev/null | wc -l' \
  | tr -d '[:space:]')

# 2) EXTRAER subset: intentos a secretos (.env / .git / credenciales).
SECRETOS=$(docker exec -i "$PROXY_CONTAINER" sh -c \
  'cat /data/logs/fallback_http_access.log /data/logs/fallback_http_access.log.*.gz 2>/dev/null | zcat -f 2>/dev/null | grep -iE "\.env|\.git|\.aws|\.ssh|id_rsa|credentials|wp-config|\.htpasswd" | wc -l' \
  | tr -d '[:space:]')

# Validación defensiva: si el conteo no es numérico, abortar sin tocar la DB.
if ! [[ "$TOTAL" =~ ^[0-9]+$ ]]; then
  echo "[$(date -Is)] ERROR: conteo TOTAL no numérico ('$TOTAL'); no se actualiza." >&2
  exit 1
fi
[[ "$SECRETOS" =~ ^[0-9]+$ ]] || SECRETOS=0

# 3) CARGAR: persistir en la DB del portafolio vía el comando artisan.
cd "$APP_DIR"
docker compose -f "$COMPOSE_FILE" exec -T "$APP_SERVICE" \
  php artisan infra:contar-sondeos --total="$TOTAL" --secretos="$SECRETOS"

echo "[$(date -Is)] OK: total=$TOTAL secretos=$SECRETOS"
