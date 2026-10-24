# 02. Complete Database Inventory and Schema Assessment

**Project:** `innova-web` (INNOVA Computers BD / ICBD)  
**Audit Date:** October 13, 2026  
**Auditor:** Antigravity Agentic Audit (Phase 0 Discovery)  
**Strict Constraint:** Read-Only Audit (No code/configuration/data changes made)

---

## 1. Executive Database Overview

### 1.1 Methodology and Data Source Distinction
To strictly adhere to the rule: *"Distinguish migration-defined schema from the actual current database schema. Do not claim that they match unless verified"*:
1. **Migration-Defined Schema:** Derived from **52 migration files** located in [`database/migrations/`](file:///c:/wamp64/www/innova-web/database/migrations).
2. **Historical Production Dump Schema:** Extracted from the unencrypted phpMyAdmin MySQL dump [`innovacomputer_pay.sql`](file:///c:/wamp64/www/innova-web/resources/views/admin/report/innovacomputer_pay.sql) dated **February 21, 2024**.
3. **Live Database Status:** Currently **unavailable locally** due to connection authentication failure (`Access denied for user 'sroot'@'localhost'` caused by `.env` typo).
4. **Key Finding:** The 2024 SQL dump contains **25 tables**. Between July 2024 and May 2026, **24 additional tables** were added via migrations. Consequently, tables created after Feb 2024 have their production row counts marked as **Unverified** until a live database connection is provided.

---

## 2. Master Table Inventory (49 Tables)

| # | Table Name | Purpose / Domain | Eloquent Model | Primary Key | Verified Dump Rows (Feb 2024) | Migrations Defining / Modifying |
|---|---|---|---|---|---|---|
| 1 | `admins` | Administrative users & credentials | [`Admin`](file:///c:/wamp64/www/innova-web/app/Models/Admin.php) | `id` (bigint) | 6 | `2019_08_13_144617_create_admins_table.php` |
| 2 | `admissions` | Online course admission requests | [`Admission`](file:///c:/wamp64/www/innova-web/app/Models/Admission.php) | `id` (bigint) | 20 | `2023_04_09_151558_create_admissions_table.php` |
| 3 | `asset_courses` | ASSET project training courses | [`AssetCourse`](file:///c:/wamp64/www/innova-web/app/Models/AssetCourse.php) | `id` (bigint) | *Unverified* | `2026_05_20_000000`, `2026_05_20_000300`, `2026_05_21_000100` |
| 4 | `asset_registration_feedbacks` | Feedback & call notes for ASSET registrants | [`AssetRegistrationFeedback`](file:///c:/wamp64/www/innova-web/app/Models/AssetRegistrationFeedback.php) | `id` (bigint) | *Unverified* | `2026_05_20_000700_create_asset_registration_feedbacks_table.php` |
| 5 | `asset_registrations` | ASSET project student lead registrations | [`AssetRegistration`](file:///c:/wamp64/www/innova-web/app/Models/AssetRegistration.php) | `id` (bigint) | *Unverified* | `2026_05_20_000100`, `2026_05_20_000500`, `2026_05_20_000600` |
| 6 | `asset_students` | Enrolled ASSET project trainees | [`AssetStudent`](file:///c:/wamp64/www/innova-web/app/Models/AssetStudent.php) | `id` (bigint) | *Unverified* | `2026_05_20_000001`, `2026_05_20_000400` |
| 7 | `assets` | General ASSET project resources/photos | [`Asset`](file:///c:/wamp64/www/innova-web/app/Models/Asset.php) | `id` (bigint) | *Unverified* | `2026_05_19_000000_create_assets_table.php` |
| 8 | `bank_loans` | Bank loan tracking (EMI) | [`BankLoan`](file:///c:/wamp64/www/innova-web/app/Models/BankLoan.php) | `id` (bigint) | *Unverified* | *No migration file!* (Created manually or missing) |
| 9 | `batchs` | Course batches and class schedules | [`Batchs`](file:///c:/wamp64/www/innova-web/app/Models/Batchs.php) | `id` (bigint) | 31 | `2022_08_13_194856_create_batchs_table.php` |
| 10 | `blog_categoris` | Blog categories | [`blogCategoris`](file:///c:/wamp64/www/innova-web/app/Models/blogCategoris.php) | `id` (bigint) | *Unverified* | `2024_12_26_141652_create_blog_categoris_table.php` |
| 11 | `blogs` | Blog articles, news & posts | [`Blog`](file:///c:/wamp64/www/innova-web/app/Models/Blog.php) | `id` (bigint) | *Unverified* | `2024_12_26_142039_create_blogs_table.php` |
| 12 | `branches` | Institute physical branches | [`Branch`](file:///c:/wamp64/www/innova-web/app/Models/Branch.php) | `id` (bigint) | *Unverified* | `2024_07_15_223125_create_branches_table.php` |
| 13 | `certificate_icbds` | Internal ICBD student certificates | [`Certificate_icbd`](file:///c:/wamp64/www/innova-web/app/Models/Certificate_icbd.php) | `id` (bigint) | *Unverified* | *No migration file!* (Created manually) |
| 14 | `certificates` | BTEB & course completion certificates | [`Certificates`](file:///c:/wamp64/www/innova-web/app/Models/Certificates.php) | `id` (bigint) | *Unverified* | `2024_07_06_190257_create_certificates_table.php` |
| 15 | `clients` | Institutional clients / partners | [`Client`](file:///c:/wamp64/www/innova-web/app/Models/Client.php) | `id` (bigint) | *Unverified* | `2026_04_20_222721_create_clients_table.php` |
| 16 | `cms_abouts` | CMS About page content blocks | [`cmsAbout`](file:///c:/wamp64/www/innova-web/app/Models/cmsAbout.php) | `id` (bigint) | *Unverified* | `2024_12_26_142340_create_cms_abouts_table.php` |
| 17 | `concerns` | Sister concerns / business units | [`Concern`](file:///c:/wamp64/www/innova-web/app/Models/Concern.php) | `id` (bigint) | *Unverified* | `2026_04_20_193559_create_concerns_table.php` |
| 18 | `contacts` | Public contact message submissions | [`Contact`](file:///c:/wamp64/www/innova-web/app/Models/Contact.php) | `id` (bigint) | 223 | `2023_04_10_151938_create_contacts_table.php` |
| 19 | `course_categories` | Categorization for training courses | [`CourseCategory`](file:///c:/wamp64/www/innova-web/app/Models/CourseCategory.php) | `id` (bigint) | *Unverified* | `2024_12_17_142915_create_course_categories_table.php` |
| 20 | `courses` | Training courses & fee details | [`Courses`](file:///c:/wamp64/www/innova-web/app/Models/Courses.php) | `id` (bigint) | 4 | `2022_08_12_080223_create_courses_table.php` |
| 21 | `dividend_withdraws` | Shareholder dividend withdrawals | [`DividendWithdraw`](file:///c:/wamp64/www/innova-web/app/Models/DividendWithdraw.php) | `id` (bigint) | *Unverified* | *No migration file!* |
| 22 | `emi_installments` | Loan installment payments | [`EmiInstallment`](file:///c:/wamp64/www/innova-web/app/Models/EmiInstallment.php) | `id` (bigint) | *Unverified* | *No migration file!* |
| 23 | `expanse_categoris` | Expense classification categories | [`ExpanseCategoris`](file:///c:/wamp64/www/innova-web/app/Models/ExpanseCategoris.php) | `id` (bigint) | 25 | `2022_11_23_191455_create_expanse_categoris_table.php` |
| 24 | `expanses` | Expenditure vouchers & entries | [`Expanse`](file:///c:/wamp64/www/innova-web/app/Models/Expanse.php) | `id` (bigint) | 387 | `2022_11_23_191754_create_expanses_table.php` |
| 25 | `fees_transections` | Student payment receipts & bKash logs | [`FeesTransections`](file:///c:/wamp64/www/innova-web/app/Models/FeesTransections.php) | `id` (bigint) | 706 | `2022_08_17_205522_create_fees_transections_table.php` |
| 26 | `galleries` | Image & photo gallery items | [`Gallery`](file:///c:/wamp64/www/innova-web/app/Models/Gallery.php) | `id` (bigint) | *Unverified* | `2025_01_02_233300_create_galleries_table.php` |
| 27 | `income_categoris` | Income sources & categories | [`IncomeCategoris`](file:///c:/wamp64/www/innova-web/app/Models/IncomeCategoris.php) | `id` (bigint) | *Unverified* | `2024_07_22_222816_create_income_categoris_table.php` |
| 28 | `incomes` | Revenue receipts & income records | [`Income`](file:///c:/wamp64/www/innova-web/app/Models/Income.php) | `id` (bigint) | *Unverified* | `2024_07_22_223012_create_incomes_table.php` |
| 29 | `invesments` | Capital investments by shareholders | [`Invesments`](file:///c:/wamp64/www/innova-web/app/Models/Invesments.php) | `id` (bigint) | 37 | `2023_04_27_130952_create_invesments_table.php` |
| 30 | `investment_withdraws` | Capital investment withdrawals | [`InvestmentWithdraw`](file:///c:/wamp64/www/innova-web/app/Models/InvestmentWithdraw.php) | `id` (bigint) | *Unverified* | *No migration file!* |
| 31 | `migrations` | Laravel migration tracking | N/A | `id` (int) | 16 | Core Laravel |
| 32 | `model_has_permissions` | Polymorphic model permissions | Spatie | `(permission_id, model_id, model_type)` | 0 | `2023_01_11_232251_create_permission_tables.php` |
| 33 | `model_has_roles` | Polymorphic model roles | Spatie | `(role_id, model_id, model_type)` | 6 | `2023_01_11_232251_create_permission_tables.php` |
| 34 | `password_resets` | Password reset tokens | N/A | `email` (index) | 0 | `2014_10_12_100000_create_password_resets_table.php` |
| 35 | `permissions` | RBAC individual permissions | Spatie | `id` (bigint) | 55 | `2023_01_11_232251_create_permission_tables.php` |
| 36 | `products` | Software products / showcase | [`Product`](file:///c:/wamp64/www/innova-web/app/Models/Product.php) | `id` (bigint) | *Unverified* | `2026_04_20_193551_create_products_table.php` |
| 37 | `registrations` | BTEB student exam registrations | [`Registration`](file:///c:/wamp64/www/innova-web/app/Models/Registration.php) | `id` (bigint) | 132 | `2022_08_19_163921_create_registrations_table.php` |
| 38 | `reviews` | Student testimonials / reviews | [`Review`](file:///c:/wamp64/www/innova-web/app/Models/Review.php) | `id` (bigint) | *Unverified* | `2024_12_25_212411_create_reviews_table.php` |
| 39 | `role_has_permissions` | Permissions granted to roles | Spatie | `(permission_id, role_id)` | 108 | `2023_01_11_232251_create_permission_tables.php` |
| 40 | `roles` | RBAC user roles | Spatie | `id` (bigint) | 3 | `2023_01_11_232251_create_permission_tables.php` |
| 41 | `seminor_registrations` | Seminar attendee registrations | [`SeminorRegistration`](file:///c:/wamp64/www/innova-web/app/Models/SeminorRegistration.php) | `id` (bigint) | *Unverified* | `2024_12_26_142234_create_seminor_registrations_table.php` |
| 42 | `seminors` | Workshops & seminar events | [`Seminor`](file:///c:/wamp64/www/innova-web/app/Models/Seminor.php) | `id` (bigint) | *Unverified* | `2024_12_26_142123_create_seminor_registrations_table.php` |
| 43 | `services` | IT services offerings | [`Service`](file:///c:/wamp64/www/innova-web/app/Models/Service.php) | `id` (bigint) | *Unverified* | `2026_04_20_193543_create_services_table.php` |
| 44 | `sessions` | Academic calendar sessions *(Conflicted!)* | [`Session`](file:///c:/wamp64/www/innova-web/app/Models/Session.php) | `id` (bigint) | 7 | `2022_08_19_163812`, `2024_07_13_012857`, `2024_07_16_031214` |
| 45 | `settings` | Key-value application settings | [`Setting`](file:///c:/wamp64/www/innova-web/app/Models/Setting.php) | `id` (bigint) | 8 | `2019_08_14_124941_create_settings_table.php`, `2026_04_27_000001` |
| 46 | `shareholders` | Company shareholders / investors | [`Shareholder`](file:///c:/wamp64/www/innova-web/app/Models/Shareholder.php) | `id` (bigint) | 6 | `2023_04_27_130942_create_shareholders_table.php` |
| 47 | `sliders` | Homepage hero banners / sliders | [`Slider`](file:///c:/wamp64/www/innova-web/app/Models/Slider.php) | `id` (bigint) | 2 | `2022_12_01_195014_create_sliders_table.php` |
| 48 | `students` | Enrolled regular institute students | [`Students`](file:///c:/wamp64/www/innova-web/app/Models/Students.php) | `id` (bigint) | 335 | `2022_08_16_072354_create_students_table.php` |
| 49 | `success_stories` | Student success showcase | [`SuccessStory`](file:///c:/wamp64/www/innova-web/app/Models/SuccessStory.php) | `id` (bigint) | 1 | `2022_12_06_015548_create_success_stories_table.php` |
| 50 | `teachers` | Instructors & institute staff | [`Teachers`](file:///c:/wamp64/www/innova-web/app/Models/Teachers.php) | `id` (bigint) | 10 | `2020_11_04_171732_create_teachers_table.php` |
| 51 | `technologies` | Technologies used/taught showcase | [`Technology`](file:///c:/wamp64/www/innova-web/app/Models/Technology.php) | `id` (bigint) | *Unverified* | `2026_04_20_230116_create_technologies_table.php` |
| 52 | `users` | Student portal user accounts | [`User`](file:///c:/wamp64/www/innova-web/app/Models/User.php) | `id` (bigint) | 146 | `2014_10_12_000000_create_users_table.php` |
| 53 | `workflows` | Company development workflow steps | [`Workflow`](file:///c:/wamp64/www/innova-web/app/Models/Workflow.php) | `id` (bigint) | *Unverified* | `2026_04_20_193607_create_workflows_table.php` |

---

## 3. Deep Architectural Schemas of Core Entities

### 3.1 Students Table (`students`)
- **Primary Key:** `id` (`bigint unsigned auto_increment`).
- **Foreign Keys:**
  - `user_id` → `users.id` (nullable).
  - `course_id` → `courses.id`.
  - `batch_id` → `batchs.id`.
  - `branch_id` → `branches.id` (nullable).
- **Core Columns:**
  - Personal: `sname` (varchar 191), `father_name`, `mother_name`, `gender`, `religion`, `blood_group`, `dob`, `phone`, `g_phone`, `rel_g`, `email`, `address`.
  - Academic: `admission_date` (date), `stitle` (reg number), `course_fee` (varchar), `discount` (varchar), `balance` (varchar).
  - Status Flags: `IsActive` (tinyint unsigned default 1: 1=Active, 2=Irregular, 3=Completed, 4=Restricted, 5=Postponed), `IsRegister` (tinyint unsigned default 0).
  - Media: `image` (varchar nullable).
  - Timestamps: `created_at`, `updated_at`, `deleted_at` (SoftDeletes).
- **Controllers Using:** [`StudentsController`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/StudentsController.php), [`StudentManagementController`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/StudentManagementController.php), [`SMSController`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/SMSController.php), [`ReportController`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/ReportController.php).
- **Relationships:**
  - `belongsTo(Batchs::class, 'batch_id')`
  - `belongsTo(Courses::class, 'course_id')`
  - `hasMany(FeesTransections::class, 'student_id')`
  - `hasOne(FeesTransections::class, 'student_id')->latest()`

### 3.2 Fees Transactions Table (`fees_transections`)
- **Primary Key:** `id` (`bigint unsigned auto_increment`).
- **Foreign Keys:**
  - `student_id` → `students.id`.
  - `user_id` → `users.id` (nullable).
- **Financial Columns:**
  - `paymentType` (varchar): 1=Admission, 2=Course Fee, 3=Exam Fee, 4=Certificate Fee.
  - `paidamount` (varchar): **CRITICAL:** Stored as string, occasionally with commas or decimals.
  - `paiddate` (date).
  - `channel` (tinyint): 1=Cash / Counter, 2=bKash Iframe.
  - `trxID` (varchar nullable): bKash Transaction ID.
  - `paymentID` (varchar nullable): bKash Payment Reference.
  - `status` (tinyint default 1): 1=Successful/Verified.
  - `paidremark` (text nullable).
- **Data Risk:** No unique constraint on `(trxID)` in the database schema! Multiple records can be created with identical transaction IDs if not guarded at the controller level.

### 3.3 Expenses Table (`expanses`)
- **Primary Key:** `id` (`bigint unsigned auto_increment`).
- **Foreign Keys:**
  - `categoris_id` → `expanse_categoris.id`.
  - `user_id` → `users.id`.
  - `branch_id` → `branches.id`.
- **Columns:**
  - `invoiceID` (varchar nullable), `invoiceDate` (date), `title` (varchar), `seller` (varchar), `recever` (varchar), `description` (text nullable).
  - `amount` (varchar): **CRITICAL DATA QUALITY FLAW.** Stored as varchar (e.g., `'1,500'`).
  - `createDate` (date), `IsActive` (int default 1), `image` (varchar nullable voucher path).
  - `created_at`, `updated_at`, `deleted_at`.

### 3.4 Incomes Table (`incomes`)
- **Primary Key:** `id` (`bigint unsigned auto_increment`).
- **Foreign Keys:**
  - `categoris_id` → `income_categoris.id`.
  - `user_id` → `users.id`.
  - `branch_id` → `branches.id`.
- **Columns:**
  - `bookNO` (varchar), `invoiceID` (varchar), `invoiceDate` (date), `title` (varchar), `seller`, `recever`, `description`, `amount` (varchar).
  - Same data-quality risk as `expanses`.

---

## 4. Migration Conflicts, Anomalies, and Missing Migrations

### 4.1 Duplicate Class & Conflicting Table Definitions
1. **Triplicate Sessions Table:**
   - [`database/migrations/2022_08_19_163812_create_sessions_table.php`](file:///c:/wamp64/www/innova-web/database/migrations/2022_08_19_163812_create_sessions_table.php): Creates academic session table (`sessionName`, `startdate`, `enddate`, `IsActive`). Class: `CreateSessionsTable`.
   - [`database/migrations/2024_07_13_012857_create_sessions_table.php`](file:///c:/wamp64/www/innova-web/database/migrations/2024_07_13_012857_create_sessions_table.php): Generated by `php artisan session:table` for Laravel database session driver. Class: `CreateSessionsTable`.
   - [`database/migrations/2024_07_16_031214_create_sessions_table.php`](file:///c:/wamp64/www/innova-web/database/migrations/2024_07_16_031214_create_sessions_table.php): Literal duplicate of the above.
   - **Consequence:** Running `php artisan migrate` on a fresh database fails immediately with `Fatal error: Cannot declare class CreateSessionsTable`.
2. **Duplicate Asset Courses:**
   - [`2026_05_20_000000_create_asset_courses_table.php`](file:///c:/wamp64/www/innova-web/database/migrations/2026_05_20_000000_create_asset_courses_table.php) vs [`2026_05_20_000300_create_asset_courses_table.php`](file:///c:/wamp64/www/innova-web/database/migrations/2026_05_20_000300_create_asset_courses_table.php). Both declare `CreateAssetCoursesTable`.
3. **Duplicate Asset Students:**
   - [`2026_05_20_000001_create_asset_students_table.php`](file:///c:/wamp64/www/innova-web/database/migrations/2026_05_20_000001_create_asset_students_table.php) vs [`2026_05_20_000400_create_asset_students_table.php`](file:///c:/wamp64/www/innova-web/database/migrations/2026_05_20_000400_create_asset_students_table.php). Both declare `CreateAssetStudentsTable`.

### 4.2 Missing Migration Files (Tables with Models & Controllers but No Migrations)
The following tables are actively used by Eloquent models and Admin controllers, but **no migration files exist** in `database/migrations/`:
- `bank_loans` (Model: [`BankLoan.php`](file:///c:/wamp64/www/innova-web/app/Models/BankLoan.php), Controller: [`BankLoanController.php`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/BankLoanController.php))
- `emi_installments` (Model: [`EmiInstallment.php`](file:///c:/wamp64/www/innova-web/app/Models/EmiInstallment.php), Controller: [`EmiInstallmentController.php`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/EmiInstallmentController.php))
- `investment_withdraws` (Model: [`InvestmentWithdraw.php`](file:///c:/wamp64/www/innova-web/app/Models/InvestmentWithdraw.php), Controller: [`InvestmentWithdrawController.php`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/InvestmentWithdrawController.php))
- `dividend_withdraws` (Model: [`DividendWithdraw.php`](file:///c:/wamp64/www/innova-web/app/Models/DividendWithdraw.php), Controller: [`DividendWithdrawController.php`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/DividendWithdrawController.php))
- `certificate_icbds` (Model: [`Certificate_icbd.php`](file:///c:/wamp64/www/innova-web/app/Models/Certificate_icbd.php), Controller: [`CertificateICBDController.php`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/CertificateICBDController.php))

> **Crucial Finding:** These tables were evidently created manually in phpMyAdmin on the production database, leaving the migration directory incomplete and preventing standard automated deployment.

---

## 5. Data Quality and Schema Integrity Risks

1. **Unformatted Financial Quantities:**
   - Tables `expanses`, `incomes`, `fees_transections`, `invesments`, `shareholders` store currency amounts as `VARCHAR`.
   - Some rows in the 2024 dump contain commas (`"25,000"`), leading/trailing whitespace, or Bengali numerals.
   - Any mathematical computation currently requires in-memory casting or fragile SQL regex replacements (`REPLACE(..., ',', '')`).
2. **Missing Database-Level Foreign Key Constraints:**
   - In older tables (`students`, `fees_transections`), foreign keys are declared in migration comments or simple unsigned columns without explicit `ON DELETE RESTRICT` or `CASCADE` foreign key constraints in MySQL InnoDB.
   - Risk of orphan payment records if a student is deleted without using SoftDeletes.
3. **Misspelled Table & Model Identifiers:**
   - Database tables use misspelled nouns (`expanses` instead of `expenses`, `invesments` instead of `investments`, `expanse_categoris` instead of `expense_categories`, `fees_transections` instead of `fees_transactions`).
   - Models replicate these misspellings, creating technical debt and increasing maintenance friction.
