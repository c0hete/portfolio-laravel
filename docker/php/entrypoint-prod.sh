#!/bin/sh
# portfolio-laravel — entrypoint de producción (Apache).
# Idempotente: corre en cada arranque del container.
set -e

# Permisos de storage/cache (por si un volumen se monta encima en runtime).
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache 2>/dev/null || true
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache 2>/dev/null || true

# Caches de producción: config + route (NUNCA view — patrón del hub, rompe en algunos setups).
# Se generan en runtime con el .env real ya presente. Limpio antes para evitar caché viejo.
php artisan config:clear >/dev/null 2>&1 || true
php artisan config:cache >/dev/null 2>&1 || true
php artisan route:cache  >/dev/null 2>&1 || true

# Arranca Apache en foreground (comando por defecto de la imagen php:apache)
exec apache2-foreground
