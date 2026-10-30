# Bakuna Tracker - Purok Buenviaje (`LabActivity9-Buenviaje`)

Community Immunization & Vaccination Schedule Tracker built for **Nurse Marites Abellana's Barangay Matina Crossing Health Center (Purok Buenviaje)** using **Laravel**, **Blade Views & Components**, **Tailwind CSS v3**, **PostCSS**, **Vite**, and **SQLite**.

---

## Personalization Summary

| Requirement | Configured Value |
| :--- | :--- |
| **Application Title** | `Bakuna Tracker - Purok Buenviaje` |
| **Health Center** | Barangay Matina Crossing Health Center (Nurse Marites Abellana, RN) |
| **Logged-in Health Worker (Navbar)** | `Hi, Brian` (Brian Vincent Alfred D. Buenviaje — configured in `DatabaseSeeder.php`) |
| **Seeded User Email** | `nurse.buenviaje@bakuna.test` |
| **Seeded User Password** | `bakuna2026` |
| **Address / City** | `Davao City` |
| **Seeded Vaccines (8 total entries)** | `BCG`, `Pentavalent`, `OPV`, `MMR`, `Anti-Flu`, `PCV-13 (Pneumococcal)`, `Hepatitis B` |
| **2026 Birthday Entry** | `2026-10-30` (Sanitized 2026 birthday schedule entry — `Brian Buenviaje` — `BCG` in `Purok Buenviaje, Davao City`) |

---

## Login Credentials

Use the following seeded credentials to sign in at `/login`:

- **Email:** `nurse.buenviaje@bakuna.test`
- **Password:** `bakuna2026`

---

## Setup & Installation Commands

Run these commands from the project root (`LabActivity9-Buenviaje`):

```bash
# 1. Install PHP dependencies
composer install

# 2. Copy environment configuration and generate app key
cp .env.example .env
php artisan key:generate

# 3. Ensure SQLite database file exists and run fresh migrations with seeders
touch database/database.sqlite
php artisan migrate:fresh --seed

# 4. Install Node dependencies (Tailwind CSS v3, PostCSS, Autoprefixer, Vite)
npm install

# 5. Build production frontend assets (generates public/build/manifest.json)
npm run build

# 6. Start the local Laravel development server
php artisan serve
```

For hot-module replacement (HMR) during local development, run Vite in a second terminal:

```bash
npm run dev
```

---

## Technical Architecture (Topics 1–9 Compliance)

1. **Tailwind CSS v3 via Vite & PostCSS**:
   - Configured in `tailwind.config.js` (`content: ['./resources/**/*.blade.php', ...]`) and `postcss.config.js`.
   - `resources/css/app.css` imports `@tailwind base; @tailwind components; @tailwind utilities;`.
   - Loaded via `@vite(['resources/css/app.css', 'resources/js/app.js'])` in `resources/views/layouts/app.blade.php` (no CDN scripts or hardcoded static `<link>` tags).
2. **Database Migration, Eloquent Model & Seeding**:
   - Migration: `database/migrations/2026_10_30_055415_create_vaccinations_table.php` (`id`, `patient_name`, `purok`, `vaccine`, `dose`, `scheduled_at`, `status`, `timestamps`).
   - Model: `app/Models/Vaccination.php` with `$fillable` and `$casts = ['scheduled_at' => 'date']`.
   - Seeders: `database/seeders/DatabaseSeeder.php` (seeds `nurse.buenviaje@bakuna.test` with `Hash::make('bakuna2026')`) and `database/seeders/VaccinationSeeder.php` (seeds 8 immunization schedule entries across 2026).
3. **Manual Session Authentication & Route Protection**:
   - `app/Http/Controllers/AuthController.php` implements `showLogin()`, `login()`, and `logout()`.
   - `app/Http/Controllers/DashboardController.php` implements `index()` (`/dashboard`) and `schedule()` (`/schedule`).
   - `routes/web.php` protects `/dashboard`, `/schedule`, and `/logout` with `auth` middleware, and `/login` with `guest` middleware.
4. **Blade Layouts, Directives & Reusable Components**:
   - Master Layout: `resources/views/layouts/app.blade.php` (`@yield('title')`, `@yield('content')`, `@auth`, `@guest`, semantic `<header>`, `<nav>`, `<main>`, `<footer>`).
   - Conditional Alert Banners using `@if` / `@elseif` / `@else` and `@unless`.
   - Schedule Table using `@forelse ... @empty ... @endforelse` and `$loop` metadata (`$loop->iteration`, `$loop->odd`, `$loop->first`, `$loop->last`).
   - Reusable Blade Components: `<x-stat-card :title="..." :value="..." />` (`resources/views/components/stat-card.blade.php`) and slotted `<x-panel title="...">...</x-panel>` (`resources/views/components/panel.blade.php`).

---

## Running Tests

```bash
php artisan test --compact
```
