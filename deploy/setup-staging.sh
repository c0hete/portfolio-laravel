#!/usr/bin/env bash
# =============================================================================
# setup-staging.sh - Montar el entorno de STAGING del portafolio "de una patada"
# =============================================================================
# Automatiza lo que el pipeline NO hace: el montaje INICIAL de un entorno nuevo.
# (El pipeline solo hace git pull + rebuild sobre un entorno YA montado.)
#
# Idempotente: correrlo 2 veces no rompe nada (detecta lo que ya existe y lo saltea).
#
# Corre EN EL HUB (bash del server), NO en tu PC Windows:
#   ssh hub
#   cd ~/sites/portafolio-staging/deploy   # (o donde lo dejes)
#   ./setup-staging.sh
#
# --- PREREQUISITOS (los preparás VOS antes de correr) ------------------------
#   1. DNS: staging.alvaradomazzei.cl -> IP del hub, en GREY/DNS-only (Cloudflare).
#      El script valida que resuelva; si no, aborta con mensaje claro.
#   2. NPM admin: email + password (para crear el proxy host vía API).
#      Se pasan por variables de entorno (ver abajo), nunca hardcodeadas.
#   3. Red nginx_network ya existe en el hub (la crea NPM).
#
# --- VARIABLES (pasalas al invocar; las que faltan se generan/preguntan) -----
#   NPM_ADMIN_EMAIL     (requerida) email admin de NPM
#   NPM_ADMIN_PASSWORD  (requerida) password admin de NPM
#   STAGING_DOMAIN      (opcional)  default: staging.alvaradomazzei.cl
#   STAGING_PATH        (opcional)  default: $HOME/sites/portafolio-staging
#   REPO_URL            (opcional)  default: https://github.com/c0hete/portfolio-laravel.git
#   BRANCH              (opcional)  default: develop
#   NPM_API             (opcional)  default: http://127.0.0.1:81
#
# Ejemplo:
#   NPM_ADMIN_EMAIL=jose@alvaradomazzei.cl NPM_ADMIN_PASSWORD=*** ./setup-staging.sh
#
# Flags:
#   --dry-run   muestra qué haría, sin tocar nada
# =============================================================================

set -euo pipefail

# --- colores / helpers -------------------------------------------------------
c_ok="\033[32m"; c_warn="\033[33m"; c_err="\033[31m"; c_info="\033[36m"; c_off="\033[0m"
log()  { echo -e "${c_info}==>${c_off} $*"; }
ok()   { echo -e "${c_ok}  ✓${c_off} $*"; }
warn() { echo -e "${c_warn}  !${c_off} $*"; }
die()  { echo -e "${c_err}  ✗ $*${c_off}" >&2; exit 1; }

DRY_RUN=0
[ "${1:-}" = "--dry-run" ] && DRY_RUN=1 && warn "DRY-RUN: no se ejecuta nada real"

# --- config (con defaults) ---------------------------------------------------
STAGING_DOMAIN="${STAGING_DOMAIN:-staging.alvaradomazzei.cl}"
STAGING_PATH="${STAGING_PATH:-$HOME/sites/portafolio-staging}"
REPO_URL="${REPO_URL:-https://github.com/c0hete/portfolio-laravel.git}"
BRANCH="${BRANCH:-develop}"
NPM_API="${NPM_API:-http://127.0.0.1:81}"
COMPOSE_FILE="docker-compose.staging.yml"

# =============================================================================
# 0. Validar prerequisitos (fallar temprano y claro)
# =============================================================================
log "Validando prerequisitos..."

command -v docker >/dev/null || die "docker no está en PATH"
command -v git    >/dev/null || die "git no está en PATH"
command -v curl   >/dev/null || die "curl no está en PATH"

# DNS: debe resolver a una IP (no exigimos cuál; el hub puede tener varias)
if ! getent hosts "$STAGING_DOMAIN" >/dev/null 2>&1 && ! nslookup "$STAGING_DOMAIN" >/dev/null 2>&1; then
    die "DNS de $STAGING_DOMAIN no resuelve. Creá el registro A en Cloudflare (grey/DNS-only) ANTES de correr esto."
fi
ok "DNS de $STAGING_DOMAIN resuelve"

# Red de NPM
docker network inspect nginx_network >/dev/null 2>&1 || die "la red nginx_network no existe (la crea NPM)"
ok "red nginx_network existe"

# Credenciales NPM (requeridas para el paso 5)
: "${NPM_ADMIN_EMAIL:?Falta NPM_ADMIN_EMAIL (email admin de NPM)}"
: "${NPM_ADMIN_PASSWORD:?Falta NPM_ADMIN_PASSWORD (password admin de NPM)}"
ok "credenciales NPM presentes"

if [ "$DRY_RUN" = "1" ]; then
    log "DRY-RUN: prerequisitos OK. Acá terminaría la simulación."
    exit 0
fi

# =============================================================================
# 1. Clonar el repo (idempotente: si existe, hace fetch+checkout)
# =============================================================================
if [ -d "$STAGING_PATH/.git" ]; then
    log "Repo ya existe en $STAGING_PATH → fetch + checkout $BRANCH"
    git -C "$STAGING_PATH" fetch origin "$BRANCH" --quiet
    git -C "$STAGING_PATH" checkout "$BRANCH" --quiet
    git -C "$STAGING_PATH" reset --hard "origin/$BRANCH" --quiet
else
    log "Clonando $REPO_URL ($BRANCH) en $STAGING_PATH"
    git clone -b "$BRANCH" "$REPO_URL" "$STAGING_PATH" --quiet
fi
ok "código en $BRANCH @ $(git -C "$STAGING_PATH" rev-parse --short HEAD)"

cd "$STAGING_PATH"

# =============================================================================
# 2. Generar el .env de staging (idempotente: no pisa uno existente)
# =============================================================================
if [ -f .env ]; then
    ok ".env ya existe (no se toca)"
else
    log "Generando .env de staging (APP_KEY + DB password nuevos)"
    cp .env.example .env
    APP_KEY="base64:$(openssl rand -base64 32)"
    DB_PW="$(openssl rand -hex 24)"
    sed -i \
        -e 's|^APP_NAME=.*|APP_NAME="Portafolio (Staging)"|' \
        -e 's|^APP_ENV=.*|APP_ENV=staging|' \
        -e 's|^APP_DEBUG=.*|APP_DEBUG=false|' \
        -e "s|^APP_KEY=.*|APP_KEY=$APP_KEY|" \
        -e "s|^APP_URL=.*|APP_URL=https://$STAGING_DOMAIN|" \
        -e 's|^DB_CONNECTION=.*|DB_CONNECTION=pgsql|' \
        .env
    printf '\nDB_HOST=portfolio_staging_db\nDB_PORT=5432\nDB_DATABASE=portfolio_staging\nDB_USERNAME=staging\nDB_PASSWORD=%s\n' "$DB_PW" >> .env
    ok ".env de staging generado (APP_ENV=staging → noindex automático)"
fi

# =============================================================================
# 3. Levantar el stack (build + up)
# =============================================================================
log "docker compose up -d --build ($COMPOSE_FILE)"
docker compose -f "$COMPOSE_FILE" up -d --build
ok "stack staging levantado"

# Esperar a que la DB esté healthy
log "esperando DB healthy..."
for i in $(seq 1 30); do
    if docker compose -f "$COMPOSE_FILE" ps db 2>/dev/null | grep -q healthy; then break; fi
    sleep 2
done

# =============================================================================
# 4. Migrate + seed (idempotente: migrate no re-corre lo aplicado; seed demo)
# =============================================================================
log "migrate + seed"
docker compose -f "$COMPOSE_FILE" exec -T app php artisan migrate --force
docker compose -f "$COMPOSE_FILE" exec -T app php artisan db:seed --class=ProjectSeeder --force || true
ok "DB migrada y seedeada"

# =============================================================================
# 5. Proxy host en NPM vía API (idempotente: si ya existe el dominio, no duplica)
# =============================================================================
log "configurando NPM (proxy host + Basic Auth)..."

TOKEN="$(curl -s -X POST "$NPM_API/api/tokens" -H "Content-Type: application/json" \
    -d "{\"identity\":\"$NPM_ADMIN_EMAIL\",\"secret\":\"$NPM_ADMIN_PASSWORD\"}" \
    | grep -oE '"token":"[^"]+"' | head -1 | cut -d'"' -f4)"
[ -n "$TOKEN" ] || die "no se pudo autenticar contra NPM API (revisá NPM_ADMIN_EMAIL/PASSWORD)"

EXISTS="$(curl -s "$NPM_API/api/nginx/proxy-hosts" -H "Authorization: Bearer $TOKEN" \
    | grep -oE "\"domain_names\":\[\"$STAGING_DOMAIN\"\]" | head -1)"

if [ -n "$EXISTS" ]; then
    ok "proxy host de $STAGING_DOMAIN ya existe en NPM (no se duplica)"
else
    # 5a. Access List con Basic Auth (solo auth, sin clients → satisfy_any)
    BASIC_PW="$(openssl rand -base64 12)"
    AL_RESP="$(curl -s -X POST "$NPM_API/api/nginx/access-lists" -H "Authorization: Bearer $TOKEN" \
        -H "Content-Type: application/json" \
        -d "{\"name\":\"staging-portafolio\",\"satisfy_any\":true,\"pass_auth\":false,\"items\":[{\"username\":\"jose\",\"password\":\"$BASIC_PW\"}],\"clients\":[]}")"
    AL_ID="$(echo "$AL_RESP" | grep -oE '"id":[0-9]+' | head -1 | cut -d: -f2)"
    [ -n "$AL_ID" ] || die "no se pudo crear la Access List en NPM"
    ok "Access List (Basic Auth) creada — user: jose / pass: $BASIC_PW  (GUARDALA en el .env del hub)"

    # 5b. Proxy host (HTTP, sin SSL todavía)
    PH_RESP="$(curl -s -X POST "$NPM_API/api/nginx/proxy-hosts" -H "Authorization: Bearer $TOKEN" \
        -H "Content-Type: application/json" \
        -d "{\"domain_names\":[\"$STAGING_DOMAIN\"],\"forward_scheme\":\"http\",\"forward_host\":\"portfolio_staging_app\",\"forward_port\":80,\"block_exploits\":true,\"allow_websocket_upgrade\":true,\"caching_enabled\":false,\"access_list_id\":$AL_ID,\"certificate_id\":0,\"ssl_forced\":false,\"http2_support\":false,\"hsts_enabled\":false,\"meta\":{},\"locations\":[]}")"
    PH_ID="$(echo "$PH_RESP" | grep -oE '"id":[0-9]+' | head -1 | cut -d: -f2)"
    [ -n "$PH_ID" ] || die "no se pudo crear el proxy host"
    ok "proxy host creado (id $PH_ID)"

    # 5c. Cert LE (NPM 2.14: meta vacío, usa el email de la cuenta admin)
    log "emitiendo cert Let's Encrypt (puede tardar ~30s)..."
    CERT_RESP="$(curl -s -X POST "$NPM_API/api/nginx/certificates" -H "Authorization: Bearer $TOKEN" \
        -H "Content-Type: application/json" \
        -d "{\"provider\":\"letsencrypt\",\"domain_names\":[\"$STAGING_DOMAIN\"],\"meta\":{}}" --max-time 120)"
    CERT_ID="$(echo "$CERT_RESP" | grep -oE '"id":[0-9]+' | head -1 | cut -d: -f2)"
    if [ -n "$CERT_ID" ]; then
        # 5d. Asociar cert + Force SSL
        curl -s -X PUT "$NPM_API/api/nginx/proxy-hosts/$PH_ID" -H "Authorization: Bearer $TOKEN" \
            -H "Content-Type: application/json" \
            -d "{\"certificate_id\":$CERT_ID,\"ssl_forced\":true,\"http2_support\":true,\"hsts_enabled\":true}" >/dev/null
        ok "cert LE emitido (id $CERT_ID) + Force SSL activado"
    else
        warn "no se pudo emitir el cert por API. Hacelo en la UI de NPM (Edit → SSL → Request new cert)."
        warn "Causa común: Cloudflare en orange (poné el registro en grey/DNS-only)."
    fi
fi

# =============================================================================
# Resumen
# =============================================================================
echo ""
log "STAGING montado:"
ok  "URL:      https://$STAGING_DOMAIN  (Basic Auth + noindex)"
ok  "código:   $STAGING_PATH ($BRANCH)"
ok  "stack:    docker compose -f $COMPOSE_FILE"
echo ""
warn "Pendiente manual: cargar el GitHub Secret DEPLOY_STAGING_PATH=$STAGING_PATH"
warn "                  y guardar las credenciales del Basic Auth en el .env del hub."
