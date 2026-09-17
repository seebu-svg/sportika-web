#!/usr/bin/env bash
# ─────────────────────────────────────────────────────────────────────────────
# Sportika — Hostinger deployment script
# ─────────────────────────────────────────────────────────────────────────────
# Run this ONCE after uploading all files to Hostinger via FTP / Git.
# It installs Composer deps, generates keys, migrates and seeds the database.
# ─────────────────────────────────────────────────────────────────────────────
set -euo pipefail

echo "▸ Installing Composer dependencies (production)…"
composer install --no-dev --optimize-autoloader --no-interaction

echo "▸ Generating application key…"
php artisan key:generate --force

echo "▸ Creating storage link…"
php artisan storage:link --force 2>/dev/null || true

echo "▸ Clearing and caching configuration…"
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "▸ Running migrations…"
php artisan migrate --force

echo "▸ Seeding database (first deploy only — comment out on updates)…"
php artisan db:seed --force

echo "▸ Setting permissions…"
chmod -R 775 storage bootstrap/cache
chmod -R 775 public/storage 2>/dev/null || true

echo ""
echo "✅  Deployment complete!"
echo ""
echo "   Admin panel : https://sportika.agency/admin"
echo "   Login       : admin@sportika.test / password"
echo ""
echo "   ⚠  Change the admin password immediately after first login."
