# Database Schema Reconciliation Plan & Migration Strategy

**Project:** INNOVA Computers BD (`innova-web`)  
**Scope:** Migration Reconciliation Strategy & Architectural Rollout Plan  
**Status:** Approved Actions Implemented; Gated Items Documented for Owner Sign-Off  
**Date:** October 2026  
**Auditor:** Senior Database Architect & Migration Specialist  

---

## 1. Executive Summary & Strategy Framework

The database schema reconciliation plan bridges the gap between the live operational MySQL database (`icbd_web`, 52 tables, 15,663 records) and the Laravel migration codebase (59 files).

### Guiding Principles:
1. **Zero Production Mutation:** The active MySQL database remains completely untouched. No DDL, migrations, or data writes are executed against `icbd_web`.
2. **Preserve Operational Schema:** All 23 manually added fields and 5 unmigrated tables actively utilized by business logic are preserved in canonical documentation and forward migrations.
3. **Defense-in-Depth Idempotence:** All new reconciliation migrations employ `Schema::hasTable` and `Schema::hasColumn` guards. If executed in a future rollout on an existing database, they safely no-op; if executed on a fresh database, they construct the complete, correct schema.
4. **Owner Gating on Semantic Changes:** Any structural change that renames business entities (such as academic `sessions`), alters business data semantics, or resolves conflicting historical migrations is presented as an explicit Decision Gate for owner review.

---

## 2. Classification of Changes by Strategy Case

Every finding from the Reconciliation Matrix is mapped to an authoritative strategy case:

### Case A — Unreleased or Safely Editable Historical Migrations
- **Applies to:** None. All historical migrations in `database/migrations/` represent deployed or historical system states. Rewriting historical files was avoided to prevent breaking rollback chains or diverging from Git history.

### Case B — Migrations Already Executed in Existing Installations (Forward Migration Strategy)
- **Applies to:** 
  1. The 5 unmigrated production tables (`bank_loans`, `emi_installments`, `investment_withdraws`, `dividend_withdraws`, `certificates_icbd`).
  2. The 23 manually added columns across 5 operational tables (`users`, `fees_transections`, `courses`, `course_categories`, `teachers`).
- **Action Completed:** Authored 6 forward, idempotent, anonymous migrations:
  - `2026_10_24_000001_create_bank_loans_table.php`
  - `2026_10_24_000002_create_emi_installments_table.php`
  - `2026_10_24_000003_create_investment_withdraws_table.php`
  - `2026_10_24_000004_create_dividend_withdraws_table.php`
  - `2026_10_24_000005_create_certificates_icbd_table.php`
  - `2026_10_24_000006_reconcile_manually_added_columns.php`

### Case C — Manually Added Columns with Established Application Usage
- **Applies to:**
  - `fees_transections.channel`, `trxID`, `paymentID`, `status`: Actively used by bKash payment verification (`BkashController`) and student fee auditing.
  - `courses.IsCourse`, `courseFor`, `Instructor`, `Rating`, `TotalReview`, `Discount`, `views`: Actively used by public course catalog and frontend views.
  - `course_categories.fontawesome`, `isFeature`, `tabId`: Actively used by category cards and UI navigation tabs.
  - `teachers.email`, `ComCourse`, `nStd`, `rating`, `review`, `isTeacher`, `IsFeatured`, `bio`: Actively used by teacher listings and team sections.
  - `users.name`: Used by student profile authentication and registration.
- **Action Completed:** Captured in `2026_10_24_000006_reconcile_manually_added_columns.php` with exact data types, nullabilities, and defaults matching live MySQL.

### Case D — Data Type & Constraint Mismatches
- **Applies to:**
  - `courses.coursefee`: Live MySQL is `decimal(10,2) NOT NULL`; migration `2022_08_12` had `string('coursefee')`. Preserved live `decimal(10,2)`.
  - `registrations.PassYear`: Live MySQL is `varchar(255) NULL`; migration `2022_08_19` had `date('PassYear')`. Stored values are 4-digit years (`2023`). Preserved `varchar(255)` to prevent truncation.
  - `fees_transections.trxID`: Live MySQL has 1 duplicate key across 6 rows (`ids 332-337`). Must NOT have an unconditional unique constraint in MySQL; must use a PostgreSQL partial unique index (`WHERE trxID IS NOT NULL AND TRIM(trxID) != ''`).

### Case E — Missing Tables or Conflicting Historical Migrations (Owner Sign-Off Required)
- **Applies to:**
  - Triplicate `sessions` migrations (Decision Gate 2).
  - Duplicate ASSET migration pairs (`asset_courses`, `asset_students`) (Decision Gate 7).
  - Migration ordering dependency (`courses` FK pointing to `course_categories` before creation) (Decision Gate 8).

---

## 3. Changes Made to Migration Files

Six new forward migrations were authored in `database/migrations/`:

| Migration File | Entity Handled | Strategy & Safety Mechanism |
|---|---|---|
| `2026_10_24_000001_create_bank_loans_table.php` | `bank_loans` | Anonymous class; wrapped in `if (!Schema::hasTable('bank_loans'))`. Creates complete 16-column schema. |
| `2026_10_24_000002_create_emi_installments_table.php` | `emi_installments` | Anonymous class; wrapped in `if (!Schema::hasTable('emi_installments'))`. Creates complete 15-column schema. |
| `2026_10_24_000003_create_investment_withdraws_table.php` | `investment_withdraws` | Anonymous class; wrapped in `if (!Schema::hasTable('investment_withdraws'))`. Creates complete 20-column schema. |
| `2026_10_24_000004_create_dividend_withdraws_table.php` | `dividend_withdraws` | Anonymous class; wrapped in `if (!Schema::hasTable('dividend_withdraws'))`. Creates complete 20-column schema. |
| `2026_10_24_000005_create_certificates_icbd_table.php` | `certificates_icbd` | Anonymous class; wrapped in `if (!Schema::hasTable('certificates_icbd'))`. Creates complete 16-column schema with `certificate_no` unique key. |
| `2026_10_24_000006_reconcile_manually_added_columns.php` | 23 Columns across 5 Tables | Anonymous class; each table checked via `Schema::hasTable` and each column checked via `if (!Schema::hasColumn)`. Completely non-destructive. |

---

## 4. Deferred Architectural Actions & Owner Decision Gates

The following items are deferred pending explicit project owner sign-off:

### Decision Gate 1: Entity Name Collision — Academic Sessions vs. HTTP Sessions
- **Current State:** Table `sessions` in MySQL is the academic session entity (`App\Models\Session`). Two unexecuted migrations (`2024_07_13_012857` and `2024_07_16_031214`) attempt to create a Laravel HTTP database session table named `sessions`.
- **Options for Owner:**
  - **Option 1A (Recommended):** Rename the academic entity table to `academic_sessions` in the future PostgreSQL migration, and update `App\Models\Session::$table = 'academic_sessions'`. Allow Laravel HTTP session driver to use standard `sessions`.
  - **Option 1B:** Keep `sessions` as the academic entity permanently and configure Laravel HTTP sessions to use file or Redis cache storage (`SESSION_DRIVER=file`).
- **Status:** Deferred to PostgreSQL migration phase.

### Decision Gate 2: Duplicate ASSET Migrations Retirement
- **Current State:** 
  - `2026_05_20_000000` vs `2026_05_20_000300` for `asset_courses`
  - `2026_05_20_000001` vs `2026_05_20_000400` for `asset_students`
- **Options for Owner:**
  - **Option 2A (Recommended):** Convert legacy draft migrations (`000000` and `000001`) into anonymous classes or archive them to an `archive/` folder so clean installs run without class collisions.
  - **Option 2B:** Consolidate ASSET migrations during Phase 2.7.4 (ASSET Project APIs).
- **Status:** Deferred to Phase 2.7.4.

### Decision Gate 3: Deduplication of `fees_transections.trxID` (IDs 332 to 337)
- **Current State:** 6 distinct rows on 2023-01-23 share the same bKash transaction key (`AAN****SE0`).
- **Options for Owner:**
  - **Option 3A (Recommended):** Audit IDs 332–337 with accounting; soft-delete or merge confirmed duplicates, and implement the PostgreSQL partial unique index (`WHERE trxID IS NOT NULL AND TRIM(trxID) != ''`).
  - **Option 3B:** Retain duplicate rows by appending an audit suffix (`_DUP_1`) to preserve historical ledger records while enforcing uniqueness on future payments.
- **Status:** Deferred to PostgreSQL migration phase.

### Decision Gate 4: Financial Column Type Normalization (`VARCHAR` → `NUMERIC(15,2)`)
- **Current State:** Six tables (`expanses`, `incomes`, `fees_transections`, `students`, `invesments`, `courses`) store monetary values as `VARCHAR(191)` strings with occasional commas (`'15,000'`).
- **Options for Owner:**
  - **Option 4A (Recommended):** Normalize all monetary fields to `NUMERIC(15,2)` during PostgreSQL ETL migration with comma-cleansing.
  - **Option 4B:** Maintain `VARCHAR` strings (strongly discouraged due to silent math truncation in PHP 8+).
- **Status:** Deferred to PostgreSQL ETL phase.

---

## 5. Safe Rollout Strategy for Future Environments

When deploying this repository to a new environment (e.g., staging, Docker, or PostgreSQL):

1. **Clean Installation Pipeline:**
   - Run core base migrations.
   - Forward migrations `2026_10_24_000001` through `000006` automatically create all 5 formerly unmigrated tables and all 23 manual columns.
   - Result: 100% schema parity with live production MySQL.
2. **Existing Production MySQL Database:**
   - Under no circumstances should `php artisan migrate` be run against live `icbd_web` without prior maintenance window sign-off.
   - If executed in the future, the defensive `hasTable` and `hasColumn` checks ensure zero destructive mutations.
3. **Automated Testing Isolation:**
   - All PHPUnit tests continue executing in isolated in-memory SQLite (`:memory:`), completely decoupled from MySQL.
