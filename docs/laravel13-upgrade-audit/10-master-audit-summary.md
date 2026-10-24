# 10. Master Audit Summary and Migration Readiness Report

**Project:** `innova-web` (INNOVA Computers BD / ICBD)  
**Audit Target:** Laravel 13 + PHP 8.4 + PostgreSQL + React on Self-Managed VPS  
**Audit Date:** October 2026  
**Status:** Read-Only Audit (Phase 0 Complete — Stop Point Reached)  
**Auditor:** Senior Laravel Migration Architect & Database Migration Specialist  

---

## 1. Executive Scorecard & Migration Readiness Rating

| Audit Dimension | Current Rating | Migration Readiness Score | Primary Blocker / Risk Factor |
|---|---|---|---|
| **Framework & Architecture** | **High Risk** | **3.5 / 10** | 5 major versions behind (Laravel 8); obsolete Laravel Mix 4 build system; dual-root shared hosting layout. |
| **PHP 8.4 Compatibility** | **Medium-High Risk** | **4.5 / 10** | Untyped codebase; fatal `TypeError` risks on null strings; deprecated Eloquent `$dates` across 10 models. |
| **Composer Dependencies** | **Critical Blocker** | **2.5 / 10** | 6 abandoned packages (`swiftmailer`, `fideloper/proxy`, `laravelcollective/html`, `unisharp/lfm`, `fzaninotto/faker`, `dump-server`); zero locked packages support L13. |
| **Database & PostgreSQL** | **High Risk** | **4.0 / 10** | Broken migrations with duplicate classes; 5 missing migrations; formatted strings in financial columns; invalid `GROUP BY` queries. |
| **Frontend & React** | **Medium Risk** | **6.0 / 10** | Vue 2 is unused boilerplate; 326 Blade views with jQuery; zero existing REST API endpoints. |
| **Business Workflows** | **High Risk** | **4.0 / 10** | Race condition in SID generation; payment replay hole in bKash callback; fragile `env()` calls crash on `config:cache`. |
| **Security Posture** | **Critical Risk** | **2.0 / 10** | 1.4 MB SQL dump committed in views; live DB credentials in config; RCE in `SettingController`; disabled brute-force throttling; 48 admin controllers unauthenticated by RBAC. |
| **Testing & QA** | **Critical Blocker** | **0.0 / 10** | **0 automated tests exist.** 100% manual testing required unless test suite is constructed. |
| **OVERALL READINESS** | **HIGH RISK / BLOCKED** | **3.3 / 10** | **Remediation & re-platforming mandatory before production deployment.** |

---

## 2. Summary of Critical Blockers (Must Fix Before Upgrade)

1. **Abandoned Package Blockers:**
   - `swiftmailer/swiftmailer` must be removed and converted to Symfony Mailer (blocks Laravel 9+).
   - `fideloper/proxy` must be replaced by native Laravel proxy middleware (blocks Laravel 9+).
   - `laravelcollective/html` must be removed (blocks Laravel 11+).
   - `unisharp/laravel-filemanager` must be removed due to `CVE-2024-21546` RCE.
2. **Broken Database Migrations:**
   - 3 duplicate `CreateSessionsTable` migration classes crash `php artisan migrate` immediately.
   - Duplicate `CreateAssetCoursesTable` and `CreateAssetStudentsTable` classes crash fresh deployments.
   - Five production tables (`bank_loans`, `emi_installments`, `investment_withdraws`, `dividend_withdraws`, `certificate_icbds`) have no migration files in the repository.
3. **Committed Secrets & SQL Dump:**
   - 1.4 MB plain-text database dump (`resources/views/admin/report/innovacomputer_pay.sql`) exposes historical student and admin records.
   - Hardcoded production credentials in `config/database.php:51-53`.
4. **PostgreSQL Strict Query Failures:**
   - Invalid non-aggregate `GROUP BY` queries in `ReportController.php` will immediately crash financial reporting under PostgreSQL.
5. **Absence of Test Safety Net:**
   - Zero unit or feature tests exist in `tests/`, creating extreme risk of silent financial or admission regressions.

---

## 3. Package Replacement Requirements Summary

| Legacy Package | Status | Target Modern Replacement | Migration Action Required |
|---|---|---|---|
| `laravel/framework: 8.83.29` | End-of-Life | `laravel/framework: ^13.0` | Step upgrade or clean Laravel 13 skeleton re-platforming. |
| `swiftmailer/swiftmailer: 6.3.0` | Abandoned | Built-in `symfony/mailer: ^7.0` | Update `config/mail.php` to modern mailers array; remove package. |
| `fideloper/proxy: 4.4.2` | Abandoned | Built-in `Illuminate\Http\Middleware\TrustProxies` | Update middleware namespace; remove package. |
| `laravelcollective/html: 6.4.1` | Discontinued | Native Blade Components / HTML5 | Convert remaining 9 views to standard HTML5; remove package. |
| `unisharp/laravel-filemanager: 2.6.3` | High Risk / CVE | Custom React Media Manager / Spatie Media Library | Remove unmaintained package and routes. |
| `intervention/image: 2.7.2` | Obsolete API | `intervention/image: ^3.7` | Refactor single call in `AssetController.php` to v3 Driver API. |
| `spatie/laravel-permission: 5.11.1` | Incompatible | `spatie/laravel-permission: ^6.9` | Run v6 schema updates; verify guard configurations. |
| `barryvdh/laravel-dompdf: 1.0.0` | Outdated | `barryvdh/laravel-dompdf: ^3.0` | Upgrade to v3 (DomPDF 3.x engine with PHP 8.4 support). |
| `fzaninotto/faker: dev-master` | Abandoned | `fakerphp/faker: ^1.23` | Replace in `require-dev`. |
| `laravel-mix: 4.0.7` | Obsolete Webpack | `vite: ^5.4` + `@laravel/vite-plugin` | Complete transition to Vite asset bundling. |

---

## 4. PHP 8.4 Compatibility Risks Summary

1. **Fatal `TypeError` on Null Arguments:** Native string functions (`explode()`, `trim()`, `str_replace()`) in `ReportController` and `ExpanseController` lack null validation and will crash when given empty request inputs.
2. **Deprecated Eloquent `$dates` Property:** 10 Eloquent models (`BankLoan`, `EmiInstallment`, `DividendWithdraw`, `InvestmentWithdraw`, etc.) use `$dates = [...]`, which is completely ignored in Laravel 10+, breaking all date formatting in views and reports. Must be migrated to `protected function casts(): array`.
3. **String Arithmetic on Balances:** In `FeesTransectionsController.php:85`, `$due = $students['balance'] - $pay` subtracts a float from a formatted string containing commas, which fails in PHP 8.0+.
4. **Implicitly Nullable Parameter Deprecation:** Future code refactoring must avoid `Type $param = null` syntax, using `?Type $param = null` instead.

---

## 5. PostgreSQL Data Migration Risks Summary

1. **Financial Strings (`VARCHAR` → `NUMERIC`):** Twelve tables store currency with commas (`'12,000'`). Direct bulk loading into PostgreSQL `NUMERIC(12, 2)` will crash. A dedicated ETL sanitization command using regex replacement (`REGEXP_REPLACE(..., '[^0-9.]', '')`) is mandatory.
2. **Case Sensitivity in Searches (`LIKE` → `ILIKE`):** MySQL `LIKE` was case-insensitive under `utf8mb4_unicode_ci`. In PostgreSQL, `LIKE` is strictly case-sensitive. All student name search, phone search, and blog search queries must be converted to `ILIKE`.
3. **Multi-State Flag Data Loss Trap (`students.IsActive`):** `students.IsActive` holds 5 academic status states (`1..5`), NOT a boolean. Migrating to PostgreSQL `BOOLEAN` will destroy student records. Must be mapped to `SMALLINT`.
4. **Primary Key Sequence Alignment:** PostgreSQL sequences do not automatically advance upon importing hardcoded IDs. `setval(pg_get_serial_sequence(table, 'id'), MAX(id))` must be run for all 49 tables after import.
5. **Zero Date Rejection:** MySQL dates with `0000-00-00` must be cleansed to `NULL`.

---

## 6. React Migration Architecture Summary

- **Clarification:** Vue 2 is NOT used in the application UI (only 1 unused stub exists). The current UI is 326 server-rendered Blade templates.
- **Architectural Recommendation:** Adopt **Inertia.js + React (Monorepo)**:
  - Preserves Laravel routing, session authentication, CSRF, and controller logic.
  - Eliminates the need to rewrite 76 controllers into REST API endpoints.
  - Reduces frontend migration timeline from 16 weeks (headless REST API) to 5–6 weeks (Inertia.js).
- **Tooling:** Replace Laravel Mix 4 with Vite 5+, using Tailwind CSS and TanStack Table.

---

## 7. Recommended Upgrade Execution Order

```
Phase 1: Security Hardening & Secret Purge (Immediate)
   └── Delete SQL dump, rotate DB/bKash/SMS keys, fix env() caching bug, patch file uploads.
Phase 2: PostgreSQL Schema Reconstruction & Data ETL Pipeline (Week 2)
   └── Reconstruct 5 missing migrations, fix class collisions, build numeric ETL sanitization script.
Phase 3: Core Application Migration to Laravel 13 & PHP 8.4 (Weeks 3–4)
   └── Clean-slate skeleton re-platforming, model casts() migration, route modernization, package upgrades.
Phase 4: Frontend Modernization with Vite and React / Inertia (Weeks 5–6)
   └── Public marketing site first, student portal second, admin modules incrementally.
Phase 5: Automated Testing & Financial Ledger Parity Verification (Week 7)
   └── Integration test suite, 100% financial checksum matching between MySQL and PostgreSQL.
Phase 6: VPS Provisioning, Zero-Downtime Deployment & Cutover (Week 8)
   └── Ubuntu 24.04, Nginx, PHP 8.4, PostgreSQL 16, Redis, atomic symlink deployment, DNS cutover.
```

---

## 8. Backup and Rollback Prerequisites

Prior to production cutover:
1. **Full Database Snapshot:** Export full MySQL production dump with routines and triggers:
   ```bash
   mysqldump -u [user] -p --single-transaction --routines --triggers [database] > pre_migration_backup.sql
   ```
2. **Full Storage Media Archive:** Tar and compress all uploaded media:
   ```bash
   tar -czvf media_uploads_backup.tar.gz public/uploads storage/app/public
   ```
3. **Atomic Symlink Deployment:** Deploy new code to `/var/www/innova-web/releases/<timestamp>` and symlink to `/var/www/innova-web/current`.
4. **DNS Rollback Readiness:** Lower DNS TTL to 300 seconds 48 hours prior to maintenance window. If cutover encounters unexpected failure, point DNS back to the legacy server immediately.

---

## 9. Comprehensive List of Questions That Cannot Be Answered From the Repository

The following critical questions require input from the project stakeholders, server administrators, or third-party service providers:

1. **Current Production Database Structure & Row Counts:**
   - What are the exact table schemas, indexes, foreign keys, and current row counts for the 5 unmigrated production tables (`bank_loans`, `emi_installments`, `investment_withdraws`, `dividend_withdraws`, `certificate_icbds`)?
   - *Requirement:* A read-only database connection or an up-to-date schema export of the live production MySQL database is required.
2. **Current Production Media Volume:**
   - What is the total disk size (GB) and file count of uploaded images and student files currently stored in production (`public/uploads/` and `storage/app/public/`)?
   - *Requirement:* Needed to plan rsync/transfer times and allocate VPS SSD storage.
3. **Third-Party API Credentials Rotation Status:**
   - Have the live production bKash merchant credentials, Elitbuzz SMS credentials, and production MySQL passwords found committed in the repository been rotated on their respective dashboards?
   - *Requirement:* Confirmation from system administrators.
4. **Target VPS Specifications & Architecture:**
   - What are the exact hardware specifications (CPU cores, RAM, NVMe storage) and hosting provider of the target VPS?
   - Will PostgreSQL and Redis run on the same VPS instance as Nginx and PHP-FPM, or on separate managed database services?
5. **bKash Merchant Account Configuration:**
   - Does the live bKash merchant account support modern Tokenized Checkout (v1.2.0 API), and what callback URLs are currently whitelisted on the bKash merchant portal?
6. **Frontend Architectural Decision:**
   - Does the product stakeholder approve the **Inertia.js + React** monorepo architecture (recommended: 5–6 weeks timeline), or is there a hard organizational requirement for a fully decoupled headless REST API / Next.js architecture (12–16 weeks timeline)?
7. **Production Maintenance Window Constraints:**
   - What is the acceptable downtime window (e.g., Friday 02:00–04:00 AM) for performing the final delta data migration and DNS cutover?

---

## 10. Audit Phase 0 Complete — Stop Point

In strict accordance with Phase 0 audit guidelines, **no application code, configuration, or database structures have been modified**. All ten audit reports are generated under `docs/laravel13-upgrade-audit/` for technical review. Implementation should proceed only after review and resolution of the prerequisites outlined above.
