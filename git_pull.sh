#!/bin/bash

# Set variables
APP_DIR="/var/www/richad/prasthan_yatnam"
USER="www-data"
GROUP="www-data"
STORAGE_DIR="$APP_DIR/storage"
PUBLIC_STORAGE_DIR="$APP_DIR/public/storage"
IMAGES_DIR="$APP_DIR/public/storage/images/discourses"

echo "🔁 Changing to project directory..."
cd "$APP_DIR" || { echo "❌ Failed to cd to $APP_DIR"; exit 1; }

echo "📥 Pulling latest changes from Git..."
git pull origin main || { echo "❌ Git pull failed"; exit 1; }

echo "📦 Installing dependencies..."
composer install --no-interaction --prefer-dist --optimize-autoloader

echo "⚙️ Running migrations..."
php artisan migrate --force

echo "🧹 Clearing Laravel caches..."
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

echo "🔄 Updating storage link..."
php artisan storage:link --force 2>/dev/null || true

echo "🔐 Setting permissions..."
sudo chown -R $USER:$GROUP "$APP_DIR"
sudo find "$STORAGE_DIR" "$APP_DIR/bootstrap/cache" -type d -exec chmod 775 {} \;
sudo find "$STORAGE_DIR" "$APP_DIR/bootstrap/cache" -type f -exec chmod 664 {} \;

# Ensure public storage directories exist
sudo mkdir -p "$IMAGES_DIR"

# Set permissions for public storage directories
sudo chown -R $USER:$GROUP "$PUBLIC_STORAGE_DIR"
sudo chmod -R 775 "$PUBLIC_STORAGE_DIR"

echo "✅ Project updated and permissions set."
