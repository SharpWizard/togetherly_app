# Togetherly — Laravel app for Railway (and any Docker host)
FROM php:8.2-cli

# System dependencies + PHP extensions Laravel needs
RUN apt-get update && apt-get install -y \
        git unzip libzip-dev libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo_mysql mbstring zip gd bcmath exif \
    && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Ensure PHP populates $_ENV from the container environment so Laravel's env()
# can read platform-injected variables (APP_KEY, DB_*, etc.) under `artisan serve`.
RUN echo "variables_order=EGPCS" > /usr/local/etc/php/conf.d/zz-railway.ini

WORKDIR /app

# Install PHP dependencies first (better build caching)
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts

# Copy the rest of the app
COPY . .

# Make sure a .env exists for artisan during build (runtime env vars override these)
RUN cp -n .env.example .env || true \
    && composer dump-autoload --optimize \
    && php artisan storage:link || true

# Storage needs to be writable
RUN chmod -R 775 storage bootstrap/cache

# Remove the build-time .env so the running container uses ONLY the platform's
# injected environment variables (APP_KEY, DB_*, etc.). A stale .env with an
# empty APP_KEY would otherwise cause "No application encryption key" errors.
RUN rm -f .env

# Railway injects $PORT at runtime. Clear any cached config, migrate + seed
# (idempotent), then serve.
CMD php artisan config:clear \
    && php artisan migrate --force --seed \
    && php artisan serve --host 0.0.0.0 --port ${PORT:-8080}
