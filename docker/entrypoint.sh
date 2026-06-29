#!/usr/bin/env bash
set -e

if [ ! -f .env ]; then
    cp .env.example .env
fi

composer install --no-interaction --prefer-dist

if ! grep -q '^APP_KEY=base64:' .env; then
    php artisan key:generate --force
fi

if [ -f package.json ]; then
    npm install --ignore-scripts
    npm run build
fi

until mysqladmin ping -h"${DB_HOST:-mysql}" -P"${DB_PORT:-3306}" -u"${DB_USERNAME:-root}" --silent; do
    sleep 2
done

CACHE_STORE=file php artisan optimize:clear
php artisan filament:upgrade
php artisan storage:link || true
php artisan migrate --seed --force

exec "$@"
