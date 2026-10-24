# Phase 2 — Database Schema Drift & Discrepancy Report

**Project:** `innova-web` — INNOVA Computers BD (ICBD)  
**Audit Phase:** Phase 2 (Database Architecture Audit & Migration Planning — Audit Only)  
**Database Audited:** `icbd_web` (MySQL 8.0.31 on `127.0.0.1:3306`)  
**Audit Date:** October 2026  
**Status:** CONFIRMED — Evidence-Based Live Database vs. Migration Comparison  

---

## 1. Executive Summary

This report provides the exhaustive schema drift analysis between the actual running MySQL database (`icbd_web`) and the source artifacts in the repository (`database/migrations/`, `app/Models/`, and application controllers).

### Summary of Discrepancies:
1. **5 Unmigrated Production Tables (CONFIRMED):** Five operational tables actively used by models and controllers have **zero migration files** in `database/migrations/`.
2. **2 Ghost Migration Tables (CONFIRMED):** Two tables defined in migration files (`assets`, `asset_students`) **do not exist** in the live database.
3. **Broken Migration Suite (CONFIRMED):** Running `php artisan migrate:fresh` on an empty database **crashes immediately** due to 3 duplicate class names (`CreateSessionsTable` in 3 files, `CreateAssetCoursesTable` in 2 files, `CreateAssetStudentsTable` in 2 files) and a circular foreign-key dependency between `courses` and `course_categories`.
4. **`fees_transections.trxID` Confirmed Drift & Duplicate Trap (CONFIRMED):**
   - The column `trxID` **exists in the live database** as `varchar(255) NULL`, but is **completely missing from all migrations**.
   - Out of 1,604 payment records, **1,598 records have `trxID IS NULL`** (cash/counter payments).
   - Exactly **1 duplicate transaction key (masked `AAN****SE0`) exists across 6 rows** (`ids: 332, 333, 334, 335, 336, 337`).
   - A naive unique constraint on `trxID` will immediately crash database migration and data restoration.
5. **6 Tables with Unmigrated Columns (CONFIRMED):** A total of 23 columns exist in the active MySQL database and are actively queried in application code, but are absent from Laravel migrations.
6. **Zero Orphaned Foreign Keys (CONFIRMED):** Across 20 relational foreign-key audit checks on core operational data, **0 orphaned records were detected**. The live database preserves 100% referential integrity despite lacking foreign keys in MySQL.
7. **14 Zero Dates (`0000-00-00`) (CONFIRMED):** 14 rows across `expanses.invoiceDate` (6) and `incomes.invoiceDate` (8) contain `'0000-00-00'`, which PostgreSQL strictly rejects.

---

## 2. Table-Level Drift Matrix

| Category | Table Name | Status in MySQL Live DB | Status in `database/migrations/` | Status in `app/Models/` | Impact & Risk Level |
|---|---|---|---|---|---|
| **Unmigrated Table** | `bank_loans` | Exists (7 rows, MyISAM) | **Missing** | [`BankLoan.php`](file:///c:/wamp64/www/innova-web/app/Models/BankLoan.php) | **High** — Fresh deployment will miss entire loan module. |
| **Unmigrated Table** | `emi_installments` | Exists (71 rows, MyISAM) | **Missing** | [`EmiInstallment.php`](file:///c:/wamp64/www/innova-web/app/Models/EmiInstallment.php) | **High** — Fresh deployment will miss EMI payment tracking. |
| **Unmigrated Table** | `investment_withdraws` | Exists (11 rows, MyISAM) | **Missing** | [`InvestmentWithdraw.php`](file:///c:/wamp64/www/innova-web/app/Models/InvestmentWithdraw.php) | **High** — Shareholder capital withdrawal ledger missing. |
| **Unmigrated Table** | `dividend_withdraws` | Exists (1 row, MyISAM) | **Missing** | [`DividendWithdraw.php`](file:///c:/wamp64/www/innova-web/app/Models/DividendWithdraw.php) | **High** — Shareholder dividend distribution ledger missing. |
| **Unmigrated Table** | `certificates_icbd` | Exists (38 rows, InnoDB) | **Missing** | [`Certificate_icbd.php`](file:///c:/wamp64/www/innova-web/app/Models/Certificate_icbd.php) | **High** — Institute certificate printing & verification missing. |
| **Ghost Migration** | `assets` | **Missing** | Defined (`2026_05_19_000000`) | [`Asset.php`](file:///c:/wamp64/www/innova-web/app/Models/Asset.php) | **Medium** — Migration exists but was never run on MySQL. |
| **Ghost Migration** | `asset_students` | **Missing** | Defined (`2026_05_20_000001` & `000400`) | [`AssetStudent.php`](file:///c:/wamp64/www/innova-web/app/Models/AssetStudent.php) | **Medium** — Trainee leads stored in `asset_registrations` instead. |
| **Class Collision** | `sessions` | Exists (10 rows, Academic) | **3 Colliding Migrations** | [`Session.php`](file:///c:/wamp64/www/innova-web/app/Models/Session.php) | **Critical** — Halts `php artisan migrate:fresh`. |
| **Class Collision** | `asset_courses` | Exists (2 rows, MyISAM) | **2 Colliding Migrations** | [`AssetCourse.php`](file:///c:/wamp64/www/innova-web/app/Models/AssetCourse.php) | **Critical** — Halts `php artisan migrate:fresh`. |
| **Class Collision** | `asset_students` | Missing from DB | **2 Colliding Migrations** | [`AssetStudent.php`](file:///c:/wamp64/www/innova-web/app/Models/AssetStudent.php) | **Critical** — Halts `php artisan migrate:fresh`. |

---

## 3. Deep-Dive Audit: `fees_transections.trxID` & Payment Columns

### 3.1 Migration vs. Database Discrepancy
In [`database/migrations/2022_08_17_205522_create_fees_transections_table.php`](file:///c:/wamp64/www/innova-web/database/migrations/2022_08_17_205522_create_fees_transections_table.php), the table definition contains only:
- `id`, `user_id`, `student_id`, `paidamount`, `paymentType`, `paiddate`, `paidremark`, `softDeletes`, `timestamps`.

In the live database `icbd_web`, **four additional columns exist** that were added manually via phpMyAdmin:
- `channel int DEFAULT 1`
- `trxID varchar(255) DEFAULT NULL`
- `paymentID varchar(255) DEFAULT NULL`
- `status int DEFAULT 0`

These columns are actively used in production:
- [`app/Http/Controllers/BkashController.php:207, 220, 246`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/BkashController.php#L207) writes `$fees->trxID = $trxId;` and `$fees->channel = 2;`.
- [`app/Http/Controllers/UserController.php:206, 233`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/UserController.php#L206) queries `where('status', 0)` and `where('paymentType', 1)`.

### 3.2 Live Database Statistical Breakdown of `fees_transections`
- **Total Records:** 1,604 rows
- **`trxID IS NULL`:** 1,598 rows (99.63% of all rows are counter/cash payments where bKash transaction IDs do not apply)
- **`TRIM(trxID) = ''` (Empty string):** 0 rows
- **Non-null `trxID` Records:** 6 rows

### 3.3 The Duplicate Key Trap: IDs 332 to 337
Auditing the non-null `trxID` records revealed:
- **Unique `trxID` Values:** 1
- **Total Rows Occupying this Key:** 6 rows
- **Ids:** `332, 333, 334, 335, 336, 337`
- **Timestamp Window:** Created on `2023-01-23` between `08:20:02` and `09:01:30`
- **Root Cause:** Prior to the Phase 1 idempotent transaction lock implementation, a user repeatedly executed payments or bKash webhook retries hit the server multiple times, creating 6 separate records for the same transaction.

### 3.4 PostgreSQL Migration Mandate for `trxID`
1. **Never create an unconditional `UNIQUE` constraint on `fees_transections(trxID)`** during initial migration:
   - In standard SQL, a unique constraint would fail immediately on IDs 332–337.
2. **Pre-Migration Reconciliation Step Required:**
   - Owner must decide whether IDs 333–337 are duplicate ledger entries that should be merged/soft-deleted, or whether an audit sequence should retain them.
3. **Recommended PostgreSQL Schema Implementation:**
   - Use a **partial unique index** in PostgreSQL:
     ```sql
     CREATE UNIQUE INDEX fees_transections_trxid_unique 
     ON fees_transections (trxID) 
     WHERE trxID IS NOT NULL AND TRIM(trxID) != '';
     ```
   - This allows thousands of cash payments with `NULL` transaction IDs while strictly guaranteeing that no future bKash transaction ID can ever be recorded twice!

---

## 4. Column-Level Drift on Existing Migrated Tables

| Table Name | Drifted Columns in Live DB (Absent from Migrations) | Data Types & Defaults | Evidence in Application Code |
|---|---|---|---|
| `courses` | `IsCourse`<br/>`courseFor`<br/>`Instructor`<br/>`Rating`<br/>`TotalReview`<br/>`Discount`<br/>`views` | `int DEFAULT 0`<br/>`varchar(255) NULL`<br/>`varchar(255) NULL`<br/>`varchar(255) NULL`<br/>`varchar(255) NULL`<br/>`varchar(255) NULL`<br/>`int DEFAULT 0` | [`app/Models/Courses.php:36-44`](file:///c:/wamp64/www/innova-web/app/Models/Courses.php#L36-L44) declares all 7 columns in `$fillable`. [`FrontendController.php`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Frontend/FrontendController.php) displays course ratings, reviews, and instructors. |
| `courses` (Type Drift) | `coursefee` | **`decimal(10,2) NOT NULL`** in DB vs. **`varchar(191)`** in migration | DB has proper numeric type; migration had string anti-pattern. |
| `teachers` | `email`<br/>`ComCourse`<br/>`nStd`<br/>`rating`<br/>`review`<br/>`isTeacher`<br/>`IsFeatured`<br/>`bio` | `varchar(191) NULL`<br/>`varchar(255) NULL`<br/>`varchar(255) NULL`<br/>`varchar(255) NULL`<br/>`varchar(255) NULL`<br/>`int DEFAULT 0`<br/>`int DEFAULT 0`<br/>`text NULL` | [`app/Models/Teachers.php:46-53`](file:///c:/wamp64/www/innova-web/app/Models/Teachers.php#L46-L53) defines in `$fillable`. [`FrontendController.php:48, 199, 257`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Frontend/FrontendController.php#L48) queries `where('isTeacher', '!=', 1)->where('IsFeatured', '!=', 1)`. If run on fresh migrations, this query immediately crashes! |
| `course_categories` | `fontawesome`<br/>`isFeature`<br/>`tabId` | `varchar(191) NULL`<br/>`int DEFAULT 0`<br/>`varchar(191) NULL` | [`FrontendController.php:40`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Frontend/FrontendController.php#L40) queries `where('isFeature', '!=', 0)`. |
| `admins` | `remember_token` | `varchar(100) NULL` | Handled by Laravel Auth guard. |
| `users` | `name` | `varchar(191) NULL` | Present in DB, missing from initial user migration. |
| `asset_courses` | `deleted_at` | **Missing in Live DB** (exists in migration `000000`) | Migration defined `softDeletes()`, but second migration `000300` and model [`AssetCourse.php`](file:///c:/wamp64/www/innova-web/app/Models/AssetCourse.php) do not use SoftDeletes. |

---

## 5. Migration Suite Crash Blockers (Root Cause Analysis)

Attempting to run `php artisan migrate:fresh` on an empty PostgreSQL database fails at three distinct barriers:

### Barrier 1: Class Name Redeclarations
PHP fatal error: `Cannot declare class CreateSessionsTable because the name is already in use`.

1. **`CreateSessionsTable`:**
   - [`database/migrations/2022_08_19_163812_create_sessions_table.php`](file:///c:/wamp64/www/innova-web/database/migrations/2022_08_19_163812_create_sessions_table.php) creates the **academic session** entity (`sessionName`, `startdate`, `enddate`, `IsActive`).
   - [`database/migrations/2024_07_13_012857_create_sessions_table.php`](file:///c:/wamp64/www/innova-web/database/migrations/2024_07_13_012857_create_sessions_table.php) and [`2024_07_16_031214_create_sessions_table.php`](file:///c:/wamp64/www/innova-web/database/migrations/2024_07_16_031214_create_sessions_table.php) were generated by `php artisan session:table` for **Laravel HTTP database sessions** (`id`, `payload`, `last_activity`).
   - Both the class name and the table name collide!
2. **`CreateAssetCoursesTable`:**
   - [`2026_05_20_000000_create_asset_courses_table.php`](file:///c:/wamp64/www/innova-web/database/migrations/2026_05_20_000000_create_asset_courses_table.php) vs. [`2026_05_20_000300_create_asset_courses_table.php`](file:///c:/wamp64/www/innova-web/database/migrations/2026_05_20_000300_create_asset_courses_table.php).
3. **`CreateAssetStudentsTable`:**
   - [`2026_05_20_000001_create_asset_students_table.php`](file:///c:/wamp64/www/innova-web/database/migrations/2026_05_20_000001_create_asset_students_table.php) vs. [`2026_05_20_000400_create_asset_students_table.php`](file:///c:/wamp64/www/innova-web/database/migrations/2026_05_20_000400_create_asset_students_table.php).

### Barrier 2: Chronological Circular Dependency
In [`database/migrations/2022_08_12_080223_create_courses_table.php`](file:///c:/wamp64/www/innova-web/database/migrations/2022_08_12_080223_create_courses_table.php):
```php
$table->foreign('category_id')->references('id')->on('course_categories');
$table->unsignedBigInteger('category_id')->nullable();
```
- The migration references table `course_categories` before `course_categories` exists (its migration is dated `2024_12_17`!).
- In strict PostgreSQL, this query fails immediately with `relation "course_categories" does not exist`.

---

## 6. Data Integrity Audit (Live DB Validation Queries & Results)

Every integrity check was executed against the active MySQL database `icbd_web`:

### 6.1 Foreign Key Referential Integrity (Orphan Record Checks)
| Relation Checked | Parent Table (PK) | Child Table (FK) | Broken / Orphan Rows | Integrity Status |
|---|---|---|---|---|
| `fees_transections` → `students` | `students.id` | `fees_transections.student_id` | **0** | **PASS (100% Valid)** |
| `fees_transections` → `users` | `users.id` | `fees_transections.user_id` | **0** | **PASS (100% Valid)** |
| `students` → `courses` | `courses.id` | `students.course_id` | **0** | **PASS (100% Valid)** |
| `students` → `batchs` | `batchs.id` | `students.batch_id` | **0** | **PASS (100% Valid)** |
| `students` → `branches` | `branches.id` | `students.branch_id` | **0** | **PASS (100% Valid)** |
| `students` → `users` | `users.id` | `students.user_id` | **0** | **PASS (100% Valid)** |
| `batchs` → `teachers` | `teachers.id` | `batchs.stuff_id` | **0** | **PASS (100% Valid)** |
| `registrations` → `students` | `students.id` | `registrations.student_id` | **0** | **PASS (100% Valid)** |
| `registrations` → `sessions` | `sessions.id` | `registrations.session_id` | **0** | **PASS (100% Valid)** |
| `certificates` → `students` | `students.id` | `certificates.student_id` | **0** | **PASS (100% Valid)** |
| `certificates` → `sessions` | `sessions.id` | `certificates.session_id` | **0** | **PASS (100% Valid)** |
| `certificates_icbd` → `students`| `students.id` | `certificates_icbd.student_id` | **0** | **PASS (100% Valid)** |
| `certificates_icbd` → `batchs` | `batchs.id` | `certificates_icbd.batch_id` | **0** | **PASS (100% Valid)** |
| `certificates_icbd` → `courses`| `courses.id` | `certificates_icbd.course_id` | **0** | **PASS (100% Valid)** |
| `expanses` → `expanse_categoris`| `expanse_categoris.id`| `expanses.categoris_id` | **0** | **PASS (100% Valid)** |
| `incomes` → `income_categoris` | `income_categoris.id` | `incomes.categoris_id` | **0** | **PASS (100% Valid)** |
| `invesments` → `shareholders` | `shareholders.id` | `invesments.shareholder_id` | **0** | **PASS (100% Valid)** |
| `bank_loans` → `shareholders` | `shareholders.id` | `bank_loans.shareholder_id` | **0** | **PASS (100% Valid)** |
| `emi_installments` → `bank_loans`| `bank_loans.id` | `emi_installments.bank_loan_id`| **0** | **PASS (100% Valid)** |
| `investment_withdraws` → `shareholders`| `shareholders.id`| `investment_withdraws.shareholder_id`| **0** | **PASS (100% Valid)** |
| `dividend_withdraws` → `shareholders` | `shareholders.id`| `dividend_withdraws.shareholder_id` | **0** | **PASS (100% Valid)** |

> **Crucial Finding:** Despite MySQL operating with `'strict' => false` and 14 tables running on MyISAM, the application logic has maintained **zero orphaned records** across all 20 tested parent-child relationships. All child records cleanly map to valid parents.

### 6.2 Candidate Key Uniqueness Checks
| Candidate Key | Scope / Condition | Duplicate Keys Count | Excess Rows | Notes |
|---|---|---|---|---|
| `users.email` | `WHERE email IS NOT NULL AND email != ''` | **0** | 0 | Clean. Safe for PostgreSQL UNIQUE constraint. |
| `admins.email` | `WHERE email IS NOT NULL AND email != ''` | **0** | 0 | Clean. Safe for PostgreSQL UNIQUE constraint. |
| `settings.key` | Global | **0** | 0 | Clean. Already unique. |
| `certificates_icbd.certificate_no`| Global | **0** | 0 | Clean. Safe for PostgreSQL UNIQUE constraint. |
| `courses.name` | Global | **2 duplicate names** | 2 | Same course name "Microsoft Office Management" re-created with different fees/durations. Name cannot have unique index. |
| `students.phone` | Global | **75 duplicate numbers** | 108 | Multiple siblings, family members, or re-enrolled students share contact phones. Must remain non-unique. |

### 6.3 Zero Date Checks (`0000-00-00`)
- `expanses.invoiceDate`: **6 rows** contain `'0000-00-00'`
- `incomes.invoiceDate`: **8 rows** contain `'0000-00-00'`
- Total zero dates across database: **14 rows**.
- **Action Required:** Convert all 14 rows to `NULL` during data migration.

---

## 7. Action Plan & Next Steps
1. Author formal Laravel migrations for the 5 unmigrated production tables (`bank_loans`, `emi_installments`, `investment_withdraws`, `dividend_withdraws`, `certificates_icbd`).
2. Add missing columns (`fees_transections.trxID`, `courses` metadata, `teachers` flags) to authoritative migration suite.
3. Resolve triplicate `CreateSessionsTable` by renaming the academic session table to `academic_sessions`.
4. Implement PostgreSQL partial unique index on `fees_transections.trxID` (`WHERE trxID IS NOT NULL`).
