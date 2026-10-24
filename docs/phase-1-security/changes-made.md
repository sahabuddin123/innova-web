# Phase 1 Summary of Changes Made

**Project:** `innova-web` (INNOVA Computers BD / ICBD)  
**Execution Phase:** Phase 1 — Security Hardening & Repository Remediation  
**Date:** October 23, 2026 (Updated after Final Verification Pass)  
**Branch:** `feature/phase-1-security-hardening`  
**Auditor:** Senior Laravel Security Engineer  

---

## 1. Overview of Code Modifications

During Phase 1, **15 application and repository files** were modified to remediate confirmed security vulnerabilities:
- Eliminating hardcoded production credentials.
- Hardening file upload pipelines against RCE and Stored SVG XSS.
- Containing legacy UniSharp File Manager by disabling package auto-routes, enforcing `auth:admin` middleware, activating strict MIME/size validation, and prohibiting SVG.
- Enforcing admin login brute-force rate limiting.
- Restoring TLS peer and hostname verification for outbound SMS requests.
- Validating bKash payment states, guarding execute calls, handling lock timeouts, and preventing duplicate transaction creation under concurrent callbacks.
- Converting state-changing maintenance and SMS operations to POST-only with CSRF protection.
- Updating JavaScript AJAX callers with CSRF headers and error feedback.
- Adding safe ignore rules to `.gitignore`.
- Implementing a comprehensive automated unit test suite (22 unit tests, 120 assertions across `tests/Unit/` with 100% pass rate).

---

## 2. File-by-File Change Log

### 2.1 Configuration Hardening: `config/database.php`
- **File:** [`config/database.php`](file:///c:/wamp64/www/innova-web/config/database.php)
- **Finding Addressed:** **SEC-02 (Hardcoded Production Credentials)**
- **Modification:** Replaced live production MySQL database credentials used as default fallback arguments in `env()` with safe standard placeholders.
- **Diff Summary:**
  ```diff
  - 'database' => env('DB_DATABASE', 'satebwwt_icbdpayments'),
  - 'username' => env('DB_USERNAME', 'satebwwt_icbdpayments'),
  - 'password' => env('DB_PASSWORD', '[REDACTED_LIVE_PASSWORD]'),
  + 'database' => env('DB_DATABASE', 'forge'),
  + 'username' => env('DB_USERNAME', 'forge'),
  + 'password' => env('DB_PASSWORD', ''),
  ```

---

### 2.2 Centralized Service Config: `config/services.php`
- **File:** [`config/services.php`](file:///c:/wamp64/www/innova-web/config/services.php)
- **Finding Addressed:** **SEC-08, SEC-10 (Runtime `env()` Fragility under `config:cache`)**
- **Modification:** Added dedicated configuration arrays for `bkash` and `sms` services.
- **Diff Summary:**
  ```php
  'bkash' => [
      'app_key' => env('BKASH_CHECKOUT_APP_KEY'),
      'app_secret' => env('BKASH_CHECKOUT_APP_SECRET'),
      'user_name' => env('BKASH_CHECKOUT_USER_NAME'),
      'password' => env('BKASH_CHECKOUT_PASSWORD'),
      'base_url' => env('BKASH_BASE_URL', 'https://checkout.pay.bka.sh/v1.2.0-beta'),
  ],

  'sms' => [
      'url' => env('SMS_URL'),
      'api_key' => env('SMS_API_KEY'),
      'sender_id' => env('SMS_SENDER_ID'),
  ],
  ```

---

### 2.3 Legacy File Manager Containment: `config/lfm.php`
- **File:** [`config/lfm.php`](file:///c:/wamp64/www/innova-web/config/lfm.php)
- **Finding Addressed:** **SEC-04 (UniSharp Laravel Filemanager Containment)**
- **Modification:**
  1. Set `'use_package_routes' => false` to disable default `/filemanager` routes previously exposed to regular users via the default `auth` guard.
  2. Set `'should_validate_mime' => true` and `'should_validate_size' => true` to activate package-level file validation.
  3. Set `'rename_file' => true` to rename uploaded files with unique hashes, eliminating path traversal risks and arbitrary uploaded filenames.
  4. Set `'alphanumeric_filename' => true` and `'alphanumeric_directory' => true`.
  5. Removed `'image/svg+xml'` from both `'valid_image_mimetypes'` and `'valid_file_mimetypes'` to eliminate vector Stored XSS.

---

### 2.4 Upload Validation Hardening: `app/Http/Controllers/Admin/SettingController.php`
- **File:** [`app/Http/Controllers/Admin/SettingController.php`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/SettingController.php)
- **Finding Addressed:** **SEC-03 (Unrestricted File Upload & Stored SVG XSS)**
- **Modification:** Added strict validation rules for `site_logo` and `site_favicon`. Explicitly excluded `svg` to prevent stored XSS attacks via uploaded vector graphics.
- **Diff Summary:**
  ```diff
  + $request->validate([
  +     'site_logo' => 'nullable|file|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
  +     'site_favicon' => 'nullable|file|mimes:ico,png,jpg|max:512',
  + ]);
  ```

---

### 2.5 Upload Trait Hardening: `app/Traits/UploadAble.php`
- **File:** [`app/Traits/UploadAble.php`](file:///c:/wamp64/www/innova-web/app/Traits/UploadAble.php)
- **Finding Addressed:** **SEC-03 (Arbitrary File Upload, Stored XSS, Path Traversal & Double Extensions)**
- **Modification:**
  1. Sanitized `$filename` and `$folder` to prevent directory traversal (`..`) or overwriting arbitrary files.
  2. Blocked dangerous double-extension filenames (e.g., `shell.php.jpg`, `exploit.phtml.png`).
  3. Enforced strict extension allowlist (`jpg`, `jpeg`, `png`, `gif`, `webp`, `ico`, `pdf`, `bmp`).
  4. Enforced server-detected MIME allowlist (`image/jpeg`, `image/png`, `image/gif`, `image/webp`, `image/x-icon`, `image/vnd.microsoft.icon`, `application/pdf`, `image/bmp`).
  5. Explicitly rejected SVG files and SVG MIME types (`image/svg+xml`) to prevent stored XSS attacks.

---

### 2.6 Admin Login Rate Limiting: `app/Http/Controllers/Admin/LoginController.php`
- **File:** [`app/Http/Controllers/Admin/LoginController.php`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/LoginController.php)
- **Finding Addressed:** **SEC-06 (Missing Brute-Force Rate Limiting)**
- **Modification:** Restored `ThrottlesLogins` checking, incrementing, and lockout event dispatching in overridden `login(Request $request)` method.

---

### 2.7 bKash State Validation & Concurrency Protection: `app/Http/Controllers/BkashController.php`
- **File:** [`app/Http/Controllers/BkashController.php`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/BkashController.php)
- **Finding Addressed:** **SEC-08 (bKash Payment State Validation & Concurrent Replay)**
- **Modification:**
  1. Replaced direct runtime `env()` lookups with `config('services.bkash.*')`.
  2. In `execute()`, validated session `paymentID`; guarded against missing session and updated decoded `$arr` if query retry is invoked.
  3. In `success()`, validated both `paymentID` and `trxID`; strictly checked that `$arr['transactionStatus']` is non-empty and equals `'Completed'` (case-insensitive), and `$arr['errorCode'] === '0000'`. Malformed or non-completed callbacks are rejected before database interactions.
  4. Added atomic distributed locking (`Cache::lock('bkash_payment_trx_' . $trxId, 15)`) to serialize concurrent requests for identical transaction IDs, safely released within a `finally` block.
  5. Handled lock contention and timeout gracefully via `LockTimeoutException` catch block; verified that fee record exists before displaying success view.
  6. Wrapped fee insertion in `DB::transaction()` with pre-insert existence check and graceful `QueryException` catch to handle unique constraint collisions.
  7. Cleared transient payment session keys (`paymentID`, `arr`) upon successful execution to eliminate replay attacks.

---

### 2.8 Outbound TLS Verification: `app/Http/Controllers/Admin/SMSController.php`
- **File:** [`app/Http/Controllers/Admin/SMSController.php`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/SMSController.php)
- **Finding Addressed:** **SEC-10 (Disabled TLS Verification)**
- **Modification:** Restored `CURLOPT_SSL_VERIFYPEER => true` and `CURLOPT_SSL_VERIFYHOST => 2`. Switched to `config('services.sms.*')`.

---

### 2.9 Outbound TLS Verification: `app/Http/Controllers/Admin/FeesTransectionsController.php`
- **File:** [`app/Http/Controllers/Admin/FeesTransectionsController.php`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/FeesTransectionsController.php)
- **Finding Addressed:** **SEC-10 (Disabled TLS Verification)**
- **Modification:** Restored `CURLOPT_SSL_VERIFYPEER => true` and `CURLOPT_SSL_VERIFYHOST => 2` in `send_sms` method. Switched to `config('services.sms.*')`.

---

### 2.10 Outbound TLS Verification: `app/Http/Controllers/Admin/UsersController.php`
- **File:** [`app/Http/Controllers/Admin/UsersController.php`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/UsersController.php)
- **Finding Addressed:** **SEC-10 (Disabled TLS Verification)**
- **Modification:** Restored `CURLOPT_SSL_VERIFYPEER => true` and `CURLOPT_SSL_VERIFYHOST => 2` in user account dispatch SMS helper. Switched to `config('services.sms.*')`.

---

### 2.11 Exception Handler Route Correction: `app/Exceptions/Handler.php`
- **File:** [`app/Exceptions/Handler.php`](file:///c:/wamp64/www/innova-web/app/Exceptions/Handler.php)
- **Finding Addressed:** **SEC-12 (Undefined Route Reference)**
- **Modification:** Changed redirect destination from non-existent `'auth.login'` to `'login'`.

---

### 2.12 State-Changing Routes & LFM Containment: `routes/admin.php`
- **File:** [`routes/admin.php`](file:///c:/wamp64/www/innova-web/routes/admin.php)
- **Finding Addressed:** **SEC-04, SEC-06, SEC-11 (LFM Guarding, Login Rate Limiting & POST-Only Operations)**
- **Modification:**
  1. Added `throttle:5,1` middleware to `admin.login.post`.
  2. Converted 7 maintenance routes (`/storagelink`, `/optimize`, `/configcatche`, `/configclear`, `/viewclear`, `/cacheclear`, `/vendorpublish`) strictly to `Route::post(...)`.
  3. Converted 10 batch and student SMS dispatch routes strictly to `Route::post(...)` (no GET fallback retained).
  4. Registered `laravel-filemanager` route group explicitly under `['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth:admin']]`, mapping CKEditor calls directly to `auth:admin`-guarded endpoints.

---

### 2.13 AJAX Callers Updated with POST & CSRF: `public/backend/js/custom.js` & `backend/js/custom.js`
- **Files:** [`public/backend/js/custom.js`](file:///c:/wamp64/www/innova-web/public/backend/js/custom.js), [`backend/js/custom.js`](file:///c:/wamp64/www/innova-web/backend/js/custom.js)
- **Finding Addressed:** **SEC-11 (AJAX Caller Compatibility)**
- **Modification:** Configured global `$.ajaxSetup` with `X-CSRF-TOKEN` header and updated all 10 SMS dispatch triggers to `type: "POST"` with CSRF headers and error feedback.

---

### 2.14 Safe Ignore Rules Added: `.gitignore`
- **File:** [`.gitignore`](file:///c:/wamp64/www/innova-web/.gitignore)
- **Finding Addressed:** **SEC-01, SEC-09 (Preventing Accidental Commit of Dumps and Logs)**
- **Modification:** Added ignore rules for `*.sql`, `*.sql.gz`, `*.sqlite`, `*.log`, `error_log`, and `/config/error_log`.

---

### 2.15 Automated Security Unit Tests: `tests/Unit/SecurityHardeningUnitTest.php`
- **File:** [`tests/Unit/SecurityHardeningUnitTest.php`](file:///c:/wamp64/www/innova-web/tests/Unit/SecurityHardeningUnitTest.php)
- **Modification:** Authored 21 focused security hardening unit tests with 119 assertions (bringing total `tests/Unit/` execution to 22 tests and 120 assertions). Tests verify DB config fallback hygiene, service configs, LFM route guard containment (`auth:admin`), LFM config hardening (size, MIME, rename, no SVG), executable upload rejection, SVG XSS rejection, double extension rejection, MIME extension mismatch rejection, path traversal sanitization, valid image uploads, exception handler redirection, admin login throttling capabilities, lockout behavior, and route middleware, maintenance/SMS POST-only route restrictions with 405 status verification, bKash session validation, uncompleted bKash status rejection, and isolated SQLite in-memory bKash callback idempotency.
