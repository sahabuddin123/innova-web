# Phase 2 — Architectural Decisions, Blockers & Owner Sign-Off Gate

**Project:** `innova-web` — INNOVA Computers BD (ICBD)  
**Audit Phase:** Phase 2 (Database Architecture Audit & Migration Planning — Audit Only)  
**Audit Date:** October 2026  
**Status:** READY FOR OWNER REVIEW — No Code, Configuration, or Database Changes Applied  

---

## 1. Executive Overview

This document presents the **8 critical architectural decisions** that require explicit project owner sign-off before any schema modification, migration creation, or database conversion can begin.

Because Phase 2 was strictly an **evidence-based, read-only audit**, no database writes, migrations, or code changes were executed. Every recommendation below is backed by confirmed facts from the live MySQL database (`icbd_web`, 52 tables, 15,663 records) and repository source code.

---

## 2. Master Decision Gates for Owner Review

### Decision Gate 1: Reverse-Engineering Migrations for 5 Unmigrated Production Tables
- **Current State:** Five tables exist in the production MySQL database and are actively managed by models and admin controllers, but have **zero migration files** in `database/migrations/`:
  1. `bank_loans` (7 rows, 16 columns)
  2. `emi_installments` (71 rows, 15 columns)
  3. `investment_withdraws` (11 rows, 20 columns)
  4. `dividend_withdraws` (1 row, 20 columns)
  5. `certificates_icbd` (38 rows, 16 columns)
- **The Problem:** Running `php artisan migrate:fresh` on a new server will completely omit these 5 modules, breaking loan management, EMI payments, shareholder ledgers, and institute certificate verification.
- **Architectural Proposal:** In Phase 3, generate authoritative Laravel migration files for these 5 tables using the exact live database schema captured during this audit.
- **Decision Required:**
  - **Option 1A (Recommended):** Approve generation of formal Laravel migrations for all 5 unmigrated tables.
  - **Option 1B:** Retire or archive any of these modules if they are no longer needed by INNOVA Computers BD.

---

### Decision Gate 2: Resolution of Triplicate `CreateSessionsTable` & Domain Entity Collision
- **Current State:**
  - File 1: [`database/migrations/2022_08_19_163812_create_sessions_table.php`](file:///c:/wamp64/www/innova-web/database/migrations/2022_08_19_163812_create_sessions_table.php) defines the **academic session** entity (`sessionName`, `startdate`, `enddate`, `IsActive`) used by students, registrations, and certificates.
  - File 2 & 3: [`database/migrations/2024_07_13_012857_create_sessions_table.php`](file:///c:/wamp64/www/innova-web/database/migrations/2024_07_13_012857_create_sessions_table.php) and [`2024_07_16_031214_create_sessions_table.php`](file:///c:/wamp64/www/innova-web/database/migrations/2024_07_16_031214_create_sessions_table.php) both attempt to create the Laravel **HTTP session storage table** (`id`, `payload`, `last_activity`).
  - Both PHP class name `CreateSessionsTable` and database table name `sessions` collide!
- **The Problem:** Fresh migration immediately crashes. Furthermore, `certificates` and `registrations` have foreign keys pointing to `sessions.id` (meaning the academic session).
- **Architectural Proposal:**
  1. Rename the academic entity table to `academic_sessions` and update [`App\Models\Session.php`](file:///c:/wamp64/www/innova-web/app/Models/Session.php) to use `protected $table = 'academic_sessions';` (or create `AcademicSession.php` with backward-compatible alias).
  2. Update foreign keys in `certificates` and `registrations` to point to `academic_sessions(id)`.
  3. Convert all migrations to Laravel anonymous class syntax (`return new class extends Migration { ... };`) to prevent class name redeclaration crashes.
  4. Allow the single Laravel HTTP session table migration to create standard `sessions`.
- **Decision Required:**
  - **Option 2A (Recommended):** Approve table rename to `academic_sessions` and anonymous migration syntax conversion.
  - **Option 2B:** Retain `sessions` for academic sessions and use Redis / file driver for HTTP sessions (not recommended: breaks standard Laravel ecosystem conventions).

---

### Decision Gate 3: Deduplication of `fees_transections.trxID` (IDs 332 to 337)
- **Current State:**
  - The live database contains 1,604 payment records in `fees_transections`.
  - 1,598 rows have `trxID IS NULL` (counter / cash receipts).
  - 0 rows have empty strings.
  - Exactly **1 duplicate transaction key (masked `AAN****SE0`) exists across 6 distinct rows** (`ids: 332, 333, 334, 335, 336, 337`) recorded on `2023-01-23` between `08:20:02` and `09:01:30`.
- **The Problem:** Applying a standard `UNIQUE(trxID)` constraint during migration will fail immediately on these 6 rows.
- **Architectural Proposal:**
  - **Step 1 (Deduplication):** In consultation with INNOVA accounting, review whether IDs 333–337 were redundant duplicate payment submissions for the same bKash transaction.
  - **Step 2 (PostgreSQL Schema):** Implement a **PostgreSQL partial unique index**:
    ```sql
    CREATE UNIQUE INDEX fees_transections_trxid_unique 
    ON fees_transections ("trxID") 
    WHERE "trxID" IS NOT NULL AND TRIM("trxID") != '';
    ```
    This accommodates all 1,598 legitimate cash transactions with `NULL` transaction IDs while guaranteeing absolute concurrency protection against duplicate bKash payments going forward.
- **Decision Required:**
  - **Option 3A (Recommended):** Audit IDs 332–337 with accounting; soft-delete or merge confirmed duplicates, and implement the PostgreSQL partial unique index.
  - **Option 3B:** Retain duplicate rows by appending an audit suffix (`AAN****SE0_DUP_1`) to preserve historical ledger records while enforcing uniqueness on future payments.

---

### Decision Gate 4: Financial Amount Normalization (`VARCHAR` → `NUMERIC(15,2)`)
- **Current State:** Six tables (`expanses`, `incomes`, `fees_transections`, `students`, `invesments`, `courses`) store monetary figures as `VARCHAR(191)` strings, occasionally with formatted commas (`'15,000'`).
- **The Problem:**
  1. Direct import into PostgreSQL `NUMERIC` fails on comma-formatted strings.
  2. In PHP 8+, mathematical operations on comma-formatted strings truncate values (e.g. `'15,000'` evaluates to `15`), introducing silent accounting discrepancies.
  3. SQL queries in [`ReportController.php:57, 108`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/ReportController.php#L57) are forced to run costly `REPLACE(amount, ',', '')` operations.
- **Architectural Proposal:**
  Migrate all monetary fields to `NUMERIC(15, 2) NOT NULL DEFAULT 0.00` using an ETL cleansing script that strips commas and non-numeric characters during data transfer.
- **Decision Required:**
  - **Option 4A (Recommended):** Approve conversion of all financial columns to `NUMERIC(15,2)`.
  - **Option 4B:** Keep financial columns as `VARCHAR` (strongly discouraged: perpetuates technical debt and financial calculation bugs).

---

### Decision Gate 5: Conversion of 14 Zero Dates (`0000-00-00`) to `NULL`
- **Current State:** 14 records in the live database contain `'0000-00-00'`:
  - `expanses.invoiceDate`: 6 rows
  - `incomes.invoiceDate`: 8 rows
- **The Problem:** PostgreSQL strictly rejects `'0000-00-00'` with SQL State 22008 (`date out of range`).
- **Architectural Proposal:** Convert all 14 `'0000-00-00'` occurrences to `NULL` during data migration.
- **Decision Required:**
  - **Option 5A (Recommended):** Approve conversion of zero dates to `NULL`.

---

### Decision Gate 6: Conversion of 14 MyISAM Tables to PostgreSQL Strict Transactional Tables
- **Current State:** 14 tables in the live MySQL database (`bank_loans`, `emi_installments`, `investment_withdraws`, `dividend_withdraws`, `asset_courses`, `asset_registrations`, `asset_registration_feedbacks`, `clients`, `concerns`, `products`, `services`, `teams`, `technologies`, `workflows`) use the `MyISAM` engine.
- **The Problem:** MyISAM does not support database transactions or foreign-key constraints.
- **Architectural Proposal:** Migrate all 14 tables to PostgreSQL standard transactional tables and apply explicit foreign-key constraints with `ON DELETE RESTRICT` (or `CASCADE` where appropriate).
- **Decision Required:**
  - **Option 6A (Recommended):** Approve full conversion to standard transactional tables with foreign keys.

---

### Decision Gate 7: Table & Column Misspelling Modernization (Technical Debt)
- **Current State:** The legacy MySQL schema contains several misspelled identifiers:
  - `expanses` → `expenses`
  - `expanse_categoris` → `expense_categories`
  - `income_categoris` → `income_categories`
  - `fees_transections` → `fees_transactions`
  - `invesments` → `investments`
  - `batchs` → `batches`
- **Architectural Proposal:**
  - **Approach 1 (Conservative):** Retain legacy misspelled table names in PostgreSQL during the initial migration to minimize changes to existing Eloquent models, then rename during the Laravel 13 refactoring phase.
  - **Approach 2 (Modernize at Cutover):** Create PostgreSQL tables with correct English names, and create PostgreSQL `VIEW`s aliasing the legacy names (`CREATE VIEW expanses AS SELECT * FROM expenses;`), allowing old models to work seamlessly while new code uses modern naming.
- **Decision Required:**
  - **Option 7A (Conservative — Recommended for Safety):** Retain legacy table names during initial database cutover; rename during application modernization.
  - **Option 7B (Clean Architecture):** Rename tables to standard English in PostgreSQL with database backward-compatibility views.

---

### Decision Gate 8: React Frontend & Full-System Modernization Alignment
- **Target Architecture:** Laravel 13, PHP 8.4, React frontend, BN/EN i18n.
- **Database Alignment Needs:**
  1. **Consistent API Contracts:** Timestamps and dates must serialize to ISO 8601 strings (`2026-10-23T17:35:00Z`) for React consumption.
  2. **Auditability:** Retain `created_by` / `updated_by` admin references across all financial and loan tables.
  3. **Bangla / English i18n:** Ensure all text and character columns use standard `UTF-8` encoding. The live audit verified that `certificates_icbd` currently uses `latin1_swedish_ci`, which must be converted to `UTF-8` to prevent Bangla character corruption.
- **Decision Required:**
  - **Option 8A (Recommended):** Approve these modernization baseline constraints for the target PostgreSQL schema.

---

## 3. Mandatory Stop Gate Verification

In strict accordance with the task instructions:
- **No Laravel or PHP upgrades were attempted.**
- **No Composer dependencies were installed or changed.**
- **No database migrations or seeders were run.**
- **No data was modified, inserted, updated, or deleted.**
- **No production dumps were exported.**
- **No credentials or secrets were exposed.**
- **Branch remains strictly on `feature/phase-1-security-hardening`.**

Execution is paused. All database findings and architectural options are submitted for owner review and decision.
