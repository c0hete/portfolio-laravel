# deploy/ — montar entornos del portafolio

Scripts y compose para desplegar el portafolio. El **pipeline** (`.github/workflows/ci.yml`)
hace los deploys del día a día; estos scripts hacen el **montaje inicial** de un entorno nuevo
(lo que el pipeline NO hace).

## Archivos

| Archivo | Qué es |
|---|---|
| `../docker-compose.prod.yml` | Stack de producción (alvaradomazzei.cl) |
| `../docker-compose.staging.yml` | Stack de staging (staging.alvaradomazzei.cl) |
| `setup-staging.sh` | Monta el entorno de **staging** de cero, idempotente |

---

## 🚀 Levantar STAGING "de una patada"

### Antes de correr — tené esto listo (prerequisitos)

1. **DNS** — en Cloudflare, registro `A` apuntando al hub:
   ```
   staging.alvaradomazzei.cl  →  <IP del hub>   ·   Proxy: DNS only (gris)
   ```
   (Gris = obligatorio para que Let's Encrypt pueda emitir el cert.)

2. **Credenciales del NPM admin** — email + password (las tenés en el `.env` del hub,
   bloque `# === NPM ===`). Se pasan como variables, no se hardcodean.

3. **Estás en el hub** (el script es bash del server, no de tu PC Windows):
   ```bash
   ssh hub
   ```

### Correr

```bash
# opción A: clonar primero y correr desde el repo
git clone -b develop https://github.com/c0hete/portfolio-laravel.git ~/sites/portafolio-staging
cd ~/sites/portafolio-staging/deploy

NPM_ADMIN_EMAIL=jose@alvaradomazzei.cl \
NPM_ADMIN_PASSWORD='<pass del NPM del hub>' \
./setup-staging.sh
```

Probar primero sin tocar nada:
```bash
NPM_ADMIN_EMAIL=... NPM_ADMIN_PASSWORD=... ./setup-staging.sh --dry-run
```

### Qué hace el script (en orden, idempotente)

1. Valida prerequisitos (docker, DNS resuelve, red nginx_network, creds NPM) → falla claro si falta algo.
2. Clona el repo (o hace fetch+checkout si ya existe).
3. Genera el `.env` de staging (APP_ENV=staging, APP_KEY + DB password nuevos). No pisa uno existente.
4. `docker compose up -d --build` del stack staging.
5. `migrate` + `seed` (proyectos demo).
6. NPM vía API: Access List (Basic Auth) + proxy host + cert Let's Encrypt + Force SSL.

### Después del script — 2 pasos manuales que quedan

- **GitHub Secret** `DEPLOY_STAGING_PATH=/home/master/sites/portafolio-staging`
  (para que el pipeline despliegue automático en push a `develop`).
- **Guardar las credenciales del Basic Auth** (el script las imprime) en el `.env` del hub.

---

## Qué NO automatiza el script (y por qué)

- **DNS** → requiere acceso a Cloudflare (decisión humana / token). Prerequisito manual.
- **GitHub Secret** → vive en GitHub, no en el server. Manual.
- **Guardar secretos generados** → el script los imprime; vos decidís dónde centralizarlos.

Esto es a propósito: un `setup.sh` automatiza lo *mecánico del server*; lo que toca
credenciales/DNS/decisiones queda como prerequisito documentado. Mismo patrón que
`infra-core/provisioning/setup.sh` del negocio de hosting.

## Producción

Prod ya está montado (`~/sites/portafolio`). Su deploy lo maneja el pipeline (push a `main`).
Para remontar prod de cero se podría clonar este patrón en un `setup-prod.sh` — no existe
todavía porque prod no se ha necesitado remontar. El runbook manual está en
`documentacion/ANALISIS_DEPLOY_2026-05-30.md` y `documentacion/STAGING.md`.
