# Master Database Schema Audit — Live MySQL vs Migration History

**Project:** INNOVA Computers BD (`innova-web`)  
**Scope:** Complete Database Schema Audit (52 Tables, 59 Migration Files)  
**Audit Date:** October 2026  
**Status:** Completed & Verified Read-Only  
**Auditor:** Senior Database Architect & Migration Specialist  

---

## 1. Executive Summary & Audit Methodology

This report establishes the verified, comprehensive schema baseline for the active INNOVA Computers BD MySQL database (`icbd_web`) and compares it against the complete Laravel migration history.

### Inspection Methodology & Safety Enforcement
1. **Strictly Read-Only Inspection:**
   - Database metadata was extracted exclusively via read-only SQL queries against `information_schema.TABLES`, `information_schema.COLUMNS`, `information_schema.STATISTICS`, and `information_schema.KEY_COLUMN_USAGE`.
   - No `CREATE`, `ALTER`, `DROP`, `TRUNCATE`, `INSERT`, `UPDATE`, or `DELETE` statements were executed against the live MySQL database.
   - Zero mutating Artisan commands (`migrate`, `migrate:fresh`, `db:seed`) were run against MySQL.
   - Database credentials and secrets were preserved without modification or disclosure.
2. **Authoritative Evidence Hierarchy:**
   - **`[CONFIRMED LIVE DB]`**: Directly extracted from MySQL 8.0.31 `information_schema`.
   - **`[CONFIRMED MIGRATION]`**: Formally declared in Laravel migration history (`database/migrations/`).
   - **`[CONFIRMED APPLICATION CODE]`**: Formally referenced in Eloquent models, controllers, and query builders.
   - **`[UNMIGRATED / DRIFT]`**: Operational in MySQL and code but previously absent from migration files.

### Key Inventory Totals:
- **Total Tables in Live MySQL Database:** 52 Tables (51 Base Application Tables + 1 `migrations` tracking table; 0 Views).
- **Total Operational Records:** 15,663 rows across live operational tables.
- **Migration Files in Repository:** 53 historical migration files + 6 newly authored forward reconciliation migrations = 59 total migration files.
- **Recorded Migrations in Live MySQL:** Exactly 24 migrations across Batches 1–14.
- **Tables Using Legacy `MyISAM` Engine:** 14 tables (completely lack ACID transactional safety and foreign keys in MySQL).
- **Tables with Non-Standard Collation:** 2 tables (`certificates_icbd` uses `latin1_swedish_ci`; `courses` uses `utf8mb4_general_ci`).

---

## 2. Complete Live Table Inventory (52 Tables)

The table below catalogs every table in the live `icbd_web` database:

| # | Table Name | Storage Engine | Table Collation | Live Rows | Primary Key | Eloquent Model | Migration Status | Domain / Business Purpose |
|---|---|---|---|---|---|---|---|---|
| 1 | `admins` | InnoDB | `utf8mb4_unicode_ci` | 7 | `id` (bigint) | `App\Models\Admin` | Confirmed (Batch 1) | Admin staff & system credentials |
| 2 | `admissions` | InnoDB | `utf8mb4_unicode_ci` | 43 | `id` (bigint) | `App\Models\Admission` | Confirmed (Unrecorded) | Public course admission inquiries |
| 3 | `asset_courses` | **MyISAM** | `utf8mb4_unicode_ci` | 2 | `id` (bigint) | `App\Models\AssetCourse` | Confirmed (Unrecorded, Duplicate files) | ASSET government project courses |
| 4 | `asset_registration_feedbacks` | **MyISAM** | `utf8mb4_unicode_ci` | 5 | `id` (bigint) | `App\Models\AssetRegistrationFeedback` | Confirmed (Unrecorded) | Follow-up feedback on leads |
| 5 | `asset_registrations` | **MyISAM** | `utf8mb4_unicode_ci` | 31 | `id` (bigint) | `App\Models\AssetRegistration` | Confirmed (Unrecorded) | ASSET trainee applications |
| 6 | `bank_loans` | **MyISAM** | `utf8mb4_unicode_ci` | 7 | `id` (bigint) | `App\Models\BankLoan` | **Unmigrated (Reconciled 2026)** | Shareholder commercial bank loans |
| 7 | `batchs` | InnoDB | `utf8mb4_unicode_ci` | 65 | `id` (bigint) | `App\Models\Batchs` | Confirmed (Batch 1) | Student batches, seat quotas & class times |
| 8 | `blog_categoris` | InnoDB | `utf8mb4_unicode_ci` | 3 | `id` (bigint) | `App\Models\blogCategoris` | Confirmed (Batch 9) | Public blog classification |
| 9 | `blogs` | InnoDB | `utf8mb4_unicode_ci` | 3 | `id` (bigint) | `App\Models\Blog` | Confirmed (Batch 10) | Tech articles, notices, announcements |
| 10 | `branches` | InnoDB | `utf8mb4_unicode_ci` | 4 | `id` (bigint) | `App\Models\Branch` | Confirmed (Unrecorded) | Physical branch offices |
| 11 | `certificates` | InnoDB | `utf8mb4_unicode_ci` | 128 | `id` (bigint) | `App\Models\Certificates` | Confirmed (Unrecorded) | BTEB government certificate records |
| 12 | `certificates_icbd` | InnoDB | **`latin1_swedish_ci`** | 38 | `id` (bigint) | `App\Models\Certificate_icbd` | **Unmigrated (Reconciled 2026)** | Internal ICBD institute certificates |
| 13 | `clients` | **MyISAM** | `utf8mb4_unicode_ci` | 0 | `id` (bigint) | `App\Models\Client` | Confirmed (Unrecorded) | Client logos & partners |
| 14 | `cms_abouts` | InnoDB | `utf8mb4_unicode_ci` | 1 | `id` (bigint) | `App\Models\cmsAbout` | Confirmed (Batch 13) | CMS About Us content block |
| 15 | `concerns` | **MyISAM** | `utf8mb4_unicode_ci` | 4 | `id` (bigint) | `App\Models\Concern` | Confirmed (Unrecorded) | Sister business ventures |
| 16 | `contacts` | InnoDB | `utf8mb4_unicode_ci` | 269 | `id` (bigint) | `App\Models\Contact` | Confirmed (Unrecorded) | Public contact form submissions |
| 17 | `course_categories` | InnoDB | `utf8mb4_unicode_ci` | 10 | `id` (bigint) | `App\Models\CourseCategory` | Confirmed (Batch 7, 3 Drift columns) | Course categories (IT, Graphic, Web) |
| 18 | `courses` | InnoDB | **`utf8mb4_general_ci`** | 26 | `id` (bigint) | `App\Models\Courses` | Confirmed (Batch 1, 7 Drift columns) | Training curriculum & syllabi |
| 19 | `dividend_withdraws` | **MyISAM** | `utf8mb4_unicode_ci` | 1 | `id` (bigint) | `App\Models\DividendWithdraw` | **Unmigrated (Reconciled 2026)** | Shareholder dividend disbursements |
| 20 | `emi_installments` | **MyISAM** | `utf8mb4_unicode_ci` | 71 | `id` (bigint) | `App\Models\EmiInstallment` | **Unmigrated (Reconciled 2026)** | Monthly loan EMI repayment ledger |
| 21 | `expanse_categoris` | InnoDB | `utf8mb4_unicode_ci` | 118 | `id` (bigint) | `App\Models\ExpanseCategoris` | Confirmed (Batch 2) | Chart of Accounts for expenditures |
| 22 | `expanses` | InnoDB | `utf8mb4_unicode_ci` | 6,338 | `id` (bigint) | `App\Models\Expanse` | Confirmed (Batch 2) | Operating expenditures & expense vouchers |
| 23 | `fees_transections` | InnoDB | `utf8mb4_unicode_ci` | 1,604 | `id` (bigint) | `App\Models\FeesTransections` | Confirmed (Batch 1, 4 Drift columns) | Student tuition receipts & bKash logs |
| 24 | `galleries` | InnoDB | `utf8mb4_unicode_ci` | 21 | `id` (bigint) | `App\Models\Gallery` | Confirmed (Batch 14) | Event gallery photo albums |
| 25 | `income_categoris` | InnoDB | `utf8mb4_unicode_ci` | 75 | `id` (bigint) | `App\Models\IncomeCategoris` | Confirmed (Unrecorded) | Revenue classification categories |
| 26 | `incomes` | InnoDB | `utf8mb4_unicode_ci` | 5,694 | `id` (bigint) | `App\Models\Income` | Confirmed (Unrecorded) | Revenue entries & receipts |
| 27 | `invesments` | InnoDB | `utf8mb4_unicode_ci` | 46 | `id` (bigint) | `App\Models\Invesments` | Confirmed (Unrecorded) | Shareholder capital contributions |
| 28 | `investment_withdraws` | **MyISAM** | `utf8mb4_unicode_ci` | 11 | `id` (bigint) | `App\Models\InvestmentWithdraw` | **Unmigrated (Reconciled 2026)** | Shareholder capital withdrawal requests |
| 29 | `migrations` | InnoDB | `utf8mb4_unicode_ci` | 24 | `id` (int) | None (System Table) | Core Laravel Tracker | Recorded migration batches (1-14) |
| 30 | `model_has_permissions` | InnoDB | `utf8mb4_unicode_ci` | 0 | `(perm, model_id, model_type)` | Spatie Permission | Confirmed (Batch 5) | Polymorphic user direct permissions |
| 31 | `model_has_roles` | InnoDB | `utf8mb4_unicode_ci` | 7 | `(role, model_id, model_type)` | Spatie Permission | Confirmed (Batch 5) | Polymorphic user role assignments |
| 32 | `password_resets` | InnoDB | `utf8mb4_unicode_ci` | 0 | Index (`email`) | None | Confirmed (Batch 1) | Auth password reset tokens |
| 33 | `permissions` | InnoDB | `utf8mb4_unicode_ci` | 55 | `id` (int) | Spatie Permission | Confirmed (Batch 5) | System permissions list |
| 34 | `products` | **MyISAM** | `utf8mb4_unicode_ci` | 11 | `id` (bigint) | `App\Models\Product` | Confirmed (Unrecorded) | Software products catalog |
| 35 | `registrations` | InnoDB | `utf8mb4_unicode_ci` | 270 | `id` (bigint) | `App\Models\Registration` | Confirmed (Batch 1) | BTEB board exam registrations |
| 36 | `reviews` | InnoDB | `utf8mb4_unicode_ci` | 91 | `id` (bigint) | `App\Models\Review` | Confirmed (Batch 8) | Student reviews & feedback ratings |
| 37 | `role_has_permissions` | InnoDB | `utf8mb4_unicode_ci` | 108 | `(perm, role)` | Spatie Permission | Confirmed (Batch 5) | Roles to permissions M2M mapping |
| 38 | `roles` | InnoDB | `utf8mb4_unicode_ci` | 3 | `id` (int) | Spatie Permission | Confirmed (Batch 5) | RBAC roles (Super Admin, Admin, Manager) |
| 39 | `seminor_registrations` | InnoDB | `utf8mb4_unicode_ci` | 13 | `id` (bigint) | `App\Models\SeminorRegistration` | Confirmed (Batch 12) | Seminar attendee registrations |
| 40 | `seminors` | InnoDB | `utf8mb4_unicode_ci` | 1 | `id` (bigint) | `App\Models\Seminor` | Confirmed (Batch 11) | Workshop / seminar event schedules |
| 41 | `services` | **MyISAM** | `utf8mb4_unicode_ci` | 9 | `id` (bigint) | `App\Models\Service` | Confirmed (Unrecorded) | IT services catalog |
| 42 | `sessions` | InnoDB | `utf8mb4_unicode_ci` | 10 | `id` (bigint) | `App\Models\Session` | Confirmed (Batch 1, Collision files) | Academic semester calendar sessions |
| 43 | `settings` | InnoDB | `utf8mb4_unicode_ci` | 23 | `id` (bigint) | `App\Models\Setting` | Confirmed (Batch 1) | Key-value application settings |
| 44 | `shareholders` | InnoDB | `utf8mb4_unicode_ci` | 6 | `id` (bigint) | `App\Models\Shareholder` | Confirmed (Unrecorded) | Corporate shareholders & equity owners |
| 45 | `sliders` | InnoDB | `utf8mb4_unicode_ci` | 1 | `id` (bigint) | `App\Models\Slider` | Confirmed (Batch 6) | Hero homepage banner sliders |
| 46 | `students` | InnoDB | `utf8mb4_unicode_ci` | 1,005 | `id` (bigint) | `App\Models\Students` | Confirmed (Batch 1) | Enrolled students master registry |
| 47 | `success_stories` | InnoDB | `utf8mb4_unicode_ci` | 1 | `id` (bigint) | `App\Models\SuccessStory` | Confirmed (Batch 4) | Alumni employment success showcase |
| 48 | `teachers` | InnoDB | `utf8mb4_unicode_ci` | 32 | `id` (bigint) | `App\Models\Teachers` | Confirmed (Batch 1, 8 Drift columns) | Faculty members, instructors & staff |
| 49 | `teams` | **MyISAM** | `utf8mb4_unicode_ci` | 0 | `id` (bigint) | `App\Models\Team` | Confirmed (Unrecorded) | Corporate leadership team |
| 50 | `technologies` | **MyISAM** | `utf8mb4_unicode_ci` | 0 | `id` (bigint) | `App\Models\Technology` | Confirmed (Unrecorded) | Taught software stacks & technologies |
| 51 | `users` | InnoDB | `utf8mb4_unicode_ci` | 149 | `id` (bigint) | `App\Models\User` | Confirmed (Batch 1, 1 Drift column) | Student portal login user accounts |
| 52 | `workflows` | **MyISAM** | `utf8mb4_unicode_ci` | 5 | `id` (bigint) | `App\Models\Workflow` | Confirmed (Unrecorded) | Development workflow steps |

---

## 3. Storage Engine Distribution & Risk Analysis

### Summary:
- **InnoDB (Transactional, ACID-compliant):** 38 Tables (73.1%)
- **MyISAM (Non-transactional, Table-level locks):** 14 Tables (26.9%)

### The 14 MyISAM Tables:
1. `asset_courses` (2 rows)
2. `asset_registration_feedbacks` (5 rows)
3. `asset_registrations` (31 rows)
4. `bank_loans` (7 rows)
5. `clients` (0 rows)
6. `concerns` (4 rows)
7. `dividend_withdraws` (1 row)
8. `emi_installments` (71 rows)
9. `investment_withdraws` (11 rows)
10. `products` (11 rows)
11. `services` (9 rows)
12. `teams` (0 rows)
13. `technologies` (0 rows)
14. `workflows` (5 rows)

**Risks of MyISAM in Production:**
- Zero rollback capability (`DB::beginTransaction()` does not protect MyISAM tables).
- Table-level locking under concurrent writes.
- Foreign keys defined in migrations or models are completely ignored by the MySQL MyISAM storage engine.
- *Mitigation Plan:* Must be migrated to standard transactional tables (InnoDB in MySQL / native relation tables in PostgreSQL) during modern deployment.

---

## 4. Collation and Character Set Variations

The live MySQL database is standardized on `utf8mb4` with two specific anomalies:
1. **`certificates_icbd` (`latin1_swedish_ci`):**
   - The table was created manually in phpMyAdmin using default Latin1 collation.
   - If Bengali student names or Unicode characters are stored in `certificate_receiver` without conversion, character corruption occurs.
2. **`courses` (`utf8mb4_general_ci`):**
   - Uses `utf8mb4_general_ci` instead of `utf8mb4_unicode_ci`. Less strict Unicode sorting rules.

---

## 5. Critical Data-Level Discoveries & Migration Preconditions

### 5.1 `fees_transections.trxID` Duplicate Key Trap
- **Live Row Count:** 1,604 payment records.
- **Null Values:** 1,598 records have `trxID IS NULL` (counter cash receipts).
- **Duplicate Key Detected:** Exactly 1 bKash transaction key (`AAN****SE0`) exists across **6 distinct records** (`id`: 332, 333, 334, 335, 336, 337) created on 2023-01-23.
- **Precondition:** Applying an unconditional `UNIQUE(trxID)` constraint will fail. PostgreSQL migration must use a partial unique index:
  ```sql
  CREATE UNIQUE INDEX fees_transections_trxid_unique 
  ON fees_transections ("trxID") 
  WHERE "trxID" IS NOT NULL AND TRIM("trxID") != '';
  ```

### 5.2 Zero Date Values (`0000-00-00`)
- **`expanses.invoiceDate`:** 6 rows contain `'0000-00-00'`
- **`incomes.invoiceDate`:** 8 rows contain `'0000-00-00'`
- **Precondition:** Total 14 zero-date rows must be sanitized to `NULL` during data migration because PostgreSQL rejects `'0000-00-00'` with SQL State 22008.

### 5.3 Comma-Formatted Financial Strings in `VARCHAR` Columns
- Legacy MySQL schema stores monetary values as `VARCHAR(191)` across `expanses.amount`, `incomes.amount`, `fees_transections.paidamount`, `invesments.amount`, `courses.coursefee`, and `students.coursefee`.
- Some records contain comma separators (e.g. `'15,000'`).
- The API layer sanitizes commas via `(float) str_replace(',', '', (string) $val)`. Future schema normalization must cleanse strings before casting to `NUMERIC(15,2)`.
