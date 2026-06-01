#!/bin/sh
# portfolio-laravel — entrypoint de producción (Apache).
# Idempotente: corre en cada arranque del container.
set -e

# Permisos de storage/cache (por si un volumen se monta encima en runtime).
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache 2>/dev/null || true
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache 2>/dev/null || true

# Caches de producción: config + route (NUNCA view — patrón del hub, rompe en algunos setups).
# Se generan en runtime con el .env real ya presente. El entrypoint es la ÚNICA
# fuente de verdad del cacheo (corre en cada arranque con el código final), por
# eso el pipeline ya NO cachea — evita el gotcha de rutas nuevas que quedaban en
# 404 por caché generado a destiempo durante el 'up --build'.
# CLEAR de route+config ANTES de cachear: descarta el caché viejo de la imagen
# anterior aunque el archivo siga ahí. Sin esto, una ruta nueva podía no aparecer.
php artisan route:clear  >/dev/null 2>&1 || true
php artisan config:clear >/dev/null 2>&1 || true
php artisan config:cache >/dev/null 2>&1 || true
php artisan route:cache  >/dev/null 2>&1 || true

# Arranca Apache en foreground (comando por defecto de la imagen php:apache)
exec apache2-foreground
