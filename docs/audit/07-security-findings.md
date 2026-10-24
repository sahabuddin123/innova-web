# 07. Security Findings and Vulnerability Assessment

**Project:** `innova-web` (INNOVA Computers BD / ICBD)  
**Audit Date:** October 13, 2026  
**Auditor:** Antigravity Agentic Audit (Phase 0 Discovery)  
**Strict Constraint:** Read-Only Audit (No code/configuration/data changes made; all secret values strictly redacted)

---

## 1. Vulnerability Summary Dashboard

| Finding ID | Title | Severity | CVSS v3.1 | Status |
|---|---|---|---|---|
| **SEC-01** | Production Database Dump Stored in Views Directory | **CRITICAL** | 9.8 (Critical) | Confirmed Unprotected |
| **SEC-02** | Hardcoded Live Production Database Credentials | **CRITICAL** | 9.1 (Critical) | Confirmed in Git |
| **SEC-03** | Unrestricted File Upload to Storage (RCE Risk) | **HIGH** | 8.8 (High) | Confirmed in Code |
| **SEC-04** | Known Remote Code Execution in UniSharp Filemanager | **HIGH** | 8.8 (High) | Confirmed Dependency |
| **SEC-05** | Missing RBAC Authorization across 48 Admin Controllers | **HIGH** | 8.1 (High) | Confirmed in Code |
| **SEC-06** | Missing Brute-Force Login Throttling on Admin Portal | **HIGH** | 7.5 (High) | Confirmed in Code |
| **SEC-07** | Sensitive Server Paths Leaked in Committed Error Logs | **MEDIUM** | 5.3 (Medium) | Confirmed in Git |
| **SEC-08** | SSL Peer Certificate Verification Disabled in SMS cURL | **MEDIUM** | 5.9 (Medium) | Confirmed in Code |
| **SEC-09** | Application Crash & Integration Failure on Config Caching | **MEDIUM** | 5.3 (Medium) | Confirmed in Code |
| **SEC-10** | State-Changing Mutations & Deletions via HTTP GET | **MEDIUM** | 6.5 (Medium) | Confirmed in Routes |
| **SEC-11** | Unhashed Plaintext API Token Storage Driver | **LOW** | 3.8 (Low) | Confirmed in Config |
| **SEC-12** | End-of-Life Framework and Abandoned Open-Source Packages | **LOW** | 3.7 (Low) | Confirmed in Composer/NPM |

---

## 2. Detailed Vulnerability Dossiers

### SEC-01: Production Database Dump Stored in Views Directory
- **Severity:** **CRITICAL** (CVSS:3.1/AV:N/AC:L/PR:N/UI:N/S:U/C:H/I:H/A:N — Score: 9.8)
- **Affected File:** [`resources/views/admin/report/innovacomputer_pay.sql`](file:///c:/wamp64/www/innova-web/resources/views/admin/report/innovacomputer_pay.sql)
- **File Size:** 1,398,532 Bytes (1.4 MB, 5,045 lines)
- **Evidence / Mechanism:**
  The repository contains an unencrypted full MySQL dump generated via phpMyAdmin on February 21, 2024.
  - Contains full schemas and data tuples for 25 tables.
  - Exposes 6 administrative accounts, their real names, emails, and Bcrypt password hashes.
  - Exposes 335 student profiles, personal mobile numbers, guardian numbers, addresses, and fees.
  - Exposes 706 financial fee transaction logs, bKash transaction identifiers, and amounts.
- **Potential Impact:**
  Complete loss of student and institutional confidentiality. If an attacker identifies the directory path via directory fuzzing or if `.htaccess` misconfiguration exposes the repository root, the entire production database can be downloaded without authentication.
- **Remediation:**
  1. Immediately delete `resources/views/admin/report/innovacomputer_pay.sql` from the file system.
  2. Purge the file from Git commit history using `git-filter-repo` or BFG Repo-Cleaner.
  3. Rotate all administrative passwords and notify affected stakeholders if previously exposed.

---

### SEC-02: Hardcoded Live Production Database Credentials
- **Severity:** **CRITICAL** (CVSS:3.1/AV:N/AC:L/PR:N/UI:N/S:U/C:H/I:H/A:N — Score: 9.1)
- **Affected Location:** [`config/database.php:L51-53`](file:///c:/wamp64/www/innova-web/config/database.php#L51-L53)
- **Evidence / Mechanism:**
  ```php
  'database' => env('DB_DATABASE', '[REDACTED_LIVE_DB_NAME]'),
  'username' => env('DB_USERNAME', '[REDACTED_LIVE_DB_USER]'),
  'password' => env('DB_PASSWORD', '[REDACTED_LIVE_DB_PASSWORD]'),
  ```
  Instead of generic local fallbacks (`'forge'`, `'root'`, `''`), the production database credentials for the live cPanel/MariaDB instance were hardcoded into the fallback arguments of `env()`.
- **Potential Impact:**
  Any individual with read access to the Git repository can obtain the production database credentials. If the production database server allows external MySQL connections (`3306`), an attacker can connect directly and exfiltrate or wipe the database.
- **Remediation:**
  1. Replace hardcoded default values in `config/database.php` with safe local placeholders (`'forge'`, `'root'`, `''`).
  2. Immediately rotate the password for user `[REDACTED_LIVE_DB_USER]` on the live MySQL server.

---

### SEC-03: Unrestricted File Upload to Storage (RCE Risk)
- **Severity:** **HIGH** (CVSS:3.1/AV:N/AC:L/PR:H/UI:N/S:U/C:H/I:H/A:H — Score: 8.8)
- **Affected Locations:**
  - [`app/Http/Controllers/Admin/SettingController.php:L35-50`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/SettingController.php#L35-L50)
  - [`app/Traits/UploadAble.php:L21-30`](file:///c:/wamp64/www/innova-web/app/Traits/UploadAble.php#L21-L30)
  - [`.htaccess:L9-12`](file:///c:/wamp64/www/innova-web/.htaccess#L9-L12)
- **Evidence / Mechanism:**
  `SettingController::update()` accepts `site_logo` and `site_favicon` without validating MIME types, extensions, or file sizes.
  `UploadAble::uploadOne()` uses `$file->getClientOriginalExtension()` without sanitization.
  The root `.htaccess` explicitly allows PHP script execution:
  ```apache
  <FilesMatch ".(php7|phtml|php)$">
  Order allow,deny
  Allow from all
  </FilesMatch>
  ```
- **Potential Impact:**
  An attacker with administrative portal access can upload a file named `payload.php` disguised as a logo. The file is written to public storage, allowing the attacker to execute arbitrary PHP code on the server host.
- **Remediation:**
  1. Add strict validation rules in `SettingController`:
     ```php
     $request->validate([
         'site_logo' => 'nullable|image|mimes:png,jpg,jpeg,webp,svg|max:2048',
         'site_favicon' => 'nullable|file|mimes:png,ico|max:512',
     ]);
     ```
  2. Generate randomized extensions or verify file MIME types server-side using `finfo` or Laravel's `extension()` rather than client-reported original extensions.
  3. Deny execution of PHP scripts in `storage/` and `public/uploads/` via web server configuration.

---

### SEC-04: Known Remote Code Execution in UniSharp Filemanager
- **Severity:** **HIGH** (CVSS:3.1/AV:N/AC:L/PR:L/UI:N/S:U/C:H/I:H/A:H — Score: 8.8)
- **Affected Location:** [`composer.json:L24`](file:///c:/wamp64/www/innova-web/composer.json#L24) (`"unisharp/laravel-filemanager": "^2.5"`)
- **Evidence / Mechanism:**
  The project depends on UniSharp Laravel Filemanager `<2.9.1`, which contains known public security vulnerabilities:
  - `CVE-2024-21546`: Code Injection vulnerability allowing authenticated users to inject and execute arbitrary server-side code.
  - `CVE-2022-40734`: Directory traversal allowing file operations outside permitted directories.
- **Potential Impact:**
  Exploitation permits unauthorized remote code execution and arbitrary file reads on the server.
- **Remediation:**
  Remove the abandoned `unisharp/laravel-filemanager` package and replace it with a maintained, modern media management abstraction (e.g., Spatie Media Library).

---

### SEC-05: Missing RBAC Authorization across 48 Administrative Controllers
- **Severity:** **HIGH** (CVSS:3.1/AV:N/AC:L/PR:L/UI:N/S:U/C:H/I:H/A:N — Score: 8.1)
- **Affected Location:** `app/Http/Controllers/Admin/*.php` (48 of 49 admin controllers)
- **Evidence / Mechanism:**
  While `spatie/laravel-permission` is installed and 55 permissions exist, permission middleware is only registered in [`Admin\RoleController.php`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/RoleController.php). All other administrative routes are protected solely by `auth:admin`.
- **Potential Impact:**
  Any authenticated staff member with low-privilege access can view, edit, or delete student financial balances, fee receipts, company expenses, shareholder equity, and employee records.
- **Remediation:**
  Implement permission middleware across all administrative controllers (e.g., `$this->middleware('permission:student-delete', ['only' => ['delete']])`) or implement Laravel Policy classes.

---

### SEC-06: Missing Brute-Force Login Throttling on Admin Portal
- **Severity:** **HIGH** (CVSS:3.1/AV:N/AC:L/PR:N/UI:N/S:U/C:H/I:N/A:N — Score: 7.5)
- **Affected Location:** [`app/Http/Controllers/Admin/LoginController.php:L43-56`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/LoginController.php#L43-L56)
- **Evidence / Mechanism:**
  The `login()` method overrides Laravel's standard authentication trait without integrating `ThrottlesLogins`. No rate limiting is applied to requests targeting `POST /admin/login`.
- **Potential Impact:**
  Attackers can perform high-speed credential stuffing and dictionary attacks against administrative accounts without account lockout or latency penalties.
- **Remediation:**
  Integrate the `ThrottlesLogins` trait and call `hasTooManyLoginAttempts($request)` and `incrementLoginAttempts($request)` in the login method.

---

### SEC-07: Sensitive Server Paths Leaked in Committed Error Logs
- **Severity:** **MEDIUM** (CVSS:3.1/AV:N/AC:L/PR:N/UI:N/S:U/C:L/I:N/A:N — Score: 5.3)
- **Affected Files:**
  - [`app/Repositories/error_log`](file:///c:/wamp64/www/innova-web/app/Repositories/error_log)
  - [`config/error_log`](file:///c:/wamp64/www/innova-web/config/error_log)
- **Evidence / Mechanism:**
  Unfiltered PHP runtime error logs committed to Git contain internal production server paths:
  `/home/sahabriyaj/innovacomputersbd.com/` and `/home/homearta/innovacomputersbd.com/`.
- **Potential Impact:**
  Provides attackers with internal filesystem path topology, assisting in path traversal and LFI exploitation.
- **Remediation:**
  Delete both `error_log` files from the repository and add `*error_log*` to `.gitignore`.

---

### SEC-08: SSL Peer Certificate Verification Disabled in SMS cURL
- **Severity:** **MEDIUM** (CVSS:3.1/AV:N/AC:H/PR:N/UI:N/S:U/C:H/I:L/A:N — Score: 5.9)
- **Affected Location:** [`app/Http/Controllers/Admin/SMSController.php:L32`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/SMSController.php#L32)
- **Evidence / Mechanism:**
  `curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);`
- **Potential Impact:**
  Disabling SSL verification allows an active Man-in-the-Middle (MitM) attacker on the network route to intercept SMS payloads (containing student names, phones, and payment details) and steal the `SMS_API_KEY`.
- **Remediation:**
  Set `CURLOPT_SSL_VERIFYPEER => true` and verify that the operating system has an up-to-date CA certificate bundle (`cacert.pem`).

---

### SEC-09: Application Crash & Integration Failure on Config Caching
- **Severity:** **MEDIUM** (CVSS:3.1/AV:N/AC:L/PR:H/UI:N/S:U/C:N/I:N/A:H — Score: 5.3)
- **Affected Locations:**
  - [`BkashController.php:L30, L67-68, L72`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/BkashController.php#L30)
  - [`SMSController.php:L19-24`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/SMSController.php#L19-L24)
  - [`FeesTransectionsController.php:L283-285`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/FeesTransectionsController.php#L283-L285)
  - [`routes/admin.php:L37`](file:///c:/wamp64/www/innova-web/routes/admin.php#L37)
- **Evidence / Mechanism:**
  In Laravel production deployments, `php artisan config:cache` is a standard optimization. When run, `env()` returns `null` outside `config/` files. Calling `env('BKASH_CHECKOUT_APP_KEY')` directly in controllers returns `null`, crashing all payment and SMS integrations.
- **Potential Impact:**
  Denial of Service for all student online payments and automated SMS alerts whenever configuration caching is performed.
- **Remediation:**
  Define all bKash and SMS configurations inside [`config/services.php`](file:///c:/wamp64/www/innova-web/config/services.php) and consume them via `config('services.bkash.app_key')`.

---

### SEC-10: State-Changing Mutations & Deletions via HTTP GET
- **Severity:** **MEDIUM** (CVSS:3.1/AV:N/AC:L/PR:L/UI:R/S:U/C:N/I:H/A:L — Score: 6.5)
- **Affected Locations:**
  - [`routes/admin.php:L31-51`](file:///c:/wamp64/www/innova-web/routes/admin.php#L31-L51)
  - [`routes/web.php:L103`](file:///c:/wamp64/www/innova-web/routes/web.php#L103)
  - [`app/Http/Controllers/Admin/admin.php:L46, L58, L72, L97`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/admin.php#L46)
- **Evidence / Mechanism:**
  Administrative artisan commands (`/admin/storagelink`, `/admin/optimize`, `/admin/configcatche`) and student payment processing (`/user/success`) are mapped to HTTP `GET` verbs without CSRF token validation.
- **Potential Impact:**
  Browser pre-fetching, web crawlers, or cross-site image tags (`<img src="/admin/configcatche">`) can trigger unintended system reconfiguration or duplicate fee records.
- **Remediation:**
  Convert all state-altering endpoints to HTTP `POST` or `DELETE` verbs protected with CSRF tokens.

---

### SEC-11: Unhashed Plaintext API Token Storage Driver
- **Severity:** **LOW** (CVSS:3.1/AV:N/AC:H/PR:H/UI:N/S:U/C:L/I:N/A:N — Score: 3.8)
- **Affected Location:** [`config/auth.php:L47, L58`](file:///c:/wamp64/www/innova-web/config/auth.php#L47)
- **Evidence / Mechanism:**
  The `api` and `admin-api` guards specify `'hash' => false`.
- **Potential Impact:**
  If API tokens are generated and stored, any SQL injection or database read leak exposes raw valid API tokens immediately without requiring hash cracking.
- **Remediation:**
  Set `'hash' => true` or replace the legacy token driver with Laravel Sanctum.

---

### SEC-12: End-of-Life Framework and Abandoned Open-Source Packages
- **Severity:** **LOW** (CVSS:3.1/AV:N/AC:H/PR:N/UI:N/S:U/C:L/I:N/A:N — Score: 3.7)
- **Affected Locations:** [`composer.json`](file:///c:/wamp64/www/innova-web/composer.json), [`package.json`](file:///c:/wamp64/www/innova-web/package.json)
- **Evidence / Mechanism:**
  - Laravel 8.83.29 (EOL January 2023)
  - Vue 2.5.17 (EOL December 2023)
  - Abandoned packages: `swiftmailer/swiftmailer`, `laravelcollective/html`, `fzaninotto/faker`, `biscolab/laravel-recaptcha`.
- **Potential Impact:**
  No upstream security patches are provided for future vulnerabilities discovered in core framework components.
- **Remediation:**
  Execute a planned framework upgrade to a supported LTS release (Laravel 10 / 11) and modern frontend tooling.
