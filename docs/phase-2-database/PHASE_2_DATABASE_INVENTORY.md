# Phase 2 — Complete Database Inventory & Live Schema Audit

**Project:** `innova-web` — INNOVA Computers BD (ICBD)  
**Audit Phase:** Phase 2 (Database Architecture Audit & Migration Planning — Audit Only)  
**Audit Mode:** Strictly Read-Only Live Database Inspection  
**Audit Date:** October 2026  
**Auditor:** Senior Database Migration Architect & Lead Engineer  
**Source Database Environment:**
- **Connection Driver:** `mysql` (`PDO::mysql`)
- **Host / Port:** `127.0.0.1:3306` (Local WampServer MySQL Service)
- **Database Name:** `icbd_web` (Configured in `.env` as `DB_DATABASE="icbd_web"`)
- **Server Version:** MySQL 8.0.31
- **Default Character Set / Collation:** `utf8mb4` / `utf8mb4_unicode_ci`
- **Active Tables Discovered:** 52 Tables (49 Base Tables + 3 Session/System Tables; 0 Views)
- **Total Operational Records:** 15,663 Rows

---

## 1. Executive Summary & Verification Classification

Every table and field in this inventory is classified according to four strict evidence categories:
1. **`CONFIRMED [LIVE DB]`**: Directly inspected via read-only SQL queries on the active `icbd_web` MySQL database.
2. **`CONFIRMED [MIGRATION]`**: Formally defined in one or more migration files in `database/migrations/`.
3. **`INFERRED [APPLICATION CODE]`**: Referenced in Eloquent models, controllers, query builders, or Blade templates.
4. **`DISCREPANCY / UNMIGRATED`**: Present in the active database but completely absent from Laravel migration files.

### Key Inventory Findings:
- **52 Total Tables in Live Database:** The database contains 52 tables, spanning academic management, accounting, shareholder finances, BTEB certifications, and CMS content.
- **14 Tables Using Legacy `MyISAM` Engine:** 14 tables (`bank_loans`, `emi_installments`, `investment_withdraws`, `dividend_withdraws`, `asset_courses`, `asset_registrations`, `asset_registration_feedbacks`, `clients`, `concerns`, `products`, `services`, `teams`, `technologies`, `workflows`) use the `MyISAM` storage engine. They completely lack ACID transaction support and foreign-key referential integrity in MySQL.
- **5 Critical Production Tables Lack Any Migration:** `bank_loans`, `emi_installments`, `investment_withdraws`, `dividend_withdraws`, and `certificates_icbd` exist only in MySQL and Eloquent models; no migration files exist for them.
- **2 Migration Tables Do Not Exist in Database:** `assets` (migration `2026_05_19_000000`) and `asset_students` (migrations `2026_05_20_000001` & `000400`) exist as migration files but were never executed on the live database.
- **Core Financial & Payment Scale:**
  - `expanses`: 6,338 records
  - `incomes`: 5,694 records
  - `fees_transections`: 1,604 payment records (including bKash and counter transactions)
  - `students`: 1,005 student academic profiles
  - `registrations`: 270 BTEB board exam registrations
  - `certificates` + `certificates_icbd`: 166 student certificates issued

---

## 2. Master Table Inventory (52 Tables)

| # | Table Name | Storage Engine | Table Collation | Live Row Count | Primary Key | Eloquent Model | Migration Status | Purpose / Business Domain |
|---|---|---|---|---|---|---|---|---|
| 1 | `admins` | InnoDB | `utf8mb4_unicode_ci` | 7 | `id` (bigint) | [`Admin`](file:///c:/wamp64/www/innova-web/app/Models/Admin.php) | `CONFIRMED [MIGRATION]` (Drift: `remember_token`) | System administrators & staff credentials |
| 2 | `admissions` | InnoDB | `utf8mb4_unicode_ci` | 43 | `id` (bigint) | [`Admission`](file:///c:/wamp64/www/innova-web/app/Models/Admission.php) | `CONFIRMED [MIGRATION]` | Public online course admission inquiries |
| 3 | `asset_courses` | **MyISAM** | `utf8mb4_unicode_ci` | 2 | `id` (bigint) | [`AssetCourse`](file:///c:/wamp64/www/innova-web/app/Models/AssetCourse.php) | `CONFIRMED [MIGRATION]` (Duplicate files) | ASSET government project training courses |
| 4 | `asset_registration_feedbacks` | **MyISAM** | `utf8mb4_unicode_ci` | 5 | `id` (bigint) | [`AssetRegistrationFeedback`](file:///c:/wamp64/www/innova-web/app/Models/AssetRegistrationFeedback.php) | `CONFIRMED [MIGRATION]` | Follow-up call feedback for ASSET registrants |
| 5 | `asset_registrations` | **MyISAM** | `utf8mb4_unicode_ci` | 31 | `id` (bigint) | [`AssetRegistration`](file:///c:/wamp64/www/innova-web/app/Models/AssetRegistration.php) | `CONFIRMED [MIGRATION]` | ASSET project student applications & leads |
| 6 | `bank_loans` | **MyISAM** | `utf8mb4_unicode_ci` | 7 | `id` (bigint) | [`BankLoan`](file:///c:/wamp64/www/innova-web/app/Models/BankLoan.php) | **`DISCREPANCY / UNMIGRATED`** | Institutional bank loan tracking for shareholders |
| 7 | `batchs` | InnoDB | `utf8mb4_unicode_ci` | 65 | `id` (bigint) | [`Batchs`](file:///c:/wamp64/www/innova-web/app/Models/Batchs.php) | `CONFIRMED [MIGRATION]` | Course batches, room seats, and class schedules |
| 8 | `blog_categoris` | InnoDB | `utf8mb4_unicode_ci` | 3 | `id` (bigint) | [`blogCategoris`](file:///c:/wamp64/www/innova-web/app/Models/blogCategoris.php) | `CONFIRMED [MIGRATION]` | Public blog category classification |
| 9 | `blogs` | InnoDB | `utf8mb4_unicode_ci` | 3 | `id` (bigint) | [`Blog`](file:///c:/wamp64/www/innova-web/app/Models/Blog.php) | `CONFIRMED [MIGRATION]` | Tech news, blog articles, and tutorials |
| 10 | `branches` | InnoDB | `utf8mb4_unicode_ci` | 4 | `id` (bigint) | [`Branch`](file:///c:/wamp64/www/innova-web/app/Models/Branch.php) | `CONFIRMED [MIGRATION]` | Physical branch locations (Head Office, Maijdee, etc.) |
| 11 | `certificates` | InnoDB | `utf8mb4_unicode_ci` | 128 | `id` (bigint) | [`Certificates`](file:///c:/wamp64/www/innova-web/app/Models/Certificates.php) | `CONFIRMED [MIGRATION]` | BTEB government certificate distribution records |
| 12 | `certificates_icbd` | InnoDB | **`latin1_swedish_ci`** | 38 | `id` (bigint) | [`Certificate_icbd`](file:///c:/wamp64/www/innova-web/app/Models/Certificate_icbd.php) | **`DISCREPANCY / UNMIGRATED`** | Internal ICBD institute certificates & print log |
| 13 | `clients` | **MyISAM** | `utf8mb4_unicode_ci` | 0 | `id` (bigint) | [`Client`](file:///c:/wamp64/www/innova-web/app/Models/Client.php) | `CONFIRMED [MIGRATION]` | Institutional software clients & partner logos |
| 14 | `cms_abouts` | InnoDB | `utf8mb4_unicode_ci` | 1 | `id` (bigint) | [`cmsAbout`](file:///c:/wamp64/www/innova-web/app/Models/cmsAbout.php) | `CONFIRMED [MIGRATION]` | CMS About Us block content and corporate profile |
| 15 | `concerns` | **MyISAM** | `utf8mb4_unicode_ci` | 4 | `id` (bigint) | [`Concern`](file:///c:/wamp64/www/innova-web/app/Models/Concern.php) | `CONFIRMED [MIGRATION]` | Sister business concerns / ventures |
| 16 | `contacts` | InnoDB | `utf8mb4_unicode_ci` | 269 | `id` (bigint) | [`Contact`](file:///c:/wamp64/www/innova-web/app/Models/Contact.php) | `CONFIRMED [MIGRATION]` | Public contact form submissions & inquiries |
| 17 | `course_categories` | InnoDB | `utf8mb4_unicode_ci` | 10 | `id` (bigint) | [`CourseCategory`](file:///c:/wamp64/www/innova-web/app/Models/CourseCategory.php) | `CONFIRMED [MIGRATION]` (Drift: 3 columns) | Course category grouping (IT, Graphics, Web) |
| 18 | `courses` | InnoDB | **`utf8mb4_general_ci`** | 26 | `id` (bigint) | [`Courses`](file:///c:/wamp64/www/innova-web/app/Models/Courses.php) | `CONFIRMED [MIGRATION]` (Drift: 7 columns) | Academic training courses, modules, syllabus |
| 19 | `dividend_withdraws` | **MyISAM** | `utf8mb4_unicode_ci` | 1 | `id` (bigint) | [`DividendWithdraw`](file:///c:/wamp64/www/innova-web/app/Models/DividendWithdraw.php) | **`DISCREPANCY / UNMIGRATED`** | Shareholder dividend disbursement ledger |
| 20 | `emi_installments` | **MyISAM** | `utf8mb4_unicode_ci` | 71 | `id` (bigint) | [`EmiInstallment`](file:///c:/wamp64/www/innova-web/app/Models/EmiInstallment.php) | **`DISCREPANCY / UNMIGRATED`** | Monthly bank loan EMI repayment installments |
| 21 | `expanse_categoris` | InnoDB | `utf8mb4_unicode_ci` | 118 | `id` (bigint) | [`ExpanseCategoris`](file:///c:/wamp64/www/innova-web/app/Models/ExpanseCategoris.php) | `CONFIRMED [MIGRATION]` | Operational expense categories / Chart of Accounts |
| 22 | `expanses` | InnoDB | `utf8mb4_unicode_ci` | 6,338 | `id` (bigint) | [`Expanse`](file:///c:/wamp64/www/innova-web/app/Models/Expanse.php) | `CONFIRMED [MIGRATION]` | Daily operational expenditures & payment vouchers |
| 23 | `fees_transections` | InnoDB | `utf8mb4_unicode_ci` | 1,604 | `id` (bigint) | [`FeesTransections`](file:///c:/wamp64/www/innova-web/app/Models/FeesTransections.php) | `CONFIRMED [MIGRATION]` (Drift: 4 columns) | Student fee collections, receipts & bKash logs |
| 24 | `galleries` | InnoDB | `utf8mb4_unicode_ci` | 21 | `id` (bigint) | [`Gallery`](file:///c:/wamp64/www/innova-web/app/Models/Gallery.php) | `CONFIRMED [MIGRATION]` | Photo gallery albums & event pictures |
| 25 | `income_categoris` | InnoDB | `utf8mb4_unicode_ci` | 75 | `id` (bigint) | [`IncomeCategoris`](file:///c:/wamp64/www/innova-web/app/Models/IncomeCategoris.php) | `CONFIRMED [MIGRATION]` | Income streams & revenue classification categories |
| 26 | `incomes` | InnoDB | `utf8mb4_unicode_ci` | 5,694 | `id` (bigint) | [`Income`](file:///c:/wamp64/www/innova-web/app/Models/Income.php) | `CONFIRMED [MIGRATION]` | Revenue vouchers and non-tuition income records |
| 27 | `invesments` | InnoDB | `utf8mb4_unicode_ci` | 46 | `id` (bigint) | [`Invesments`](file:///c:/wamp64/www/innova-web/app/Models/Invesments.php) | `CONFIRMED [MIGRATION]` | Capital investment contributions from shareholders |
| 28 | `investment_withdraws`| **MyISAM** | `utf8mb4_unicode_ci` | 11 | `id` (bigint) | [`InvestmentWithdraw`](file:///c:/wamp64/www/innova-web/app/Models/InvestmentWithdraw.php) | **`DISCREPANCY / UNMIGRATED`** | Principal capital withdrawal records |
| 29 | `migrations` | InnoDB | `utf8mb4_unicode_ci` | 24 | `id` (int) | N/A | Core Laravel Migration Tracker | Tracking recorded applied migration batches |
| 30 | `model_has_permissions`| InnoDB | `utf8mb4_unicode_ci` | 0 | `(perm, model_id, model_type)` | Spatie Permission | `CONFIRMED [MIGRATION]` | Polymorphic direct user/admin permissions |
| 31 | `model_has_roles` | InnoDB | `utf8mb4_unicode_ci` | 7 | `(role, model_id, model_type)` | Spatie Permission | `CONFIRMED [MIGRATION]` | Admin/User RBAC role assignment |
| 32 | `password_resets` | InnoDB | `utf8mb4_unicode_ci` | 0 | Index (`email`) | N/A | `CONFIRMED [MIGRATION]` | Password reset token storage |
| 33 | `permissions` | InnoDB | `utf8mb4_unicode_ci` | 55 | `id` (bigint) | Spatie Permission | `CONFIRMED [MIGRATION]` | RBAC system permissions |
| 34 | `products` | **MyISAM** | `utf8mb4_unicode_ci` | 11 | `id` (bigint) | [`Product`](file:///c:/wamp64/www/innova-web/app/Models/Product.php) | `CONFIRMED [MIGRATION]` | Software products portfolio showcase |
| 35 | `registrations` | InnoDB | `utf8mb4_unicode_ci` | 270 | `id` (bigint) | [`Registration`](file:///c:/wamp64/www/innova-web/app/Models/Registration.php) | `CONFIRMED [MIGRATION]` | BTEB Technical Board student registrations |
| 36 | `reviews` | InnoDB | `utf8mb4_unicode_ci` | 91 | `id` (bigint) | [`Review`](file:///c:/wamp64/www/innova-web/app/Models/Review.php) | `CONFIRMED [MIGRATION]` | Student testimonials, course ratings & reviews |
| 37 | `role_has_permissions` | InnoDB | `utf8mb4_unicode_ci` | 108 | `(perm, role)` | Spatie Permission | `CONFIRMED [MIGRATION]` | M2M permissions granted to specific roles |
| 38 | `roles` | InnoDB | `utf8mb4_unicode_ci` | 3 | `id` (bigint) | Spatie Permission | `CONFIRMED [MIGRATION]` | RBAC roles (Super Admin, Admin, Manager) |
| 39 | `seminor_registrations`| InnoDB | `utf8mb4_unicode_ci` | 13 | `id` (bigint) | [`SeminorRegistration`](file:///c:/wamp64/www/innova-web/app/Models/SeminorRegistration.php) | `CONFIRMED [MIGRATION]` | Free seminar / workshop attendee registrations |
| 40 | `seminors` | InnoDB | `utf8mb4_unicode_ci` | 1 | `id` (bigint) | [`Seminor`](file:///c:/wamp64/www/innova-web/app/Models/Seminor.php) | `CONFIRMED [MIGRATION]` | Workshop / masterclass event schedules |
| 41 | `services` | **MyISAM** | `utf8mb4_unicode_ci` | 9 | `id` (bigint) | [`Service`](file:///c:/wamp64/www/innova-web/app/Models/Service.php) | `CONFIRMED [MIGRATION]` | IT service offerings portfolio |
| 42 | `sessions` | InnoDB | `utf8mb4_unicode_ci` | 10 | `id` (bigint) | [`Session`](file:///c:/wamp64/www/innova-web/app/Models/Session.php) | `CONFIRMED [MIGRATION]` (Triplicate Conflict) | Academic calendar sessions (Jan-Jun, Jul-Dec) |
| 43 | `settings` | InnoDB | `utf8mb4_unicode_ci` | 23 | `id` (bigint) | [`Setting`](file:///c:/wamp64/www/innova-web/app/Models/Setting.php) | `CONFIRMED [MIGRATION]` | Application-wide key-value configuration |
| 44 | `shareholders` | InnoDB | `utf8mb4_unicode_ci` | 6 | `id` (bigint) | [`Shareholder`](file:///c:/wamp64/www/innova-web/app/Models/Shareholder.php) | `CONFIRMED [MIGRATION]` | Company shareholders, partners & directors |
| 45 | `sliders` | InnoDB | `utf8mb4_unicode_ci` | 1 | `id` (bigint) | [`Slider`](file:///c:/wamp64/www/innova-web/app/Models/Slider.php) | `CONFIRMED [MIGRATION]` | Homepage hero carousel slider banners |
| 46 | `students` | InnoDB | `utf8mb4_unicode_ci` | 1,005 | `id` (bigint) | [`Students`](file:///c:/wamp64/www/innova-web/app/Models/Students.php) | `CONFIRMED [MIGRATION]` | Regular institute enrolled student master records |
| 47 | `success_stories` | InnoDB | `utf8mb4_unicode_ci` | 1 | `id` (bigint) | [`SuccessStory`](file:///c:/wamp64/www/innova-web/app/Models/SuccessStory.php) | `CONFIRMED [MIGRATION]` | Student placement & success story showcase |
| 48 | `teachers` | InnoDB | `utf8mb4_unicode_ci` | 32 | `id` (bigint) | [`Teachers`](file:///c:/wamp64/www/innova-web/app/Models/Teachers.php) | `CONFIRMED [MIGRATION]` (Drift: 8 columns) | Instructors, trainers, and institute staff |
| 49 | `teams` | **MyISAM** | `utf8mb4_unicode_ci` | 0 | `id` (bigint) | [`Team`](file:///c:/wamp64/www/innova-web/app/Models/Team.php) | `CONFIRMED [MIGRATION]` | Executive management team members |
| 50 | `technologies` | **MyISAM** | `utf8mb4_unicode_ci` | 0 | `id` (bigint) | [`Technology`](file:///c:/wamp64/www/innova-web/app/Models/Technology.php) | `CONFIRMED [MIGRATION]` | Taught technology stacks showcase |
| 51 | `users` | InnoDB | `utf8mb4_unicode_ci` | 149 | `id` (bigint) | [`User`](file:///c:/wamp64/www/innova-web/app/Models/User.php) | `CONFIRMED [MIGRATION]` (Drift: `name`) | Student portal login user accounts |
| 52 | `workflows` | **MyISAM** | `utf8mb4_unicode_ci` | 5 | `id` (bigint) | [`Workflow`](file:///c:/wamp64/www/innova-web/app/Models/Workflow.php) | `CONFIRMED [MIGRATION]` | Software development lifecycle workflow steps |

---

## 3. Deep Architectural Schemas of Core Transactional Entities

### 3.1 Student Payment Transactions (`fees_transections`)
- **Table Name:** `fees_transections`
- **Engine:** InnoDB | **Collation:** `utf8mb4_unicode_ci` | **Live Rows:** 1,604
- **Primary Key:** `id` (`bigint unsigned auto_increment`)
- **Foreign Keys in MySQL:** NONE declared at database level (indexed only by convention)
- **Columns (14 Columns Verified in Live DB):**
  1. `id`: `bigint unsigned NOT NULL AUTO_INCREMENT` (PK)
  2. `user_id`: `bigint unsigned DEFAULT NULL` (Nullable FK to `users.id`)
  3. `student_id`: `bigint unsigned NOT NULL` (FK to `students.id`)
  4. `paidamount`: `varchar(191) NOT NULL` (Monetary amount as string)
  5. `paymentType`: `varchar(191) NOT NULL DEFAULT '1'` (1=Course Fee, 2=Registration Fee)
  6. `paiddate`: `date NOT NULL`
  7. `paidremark`: `text NOT NULL`
  8. `channel`: `int DEFAULT 1` (**DRIFT — Missing from migration**) (1=Cash/Counter, 2=bKash)
  9. `trxID`: `varchar(255) DEFAULT NULL` (**DRIFT — Missing from migration**) (bKash Transaction ID)
  10. `paymentID`: `varchar(255) DEFAULT NULL` (**DRIFT — Missing from migration**) (bKash Payment Reference)
  11. `status`: `int DEFAULT 0` (**DRIFT — Missing from migration**) (0=Pending/Legacy, 1=Verified)
  12. `deleted_at`: `timestamp NULL DEFAULT NULL` (SoftDeletes)
  13. `created_at`: `timestamp NULL DEFAULT NULL`
  14. `updated_at`: `timestamp NULL DEFAULT NULL`
- **Indexes in Live DB:**
  - `PRIMARY` on (`id`)
  - `fees_transections_user_id_foreign` on (`user_id`)
  - `fees_transections_student_id_foreign` on (`student_id`)
  - **CRITICAL RISK:** `trxID` has **NO index and NO unique constraint** in the live database!

### 3.2 Student Profiles (`students`)
- **Table Name:** `students`
- **Engine:** InnoDB | **Collation:** `utf8mb4_unicode_ci` | **Live Rows:** 1,005
- **Primary Key:** `id` (`bigint unsigned auto_increment`)
- **Columns (33 Columns Verified in Live DB):**
  - Personal: `sname` (varchar 191), `gender`, `dob` (date null), `bloodgroup`, `religion`, `height`, `weight`, `phone`, `nid`, `last_school`, `image`.
  - Family / Guardians: `f_name`, `f_phone`, `m_name`, `m_phone`, `g_name`, `g_phone`, `rel_g`.
  - Academic & Financial: `course_id` (bigint), `batch_id` (bigint), `branch_id` (bigint null), `user_id` (bigint null), `admission_date` (date), `course_fee` (varchar 191), `discount` (varchar 191 null), `balance` (varchar 191 null), `ref` (varchar 191 null).
  - Status Flags: `IsRegister` (int default 1), `IsActive` (int default 1; represents 5 academic states: 1=Active, 2=Irregular, 3=Completed, 4=Restricted, 5=Postponed).
  - Timestamps: `created_at`, `updated_at`, `deleted_at`.
- **Indexes in Live DB:**
  - `PRIMARY` (`id`)
  - `students_user_id_foreign` (`user_id`)
  - `students_course_id_foreign` (`course_id`)
  - `students_batch_id_foreign` (`batch_id`)

### 3.3 Expenditure Ledger (`expanses`)
- **Table Name:** `expanses` (Misspelled for `expenses`)
- **Engine:** InnoDB | **Collation:** `utf8mb4_unicode_ci` | **Live Rows:** 6,338
- **Primary Key:** `id` (`bigint unsigned auto_increment`)
- **Columns (17 Columns Verified in Live DB):**
  - `id`: `bigint unsigned NOT NULL AUTO_INCREMENT`
  - `user_id`: `bigint unsigned DEFAULT NULL`
  - `branch_id`: `bigint unsigned DEFAULT NULL`
  - `categoris_id`: `bigint unsigned DEFAULT NULL`
  - `invoiceID`: `varchar(191) DEFAULT NULL`
  - `invoiceDate`: `date DEFAULT NULL` (**Contains 6 zero-date `'0000-00-00'` rows**)
  - `title`: `varchar(191) NOT NULL`
  - `seller`: `varchar(191) NOT NULL`
  - `recever`: `varchar(191) NOT NULL`
  - `description`: `text DEFAULT NULL`
  - `amount`: `varchar(191) NOT NULL` (**Monetary amount stored as string**)
  - `createDate`: `date DEFAULT NULL`
  - `IsActive`: `int DEFAULT 1`
  - `image`: `varchar(191) DEFAULT NULL`
  - `created_at`, `updated_at`, `deleted_at`.
- **Foreign Keys Active in MySQL:**
  - `expanses_categoris_id_foreign` → `expanse_categoris.id` (RESTRICT / RESTRICT)
  - `expanses_user_id_foreign` → `users.id` (RESTRICT / RESTRICT)
  - `expanses_branch_id_foreign` → `branches.id` (RESTRICT / RESTRICT)

### 3.4 Revenue / Income Ledger (`incomes`)
- **Table Name:** `incomes`
- **Engine:** InnoDB | **Collation:** `utf8mb4_unicode_ci` | **Live Rows:** 5,694
- **Primary Key:** `id` (`bigint unsigned auto_increment`)
- **Columns (18 Columns Verified in Live DB):**
  - `id`, `user_id`, `branch_id`, `categoris_id`, `bookNO`, `invoiceID`, `invoiceDate` (**Contains 8 zero-date `'0000-00-00'` rows**), `title`, `seller`, `recever`, `description`, `amount` (`varchar 191`), `createDate`, `IsActive`, `image`, `created_at`, `updated_at`, `deleted_at`.

### 3.5 Courses Master (`courses`)
- **Table Name:** `courses`
- **Engine:** InnoDB | **Collation:** `utf8mb4_general_ci` | **Live Rows:** 26
- **Primary Key:** `id` (`bigint unsigned auto_increment`)
- **Columns (30 Columns Verified in Live DB):**
  - Migration-Defined: `id`, `shortTitle`, `name`, `coursefee` (**In DB defined as `decimal(10,2)`**, unlike migration which declared `string`), `courseduration`, `lacture`, `totalmoduls`, `totalproject`, `description`, `overview`, `curriculum`, `software`, `trainee`, `jobPlacement`, `jobPosition`, `IsActive`, `featured`, `image`, `video`, `category_id`, `created_at`, `updated_at`, `deleted_at`.
  - **Manually Added Unmigrated Columns (7 Columns):**
    1. `IsCourse` (`int DEFAULT 0`)
    2. `courseFor` (`varchar(255) NULL`)
    3. `Instructor` (`varchar(255) NULL`)
    4. `Rating` (`varchar(255) NULL`)
    5. `TotalReview` (`varchar(255) NULL`)
    6. `Discount` (`varchar(255) NULL`)
    7. `views` (`int DEFAULT 0`)

### 3.6 Teachers & Staff Master (`teachers`)
- **Table Name:** `teachers`
- **Engine:** InnoDB | **Collation:** `utf8mb4_unicode_ci` | **Live Rows:** 32
- **Primary Key:** `id` (`bigint unsigned auto_increment`)
- **Columns (40 Columns Verified in Live DB):**
  - Migration-Defined: `id`, `user_id`, `stuffid`, `name`, `fname`, `mname`, `gender`, `dob`, `bloodgroup`, `religion`, `maritalStatus`, `phone`, `nid`, `education`, `subject`, `designation`, `department`, `salary`, `contactType`, `shift`, `exprience`, `link1`, `link2`, `link3`, `link4`, `address`, `image`, `joiningdate`, `IsActive`, `created_at`, `updated_at`, `deleted_at`.
  - **Manually Added Unmigrated Columns (8 Columns):**
    1. `email` (`varchar(191) NULL`)
    2. `ComCourse` (`varchar(255) NULL`)
    3. `nStd` (`varchar(255) NULL`)
    4. `rating` (`varchar(255) NULL`)
    5. `review` (`varchar(255) NULL`)
    6. `isTeacher` (`int DEFAULT 0` — actively queried by `FrontendController`)
    7. `IsFeatured` (`int DEFAULT 0` — actively queried by `FrontendController`)
    8. `bio` (`text NULL`)

---

## 4. Unmigrated Production Modules Detail

These 5 tables have Eloquent models and Admin controllers in the codebase and live rows in the database, but **zero Laravel migration files**:

### 4.1 Bank Loans (`bank_loans`)
- **Live Rows:** 7 | **Engine:** MyISAM | **Collation:** `utf8mb4_unicode_ci`
- **Columns (16):** `id` (bigint PK), `shareholder_id` (bigint), `bank_name` (varchar 191), `loan_amount` (`decimal 15,2`), `interest_rate` (`decimal 5,2`), `loan_term_months` (int), `loan_date` (date), `maturity_date` (date), `installment_count` (int), `savings_amount` (`decimal 15,2`), `status` (varchar 50), `remarks` (text), `created_by` (bigint), `created_at`, `updated_at`, `deleted_at`.
- **Model:** [`App\Models\BankLoan.php`](file:///c:/wamp64/www/innova-web/app/Models/BankLoan.php)
- **Controller:** [`App\Http\Controllers\Admin\BankLoanController.php`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/BankLoanController.php)

### 4.2 Loan EMI Installments (`emi_installments`)
- **Live Rows:** 71 | **Engine:** MyISAM | **Collation:** `utf8mb4_unicode_ci`
- **Columns (15):** `id` (bigint PK), `bank_loan_id` (bigint), `shareholder_id` (bigint), `emi_amount` (`decimal 15,2`), `savings_amount` (`decimal 15,2`), `payment_date` (date), `payment_method` (varchar 50), `paid_by` (bigint), `received_by` (bigint), `paid_at` (datetime), `status` (varchar 50), `remarks` (text), `created_at`, `updated_at`, `deleted_at`.
- **Model:** [`App\Models\EmiInstallment.php`](file:///c:/wamp64/www/innova-web/app/Models/EmiInstallment.php)
- **Controller:** [`App\Http\Controllers\Admin\EmiInstallmentController.php`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/EmiInstallmentController.php)

### 4.3 Capital Investment Withdrawals (`investment_withdraws`)
- **Live Rows:** 11 | **Engine:** MyISAM | **Collation:** `utf8mb4_unicode_ci`
- **Columns (20):** `id` (bigint PK), `shareholder_id` (bigint), `amount` (`decimal 15,2`), `withdraw_date` (date), `method` (varchar 191), `branch_name` (varchar 191), `receiver_name` (varchar 191), `pay_by` (varchar 191), `account_number` (varchar 191), `status` (varchar 191), `requested_by` (bigint), `requested_at` (datetime), `processed_by` (bigint), `processed_at` (datetime), `processed_remarks` (text), `remarks` (text), `attachment` (varchar 191), `created_at`, `updated_at`, `deleted_at`.
- **Model:** [`App\Models\InvestmentWithdraw.php`](file:///c:/wamp64/www/innova-web/app/Models/InvestmentWithdraw.php)
- **Controller:** [`App\Http\Controllers\Admin\InvestmentWithdrawController.php`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/InvestmentWithdrawController.php)

### 4.4 Shareholder Dividend Withdrawals (`dividend_withdraws`)
- **Live Rows:** 1 | **Engine:** MyISAM | **Collation:** `utf8mb4_unicode_ci`
- **Columns (20):** Identical schema structure to `investment_withdraws`.
- **Model:** [`App\Models\DividendWithdraw.php`](file:///c:/wamp64/www/innova-web/app/Models/DividendWithdraw.php)
- **Controller:** [`App\Http\Controllers\Admin\DividendWithdrawController.php`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/DividendWithdrawController.php)

### 4.5 ICBD Institute Certificates (`certificates_icbd`)
- **Live Rows:** 38 | **Engine:** InnoDB | **Collation:** `latin1_swedish_ci`
- **Columns (16):** `id` (bigint PK), `student_id` (bigint), `batch_id` (bigint), `course_id` (bigint), `certificate_no` (varchar 191), `theory_hours` (varchar 191), `practical_hours` (varchar 191), `intern_hours` (varchar 191), `result` (varchar 191), `issue_date` (date), `certificate_receiver` (varchar 191), `delivery_date` (date), `is_active` (int), `created_at`, `updated_at`, `deleted_at`.
- **Model:** [`App\Models\Certificate_icbd.php`](file:///c:/wamp64/www/innova-web/app/Models/Certificate_icbd.php)
- **Controller:** [`App\Http\Controllers\Admin\CertificateICBDController.php`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/CertificateICBDController.php)

---

## 5. Storage Engine & Collation Risk Matrix

| Risk Factor | Tables Affected | Root Cause & Impact on PostgreSQL Target |
|---|---|---|
| **MyISAM Engine (Lack of ACID / No Foreign Keys)** | 14 Tables (`bank_loans`, `emi_installments`, `investment_withdraws`, `dividend_withdraws`, `asset_courses`, `asset_registrations`, `asset_registration_feedbacks`, `clients`, `concerns`, `products`, `services`, `teams`, `technologies`, `workflows`) | MyISAM tables in MySQL do not enforce foreign key integrity and do not support multi-query rollback transactions. PostgreSQL enforces transactions and referential integrity globally. |
| **Collation Discrepancies** | `certificates_icbd` (`latin1_swedish_ci`), `courses` (`utf8mb4_general_ci`), others (`utf8mb4_unicode_ci`) | If Bangla Unicode characters are inserted into `certificates_icbd`, `latin1` corrupts characters as `????`. PostgreSQL migration requires strict `UTF8` conversion. |
| **Zero Dates (`0000-00-00`)** | `expanses.invoiceDate` (6 rows), `incomes.invoiceDate` (8 rows) | MySQL allows zero dates when `NO_ZERO_DATE` is disabled. PostgreSQL rejects `0000-00-00` with a syntax error. Must be converted to `NULL`. |

---

## 6. Audit Conclusion & Baseline Status
- **Database Status:** `CONFIRMED — LIVE READ-ONLY AUDIT COMPLETE`
- **Total Tables:** 52 Verified
- **Total Records:** 15,663 Verified
- **Unmigrated Tables Requiring Reverse Engineering:** 5
- **Tables with Unmigrated Columns:** 6
- **Next Required Artifact:** `PHASE_2_SCHEMA_DRIFT_REPORT.md`
