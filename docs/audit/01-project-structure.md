# 01. Project Structure and Architectural Overview

**Project:** `innova-web` (INNOVA Computers BD / ICBD)  
**Audit Date:** October 13, 2026  
**Auditor:** Antigravity Agentic Audit (Phase 0 Discovery)  
**Strict Constraint:** Read-Only Audit (No code/configuration/data changes made)

---

## 1. Application Entry Points and Routing Lifecycle

### 1.1 Web Entry Points
The repository contains dual web entry points due to legacy shared-hosting configurations:
- **Standard Laravel Public Entry Point (`public/index.php`):**
  - Path: [`public/index.php`](file:///c:/wamp64/www/innova-web/public/index.php)
  - Loads Composer autoloader (`../vendor/autoload.php`) and boots Laravel via [`bootstrap/app.php`](file:///c:/wamp64/www/innova-web/bootstrap/app.php).
  - Intended document root for Apache/Nginx.
- **Root Directory Entry Wrapper (`index.php`):**
  - Path: [`index.php`](file:///c:/wamp64/www/innova-web/index.php)
  - Content: A literal duplicate of Laravel's [`server.php`](file:///c:/wamp64/www/innova-web/server.php) rewrite emulator.
  - Purpose: Deployed to allow execution when Apache `DocumentRoot` is set to the project repository root rather than `/public`.
  - Fallback logic: Checks `__DIR__ . '/public' . $uri`, then requires `__DIR__ . '/public/index.php'`.
- **Server Router (`server.php`):**
  - Path: [`server.php`](file:///c:/wamp64/www/innova-web/server.php)
  - Standard Laravel built-in PHP development server router (`php -S`).

### 1.2 CLI and Console Entry Points
- **Artisan CLI:**
  - Path: [`artisan`](file:///c:/wamp64/www/innova-web/artisan)
  - Boots the console kernel [`App\Console\Kernel`](file:///c:/wamp64/www/innova-web/app/Console/Kernel.php).

---

## 2. Directory Structure Inventory

```
innova-web/
├── .editorconfig
├── .env                              # Active environment configuration (contains live credentials)
├── .env.example                      # Template (contains hardcoded APP_KEY and dev typo)
├── .git/                             # Single initial commit ("2ea32df first commit")
├── .gitattributes
├── .gitignore                        # Standard rules + tar.gz backup ignore rule
├── .htaccess                         # Root Apache rewrite rules (Anti-pattern: exposes root files)
├── .styleci.yml
├── .user.ini                         # Injected PHP open_basedir from live cPanel
├── .well-known/                      # PKI / SSL certificate validation challenges
├── app/
│   ├── Console/                      # Console Kernel (no custom CLI commands defined)
│   ├── Contracts/                    # Interface contracts for repositories
│   ├── Exceptions/                   # Exception Handler
│   ├── Http/
│   │   ├── Controllers/              # 76 total Controller files (Admin, Frontend, Auth)
│   │   │   ├── Admin/                # 49 Admin Controllers + 1 anomalous route file
│   │   │   ├── Auth/                 # Authentication Controllers
│   │   │   ├── Frontend/             # Public Frontend Controllers
│   │   │   └── *.php                 # Root namespace Controllers
│   │   ├── Middleware/               # Auth, CSRF, Redirect, EncryptCookies
│   │   └── Requests/                 # (No custom FormRequest classes; validation in controllers)
│   ├── Models/                       # 49 Eloquent Model classes
│   ├── Notifications/                # (Directory exists; no custom notification classes)
│   ├── Providers/                    # 7 Service Providers (App, Auth, Repo, Settings, Route, etc.)
│   ├── Repositories/                 # 19 Repository classes + 1 anomalous error_log file
│   └── Traits/                       # UploadAble.php trait
├── artisan
├── backend/                          # [ANOMALOUS] Root static assets duplicate of public/backend
│   ├── ckeditor/
│   ├── css/
│   ├── img/
│   ├── js/
│   ├── scss/
│   └── vendor/
├── bootstrap/
│   ├── app.php
│   └── cache/
├── composer.json                     # PHP package declarations (Laravel 8.x, PHP ^8.0)
├── composer.lock                     # Locked dependency tree
├── config/                           # 15 Configuration files + 1 anomalous error_log file
├── css/                              # [ANOMALOUS] Root static CSS files duplicate of public/css
├── database/
│   ├── factories/                    # UserFactory.php
│   ├── migrations/                   # 52 Migration files (multiple duplicate/conflicting classes)
│   └── seeds/                        # DatabaseSeeder.php, UsersTableSeeder.php
├── frontend/                         # [ANOMALOUS] Root frontend static assets duplicate of public/frontend
│   ├── assets/
│   └── v2/
├── index.php                         # [ANOMALOUS] Root copy of server.php for shared hosting
├── js/                               # [ANOMALOUS] Root static JS files duplicate of public/js
├── package.json                      # Frontend dependencies (Laravel Mix 4, Vue 2, Bootstrap 4)
├── php.ini                           # [ANOMALOUS] 62 KB cPanel PHP configuration dumped in repo root
├── phpunit.xml
├── public/                           # Intended Web Root
│   ├── .htaccess                     # Proper public Apache rewrite rules
│   ├── backend/                      # Backend admin templates and plugins
│   ├── css/                          # Compiled CSS & vendor CSS
│   ├── fonts/
│   ├── frontend/                     # Frontend templates, images, JS
│   ├── index.php                     # Official Laravel front controller
│   ├── js/                           # Compiled JS
│   ├── uploads/                      # Direct uploads destination (e.g. uploads/asset/)
│   ├── verified.png
│   └── web.config                    # IIS server config
├── readme.md
├── resources/
│   ├── js/                           # Vue 2 / JS source assets
│   ├── lang/                         # Translation files
│   ├── sass/                         # SCSS sources
│   └── views/                        # 240+ Blade template views + 2 anomalous archives
│       ├── admin/
│       ├── auth/
│       ├── frontend/
│       ├── Iframe/
│       ├── layouts/
│       ├── users/
│       ├── vendor/
│       └── views.zip                 # [ANOMALOUS] 733 KB zip archive left in views directory
├── routes/
│   ├── admin.php                     # 43 KB admin route definitions (383+ routes)
│   ├── api.php                       # Default api route boilerplate (1 route)
│   ├── channels.php                  # Broadcasting channels
│   ├── console.php                   # Console closure commands
│   └── web.php                       # Public frontend, user, bKash, and auth routes
├── server.php
├── storage/
│   ├── app/
│   │   └── public/                   # Storage disk root (symlinked to public/storage)
│   ├── framework/
│   │   ├── cache/
│   │   ├── sessions/
│   │   ├── testing/
│   │   └── views/
│   └── logs/                         # Application logs (daily/single/bkash)
├── tests/
│   ├── CreatesApplication.php
│   ├── Feature/                      # Only default ExampleTest.php
│   ├── TestCase.php
│   └── Unit/                         # Only default ExampleTest.php
├── vendor/                           # Composer dependencies (installed)
└── webpack.mix.js                    # Laravel Mix 4 build config
```

---

## 3. Runtime, Framework, and Dependency Inventory

### 3.1 PHP and Laravel Framework Versions
- **Current CLI Runtime:** `PHP 8.2.0 (cli)` (Visual C++ 2019 x64, with Zend OPcache & Xdebug v3.2.0RC1).
- **Framework Core:** `Laravel Framework 8.83.29`.
- **Lifecycle & Support Status:**
  - Laravel 8 Bug Fixes ended: **July 26, 2022**.
  - Laravel 8 Security Fixes ended: **January 24, 2023** (**END OF LIFE**).
  - PHP 8.2 Active Support ended: **December 2024** (Security fixes only until December 2025).

### 3.2 Composer Dependencies (`composer.json`)

#### Production Dependencies (`require`):
| Package | Version Constraint | Active Status / Security Advisory | Purpose |
|---|---|---|---|
| `php` | `^8.0` | Runtime | Minimum PHP requirement |
| `laravel/framework` | `^8.0` | **EOL (Jan 2023)** | Core MVC Framework |
| `barryvdh/laravel-dompdf` | `1.0` | Pin Warning in composer validate | PDF generation (ID cards, reports) |
| `biscolab/laravel-recaptcha` | `^5.0` | **ABANDONED** | Google reCAPTCHA v2/v3 validation |
| `fideloper/proxy` | `^4.4` | Deprecated (replaced by framework TrustProxies) | Reverse proxy IP detection |
| `intervention/image` | `^2.7` | Legacy v2 (v3 current) | Image cropping and resizing |
| `laravel/tinker` | `^2.0` | Active | REPL console |
| `laravel/ui` | `^3.4` | Legacy Auth scaffolding | Bootstrap auth controllers & views |
| `laravelcollective/html` | `^6.3` | **ABANDONED / ARCHIVED** | Form and HTML Blade helpers (`Form::open()`) |
| `lemonpatwari/number-to-bangla` | `^1.0` | Active | Bengali number & currency word conversion |
| `simplesoftwareio/simple-qrcode` | `^4.2` | Active | QR code generation for certificates |
| `spatie/laravel-permission` | `^5.5` | Legacy v5 (v6 current) | Role and permission management |
| `swiftmailer/swiftmailer` | `^6.3` | **ABANDONED** (Replaced by `symfony/mailer`) | Mail delivery engine |
| `unisharp/laravel-filemanager` | `^2.5` | **HIGH SECURITY VULNERABILITY** (`CVE-2024-21546`, `CVE-2022-40734`) | Media upload & file management |

#### Development Dependencies (`require-dev`):
| Package | Version Constraint | Status | Purpose |
|---|---|---|---|
| `beyondcode/laravel-dump-server` | `^1.7` | Legacy | Console dump server |
| `filp/whoops` | `^2.14` | Active | Error screen in debug mode |
| `fzaninotto/faker` | `^1.9` | **ABANDONED** (Replaced by `fakerphp/faker`) | Fake seed data generator |
| `mockery/mockery` | `^1.3` | Active | Testing mock library |
| `nunomaduro/collision` | `^5.0` | Active | CLI error reporting |
| `phpunit/phpunit` | `^9.5` | EOL | Unit & Feature testing suite |

### 3.3 Frontend Packages & Build Tools (`package.json`)

#### DevDependencies:
| Package | Specified Version | Status / CVEs | Purpose |
|---|---|---|---|
| `laravel-mix` | `^4.0.7` | Severely outdated (Mix 6 / Vite current) | Webpack wrapper |
| `vue` | `^2.5.17` | **END OF LIFE (Dec 31, 2023)** | Reactive frontend components |
| `bootstrap` | `^4.1.0` | Legacy (Bootstrap 5 current) | Admin & Frontend CSS framework |
| `jquery` | `^3.2` | Outdated | DOM manipulation & legacy plugins |
| `popper.js` | `^1.12` | Deprecated (Floating UI / Popper 2) | Tooltips and dropdown positioning |
| `axios` | `^0.19` | Outdated | AJAX HTTP client |
| `cross-env` | `^5.1` | Outdated | Cross-platform build environment |
| `lodash` | `^4.17.13` | Multiple CVEs | Utility library |
| `resolve-url-loader` | `^2.3.1` | Outdated | Sass URL path resolver |
| `sass` | `^1.15.2` | Outdated Dart Sass | Sass compilation |
| `sass-loader` | `^7.1.0` | Outdated | Webpack Sass loader |

#### Security Vulnerability Summary (NPM Audit):
- Total vulnerabilities: **99**
- High Severity: **26** (`webpack-dev-server`, `webpack-dev-middleware`, path traversal, prototype pollution)
- Moderate Severity: **67**
- Low Severity: **6**

---

## 4. Configuration, Environment, Storage, and Task Architecture

### 4.1 Configuration Files Inventory (`config/*.php`)
1. [`config/app.php`](file:///c:/wamp64/www/innova-web/config/app.php): Defines timezone (`Asia/Dhaka`), locale (`en`), providers, and aliases.
2. [`config/auth.php`](file:///c:/wamp64/www/innova-web/config/auth.php): Defines guards (`web`, `api`, `admin`, `admin-api`). `api` and `admin-api` use unhashed token driver.
3. [`config/broadcasting.php`](file:///c:/wamp64/www/innova-web/config/broadcasting.php): Pusher, redis, log.
4. [`config/cache.php`](file:///c:/wamp64/www/innova-web/config/cache.php): File cache driver default.
5. [`config/cors.php`](file:///c:/wamp64/www/innova-web/config/cors.php): Default CORS settings.
6. [`config/database.php`](file:///c:/wamp64/www/innova-web/config/database.php): MySQL connection settings. **Critical Finding:** Contains hardcoded production fallback database name, username, and password!
7. [`config/filesystems.php`](file:///c:/wamp64/www/innova-web/config/filesystems.php): Disks `local`, `public`, `s3`.
8. [`config/hashing.php`](file:///c:/wamp64/www/innova-web/config/hashing.php): Bcrypt hashing (`rounds => 10`).
9. [`config/logging.php`](file:///c:/wamp64/www/innova-web/config/logging.php): Log channels: `stack`, `single`, `daily`, `slack`, `papertrail`, `stderr`, `syslog`, `errorlog`, and custom channel `bkash` (`storage/logs/bkash.log`).
10. [`config/mail.php`](file:///c:/wamp64/www/innova-web/config/mail.php): Mailer configuration. Defaults to SMTP with hardcoded from address `innovacomputersbd@gmail.com`.
11. [`config/permission.php`](file:///c:/wamp64/www/innova-web/config/permission.php): Spatie permission config.
12. [`config/queue.php`](file:///c:/wamp64/www/innova-web/config/queue.php): Default driver `sync`.
13. [`config/services.php`](file:///c:/wamp64/www/innova-web/config/services.php): Mailgun, postmark, ses, stripe. **Missing bKash and SMS configuration entries!**
14. [`config/session.php`](file:///c:/wamp64/www/innova-web/config/session.php): Default driver `file`, lifetime 120 minutes.
15. [`config/view.php`](file:///c:/wamp64/www/innova-web/config/view.php): Compiled view path `storage/framework/views`.

### 4.2 Storage and File Upload Directories
- **Public Storage Symlink:** `storage/app/public` symlinked to `public/storage`.
  - Directories: `students/`, `teachers/`, `slider/`, `courses/`, `ShareHolder/`, `investment/`, `feestransactions/`, `cmsAbout/`, `Certificate/`, `blog/`, `batchs/`, `Assets/`, `Admission/`, `img/`.
- **Direct Public Uploads (Bypassing Storage Disk):**
  - Path: `public/uploads/`
  - Subdirectories: `uploads/asset/`, `uploads/photos/`.
  - Inconsistency: Some controllers write directly to `public_path('uploads/...')` using PHP `mkdir()` and Intervention Image, while others use the `UploadAble` trait writing to `Storage::disk('public')`.

### 4.3 Scheduled Tasks and Background Jobs
- **Scheduler (`app/Console/Kernel.php`):**
  - No scheduled tasks registered in `schedule(Schedule $schedule)` (both inspire and custom jobs commented out).
- **Queues:**
  - `QUEUE_CONNECTION=sync` in `.env`.
  - No queued jobs, events, or listeners exist in `app/Jobs` or `app/Listeners`. All heavy operations (image manipulation, PDF generation, SMS dispatch, bKash cURL calls) run synchronously in HTTP request threads.

---

## 5. File Cleanliness and Anomaly Classification

### 5.1 Confirmed Anomalous and Suspicious Files
| File / Directory Path | Size | Classification | Evidence & Impact |
|---|---|---|---|
| [`resources/views/admin/report/innovacomputer_pay.sql`](file:///c:/wamp64/www/innova-web/resources/views/admin/report/innovacomputer_pay.sql) | 1,398,532 B (1.4 MB) | **CRITICAL DATA EXPOSURE** | Complete phpMyAdmin MySQL dump (5,045 lines) containing real historical production student, transaction, admin, and user data. |
| [`resources/views/views.zip`](file:///c:/wamp64/www/innova-web/resources/views/views.zip) | 733,066 B (733 KB) | **STRAY BACKUP ARCHIVE** | Zip file containing duplicate Blade templates sitting in production views directory. |
| [`app/Http/Controllers/Admin/admin.php`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/admin.php) | 6,066 B | **ORPHAN ROUTE FILE IN CONTROLLERS** | A 102-line Laravel route file accidentally saved inside the Controllers directory containing state-changing GET delete routes. |
| [`app/Repositories/error_log`](file:///c:/wamp64/www/innova-web/app/Repositories/error_log) | 2,933 B | **SERVER ERROR LOG LEAK** | Apache/cPanel error log revealing live server paths (`/home/sahabriyaj/innovacomputersbd.com/`). |
| [`config/error_log`](file:///c:/wamp64/www/innova-web/config/error_log) | 4,206 B | **SERVER ERROR LOG LEAK** | Logs proving direct URL scanning of config files (`/config/cache.php`, `/config/database.php`). |
| [`php.ini`](file:///c:/wamp64/www/innova-web/php.ini) | 62,523 B (62 KB) | **STRAY SERVER CONFIG** | Full cPanel PHP.ini file placed in repository root. |
| [`.user.ini`](file:///c:/wamp64/www/innova-web/.user.ini) | 54 B | **STRAY SERVER CONFIG** | Defines `open_basedir=/www/wwwroot/innovacomputersbd.com/:/tmp/` for live aaPanel/cPanel host. |
| [`index.php`](file:///c:/wamp64/www/innova-web/index.php) (Root) | 584 B | **ANTI-PATTERN WEB WRAPPER** | Copy of `server.php` in repo root to bypass `public/` web root. |

### 5.2 Candidate Anomalies Requiring Verification
| File / Directory Path | Description | Verification Required |
|---|---|---|
| `backend/` (Root) vs `public/backend/` | 6 subdirectories of static admin assets duplicated in repository root. | Verify if any legacy server still points DocumentRoot to root, rendering root `backend/` active. |
| `frontend/` (Root) vs `public/frontend/` | Static frontend assets duplicated in repository root. | Same as above. |
| `css/` and `js/` (Root) vs `public/css/` | Root-level script and stylesheet assets. | Verify if required by any legacy view referencing relative paths (`./css/...`). |
| `.well-known/` (Root) vs `public/.well-known/` | ACME challenge directories. | Verify if production SSL automation relies on root vs public folder. |
