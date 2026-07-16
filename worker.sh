#!/usr/bin/env sh
set -e

echo "=============================="
echo "👷 Starting Queue Worker"
echo "=============================="

cd /var/www

chmod -R 775 storage bootstrap/cache || true

# مهم جدًا عشان ياخد ENV الجديد
php artisan optimize:clear || true
php artisan queue:restart || true

exec php artisan queue:work --sleep=0 --tries=1 --timeout=180
