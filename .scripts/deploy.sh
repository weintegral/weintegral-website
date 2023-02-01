#!/bin/bash
set -e

echo "Deployment started ..."

# Enter maintenance mode or return true
# if already is in maintenance mode
(php artisan down --message 'The app is being (quickly!) updated. Please try again in a minute.') || true

# Pull the latest version of the app
git fetch origin main
git reset --hard origin/main
git pull origin main

# Compile npm assets
npm install && npm run build

# Install composer dependencies
COMPOSER_ALLOW_SUPERUSER=1 composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# Clear the old cache
php artisan clear-compiled
php artisan route:clear
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Recreate cache
php artisan config:cache
php artisan optimize

# Run database migrations
php artisan migrate --force

# Exit maintenance mode
php artisan up

echo "Deployment finished!"
