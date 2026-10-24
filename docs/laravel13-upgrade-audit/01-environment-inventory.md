# 01. Environment and Architecture Inventory

**Project:** `innova-web` (INNOVA Computers BD / ICBD)  
**Audit Target:** Laravel 13 + PHP 8.4 + PostgreSQL + React Migration  
**Audit Date:** October 2026  
**Status:** Read-Only Audit (Phase 0)  
**Auditor:** Senior Laravel Migration Architect & Database Migration Specialist  

---

## 1. Executive Summary

This inventory documents the existing runtime environment, build toolchain, hosting architecture, and server dependencies of `innova-web`. The application is currently running on **Laravel 8.83.29** under a legacy architecture that mixes modern Composer dependencies with cPanel shared-hosting structural workarounds. Upgrading to **Laravel 13** and **PHP 8.4** hosted on a self-managed VPS requires standardizing the directory layout, replacing the legacy Webpack/Mix build system with Vite, modernizing runtime PHP extensions, and preparing the infrastructure for PostgreSQL 16+.

---

## 2. Core Runtime and Framework Inventory

| Component | Current State in Repository | Target Architecture | Verification Source | Status / Gap Analysis |
|---|---|---|---|---|
| **Framework** | Laravel Framework `v8.83.29` | Laravel `13.x` | `composer.lock` / `composer.json:16` | **Critical Gap:** 5 major versions behind. Laravel 8 reached end-of-life in Jan 2024. |
| **PHP Runtime** | `^8.0` (in `composer.json:11`), local CLI is PHP `8.2.0` | PHP `8.4.x` | `composer.json`, `composer.lock`, CLI | **Major Gap:** Current locked packages fail on PHP 8.4; code uses legacy untyped syntax. |
| **Database Engine** | MySQL 5.7 / MariaDB 10.4 (InnoDB) | PostgreSQL 15 / 16 (Strict SQL) | `config/database.php:46-64`, `.env.example` | **Major Gap:** MySQL non-strict mode (`strict: false`), raw string queries, and unmigrated tables. |
| **Frontend Framework** | Vue.js `^2.5.17` (scaffolding only) | React 18+ (Inertia.js or SPA) | `package.json:23`, `resources/js/app.js` | **Low Vue Footprint:** Only 1 dummy Vue component exists; UI is 326 server-rendered Blade views. |
| **Asset Bundler** | Laravel Mix `v4.0.7` (Webpack 4) | Vite `5.x` / `6.x` | `package.json:17`, `webpack.mix.js` | **Critical Gap:** Mix 4 is obsolete, fails on Node 18+, and lacks ESM / modern bundling. |
| **Node.js Toolchain** | Node `v22.15.0`, npm `10.9.2` | Node `20.x LTS` or `22.x LTS` | Host environment | **Compatible Host:** Node 22 is present, but `package-lock.json` contains 99 known CVEs. |
| **Hosting Model** | Shared Hosting Root Workaround (cPanel) | Self-managed Linux VPS (Ubuntu 24.04 LTS) | Repository root layout, `config/error_log` | **Architectural Anti-Pattern:** Root `index.php` and dual asset folders expose codebase. |

---

## 3. Directory Layout and Structural Anomalies

The application filesystem exhibits architectural anti-patterns resulting from legacy cPanel shared hosting deployments:

```
innova-web/
├── backend/                  <-- ANOMALY: Duplicate asset directory committed at root
├── frontend/                 <-- ANOMALY: Duplicate asset directory committed at root
├── css/                      <-- ANOMALY: Compiled CSS committed at root
├── js/                       <-- ANOMALY: Compiled JS committed at root
├── index.php                 <-- ANOMALY: Duplicate of server.php committed at root
├── server.php                <-- Standard Laravel built-in server script
├── public/                   <-- Proper Laravel document root
│   ├── backend/
│   ├── frontend/
│   ├── index.php             <-- Standard entrypoint
│   └── uploads/
├── app/                      <-- Core application code (76 Controllers, 49 Models)
├── config/                   <-- Configuration files (Contains error_log file)
├── database/                 <-- Migrations (52 files with collisions) & seeds
├── resources/
│   └── views/                <-- 326 Blade view files + 1.4MB SQL dump in views/admin/report/
└── docs/
    └── audit/                <-- Historical audit artifacts
```

### Detailed Structural Findings

#### Finding ENV-01: Shared-Hosting Dual Web Root and Exposed Document Root
- **Severity:** High
- **Location:** Repository root [`index.php`](file:///c:/wamp64/www/innova-web/index.php) and [`public/index.php`](file:///c:/wamp64/www/innova-web/public/index.php)
- **Observed State:** A copy of `server.php` is committed as `index.php` in the root directory, alongside duplicate static assets (`backend/`, `frontend/`, `css/`, `js/`).
- **Why It Matters:** When a web server (Apache/Nginx) points its `DocumentRoot` to the repository root instead of `/public`, sensitive files such as `.env`, `composer.lock`, `storage/logs/`, and committed SQL dumps become directly downloadable via HTTP requests.
- **Recommended Action:** On the target VPS, configure Nginx/Apache virtual host strictly to serve from `/var/www/innova-web/public`. Remove root `index.php` and redundant root asset directories.
- **Verification Status:** Confirmed.

#### Finding ENV-02: Leaked Internal Server Paths in Committed Log Files
- **Severity:** Medium
- **Location:** [`config/error_log`](file:///c:/wamp64/www/innova-web/config/error_log#L1-L20)
- **Observed State:** A committed server error log reveals absolute paths from previous production cPanel environments: `/home/innovacomputer/public_html/` and `/home/homearta/innovacomputersbd.com/`.
- **Why It Matters:** Leaks infrastructure layout and hosting account usernames to repository readers.
- **Recommended Action:** Delete `config/error_log` and add `error_log` to `.gitignore`.
- **Verification Status:** Confirmed.

---

## 4. Current Database Configuration

Database settings inspected from [`config/database.php`](file:///c:/wamp64/www/innova-web/config/database.php#L46-L79):

```php
'mysql' => [
    'driver' => 'mysql',
    'url' => env('DATABASE_URL'),
    'host' => env('DB_HOST', '127.0.0.1'),
    'port' => env('DB_PORT', '3306'),
    'database' => env('DB_DATABASE', 'satebwwt_icbdpayments'),
    'username' => env('DB_USERNAME', 'satebwwt_icbdpayments'),
    'password' => env('DB_PASSWORD', '[REDACTED_IN_AUDIT]'),
    'unix_socket' => env('DB_SOCKET', ''),
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix' => '',
    'prefix_indexes' => true,
    'strict' => false, // <-- CRITICAL: Disables strict SQL mode
    'engine' => null,
],
'pgsql' => [
    'driver' => 'pgsql',
    'url' => env('DATABASE_URL'),
    'host' => env('DB_HOST', '127.0.0.1'),
    'port' => env('DB_PORT', '5432'),
    'database' => env('DB_DATABASE', 'forge'),
    'username' => env('DB_USERNAME', 'forge'),
    'password' => env('DB_PASSWORD', ''),
    'charset' => 'utf8',
    'prefix' => '',
    'prefix_indexes' => true,
    'schema' => 'public',
    'sslmode' => 'prefer',
]
```

### Key Database Environment Discoveries:
1. **Fallback Credentials Exposed:** Live MySQL production database name, user, and password were hardcoded as the default fallback arguments in `env()` within `config/database.php:51-53`.
2. **Non-Strict MySQL Enabled:** `'strict' => false` allows non-standard SQL, invalid date representations (`0000-00-00`), and incomplete `GROUP BY` statements to succeed silently in MySQL. Under PostgreSQL, these queries fail with immediate database exceptions.
3. **PostgreSQL Configuration:** The `pgsql` driver is defined with default Laravel boilerplate (`forge`), but the application has never been executed against PostgreSQL in this codebase.

---

## 5. Required PHP Extensions and Server Requirements

For the target stack (**PHP 8.4 on Linux VPS** with PostgreSQL and modern Laravel 13):

| Extension / Utility | Current Usage in Application | Required in PHP 8.4 VPS | Notes / Action |
|---|---|---|---|
| `pdo_pgsql` | None (currently uses `pdo_mysql`) | **Mandatory** | Required for PostgreSQL PDO connection. |
| `pdo_mysql` | Primary active driver | Optional (Temporary) | Needed only during parallel migration / ETL data transfer. |
| `openssl` | Application encryption & hashing | **Mandatory** | Standard PHP core extension. |
| `mbstring` | Bengali text processing & string manipulation | **Mandatory** | Essential for UTF-8 Bengali language support. |
| `bcmath` | Precision math operations | **Mandatory** | Required for financial calculations and currency precision. |
| `gd` or `imagick` | Image thumbnailing & QR code generation | **Mandatory** | Required by `intervention/image` and `simple-qrcode`. |
| `fileinfo` | MIME type validation during file upload | **Mandatory** | Critical for hardening file upload security. |
| `curl` | bKash checkout API and SMS gateway requests | **Mandatory** | Required for outgoing HTTP integrations. |
| `ext-imap` | Not used in codebase | **Not Required** | Unbundled in PHP 8.4; verified absent from codebase. |
| `zip` | Excel/PDF/archive export | **Mandatory** | Required for DomPDF and file archives. |
| `redis` | Session / Cache / Queue driver | **Recommended** | High performance replacement for file/database cache. |

---

## 6. Build Tools and Deployment Environment

### Current Frontend Tooling:
- **`laravel-mix`**: `^4.0.7` (Released 2019, based on Webpack 4). Mix 4 does not support modern ES modules, modern CSS nesting, or React JSX transformations without deprecated plugins.
- **`cross-env`**: `^5.1` (Deprecated).
- **`vue`**: `^2.5.17` (Deprecated Vue 2, reached EOL December 31, 2023).
- **`bootstrap`**: `^4.1.0` (Bootstrap 4 is superseded by Bootstrap 5).

### Target Tooling:
- **`vite`**: `^5.4` or `^6.0` (Native Laravel Vite plugin `@laravel/vite-plugin`).
- **`@vitejs/plugin-react`**: For first-class React JSX/TSX bundling and Hot Module Replacement (HMR).
- **`tailwindcss`**: Modern utility CSS replacing legacy Bootstrap 4 styling.

---

## 7. Operational and Infrastructure Checklist for Self-Managed VPS

1. **Operating System:** Ubuntu 24.04 LTS (Noble Numbat) recommended.
2. **Web Server:** Nginx 1.24+ with HTTP/2 and TLS 1.3, reverse-proxying PHP-FPM 8.4.
3. **Database Server:** PostgreSQL 16 installed locally or accessed via private network.
4. **Process Manager:** `supervisord` or `systemd` to supervise Laravel queue workers (`php artisan queue:work`).
5. **Cron Scheduler:** Single system cron job:
   ```cron
   * * * * * cd /var/www/innova-web && php artisan schedule:run >> /dev/null 2>&1
   ```
6. **Filesystem Security:** 
   - Non-root user ownership (`www-data:www-data`).
   - `storage/` and `bootstrap/cache/` set to `775`.
   - Application code set to `755` for directories and `644` for files.
   - Nginx root configured strictly to `/var/www/innova-web/public`.
