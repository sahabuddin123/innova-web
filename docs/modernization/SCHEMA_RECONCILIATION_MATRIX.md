# Database Schema Reconciliation Matrix

**Project:** INNOVA Computers BD (`innova-web`)  
**Scope:** Complete Discrepancy Classification (Categories A through M)  
**Status:** Reconciled & Documented  
**Reference Database:** MySQL `icbd_web` (52 Tables)  
**Reference Migrations:** `database/migrations/` (59 Files)  

---

## 1. Classification Categories Overview

| Code | Discrepancy Category | Initial Count | Reconciled Status | Action Strategy |
|---|---|:---:|:---:|---|
| **A** | Actual-Only Tables | 5 | Reconciled (0 Remaining) | Forward migrations authored |
| **B** | Migration-Only Tables | 3 | Documented (3 Retained) | Ghost/Sanctum tables preserved |
| **C** | Actual-Only Columns (Manually Added Fields) | 23 | Reconciled (0 Remaining) | Forward idempotent migration authored |
| **D** | Migration-Only Columns | 6 | Documented (6 Retained) | Unexecuted draft / HTTP session fields |
| **E** | Data Type Mismatches | 3 | Documented | Documented; preserved for legacy compatibility |
| **F** | Nullability / Default Mismatches | 1 | Documented | Documented; DB allows NULL |
| **G** | Primary Key & Unique Index Mismatches | 0 | Verified Clean (0) | All keys match |
| **H** | Foreign Key Constraint Mismatches | 0 | Verified Clean (0) | 0 orphaned records across live data |
| **I** | Storage Engine Mismatches (MyISAM vs. InnoDB) | 14 | Documented | 14 tables require transactional migration |
| **J** | Collation Mismatches | 2 | Documented | Latin1 & General CI flags documented |
| **K** | Duplicate / Conflicting Migration Files | 6 | Documented (Owner Gate) | Class & table collision gates documented |
| **L** | Migration Ordering / Dependency Problem | 1 | Documented (Owner Gate) | Circular FK between courses & categories |
| **M** | Uncertain Discrepancies Requiring Investigation | 0 | Verified Clean (0) | All discrepancies diagnosed |

---

## 2. Category A: Actual-Only Tables (5 Tables Reconciled)

These 5 operational production tables existed in the live MySQL database and were actively managed by Eloquent models, but had zero migration files in `database/migrations/`.

| Table Name | Live MySQL Definition | Rows | Eloquent Model | Risk Level | Reconciled Migration | Action Taken |
|---|---|:---:|---|:---:|---|---|
| `bank_loans` | 16 columns (PK, shareholder_id, bank_name, loan_amount, interest_rate, loan_term_months, loan_date, maturity_date, installment_count, savings_amount, status, remarks, created_by, timestamps, softDeletes) | 7 | `App\Models\BankLoan` | **High** | `2026_10_24_000001_create_bank_loans_table.php` | Authored forward idempotent migration capturing exact live schema. |
| `emi_installments` | 15 columns (PK, bank_loan_id, shareholder_id, emi_amount, savings_amount, payment_date, payment_method, paid_by, received_by, paid_at, status, remarks, timestamps, softDeletes) | 71 | `App\Models\EmiInstallment` | **High** | `2026_10_24_000002_create_emi_installments_table.php` | Authored forward idempotent migration capturing exact live schema. |
| `investment_withdraws` | 20 columns (PK, shareholder_id, amount, withdraw_date, method, branch_name, receiver_name, pay_by, account_number, status, requested_by, requested_at, processed_by, processed_at, processed_remarks, remarks, attachment, timestamps, softDeletes) | 11 | `App\Models\InvestmentWithdraw` | **High** | `2026_10_24_000003_create_investment_withdraws_table.php` | Authored forward idempotent migration capturing exact live schema. |
| `dividend_withdraws` | 20 columns (PK, shareholder_id, amount, withdraw_date, method, branch_name, receiver_name, pay_by, account_number, status, requested_by, requested_at, processed_by, processed_at, processed_remarks, remarks, attachment, timestamps, softDeletes) | 1 | `App\Models\DividendWithdraw` | **High** | `2026_10_24_000004_create_dividend_withdraws_table.php` | Authored forward idempotent migration capturing exact live schema. |
| `certificates_icbd` | 16 columns (PK, student_id, batch_id, course_id, certificate_no [UNIQUE], theory_hours, practical_hours, intern_hours, result, issue_date, certificate_receiver, delivery_date, is_active, timestamps, softDeletes) | 38 | `App\Models\Certificate_icbd` | **High** | `2026_10_24_000005_create_certificates_icbd_table.php` | Authored forward idempotent migration capturing exact live schema. |

---

## 3. Category B: Migration-Only Tables (3 Tables)

These tables are defined in migrations but do not exist in the live MySQL database `icbd_web`.

| Table Name | Defined in Migration | Model | Reason for Absence in MySQL | Risk | Recommended Action | Owner Approval Required |
|---|---|---|---|---|---|:---:|
| `personal_access_tokens` | `2019_12_14_000001_create_personal_access_tokens_table.php` | Laravel Sanctum | Authored during Phase 2.1/2.2. Under database safety rules, migrations were not executed on MySQL `icbd_web`. | Low | Retain migration for clean installs and future rollout. | No |
| `assets` | `2026_05_19_000000_create_assets_table.php` | `App\Models\Asset` | Legacy draft migration created for ASSET project that was never executed on MySQL. Operational ASSET records are stored in `asset_courses` and `asset_registrations`. | Medium | Retain migration; evaluate in Phase 2.7.4 if ASSET assets table is needed. | Yes (in Phase 2.7.4) |
| `asset_students` | `2026_05_20_000001_create_asset_students_table.php` & `000400` | `App\Models\AssetStudent` | Legacy draft migration created for ASSET project leads that was never executed on MySQL. Trainee leads are stored in `asset_registrations` instead. | Medium | Retain migration; evaluate in Phase 2.7.4. | Yes (in Phase 2.7.4) |

---

## 4. Category C: Actual-Only Columns (23 Manually Added Fields Reconciled)

These 23 columns existed in live MySQL tables and were actively referenced in code, but were missing from all migration files. All 23 have been reconciled into `2026_10_24_000006_reconcile_manually_added_columns.php`.

| Table | Column Name | Actual Live MySQL Type | Application Code Usage | Reconciled In Migration |
|---|---|---|---|---|
| `users` | `name` | `varchar(255) NULL` | `App\Models\User::$fillable`, user registration | `2026_10_24_000006` |
| `fees_transections` | `channel` | `int NOT NULL DEFAULT 1` | `BkashController::class` (1=Counter/Cash, 2=bKash) | `2026_10_24_000006` |
| `fees_transections` | `trxID` | `varchar(255) NULL` | `BkashController::class`, transaction logging | `2026_10_24_000006` |
| `fees_transections` | `paymentID` | `varchar(255) NULL` | `BkashController::class`, bKash payment ID | `2026_10_24_000006` |
| `fees_transections` | `status` | `int NOT NULL DEFAULT 0` | Fee approval status (0=Approved, 1=Pending) | `2026_10_24_000006` |
| `courses` | `IsCourse` | `tinyint(1) NOT NULL DEFAULT 0` | Course flag in public portal | `2026_10_24_000006` |
| `courses` | `courseFor` | `varchar(255) NULL` | Target audience description | `2026_10_24_000006` |
| `courses` | `Instructor` | `int NULL` | Assigned lead instructor | `2026_10_24_000006` |
| `courses` | `Rating` | `decimal(2,1) NULL` | Public course rating | `2026_10_24_000006` |
| `courses` | `TotalReview` | `varchar(255) NULL` | Number of reviews displayed | `2026_10_24_000006` |
| `courses` | `Discount` | `varchar(255) NULL` | Promotional discount tag | `2026_10_24_000006` |
| `courses` | `views` | `varchar(11) NOT NULL DEFAULT '0'` | Course page views counter | `2026_10_24_000006` |
| `course_categories` | `fontawesome` | `varchar(255) NULL` | FontAwesome CSS icon class | `2026_10_24_000006` |
| `course_categories` | `isFeature` | `int NOT NULL DEFAULT 0` | Featured category display flag | `2026_10_24_000006` |
| `course_categories` | `tabId` | `varchar(255) NULL` | UI tab anchor identifier | `2026_10_24_000006` |
| `teachers` | `email` | `varchar(255) NULL` | Teacher email address | `2026_10_24_000006` |
| `teachers` | `ComCourse` | `varchar(255) NULL` | Completed courses / specialties | `2026_10_24_000006` |
| `teachers` | `nStd` | `varchar(255) NULL` | Number of students taught | `2026_10_24_000006` |
| `teachers` | `rating` | `varchar(255) NULL` | Teacher public rating | `2026_10_24_000006` |
| `teachers` | `review` | `varchar(255) NULL` | Total reviews received | `2026_10_24_000006` |
| `teachers` | `isTeacher` | `int NOT NULL DEFAULT 0` | Teacher status filter | `2026_10_24_000006` |
| `teachers` | `IsFeatured` | `int NOT NULL DEFAULT 0` | Homepage featured teacher flag | `2026_10_24_000006` |
| `teachers` | `bio` | `text NULL` | Teacher biography | `2026_10_24_000006` |

---

## 5. Category D: Migration-Only Columns (6 Columns)

These columns appear in migration files but do not exist in the live MySQL database.

| Table | Column Name | Defined in Migration | Reason for Discrepancy | Risk | Recommendation |
|---|---|---|---|---|---|
| `asset_courses` | `deleted_at` | `2026_05_20_000000_create_asset_courses_table.php` | Defined in first draft migration `000000`, but second migration `000300` and model `App\Models\AssetCourse` do not use SoftDeletes. Table in DB has no `deleted_at`. | Low | Documented; preserved live schema without soft deletes. |
| `sessions` | `user_id` | `2024_07_16_031214_create_sessions_table.php` | File is an unexecuted Laravel HTTP database session migration. The actual table in MySQL is the academic session entity (`App\Models\Session`). | **High** | Subject to Decision Gate 2 (Academic Sessions vs. HTTP Sessions). |
| `sessions` | `ip_address` | `2024_07_16_031214_create_sessions_table.php` | Unexecuted HTTP session column. | **High** | Subject to Decision Gate 2. |
| `sessions` | `user_agent` | `2024_07_16_031214_create_sessions_table.php` | Unexecuted HTTP session column. | **High** | Subject to Decision Gate 2. |
| `sessions` | `payload` | `2024_07_16_031214_create_sessions_table.php` | Unexecuted HTTP session column. | **High** | Subject to Decision Gate 2. |
| `sessions` | `last_activity` | `2024_07_16_031214_create_sessions_table.php` | Unexecuted HTTP session column. | **High** | Subject to Decision Gate 2. |

---

## 6. Category E: Data Type Mismatches (3 Columns)

| Table | Column | Actual Live MySQL Type | Migration Definition | Rationale & Recommendation | Risk |
|---|---|---|---|---|---|
| `courses` | `coursefee` | `decimal(10,2) NOT NULL` | `$table->string('coursefee')` (`2022_08_12_080223`) | Live DB was manually upgraded to proper numeric type `decimal(10,2)`. Reconciled schema adopts `decimal(10,2)`. | Low |
| `registrations` | `PassYear` | `varchar(255) NULL` | `$table->date('PassYear')->nullable()` (`2022_08_19_163921`) | DB contains 4-digit year strings (e.g., `'2023'`). A strict date type (`YYYY-MM-DD`) would corrupt year-only values. Must remain string or integer. | Medium |
| `sessions` | `id` | `bigint unsigned AUTO_INCREMENT` | `$table->string('id')->unique()` (`2024_07_16_031214`) | Collision between academic session integer ID and Laravel HTTP session string ID. Subject to Decision Gate 2. | **Critical** |

---

## 7. Category F: Nullability & Default Mismatches (1 Column)

| Table | Column | Actual Live DB | Migration Definition | Rationale & Recommendation |
|---|---|---|---|---|
| `courses` | `shortTitle` | `varchar(255) NULL` (`IS_NULLABLE = YES`) | `$table->string('shortTitle')` (NOT nullable) | Live DB permits null values for short titles. Reconciled schema preserves nullable. |

---

## 8. Category I: Storage Engine Mismatches (14 Tables)

All 14 tables below operate on the non-transactional `MyISAM` storage engine in the live MySQL database.

| # | Table Name | Live Rows | Actual Engine | Expected Modern Engine | Architectural Impact |
|---|---|:---:|---|---|---|
| 1 | `asset_courses` | 2 | MyISAM | InnoDB / PostgreSQL relation | No transaction rollback |
| 2 | `asset_registration_feedbacks` | 5 | MyISAM | InnoDB / PostgreSQL relation | Table-level write locking |
| 3 | `asset_registrations` | 31 | MyISAM | InnoDB / PostgreSQL relation | No foreign-key enforcement |
| 4 | `bank_loans` | 7 | MyISAM | InnoDB / PostgreSQL relation | Financial ledger lacks ACID safety |
| 5 | `clients` | 0 | MyISAM | InnoDB / PostgreSQL relation | Minor CMS table |
| 6 | `concerns` | 4 | MyISAM | InnoDB / PostgreSQL relation | Minor CMS table |
| 7 | `dividend_withdraws` | 1 | MyISAM | InnoDB / PostgreSQL relation | Financial ledger lacks ACID safety |
| 8 | `emi_installments` | 71 | MyISAM | InnoDB / PostgreSQL relation | Financial ledger lacks ACID safety |
| 9 | `investment_withdraws` | 11 | MyISAM | InnoDB / PostgreSQL relation | Financial ledger lacks ACID safety |
| 10 | `products` | 11 | MyISAM | InnoDB / PostgreSQL relation | Minor CMS table |
| 11 | `services` | 9 | MyISAM | InnoDB / PostgreSQL relation | Minor CMS table |
| 12 | `teams` | 0 | MyISAM | InnoDB / PostgreSQL relation | Minor CMS table |
| 13 | `technologies` | 0 | MyISAM | InnoDB / PostgreSQL relation | Minor CMS table |
| 14 | `workflows` | 5 | MyISAM | InnoDB / PostgreSQL relation | Minor CMS table |

---

## 9. Category J: Collation Mismatches (2 Tables)

| Table Name | Actual Live Collation | Standard Collation | Rationale & Risk |
|---|---|---|---|
| `certificates_icbd` | `latin1_swedish_ci` | `utf8mb4_unicode_ci` | Manually created table in phpMyAdmin with default Latin1. Risk of Unicode corruption for Bengali names. Must be converted to `utf8mb4` during PostgreSQL migration. |
| `courses` | `utf8mb4_general_ci` | `utf8mb4_unicode_ci` | Uses less strict general collation. Low risk. |

---

## 10. Category K: Duplicate / Conflicting Migrations (6 Findings)

| Collision Type | Entity | Involved Migration Files | Root Cause | Resolution Strategy | Owner Sign-Off Required |
|---|---|---|---|---|:---:|
| **Class Collision** | `CreateSessionsTable` | `2022_08_19_163812`<br/>`2024_07_13_012857`<br/>`2024_07_16_031214` | 1 file for academic session; 2 duplicate files from `php artisan session:table` | Documented as Decision Gate 2 | **Yes** |
| **Class Collision** | `CreateAssetCoursesTable` | `2026_05_20_000000`<br/>`2026_05_20_000300` | Initial draft vs revised implementation | Documented as Decision Gate 7 | **Yes** |
| **Class Collision** | `CreateAssetStudentsTable` | `2026_05_20_000001`<br/>`2026_05_20_000400` | Initial draft vs revised implementation | Documented as Decision Gate 7 | **Yes** |
| **Table Collision** | `sessions` | `2022_08_19_163812`<br/>`2024_07_13_012857`<br/>`2024_07_16_031214` | Academic session vs HTTP session | Documented as Decision Gate 2 | **Yes** |
| **Table Collision** | `asset_courses` | `2026_05_20_000000`<br/>`2026_05_20_000300` | Two migrations attempting to create `asset_courses` | Documented as Decision Gate 7 | **Yes** |
| **Table Collision** | `asset_students` | `2026_05_20_000001`<br/>`2026_05_20_000400` | Two migrations attempting to create `asset_students` | Documented as Decision Gate 7 | **Yes** |

---

## 11. Category L: Migration Ordering & Circular Dependencies (1 Finding)

| Table | Migration File | Dependent Table | Issue Description | Risk | Resolution |
|---|---|---|---|---|---|
| `courses` | `2022_08_12_080223_create_courses_table.php` | `course_categories` | The courses migration declares `$table->foreign('category_id')->references('id')->on('course_categories')`, but `course_categories` migration was not created until `2024_12_17_142915_create_course_categories_table.php` (28 months later!). | Strict RDBMS (PostgreSQL) fails immediately when running migrations chronologically. | On PostgreSQL rollout, create tables first without foreign keys, then apply foreign keys in a dedicated constraint pass. |
