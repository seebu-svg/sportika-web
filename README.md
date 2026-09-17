# Sportika — Player Management Agency

A modern web application for a player management agency, built with **Laravel 12** and **Filament 3**. Features a public-facing website with player portfolios, news blog, and contact system, plus a full-featured admin panel for content management.

![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![Filament](https://img.shields.io/badge/Filament-3-F46A35?style=for-the-badge)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-4-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)

## Features

### Public Website
- **Home Page** — Hero section, featured players, latest news
- **About Page** — Editable content managed from admin panel
- **Team Page** — Team members with photos, bios, social links
- **Players Directory** — Filterable listing by position, nationality, search
- **Player Portfolio** — Individual player pages with photo, stats, bio, social links
- **Tournaments** — Tournament listing with fixtures, results, galleries
- **Champions Gallery** — Photo/video gallery with albums
- **Sponsors & Partners** — Tiered sponsor showcase (title, gold, silver, bronze, partner)
- **News** — Official updates, results, announcements
- **Blog** — Insights, interviews, opinion pieces with categories
- **Podcast** — Episode listing with streaming links (YouTube, Spotify, Apple)
- **Membership** — Player registration and brand partnership applications
- **Contact Form** — Honeypot spam protection, email notifications to admin
- **FAQ Page** — Frequently asked questions
- **Legal Pages** — Privacy policy and terms of service

### Admin Panel (Filament)
- **Dashboard** — Stats overview (players, posts, unread messages)
- **Players CRUD** — Full management with photo upload, career stats, honours, social links
- **News Posts CRUD** — Rich-text editor, categories, scheduling, featured flag, SEO fields
- **Blog Posts CRUD** — Separate blog section with tags, authors, cover images
- **Categories** — Blog/news category management with post counts
- **Tournaments CRUD** — Fixtures, results, galleries, status tracking
- **Gallery Items** — Photo/video upload with albums, featured items
- **Sponsors CRUD** — Tiered sponsorship management with logos
- **Team Members CRUD** — Staff profiles with photos, bios, social links
- **Podcast Episodes** — Episode management with streaming platform links
- **Player Applications** — Approval workflow with auto-player creation
- **Brand Applications** — Partnership/sponsorship inquiry management
- **Podcast Applications** — Guest application review and shortlisting
- **Messages Inbox** — View/read/reply to contact form submissions
- **Site Settings** — Editable homepage content, about page, contact details, social URLs

## Tech Stack

| Component | Technology |
|-----------|------------|
| Backend | Laravel 12 (PHP 8.2+) |
| Admin Panel | Filament 3 |
| CSS Framework | Tailwind CSS v4 |
| JavaScript | Alpine.js |
| Fonts | Inter Variable, Bebas Neue |
| Build Tool | Vite 6 |
| Database | MySQL 8 (production) / SQLite (local dev) |
| Mail | SMTP (Hostinger) / Log (dev) |

## Requirements

- PHP 8.2+ with extensions: `pdo_mysql`, `mbstring`, `xml`, `curl`, `gd`, `zip`, `intl`, `bcmath`
- Composer 2.x
- Node.js 18+ & npm
- MySQL 8.0+ (production) or SQLite (development)

## Installation

### Local Development

```bash
# Clone the repository
git clone https://github.com/seebu-svg/sportika-web.git
cd sportika-web

# Install PHP dependencies
composer install

# Install JS dependencies and build assets
npm install && npm run build

# Set up environment
cp .env.example .env
php artisan key:generate

# Create database (SQLite for local dev)
touch database/database.sqlite

# Run migrations and seed
php artisan migrate:fresh --seed

# Start development server
php artisan serve
```

### Access the Application

| Page | URL |
|------|-----|
| Public Site | http://localhost:8000 |
| Admin Panel | http://localhost:8000/admin |
| Admin Login | `admin@sportika.test` / `password` |

> **Important:** Change the admin password immediately after first login.

## Seeded Data

The seeder creates sample content for testing:

- **1 Admin User** — `admin@sportika.test` / `password`
- **10 Players** — 4 featured, with unique SVG portraits
- **6 Blog Posts** — across 5 categories
- **5 Categories** — Transfers, Match Reports, Training, Club News, Interviews
- **9 Messages** — 6 unread, 3 read
- **Site Settings** — Fully populated with sample content

## Project Structure

```
sportika-web/
├── app/
│   ├── Filament/           # Admin panel resources & pages
│   │   ├── Pages/          # Site settings page
│   │   ├── Resources/      # Player, Post, Category, Message CRUD
│   │   └── Widgets/        # Dashboard stats
│   ├── Http/
│   │   ├── Controllers/    # Public frontend controllers
│   │   └── Requests/       # Form validation
│   ├── Mail/               # Contact message email
│   └── Models/             # Eloquent models
├── database/
│   ├── factories/          # Model factories
│   ├── migrations/         # Database schema
│   └── seeders/            # Sample data
├── deploy/                 # Hostinger deployment assets
├── resources/
│   ├── css/                # Tailwind + custom styles
│   ├── js/                 # Alpine.js setup
│   └── views/              # Blade templates
│       ├── components/     # Reusable UI components
│       ├── front/          # Public pages
│       ├── layouts/        # Master layout
│       └── mail/           # Email templates
├── routes/                 # Web routes
└── .env.hostinger          # Production env template
```

## Public Routes

| Route | Controller | Description |
|-------|------------|-------------|
| `/` | `HomeController` | Homepage with hero, featured players, latest posts |
| `/about` | `AboutController` | About page with editable content |
| `/team` | `TeamController@index` | Team members listing |
| `/team/{slug}` | `TeamController@show` | Individual team member profile |
| `/players` | `PlayerController@index` | Filterable player directory |
| `/players/{slug}` | `PlayerController@show` | Individual player portfolio |
| `/tournaments` | `TournamentController@index` | Tournament listing |
| `/tournaments/{slug}` | `TournamentController@show` | Tournament detail with fixtures/results |
| `/gallery` | `GalleryController` | Champions gallery with photos/videos |
| `/sponsors` | `SponsorController` | Sponsors and partners showcase |
| `/news` | `PostController@index` | News listing (official updates) |
| `/news/{slug}` | `PostController@show` | Single news post |
| `/blogs` | `BlogController@index` | Blog listing (insights, interviews) |
| `/blogs/{slug}` | `BlogController@show` | Single blog post |
| `/podcast` | `PodcastController` | Podcast episodes listing |
| `/podcast/apply` | `PodcastApplyController` | Podcast guest application form |
| `/join/player` | `MembershipController` | Player registration application |
| `/join/brand` | `MembershipController` | Brand partnership application |
| `/contact` | `ContactController` | Contact form with honeypot |
| `/faq` | `FaqController` | Frequently asked questions |
| `/privacy-policy` | `LegalController` | Privacy policy page |
| `/terms-of-service` | `LegalController` | Terms of service page |

## Hostinger Deployment

See [DEPLOYMENT.md](DEPLOYMENT.md) for complete instructions. Quick summary:

1. Upload project to Hostinger (FTP or Git)
2. Copy `.env.hostinger` to `.env` and configure MySQL + SMTP
3. Run `bash deploy/deploy.sh`
4. Set permissions: `chmod -R 775 storage bootstrap/cache`

### Deployment Assets

| File | Purpose |
|------|---------|
| `.env.hostinger` | Production environment template |
| `deploy/deploy.sh` | One-command deployment script |
| `deploy/hostinger-root-htaccess` | Root `.htaccess` for Apache |
| `deploy/hostinger-user-ini` | PHP configuration overrides |

## Configuration

### Environment Variables

Key settings in `.env`:

```env
APP_NAME=Sportika
APP_URL=https://yourdomain.com

# Database (MySQL for production)
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password

# Mail (Hostinger SMTP)
MAIL_MAILER=smtp
MAIL_HOST=smtp.hostinger.com
MAIL_PORT=465
MAIL_USERNAME=noreply@yourdomain.com
MAIL_PASSWORD=your_password
```

### Admin Panel

The Filament admin panel is accessible at `/admin`. Only users with `is_admin = true` can access it.

To create a new admin user:

```bash
php artisan tinker
```

```php
\App\Models\User::create([
    'name' => 'Your Name',
    'email' => 'your@email.com',
    'password' => \Illuminate\Support\Facades\Hash::make('your-password'),
    'is_admin' => true,
]);
```

## Building for Production

```bash
# Build production assets
npm run build

# Cache configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Optimize autoloader
composer install --no-dev --optimize-autoloader
```

## Troubleshooting

| Issue | Solution |
|-------|----------|
| 500 Internal Server Error | Check `storage/logs/laravel.log`. Ensure `storage/` and `bootstrap/cache/` are writable (775). |
| Admin panel shows 403 | Ensure the user has `is_admin = true` in the database. |
| Images not loading | Run `php artisan storage:link`. Check `FILESYSTEM_DISK=public` in `.env`. |
| CSS/JS not loading | Run `npm run build` and ensure `public/build/` exists. |
| Contact form 419 | CSRF token issue — clear browser cache and ensure session config is correct. |
| Database connection refused | Verify MySQL credentials in `.env`. |

## License

This project is proprietary software created for Sportika Player Management Agency.

## Credits

- **Framework:** [Laravel](https://laravel.com)
- **Admin Panel:** [Filament](https://filamentphp.com)
- **CSS:** [Tailwind CSS](https://tailwindcss.com)
- **Fonts:** [Inter](https://rsms.me/inter/) by Rasmus Andersson, [Bebas Neue](https://github.com/dharmatype/Bebas-Neue) by Dharma Type
