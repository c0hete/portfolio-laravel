# alvaradomazzei.cl — Portafolio personal

Portafolio profesional de **José Alvarado Mazzei** — Full Stack Developer & DevSecOps Engineer.
No es un sitio de plantilla: la seguridad es una característica visible del producto, no un detalle de
configuración. El propio portafolio instrumenta y muestra su postura defensiva en vivo.

🔗 **En producción:** [alvaradomazzei.cl](https://alvaradomazzei.cl)

---

## Qué tiene de distinto

La mayoría de los portafolios son una landing estática. Este es una aplicación Laravel que **practica
lo que predica** sobre DevSecOps:

- **Telemetría de amenazas en vivo.** Un middleware (`BlockedProbeLogger`) detecta y clasifica los
  sondeos maliciosos contra el dominio (`.env`, `.git`, `wp-login`, `.aws`…), los persiste y los
  expone en la sección `/seguridad` como métricas reales — no decorativas.
- **Cabeceras de seguridad endurecidas** (`SecureHeadersMiddleware`): CSP estricta, HSTS con `preload`,
  `X-Frame-Options: DENY`, `Permissions-Policy`, y eliminación de `X-Powered-By` para no divulgar el
  stack. La CSP se relaja **solo** en entorno local (para el HMR de Vite); en producción queda intacta.
- **`/.well-known/security.txt`** (RFC 9116), `robots.txt` y `sitemap.xml` generados por la aplicación.
- **Analítica self-hosted** (Umami) en vez de un tercero — el token de la API nunca llega al navegador,
  se consume server-side con caché (`UmamiStats`).
- **Degradación segura:** los widgets de telemetría caen a vacío si la DB falla, nunca rompen la página.

---

## Stack

| Capa | Tecnología |
|------|-----------|
| Backend | **Laravel 13** · **PHP 8.4** |
| Frontend | **Blade** + componentes · **Tailwind CSS v4** · **Vite 8** (sin Livewire/Inertia) |
| Datos | PostgreSQL en producción · SQLite en local |
| Infra | **Docker** (multi-stage `Dockerfile.prod`) detrás de un reverse proxy |
| CI/CD | **GitHub Actions** — quality gates, SCA (`composer/npm audit`), escaneo de secretos, deploy automático |
| Analítica | Umami (self-hosted) |

---

## Estructura

Secciones (rutas en `routes/web.php`), todas vistas Blade en `resources/views/sections/`:

| Ruta | Contenido |
|------|-----------|
| `/` | Identidad / landing |
| `/sobre-mi` | Perfil, experiencia, educación, certificaciones |
| `/stack` | Ecosistema técnico |
| `/proyectos` | Proyectos (modelo `Project`, desde DB) |
| `/seguridad` | Telemetría de amenazas en vivo + analítica |
| `/contacto` | Formulario de contacto |

Piezas de seguridad:
- `app/Http/Middleware/SecureHeadersMiddleware.php` — cabeceras + CSP.
- `app/Http/Middleware/BlockedProbeLogger.php` — detección y clasificación de sondeos.
- `app/Services/{ThreatStats,UmamiStats,BannedIps}.php` — lectura cacheada de la telemetría.

---

## Setup local

Requisitos: PHP 8.4, Composer, Node 20+.

```bash
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate --seed
npm install && npm run dev      # o `composer dev` (server + queue + vite juntos)
php artisan serve --host=127.0.0.1 --port=8000
```

> **Nota (Windows):** el dev server de Vite queda fijado a `127.0.0.1` en `vite.config.js`. Sin eso,
> en Windows escucha en `[::1]` (IPv6) y el navegador no carga los assets. No quitar.

La app queda en `http://127.0.0.1:8000`; Vite sirve los assets con HMR.

---

## Seguridad

Este repo aplica controles **shift-left** acordes a un proyecto de portafolio público:

- `.gitignore` y `.dockerignore` protegen `.env` y secretos; el `.env` real nunca se versiona ni entra
  en el build context.
- CI con escaneo de secretos (gitleaks) y análisis de dependencias (SCA) como gates.
- Configuración endurecida por defecto: `APP_DEBUG=false` en producción, rutas de depuración cerradas,
  métodos HTTP peligrosos deshabilitados.

¿Encontraste algo? Ver [`/.well-known/security.txt`](https://alvaradomazzei.cl/.well-known/security.txt).

---

## Licencia

Código bajo licencia MIT. El contenido (textos, imágenes, identidad visual) es propiedad del autor.
