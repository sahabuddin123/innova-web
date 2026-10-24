# Phase 1 Security Finding Triage and Verification Status

**Project:** `innova-web` (INNOVA Computers BD / ICBD)  
**Execution Phase:** Phase 1 — Security Hardening & Repository Remediation  
**Date:** October 23, 2026 (Updated after Final Verification Pass)  
**Branch:** `feature/phase-1-security-hardening`  
**Auditor:** Senior Laravel Security Engineer  

---

## 1. Executive Triage Summary

All twelve findings reported during Phase 0 discovery were independently inspected, verified against the active source code, remediated where in scope, and subjected to automated unit and static verification.

**Summary of Verified Status:**
- **Confirmed & Fully Remediated in Code (Phase 1):** SEC-02, SEC-03, SEC-06, SEC-08, SEC-10, SEC-11, SEC-12.
- **Confirmed & Safely Contained in Code (Phase 1 — Replacement in Phase 3/4):** SEC-04 (Disabled package auto-routes, registered `/laravel-filemanager` strictly guarded by `auth:admin`, enabled strict MIME/size validation, unique filename hashing, and prohibited SVG; full package removal deferred to Phase 3/4).
- **Confirmed & Safely Contained (Requires Owner Approval / Coordinated Infrastructure Action):** SEC-01, SEC-07, SEC-09.
- **Confirmed & Deferred to Re-Platforming (Phase 2/3 Roadmap):** SEC-05 (Complete RBAC permission database migration and role assignment).

---

## 2. Detailed Verification Matrix

### SEC-01: Sensitive Database Dump in Views Directory
- **Reported Location:** [`resources/views/admin/report/innovacomputer_pay.sql`](file:///c:/wamp64/www/innova-web/resources/views/admin/report/innovacomputer_pay.sql)
- **Status:** **Confirmed (Contained — Pending Owner Approval)**
- **Verification Evidence:** File size 1,418,240 bytes. Tracked in Git history across past commits. Contains complete MySQL dumps including table schemas, student records, and Bcrypt admin password hashes.
- **Phase 1 Remediation & Containment:**
  - Added `*.sql`, `*.sql.gz`, and `*.sqlite` to [`.gitignore`](file:///c:/wamp64/www/innova-web/.gitignore) to prevent accidental staging or new commits.
  - In accordance with safety restrictions ("Do not delete the only copy of any database dump... Do not rewrite Git history, force-push, or delete branches"), the file was quarantined and not purged during Phase 1.
  - A step-by-step history purge procedure (`git-filter-repo`) is detailed in `owner-actions-required.md` for execution during an approved maintenance window.

---

### SEC-02: Hardcoded Production Credentials in Configuration Fallbacks
- **Reported Location:** [`config/database.php:51-53`](file:///c:/wamp64/www/innova-web/config/database.php#L51-L53)
- **Status:** **Confirmed & Fully Remediated**
- **Verification Evidence:** Production database name and passwords were hardcoded as fallback arguments when `.env` was omitted.
- **Phase 1 Remediation:** Replaced live credentials with safe standard placeholders (`'forge'`, `''`). Application configuration now strictly relies on `.env`. Tested via PHPUnit assertions ensuring production database names are absent.

---

### SEC-03: Unrestricted Arbitrary File Upload & Stored SVG XSS
- **Reported Location:** [`app/Http/Controllers/Admin/SettingController.php:34-37`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/SettingController.php#L34-L37) and [`app/Traits/UploadAble.php:28-36`](file:///c:/wamp64/www/innova-web/app/Traits/UploadAble.php#L28-L36)
- **Status:** **Confirmed & Fully Remediated**
- **Verification Evidence:** `SettingController@update` lacked server-side MIME and size validation for logo and favicon. `UploadAble::uploadOne()` relied on `$file->getClientOriginalExtension()`. Furthermore, allowing SVG uploads exposed the application to Stored Cross-Site Scripting (XSS) via embedded `<script>` or event attributes.
- **Phase 1 Remediation:**
  1. Added strict validation rules in `SettingController`: `'site_logo' => 'nullable|file|image|mimes:jpeg,png,jpg,gif,webp|max:2048'` and `'site_favicon' => 'nullable|file|mimes:ico,png,jpg|max:512'`.
  2. **Disabled SVG Uploads:** SVG has been explicitly removed from allowed MIME types and added to the `$blockedExtensions` list in `UploadAble` trait until a dedicated XML/SVG sanitizer (e.g. `enshrined/svg-sanitize`) can be installed.
  3. Sanitized filenames using server-detected extensions (`guessExtension()`) and enforced a comprehensive blacklist blocking executable files (`php`, `phtml`, `phar`, `exe`, `sh`, `bat`, `cmd`, `js`, `html`, `svg`).
  4. Tested with 8 malicious file types and SVG payloads; all were rejected with `\InvalidArgumentException`.

---

### SEC-04: Vulnerable Legacy UniSharp Laravel Filemanager
- **Reported Location:** [`config/lfm.php`](file:///c:/wamp64/www/innova-web/config/lfm.php), [`composer.json:24`](file:///c:/wamp64/www/innova-web/composer.json#L24), [`composer.lock:5680`](file:///c:/wamp64/www/innova-web/composer.lock#L5680), [`routes/admin.php:600-602`](file:///c:/wamp64/www/innova-web/routes/admin.php#L600-L602)
- **Status:** **Confirmed & Safely Contained in Code (Package Removal Deferred to Phase 3/4)**
- **Verification Evidence:**
  1. **Locked Version:** `composer.lock` confirms `unisharp/laravel-filemanager` is locked at version `v2.6.3` (commit `3bf53c9`).
  2. **Vulnerability:** Known `CVE-2024-21546` (High/Critical) permits arbitrary file upload and path traversal leading to Remote Code Execution (RCE) via improper sanitization of file paths and types.
  3. **Previous Package Route Exposure:** `LaravelFilemanagerServiceProvider` previously auto-registered `/filemanager` using middleware `['web', 'auth']` (which defaulted to `web` user guard rather than `admin`, exposing it to frontend students while 404ing admin CKEditor calls).
  4. **Active UI Call Sites:** Integrated into CKEditor instances in 4 administrative Blade templates calling `/laravel-filemanager`:
     - [`resources/views/admin/blogs/create.blade.php:100-103`](file:///c:/wamp64/www/innova-web/resources/views/admin/blogs/create.blade.php#L100-L103)
     - [`resources/views/admin/blogs/edit.blade.php:118-121`](file:///c:/wamp64/www/innova-web/resources/views/admin/blogs/edit.blade.php#L118-L121)
     - [`resources/views/admin/courses/create.blade.php:148-151`](file:///c:/wamp64/www/innova-web/resources/views/admin/courses/create.blade.php#L148-L151)
     - [`resources/views/admin/courses/edit.blade.php:161-164`](file:///c:/wamp64/www/innova-web/resources/views/admin/courses/edit.blade.php#L161-L164)
- **Phase 1 Remediation & Code Containment Implemented:**
  1. **Disabled Auto-Routes:** Set `'use_package_routes' => false` in `config/lfm.php` to prevent the package from exposing unprotected routes under the default user guard.
  2. **Explicit Admin Guard:** Registered `\UniSharp\LaravelFilemanager\Lfm::routes()` in `routes/admin.php` under prefix `'laravel-filemanager'` with middleware `['web', 'auth:admin']`. Non-admin users are strictly blocked.
  3. **Preserved CKEditor Integration:** Mapped endpoints to the exact prefix (`/laravel-filemanager`) called by the 4 Blade views, restoring intended admin functionality.
  4. **Strict Validation Enabled:** Set `'should_validate_mime' => true` and `'should_validate_size' => true` in `config/lfm.php`.
  5. **Neutralized Path Traversal & SVG XSS:** Set `'rename_file' => true`, `'alphanumeric_filename' => true`, `'alphanumeric_directory' => true`, and stripped `'image/svg+xml'` from both `'valid_image_mimetypes'` and `'valid_file_mimetypes'`.
  6. Verified via automated unit tests (`test_filemanager_routes_are_strictly_guarded_by_admin_middleware`, `test_filemanager_configuration_has_strict_validation_and_no_svg`).
- **Phase 3/4 Replacement Plan:** Replace package with Spatie MediaLibrary or native Laravel upload controllers paired with CKEditor SimpleUploadAdapter; remove `unisharp/laravel-filemanager` from `composer.json`.

---

### SEC-05: Missing RBAC Authorization Checks on Admin Controllers
- **Reported Location:** [`app/Http/Controllers/Admin/*`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/), [`routes/admin.php:24`](file:///c:/wamp64/www/innova-web/routes/admin.php#L24)
- **Status:** **Audited & Quantified (Deferred to Phase 2/3 Roadmap — Blind Addition Blocked)**
- **Audit Findings & Evidence:**
  1. Only 1 of 49 Admin Controllers ([`RoleController.php`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/RoleController.php)) enforces Spatie permission middleware (`permission:role-list|role-create|role-edit|role-delete`).
  2. All other 48 Admin Controllers rely solely on authentication middleware `auth:admin`. Any authenticated administrative user (regardless of specific role) has unconstrained access to financial ledgers, settings, and user administration.
  3. Database seeders ([`PermissionTableSeeder.php`](file:///c:/wamp64/www/innova-web/database/seeds/PermissionTableSeeder.php)) define permissions for only 14 legacy entities (53 permissions). Modules developed later (`bank_loans`, `emi_installments`, `incomes`, `assets`, `cms`, `shareholders`, `settings`) have ZERO permission records defined in the codebase.
  4. Blade authorization checks (`@can`) exist only in 3 views (`admins/index`, `roles/index`, `users/index`).
  5. **Safety Gate Decision:** Blindly adding `$this->middleware('permission:...')` across controllers without verified production role-permission assignments would immediately break administrative workflows and lock out legitimate administrators.

#### Controller & Route Group Authorization Matrix

| Controller / Route Group | Auth Middleware | Existing Authorization | Server-Side Enforced? | Missing Permission Checks | Risk Rating | Recommended Safe Fix |
|---|---|---|---|---|---|---|
| **Role Management** ([`RoleController`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/RoleController.php)) | `auth:admin` | `$this->middleware('permission:role-*')` | **Yes** | None | Low | Preserved as-is. |
| **System Settings** ([`SettingController`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/SettingController.php)) | `auth:admin` | None | **No** | `setting-view`, `setting-edit` | Critical | Introduce `setting-*` permissions in Phase 2/3; restrict to Super Admin. |
| **Fees & Payments Ledger** ([`FeesTransectionsController`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/FeesTransectionsController.php)) | `auth:admin` | None | **No** | `fees-list`, `fees-create`, `fees-edit`, `fees-delete` | Critical | Seed permissions and apply middleware in Phase 2/3. |
| **Admin User Accounts** ([`UserController`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/UserController.php)) | `auth:admin` | None | **No** | `admin-list`, `admin-create`, `admin-edit`, `admin-delete` | Critical | Connect existing seeded permissions in Phase 2/3. |
| **Portal Users / Students** ([`UsersController`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/UsersController.php)) | `auth:admin` | None | **No** | `user-list`, `user-create`, `user-edit`, `user-delete` | High | Connect existing seeded permissions in Phase 2/3. |
| **Banking & Loans** ([`BankLoanController`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/BankLoanController.php)) | `auth:admin` | None | **No** | `bankloan-list`, `bankloan-manage` | High | Define new permissions in Phase 2/3 seeder. |
| **EMI Installments** ([`EmiInstallmentController`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/EmiInstallmentController.php)) | `auth:admin` | Commented out (`// $this->middleware(...)`) | **No** | `emi-list`, `emi-create`, `emi-edit` | High | Define and seed permissions in Phase 2/3. |
| **Capital Investments** ([`InvesmentsController`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/InvesmentsController.php)) | `auth:admin` | None | **No** | `investment-list`, `investment-manage` | Critical | Define and seed permissions in Phase 2/3. |
| **Investment Withdrawals** ([`InvestmentWithdrawController`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/InvestmentWithdrawController.php)) | `auth:admin` | None | **No** | `investment-withdraw` | Critical | Restrict to Super Admin in Phase 2/3. |
| **Dividend Withdrawals** ([`DividendWithdrawController`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/DividendWithdrawController.php)) | `auth:admin` | None | **No** | `dividend-withdraw` | Critical | Restrict to Super Admin in Phase 2/3. |
| **Incomes & Categories** ([`IncomeController`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/IncomeController.php), `IncomeCategorisController`) | `auth:admin` | None | **No** | `income-list`, `income-manage` | High | Define and seed permissions in Phase 2/3. |
| **Expenses & Categories** ([`ExpanseController`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/ExpanseController.php), `ExpanseCategorisController`) | `auth:admin` | None | **No** | `expanse-list`, `expanse-create`, `expanse-edit` | High | Connect existing seeded permissions in Phase 2/3. |
| **Academic Certificates** ([`CertificateController`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/CertificateController.php), `CertificateICBDController`) | `auth:admin` | None | **No** | `certificate-issue`, `certificate-edit` | High | Define new permissions in Phase 2/3 seeder. |
| **Students & Admissions** ([`StudentsController`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/StudentsController.php), `AdmissionController`, `StudentManagementController`) | `auth:admin` | None | **No** | `student-list`, `student-create`, `student-edit` | High | Connect existing seeded permissions in Phase 2/3. |
| **Batches & Sessions** ([`BatchsController`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/BatchsController.php), `SessionController`) | `auth:admin` | None | **No** | `batch-list`, `session-list`, etc. | Medium | Connect existing seeded permissions in Phase 2/3. |
| **Courses & Categories** ([`CourseController`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/CourseController.php), `CoursesController`, `CourseCategoryController`) | `auth:admin` | None | **No** | `course-list`, `course-create`, `course-edit` | Medium | Connect existing seeded permissions in Phase 2/3. |
| **SMS Gateway Broadcasts** ([`SMSController`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/SMSController.php)) | `auth:admin` | None | **No** | `sms-broadcast`, `sms-log` | High | Define permissions and restrict in Phase 2/3. |
| **Content Management** (`BlogController`, `GalleryController`, `SliderController`, `SuccessStoryController`) | `auth:admin` | None | **No** | `content-manage`, `slider-manage` | Low-Med | Connect existing seeded permissions in Phase 2/3. |
| **Maintenance Route Endpoints** (`/storagelink`, `/optimize`, `/configclear`, etc.) | `auth:admin` | POST method + CSRF enforced | **No** (any admin) | `system-maintenance` | High | Restrict to Super Admin in Phase 2/3. |

---

### SEC-06: Missing Admin Login Brute-Force Rate Limiting
- **Reported Location:** [`app/Http/Controllers/Admin/LoginController.php:43-56`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/LoginController.php#L43-L56), [`routes/admin.php:10`](file:///c:/wamp64/www/innova-web/routes/admin.php#L10)
- **Status:** **Confirmed & Fully Remediated**
- **Verification Evidence:** The controller imported `AuthenticatesUsers` but overrode `login(Request $request)` without calling `hasTooManyLoginAttempts($request)` or `incrementLoginAttempts($request)`.
- **Phase 1 Remediation:** Restored `ThrottlesLogins` check, increment, and lockout dispatching in `Admin/LoginController@login`. Added `throttle:5,1` middleware to `admin.login.post` route. Verified via automated unit tests.

---

### SEC-07: Repository-Root Web Exposure (Dual Web Root)
- **Reported Location:** Root [`index.php`](file:///c:/wamp64/www/innova-web/index.php) and duplicate asset directories (`backend/`, `frontend/`, `css/`, `js/`)
- **Status:** **Confirmed (Contained — Pending Web Server VirtualHost Configuration)**
- **Verification Evidence:** `config/error_log` revealed absolute paths executing directly inside `/home/innovacomputer/public_html/config/cache.php`, proving the production web root pointed to the repository root.
- **Phase 1 Action:** Preserved root assets to prevent broken local environments. Documented required VPS Apache/Nginx configuration change (`DocumentRoot "/home/innovacomputer/public_html/public"`) in `owner-actions-required.md`.

---

### SEC-08: bKash Callback Replay & Concurrent Race Condition
- **Reported Location:** [`app/Http/Controllers/BkashController.php:174-256`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/BkashController.php#L174-L256)
- **Status:** **Confirmed & Fully Remediated in Application Logic (Database Schema Prerequisite Pending Phase 2)**
- **Verification Evidence:** `GET /user/success` read session state without validating gateway payment state or transaction status, and inserted financial records without distributed or database locking, allowing page refreshes or concurrent callback hits to create duplicate payment records.
- **Phase 1 Remediation:**
  1. **Gateway State Verification:** Enforced strict check requiring non-empty `$arr['transactionStatus']` equal to `'Completed'` (case-insensitive) and `$arr['errorCode'] === '0000'`. Malformed or non-completed transactions are immediately rejected with an error redirect and zero fee records created.
  2. **Application-Level Distributed Locking:** Enforced atomic locking via `Cache::lock('bkash_payment_trx_' . $trxId, 15)`. Concurrent callbacks with identical `trxID` are serialized. The lock is released inside a `finally` block to prevent deadlocks.
  3. **Atomic Database Transaction & Collision Catching:** Wrapped fee insertion inside `DB::transaction()` with pre-insert existence check and graceful recovery from `\Illuminate\Database\QueryException` to handle race condition collisions.
  4. **Session Cleansing:** Purged transient payment keys (`paymentID`, `arr`) from the user session immediately upon recording to prevent replay attacks.
  5. **Config Isolation:** Replaced direct `env()` lookups with `config('services.bkash.*')`.
- **Concurrency & Database Schema Prerequisite (Phase 2):**
  - Verification on SQLite in-memory test fixtures confirmed that duplicate callbacks produce exactly 1 fee transaction.
  - **Important Distinction:** In a multi-worker production MySQL environment, application locks guard against race conditions, but absolute database-engine-level concurrency guarantees require a `UNIQUE` index on `fees_transections.trxID`.
  - Inspection of `database/migrations/2022_08_17_205522_create_fees_transections_table.php` revealed that `trxID` was added outside versioned Laravel migrations. In strict compliance with Phase 1 rules (prohibiting production database mutations), this schema change is documented as a prerequisite for the Phase 2 database migration phase.

---

### SEC-09: Committed Error Logs Leaking Infrastructure Paths
- **Reported Location:** [`config/error_log`](file:///c:/wamp64/www/innova-web/config/error_log)
- **Status:** **Confirmed (Contained — Pending Owner Approval)**
- **Verification Evidence:** 4,206-byte error log committed in Git history leaking server directory structures.
- **Phase 1 Action:** Added `*.log`, `error_log`, and `/config/error_log` to `.gitignore`. File retained in working tree per prompt constraints until owner approves untracking and repository history sanitize.

---

### SEC-10: Disabled TLS Peer Verification in SMS Gateways
- **Reported Location:**
  - [`SMSController.php:32`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/SMSController.php#L32)
  - [`FeesTransectionsController.php:295`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/FeesTransectionsController.php#L295)
  - [`UsersController.php:179`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/UsersController.php#L179)
- **Status:** **Confirmed & Fully Remediated**
- **Verification Evidence:** All three call sites explicitly set `curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);`.
- **Phase 1 Remediation:** Restored `CURLOPT_SSL_VERIFYPEER => true` and `CURLOPT_SSL_VERIFYHOST => 2` across all outbound curl calls. Migrated credentials to `config('services.sms.*')`.

---

### SEC-11: State-Changing Operations on HTTP GET Routes
- **Reported Location:** [`routes/admin.php:31-58, 185-189, 203-207`](file:///c:/wamp64/www/innova-web/routes/admin.php#L31-L58), [`public/backend/js/custom.js`](file:///c:/wamp64/www/innova-web/public/backend/js/custom.js)
- **Status:** **Confirmed & Fully Remediated**
- **Verification Evidence:** Maintenance artisan commands (`storagelink`, `optimize`, `configcatche`, `configclear`, `viewclear`, `cacheclear`, `vendorpublish`) and 10 batch/student SMS dispatch routes were mapped to GET verbs without CSRF validation.
- **Phase 1 Remediation:**
  1. Converted all 7 maintenance routes strictly to `Route::post(...)` with named routes.
  2. Converted all 10 batch and student SMS dispatch routes strictly to `Route::post(...)` (no GET fallback retained).
  3. Updated `public/backend/js/custom.js` and `backend/js/custom.js` to configure global `$.ajaxSetup` with CSRF token header and updated all 10 jQuery AJAX callers to use `type: "POST"` with CSRF headers and error feedback.
  4. Verified route method restrictions (POST-only) via automated unit tests.

---

### SEC-12: Undefined Route Reference in Exception Handler
- **Reported Location:** [`app/Exceptions/Handler.php:78`](file:///c:/wamp64/www/innova-web/app/Exceptions/Handler.php#L78)
- **Status:** **Confirmed & Fully Remediated**
- **Verification Evidence:** `unauthenticated()` redirected to undefined route `'auth.login'`.
- **Phase 1 Remediation:** Corrected route to `'login'`. Verified via automated unit tests.
