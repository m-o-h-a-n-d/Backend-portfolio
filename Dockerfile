# ---- Base image with PHP 8.4 ----
FROM php:8.4-cli

# System deps + PHP extensions
RUN apt-get update && apt-get install -y \
    git unzip curl libzip-dev libpng-dev \
    && docker-php-ext-install pdo pdo_mysql zip \
    && rm -rf /var/lib/apt/lists/*

# Install Node.js (for npm build if you use Vite)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get update && apt-get install -y nodejs \
    && node -v && npm -v

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# App dir
WORKDIR /var/www

# Copy project files
COPY . .

# Install PHP deps
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Backend API only — no Vite build here
# RUN if [ -f package.json ]; then npm ci && npm run build; fi

# Permissions for Laravel
RUN chmod -R 775 storage bootstrap/cache || true

# Expose port (Railway uses $PORT)
EXPOSE 8080

# Start script
# Start scripts
RUN chmod +x /var/www/start.sh /var/www/worker.sh || true

CMD ["sh", "/var/www/start.sh"]


