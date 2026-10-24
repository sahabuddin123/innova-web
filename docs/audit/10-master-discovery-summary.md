# 10. Master Discovery Summary and Phase 0 Audit Report

**Project:** `innova-web` (INNOVA Computers BD / ICBD)  
**Audit Date:** October 13, 2026  
**Auditor:** Antigravity Agentic Audit (Phase 0 Discovery)  
**Strict Constraint:** AUDIT COMPLETE — STOP POINT REACHED (No implementation or destructive actions performed)

---

## 1. Executive Discovery Scorecard

| Dimension | Discovered & Verified Count | Verification Source / Status |
|---|---|---|
| **Registered Application Routes** | **466 Routes** | Verified via `php artisan route:list` (383 Admin, 60 Public, 13 User, 8 Auth, 1 Dev, 1 API) |
| **Controller Classes** | **76 Controllers** | Verified in `app/Http/Controllers/` (49 Admin, 4 Frontend, 4 Auth, 19 Root/Subsystem) |
| **Eloquent Model Classes** | **49 Models** | Verified in `app/Models/` |
| **Repository Classes** | **19 Repositories** | Verified in `app/Repositories/` |
| **Database Migration Files** | **52 Migrations** | Verified in `database/migrations/` |
| **Identified Database Tables** | **49 Tables** | 25 verified in historical dump; 24 defined in migrations; 5 missing migrations |
| **Core Business Modules** | **10 Modules** | Authentication, Academics, Fees, bKash, ASSET, Accounting, Banking, SMS, CMS, Settings |
| **Distinct Features Cataloged** | **45 Distinct Features** | 100% mapped in Feature Parity Matrix without omission |
| **Security Findings Cataloged** | **12 Vulnerabilities** | 2 Critical, 4 High, 4 Medium, 2 Low |
| **NPM Frontend Vulnerabilities** | **99 Vulnerabilities** | Verified via `npm audit` (26 High Severity) |
| **Composer Advisories** | **3 Major CVEs / 5 Abandoned** | Verified via `composer audit` (`CVE-2024-21546`, `CVE-2022-40734`) |

---

## 2. Key Architectural Discoveries

1. **Shared Hosting Dual Web-Root Anti-Pattern:**
   The project contains an anomalous `index.php` in the repository root (a clone of `server.php`) and duplicate asset directories (`backend/`, `frontend/`, `css/`, `js/`) created to allow serving from the repository root instead of the proper `/public` document root. This structure poses severe security risks if Apache allows downloading dotfiles (`.env`) or database dumps.
2. **Configuration Caching Fragility (`env()` Anti-Pattern):**
   Multiple business controllers (`BkashController`, `SMSController`, `UsersController`, `FeesTransectionsController`) call `env()` directly instead of `config()`. In production, running `php artisan config:cache` (which is even exposed as a web link in the admin portal) immediately sets these values to `null`, completely crashing online student payments and SMS dispatches.
3. **Broken Database Migrations on Fresh Installations:**
   Running `php artisan migrate` on a fresh database will crash immediately with `Fatal error: Cannot declare class ...` due to duplicate class definitions:
   - 3 separate `CreateSessionsTable` migrations.
   - 2 separate `CreateAssetCoursesTable` migrations.
   - 2 separate `CreateAssetStudentsTable` migrations.
4. **Missing Migration Files for Production Modules:**
   Five tables actively used in models and controllers (`bank_loans`, `emi_installments`, `investment_withdraws`, `dividend_withdraws`, `certificate_icbds`) have **no migration files in the codebase**, having been created manually on production.
5. **Data Type Anti-Pattern on Financial Quantities:**
   Tables `expanses`, `incomes`, `fees_transections`, `invesments`, and `shareholders` store monetary amounts as `VARCHAR(255)` with commas (e.g. `'15,000'`). This forces the application to use raw SQL string regex replacement (`SUM(REPLACE(amount, ',', ''))`) for financial reports.

---

## 3. Critical Security Posture Summary

```
CRITICAL (CVSS 9.0 - 10.0) ───► [SEC-01] 1.4 MB Production SQL Dump Exposed in Views
                           ───► [SEC-02] Live Database Credentials Hardcoded in config/database.php
HIGH     (CVSS 7.0 - 8.9)  ───► [SEC-03] Unrestricted Arbitrary File Upload in SettingController (RCE)
                           ───► [SEC-04] Remote Code Execution in UniSharp Filemanager (CVE-2024-21546)
                           ───► [SEC-05] Missing RBAC Authorization across 48 Admin Controllers
                           ───► [SEC-06] Missing Brute-Force Throttling on Admin Login Endpoint
MEDIUM   (CVSS 4.0 - 6.9)  ───► [SEC-07] Server Paths Leaked in Committed error_log Files
                           ───► [SEC-08] SSL Peer Verification Disabled in SMS cURL
                           ───► [SEC-09] Integration Failure on Config Caching
                           ───► [SEC-10] State-Changing Mutations & Deletions via HTTP GET
```

---

## 4. PostgreSQL Migration Readiness Assessment

- **Feasibility:** **High**, provided an ETL cleansing script is used to normalize financial strings and handle legacy sequence alignment.
- **Complexity Rating:** **Medium-High**.
- **Crucial Requirements:**
  1. **Financial Normalization:** Sanitize `VARCHAR` amounts containing commas or spaces into PostgreSQL `NUMERIC(12, 2)`.
  2. **Multi-State Flag Preservation:** In `students.IsActive`, the values `1..5` represent distinct academic statuses (Active, Irregular, Completed, Restricted, Postponed) and must be migrated to `SMALLINT`, NOT `BOOLEAN`.
  3. **Case Sensitivity:** Queries using `LIKE` must be converted to `ILIKE` for student search to preserve case-insensitive behavior under PostgreSQL.
  4. **Sequence Alignment:** Execute `setval(pg_get_serial_sequence('...', 'id'), MAX(id))` for all 49 tables after bulk import.
  5. **Password Compatibility:** Existing `$2y$10$` Bcrypt hashes are 100% compatible with Laravel's Bcrypt hasher under PostgreSQL with zero re-hashing required.

---

## 5. Missing Information & Open Dependencies

1. **Current Live Production Database Connection:**
   The local `.env` currently has `DB_USERNAME="sroot"`, causing `Access denied`. A live schema dump or read-only connection to the current production database is required to verify the exact structure of the 5 unmigrated tables (`bank_loans`, `emi_installments`, `investment_withdraws`, `dividend_withdraws`, `certificate_icbds`) and confirm active production row counts for tables created after February 2024.
2. **Current Production File Uploads Volume:**
   The exact disk size and file count of user uploads stored in production (`storage/app/public/` and `public/uploads/`) must be audited prior to data migration to plan media transfer to S3 or a persistent volume.
3. **Live API Credentials Rotation Confirmation:**
   Confirmation from the project stakeholders that live bKash keys, Elitbuzz SMS keys, and live database passwords exposed in the repository have been rotated.

---

## 6. Recommended Next Steps (Phase 1 Roadmap)

```mermaid
graph LR
    P0[Phase 0: Audit Complete] --> P1[Phase 1: Remediation & Schema Freeze]
    P1 --> P2[Phase 2: Modern Laravel API & PostgreSQL]
    P2 --> P3[Phase 3: React / Next.js Frontend]
    P3 --> P4[Phase 4: Data Migration & Parity Testing]
```

### Immediate Phase 1 Actions:
1. **Purge Leaked Assets:** Delete `innovacomputer_pay.sql`, `views.zip`, and `error_log` files from the filesystem and purge them from Git history.
2. **Rotate Credentials:** Immediately rotate production database passwords, bKash API credentials, and SMS API keys.
3. **Generate Complete Migration Suite:** Reconstruct proper migration files for the 5 unmigrated tables (`bank_loans`, etc.) and delete duplicate conflicting migration files.
4. **Fix Configuration Cache Anti-Pattern:** Migrate all direct `env()` references in controllers into `config/services.php`.
5. **Freeze Legacy Feature Development:** Transition development to the modern backend API and React frontend according to the specifications in [`09-feature-parity-matrix.md`](file:///c:/wamp64/www/innova-web/docs/audit/09-feature-parity-matrix.md).

---

## 7. Deliverables Index

All 10 required audit reports have been compiled in the `docs/audit/` directory:
1. [`docs/audit/01-project-structure.md`](file:///c:/wamp64/www/innova-web/docs/audit/01-project-structure.md) — Application structure, dependencies, runtime, and anomalous files.
2. [`docs/audit/02-database-inventory.md`](file:///c:/wamp64/www/innova-web/docs/audit/02-database-inventory.md) — 49-table inventory, schemas, duplicate migrations, and dump comparison.
3. [`docs/audit/03-feature-inventory.md`](file:///c:/wamp64/www/innova-web/docs/audit/03-feature-inventory.md) — Complete 10-module feature breakdown and status evaluation.
4. [`docs/audit/04-route-controller-model-map.md`](file:///c:/wamp64/www/innova-web/docs/audit/04-route-controller-model-map.md) — Comprehensive 466-route architecture and dependency map.
5. [`docs/audit/05-roles-permissions-security.md`](file:///c:/wamp64/www/innova-web/docs/audit/05-roles-permissions-security.md) — Authentication, RBAC gap, upload risks, and auth security.
6. [`docs/audit/06-integrations-business-logic.md`](file:///c:/wamp64/www/innova-web/docs/audit/06-integrations-business-logic.md) — bKash, Elitbuzz SMS, accounting calculations, and document generation.
7. [`docs/audit/07-security-findings.md`](file:///c:/wamp64/www/innova-web/docs/audit/07-security-findings.md) — CVSS-scored vulnerability assessment with remediation guides.
8. [`docs/audit/08-mysql-postgresql-migration-assessment.md`](file:///c:/wamp64/www/innova-web/docs/audit/08-mysql-postgresql-migration-assessment.md) — PostgreSQL data type mapping, DAG order, and ETL rules.
9. [`docs/audit/09-feature-parity-matrix.md`](file:///c:/wamp64/www/innova-web/docs/audit/09-feature-parity-matrix.md) — Complete matrix mapping 45 legacy features to modern React + Laravel API.
10. [`docs/audit/10-master-discovery-summary.md`](file:///c:/wamp64/www/innova-web/docs/audit/10-master-discovery-summary.md) — Master summary, discovery scorecard, and transition roadmap.
