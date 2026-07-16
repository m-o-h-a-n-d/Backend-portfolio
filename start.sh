#!/usr/bin/env sh
set -e

echo "=============================="
echo "🚀 Starting Laravel on Railway"
echo "=============================="

cd /var/www

echo "🔐 Fixing permissions..."
chmod -R 775 storage bootstrap/cache || true

echo "🧹 Clearing & rebuilding caches..."
php artisan optimize:clear || true

# Cache for production performance
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

# If you use storage/public
php artisan storage:link || true

echo "🛢️ Running migrations (safe)..."
php artisan migrate --force --no-interaction || true

echo "✅ Bootstrapping complete"
echo "🌐 Starting PHP server on port: ${PORT:-8080}"

exec php -S 0.0.0.0:${PORT:-8080} -t public
