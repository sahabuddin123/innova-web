# Phase 3 — Laravel Migration Repair & Database Reconstruction Plan (Planning Only)

**Project:** `innova-web` — INNOVA Computers BD (ICBD)  
**Phase:** Phase 3 Planning (Strictly Planning & Architecture Specification — No Implementation)  
**Source Database:** MySQL 8.0.31 (`icbd_web` on `127.0.0.1:3306`, 52 Tables, 15,663 Records)  
**Target Architecture:** Laravel 13 · PHP 8.4 · PostgreSQL 15/16 · React Frontend · BN/EN i18n  
**Author:** Senior Database Migration Architect & Lead Engineer  
**Date:** October 2026  
**Status:** `PHASE 3 PLANNING COMPLETE — READY FOR OWNER REVIEW`  

---

## 1. Executive Summary

This document specifies an evidence-based, deterministic implementation plan to reconstruct, repair, and modernize the Laravel database migration system for `innova-web`.

During Phase 2, a strictly read-only audit of the live MySQL database (`icbd_web`) and repository source code revealed that the historical migration suite in `database/migrations/` is broken, out of sync with production, and incomplete:
1. **Broken Migration Suite:** Fresh execution of `php artisan migrate:fresh` crashes immediately due to three duplicate PHP migration class names (`CreateSessionsTable` x3, `CreateAssetCoursesTable` x2, `CreateAssetStudentsTable` x2) and a circular foreign-key dependency between `courses` and `course_categories`.
2. **Missing Core Tables:** Five production tables (`bank_loans`, `emi_installments`, `investment_withdraws`, `dividend_withdraws`, `certificates_icbd`) actively managed by Eloquent models and Admin controllers have zero migration files in the repository.
3. **Severe Schema Drift:** 23 production columns across 6 existing tables are missing from migration files, including critical financial/bKash payment fields (`fees_transections.trxID`, `channel`, `paymentID`, `status`).
4. **Data Integrity Baseline:** The live database currently preserves 100% referential integrity across 20 tested parent-child relationships (zero orphaned records), but contains 14 invalid zero dates (`0000-00-00`) and one duplicate bKash transaction key across 6 historical rows (`IDs: 332–337`).

**Mandatory Rule:** This document is an **architectural specification and repair plan only**. No migration files, models, controllers, configuration files, `.env` variables, or database records are created, altered, or deleted during this phase.

---

## 2. Preflight & Verification Findings

The preflight inspection confirmed the exact environmental baseline:
- **Active Git Branch:** `feature/phase-1-security-hardening` (Verified).
- **Working Tree Integrity:** All 17 Phase 1 security-hardening file changes remain intact. `git diff --check` passes with exit code 0.
- **Phase 2 Audit Reports Verified:**
  1. [`docs/phase-2-database/PHASE_2_DATABASE_INVENTORY.md`](file:///c:/wamp64/www/innova-web/docs/phase-2-database/PHASE_2_DATABASE_INVENTORY.md)
  2. [`docs/phase-2-database/PHASE_2_SCHEMA_DRIFT_REPORT.md`](file:///c:/wamp64/www/innova-web/docs/phase-2-database/PHASE_2_SCHEMA_DRIFT_REPORT.md)
  3. [`docs/phase-2-database/PHASE_2_POSTGRESQL_COMPATIBILITY.md`](file:///c:/wamp64/www/innova-web/docs/phase-2-database/PHASE_2_POSTGRESQL_COMPATIBILITY.md)
  4. [`docs/phase-2-database/PHASE_2_DATA_MIGRATION_PLAN.md`](file:///c:/wamp64/www/innova-web/docs/phase-2-database/PHASE_2_DATA_MIGRATION_PLAN.md)
  5. [`docs/phase-2-database/PHASE_2_BLOCKERS_AND_DECISIONS.md`](file:///c:/wamp64/www/innova-web/docs/phase-2-database/PHASE_2_BLOCKERS_AND_DECISIONS.md)
- **Authoritative Database Inspected:** `icbd_web` on MySQL 8.0.31 (`127.0.0.1:3306`, `root` user, local WampServer). Confirmed 52 tables and 15,663 operational records.

---

## 3. Master Table-by-Table Reconstruction Matrix (All 52 Tables)

Every table below is classified according to evidence from the Phase 2 live database audit and repository inspection:
- `CONFIRMED FROM PHASE 2`: Verified directly against live `information_schema` and database tables.
- `REQUIRES REPOSITORY VERIFICATION`: Verified against Eloquent models, controllers, and queries.

```
CLASSIFICATION KEY:
• ENGINE: InnoDB (Transactional / ACID) vs. MyISAM (Non-ACID / No Foreign Keys in MySQL)
• ACTION: RETAIN (Migration matches DB), REPAIR (Update migration columns), RECONSTRUCT (Author new migration from scratch)
```

| # | Table Name | Live Rows & Engine | Existing Migration Files | Eloquent Model & Core Relationships | Missing Migrations / Discrepancies | Dependencies | Reconstruction / Repair Approach | PostgreSQL Compatibility Concerns | Data Preservation & Rollback | Required Owner Approval |
|---|---|---|---|---|---|---|---|---|---|---|
| 1 | `admins` | 7 rows<br/>InnoDB | `2019_08_13_144617_create_admins_table.php` | [`Admin.php`](file:///c:/wamp64/www/innova-web/app/Models/Admin.php)<br/>• `hasMany(model_has_roles)` | Missing: `remember_token varchar(100)` in migration. | None | **REPAIR:** Add `rememberToken()` to migration. | `email` unique constraint; Bcrypt hash compatibility confirmed. | Preserve verbatim. 0 password resets. | None |
| 2 | `admissions` | 43 rows<br/>InnoDB | `2023_04_09_151558_create_admissions_table.php` | [`Admission.php`](file:///c:/wamp64/www/innova-web/app/Models/Admission.php)<br/>• `hasMany(Courses)` on `courseId` | None. Schema matches live DB. | `courses` | **RETAIN:** Update FK constraint syntax. | `isActive` integer to `SMALLINT`. | Preserve 43 lead records verbatim. | None |
| 3 | `asset_courses` | 2 rows<br/>**MyISAM** | `2026_05_20_000000`<br/>`2026_05_20_000300`<br/>`2026_05_21_000100` | [`AssetCourse.php`](file:///c:/wamp64/www/innova-web/app/Models/AssetCourse.php)<br/>• `hasMany(AssetRegistration)` on `name` | **Collision:** Duplicate class `CreateAssetCoursesTable`. Migration `000000` defines `deleted_at`, but live DB & model lack SoftDeletes. | None | **REPAIR:** Consolidate into single migration matching `000300` + `000100`. Remove duplicate `000000`. | MyISAM to PostgreSQL table; `status` boolean mapping. | Preserve 2 active government project courses. | Gate 2 |
| 4 | `asset_registration_feedbacks` | 5 rows<br/>**MyISAM** | `2026_05_20_000700_create_asset_registration_feedbacks_table.php` | [`AssetRegistrationFeedback.php`](file:///c:/wamp64/www/innova-web/app/Models/AssetRegistrationFeedback.php)<br/>• `belongsTo(AssetRegistration)` | Matches live DB. | `asset_registrations` | **RETAIN:** Convert to anonymous class. | MyISAM to PostgreSQL; `feedback_step` `unsignedTinyInteger` → `SMALLINT`. | Preserve 5 call feedback notes. | None |
| 5 | `asset_registrations` | 31 rows<br/>**MyISAM** | `2026_05_20_000100`<br/>`2026_05_20_000500`<br/>`2026_05_20_000600` | [`AssetRegistration.php`](file:///c:/wamp64/www/innova-web/app/Models/AssetRegistration.php)<br/>• `hasMany(feedbacks)`<br/>• `belongsTo(AssetCourse)` on string `course` | Matches live DB. | None | **RETAIN:** Consolidate add-column migrations into baseline definition. | MyISAM to PostgreSQL. String foreign key on `course` requires indexing. | Preserve 31 trainee lead records verbatim. | None |
| 6 | `bank_loans` | 7 rows<br/>**MyISAM** | **NONE** (Missing) | [`BankLoan.php`](file:///c:/wamp64/www/innova-web/app/Models/BankLoan.php)<br/>• `belongsTo(Shareholder)`<br/>• `hasMany(EmiInstallment)`<br/>• `belongsTo(Admin, 'created_by')` | **UNMIGRATED:** 16 columns exist in live DB without migration. | `shareholders`, `admins` | **RECONSTRUCT:** Author new migration `create_bank_loans_table` from live schema with `loan_amount`, `savings_amount` as `decimal(15,2)`. | MyISAM to PostgreSQL; Add explicit foreign keys to `shareholders(id)` and `admins(id)`. | 7 loan ledgers preserved verbatim. | Gate 1 |
| 7 | `batchs` | 65 rows<br/>InnoDB | `2022_08_13_194856_create_batchs_table.php` | [`Batchs.php`](file:///c:/wamp64/www/innova-web/app/Models/Batchs.php)<br/>• `belongsTo(Teachers, 'stuff_id')`<br/>• `hasMany(Students)` | Matches live DB. | `teachers` | **RETAIN:** Convert to anonymous class; keep table name `batchs`. | `totalseat` is `varchar(191)` in DB; cast to `INTEGER` in target schema. | 65 batches preserved verbatim. | None |
| 8 | `blog_categoris` | 3 rows<br/>InnoDB | `2024_12_26_141652_create_blog_categoris_table.php` | [`blogCategoris.php`](file:///c:/wamp64/www/innova-web/app/Models/blogCategoris.php)<br/>• `hasMany(Blog)` | Matches live DB. | None | **RETAIN:** Convert to anonymous class. | Standard table. | 3 categories preserved. | None |
| 9 | `blogs` | 3 rows<br/>InnoDB | `2024_12_26_142039_create_blogs_table.php` | [`Blog.php`](file:///c:/wamp64/www/innova-web/app/Models/Blog.php)<br/>• `belongsTo(blogCategoris)` | Matches live DB. | `blog_categoris` | **RETAIN:** Convert to anonymous class. | Standard table. | 3 published blog posts preserved. | None |
| 10 | `branches` | 4 rows<br/>InnoDB | `2024_07_15_223125_create_branches_table.php` | [`Branch.php`](file:///c:/wamp64/www/innova-web/app/Models/Branch.php)<br/>• `hasMany(Students)`<br/>• `hasMany(Expanses)` | Matches live DB. | None | **RETAIN:** Convert to anonymous class. | Standard table. | 4 branches preserved. | None |
| 11 | `certificates` | 128 rows<br/>InnoDB | `2024_07_06_190257_create_certificates_table.php` | [`Certificates.php`](file:///c:/wamp64/www/innova-web/app/Models/Certificates.php)<br/>• `belongsTo(Students)`<br/>• `belongsTo(Session)` | Collision: `session_id` references academic `sessions` table. | `students`, `sessions` | **REPAIR:** Update FK to reference `academic_sessions(id)`. | Standard table. | 128 BTEB certificate records preserved. | Gate 2 |
| 12 | `certificates_icbd` | 38 rows<br/>InnoDB | **NONE** (Missing) | [`Certificate_icbd.php`](file:///c:/wamp64/www/innova-web/app/Models/Certificate_icbd.php)<br/>• `belongsTo(Students)`<br/>• `belongsTo(Branch, 'batch_id')` (Model Bug!)<br/>• `belongsTo(Courses)` | **UNMIGRATED:** 16 columns exist in live DB without migration. Model has bug pointing `batch_id` to `Branch::class`. | `students`, `batchs`, `courses` | **RECONSTRUCT:** Author new migration `create_certificates_icbd_table`. Correct model relation to `Batchs::class`. | Collation is `latin1_swedish_ci` in MySQL; must convert to `UTF8` in PostgreSQL. | 38 institute certificates preserved. | Gate 1 |
| 13 | `clients` | 0 rows<br/>**MyISAM** | `2026_04_20_222721_create_clients_table.php` | [`Client.php`](file:///c:/wamp64/www/innova-web/app/Models/Client.php) | Matches live DB (empty). | None | **RETAIN:** Convert to anonymous class. | MyISAM to PostgreSQL. | Table structure preserved. | None |
| 14 | `cms_abouts` | 1 row<br/>InnoDB | `2024_12_26_142340_create_cms_abouts_table.php` | [`cmsAbout.php`](file:///c:/wamp64/www/innova-web/app/Models/cmsAbout.php) | Matches live DB. | None | **RETAIN:** Convert to anonymous class. | Standard table. | Corporate profile block preserved. | None |
| 15 | `concerns` | 4 rows<br/>**MyISAM** | `2026_04_20_193559_create_concerns_table.php` | [`Concern.php`](file:///c:/wamp64/www/innova-web/app/Models/Concern.php) | Matches live DB. | None | **RETAIN:** Convert to anonymous class. | MyISAM to PostgreSQL. | 4 sister concerns preserved. | None |
| 16 | `contacts` | 269 rows<br/>InnoDB | `2023_04_10_151938_create_contacts_table.php` | [`Contact.php`](file:///c:/wamp64/www/innova-web/app/Models/Contact.php)<br/>• `belongsTo(Courses, 'courseId')` | Matches live DB. | `courses` | **RETAIN:** Convert to anonymous class. | Standard table. | 269 public inquiries preserved. | None |
| 17 | `course_categories` | 10 rows<br/>InnoDB | `2024_12_17_142915_create_course_categories_table.php` | [`CourseCategory.php`](file:///c:/wamp64/www/innova-web/app/Models/CourseCategory.php)<br/>• `hasMany(Courses)` | Missing: `fontawesome`, `isFeature`, `tabId` exist in live DB. | None | **REPAIR:** Add the 3 missing columns to migration. Ensure chronological order precedes `courses`. | Standard table. | 10 categories preserved. | Gate 2 |
| 18 | `courses` | 26 rows<br/>InnoDB | `2022_08_12_080223_create_courses_table.php` | [`Courses.php`](file:///c:/wamp64/www/innova-web/app/Models/Courses.php)<br/>• `belongsTo(CourseCategory)`<br/>• `hasMany(Students)` | **Drift:** 7 missing columns (`IsCourse`, `courseFor`, `Instructor`, `Rating`, `TotalReview`, `Discount`, `views`). `coursefee` is `decimal(10,2)` in DB vs. `string` in migration. Circular FK to `course_categories`. | `course_categories` | **REPAIR:** Move migration after `course_categories`; add 7 missing columns; define `coursefee` as `decimal(10,2)`. | Collation in MySQL is `utf8mb4_general_ci`; convert to UTF8. Name has 2 duplicates (no unique index). | 26 courses preserved. | Gate 2 |
| 19 | `dividend_withdraws` | 1 row<br/>**MyISAM** | **NONE** (Missing) | [`DividendWithdraw.php`](file:///c:/wamp64/www/innova-web/app/Models/DividendWithdraw.php)<br/>• `belongsTo(Shareholder)`<br/>• `belongsTo(Admin, 'requested_by')` | **UNMIGRATED:** 20 columns exist in live DB without migration. | `shareholders`, `admins` | **RECONSTRUCT:** Author new migration `create_dividend_withdraws_table` with `amount decimal(15,2)`. | MyISAM to PostgreSQL; Add foreign keys. | 1 disbursement record preserved. | Gate 1 |
| 20 | `emi_installments` | 71 rows<br/>**MyISAM** | **NONE** (Missing) | [`EmiInstallment.php`](file:///c:/wamp64/www/innova-web/app/Models/EmiInstallment.php)<br/>• `belongsTo(BankLoan)`<br/>• `belongsTo(Shareholder)` | **UNMIGRATED:** 15 columns exist in live DB without migration. | `bank_loans`, `shareholders`, `admins` | **RECONSTRUCT:** Author new migration `create_emi_installments_table` with `emi_amount`, `savings_amount` as `decimal(15,2)`. | MyISAM to PostgreSQL; Add foreign keys. | 71 installment repayments preserved. | Gate 1 |
| 21 | `expanse_categoris` | 118 rows<br/>InnoDB | `2022_11_23_191455_create_expanse_categoris_table.php` | [`ExpanseCategoris.php`](file:///c:/wamp64/www/innova-web/app/Models/ExpanseCategoris.php)<br/>• `hasMany(Expanses)` | Matches live DB. | None | **RETAIN:** Convert to anonymous class; keep name `expanse_categoris`. | Standard table. | 118 categories preserved. | None |
| 22 | `expanses` | 6,338 rows<br/>InnoDB | `2022_11_23_191754_create_expanses_table.php` | [`Expanse.php`](file:///c:/wamp64/www/innova-web/app/Models/Expanse.php)<br/>• `belongsTo(ExpanseCategoris)`<br/>• `belongsTo(Branch)`<br/>• `belongsTo(User)` | `amount` defined as `string` in migration and DB. Contains 6 `'0000-00-00'` dates. | `expanse_categoris`, `branches`, `users` | **REPAIR:** Change `amount` to `decimal(15,2)` in target schema. Pre-cleanse 6 zero-dates to `NULL`. | Strict `GROUP BY` refactor in `ReportController.php:54-74`. | 6,338 expenditure vouchers preserved. | Gate 4, 5 |
| 23 | `fees_transections` | 1,604 rows<br/>InnoDB | `2022_08_17_205522_create_fees_transections_table.php` | [`FeesTransections.php`](file:///c:/wamp64/www/innova-web/app/Models/FeesTransections.php)<br/>• `belongsTo(Students)`<br/>• `belongsTo(User)` | **Drift:** Missing `channel`, `trxID`, `paymentID`, `status`. `paidamount` is `varchar(191)` in DB and migration. Duplicate `trxID` on IDs 332–337. | `students`, `users` | **REPAIR:** Add missing 4 columns. In PostgreSQL, define `paidamount decimal(15,2)` and **partial unique index** on `trxID`. | Unconditional UNIQUE constraint will crash restore on duplicate IDs 332–337. Partial index required. | 1,604 payment records preserved. 0 loss. | Gate 3, 4 |
| 24 | `galleries` | 21 rows<br/>InnoDB | `2025_01_02_233300_create_galleries_table.php` | [`Gallery.php`](file:///c:/wamp64/www/innova-web/app/Models/Gallery.php) | Matches live DB. | None | **RETAIN:** Convert to anonymous class. | Standard table. | 21 photo records preserved. | None |
| 25 | `income_categoris` | 75 rows<br/>InnoDB | `2024_07_22_222816_create_income_categoris_table.php` | [`IncomeCategoris.php`](file:///c:/wamp64/www/innova-web/app/Models/IncomeCategoris.php)<br/>• `hasMany(Incomes)` | Matches live DB. | `branches` | **RETAIN:** Convert to anonymous class. | Standard table. | 75 categories preserved. | None |
| 26 | `incomes` | 5,694 rows<br/>InnoDB | `2024_07_22_223012_create_incomes_table.php` | [`Income.php`](file:///c:/wamp64/www/innova-web/app/Models/Income.php)<br/>• `belongsTo(IncomeCategoris)`<br/>• `belongsTo(Branch)` | `amount` is `varchar(191)`. Contains 8 `'0000-00-00'` dates. | `income_categoris`, `branches`, `users` | **REPAIR:** Change `amount` to `decimal(15,2)`. Pre-cleanse 8 zero-dates to `NULL`. | Strict `GROUP BY` refactor in `ReportController.php:105-125`. | 5,694 revenue vouchers preserved. | Gate 4, 5 |
| 27 | `invesments` | 46 rows<br/>InnoDB | `2023_04_27_130952_create_invesments_table.php` | [`Invesments.php`](file:///c:/wamp64/www/innova-web/app/Models/Invesments.php)<br/>• `belongsTo(Shareholder)` | `amount` is `varchar(191)`. | `shareholders` | **REPAIR:** Change `amount` to `decimal(15,2)`. Keep name `invesments`. | Standard table. | 46 investment entries preserved. | Gate 4 |
| 28 | `investment_withdraws`| 11 rows<br/>**MyISAM** | **NONE** (Missing) | [`InvestmentWithdraw.php`](file:///c:/wamp64/www/innova-web/app/Models/InvestmentWithdraw.php)<br/>• `belongsTo(Shareholder)`<br/>• `belongsTo(Admin, 'requested_by')` | **UNMIGRATED:** 20 columns exist in live DB without migration. | `shareholders`, `admins` | **RECONSTRUCT:** Author new migration `create_investment_withdraws_table` with `amount decimal(15,2)`. | MyISAM to PostgreSQL; Add foreign keys. | 11 capital withdrawals preserved. | Gate 1 |
| 29 | `migrations` | 24 rows<br/>InnoDB | Core Laravel | N/A | Tracks migration history. | None | **SYSTEM:** Managed by Laravel migration repository. | Standard table. | Synchronize batch counter post-migration. | None |
| 30 | `model_has_permissions`| 0 rows<br/>InnoDB | `2023_01_11_232251_create_permission_tables.php` | Spatie Permission | Matches live DB. | `permissions` | **RETAIN:** Preserved via Spatie configuration. | Composite primary key `(permission_id, model_id, model_type)`. | Preserved. | None |
| 31 | `model_has_roles` | 7 rows<br/>InnoDB | `2023_01_11_232251_create_permission_tables.php` | Spatie Permission | Matches live DB. | `roles` | **RETAIN:** Preserved via Spatie configuration. | Composite primary key. | 7 admin role assignments preserved. | None |
| 32 | `password_resets` | 0 rows<br/>InnoDB | `2014_10_12_100000_create_password_resets_table.php` | N/A | Matches live DB. | None | **RETAIN:** Standard table. | Index on `email`. | Preserved. | None |
| 33 | `permissions` | 55 rows<br/>InnoDB | `2023_01_11_232251_create_permission_tables.php` | Spatie Permission | Matches live DB. | None | **RETAIN:** Standard table. | Unique on `(name, guard_name)`. | 55 RBAC permissions preserved. | None |
| 34 | `products` | 11 rows<br/>**MyISAM** | `2026_04_20_193551_create_products_table.php` | [`Product.php`](file:///c:/wamp64/www/innova-web/app/Models/Product.php) | Matches live DB. | None | **RETAIN:** Convert to anonymous class. | MyISAM to PostgreSQL. | 11 products preserved. | None |
| 35 | `registrations` | 270 rows<br/>InnoDB | `2022_08_19_163921_create_registrations_table.php` | [`Registration.php`](file:///c:/wamp64/www/innova-web/app/Models/Registration.php)<br/>• `belongsTo(Students)`<br/>• `belongsTo(Session)` | Collision: `session_id` references academic sessions table. | `students`, `sessions` | **REPAIR:** Update FK to reference `academic_sessions(id)`. | Standard table. | 270 BTEB registrations preserved. | Gate 2 |
| 36 | `reviews` | 91 rows<br/>InnoDB | `2024_12_25_212411_create_reviews_table.php` | [`Review.php`](file:///c:/wamp64/www/innova-web/app/Models/Review.php)<br/>• `belongsTo(Students)` | Matches live DB. | `students` | **RETAIN:** Convert to anonymous class. | Standard table. | 91 reviews preserved. | None |
| 37 | `role_has_permissions` | 108 rows<br/>InnoDB | `2023_01_11_232251_create_permission_tables.php` | Spatie Permission | Matches live DB. | `roles`, `permissions` | **RETAIN:** Preserved via Spatie configuration. | Composite primary key. | 108 role permissions preserved. | None |
| 38 | `roles` | 3 rows<br/>InnoDB | `2023_01_11_232251_create_permission_tables.php` | Spatie Permission | Matches live DB. | None | **RETAIN:** Standard table. | Unique on `(name, guard_name)`. | 3 roles preserved. | None |
| 39 | `seminor_registrations`| 13 rows<br/>InnoDB | `2024_12_26_142234_create_seminor_registrations_table.php` | [`SeminorRegistration.php`](file:///c:/wamp64/www/innova-web/app/Models/SeminorRegistration.php)<br/>• `belongsTo(Seminor)` | Matches live DB. | `seminors` | **RETAIN:** Convert to anonymous class. | Standard table. | 13 seminar attendees preserved. | None |
| 40 | `seminors` | 1 row<br/>InnoDB | `2024_12_26_142123_create_seminors_table.php` | [`Seminor.php`](file:///c:/wamp64/www/innova-web/app/Models/Seminor.php)<br/>• `belongsTo(Courses)` | Matches live DB. | `courses` | **RETAIN:** Convert to anonymous class. | Standard table. | 1 seminar preserved. | None |
| 41 | `services` | 9 rows<br/>**MyISAM** | `2026_04_20_193543_create_services_table.php` | [`Service.php`](file:///c:/wamp64/www/innova-web/app/Models/Service.php) | Matches live DB. | None | **RETAIN:** Convert to anonymous class. | MyISAM to PostgreSQL. | 9 service offerings preserved. | None |
| 42 | `sessions` (Academic) | 10 rows<br/>InnoDB | `2022_08_19_163812_create_sessions_table.php`<br/>*(Collides with `2024_07_13_012857` & `2024_07_16_031214`)* | [`Session.php`](file:///c:/wamp64/www/innova-web/app/Models/Session.php)<br/>• `hasMany(Registrations)`<br/>• `hasMany(Certificates)` | **Critical Collision:** Class name and table name collide with Laravel HTTP session driver. | None | **RECONSTRUCT / RENAME:** Rename table to `academic_sessions`; update model to `protected $table = 'academic_sessions';`. Let single HTTP session migration create `sessions`. | Resolves table & class collisions completely. | 10 academic sessions preserved verbatim. | Gate 2 |
| 43 | `settings` | 23 rows<br/>InnoDB | `2019_08_14_124941_create_settings_table.php`<br/>`2026_04_27_000001_add_ui_theme_settings.php` | [`Setting.php`](file:///c:/wamp64/www/innova-web/app/Models/Setting.php) | Matches live DB. | None | **RETAIN:** Consolidate UI theme settings into baseline seeder/migration. | Unique on `key`. | 23 system settings preserved. | None |
| 44 | `shareholders` | 6 rows<br/>InnoDB | `2023_04_27_130942_create_shareholders_table.php` | [`Shareholder.php`](file:///c:/wamp64/www/innova-web/app/Models/Shareholder.php)<br/>• `hasMany(Invesments)`<br/>• `hasMany(BankLoan)` | Matches live DB. | None | **RETAIN:** Convert to anonymous class. | Standard table. | 6 shareholders preserved. | None |
| 45 | `sliders` | 1 row<br/>InnoDB | `2022_12_01_195014_create_sliders_table.php` | [`Slider.php`](file:///c:/wamp64/www/innova-web/app/Models/Slider.php) | Matches live DB. | None | **RETAIN:** Convert to anonymous class. | Standard table. | 1 slider preserved. | None |
| 46 | `students` | 1,005 rows<br/>InnoDB | `2022_08_16_072354_create_students_table.php` | [`Students.php`](file:///c:/wamp64/www/innova-web/app/Models/Students.php)<br/>• `belongsTo(Courses)`<br/>• `belongsTo(Batchs)`<br/>• `belongsTo(Branch)`<br/>• `hasMany(FeesTransections)` | `course_fee`, `discount`, `balance` are strings in migration & DB. `IsActive` is an academic state enumeration (1=Active, 2=Irregular, 3=Completed, 4=Restricted, 5=Postponed). | `courses`, `batchs`, `branches`, `users` | **REPAIR:** Convert monetary columns to `numeric(15,2)`. Map `IsActive` to `SMALLINT`. Inverted relation `FeesTransaction()` in model must be documented. | **Do NOT convert `IsActive` to `BOOLEAN`** (permanent status corruption). Search requires `ILIKE`. Phone has 75 duplicates (cannot be unique). | 1,005 student profiles preserved. | Gate 4 |
| 47 | `success_stories` | 1 row<br/>InnoDB | `2022_12_06_015548_create_success_stories_table.php` | [`SuccessStory.php`](file:///c:/wamp64/www/innova-web/app/Models/SuccessStory.php)<br/>• `belongsTo(Students)` | Matches live DB. | `students` | **RETAIN:** Convert to anonymous class. | Standard table. | 1 success story preserved. | None |
| 48 | `teachers` | 32 rows<br/>InnoDB | `2020_11_04_171732_create_teachers_table.php` | [`Teachers.php`](file:///c:/wamp64/www/innova-web/app/Models/Teachers.php)<br/>• `hasMany(Batchs)` | **Drift:** 8 unmigrated columns exist in live DB: `email`, `ComCourse`, `nStd`, `rating`, `review`, `isTeacher`, `IsFeatured`, `bio`. Model `Stuff.php` is orphaned. | `users` | **REPAIR:** Add the 8 missing columns to migration. Document orphaned `Stuff.php` model. | Standard table. `isTeacher`, `IsFeatured` integer flags. | 32 teacher/staff profiles preserved. | Gate 2 |
| 49 | `teams` | 0 rows<br/>**MyISAM** | `2026_04_20_235853_create_teams_table.php` | [`Team.php`](file:///c:/wamp64/www/innova-web/app/Models/Team.php) | Matches live DB (empty). | None | **RETAIN:** Convert to anonymous class. | Identifier `"order"` is a SQL reserved word; must be quoted in raw queries. | Table structure preserved. | None |
| 50 | `technologies` | 0 rows<br/>**MyISAM** | `2026_04_20_230116_create_technologies_table.php` | [`Technology.php`](file:///c:/wamp64/www/innova-web/app/Models/Technology.php) | Matches live DB (empty). | None | **RETAIN:** Convert to anonymous class. | MyISAM to PostgreSQL. | Table structure preserved. | None |
| 51 | `users` | 149 rows<br/>InnoDB | `2014_10_12_000000_create_users_table.php` | [`User.php`](file:///c:/wamp64/www/innova-web/app/Models/User.php)<br/>• `hasOne(Students)` | Missing: `name varchar(191)` exists in live DB. | None | **REPAIR:** Add `name` column to migration. | Bcrypt `$2y$10$` hashes 100% compatible. Email unique. | 149 student accounts preserved verbatim. 0 password resets. | None |
| 52 | `workflows` | 5 rows<br/>**MyISAM** | `2026_04_20_193607_create_workflows_table.php` | [`Workflow.php`](file:///c:/wamp64/www/innova-web/app/Models/Workflow.php) | Matches live DB. | None | **RETAIN:** Convert to anonymous class. | MyISAM to PostgreSQL. | 5 workflow steps preserved. | None |
| *Ghost 1* | `assets` | **0 rows (Absent)** | `2026_05_19_000000_create_assets_table.php` | [`Asset.php`](file:///c:/wamp64/www/innova-web/app/Models/Asset.php) | **Ghost:** Defined in migration, but table never created in live MySQL DB. | None | **REPAIR:** Authoritative target schema creates table cleanly. | PostgreSQL table. | No historical data to preserve. | Gate 2 |
| *Ghost 2* | `asset_students` | **0 rows (Absent)** | `2026_05_20_000001`<br/>`2026_05_20_000400` | [`AssetStudent.php`](file:///c:/wamp64/www/innova-web/app/Models/AssetStudent.php) | **Ghost & Collision:** Duplicate class; table never created in live DB (applications stored in `asset_registrations`). | `asset_courses` | **REPAIR:** Consolidate migration matching `000400` (without SoftDeletes, matching model). Remove duplicate `000001`. | PostgreSQL table. | No historical data to preserve. | Gate 2 |

---

## 4. Missing Table & Column Reconstruction Inventory

### 4.1 Five Tables Requiring Reverse-Engineered Migrations
The following 5 migrations will be generated from scratch in Phase 3 implementation, matching the live database schema:

1. **`create_bank_loans_table.php`:**
   - Columns: `id` (bigint PK), `shareholder_id` (bigint FK), `bank_name` (varchar 191), `loan_amount` (decimal 15,2), `interest_rate` (decimal 5,2), `loan_term_months` (int), `loan_date` (date), `maturity_date` (date), `installment_count` (int), `savings_amount` (decimal 15,2), `status` (varchar 50), `remarks` (text), `created_by` (bigint FK), `timestamps`, `softDeletes`.
2. **`create_emi_installments_table.php`:**
   - Columns: `id` (bigint PK), `bank_loan_id` (bigint FK), `shareholder_id` (bigint FK), `emi_amount` (decimal 15,2), `savings_amount` (decimal 15,2), `payment_date` (date), `payment_method` (varchar 50), `paid_by` (bigint FK), `received_by` (bigint FK), `paid_at` (datetime), `status` (varchar 50), `remarks` (text), `timestamps`, `softDeletes`.
3. **`create_investment_withdraws_table.php`:**
   - Columns: `id` (bigint PK), `shareholder_id` (bigint FK), `amount` (decimal 15,2), `withdraw_date` (date), `method` (varchar 191), `branch_name` (varchar 191), `receiver_name` (varchar 191), `pay_by` (varchar 191), `account_number` (varchar 191), `status` (varchar 191), `requested_by` (bigint FK), `requested_at` (datetime), `processed_by` (bigint FK), `processed_at` (datetime), `processed_remarks` (text), `remarks` (text), `attachment` (varchar 191), `timestamps`, `softDeletes`.
4. **`create_dividend_withdraws_table.php`:**
   - Columns: Identical schema structure to `investment_withdraws`.
5. **`create_certificates_icbd_table.php`:**
   - Columns: `id` (bigint PK), `student_id` (bigint FK), `batch_id` (bigint FK), `course_id` (bigint FK), `certificate_no` (varchar 191), `theory_hours` (varchar 191), `practical_hours` (varchar 191), `intern_hours` (varchar 191), `result` (varchar 191), `issue_date` (date), `certificate_receiver` (varchar 191), `delivery_date` (date), `is_active` (int), `timestamps`, `softDeletes`.

### 4.2 Twenty-Three Unmigrated Columns Across Six Tables
| Table | Column Name | Confirmed Type in Live DB | Nullable | Default | Source Code Verification |
|---|---|---|---|---|---|
| `fees_transections` | `channel` | `int` | YES | `1` | [`BkashController.php:220`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/BkashController.php#L220) |
| `fees_transections` | `trxID` | `varchar(255)` | YES | `NULL` | [`BkashController.php:207, 220`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/BkashController.php#L207) |
| `fees_transections` | `paymentID` | `varchar(255)` | YES | `NULL` | [`BkashController.php:221`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/BkashController.php#L221) |
| `fees_transections` | `status` | `int` | YES | `0` | [`UserController.php:206, 233`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/UserController.php#L206) |
| `courses` | `IsCourse` | `int` | NO | `0` | [`Courses.php:36`](file:///c:/wamp64/www/innova-web/app/Models/Courses.php#L36) |
| `courses` | `courseFor` | `varchar(255)` | YES | `NULL` | [`Courses.php:39`](file:///c:/wamp64/www/innova-web/app/Models/Courses.php#L39) |
| `courses` | `Instructor` | `varchar(255)` | YES | `NULL` | [`Courses.php:40`](file:///c:/wamp64/www/innova-web/app/Models/Courses.php#L40) |
| `courses` | `Rating` | `varchar(255)` | YES | `NULL` | [`Courses.php:41`](file:///c:/wamp64/www/innova-web/app/Models/Courses.php#L41) |
| `courses` | `TotalReview` | `varchar(255)` | YES | `NULL` | [`Courses.php:42`](file:///c:/wamp64/www/innova-web/app/Models/Courses.php#L42) |
| `courses` | `Discount` | `varchar(255)` | YES | `NULL` | [`Courses.php:43`](file:///c:/wamp64/www/innova-web/app/Models/Courses.php#L43) |
| `courses` | `views` | `int` | YES | `0` | [`Courses.php:44`](file:///c:/wamp64/www/innova-web/app/Models/Courses.php#L44) |
| `teachers` | `email` | `varchar(191)` | YES | `NULL` | [`Teachers.php`](file:///c:/wamp64/www/innova-web/app/Models/Teachers.php) |
| `teachers` | `ComCourse` | `varchar(255)` | YES | `NULL` | [`Teachers.php:46`](file:///c:/wamp64/www/innova-web/app/Models/Teachers.php#L46) |
| `teachers` | `nStd` | `varchar(255)` | YES | `NULL` | [`Teachers.php:47`](file:///c:/wamp64/www/innova-web/app/Models/Teachers.php#L47) |
| `teachers` | `rating` | `varchar(255)` | YES | `NULL` | [`Teachers.php:48`](file:///c:/wamp64/www/innova-web/app/Models/Teachers.php#L48) |
| `teachers` | `review` | `varchar(255)` | YES | `NULL` | [`Teachers.php:49`](file:///c:/wamp64/www/innova-web/app/Models/Teachers.php#L49) |
| `teachers` | `isTeacher` | `int` | YES | `0` | [`FrontendController.php:48, 199, 257`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Frontend/FrontendController.php#L48) |
| `teachers` | `IsFeatured` | `int` | YES | `0` | [`FrontendController.php:48, 257`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Frontend/FrontendController.php#L48) |
| `teachers` | `bio` | `text` | YES | `NULL` | [`Teachers.php:53`](file:///c:/wamp64/www/innova-web/app/Models/Teachers.php#L53) |
| `course_categories` | `fontawesome` | `varchar(191)` | YES | `NULL` | [`CourseCategory.php`](file:///c:/wamp64/www/innova-web/app/Models/CourseCategory.php) |
| `course_categories` | `isFeature` | `int` | YES | `0` | [`FrontendController.php:40`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Frontend/FrontendController.php#L40) |
| `course_categories` | `tabId` | `varchar(191)` | YES | `NULL` | [`CourseCategory.php`](file:///c:/wamp64/www/innova-web/app/Models/CourseCategory.php) |
| `admins` | `remember_token` | `varchar(100)` | YES | `NULL` | Laravel Auth Guard |
| `users` | `name` | `varchar(191)` | YES | `NULL` | [`User.php`](file:///c:/wamp64/www/innova-web/app/Models/User.php) |

---

## 5. Migration Collision & Dependency Resolution Plan

### 5.1 Anonymous Class Migration Strategy & Trade-Offs
- **The Problem:** The existing migration suite contains duplicate class declarations that crash `php artisan migrate:fresh` on PHP 8+.
- **Options Evaluated:**
  - *Option A (Risky):* Bulk-rewrite every existing historical migration file to anonymous class syntax (`return new class extends Migration`).
    - *Risk:* If executed against an existing production database where migrations are already recorded in `migrations` table by old batch numbers, renaming or altering files can create mismatch between migration filenames and database records.
  - *Option B (Recommended — Safe Staged Strategy):*
    1. Retain existing historical migrations untouched on the feature branch.
    2. Consolidate duplicate migrations Surgically:
       - Academic sessions: Rename [`2022_08_19_163812_create_sessions_table.php`](file:///c:/wamp64/www/innova-web/database/migrations/2022_08_19_163812_create_sessions_table.php) class to `CreateAcademicSessionsTable` creating table `academic_sessions`. Remove the redundant second HTTP session file [`2024_07_16_031214_create_sessions_table.php`](file:///c:/wamp64/www/innova-web/database/migrations/2024_07_16_031214_create_sessions_table.php).
       - Asset courses: Delete redundant `2026_05_20_000000`; keep authoritative `2026_05_20_000300` + `2026_05_21_000100`.
       - Asset students: Delete redundant `2026_05_20_000001`; keep authoritative `2026_05_20_000400`.
    3. Author all new migrations (`bank_loans`, `emi_installments`, etc.) using anonymous classes (`return new class extends Migration`).

### 5.2 Resolution of `courses` vs. `course_categories` Circular Dependency
- **Current Bug:** [`2022_08_12_080223_create_courses_table.php`](file:///c:/wamp64/www/innova-web/database/migrations/2022_08_12_080223_create_courses_table.php) declares a foreign key referencing `course_categories(id)`, but `course_categories` migration was written in `2024_12_17`.
- **Resolution Plan:**
  1. Remove the premature foreign key declaration from the 2022 `courses` migration.
  2. In the 2024 `course_categories` migration (or a dedicated post-category migration), add the foreign key constraint:
     ```php
     Schema::table('courses', function (Blueprint $table) {
         $table->foreign('category_id')->references('id')->on('course_categories')->onDelete('set null');
     });
     ```

---

## 6. Payment-Data Integrity Strategy (`fees_transections`)

### 6.1 Audit Baseline
- Total records: **1,604 rows**.
- Cash/Counter payments: **1,598 rows** (`trxID IS NULL`).
- Empty strings: **0 rows**.
- Non-null `trxID` rows: **6 rows**.

### 6.2 Analysis of Duplicate IDs 332 to 337
All 6 non-null rows share the identical transaction key (`AAN****SE0`):
- `id: 332` — Created `2023-01-23 08:20:02`
- `id: 333` — Created `2023-01-23 08:24:15`
- `id: 334` — Created `2023-01-23 08:35:40`
- `id: 335` — Created `2023-01-23 08:42:11`
- `id: 336` — Created `2023-01-23 08:50:05`
- `id: 337` — Created `2023-01-23 09:01:30`

### 6.3 Why Naive Unconditional Unique Index Fails
1. An unconditional `UNIQUE(trxID)` constraint in MySQL or PostgreSQL will immediately fail during migration with:
   `duplicate key value violates unique constraint (Key (trxID)=(AAN...SE0) already exists)`.
2. Furthermore, in some SQL dialects, multiple `NULL` values can conflict if unique indexes are misconfigured.

### 6.4 Proposed Reconciliation Procedure (For Approved Phase)
1. **No Data Deletion in Planning:** All 6 records remain 100% untouched.
2. **Owner & Accounting Review:** INNOVA Computers BD accounting will review whether IDs 333–337 represent duplicate student portal payment attempts that were already credited, or separate partial payments.
3. **Database Architecture Solution:** In the PostgreSQL target schema, implement a **partial unique index**:
   ```sql
   CREATE UNIQUE INDEX fees_transections_trxid_unique 
   ON fees_transections ("trxID") 
   WHERE "trxID" IS NOT NULL AND TRIM("trxID") != '';
   ```
   This accommodates 1,598+ cash receipts without restriction while strictly guaranteeing that future bKash payments can never be duplicated.

---

## 7. PostgreSQL Compatibility Dependencies

| Risk Category | MySQL Source State | PostgreSQL Failure Mode | Staged Implementation Plan |
|---|---|---|---|
| **Monetary Strings** | `VARCHAR(191)` in `expanses`, `incomes`, `fees_transections`, `students`, `invesments` | `ERROR: invalid input syntax for type numeric` if strings containing commas (`15,000`) are inserted | Stage 1: Build ETL regex cleansing script.<br/>Stage 2: Target schema defines `NUMERIC(15,2)`.<br/>Stage 3: Validate exact totals match to 0.00 BDT tolerance. |
| **Zero Dates** | 14 rows contain `'0000-00-00'` (`expanses.invoiceDate`: 6, `incomes.invoiceDate`: 8) | `ERROR: date out of range for "0000-00-00"` | Convert all 14 rows to `NULL` prior to PostgreSQL restore. |
| **Multi-State Integer** | `students.IsActive` contains 5 academic statuses (1=Active, 2=Irregular, 3=Completed, 4=Restricted, 5=Postponed) | Coercion to `BOOLEAN` maps 2, 3, 4, 5 to `TRUE`, permanently corrupting student records | Define `students.IsActive` strictly as `SMALLINT NOT NULL DEFAULT 1` with check constraint `BETWEEN 1 AND 5`. |
| **MyISAM Conversion** | 14 tables lack ACID and foreign keys | None in PostgreSQL (all tables transactional) | Define all 14 tables as standard PostgreSQL tables with explicit foreign-key constraints. |
| **Collation Mismatch** | `certificates_icbd` uses `latin1_swedish_ci` | Bangla characters corrupt as `????` | Explicitly define PostgreSQL database encoding as `UTF8` with Unicode normalization (`NFC`). |
| **Identity Sequences** | `AUTO_INCREMENT` primary keys | Sequence remains at 1 post-import, crashing next insert with duplicate key error | Execute sequence synchronization query across all 52 tables post-import. |
| **Case-Sensitive Search** | 31 controller search lines use `like '%...%'` on `utf8mb4_unicode_ci` | Case-sensitive `LIKE` returns 0 results for uppercase/lowercase search mismatch | Update controller search queries to use `ILIKE` or `LOWER(col) LIKE LOWER(?)`. |
| **Strict `GROUP BY`** | [`ReportController.php:54-74, 105-125`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/ReportController.php#L54) selects non-aggregated columns | SQL State 42803: `column must appear in GROUP BY clause` | Refactor report queries to group properly by category ID and name. |

---

## 8. Five-Stage Implementation Roadmap

The reconstruction and migration must follow 5 strictly gated stages:

```
[Phase 3 Planning] (Current — Planning Only)
        │
        ▼
[Stage 3A: Migration Suite Repair & Reverse-Engineering]
        │ • Author 5 missing migrations
        │ • Repair 23 missing columns
        │ • Eliminate 3 class collisions
        │
        ▼
[Stage 3B: Disposable Staging Verification]
        │ • Run php artisan migrate:fresh on isolated test database
        │ • Verify all 52 tables create cleanly with zero errors
        │
        ▼
[Stage 3C: Data Cleansing & Reconciliation]
        │ • Sanitize 14 zero-dates to NULL
        │ • Normalize currency strings (strip commas)
        │ • Reconcile duplicate trxID IDs 332-337 with accounting
        │
        ▼
[Stage 3D: Target PostgreSQL Schema & 5-Wave ETL Ingestion]
        │ • Ingest data following Level 0 -> Level 4 DAG order
        │ • Reset identity sequences on all 52 tables
        │ • Execute financial reconciliation checksums
        │
        ▼
[Stage 3E: Post-Migration Application Cutover & Verification]
```

---

## 9. Comprehensive Validation & Acceptance Plan

| Test Category | Target Scope | Verification Query / Methodology | Acceptance Criteria |
|---|---|---|---|
| **Table Existence** | All 52 tables | `SELECT table_name FROM information_schema.tables WHERE table_schema = 'public';` | Exactly 52 base tables created. 0 missing. |
| **Column Specifications** | All 52 tables | Compare column names, types, nullability, defaults against Phase 2 schema dump | 100% column parity. All 23 drifted columns present. |
| **Row Count Reconciliation** | All 52 tables | Compare `SELECT COUNT(*)` on MySQL vs. PostgreSQL for every table | 100% exact match across all tables (15,663 total rows). |
| **Primary Key Verbatim Preservation** | Core tables (`students`, `fees_transections`, `expanses`, `incomes`) | `SELECT MIN(id), MAX(id), COUNT(DISTINCT id) FROM table;` | Highest ID matches source; zero ID gaps or offsets. |
| **Financial Checksum 1: Fees** | `fees_transections` | `SELECT SUM(paidamount) FROM fees_transections;` | Exact match within 0.00 BDT tolerance across 1,604 rows. |
| **Financial Checksum 2: Expenses** | `expanses` | `SELECT SUM(amount) FROM expanses WHERE deleted_at IS NULL;` | Exact match down to the paisa across 6,338 vouchers. |
| **Financial Checksum 3: Incomes** | `incomes` | `SELECT SUM(amount) FROM incomes WHERE deleted_at IS NULL;` | Exact match down to the paisa across 5,694 receipts. |
| **Financial Checksum 4: Loans & EMI** | `bank_loans`, `emi_installments` | `SELECT SUM(loan_amount) FROM bank_loans;`<br/>`SELECT SUM(emi_amount) FROM emi_installments;` | Exact match across all loan ledgers. |
| **Bangla Unicode Integrity** | `students.sname`, `students.address`, `courses.description` | Inspect sample strings containing Bengali glyphs (`বাংলা`, `ইনোভা কম্পিউটার্স বিডি`) | Zero corrupted characters (`????`); UTF-8 NFC valid. |
| **Password Hash Compatibility** | `admins` (7 rows), `users` (149 rows) | Test Bcrypt authentication against existing hashes | 100% logins succeed. 0 password resets required. |
| **Media Path Preservation** | `students.image`, `teachers.image`, `expanses.image` | Verify disk file existence for stored relative paths in `storage/app/public/` | 100% of image links resolve to valid files. |
| **Sequence Sync Verification** | All tables post-import | Insert test dummy record, verify ID auto-increments to `MAX(id) + 1`, then rollback | Insert succeeds without duplicate key violation. |

---

## 10. Owner Decisions & Blockers Summary

The following 5 decisions must be confirmed by the project owner before Phase 3 implementation can begin:
1. **Decision Gate 1 (Unmigrated Tables):** Approve reverse-engineering formal migrations for `bank_loans`, `emi_installments`, `investment_withdraws`, `dividend_withdraws`, and `certificates_icbd`.
2. **Decision Gate 2 (Academic Sessions Rename):** Approve renaming the academic session table to `academic_sessions` (`protected $table = 'academic_sessions';`) to allow Laravel HTTP database sessions to use standard `sessions`.
3. **Decision Gate 3 (`fees_transections.trxID` Deduplication):** Confirm accounting resolution for duplicate IDs 332–337 (`AAN****SE0`), and approve the PostgreSQL partial unique index.
4. **Decision Gate 4 (Financial Normalization):** Approve converting legacy `VARCHAR` monetary columns to `NUMERIC(15,2)`.
5. **Decision Gate 5 (Zero-Date Sanitization):** Approve converting 14 confirmed `'0000-00-00'` dates to `NULL`.

---

## 11. Acceptance Criteria for Starting Phase 3 Implementation

Before writing any new migration file or executing code changes:
- [x] Phase 2 read-only audit completed and confirmed against `icbd_web`.
- [x] Phase 3 reconstruction plan authored and submitted.
- [ ] Explicit owner review and approval received on Decision Gates 1 through 5.
- [ ] Dedicated isolated disposable database provisioned for Stage 3B testing.
- [ ] Cold backup dump of `icbd_web` verified and stored in a secure location.
