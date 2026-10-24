# Phase 3 — Owner Decision Register & Reconciled Evidence Gate (Audit Only)

**Project:** `innova-web` — INNOVA Computers BD (ICBD)  
**Document:** Phase 3 Owner Decision Register & Reconciled Evidence Baseline  
**Author:** Senior Database Migration Architect & Lead Engineer  
**Date:** October 2026  
**Active Git Branch:** `feature/phase-1-security-hardening`  
**Operational Database:** `icbd_web` on MySQL 8.0.31 (`127.0.0.1:3306`, 52 Base Tables, 15,663 Operational Records)  
**Audit Reports Reconciled:**
- [`docs/phase-2-database/PHASE_2_DATABASE_INVENTORY.md`](file:///c:/wamp64/www/innova-web/docs/phase-2-database/PHASE_2_DATABASE_INVENTORY.md)
- [`docs/phase-2-database/PHASE_2_SCHEMA_DRIFT_REPORT.md`](file:///c:/wamp64/www/innova-web/docs/phase-2-database/PHASE_2_SCHEMA_DRIFT_REPORT.md)
- [`docs/phase-2-database/PHASE_2_POSTGRESQL_COMPATIBILITY.md`](file:///c:/wamp64/www/innova-web/docs/phase-2-database/PHASE_2_POSTGRESQL_COMPATIBILITY.md)
- [`docs/phase-2-database/PHASE_2_DATA_MIGRATION_PLAN.md`](file:///c:/wamp64/www/innova-web/docs/phase-2-database/PHASE_2_DATA_MIGRATION_PLAN.md)
- [`docs/phase-2-database/PHASE_2_BLOCKERS_AND_DECISIONS.md`](file:///c:/wamp64/www/innova-web/docs/phase-2-database/PHASE_2_BLOCKERS_AND_DECISIONS.md)
- [`docs/phase-3-planning/PHASE_3_MIGRATION_RECONSTRUCTION_PLAN.md`](file:///c:/wamp64/www/innova-web/docs/phase-3-planning/PHASE_3_MIGRATION_RECONSTRUCTION_PLAN.md)
- [`docs/phase-3-planning/PHASE_3_READINESS_REVIEW.md`](file:///c:/wamp64/www/innova-web/docs/phase-3-planning/PHASE_3_READINESS_REVIEW.md)
- [`docs/phase-3-planning/PHASE_3_DATA_PROFILING_AND_BACKUP_REVIEW.md`](file:///c:/wamp64/www/innova-web/docs/phase-3-planning/PHASE_3_DATA_PROFILING_AND_BACKUP_REVIEW.md)
- [`docs/phase-3-planning/PHASE_3_EVIDENCE_RECONCILIATION.md`](file:///c:/wamp64/www/innova-web/docs/phase-3-planning/PHASE_3_EVIDENCE_RECONCILIATION.md)

---

## 1. Executive Summary & Review Status

This document establishes the authoritative, evidence-backed **Owner Decision Register** for the database migration and modernization of `innova-web`.

All 14 technical dimensions of schema drift, data anomalies, storage engine risks, and runtime constraints have been reconciled and cross-referenced. **No migrations, code changes, database writes, DDL operations, or data corrections have been executed.**

### Official Review Determination:
```
READY FOR OWNER DECISIONS
```

> [!CRITICAL]
> **Implementation remains strictly blocked.** All eight architectural decision gates below are formally marked `PENDING`. No database changes, migration authoring, or production cutover may occur until the project owner and institutional accounting explicitly record approvals in this register.

---

## 2. Reconciled Evidence Master Table

The following master table provides the unified, reconciled baseline across all 14 technical audit areas:

| # | Technical Dimension | Reconciled Finding & Scope | Primary Evidence Source | Verification Status | Risk if Ignored During Implementation | Confirmation Required |
|---|---|---|---|---|---|---|
| **1** | **Current Runtime Baseline** | • PHP: `8.2.0 (cli)`<br/>• Laravel: `8.83.29`<br/>• MySQL: `8.0.31` | CLI execution (`php -v`, `artisan --version`, `SELECT VERSION()`) | **VERIFIED** | Deploying Laravel 13 code directly onto PHP 8.2 will fail due to framework skeleton and language syntax incompatibilities. | Owner (Infrastructure Roadmap) |
| **2** | **Live Database Table Count & Engines** | • Total: 52 Base Tables (0 views)<br/>• Records: 15,663 operational rows<br/>• Storage Engines: 38 InnoDB, 14 MyISAM | [`PHASE_2_DATABASE_INVENTORY.md:44-97`](file:///c:/wamp64/www/innova-web/docs/phase-2-database/PHASE_2_DATABASE_INVENTORY.md#L44-L97); [`PHASE_3_DATA_PROFILING_AND_BACKUP_REVIEW.md:1279`](file:///c:/wamp64/www/innova-web/docs/phase-3-planning/PHASE_3_DATA_PROFILING_AND_BACKUP_REVIEW.md#L1279) | **VERIFIED** | 14 MyISAM tables lack ACID transactions and foreign-key constraints. Uncoordinated backups cause inconsistent snapshots. | Owner (Decision Gate 6) |
| **3** | **Five Unmigrated Production Tables** | 5 live operational tables have zero migration files:<br/>1. `bank_loans` (7 rows, 16 cols, MyISAM)<br/>2. `emi_installments` (71 rows, 15 cols, MyISAM)<br/>3. `investment_withdraws` (11 rows, 20 cols, MyISAM)<br/>4. `dividend_withdraws` (1 row, 20 cols, MyISAM)<br/>5. `certificates_icbd` (38 rows, 16 cols, InnoDB) | [`PHASE_2_DATABASE_INVENTORY.md:214-243`](file:///c:/wamp64/www/innova-web/docs/phase-2-database/PHASE_2_DATABASE_INVENTORY.md#L214-L243); [`PHASE_3_READINESS_REVIEW.md:52-60`](file:///c:/wamp64/www/innova-web/docs/phase-3-planning/PHASE_3_READINESS_REVIEW.md#L52-L60) | **VERIFIED** | Running `php artisan migrate:fresh` on a new server omits these 5 modules, completely breaking loans, shareholder ledgers, and institute certificates. | Owner (Decision Gate 1) |
| **4** | **Migration Collisions & Dependency Order** | • Duplicate classes: `CreateSessionsTable` (3 files), `CreateAssetCoursesTable` (2 files), `CreateAssetStudentsTable` (2 files)<br/>• Circular dependency: `courses` (2022) references `course_categories` (2024)<br/>• Ghost tables: `assets`, `asset_students` | [`PHASE_2_SCHEMA_DRIFT_REPORT.md:107-132`](file:///c:/wamp64/www/innova-web/docs/phase-2-database/PHASE_2_SCHEMA_DRIFT_REPORT.md#L107-L132); [`PHASE_3_MIGRATION_RECONSTRUCTION_PLAN.md:161-184`](file:///c:/wamp64/www/innova-web/docs/phase-3-planning/PHASE_3_MIGRATION_RECONSTRUCTION_PLAN.md#L161-L184) | **VERIFIED** | Fresh migration suite crashes immediately with PHP fatal class redeclaration errors and foreign-key resolution failures. | Owner (Decision Gate 2) |
| **5** | **Twenty-Four Schema Drift Columns** | 24 unmigrated columns exist across 6 tables:<br/>• `fees_transections` (4): `channel`, `trxID`, `paymentID`, `status`<br/>• `courses` (7): `IsCourse`, `courseFor`, `Instructor`, `Rating`, `TotalReview`, `Discount`, `views`<br/>• `teachers` (8): `email`, `ComCourse`, `nStd`, `rating`, `review`, `isTeacher`, `IsFeatured`, `bio`<br/>• `course_categories` (3): `fontawesome`, `isFeature`, `tabId`<br/>• `admins` (1): `remember_token`<br/>• `users` (1): `name` | [`PHASE_2_SCHEMA_DRIFT_REPORT.md:93-104`](file:///c:/wamp64/www/innova-web/docs/phase-2-database/PHASE_2_SCHEMA_DRIFT_REPORT.md#L93-L104); [`PHASE_3_READINESS_REVIEW.md:62-73`](file:///c:/wamp64/www/innova-web/docs/phase-3-planning/PHASE_3_READINESS_REVIEW.md#L62-L73) | **VERIFIED** | Frontend and portal controllers query these columns; running unmodified legacy migrations causes immediate SQL column-not-found crashes. | Owner (Decision Gate 1 & 8) |
| **6** | **`fees_transections.trxID` Duplicate Group** | • Total records: 1,604<br/>• NULL records: 1,598 (cash/counter)<br/>• Non-null records: 6<br/>• Duplicate group: Exactly 1 key (`AAN****SE0`) across 6 rows (`ids: 332-337`) recorded 2023-01-23 08:20:02 to 09:01:30 | [`PHASE_2_SCHEMA_DRIFT_REPORT.md:47-91`](file:///c:/wamp64/www/innova-web/docs/phase-2-database/PHASE_2_SCHEMA_DRIFT_REPORT.md#L47-L91); [`PHASE_3_DATA_PROFILING_AND_BACKUP_REVIEW.md:905-923`](file:///c:/wamp64/www/innova-web/docs/phase-3-planning/PHASE_3_DATA_PROFILING_AND_BACKUP_REVIEW.md#L905-L923) | **VERIFIED** | Applying an unconditional UNIQUE constraint will fail during restore. Deduplication requires accounting sign-off; PostgreSQL partial unique index is mandatory. | Accounting & Owner (Decision Gate 3) |
| **7** | **Fourteen Zero-Date Records (`0000-00-00`)** | Exactly 14 records across 2 tables contain `'0000-00-00'`:<br/>• `expanses.invoiceDate`: 6 rows<br/>• `incomes.invoiceDate`: 8 rows<br/>• All other 161 date columns across the DB have 0 zero-dates | [`PHASE_2_DATABASE_INVENTORY.md:155, 175`](file:///c:/wamp64/www/innova-web/docs/phase-2-database/PHASE_2_DATABASE_INVENTORY.md#L155); [`PHASE_3_DATA_PROFILING_AND_BACKUP_REVIEW.md:131-136`](file:///c:/wamp64/www/innova-web/docs/phase-3-planning/PHASE_3_DATA_PROFILING_AND_BACKUP_REVIEW.md#L131-L136) | **VERIFIED** | PostgreSQL rejects `'0000-00-00'` with SQL State 22008 (`date out of range`), crashing ETL data ingestion. | Owner & Accounting (Decision Gate 5) |
| **8** | **Sixteen Century-Typo Date Records** | Exactly 16 operational rows across 13 distinct date values contain 2-digit century typos (`0023`, `0223`, `0024`, `0025`, `0026`, `0226`):<br/>• `expanses.invoiceDate`: 9 rows (7 distinct values)<br/>• `incomes.invoiceDate`: 6 rows (5 distinct values)<br/>• `fees_transections.paiddate`: 1 row (1 distinct value) | [`PHASE_3_DATA_PROFILING_AND_BACKUP_REVIEW.md:141-155`](file:///c:/wamp64/www/innova-web/docs/phase-3-planning/PHASE_3_DATA_PROFILING_AND_BACKUP_REVIEW.md#L141-L155); [`PHASE_3_EVIDENCE_RECONCILIATION.md:44-65`](file:///c:/wamp64/www/innova-web/docs/phase-3-planning/PHASE_3_EVIDENCE_RECONCILIATION.md#L44-L65) | **VERIFIED** | Dates stored as first-century CE are omitted by business reporting date filters (`whereBetween`). Accounting must verify intended 202x dates before correction. | Accounting & Owner (Decision Gate 5) |
| **9** | **Combined Total Date Anomalies** | Exactly 30 anomalous date records exist across the whole database (14 zero-dates + 16 century-typos). All 30 are confined to `expanses.invoiceDate` (15), `incomes.invoiceDate` (14), and `fees_transections.paiddate` (1). | [`PHASE_3_EVIDENCE_RECONCILIATION.md:110-128`](file:///c:/wamp64/www/innova-web/docs/phase-3-planning/PHASE_3_EVIDENCE_RECONCILIATION.md#L110-L128) | **VERIFIED** | Uncoordinated bulk date patching risks silent accounting ledger tampering. | Accounting & Owner (Decision Gate 5) |
| **10** | **`batchs.totalseat` Conversion Feasibility** | 65 rows in `batchs.totalseat` contain 100% pure numeric strings (`20`, `15`, `10`, `5`, `12`, `9`, `25`). 0 NULLs, 0 empty strings, 0 non-numeric text. | [`PHASE_3_DATA_PROFILING_AND_BACKUP_REVIEW.md:7-50`](file:///c:/wamp64/www/innova-web/docs/phase-3-planning/PHASE_3_DATA_PROFILING_AND_BACKUP_REVIEW.md#L7-L50) | **VERIFIED** | Safe for direct cast to PostgreSQL `INTEGER`. No conversion failure risk. | Technical Architecture (None) |
| **11** | **`students.IsActive` Multistate Statuses** | Academic status is an enumeration (1=Active, 2=Irregular, 3=Completed, 4=Restricted, 5=Postponed) queried in `StudentsController.php`. | [`app/Http/Controllers/Admin/StudentsController.php:84, 106, 128, 150`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/StudentsController.php#L84); [`PHASE_2_POSTGRESQL_COMPATIBILITY.md:148-169`](file:///c:/wamp64/www/innova-web/docs/phase-2-database/PHASE_2_POSTGRESQL_COMPATIBILITY.md#L148-L169) | **VERIFIED** | Mapping to `BOOLEAN` coerces statuses 2, 3, 4, 5 to `TRUE`, irreversibly corrupting academic student statuses. Must be `SMALLINT`. | Owner (Decision Gate 8) |
| **12** | **`students.discount` Trailing Dot (`"50."`)** | Out of 1,005 rows, 937 are pure numeric, 66 are NULL, and exactly 2 rows store `"50."` with a trailing dot. Zero commas exist across all financial tables. | [`PHASE_3_DATA_PROFILING_AND_BACKUP_REVIEW.md:382-401`](file:///c:/wamp64/www/innova-web/docs/phase-3-planning/PHASE_3_DATA_PROFILING_AND_BACKUP_REVIEW.md#L382-L401) | **VERIFIED** | Proposed conversion to `NUMERIC(15,2)` and trimming trailing dots (`"50."` → `50.00`) is an option requiring owner approval, not an authorized data correction. | Owner (Decision Gate 4) |
| **13** | **`sessions` Table Naming Conflict** | Academic session entity (10 rows, referenced by `registrations` and `certificates`) directly collides with Laravel HTTP database session table. Raw query builder calls exist in `UserController.php:263` and `SessionController.php:34, 140`. | [`PHASE_2_BLOCKERS_AND_DECISIONS.md:35-50`](file:///c:/wamp64/www/innova-web/docs/phase-2-database/PHASE_2_BLOCKERS_AND_DECISIONS.md#L35-L50); [`PHASE_3_DATA_PROFILING_AND_BACKUP_REVIEW.md:270-305`](file:///c:/wamp64/www/innova-web/docs/phase-3-planning/PHASE_3_DATA_PROFILING_AND_BACKUP_REVIEW.md#L270-L305) | **VERIFIED** | Renaming table to `academic_sessions` without updating `DB::table('sessions')` in controllers will crash user/admin session management. | Owner (Decision Gate 2) |
| **14** | **Backup & Restore Verification Status** | • Backup existence: NOT VERIFIED (no existing backup evidence identified in the audit)<br/>• Checksum verification: NOT PERFORMED<br/>• Consistent snapshot: NOT VERIFIED<br/>• Disposable restore: NOT PERFORMED<br/>• Post-restore application/data validation: NOT PERFORMED<br/>• Overall backup/restore status: NOT VERIFIED (A checksum is not proof of successful restoration) | [`PHASE_3_DATA_PROFILING_AND_BACKUP_REVIEW.md:252-268`](file:///c:/wamp64/www/innova-web/docs/phase-3-planning/PHASE_3_DATA_PROFILING_AND_BACKUP_REVIEW.md#L252-L268); [`PHASE_3_EVIDENCE_RECONCILIATION.md:144-180`](file:///c:/wamp64/www/innova-web/docs/phase-3-planning/PHASE_3_EVIDENCE_RECONCILIATION.md#L144-L180) | **VERIFIED (ABSENCE)** | Executing migrations without a verified cold backup and verified restore test risks catastrophic, unrecoverable production data loss. | Owner (Safety Prerequisite) |

---

## 3. Owner Decision Register (Eight Decision Gates)

Below are the **8 official architectural decision gates**. Each decision presents the technical context, trade-offs, available evidence, and required sign-off block. All decisions remain **`PENDING`**.

---

### Decision Gate 1: Reverse-Engineering Migrations for 5 Unmigrated Production Tables
- **Why It Matters:** Five operational tables (`bank_loans`, `emi_installments`, `investment_withdraws`, `dividend_withdraws`, `certificates_icbd`) exist in MySQL and have active Eloquent models/controllers, but zero migration files in `database/migrations/`. Running `php artisan migrate:fresh` on a new server will completely omit these modules.
- **Available Options & Trade-Offs:**
  - **Option 1A (Recommended):** Reverse-engineer authoritative Laravel migrations from the verified live database schema, incorporating explicit foreign keys and strict types.
  - **Option 1B:** Retire or archive any of these modules if they are no longer used by INNOVA Computers BD.
- **Evidence Available:** Exact live schemas, column lists, and row counts verified in [`PHASE_2_DATABASE_INVENTORY.md:214-243`](file:///c:/wamp64/www/innova-web/docs/phase-2-database/PHASE_2_DATABASE_INVENTORY.md#L214-L243).
- **Missing Confirmation:** Formal owner selection of Option 1A vs. 1B.
- **Status:** `PENDING`
- **Sign-Off Block:**
  ```
  DECISION SELECTED: [                              ]
  APPROVAL DATE:     [                              ]
  APPROVED BY:       [                              ]
  ```

---

### Decision Gate 2: Resolution of Triplicate `CreateSessionsTable` & Entity Collision
- **Why It Matters:** Academic terms (`Jan-Jun 2022`, etc., 10 rows) share the table name `sessions` and class name `CreateSessionsTable` with Laravel's HTTP database session table. Foreign keys in `registrations` and `certificates` point to academic `sessions.id`.
- **Available Options & Trade-Offs:**
  - **Option 2A (Recommended):** Rename academic table to `academic_sessions`, update model `Session.php` to `$table = 'academic_sessions'`, patch raw `DB::table('sessions')` calls in `UserController` and `SessionController`, and let Laravel HTTP sessions use standard `sessions`.
  - **Option 2B:** Keep `sessions` for academic data, and configure `config/session.php` to use `'table' => 'http_sessions'` or driver `'redis'`/`'file'`. Breaks standard Laravel ecosystem conventions.
- **Evidence Available:** Verified in [`PHASE_2_BLOCKERS_AND_DECISIONS.md:35-50`](file:///c:/wamp64/www/innova-web/docs/phase-2-database/PHASE_2_BLOCKERS_AND_DECISIONS.md#L35-L50) and [`PHASE_3_EVIDENCE_RECONCILIATION.md:210-230`](file:///c:/wamp64/www/innova-web/docs/phase-3-planning/PHASE_3_EVIDENCE_RECONCILIATION.md#L210-L230).
- **Missing Confirmation:** Formal owner selection of Option 2A vs. 2B.
- **Status:** `PENDING`
- **Sign-Off Block:**
  ```
  DECISION SELECTED: [                              ]
  APPROVAL DATE:     [                              ]
  APPROVED BY:       [                              ]
  ```

---

### Decision Gate 3: Accounting Review of Six Duplicate `trxID` Records (IDs 332–337)
- **Why It Matters:** Exactly 6 rows in `fees_transections` (`ids: 332, 333, 334, 335, 336, 337`) share the identical bKash transaction key (`AAN****SE0`) created within 41 minutes on 2023-01-23. Applying a standard `UNIQUE(trxID)` constraint will crash database migration.
- **Available Options & Trade-Offs:**
  - **Option 3A (Accounting Audit & Deduplication):** Review bank/bKash merchant statements with accounting. If IDs 333–337 are redundant retry submissions for a single payment, merge or soft-delete duplicates, then apply a PostgreSQL partial unique index (`WHERE trxID IS NOT NULL AND TRIM(trxID) != ''`).
  - **Option 3B (Audit Suffix Preservation):** Retain all 6 rows by appending audit suffixes (`AAN****SE0_DUP_1`), preserving historical rows while enforcing uniqueness on future payments via partial index.
- **Evidence Available:** Confirmed in [`PHASE_2_SCHEMA_DRIFT_REPORT.md:69-91`](file:///c:/wamp64/www/innova-web/docs/phase-2-database/PHASE_2_SCHEMA_DRIFT_REPORT.md#L69-L91) and [`PHASE_3_DATA_PROFILING_AND_BACKUP_REVIEW.md:905-923`](file:///c:/wamp64/www/innova-web/docs/phase-3-planning/PHASE_3_DATA_PROFILING_AND_BACKUP_REVIEW.md#L905-L923).
- **Missing Confirmation:** Accounting ledger reconciliation and owner sign-off on Option 3A vs. 3B.
- **Status:** `PENDING`
- **Sign-Off Block:**
  ```
  DECISION SELECTED: [                              ]
  APPROVAL DATE:     [                              ]
  APPROVED BY:       [                              ]
  ```

---

### Decision Gate 4: Monetary Field Normalization & Cleanup of `students.discount = '50.'`
- **Why It Matters:** Monetary figures are stored as `VARCHAR(191)` in `expanses`, `incomes`, `fees_transections`, `students`, and `invesments`. In PHP 8+, mathematical operations on strings introduce truncation risks. In `students.discount`, 2 rows contain trailing dots (`"50."`).
- **Available Options & Trade-Offs:**
  - **Option 4A (Proposed Treatment Requiring Owner Approval):** Convert all monetary columns to `NUMERIC(15,2) NOT NULL DEFAULT 0.00`, and trim trailing dots in `students.discount` (`"50."` → `50.00`). *Note: This proposed treatment is an architectural option requiring explicit owner authorization; it is NOT an authorized data correction.*
  - **Option 4B:** Retain `VARCHAR` monetary storage (strongly discouraged; perpetuates technical debt and financial calculation bugs).
- **Evidence Available:** Live profiling proved zero commas exist across 13,689 records; only 2 rows in `students.discount` have trailing dots. Verified in [`PHASE_3_DATA_PROFILING_AND_BACKUP_REVIEW.md:382-401`](file:///c:/wamp64/www/innova-web/docs/phase-3-planning/PHASE_3_DATA_PROFILING_AND_BACKUP_REVIEW.md#L382-L401).
- **Missing Confirmation:** Owner sign-off on Option 4A vs. 4B.
- **Status:** `PENDING`
- **Sign-Off Block:**
  ```
  DECISION SELECTED: [                              ]
  APPROVAL DATE:     [                              ]
  APPROVED BY:       [                              ]
  ```

---

### Decision Gate 5: Accounting Verification of Zero Dates & Century-Typo Dates
- **Why It Matters:** 
  1. 14 rows contain `'0000-00-00'` (`expanses.invoiceDate`: 6, `incomes.invoiceDate`: 8), which PostgreSQL rejects with SQL State 22008.
  2. 16 rows across 13 distinct values contain century typos (`0023`, `0223`, `0024`, `0025`, `0026`, `0226`) in `expanses.invoiceDate` (9 rows across 7 distinct values), `incomes.invoiceDate` (6 rows across 5 distinct values), and `fees_transections.paiddate` (1 row across 1 distinct value), causing vouchers to be omitted from financial reports. Total combined anomalous date records = 30.
- **Available Options & Trade-Offs:**
  - **Option 5A (Proposed Treatment Requiring Accounting & Owner Approval):** Convert all 14 `'0000-00-00'` occurrences to `NULL`. Authorize accounting to inspect physical paper vouchers for the 16 century-typo rows and determine approved 202x dates (`0023-11-20` → `2023-11-20`). *Note: Both the zero-date conversion to NULL and century-typo updates are proposed treatments submitted for accounting and owner decision; neither is an authorized data correction.*
  - **Option 5B:** Convert zero dates to `NULL` but leave century-typo dates unaltered in the first century CE (will exclude them from modern financial reports).
- **Evidence Available:** Exact table/column counts and stored values cataloged in [`PHASE_3_EVIDENCE_RECONCILIATION.md:44-65`](file:///c:/wamp64/www/innova-web/docs/phase-3-planning/PHASE_3_EVIDENCE_RECONCILIATION.md#L44-L65).
- **Missing Confirmation:** Accounting verification of physical vouchers and owner selection of Option 5A vs. 5B.
- **Status:** `PENDING`
- **Sign-Off Block:**
  ```
  DECISION SELECTED: [                              ]
  APPROVAL DATE:     [                              ]
  APPROVED BY:       [                              ]
  ```

---

### Decision Gate 6: Strategy for Fourteen MyISAM Tables
- **Why It Matters:** 14 tables in `icbd_web` use the `MyISAM` engine (`bank_loans`, `emi_installments`, `investment_withdraws`, `dividend_withdraws`, `asset_courses`, `asset_registrations`, `asset_registration_feedbacks`, `clients`, `concerns`, `products`, `services`, `teams`, `technologies`, `workflows`). MyISAM completely lacks transaction rollbacks and foreign-key enforcement.
- **Available Options & Trade-Offs:**
  - **Option 6A (Recommended):** Convert all 14 tables to PostgreSQL standard transactional tables with explicit foreign-key constraints and indexes.
  - **Option 6B:** Migrate tables without foreign-key constraints (not recommended; forfeits relational integrity guarantees).
- **Evidence Available:** Live audit confirmed 0 orphan records exist across all parent-child relationships despite MyISAM engine in MySQL ([`PHASE_2_DATABASE_INVENTORY.md:139-163`](file:///c:/wamp64/www/innova-web/docs/phase-2-database/PHASE_2_DATABASE_INVENTORY.md#L139-L163)).
- **Missing Confirmation:** Owner sign-off on Option 6A vs. 6B.
- **Status:** `PENDING`
- **Sign-Off Block:**
  ```
  DECISION SELECTED: [                              ]
  APPROVAL DATE:     [                              ]
  APPROVED BY:       [                              ]
  ```

---

### Decision Gate 7: Table & Column Misspelling Modernization
- **Why It Matters:** Legacy MySQL schema contains misspelled table names: `expanses` (expenses), `expanse_categoris` (expense_categories), `income_categoris` (income_categories), `fees_transections` (fees_transactions), `invesments` (investments), and `batchs` (batches).
- **Available Options & Trade-Offs:**
  - **Option 7A (Conservative — Recommended for Staged Migration):** Retain legacy table names during initial database cutover to PostgreSQL; rename during subsequent application refactoring.
  - **Option 7B (Clean Cutover with Views):** Rename tables to standard English in PostgreSQL, and create PostgreSQL backward-compatibility `VIEW`s aliasing legacy names (`CREATE VIEW expanses AS SELECT * FROM expenses;`).
- **Evidence Available:** Complete inventory of models and controllers referencing legacy names ([`PHASE_2_BLOCKERS_AND_DECISIONS.md:108-123`](file:///c:/wamp64/www/innova-web/docs/phase-2-database/PHASE_2_BLOCKERS_AND_DECISIONS.md#L108-L123)).
- **Missing Confirmation:** Owner selection of Option 7A vs. 7B.
- **Status:** `PENDING`
- **Sign-Off Block:**
  ```
  DECISION SELECTED: [                              ]
  APPROVAL DATE:     [                              ]
  APPROVED BY:       [                              ]
  ```

---

### Decision Gate 8: Target Architecture Confirmation
- **Why It Matters:** Establishes the technical baseline for the upgraded system: Laravel 13, PHP 8.4, PostgreSQL 15/16, React frontend, and strict UTF-8 Unicode encoding.
- **Available Options & Trade-Offs:**
  - **Option 8A (Clean-Slate Re-Platforming — Recommended):** Initialize clean Laravel 13 skeleton, port business services/models, connect to PostgreSQL with strict UTF-8 encoding (converting `certificates_icbd` from `latin1`).
  - **Option 8B (In-Place Step Upgrade):** Incrementally upgrade existing repository through Laravel 9 → 10 → 11 → 12 → 13 (high risk of Composer dependency solver conflicts).
- **Evidence Available:** Detailed version-by-version risk matrix in [`docs/laravel13-upgrade-audit/04-laravel13-upgrade-risks.md`](file:///c:/wamp64/www/innova-web/docs/laravel13-upgrade-audit/04-laravel13-upgrade-risks.md) and roadmap in [`09-incremental-upgrade-roadmap.md`](file:///c:/wamp64/www/innova-web/docs/laravel13-upgrade-audit/09-incremental-upgrade-roadmap.md).
- **Missing Confirmation:** Owner sign-off on Option 8A vs. 8B.
- **Status:** `PENDING`
- **Sign-Off Block:**
  ```
  DECISION SELECTED: [                              ]
  APPROVAL DATE:     [                              ]
  APPROVED BY:       [                              ]
  ```

---

## 4. Final Gate Determination

```
READY FOR OWNER DECISIONS
```

*All technical evidence, arithmetic reconciliations, and architectural options have been verified and documented. Implementation remains strictly paused until the project owner and institutional accounting record approvals on Decision Gates 1 through 8.*
