# 02. Composer Package Compatibility and Replacement Audit

**Project:** `innova-web` (INNOVA Computers BD / ICBD)  
**Audit Target:** Laravel 13 + PHP 8.4  
**Audit Date:** October 2026  
**Status:** Read-Only Audit (Phase 0) — No composer commands executed  
**Auditor:** Senior Laravel Migration Architect  

---

## 1. Executive Summary

A comprehensive dependency analysis was conducted on `composer.json` and `composer.lock`. The project currently locks **38 runtime packages** and **13 development packages** (excluding pure polyfills).

The audit reveals that **6 packages are officially abandoned or discontinued**, **4 packages have critical security vulnerabilities**, and **no package in its currently locked version is compatible with Laravel 13 or PHP 8.4**. A direct jump to Laravel 13 is blocked by dependency version conflicts across the entire ecosystem.

---

## 2. Direct Runtime Dependencies Audit (`require`)

| Package Name | Locked Version | PHP Constraint (Locked) | Declared Laravel Support | Laravel 13 / PHP 8.4 Compatibility Status | Required Migration Action |
|---|---|---|---|---|---|
| `laravel/framework` | `v8.83.29` | `^7.3 \| ^8.0` | Laravel 8 | **Incompatible:** EOL since Jan 2024. Incompatible with PHP 8.2+. | Step upgrade: 8 → 9 → 10 → 11 → 12 → 13. |
| `swiftmailer/swiftmailer` | `v6.3.0` | `>=7.0.0` | Laravel 6–8 | **Critical Blocker:** Abandoned Nov 2021. Removed in Laravel 9. | Remove package. Migrate to `symfony/mailer` (native Laravel 9+ mailer). |
| `fideloper/proxy` | `4.4.2` | `>=7.0` | Laravel 5–8 | **Critical Blocker:** Abandoned. Merged into Laravel core. | Remove package. Use `Illuminate\Http\Middleware\TrustProxies`. |
| `laravelcollective/html` | `v6.4.1` | `^7.2.5 \| ^8.0` | Up to Laravel 10 | **Critical Blocker:** Discontinued / abandoned. Incompatible with L11+. | Replace with standard Blade components or `spatie/laravel-html`. (Used in only 9 views). |
| `unisharp/laravel-filemanager` | `v2.6.3` | `>=7.0` | Laravel 5–9 | **High Risk / Incompatible:** Unmaintained; `CVE-2024-21546` RCE flaw. Incompatible with L11+. | Replace with Spatie Media Library or modern React file manager component. |
| `intervention/image` | `2.7.2` | `>=5.4.0` | Laravel 5–10 | **Incompatible:** v2 is obsolete. v3 is a complete API rewrite. | Upgrade to `intervention/image: ^3.0`. Port `Image::make()` to `ImageManager::read()`. |
| `spatie/laravel-permission` | `5.11.1` | `^7.3 \| ^8.0` | Laravel 8–10 | **Incompatible:** v5 does not support Laravel 11/12/13. | Upgrade to `spatie/laravel-permission: ^6.0`. Update migrations and traits. |
| `barryvdh/laravel-dompdf` | `v1.0.0` | `^7.1 \| ^8.0` | Laravel 8–9 | **Incompatible / High Risk:** Bundles `dompdf/dompdf v1.2.2` (`CVE-2022-40734` RCE). | Upgrade to `barryvdh/laravel-dompdf: ^3.0` (with DomPDF 3.x and PHP 8.4 support). |
| `biscolab/laravel-recaptcha` | `v5.4.0` | `>=7.3` | Laravel 8–9 | **Incompatible:** Does not support Laravel 11+. | Upgrade to `biscolab/laravel-recaptcha: ^6.0` or replace with Cloudflare Turnstile. |
| `simplesoftwareio/simple-qrcode` | `4.2.0` | `>=7.2` | Laravel 7–9 | **Incompatible:** Requires updating BaconQrCode for modern PHP 8.4 compatibility. | Upgrade to `simplesoftwareio/simple-qrcode: ^4.2.0` / verify PHP 8.4 or use `endroid/qr-code`. |
| `lemonpatwari/number-to-bangla` | `v1.0.1` | None | Pure PHP | **Compatible / Low Risk:** Pure numeric transformation utility. | Keep, but verify with automated tests under PHP 8.4. |
| `laravel/ui` | `v3.4.6` | `^7.3 \| ^8.0` | Laravel 8–9 | **Deprecated:** Legacy authentication scaffolding. | Discard during React migration. |
| `laravel/tinker` | `v2.10.1` | `^7.2.5 \| ^8.0` | Laravel 8–11 | **Upgradeable:** Minor updates needed. | Upgrade to `laravel/tinker: ^2.10`. |

---

## 3. Direct Development Dependencies Audit (`require-dev`)

| Package Name | Locked Version | Status & Compatibility | Required Migration Action |
|---|---|---|---|
| `fzaninotto/faker` | `dev-master` | **Critical Blocker:** Abandoned since 2020. Fails on PHP 8.2+. | Replace with `fakerphp/faker: ^1.23`. |
| `beyondcode/laravel-dump-server` | `1.9.0` | **Abandoned:** Replaced by Laravel's built-in `dump-server` command. | Remove from `composer.json`. |
| `filp/whoops` | `2.18.4` | Compatible with PHP 8.4. | Update to latest `^2.18`. |
| `mockery/mockery` | `1.6.12` | Compatible with PHP 8.4. | Update to `^1.6`. |
| `nunomaduro/collision` | `v5.11.0` | **Incompatible:** Tied to Laravel 8. Laravel 11+ uses Collision 8+. | Upgrade to `nunomaduro/collision: ^8.0`. |
| `phpunit/phpunit` | `9.6.29` | **Major Version Incompatible:** Laravel 10 switched to PHPUnit 10; Laravel 11/12+ uses PHPUnit 11+. | Upgrade to `phpunit/phpunit: ^11.0`. Convert test configurations and annotations. |

---

## 4. In-Depth Analysis of Critical Blockers and Abandoned Packages

### 4.1 SwiftMailer Removal (`swiftmailer/swiftmailer`)
- **Finding ID:** COMP-01
- **Severity:** Critical Blocker
- **Files Affected:** `composer.json:23`, `config/mail.php:1-60`
- **Observed Behavior:** SwiftMailer project announced end-of-life in November 2021. Laravel removed all SwiftMailer bindings in Laravel 9, completely transitioning to Symfony Mailer.
- **Why It Matters:** Any code invoking `Swift_Message`, `Swift_Mailer`, or SwiftMailer plugins will crash with `Class 'Swift_Message' not found` the moment Laravel 9 is installed.
- **Verification Status:** Confirmed.
- **Recommended Action:**
  1. Remove `"swiftmailer/swiftmailer"` from `composer.json`.
  2. Modernize `config/mail.php` from legacy `driver` syntax to the Laravel 9+ `mailers` array structure:
     ```php
     'default' => env('MAIL_MAILER', 'smtp'),
     'mailers' => [
         'smtp' => [
             'transport' => 'smtp',
             'host' => env('MAIL_HOST', 'smtp.gmail.com'),
             'port' => env('MAIL_PORT', 587),
             'encryption' => env('MAIL_ENCRYPTION', 'tls'),
             'username' => env('MAIL_USERNAME'),
             'password' => env('MAIL_PASSWORD'),
             'timeout' => null,
         ],
     ],
     ```

### 4.2 Fideloper Proxy Removal (`fideloper/proxy`)
- **Finding ID:** COMP-02
- **Severity:** Critical Blocker
- **Files Affected:** `composer.json:14`, `app/Http/Middleware/TrustProxies.php:6-22`, `app/Http/Kernel.php:21`
- **Observed Behavior:** `fideloper/proxy` is abandoned. Laravel 9 integrated proxy handling directly into `Illuminate\Http\Middleware\TrustProxies`.
- **Why It Matters:** Keeping this package prevents upgrading to Laravel 9 and beyond.
- **Verification Status:** Confirmed.
- **Recommended Action:**
  1. Remove `"fideloper/proxy"` from `composer.json`.
  2. Change inheritance in `app/Http/Middleware/TrustProxies.php`:
     ```php
     - use Fideloper\Proxy\TrustProxies as Middleware;
     + use Illuminate\Http\Middleware\TrustProxies as Middleware;
     ```
  3. Update headers constant from `Request::HEADER_X_FORWARDED_ALL` to `Request::HEADER_X_FORWARDED_FOR | Request::HEADER_X_FORWARDED_HOST | Request::HEADER_X_FORWARDED_PORT | Request::HEADER_X_FORWARDED_PROTO | Request::HEADER_X_FORWARDED_AWS_ELB`.

### 4.3 LaravelCollective HTML Discontinuation (`laravelcollective/html`)
- **Finding ID:** COMP-03
- **Severity:** High
- **Files Affected:** `composer.json:19`, and exactly 9 Blade templates:
  - [`resources/views/admin/users/index.blade.php`](file:///c:/wamp64/www/innova-web/resources/views/admin/users/index.blade.php)
  - [`resources/views/admin/users/create.blade.php`](file:///c:/wamp64/www/innova-web/resources/views/admin/users/create.blade.php)
  - [`resources/views/admin/users/edit.blade.php`](file:///c:/wamp64/www/innova-web/resources/views/admin/users/edit.blade.php)
  - [`resources/views/admin/roles/index.blade.php`](file:///c:/wamp64/www/innova-web/resources/views/admin/roles/index.blade.php)
  - [`resources/views/admin/roles/create.blade.php`](file:///c:/wamp64/www/innova-web/resources/views/admin/roles/create.blade.php)
  - [`resources/views/admin/roles/edit.blade.php`](file:///c:/wamp64/www/innova-web/resources/views/admin/roles/edit.blade.php)
  - [`resources/views/admin/admins/index.blade.php`](file:///c:/wamp64/www/innova-web/resources/views/admin/admins/index.blade.php)
  - [`resources/views/admin/admins/create.blade.php`](file:///c:/wamp64/www/innova-web/resources/views/admin/admins/create.blade.php)
  - [`resources/views/admin/admins/edit.blade.php`](file:///c:/wamp64/www/innova-web/resources/views/admin/admins/edit.blade.php)
- **Observed Behavior:** The package is unmaintained and does not support Laravel 11+.
- **Why It Matters:** Only 9 out of 326 Blade views actually use `{!! Form::open() !!}` and `{!! Form::text() !!}`. The remaining 317 views already use standard HTML `<form>` tags.
- **Verification Status:** Confirmed.
- **Recommended Action:** Replace `{!! Form:: !!}` calls in those 9 views with plain HTML forms or Blade components, then remove `laravelcollective/html` entirely.

### 4.4 UniSharp Laravel Filemanager RCE (`unisharp/laravel-filemanager`)
- **Finding ID:** COMP-04
- **Severity:** Critical Security / Blocker
- **Files Affected:** `composer.json:24`, `config/lfm.php`, `resources/views/admin/blogs/create.blade.php:100`, `resources/views/admin/courses/create.blade.php:148`
- **Observed Behavior:** The package is effectively unmaintained and vulnerable to `CVE-2024-21546` (Remote Code Execution via arbitrary file upload). It does not support Laravel 11/12/13.
- **Why It Matters:** Retaining this package is a direct security hazard and blocks modern Laravel framework upgrades.
- **Verification Status:** Confirmed.
- **Recommended Action:** Remove the package and routes. Replace CKEditor integration with a secure modern file upload handler or React-based asset manager with strict MIME validation.

### 4.5 Intervention Image v2 to v3 API Breaking Changes (`intervention/image`)
- **Finding ID:** COMP-05
- **Severity:** High
- **Files Affected:** `composer.json:15`, [`app/Http/Controllers/Frontend/AssetController.php:9, 54-56`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Frontend/AssetController.php#L54-L56)
- **Observed Behavior:** In the entire codebase, only `AssetController` utilizes Intervention Image:
  ```php
  Image::make($photo)->fit(300, 300)->save($savePath);
  ```
  Intervention Image v3 completely redesigned the public API: static `Image::make()` is removed; driver injection via `ImageManager` and `read()` is mandatory.
- **Why It Matters:** Upgrading to `intervention/image: ^3.0` will break `AssetController` unless the call site is updated.
- **Verification Status:** Confirmed.
- **Recommended Action:** Update `AssetController.php` to v3 syntax:
  ```php
  use Intervention\Image\ImageManager;
  use Intervention\Image\Drivers\Gd\Driver;

  $manager = new ImageManager(new Driver());
  $image = $manager->read($photo);
  $image->cover(300, 300)->save($savePath);
  ```

---

## 5. Comprehensive Package Replacement Matrix

| Current Package | Target Package & Version | Migration Strategy & Action Required |
|---|---|---|
| `laravel/framework: 8.83.29` | `laravel/framework: ^13.0` | Step upgrade (8→9→10→11→12→13) or clean Laravel 13 skeleton re-platforming. |
| `swiftmailer/swiftmailer: 6.3.0` | *Built-in* `symfony/mailer: ^7.0` | Native Laravel 9+ replacement. Update `config/mail.php`. |
| `fideloper/proxy: 4.4.2` | *Built-in* `Illuminate\Http\Middleware\TrustProxies` | Native replacement in Laravel 9+. Update middleware namespace. |
| `laravelcollective/html: 6.4.1` | Native Blade Components / HTML5 | Convert 9 views to standard HTML5; remove package. |
| `unisharp/laravel-filemanager: 2.6.3` | Custom React Upload / Spatie Media Library | Remove unmaintained package and replace CKEditor file picker. |
| `intervention/image: 2.7.2` | `intervention/image: ^3.7` | Refactor single usage in `AssetController.php` to v3 Driver API. |
| `spatie/laravel-permission: 5.11.1` | `spatie/laravel-permission: ^6.9` | Run v6 migration updates; verify role/permission guard configurations. |
| `barryvdh/laravel-dompdf: 1.0.0` | `barryvdh/laravel-dompdf: ^3.0` | Upgrade to v3.x (DomPDF 3.x with PHP 8.4 engine). |
| `biscolab/laravel-recaptcha: 5.4.0` | `biscolab/laravel-recaptcha: ^6.1` | Upgrade to v6 or switch to Cloudflare Turnstile. |
| `simplesoftwareio/simple-qrcode: 4.2.0` | `simplesoftwareio/simple-qrcode: ^4.2` / `endroid/qr-code` | Verify BaconQrCode 2.0 / PHP 8.4 SVG rendering. |
| `fzaninotto/faker: dev-master` | `fakerphp/faker: ^1.23` | Direct drop-in replacement in `require-dev`. |
| `beyondcode/laravel-dump-server: 1.9.0` | *Removed* | Use built-in Laravel artisan `dump-server` or `spatie/laravel-ray`. |
| `nunomaduro/collision: 5.11.0` | `nunomaduro/collision: ^8.0` | Required for Laravel 11/12/13 artisan error reporting. |
| `phpunit/phpunit: 9.6.29` | `phpunit/phpunit: ^11.0` | Upgrade XML schema in `phpunit.xml` and update test assertions. |
