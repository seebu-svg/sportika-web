# Sportika — Deployment Guide

A Laravel 12 + Filament 3 player-management web application, optimised for Hostinger shared hosting.

## Quick Start (Local Development)

```bash
# 1. Install PHP dependencies
composer install

# 2. Install JS dependencies & build assets
npm install && npm run build

# 3. Set up environment
cp .env.example .env
php artisan key:generate

# 4. Create & seed the database (SQLite for local)
touch database/database.sqlite
php artisan migrate:fresh --seed

# 5. Serve
php artisan serve
```

- **Public site:** http://localhost:8000
- **Admin panel:** http://localhost:8000/admin
- **Admin login:** `admin@sportika.test` / `password`

---

## Hostinger Deployment

### Prerequisites

- Hostinger plan with PHP 8.2+ and MySQL
- SSH access (or File Manager / FTP)
- Composer installed on the server (or upload `vendor/` directly)

### Step-by-step

#### 1. Upload project files

Upload the entire project to your Hostinger account. Recommended structure:

```
public_html/
├── app/
├── bootstrap/
├── config/
├── database/
├── public/          ← web root
├── resources/
├── routes/
├── storage/
├── vendor/
├── artisan
├── composer.json
├── composer.lock
└── .env
```

**Option A — Full project outside `public_html`:**
Place all files in `~/` (home directory), then copy `deploy/hostinger-root-htaccess` to `public_html/.htaccess` and edit it to point to the project's `public/` folder.

**Option B — Directly in `public_html`:**
Upload everything into `public_html/`, ensuring `public/index.php` is accessible at `public_html/public/index.php`.

#### 2. Configure environment

```bash
cp .env.hostinger .env
```

Edit `.env` with your Hostinger values:
- `APP_URL` — your domain (e.g. `https://sportika.com`)
- `DB_HOST`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` — from hPanel → MySQL Databases
- `MAIL_*` — from hPanel → Email Accounts (SMTP settings)

#### 3. Create MySQL database

In hPanel:
1. Go to **Databases → MySQL Databases**
2. Create a new database (note the name, username, password)
3. The database will be prefixed, e.g. `u123456789_sportika`

#### 4. Run deployment script

```bash
chmod +x deploy/deploy.sh
bash deploy/deploy.sh
```

Or run manually:

```bash
composer install --no-dev --optimize-autoloader
php artisan key:generate --force
php artisan storage:link --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan migrate --force
php artisan db:seed --force
```

#### 5. Set file permissions

```bash
chmod -R 775 storage bootstrap/cache
chmod -R 775 public/storage
```

#### 6. (Optional) PHP configuration

Upload `deploy/hostinger-user-ini` as `public_html/.user.ini` or configure via hPanel → PHP Config:
- PHP version: **8.2 or higher**
- `upload_max_filesize`: 20M
- `memory_limit`: 256M
- Enable extensions: `pdo_mysql`, `mbstring`, `curl`, `gd`, `zip`, `intl`, `bcmath`

---

## Admin Credentials (Default)

| Field    | Value                  |
|----------|------------------------|
| URL      | `/admin`               |
| Email    | `admin@sportika.test`  |
| Password | `password`             |

**Change the password immediately after first login.**

---

## Project Structure

### Public Frontend
| Page              | Route               | Description                           |
|-------------------|---------------------|---------------------------------------|
| Home              | `/`                 | Hero, featured players, latest news   |
| About             | `/about`            | About page with editable content      |
| Players Directory | `/players`          | Filterable player listing             |
| Player Portfolio  | `/players/{slug}`   | Full player profile with stats        |
| News & Blogs      | `/news`             | Blog listing with category filters    |
| Blog Post         | `/news/{slug}`      | Single post with rich-text content    |
| Contact Us        | `/contact`          | Contact form with honeypot spam trap  |

### Admin Panel (Filament)
| Resource          | Description                              |
|-------------------|------------------------------------------|
| Players           | Full CRUD with photo upload, stats, bio  |
| Posts             | Rich-text editor, categories, scheduling |
| Categories        | Blog category management                 |
| Messages          | Inbox for contact form submissions       |
| Site Settings     | Editable homepage, about, contact info   |
| Dashboard Widget  | Stats overview (players, posts, messages)|

---

## Updating After Code Changes

```bash
# Pull latest code
git pull origin main

# Update dependencies
composer install --no-dev --optimize-autoloader
npm install && npm run build

# Clear caches
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run new migrations (if any)
php artisan migrate --force
```

---

## Troubleshooting

| Issue | Solution |
|-------|----------|
| 500 Internal Server Error | Check `storage/logs/laravel.log`. Ensure `storage/` and `bootstrap/cache/` are writable (775). |
| Admin panel shows 403 | Ensure the user has `is_admin = true` in the database. |
| Images not loading | Run `php artisan storage:link`. Check `FILESYSTEM_DISK=public` in `.env`. |
| CSS/JS not loading | Run `npm run build` and ensure `public/build/` exists. |
| Contact form 419 | CSRF token issue — clear browser cache and ensure session config is correct. |
| Database connection refused | Verify MySQL credentials in `.env`. Check that the database user has proper permissions. |

---

## Tech Stack

- **Framework:** Laravel 12
- **Admin Panel:** Filament 3
- **CSS:** Tailwind CSS v4
- **JS:** Alpine.js
- **Fonts:** Inter Variable, Bebas Neue
- **Database:** MySQL 8 (production) / SQLite (local dev)
- **Build Tool:** Vite 6
