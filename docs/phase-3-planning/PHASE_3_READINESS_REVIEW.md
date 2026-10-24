# Phase 3 — Implementation Readiness & Safety Gate Review (Audit Only)

**Project:** `innova-web` — INNOVA Computers BD (ICBD)  
**Phase:** Phase 3 Readiness Review & Safety Gate Audit  
**Author:** Senior Database Migration Architect & Lead Engineer  
**Date:** October 2026  
**Active Git Branch:** `feature/phase-1-security-hardening`  
**Operational Database:** `icbd_web` on MySQL 8.0.31 (`127.0.0.1:3306`, 52 Tables, 15,663 Records)  
**Audit Documents Inspected:**
- [`docs/phase-3-planning/PHASE_3_MIGRATION_RECONSTRUCTION_PLAN.md`](file:///c:/wamp64/www/innova-web/docs/phase-3-planning/PHASE_3_MIGRATION_RECONSTRUCTION_PLAN.md)
- [`docs/phase-2-database/PHASE_2_DATABASE_INVENTORY.md`](file:///c:/wamp64/www/innova-web/docs/phase-2-database/PHASE_2_DATABASE_INVENTORY.md)
- [`docs/phase-2-database/PHASE_2_SCHEMA_DRIFT_REPORT.md`](file:///c:/wamp64/www/innova-web/docs/phase-2-database/PHASE_2_SCHEMA_DRIFT_REPORT.md)
- [`docs/phase-2-database/PHASE_2_POSTGRESQL_COMPATIBILITY.md`](file:///c:/wamp64/www/innova-web/docs/phase-2-database/PHASE_2_POSTGRESQL_COMPATIBILITY.md)
- [`docs/phase-2-database/PHASE_2_DATA_MIGRATION_PLAN.md`](file:///c:/wamp64/www/innova-web/docs/phase-2-database/PHASE_2_DATA_MIGRATION_PLAN.md)
- [`docs/phase-2-database/PHASE_2_BLOCKERS_AND_DECISIONS.md`](file:///c:/wamp64/www/innova-web/docs/phase-2-database/PHASE_2_BLOCKERS_AND_DECISIONS.md)

---

## 1. Executive Summary & Safety Gate Determination

This audit evaluates whether the project is genuinely ready to begin physical implementation of the Phase 3 migration reconstruction plan.

The Phase 3 planning document provides a thorough, evidence-based architectural blueprint that accurately reflects the Phase 2 live database audit across 52 tables and 15,663 operational records. However, **physical implementation cannot safely begin at this time**.

### Gate Determination:
```
NOT READY — OWNER DECISIONS OR SAFETY PREREQUISITES PENDING
```

### Core Grounds for Determination:
1. **Zero Owner Decisions Signed Off:** None of the 8 mandatory architectural decision gates established in Phase 2 have received formal project owner sign-off.
2. **Missing Pre-Implementation Safety Infrastructure:**
   - No verified, cold cryptographic backup dump of the live database (`icbd_web`) has been generated or tested for restoration.
   - No isolated disposable database environment (`icbd_disposable_mysql` or `icbd_disposable_pgsql`) is currently provisioned.
   - The active `.env` configuration still directly targets the live operational database `icbd_web`. Executing any Artisan migration command would risk live production data.
3. **Unverified Schema & Data Assumptions:**
   - Casting `batchs.totalseat` (`varchar(191)`) to `INTEGER` assumes all 65 rows contain valid numeric data, but this has not been verified against live values.
   - Zero-date audits (`0000-00-00`) were confirmed for `expanses` (6 rows) and `incomes` (8 rows), but 12+ other date/datetime columns across the database have not been comprehensively scanned.
   - Currency normalization assumes all monetary strings contain only digits and commas, but non-numeric tokens (e.g. `"-"`, `"N/A"`, spaces) have not been exhaustively audited across 13,000+ financial records.
   - Potential Bengali glyph corruption in `certificates_icbd` (due to legacy `latin1_swedish_ci` collation) has not been verified on actual stored text.
4. **Historical Migration File Mutation Risks:**
   - The plan proposes deleting and renaming historical migration files. If deployed to any existing database tracking these files in `migrations`, this will break Laravel migration status and rollback mechanisms.
5. **Application Code Breakage from Table Renaming:**
   - Renaming `sessions` to `academic_sessions` resolves migration collisions, but static analysis discovered raw query builder calls (`DB::table('sessions')`) in [`app/Http/Controllers/UserController.php:263`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/UserController.php#L263) and [`app/Http/Controllers/Admin/SessionController.php:34, 140`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/SessionController.php#L34) that would break immediately unless patched simultaneously.

---

## 2. Objective 1: Schema Parity & Column-Level Evidence Verification

Every table definition and column type proposed in the Phase 3 reconstruction plan was audited against the live MySQL `icbd_web` database schema recorded in Phase 2:

### 2.1 Five Unmigrated Production Tables
The proposed schemas for all 5 unmigrated tables match the live database exactly:

| Table Name | Proposed Columns | Live DB Evidence | Collation & Engine | Parity Verdict |
|---|---|---|---|---|
| `bank_loans` | 16 columns (`id`, `shareholder_id`, `bank_name`, `loan_amount`, `interest_rate`, `loan_term_months`, `loan_date`, `maturity_date`, `installment_count`, `savings_amount`, `status`, `remarks`, `created_by`, `created_at`, `updated_at`, `deleted_at`) | Verified in [`PHASE_2_DATABASE_INVENTORY.md:215-219`](file:///c:/wamp64/www/innova-web/docs/phase-2-database/PHASE_2_DATABASE_INVENTORY.md#L215-L219) (7 rows) | MyISAM / `utf8mb4_unicode_ci` | **MATCH (100% Verified)** |
| `emi_installments` | 15 columns (`id`, `bank_loan_id`, `shareholder_id`, `emi_amount`, `savings_amount`, `payment_date`, `payment_method`, `paid_by`, `received_by`, `paid_at`, `status`, `remarks`, `created_at`, `updated_at`, `deleted_at`) | Verified in [`PHASE_2_DATABASE_INVENTORY.md:221-225`](file:///c:/wamp64/www/innova-web/docs/phase-2-database/PHASE_2_DATABASE_INVENTORY.md#L221-L225) (71 rows) | MyISAM / `utf8mb4_unicode_ci` | **MATCH (100% Verified)** |
| `investment_withdraws` | 20 columns (`id`, `shareholder_id`, `amount`, `withdraw_date`, `method`, `branch_name`, `receiver_name`, `pay_by`, `account_number`, `status`, `requested_by`, `requested_at`, `processed_by`, `processed_at`, `processed_remarks`, `remarks`, `attachment`, `created_at`, `updated_at`, `deleted_at`) | Verified in [`PHASE_2_DATABASE_INVENTORY.md:227-231`](file:///c:/wamp64/www/innova-web/docs/phase-2-database/PHASE_2_DATABASE_INVENTORY.md#L227-L231) (11 rows) | MyISAM / `utf8mb4_unicode_ci` | **MATCH (100% Verified)** |
| `dividend_withdraws` | 20 columns (Identical structure to `investment_withdraws`) | Verified in [`PHASE_2_DATABASE_INVENTORY.md:233-237`](file:///c:/wamp64/www/innova-web/docs/phase-2-database/PHASE_2_DATABASE_INVENTORY.md#L233-L237) (1 row) | MyISAM / `utf8mb4_unicode_ci` | **MATCH (100% Verified)** |
| `certificates_icbd` | 16 columns (`id`, `student_id`, `batch_id`, `course_id`, `certificate_no`, `theory_hours`, `practical_hours`, `intern_hours`, `result`, `issue_date`, `certificate_receiver`, `delivery_date`, `is_active`, `created_at`, `updated_at`, `deleted_at`) | Verified in [`PHASE_2_DATABASE_INVENTORY.md:239-243`](file:///c:/wamp64/www/innova-web/docs/phase-2-database/PHASE_2_DATABASE_INVENTORY.md#L239-L243) (38 rows) | InnoDB / `latin1_swedish_ci` | **MATCH (100% Verified)** |

### 2.2 Unmigrated Drifted Columns (Count Reconciliation: 24 Columns)
Section 4.2 of the Phase 3 plan is titled *"Twenty-Three Unmigrated Columns Across Six Tables"*, but an itemized count of the table confirms **24 distinct unmigrated columns**:

1. `fees_transections` (4 columns): `channel` (int), `trxID` (varchar 255), `paymentID` (varchar 255), `status` (int).
2. `courses` (7 columns): `IsCourse` (int), `courseFor` (varchar 255), `Instructor` (varchar 255), `Rating` (varchar 255), `TotalReview` (varchar 255), `Discount` (varchar 255), `views` (int).
3. `teachers` (8 columns): `email` (varchar 191), `ComCourse` (varchar 255), `nStd` (varchar 255), `rating` (varchar 255), `review` (varchar 255), `isTeacher` (int), `IsFeatured` (int), `bio` (text).
4. `course_categories` (3 columns): `fontawesome` (varchar 191), `isFeature` (int), `tabId` (varchar 191).
5. `admins` (1 column): `remember_token` (varchar 100).
6. `users` (1 column): `name` (varchar 191).

**Calculation:** 4 + 7 + 8 + 3 + 1 + 1 = **24 Columns**.  
*Finding:* All 24 columns are confirmed present in the live database and actively queried in controller code. The title of Section 4.2 contains a minor typographical counting error (23 vs. 24) that should be corrected.

### 2.3 Proposed Column Types vs. Phase 2 Schema Evidence
- **Monetary Normalization:** Converting `VARCHAR(191)` in `expanses`, `incomes`, `fees_transections`, `students`, `invesments` to `NUMERIC(15,2)` is fully supported by live data evidence. In `courses`, `coursefee` is already stored as `decimal(10,2)` in MySQL.
- **Academic Status Multi-State:** Defining `students.IsActive` as `SMALLINT` (not `BOOLEAN`) is verified against [`app/Http/Controllers/Admin/StudentsController.php:84, 106, 128, 150`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/StudentsController.php#L84), where statuses 1 (Active), 2 (Irregular), 3 (Complete), 4 (Restricted), and 5 (Postponed) are explicitly queried. Coercing to `BOOLEAN` would destroy this domain logic.

---

## 3. Objective 2: Unverified Assumptions & Blind Spots

The review identified 6 critical assumptions in the Phase 3 plan that have not been fully verified against the live database:

```
+---------------------------------------------------------------------------------------------------+
| Finding ID | Severity | Assumption Description                               | Verification Status |
+---------------------------------------------------------------------------------------------------+
| ASSUME-01  | High     | batchs.totalseat is safely castable to INTEGER       | Unverified          |
| ASSUME-02  | High     | Zero-date presence is restricted to 14 rows          | Unverified          |
| ASSUME-03  | Medium   | Monetary string values contain only digits & commas   | Unverified          |
| ASSUME-04  | High     | certificates_icbd Latin1 text contains valid Bengali  | Unverified          |
| ASSUME-05  | Medium   | Application does not break on batch_id model fix     | Unverified          |
| ASSUME-06  | Low      | Ghost tables assets & asset_students are required    | Unverified          |
+---------------------------------------------------------------------------------------------------+
```

### Detailed Breakdown:

#### 1. Finding ASSUME-01: `batchs.totalseat` Integer Casting
- **Severity:** High
- **Supporting Evidence:** The Phase 3 matrix (row 7) specifies casting `batchs.totalseat` (`varchar(191)`) to `INTEGER`. In MySQL, free-form text input can contain values like `"40 seats"`, `"TBA"`, `""`, or `NULL`. No query was executed during Phase 2 to verify that all 65 rows in `batchs.totalseat` consist strictly of digits.
- **Risk:** In PostgreSQL, `CAST(totalseat AS INTEGER)` will abort with `ERROR: invalid input syntax for type integer: "40 seats"` if any non-digit string exists.
- **Status:** Unverified against live data.
- **Required Owner Decision:** Confirm fallback handling (e.g. default to 0 or null if invalid string encountered).
- **Recommended Safe Next Action:** Run a read-only query checking all 65 values:
  `SELECT DISTINCT totalseat FROM batchs WHERE totalseat REGEXP '[^0-9]';`

#### 2. Finding ASSUME-02: Universal Scope of Zero Dates (`0000-00-00`)
- **Severity:** High
- **Supporting Evidence:** Phase 2 audited `expanses.invoiceDate` (6 rows) and `incomes.invoiceDate` (8 rows) and found 14 zero-date occurrences. However, at least 12 other date/datetime columns exist across the database:
  - `students.dob`, `students.admission_date`
  - `fees_transections.paiddate`
  - `bank_loans.loan_date`, `bank_loans.maturity_date`
  - `emi_installments.payment_date`, `emi_installments.paid_at`
  - `investment_withdraws.withdraw_date`, `requested_at`, `processed_at`
  - `dividend_withdraws.withdraw_date`, `requested_at`, `processed_at`
  - `certificates_icbd.issue_date`, `certificates_icbd.delivery_date`
  - `teachers.dob`, `teachers.joiningdate`
  - `sessions.startdate`, `sessions.enddate`
  - `registrations.reg_date`, `issue_date`
  - `expanses.createDate`, `incomes.createDate`
- **Risk:** If any uninspected date column contains `'0000-00-00'`, PostgreSQL restore will terminate with SQL State 22008 (`date out of range`).
- **Status:** Unverified for non-expense/non-income tables.
- **Required Owner Decision:** Decision Gate 5 (Approve sanitizing ALL zero dates to `NULL`).
- **Recommended Safe Next Action:** Execute a read-only scanning query across all date/datetime columns in all 52 tables before migration scripting.

#### 3. Finding ASSUME-03: Monetary String Cleansing
- **Severity:** Medium
- **Supporting Evidence:** The proposed ETL cleansing regex `REGEXP_REPLACE(TRIM(amount), '[^0-9.]', '', 'g')` removes all non-numeric characters. However, if any row contains negative values (`"-500"`), currency prefixes (`"Tk 1500"`), European notation (`"1.500,00"`), or placeholders (`"N/A"`, `"-"`), naive stripping can alter values or create silent accounting discrepancies.
- **Status:** Unverified across all 13,000+ financial rows.
- **Required Owner Decision:** Decision Gate 4.
- **Recommended Safe Next Action:** Run a dry-run anomaly report listing any records in `expanses`, `incomes`, `fees_transections`, `students`, and `invesments` containing characters other than digits, commas, and periods.

#### 4. Finding ASSUME-04: `certificates_icbd` Collation and Character Corruption
- **Severity:** High
- **Supporting Evidence:** `certificates_icbd` uses `latin1_swedish_ci` collation. If Bengali student names or institute details were inserted into this table in MySQL, MySQL may have corrupted the byte sequence into replacement characters (`????`).
- **Risk:** Converting `latin1` to `UTF8` in PostgreSQL will preserve existing question marks (`????`), resulting in permanent data corruption that cannot be recovered after cutover.
- **Status:** Unverified. Live string contents have not been visually inspected.
- **Required Owner Decision:** Decision Gate 8.
- **Recommended Safe Next Action:** Perform a read-only query inspecting all 38 rows of `certificates_icbd` to confirm whether Bengali text is intact or corrupted.

#### 5. Finding ASSUME-05: Model Relationship Bug in `Certificate_icbd`
- **Severity:** Medium
- **Supporting Evidence:** In [`app/Models/Certificate_icbd.php:24`](file:///c:/wamp64/www/innova-web/app/Models/Certificate_icbd.php#L24), the `batch_id` foreign key is mapped as `belongsTo(Branch::class, 'batch_id')`. The Phase 2 referential check confirmed that in the database, `batch_id` values match `batchs.id` (0 orphans). Phase 3 proposes correcting this model relation to `Batchs::class`.
- **Risk:** If any Blade template or controller currently invokes `$cert->batch->branchName` or relies on the incorrect `Branch` model return type, fixing the relationship will trigger a PHP fatal error in the view.
- **Status:** Requires static analysis of views consuming `Certificate_icbd`.
- **Required Owner Decision:** None (Bug fix).
- **Recommended Safe Next Action:** Audit all Blade templates in `resources/views/admin/certificate/` to verify how `$cert->batch` is accessed.

#### 6. Finding ASSUME-06: Ghost Tables `assets` and `asset_students`
- **Severity:** Low
- **Supporting Evidence:** Migrations `2026_05_19_000000` and `2026_05_20_000001/000400` define `assets` and `asset_students`, but neither table exists in the live MySQL database. Phase 2 confirmed that trainee leads are stored in `asset_registrations`. Phase 3 proposes creating both tables in the reconstructed migration suite.
- **Risk:** Creating unused empty tables adds clutter; alternatively, omitting them might break code if an untested feature instantiates `Asset` or `AssetStudent`.
- **Status:** Inferred from code.
- **Required Owner Decision:** Confirm whether the ASSET project student intake module requires `assets` and `asset_students` tables, or if `asset_registrations` is the sole operational entity.
- **Recommended Safe Next Action:** Query codebase for `Asset::` and `AssetStudent::` usage.

---

## 4. Objective 3: Structural Conflicts & Collision Handling Review

### 4.1 Triplicate `CreateSessionsTable` & Domain Entity Collision
- **Audit Review:** The Phase 3 plan proposes:
  1. Renaming the academic session migration class from `CreateSessionsTable` to `CreateAcademicSessionsTable`.
  2. Renaming the database table to `academic_sessions`.
  3. Updating [`app/Models/Session.php`](file:///c:/wamp64/www/innova-web/app/Models/Session.php) to use `protected $table = 'academic_sessions';`.
  4. Updating foreign keys in `certificates` and `registrations` to point to `academic_sessions(id)`.
  5. Allowing Laravel's HTTP database session table migration to create standard `sessions`.
- **Critical Codebase Finding (Potential Application Breakage):**
  Static code analysis discovered that the application does **not** consistently use the Eloquent model `Session::class`. Several controllers execute raw Query Builder calls directly on table `'sessions'`:
  - [`app/Http/Controllers/UserController.php:263`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/UserController.php#L263):
    ```php
    $session = DB::table('sessions')->where('deleted_at', null)->where('IsActive',1)->get();
    ```
  - [`app/Http/Controllers/Admin/SessionController.php:34`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/SessionController.php#L34):
    ```php
    $sessions = DB::table('sessions')->where('deleted_at', null)->get();
    ```
  - [`app/Http/Controllers/Admin/SessionController.php:140`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/SessionController.php#L140):
    ```php
    $session = DB::table('sessions')->where('id', $id)->update(['deleted_at' => $date]);
    ```
  - [`app/Repositories/SessionsRepository.php:72, 106`](file:///c:/wamp64/www/innova-web/app/Repositories/SessionsRepository.php#L72): Disk uploads reference `'sessions'`.
- **Impact:** If `sessions` is renamed to `academic_sessions` without refactoring these controllers, they will query the HTTP database session table (which lacks `sessionName`, `IsActive`, and `deleted_at`), immediately throwing SQL exceptions.
- **Remediation Requirement:** The Phase 3 plan must include an explicit code refactoring task updating all `DB::table('sessions')` calls to `DB::table('academic_sessions')` or `Session::query()`.

### 4.2 Handling of Duplicate Migration Classes
- The plan identifies:
  - `CreateSessionsTable` (3 files)
  - `CreateAssetCoursesTable` (2 files)
  - `CreateAssetStudentsTable` (2 files)
- Converting all migrations to Laravel 8.37+ anonymous class syntax (`return new class extends Migration { ... };`) completely eliminates PHP class redeclaration fatal errors without requiring class renames.

### 4.3 Circular Foreign-Key Dependency (`courses` vs. `course_categories`)
- In [`database/migrations/2022_08_12_080223_create_courses_table.php`](file:///c:/wamp64/www/innova-web/database/migrations/2022_08_12_080223_create_courses_table.php), a foreign key references `course_categories`, which is not created until `2024_12_17`.
- The proposed resolution (removing the inline constraint from the 2022 migration and applying it in a subsequent migration after `course_categories` exists) is sound, deterministic, and PostgreSQL-compliant.

---

## 5. Objective 4: Risks from Deleting or Renaming Historical Migration Files

The Phase 3 plan (Section 5.1 Option B) recommends:
1. Deleting redundant migration `2024_07_16_031214_create_sessions_table.php`.
2. Deleting duplicate `2026_05_20_000000_create_asset_courses_table.php`.
3. Deleting duplicate `2026_05_20_000001_create_asset_students_table.php`.
4. Renaming class/table in `2022_08_19_163812_create_sessions_table.php`.

### Architectural Risk Analysis:

| Risk Category | Failure Mechanism | Severity | Impact on Environments |
|---|---|---|---|
| **Broken Migration Status** | Laravel's `migrations` table stores physical filenames (e.g. `2022_08_19_163812_create_sessions_table`). If files are deleted or renamed, `php artisan migrate:status` flags them as missing. | **Medium** | Diagnostic tooling reports migration registry drift. |
| **Rollback Failure** | Running `php artisan migrate:rollback` attempts to resolve the recorded class file. If the file was deleted or renamed, rollback terminates with a file-not-found error. | **High** | Reversible deployments are broken. |
| **Incremental Execution Crash** | If an existing database with 24 recorded migrations is migrated against modified files, Laravel attempts to run newly named files as new migrations, causing `Table '...' already exists` crashes. | **Critical** | Cannot run migrations on existing databases. |

### Safe Strategy Recommendation:
- **Do not delete or rename migration files in place on the active branch.**
- Instead, adopt a two-tier strategy:
  1. For existing historical migrations that must be preserved: Wrap them in anonymous classes (`return new class extends Migration`) and add defensive `if (!Schema::hasTable(...))` guards.
  2. For the target PostgreSQL architecture: Author a clean, squashed baseline migration set (`2026_10_24_000001_create_innova_baseline_schema.php` or dependency-ordered anonymous migrations) intended specifically for fresh deployment into the disposable PostgreSQL staging database, bypassing historical file baggage entirely.

---

## 6. Objective 5: Status of Owner Decisions

All **8 critical decision gates** from Phase 2 remain pending owner review. Physical implementation cannot proceed without formal sign-off:

```
+----------------------------------------------------------------------------------------------------------------+
| Decision Gate | Description                                               | Status  | Required Sign-Off Option |
+----------------------------------------------------------------------------------------------------------------+
| Gate 1        | Reverse-engineer migrations for 5 unmigrated tables       | PENDING | Option 1A (Recommended)  |
| Gate 2        | Academic sessions vs HTTP sessions rename & collision fix | PENDING | Option 2A (Recommended)  |
| Gate 3        | fees_transections.trxID deduplication (IDs 332-337)       | PENDING | Option 3A (Accounting)   |
| Gate 4        | Monetary column conversion (VARCHAR -> NUMERIC(15,2))     | PENDING | Option 4A (Recommended)  |
| Gate 5        | Zero-date sanitization (0000-00-00 -> NULL)               | PENDING | Option 5A (Recommended)  |
| Gate 6        | 14 MyISAM tables conversion to strict transactional tables| PENDING | Option 6A (Recommended)  |
| Gate 7        | Table/column misspelling modernization (expanses, etc.)   | PENDING | Option 7A (Conservative) |
| Gate 8        | React frontend & modern target architecture baseline      | PENDING | Option 8A (Recommended)  |
+----------------------------------------------------------------------------------------------------------------+
```

> [!WARNING]
> Phase 3 Reconstruction Plan Section 10 only listed Gates 1 through 5. Gates 6, 7, and 8 must be formally included in the owner sign-off registry before implementation begins.

---

## 7. Objective 6: Minimum Backup, Recovery & Disposable-Database Requirements

Before any migration command, file generation, or ETL execution is permitted, the following minimum safety infrastructure must be established and verified:

### 7.1 Authoritative Cold Database Backup
1. **Cold Dump Command:**
   ```bash
   mysqldump --single-transaction --routines --triggers --hex-blob --default-character-set=utf8mb4 -u root -p icbd_web > backups/icbd_web_authoritative_pre_phase3.sql
   ```
2. **Cryptographic Checksum:**
   Generate and record a SHA-256 hash of the backup file:
   ```powershell
   Get-FileHash backups/icbd_web_authoritative_pre_phase3.sql -Algorithm SHA256
   ```
3. **Restore Verification Test:**
   Restore the dump into a temporary verification database (`icbd_web_verify_restore`) to ensure the dump is neither truncated nor corrupted:
   ```bash
   mysql -u root -p -e "CREATE DATABASE icbd_web_verify_restore CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
   mysql -u root -p icbd_web_verify_restore < backups/icbd_web_authoritative_pre_phase3.sql
   mysql -u root -p -e "SELECT COUNT(*) FROM icbd_web_verify_restore.expanses;" # Must equal 6,338
   mysql -u root -p -e "DROP DATABASE icbd_web_verify_restore;"
   ```
4. **Storage:** Store the backup in an immutable directory outside the web server root.

### 7.2 Isolated Disposable Database Environment
1. **Zero Production Interaction:** Under no circumstances should `php artisan migrate:fresh` be run against `icbd_web`.
2. **Dedicated Disposable Databases:**
   - MySQL disposable instance: `icbd_disposable_mysql`
   - PostgreSQL target instance: `icbd_disposable_pgsql`
3. **Configuration Isolation (`.env.testing`):**
   Create a dedicated `.env.testing` configured exclusively for testing:
   ```ini
   DB_CONNECTION=pgsql_disposable
   DB_HOST=127.0.0.1
   DB_PORT=5432
   DB_DATABASE=icbd_disposable_pgsql
   DB_USERNAME=postgres
   DB_PASSWORD=secret
   ```
4. **Safety Assertion in Code/Scripts:** Any testing or reconstruction script must assert:
   ```php
   if (config('database.connections.'.config('database.default').'.database') === 'icbd_web') {
       throw new RuntimeException('ABORT: Attempted execution against live operational database!');
   }
   ```

### 7.3 Dry-Run Pre-Execution Validation
Before applying any data modifications, an automated read-only dry-run script must generate a reconciliation audit log showing:
- Every record containing `'0000-00-00'` to be converted.
- Every monetary string with non-numeric characters to be cleansed.
- Every payment record matching `trxID = 'AAN****SE0'`.

---

## 8. Objective 7: Prerequisites for Laravel 13, PHP 8.4 & PostgreSQL Compatibility

The migration roadmap targets **Laravel 13, PHP 8.4, and PostgreSQL 15/16**. The audit revealed several foundational prerequisites that are not yet fulfilled in the current environment:

### 8.1 Runtime & Environment Prerequisites
1. **PHP Version & Extensions:**
   - Current environment: PHP 8.0 on local WampServer.
   - Target environment: PHP 8.4.
   - Missing/Unverified Extensions: PostgreSQL PDO drivers (`pdo_pgsql`, `pgsql`) are not verified as enabled in `php.ini`.
2. **PostgreSQL Server Instance:**
   - PostgreSQL 15 or 16 must be installed, running, and accessible on `127.0.0.1:5432`.
   - `pg_hba.conf` and database user permissions must be configured for the application user.

### 8.2 Composer Dependency Upgrades (5 Major Framework Generations)
The application currently runs on **Laravel 8.83.29** with multiple abandoned packages that cannot install on Laravel 13 / PHP 8.4:
- `fideloper/proxy: ^4.4` — Abandoned. Removed in Laravel 9+.
- `swiftmailer/swiftmailer: ^6.3` — Abandoned. Replaced by Symfony Mailer in Laravel 9+.
- `laravelcollective/html: ^6.3` — Abandoned. Unmaintained for modern Laravel.
- `fzaninotto/faker: ^1.9` — Abandoned. Replaced by `fakerphp/faker`.
- `spatie/laravel-permission: ^5.5` — Requires v6+ for modern Laravel compatibility.
- `intervention/image: ^2.7` — Requires migration to Image v3.
- `barryvdh/laravel-dompdf: 1.0` — Requires upgrade to v2/v3.

*Architectural Implication:* Reconstructing migrations within the legacy Laravel 8 codebase must be separated from the framework upgrade to Laravel 13. The clean-slate skeleton re-platforming strategy (Option 2 of Roadmap) is mandatory.

### 8.3 Application SQL Query Incompatibilities
1. **Strict `GROUP BY` Queries:**
   [`app/Http/Controllers/Admin/ReportController.php:54-74, 105-125`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/ReportController.php#L54-L74) selects non-aggregated columns (`id`, `title`, `amount`) while grouping exclusively by `category`. This fails immediately in PostgreSQL (SQL State 42803).
2. **Case-Sensitive `LIKE` Operators:**
   31 search queries across [`StudentsController.php`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/StudentsController.php), [`StudentManagementController.php`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/StudentManagementController.php), [`DividendWithdrawController.php`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/DividendWithdrawController.php), [`EmiInstallmentController.php`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/EmiInstallmentController.php), and [`InvestmentWithdrawController.php`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/InvestmentWithdrawController.php) use `where('sname', 'like', ...)`. In PostgreSQL, `LIKE` is strictly case-sensitive, breaking search functionality for all records with mixed casing. Must be converted to `ILIKE` or `LOWER()`.
3. **Identity Sequence Synchronization:**
   PostgreSQL identity sequences do not advance automatically when data is inserted with explicit primary keys (`id`). A sequence reset script (`SELECT setval(...)`) must run post-migration on all 52 tables.

---

## 9. Comprehensive Issue Registry & Action Matrix

```
+-----------+----------+-------------------------------------------------------------+---------------------+-------------------+------------------------------------------+
| Issue ID  | Severity | Finding Summary                                             | Verification Status | Required Decision | Recommended Safe Next Action             |
+-----------+----------+-------------------------------------------------------------+---------------------+-------------------+------------------------------------------+
| SEC-01    | Critical | Active .env directly targets live DB icbd_web               | Confirmed           | Safety Mandate    | Configure .env.testing for disposable DB |
| SEC-02    | Critical | No cold backup dump verified with SHA-256 and test restore  | Confirmed           | Safety Mandate    | Run cold mysqldump & test restore        |
| DEC-01    | Critical | 8 Owner Decision Gates remain pending sign-off              | Confirmed           | Gates 1 to 8      | Present formal approval request to owner |
| CODE-01   | High     | DB::table('sessions') calls will break if table renamed     | Confirmed           | Gate 2            | Refactor queries to academic_sessions    |
| DATA-01   | High     | batchs.totalseat integer casting unverified on 65 rows      | Requires Verify     | Gate 4            | Execute read-only integer format audit   |
| DATA-02   | High     | Date columns beyond expanses/incomes not scanned for zero   | Requires Verify     | Gate 5            | Execute universal zero-date audit script |
| DATA-03   | High     | certificates_icbd Latin1 collation may have corrupted text  | Requires Verify     | Gate 8            | Inspect 38 records for Bengali glyphs    |
| MIG-01    | High     | Deleting/renaming historical migrations breaks registry     | Confirmed           | Architecture      | Retain legacy files; author squashed set |
| SQL-01    | High     | ReportController invalid GROUP BY crashes PostgreSQL        | Confirmed           | Architecture      | Refactor queries to ANSI SQL aggregation |
| SQL-02    | High     | Case-sensitive LIKE in 31 lines breaks PostgreSQL search    | Confirmed           | Architecture      | Convert controller searches to ILIKE     |
| ENV-01    | Medium   | Local runtime is PHP 8.0 / L8.83; target is PHP 8.4 / L13   | Confirmed           | Architecture      | Follow Roadmap Option 2 (Re-platforming) |
| DATA-04   | Medium   | Non-numeric characters in monetary fields unverified        | Requires Verify     | Gate 4            | Run dry-run currency cleansing anomaly log|
+-----------+----------+-------------------------------------------------------------+---------------------+-------------------+------------------------------------------+
```

---

## 10. Final Gate Determination & Safe Next Steps

### Official Review Status:
```
NOT READY — OWNER DECISIONS OR SAFETY PREREQUISITES PENDING
```

### Actionable Path to Achieve "READY" Status:
Before transitioning to `READY FOR CONTROLLED IMPLEMENTATION`, the following 5 milestones must be achieved:

1. **Owner Approval Milestone:**
   - Formal owner review and recorded approval of all 8 Decision Gates (`PHASE_2_BLOCKERS_AND_DECISIONS.md`).
2. **Safety Infrastructure Milestone:**
   - Generation of authoritative cold dump `icbd_web_authoritative_pre_phase3.sql` with verified SHA-256 hash.
   - Successful execution of test restore into temporary database.
   - Provisioning of isolated disposable databases (`icbd_disposable_mysql`, `icbd_disposable_pgsql`) and configuration in `.env.testing`.
3. **Data Verification Milestone:**
   - Execution of read-only verification query for `batchs.totalseat` values.
   - Execution of universal zero-date audit across all 52 tables.
   - Read-only text inspection of `certificates_icbd` to confirm Bengali character integrity.
4. **Code Compatibility Milestone:**
   - Preparation of patch for `DB::table('sessions')` calls in `UserController` and `SessionController`.
   - Preparation of ANSI SQL refactor for `ReportController` `GROUP BY` queries.
5. **Architectural Handoff:**
   - Owner authorization to begin Stage 3A (Migration authoring in disposable staging environment).

**Implementation remains strictly paused. All application code, configuration, database records, and migration files remain untouched.**
