# Phase 1 Preflight and Change Safety Report

**Project:** `innova-web` (INNOVA Computers BD / ICBD)  
**Execution Phase:** Phase 1 — Security Hardening & Repository Remediation  
**Date:** October 23, 2026  
**Auditor:** Senior Laravel Security Engineer  

---

## 1. Git Environment and Working Tree Status

Prior to inspecting or modifying any application code, preflight repository inspection was conducted:

- **Initial Git Status:** Clean on tracked files.
  - Branch: `main` (synchronized with `origin/main`).
  - Untracked files present: Documentation (`docs/`), temporary view caches in `storage/framework/views/`, and `package-lock.json`.
- **Change Safety Isolation:**
  - In accordance with safety rules, a dedicated isolated working branch was created:
    ```bash
    git checkout -b feature/phase-1-security-hardening
    ```
  - All Phase 1 remediation activities are strictly confined to `feature/phase-1-security-hardening`.
  - The `main` branch remains untouched.
  - No Git history rewriting, force-pushing, or destructive Git operations will be performed.

---

## 2. Planned Remediation Files and Scope

The following targeted files are identified for safe, in-scope security hardening:

| File Target | Proposed Security Fix | Risk Assessment | Mitigation / Safety Strategy |
|---|---|---|---|
| [`config/database.php`](file:///c:/wamp64/www/innova-web/config/database.php) | **SEC-02:** Remove hardcoded live database fallback credentials (`satebwwt_icbdpayments`). | Low | Use standard safe placeholders (`'forge'`, `''`). Does not alter `.env` or valid database connections. |
| [`config/services.php`](file:///c:/wamp64/www/innova-web/config/services.php) | **SEC-08 / SEC-10:** Add structured configuration entries for `bkash` and `sms` services. | Low | Pure configuration additions. Enables environment-backed lookups and prevents `config:cache` crashes. |
| [`app/Traits/UploadAble.php`](file:///c:/wamp64/www/innova-web/app/Traits/UploadAble.php) | **SEC-03:** Sanitize file extensions and block executable extensions (`php`, `phtml`, `phar`, `exe`, `sh`, etc.) using server-verified extension guessing. | Medium | Preserve legitimate file uploads across all 19 repository upload call sites. |
| [`app/Http/Controllers/Admin/SettingController.php`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/SettingController.php) | **SEC-03:** Add server-side validation rules for `site_logo` and `site_favicon` uploads. | Low | Whitelist valid image and icon MIME types; restrict file sizes. Preserve legitimate logo/favicon updates. |
| [`app/Http/Controllers/Admin/LoginController.php`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/LoginController.php) | **SEC-06:** Restore `ThrottlesLogins` rate limiting in overridden `login()` method. | Low | Prevents automated brute-force attacks; preserves valid admin login functionality. |
| [`app/Http/Controllers/Admin/SMSController.php`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/SMSController.php) | **SEC-10:** Restore TLS peer verification (`CURLOPT_SSL_VERIFYPEER => true`, `CURLOPT_SSL_VERIFYHOST => 2`); use `config('services.sms.*')`. | Low | Secures outbound HTTP requests against MITM tampering. Does not trigger live SMS during testing. |
| [`app/Http/Controllers/Admin/FeesTransectionsController.php`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/FeesTransectionsController.php) | **SEC-10:** Restore TLS peer verification in SMS helper; use `config('services.sms.*')`. | Low | Consistent outbound TLS verification across fee transactions. |
| [`app/Http/Controllers/Admin/UsersController.php`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/UsersController.php) | **SEC-10:** Restore TLS peer verification in user account creation SMS helper; use `config('services.sms.*')`. | Low | Consistent outbound TLS verification across user portal dispatches. |
| [`app/Http/Controllers/BkashController.php`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/BkashController.php) | **SEC-08:** Add transaction idempotency check on `trxID` in `success()`; guard against null sessions; use `config('services.bkash.*')`. | Medium | Eliminates duplicate payment insertion on browser refresh; eliminates crash when session expires. |
| [`app/Exceptions/Handler.php`](file:///c:/wamp64/www/innova-web/app/Exceptions/Handler.php) | **SEC-12:** Correct unauthenticated route name from non-existent `'auth.login'` to `'login'`. | Low | Prevents `RouteNotFoundException` when unauthenticated users access guarded routes. |
| [`config/lfm.php`](file:///c:/wamp64/www/innova-web/config/lfm.php) | **SEC-04:** Disable package auto-routes, activate MIME/size checks, hash filenames, and prohibit SVG. | Low | Prevents unauthenticated access,Stored XSS, and directory traversal. |
| [`routes/admin.php`](file:///c:/wamp64/www/innova-web/routes/admin.php) | **SEC-04 / SEC-11:** Add POST method support and rate limiting on sensitive endpoints; guard `/laravel-filemanager` with `auth:admin`. | Medium | Preserves backwards compatibility with existing AJAX calls while enabling secure POST with CSRF and restricting LFM. |
| [`public/backend/js/custom.js`](file:///c:/wamp64/www/innova-web/public/backend/js/custom.js) | **SEC-11:** Configure global AJAX CSRF setup and update SMS callers to POST. | Low | Synchronizes client-side AJAX callers with POST-only route restrictions. |
| [`backend/js/custom.js`](file:///c:/wamp64/www/innova-web/backend/js/custom.js) | **SEC-11:** Mirror source copy of AJAX callers with POST and CSRF. | Low | Consistency between public build and backend source assets. |
| [`.gitignore`](file:///c:/wamp64/www/innova-web/.gitignore) | **SEC-01 / SEC-09:** Add ignore patterns for SQL dumps (`*.sql`, `*.sql.gz`, `*.sqlite`) and error logs. | Low | Prevents staging or committing new sensitive dumps or error logs. |

---

## 3. Explicit Out-of-Scope and Blocked Actions

In strict compliance with prompt constraints:
- **No deletion of `resources/views/admin/report/innovacomputer_pay.sql`** during this phase. (Requires approved owner retention decision and safe backup verification).
- **No deletion of `config/error_log`** without verified backup.
- **No package removal of `unisharp/laravel-filemanager`** (requires full replacement media manager implementation in Phase 3/4).
- **No live credential rotation or modification of `.env`**.
- **No live SMS or live bKash payment gateway transactions**.
- **No framework upgrades, migrations, or database engine modifications**.

---

## 4. Preflight Conclusion

The planned fixes are isolated, non-destructive, preserve all existing business rules, and can be verified using local PHP syntax checks and unit testing fixtures without impacting live users or databases. Proceeding to Step 2 (Security Finding Triage).
