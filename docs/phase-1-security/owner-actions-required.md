# Phase 1 Owner Actions and Security Remediation Roadmap

**Project:** `innova-web` (INNOVA Computers BD / ICBD)  
**Execution Phase:** Phase 1 — Security Hardening & Repository Remediation  
**Date:** October 23, 2026 (Updated after Final Verification Pass)  
**Branch:** `feature/phase-1-security-hardening`  
**Auditor:** Senior Laravel Security Engineer  

---

## 1. Executive Summary

During Phase 1, all application-level code fixes within engineering scope were successfully implemented and verified on the `feature/phase-1-security-hardening` branch. However, several critical security items involve repository history, live infrastructure, and production third-party credentials that cannot and must not be altered automatically.

This document outlines the **mandatory owner decisions and administrator checklists** required to fully secure the `innova-web` production environment.

---

## 2. Sensitive Database Dump Containment (`SEC-01`)

### 2.1 Current File Status
- **Location:** [`resources/views/admin/report/innovacomputer_pay.sql`](file:///c:/wamp64/www/innova-web/resources/views/admin/report/innovacomputer_pay.sql)
- **Size:** 1,418,240 bytes (1.42 MB)
- **Git Tracking:** **Still tracked by Git** across historical commits.
- **Exposure:** Contains plain SQL `CREATE TABLE` and `INSERT INTO` statements with user accounts, administrative password hashes, and financial transaction history.

### 2.2 Immediate Actions Completed in Phase 1
- Added `*.sql`, `*.sql.gz`, and `*.sqlite` to [`.gitignore`](file:///c:/wamp64/www/innova-web/.gitignore) to prevent accidental staging or committing of new database dumps.
- In accordance with prompt restrictions ("Do not delete the only copy of any database dump... Do not rewrite Git history, force-push, or delete branches"), the file has NOT been purged and Git history has NOT been rewritten.

### 2.3 Approval-Dependent Procedure for Sensitive Files & History Purge

The repository owner must approve and coordinate the following exact 5-step procedure:

1. **Step 1 — Verify a Protected Offline Backup:**
   - Confirm whether `resources/views/admin/report/innovacomputer_pay.sql` and `config/error_log` are required for historical compliance or auditing.
   - If required, create an encrypted offline archive (e.g. GPG-encrypted tarball) stored in access-controlled, offline cold storage.
   - Verify archive integrity prior to codebase removal.

2. **Step 2 — Remove Sensitive Files from Active Codebase:**
   - Untrack files from the active Git index while preserving `.gitignore` entries:
     ```bash
     git rm --cached resources/views/admin/report/innovacomputer_pay.sql
     git rm --cached config/error_log
     git commit -m "chore(security): untrack sensitive SQL dump and error log from active index"
     ```

3. **Step 3 — Plan Coordinated History Purge and Full Repository Backup:**
   - Take a full bare clone backup of the remote Git repository (`git clone --mirror ...`).
   - During an agreed maintenance window, run `git-filter-repo` to permanently expunge blobs from commit history:
     ```bash
     git filter-repo --path resources/views/admin/report/innovacomputer_pay.sql --path config/error_log --invert-paths
     ```

4. **Step 4 — Coordinate Developers After History Rewriting:**
   - Because `git-filter-repo` rewrites commit SHAs across the branch graph, force-pushing the rewritten branch requires all collaborators to:
     - Push any pending feature work prior to history rewrite.
     - Delete their local working clones post-rewrite.
     - Re-clone fresh copies from the remote repository to prevent accidentally re-introducing purged blobs via merge commits.

5. **Step 5 — Rotate Potentially Exposed Credentials:**
   - Proceed immediately to the comprehensive credential rotation checklist in Section 3 below.

---

## 3. Credential Rotation Checklist (`SEC-02`, `SEC-08`, `SEC-10`)

Because database credentials were hardcoded in `config/database.php` and credentials may have been committed in repository history or logs, a **complete credential rotation** must be performed across external services.

> [!WARNING]
> Do not rotate credentials during peak business hours. Coordinated updates to `.env` on the production server must take place simultaneously to avoid service downtime.

### 3.1 Credential Categories to Rotate

| Credential Category | Service Provider | Exposure Risk | Systems Requiring Coordinated Update |
|---|---|---|---|
| **Production Database Password** | MySQL / cPanel Hosting | High (Committed in `config/database.php` fallback) | VPS/cPanel MySQL user, production `.env` (`DB_PASSWORD`) |
| **bKash Merchant API Credentials** | bKash Payment Gateway | High (Referenced in code; risk of replay/tampering) | bKash Merchant Portal, production `.env` (`BKASH_CHECKOUT_APP_KEY`, `BKASH_CHECKOUT_APP_SECRET`, `BKASH_CHECKOUT_PASSWORD`) |
| **SMS Gateway API Keys** | Elitbuzz SMS Gateway | Medium (Outbound HTTP requests; API key exposed) | Elitbuzz Portal, production `.env` (`SMS_API_KEY`) |
| **Application Encryption Key** | Laravel (`APP_KEY`) | Medium (If repository was exposed publicly) | Production `.env` (`APP_KEY`) — *Impact: Invalidates all active user sessions and encrypted cookies. Must be rotated with coordination, never automatically.* |
| **Administrative User Passwords** | Local Database Admins | Critical (Password hashes exposed in SQL dump) | All admin users must update passwords upon next login |

### 3.2 Step-by-Step Rotation Procedure

1. **Database Password Rotation:**
   - Log into cPanel MySQL Database Wizard / phpMyAdmin or VPS CLI.
   - Change the password for the application database user.
   - Immediately update `DB_PASSWORD` in `/home/innovacomputer/public_html/.env`.
   - Run `php artisan config:clear` on the server and test database connectivity:
     ```bash
     php artisan tinker --execute="DB::connection()->getPdo(); echo 'Connected!';"
     ```

2. **bKash Merchant API Rotation:**
   - Access the bKash Merchant Portal or contact bKash Merchant Operations support.
   - Request reissue of Checkout API credentials (`app_key`, `app_secret`, and password).
   - Update production `.env`:
     ```env
     BKASH_CHECKOUT_APP_KEY="<NEW_KEY>"
     BKASH_CHECKOUT_APP_SECRET="<NEW_SECRET>"
     BKASH_CHECKOUT_USER_NAME="<USER>"
     BKASH_CHECKOUT_PASSWORD="<NEW_PASSWORD>"
     ```
   - Execute a 1 BDT test transaction in a staging environment before live release.

3. **SMS Gateway Key Rotation:**
   - Log into the Elitbuzz customer control panel (`contactsms`).
   - Regenerate the API token.
   - Update `SMS_API_KEY` in production `.env`.
   - Send a test verification SMS to an internal administrative mobile number.

4. **Administrator Account Password Reset:**
   - Run an Artisan command or execute an admin reset query requiring all users with `role: admin` to set new strong passwords.
   - Disallow legacy weak passwords.

---

## 4. Web Server Document Root & Log Exposure (`SEC-07`, `SEC-09`)

### 4.1 Production Document Root Finding
- **Evidence-Based Finding:** Log paths in [`config/error_log`](file:///c:/wamp64/www/innova-web/config/error_log) show paths like `/home/innovacomputer/public_html/config/cache.php`. This indicates that the live web server document root was configured to point to the repository root directory instead of Laravel's `public/` directory. (This conclusion is based on recorded execution stack traces in committed error logs; live web server configuration must be verified directly on the host).
- **Security Impact:** When the document root is set to the project root, web visitors can directly request sensitive files such as `.env`, `composer.json`, `config/database.php`, and `resources/views/.../innovacomputer_pay.sql` over HTTP unless strict `.htaccess` block rules are loaded and functional.

### 4.2 Administrator Required Steps & Verification
The server administrator must execute the following structured remediation:

1. **Confirm the Active Virtual Host:**
   - Identify whether Apache (`/etc/apache2/sites-enabled/` or `/usr/local/apache/conf/`) or Nginx (`/etc/nginx/sites-enabled/` or `/etc/nginx/conf.d/`) is serving the domain.
2. **Set Document Root to Laravel `public/`:**
   - **Apache / cPanel:**
     ```apache
     DocumentRoot "/home/innovacomputer/public_html/public"
     <Directory "/home/innovacomputer/public_html/public">
         AllowOverride All
         Require all granted
     </Directory>
     ```
   - **Nginx:**
     ```nginx
     root /home/innovacomputer/public_html/public;
     index index.php index.html;
     ```
3. **Confirm Direct Access Is Blocked:**
   - Run HTTP verification tests to confirm that sensitive files return HTTP 403 or 404 and cannot be downloaded:
     - `curl -I https://innovacomputersbd.com/.env`
     - `curl -I https://innovacomputersbd.com/composer.json`
     - `curl -I https://innovacomputersbd.com/config/database.php`
     - `curl -I https://innovacomputersbd.com/resources/views/admin/report/innovacomputer_pay.sql`
4. **Test Essential Routes & Static Assets:**
   - Verify frontend home page, course catalog, student login, admin login, and stylesheet/script loading (`/backend/css/...`, `/frontend/...`).
5. **Rollback Plan:**
   - Backup the existing virtual host configuration file before editing. If routing fails or assets are inaccessible, restore the previous config backup and reload the web server daemon.

---

## 5. Legacy Dependency Containment & Future Prerequisites (`SEC-04`, `SEC-05`, `SEC-08`)

### 5.1 UniSharp Laravel Filemanager (`unisharp/laravel-filemanager:v2.6.3`)
- **Finding:** Locked at `v2.6.3`, vulnerable to arbitrary file upload and path traversal (CVE-2024-21546).
- **Code Containment Implemented (Phase 1):** 
  - Package auto-routes disabled (`'use_package_routes' => false` in `config/lfm.php`), stopping open route registration.
  - File manager routes (`/laravel-filemanager/*`) explicitly registered in `routes/admin.php` under `auth:admin` middleware, preventing frontend students or unauthenticated visitors from accessing file operations.
  - Package-level validation activated (`should_validate_mime => true`, `should_validate_size => true`).
  - Filename hashing and sanitization enabled (`rename_file => true`, `alphanumeric_filename => true`), neutralizing path traversal.
  - SVG (`image/svg+xml`) stripped from allowed image and file MIME types.
- **Phase 3/4 Replacement Plan:**
  - In Phase 3, replace UniSharp Filemanager with Spatie MediaLibrary or native Laravel upload controllers paired with CKEditor SimpleUploadAdapter.
  - Remove `unisharp/laravel-filemanager` from `composer.json` once replaced.

### 5.2 Granular RBAC Permissions (`SEC-05`)
- **Finding:** Database seeders define permissions for 14 legacy entities, but newly added administrative modules (`bank_loans`, `emi_installments`, `incomes`, etc.) lack permission records.
- **Prerequisite for Phase 2/3:**
  - Define a comprehensive permission seeder covering all 48 controllers.
  - Run the seeder and associate permissions with existing admin roles in the database before attaching permission middleware to administrative controllers.

### 5.3 Production Database Schema Prerequisite (`SEC-08` / Phase 2 Migration)
- **Finding:** While application-level atomic locking (`Cache::lock`) and `DB::transaction()` prevent duplicate transaction insertion under concurrent callbacks, production-grade concurrency safety requires a database-engine level uniqueness constraint.
- **Action Required for Phase 2 (Database Migration Phase):**
  - **Direct Inventory Prerequisite:** The production database is the real MySQL database. Any future migration must be based on a direct schema inventory of the real production database, not solely on existing Laravel migration files (which were found to omit `trxID`, `paymentID`, and other columns).
  - In Phase 2, perform a duplicate-check query on live data:
    ```sql
    SELECT trxID, COUNT(*) FROM fees_transections WHERE trxID IS NOT NULL GROUP BY trxID HAVING COUNT(*) > 1;
    ```
  - After resolving any historical duplicates, create a versioned migration:
    ```php
    Schema::table('fees_transections', function (Blueprint $table) {
        $table->string('trxID', 100)->nullable()->unique()->change();
    });
    ```
  - Do NOT execute this migration or alter tables during Phase 1.

---

## 6. Summary Checklist for Repository Owner

- [ ] **1. Review & Approve Sensitive File Containment:** Authorize backup archiving and subsequent `git-filter-repo` history purge of `innovacomputer_pay.sql` and `config/error_log`.
- [ ] **2. Rotate MySQL Production Password:** Update MySQL user password and synchronize with production `.env`.
- [ ] **3. Rotate bKash Checkout Credentials:** Generate new API keys via bKash Merchant Portal and update `.env`.
- [ ] **4. Rotate Elitbuzz SMS Gateway Key:** Regenerate SMS API token and update `.env`.
- [ ] **5. Reset Admin User Passwords:** Enforce password resets for all administrative user accounts.
- [ ] **6. Adjust Web Server Document Root:** Configure Apache/Nginx to serve exclusively from `/public` and verify direct downloads are blocked.
- [ ] **7. Phase 2 Database Schema Update:** Plan `trxID` unique constraint migration and historical audit based on direct production inventory.
- [ ] **8. Phase 2/3 RBAC Rollout:** Approve unified permission seeder before adding controller-level permission middleware.
- [ ] **9. Merge Security Branch:** Review `feature/phase-1-security-hardening` and merge to `main` upon completion of above verifications.
