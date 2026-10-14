<p align="center">
  <img src="public/favicon.svg" width="72" height="72" alt="Shaghalny logo">
</p>

<h1 align="center">Shaghalny</h1>

<p align="center">
  A unified <strong>job board + applicant-tracking system</strong> with a public discovery site,
  a candidate workspace, and a role-aware back-office for employers and admins — built on Laravel 12.
</p>

<p align="center">
  <img alt="Laravel" src="https://img.shields.io/badge/Laravel-12-FF2D20?logo=laravel&logoColor=white">
  <img alt="PHP" src="https://img.shields.io/badge/PHP-8.2%2B-777BB4?logo=php&logoColor=white">
  <img alt="Tailwind CSS" src="https://img.shields.io/badge/Tailwind-3-06B6D4?logo=tailwindcss&logoColor=white">
  <img alt="Alpine.js" src="https://img.shields.io/badge/Alpine.js-3-8BC0D0?logo=alpine.js&logoColor=white">
  <img alt="Vite" src="https://img.shields.io/badge/Vite-6-646CFF?logo=vite&logoColor=white">
  <img alt="License" src="https://img.shields.io/badge/License-MIT-green">
</p>

---

## Overview

**Shaghalny** is a single Laravel application that combines three products in one codebase:

1. **Public job board** — browse, search and filter vacancies; explore companies and job categories.
2. **Candidate workspace** — apply to jobs, manage résumés, track application status, and save jobs.
3. **Back-office (ATS)** — employers manage their company, vacancies and applicants; admins manage
   companies, users, categories and platform-wide analytics.

A standout feature is **AI-assisted recruitment**: uploaded PDF résumés are parsed into structured
data and scored (0–100) against each vacancy by GPT-4o, with detailed recruiter-style feedback.

The UI is a custom design system (Tailwind tokens + reusable Blade components) with a full
**light/dark theme** and a persisted theme toggle.

---

## Portfolio / CV summary

> **One-liner:** A full-stack Laravel job board and applicant-tracking platform with AI résumé
> parsing and match scoring, featuring separate candidate, employer and admin experiences.

**Short description (2–3 sentences):**
> Shaghalny is a full-stack recruitment platform I built with Laravel 12, Blade, Tailwind CSS and
> Alpine.js. It serves three distinct user roles — job seekers, company owners and admins — through a
> public job board, a candidate workspace and a back-office ATS, with AI-powered résumé parsing and
> candidate-to-job match scoring via the OpenAI API. The app uses UUID keys, soft deletes, a
> role-based middleware guard, and a token-driven design system with dark mode.

**Highlights to list on a CV / portfolio:**
- Designed and built a unified job board + ATS supporting **3 roles with role-based access control**.
- Integrated **OpenAI GPT-4o** to parse PDF résumés and generate **0–100 suitability scores + feedback**.
- Built a **custom design system** (Tailwind tokens, ~35 Blade components) with **dark mode**.
- Implemented full **CRUD + soft-delete/restore** for companies, users, categories, vacancies and applications.
- Added **search & multi-facet filtering**, saved jobs, résumé management, and an analytics dashboard.
- Architected with **Laravel 12** conventions: form requests, service layer, middleware, UUIDs, seeders.

**Tech tags:** `Laravel` `PHP` `MySQL` `Blade` `Tailwind CSS` `Alpine.js` `Vite` `OpenAI API` `AWS S3` `REST/MVC`

---

## Features

### Public (guest)
- Landing page with featured vacancies, categories and companies.
- **Job search** with keyword + filters (job type, category, minimum salary) and pagination.
- **Company directory** and **company profiles** (open roles, details).
- **Category browsing** with related vacancies.
- Static pages: About, FAQ, Contact (with persisted contact messages), Privacy, Terms.

### Candidate (`job_seeker`)
- Role-adaptive **dashboard**: application stats, recent activity, recommended jobs.
- **Apply to vacancies** by selecting an uploaded résumé; triggers AI scoring.
- **Application tracking** with status timeline (Pending / Accepted / Rejected).
- **Résumé manager**: upload PDFs, auto-extract skills/experience/education, download, delete.
- **Candidate profile** (headline, bio, location, skills, industries, availability).
- **Saved jobs** (bookmark/un-bookmark any vacancy).

### Employer (`company_owner`)
- **Analytics dashboard** scoped to their company (active candidates, jobs, applications, conversions).
- Manage their **company profile**.
- Full **job-vacancy CRUD** with publish/draft lifecycle and expiry.
- **Applicant review**: per-application detail, AI score/feedback, status updates, archive/restore.

### Admin
- Platform **analytics dashboard** (active users, total jobs/applications, most-applied jobs, conversion rates).
- **Company CRUD** (with owner account creation/editing) + archive/restore.
- **User CRUD** (role management, password reset, archive/restore) + archive/restore.
- **Job category CRUD** + restore.
- Oversight of **all vacancies and applications**.

---

## Tech stack

| Layer            | Technology |
|------------------|------------|
| Framework        | Laravel 12 (PHP 8.2+) |
| Auth             | Laravel Breeze (session-based) + custom role middleware |
| Frontend         | Blade templates, Tailwind CSS 3, Alpine.js 3 |
| Build            | Vite 6, PostCSS, Autoprefixer |
| Database         | MySQL / MariaDB (in production), SQLite (local default) |
| Files / storage  | Laravel filesystem — application local disk (`storage/app`) |
| AI               | **Groq API** via `openai-php/laravel` (OpenAI-compatible, `openai/gpt-oss-120b`) |
| PDF parsing      | `spatie/pdf-to-text` (wraps the `pdftotext` binary) |
| Testing          | Pest PHP 3 (PHPUnit under the hood) |
| Code style       | Laravel Pint |

---

## Roles & permissions

The `users.role` enum has three values, enforced by the `role` middleware alias
(`App\Http\Middleware\RoleMiddleware`, registered in `bootstrap/app.php`).

| Capability                          | Guest | Job seeker | Company owner | Admin |
|-------------------------------------|:-----:|:----------:|:-------------:|:-----:|
| Browse/search jobs & companies      | ✅ | ✅ | ✅ | ✅ |
| Apply, résumés, saved jobs          | ❌ | ✅ | – | – |
| Back-office dashboard               | ❌ | ❌ | ✅ | ✅ |
| Manage own company / vacancies      | ❌ | ❌ | ✅ | ✅ |
| Manage companies, users, categories | ❌ | ❌ | ❌ | ✅ |

> New sign-ups via `/register` default to the **`job_seeker`** role. Company-owner and admin
> accounts are provisioned by seeders or by an admin.

---

## AI résumé analysis

Implemented in `app/Services/ResumeAnalysisService.php`:

1. **Extract** — the résumé PDF is read from the application's local disk to a temp file and
   converted to text with the `pdftotext` binary.
2. **Parse** — the raw text is sent to the **Groq chat completions API** (`openai/gpt-oss-120b`,
   OpenAI-compatible) in JSON mode and returns
   structured `summary`, `skills`, `experience` and `education`.
3. **Score** — the parsed résumé plus the vacancy details are sent to GPT-4o, returning
   `AI_Generated_score` (0–100) and `AI_Generated_feedback` (detailed recruiter feedback),
   stored on the `job_applications` record.

The service **fails gracefully**: if the Groq API key is missing, the PDF tool isn't installed, or an
API error occurs, it logs the error and returns empty/zero values instead of breaking the request.

**Requirements for AI analysis:** a valid Groq API key (`OPENAI_API_KEY`, with
`OPENAI_BASE_URL=https://api.groq.com/openai/v1`) and the `pdftotext` binary available on
the host (`poppler-utils` on Debian/Ubuntu).

---

## Architecture & project structure

```
app/
├── Http/
│   ├── Controllers/        # Feature controllers (public, candidate, back-office, admin)
│   │   └── Auth/           # Breeze auth controllers
│   ├── Middleware/         # RoleMiddleware (role:admin,company_owner,...)
│   └── Requests/           # Form-request validation (Create/Update per resource)
├── Models/                 # Eloquent models (UUID keys, soft deletes where relevant)
├── Services/               # ResumeAnalysisService (AI + PDF)
└── View/Components/        # AppLayout / GuestLayout / MainLayout class components

database/
├── migrations/             # Schema (ordered so FK dependencies resolve)
├── seeders/                # DatabaseSeeder, CompanySeeder
└── data/                   # job_data.json, job_applications.json fixtures

resources/
├── css/app.css             # Design tokens (:root / .dark) + component classes
├── js/app.js               # Alpine bootstrap + theme toggle
└── views/
    ├── components/         # ~35 reusable UI components (button, card, badge, table…)
    ├── layouts/            # main, app (back-office), app-seeker, guest + navs
    ├── auth/               # Login, register, password reset, verification
    └── <feature folders>   # jobs, companies, company, user, job-vacancy, resumes, …
```

**Conventions**
- **UUID primary keys** (`HasUuids`) across models; `$keyType = 'string'`, `$incrementing = false`.
- **Soft deletes** on `users`, `companies`, `job_vacancies`, `job_applications` with restore endpoints.
- **Service layer** for cross-cutting logic (AI analysis), **form requests** for validation.
- **View components** for the design system; layouts switch by role (e.g. profile page picks the
  candidate or back-office shell).

---

## Key routes

| Method | URI | Name | Access |
|--------|-----|------|--------|
| GET | `/` | `home` | Public |
| GET | `/jobs` | `jobs.index` | Public |
| GET | `/companies`, `/companies/{company}` | `companies.*` | Public |
| GET | `/categories`, `/categories/{category}` | `categories.*` | Public |
| GET | `/job-vacancies/{id}` | `job-vacancies.show` | Public |
| GET | `/dashboard` | `dashboard` | Auth (role-adaptive) |
| GET/POST | `/job-vacancies/apply/{id}` | `job-vacancies.apply` | Auth |
| GET | `/job-applications`, `/job-applications/{id}` | `job-applications.*` | Auth |
| GET/POST/DELETE | `/resumes`, `/resumes/{resume}/download` | `resumes.*` | Job seeker |
| GET/POST | `/candidate/profile` | `candidate-profile.*` | Job seeker |
| GET/POST/DELETE | `/saved-jobs`, `/jobs/{job}/save` | `saved-jobs.*` | Auth |
| GET | `/backoffice` | `backoffice.dashboard` | Admin / Owner |
| resource | `/job-vacancy`, `/job-application` | `job-vacancy.*`, `job-application.*` | Admin / Owner |
| GET/PUT | `/myCompany/show`, `/myCompany/edit` | `myCompany.*` | Company owner |
| resource | `/company`, `/user`, `/job-category` | `company.*`, `user.*`, `job-category.*` | Admin |

---

## Getting started

### Requirements
- PHP **8.2+** with `pdo`, `mbstring`, `openssl`, `fileinfo`, `xml`, `ctype`, `json`
- Composer 2
- Node.js 18+ and npm
- A database (SQLite by default; MySQL/MariaDB supported)
- Optional: `pdftotext` (`poppler-utils`) for résumé parsing, and a Groq API key

### Installation

```bash
# 1. Install PHP dependencies
composer install

# 2. Install & build front-end assets
npm install
npm run build        # or: npm run dev

# 3. Create the environment file and app key
cp .env.example .env
php artisan key:generate

# 4. Configure the database in .env (see below), then migrate + seed
php artisan migrate --seed
```

### Run the app

```bash
# Option A — everything at once (server, queue, logs, Vite)
composer dev

# Option B — separately
php artisan serve
npm run dev
```

Then open http://localhost:8000.

---

## Environment variables

Key values in `.env`:

```dotenv
APP_NAME="Shaghalny"
APP_URL=http://localhost:8000

# --- Database (SQLite default; MySQL example) ---
DB_CONNECTION=sqlite
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=shaghalny
# DB_USERNAME=root
# DB_PASSWORD=

# --- File storage ---
FILESYSTEM_DISK=local

# --- AWS S3 (only if you switch FILESYSTEM_DISK to s3) ---
AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=

# --- Groq (résumé parsing & scoring, OpenAI-compatible) ---
OPENAI_API_KEY=
OPENAI_BASE_URL=https://api.groq.com/openai/v1
OPENAI_MODEL=openai/gpt-oss-120b

# --- PDF text extraction (optional path override; auto-detected by default) ---
PDFTOTEXT_BINARY=
```

> Résumé files are written to and read from the application's **local** disk
> (`storage/app/private`).

---

## Database & seed data

Migrations create the full schema (users, sessions, cache/jobs, contact messages, job categories,
companies, résumés, job vacancies, job applications, saved jobs, candidate profiles,
application-status histories, analytics fields).

Seeding (`php artisan db:seed`, or `--seed` with migrate) loads realistic fixtures from
`database/data/*.json`:

- **7 job categories**
- **5 companies** (each with a generated owner account)
- **26 job vacancies**
- **10 sample applications** with résumés and AI scores

### Demo credentials

| Role | Email | Password |
|------|-------|----------|
| Admin | `Admin@gmail.com` | `1234` |
| Candidate | `candidate@gmail.com` | `1234` |
| Company owner | e.g. `techcore.solutions@example.com` | `1234` |

Company-owner emails follow the pattern `<company-name-with-dots>@example.com` (the seeder
generates them from the company names in `job_data.json`).

---

## Design system & theming

- `tailwind.config.js` defines a semantic color palette (brand, surface, ink, border, accents,
  sidebar) that maps to **CSS custom properties** (`rgb(var(--token) / <alpha-value>)`).
- `resources/css/app.css` declares the light theme in `:root` and the dark theme under `.dark`,
  plus reusable component classes (`.btn-*`, `.card`, `.badge-*`, `.field-*`, `.alert-*`, …).
- `resources/js/app.js` exposes `window.toggleTheme()`; the choice is persisted to `localStorage`
  and a **no-flash inline script** (`layouts/partials/theme.blade.php`) applies it before paint.
- Reusable Blade components live in `resources/views/components/` (button, badge, table, modal,
  dropdown, stat-card, empty-state, theme-toggle, …).

---

## Testing & code style

```bash
php artisan test          # Pest test suite
./vendor/bin/pint         # format PHP code
npm run build             # production asset build
```

---

## Notes & limitations

- AI features require a Groq API key (`OPENAI_API_KEY`) and `pdftotext`; otherwise they degrade gracefully.
- Résumé uploads are PDF-only for meaningful text extraction.
- New registrations are always `job_seeker`; owner/admin accounts are seeded or admin-created.
- If you run migrations against a **load-balanced / serverless MySQL proxy**, ensure the connection
  is pinned to the primary — replicas with replication lag can make freshly-created tables
  temporarily invisible (causing foreign-key errors during migrate).

---

## License

Released under the **MIT License**. Built on the [Laravel](https://laravel.com) framework.
