# Canonical Database Schema Specification

**Project:** INNOVA Computers BD (`innova-web`)  
**Specification Version:** 1.0 (Audited Baseline)  
**Date:** October 2026  
**Status:** Authoritative Reference for MySQL Production & PostgreSQL Target Architecture  
**Source Database:** MySQL 8.0.31 (`icbd_web`) — 52 Tables  

---

## 1. Specification Architecture & Domain Partitioning

This document serves as the single source of truth for the INNOVA Computers BD database schema. It documents the exact physical schema present in the live MySQL database, indicates manually added columns, and defines the canonical target schema for clean installations and PostgreSQL migration.

### Domain Groupings:
1. **Core Identity & Authentication (8 Tables):** `admins`, `users`, `password_resets`, `personal_access_tokens`, `roles`, `permissions`, `model_has_roles`, `model_has_permissions`, `role_has_permissions`.
2. **Academic & Course Management (8 Tables):** `course_categories`, `courses`, `teachers`, `batchs`, `sessions` (academic), `students`, `admissions`, `registrations`.
3. **Institutional Accounting & Fees (6 Tables):** `branches`, `fees_transections`, `incomes`, `income_categoris`, `expanses`, `expanse_categoris`.
4. **Shareholders, Capital & Credit (6 Tables):** `shareholders`, `invesments`, `investment_withdraws`, `dividend_withdraws`, `bank_loans`, `emi_installments`.
5. **Certifications & Institutional Records (2 Tables):** `certificates` (BTEB), `certificates_icbd` (Internal).
6. **ASSET Government Project (5 Tables):** `asset_courses`, `asset_registrations`, `asset_registration_feedbacks`, `assets` (migration draft), `asset_students` (migration draft).
7. **CMS, Marketing & Portfolios (17 Tables):** `settings`, `blogs`, `blog_categoris`, `seminors`, `seminor_registrations`, `reviews`, `galleries`, `sliders`, `success_stories`, `contacts`, `cms_abouts`, `services`, `products`, `concerns`, `workflows`, `clients`, `teams`, `technologies`.

---

## 2. Core Identity & Authentication Domain

### 2.1 `admins`
- **Engine:** InnoDB | **Collation:** `utf8mb4_unicode_ci` | **Rows:** 7
- **Columns:**
  - `id`: `BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY`
  - `name`: `VARCHAR(191) NOT NULL`
  - `email`: `VARCHAR(150) NOT NULL UNIQUE`
  - `email_verified_at`: `TIMESTAMP NULL`
  - `password`: `VARCHAR(191) NOT NULL`
  - `remember_token`: `VARCHAR(100) NULL`
  - `created_at`, `updated_at`: `TIMESTAMP NULL`
- **Model:** `App\Models\Admin`

### 2.2 `users`
- **Engine:** InnoDB | **Collation:** `utf8mb4_unicode_ci` | **Rows:** 149
- **Columns:**
  - `id`: `BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY`
  - `name`: `VARCHAR(255) NULL` *(Manually added field; reconciled in 2026)*
  - `email`: `VARCHAR(150) NOT NULL UNIQUE`
  - `email_verified_at`: `TIMESTAMP NULL`
  - `password`: `VARCHAR(191) NOT NULL`
  - `remember_token`: `VARCHAR(100) NULL`
  - `created_at`, `updated_at`: `TIMESTAMP NULL`
- **Model:** `App\Models\User`

### 2.3 `personal_access_tokens`
- **Engine:** Target InnoDB | **Collation:** `utf8mb4_unicode_ci` | **Rows:** 0 (Unrecorded in MySQL)
- **Columns:**
  - `id`: `BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY`
  - `tokenable_type`: `VARCHAR(191) NOT NULL`
  - `tokenable_id`: `BIGINT UNSIGNED NOT NULL`
  - `name`: `VARCHAR(191) NOT NULL`
  - `token`: `VARCHAR(64) NOT NULL UNIQUE`
  - `abilities`: `TEXT NULL`
  - `last_used_at`: `TIMESTAMP NULL`
  - `created_at`, `updated_at`: `TIMESTAMP NULL`
- **Indexes:** `INDEX (tokenable_type, tokenable_id)`

---

## 3. Academic & Student Lifecycle Domain

### 3.1 `course_categories`
- **Engine:** InnoDB | **Collation:** `utf8mb4_unicode_ci` | **Rows:** 10
- **Columns:**
  - `id`: `BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY`
  - `name`: `VARCHAR(191) NOT NULL`
  - `slug`: `VARCHAR(191) NOT NULL UNIQUE`
  - `icon`: `VARCHAR(191) NULL`
  - `fontawesome`: `VARCHAR(255) NULL` *(Manually added field; reconciled in 2026)*
  - `isFeature`: `INT NOT NULL DEFAULT 0` *(Manually added field; reconciled in 2026)*
  - `tabId`: `VARCHAR(255) NULL` *(Manually added field; reconciled in 2026)*
  - `created_at`, `updated_at`: `TIMESTAMP NULL`
- **Model:** `App\Models\CourseCategory`

### 3.2 `courses`
- **Engine:** InnoDB | **Collation:** `utf8mb4_general_ci` | **Rows:** 26
- **Columns:**
  - `id`: `BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY`
  - `category_id`: `INT UNSIGNED NULL`
  - `name`: `VARCHAR(191) NOT NULL`
  - `slug`: `VARCHAR(191) NOT NULL UNIQUE`
  - `duration`: `VARCHAR(191) NOT NULL`
  - `coursefee`: `DECIMAL(10,2) NOT NULL` *(Upgraded from VARCHAR string)*
  - `shortTitle`: `VARCHAR(255) NULL`
  - `IsCourse`: `TINYINT(1) NOT NULL DEFAULT 0` *(Manually added field; reconciled in 2026)*
  - `courseFor`: `VARCHAR(255) NULL` *(Manually added field; reconciled in 2026)*
  - `Instructor`: `INT NULL` *(Manually added field; reconciled in 2026)*
  - `Rating`: `DECIMAL(2,1) NULL` *(Manually added field; reconciled in 2026)*
  - `TotalReview`: `VARCHAR(255) NULL` *(Manually added field; reconciled in 2026)*
  - `Discount`: `VARCHAR(255) NULL` *(Manually added field; reconciled in 2026)*
  - `views`: `VARCHAR(11) NOT NULL DEFAULT '0'` *(Manually added field; reconciled in 2026)*
  - `status`: `VARCHAR(191) NOT NULL DEFAULT '1'`
  - `created_at`, `updated_at`: `TIMESTAMP NULL`
- **Model:** `App\Models\Courses`

### 3.3 `teachers`
- **Engine:** InnoDB | **Collation:** `utf8mb4_unicode_ci` | **Rows:** 32
- **Columns:**
  - `id`: `BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY`
  - `stuffid`: `VARCHAR(191) NULL`
  - `name`: `VARCHAR(191) NOT NULL`
  - `email`: `VARCHAR(255) NULL` *(Manually added field; reconciled in 2026)*
  - `qualification`: `VARCHAR(191) NULL`
  - `ComCourse`: `VARCHAR(255) NULL` *(Manually added field; reconciled in 2026)*
  - `nStd`: `VARCHAR(255) NULL` *(Manually added field; reconciled in 2026)*
  - `rating`: `VARCHAR(255) NULL` *(Manually added field; reconciled in 2026)*
  - `review`: `VARCHAR(255) NULL` *(Manually added field; reconciled in 2026)*
  - `isTeacher`: `INT NOT NULL DEFAULT 0` *(Manually added field; reconciled in 2026)*
  - `IsFeatured`: `INT NOT NULL DEFAULT 0` *(Manually added field; reconciled in 2026)*
  - `bio`: `TEXT NULL` *(Manually added field; reconciled in 2026)*
  - `phone`: `VARCHAR(191) NULL`
  - `address`: `VARCHAR(191) NULL`
  - `created_at`, `updated_at`: `TIMESTAMP NULL`
- **Model:** `App\Models\Teachers`

### 3.4 `batchs`
- **Engine:** InnoDB | **Collation:** `utf8mb4_unicode_ci` | **Rows:** 65
- **Columns:**
  - `id`: `BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY`
  - `batchnum`: `VARCHAR(191) NOT NULL`
  - `course_id`: `BIGINT UNSIGNED NOT NULL`
  - `stuff_id`: `BIGINT UNSIGNED NOT NULL` (Instructor)
  - `classtime`: `VARCHAR(191) NOT NULL`
  - `classday`: `VARCHAR(191) NOT NULL`
  - `roomnum`: `VARCHAR(191) NOT NULL`
  - `totalseat`: `VARCHAR(191) NOT NULL` (Contains clean numeric strings)
  - `seatstatus`: `VARCHAR(191) NOT NULL`
  - `status`: `VARCHAR(191) NOT NULL DEFAULT '1'`
  - `created_at`, `updated_at`: `TIMESTAMP NULL`
- **Model:** `App\Models\Batchs`

### 3.5 `sessions` (Academic)
- **Engine:** InnoDB | **Collation:** `utf8mb4_unicode_ci` | **Rows:** 10
- **Columns:**
  - `id`: `BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY`
  - `sessionName`: `VARCHAR(191) NOT NULL`
  - `startdate`: `DATE NOT NULL`
  - `enddate`: `DATE NOT NULL`
  - `IsActive`: `VARCHAR(191) NOT NULL DEFAULT '1'`
  - `created_at`, `updated_at`: `TIMESTAMP NULL`
- **Model:** `App\Models\Session`

### 3.6 `students`
- **Engine:** InnoDB | **Collation:** `utf8mb4_unicode_ci` | **Rows:** 1,005
- **Columns:**
  - `id`: `BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY`
  - `user_id`: `BIGINT UNSIGNED NULL`
  - `course_id`: `BIGINT UNSIGNED NOT NULL`
  - `batch_id`: `BIGINT UNSIGNED NOT NULL`
  - `branch_id`: `INT NOT NULL DEFAULT 1`
  - `sname`: `VARCHAR(191) NOT NULL` (Student Name)
  - `phone`: `VARCHAR(191) NOT NULL`
  - `email`: `VARCHAR(191) NULL`
  - `nid`: `VARCHAR(191) NULL`
  - `father`: `VARCHAR(191) NULL`
  - `mother`: `VARCHAR(191) NULL`
  - `address`: `TEXT NULL`
  - `coursefee`: `VARCHAR(191) NOT NULL`
  - `totaldiscount`: `VARCHAR(191) NOT NULL DEFAULT '0'`
  - `status`: `VARCHAR(191) NOT NULL DEFAULT '1'`
  - `created_at`, `updated_at`: `TIMESTAMP NULL`
- **Model:** `App\Models\Students`

---

## 4. Institutional Accounting & Fees Domain

### 4.1 `fees_transections`
- **Engine:** InnoDB | **Collation:** `utf8mb4_unicode_ci` | **Rows:** 1,604
- **Columns:**
  - `id`: `BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY`
  - `user_id`: `BIGINT UNSIGNED NULL`
  - `student_id`: `BIGINT UNSIGNED NOT NULL`
  - `paidamount`: `VARCHAR(191) NOT NULL` (Monetary string; clean numeric values)
  - `paymentType`: `VARCHAR(191) NOT NULL DEFAULT '1'` (1=Tuition/Course Fee)
  - `channel`: `INT NOT NULL DEFAULT 1` *(Manually added field; 1=Counter/Cash, 2=bKash)*
  - `trxID`: `VARCHAR(255) NULL` *(Manually added field; 1,598 NULLs; duplicate trap on IDs 332-337)*
  - `paymentID`: `VARCHAR(255) NULL` *(Manually added field; bKash Checkout ID)*
  - `status`: `INT NOT NULL DEFAULT 0` *(Manually added field; 0=Approved, 1=Pending)*
  - `paiddate`: `DATE NOT NULL`
  - `paidremark`: `TEXT NULL`
  - `deleted_at`: `TIMESTAMP NULL`
  - `created_at`, `updated_at`: `TIMESTAMP NULL`
- **Model:** `App\Models\FeesTransections`

### 4.2 `incomes`
- **Engine:** InnoDB | **Collation:** `utf8mb4_unicode_ci` | **Rows:** 5,694
- **Columns:**
  - `id`: `BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY`
  - `branch_id`: `BIGINT UNSIGNED NOT NULL DEFAULT 1`
  - `categoris_id`: `BIGINT UNSIGNED NOT NULL`
  - `bookNO`: `VARCHAR(191) NULL`
  - `amount`: `VARCHAR(191) NOT NULL` (Legacy monetary string with commas)
  - `invoiceDate`: `DATE NOT NULL` (Contains 8 `'0000-00-00'` rows to sanitize)
  - `note`: `TEXT NULL`
  - `deleted_at`: `TIMESTAMP NULL`
  - `created_at`, `updated_at`: `TIMESTAMP NULL`
- **Model:** `App\Models\Income`

### 4.3 `expanses`
- **Engine:** InnoDB | **Collation:** `utf8mb4_unicode_ci` | **Rows:** 6,338
- **Columns:**
  - `id`: `BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY`
  - `branch_id`: `BIGINT UNSIGNED NOT NULL DEFAULT 1`
  - `categoris_id`: `BIGINT UNSIGNED NOT NULL`
  - `invoiceID`: `VARCHAR(191) NULL`
  - `amount`: `VARCHAR(191) NOT NULL` (Legacy monetary string with commas)
  - `invoiceDate`: `DATE NOT NULL` (Contains 6 `'0000-00-00'` rows to sanitize)
  - `note`: `TEXT NULL`
  - `deleted_at`: `TIMESTAMP NULL`
  - `created_at`, `updated_at`: `TIMESTAMP NULL`
- **Model:** `App\Models\Expanse`

---

## 5. Shareholders, Capital & Credit Domain

### 5.1 `shareholders`
- **Engine:** InnoDB | **Collation:** `utf8mb4_unicode_ci` | **Rows:** 6
- **Columns:**
  - `id`: `BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY`
  - `name`: `VARCHAR(191) NOT NULL`
  - `designation`: `VARCHAR(191) NOT NULL`
  - `address`: `VARCHAR(191) NOT NULL`
  - `shareType`: `VARCHAR(191) NOT NULL`
  - `isActive`: `VARCHAR(191) NOT NULL DEFAULT '1'`
  - `nid`: `VARCHAR(191) NULL`
  - `email`: `VARCHAR(191) NULL`
  - `phone`: `VARCHAR(191) NULL`
  - `deleted_at`: `TIMESTAMP NULL`
  - `created_at`, `updated_at`: `TIMESTAMP NULL`
- **Model:** `App\Models\Shareholder`

### 5.2 `invesments`
- **Engine:** InnoDB | **Collation:** `utf8mb4_unicode_ci` | **Rows:** 46
- **Columns:**
  - `id`: `BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY`
  - `shareholder_id`: `BIGINT UNSIGNED NOT NULL`
  - `amount`: `VARCHAR(191) NOT NULL` (Sanitized numeric strings)
  - `recevedBy`: `VARCHAR(191) NOT NULL`
  - `recevedDate`: `DATE NOT NULL`
  - `isActive`: `VARCHAR(191) NOT NULL DEFAULT '1'`
  - `deleted_at`: `TIMESTAMP NULL`
  - `created_at`, `updated_at`: `TIMESTAMP NULL`
- **Model:** `App\Models\Invesments`

### 5.3 `investment_withdraws`
- **Engine:** MyISAM (Target InnoDB/Postgres) | **Collation:** `utf8mb4_unicode_ci` | **Rows:** 11
- **Columns:**
  - `id`: `BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY`
  - `shareholder_id`: `BIGINT UNSIGNED NULL`
  - `amount`: `DECIMAL(15,2) NOT NULL DEFAULT 0.00`
  - `withdraw_date`: `DATE NULL`
  - `method`: `VARCHAR(191) NULL`
  - `branch_name`: `VARCHAR(191) NULL`
  - `receiver_name`: `VARCHAR(191) NULL`
  - `pay_by`: `VARCHAR(191) NULL`
  - `account_number`: `VARCHAR(191) NULL`
  - `status`: `VARCHAR(191) NOT NULL DEFAULT 'pending'`
  - `requested_by`: `BIGINT UNSIGNED NULL`
  - `requested_at`: `TIMESTAMP NULL`
  - `processed_by`: `BIGINT UNSIGNED NULL`
  - `processed_at`: `TIMESTAMP NULL`
  - `processed_remarks`: `TEXT NULL`
  - `remarks`: `TEXT NULL`
  - `attachment`: `VARCHAR(191) NULL`
  - `created_at`, `updated_at`, `deleted_at`: `TIMESTAMP NULL`
- **Model:** `App\Models\InvestmentWithdraw`

### 5.4 `dividend_withdraws`
- **Engine:** MyISAM (Target InnoDB/Postgres) | **Collation:** `utf8mb4_unicode_ci` | **Rows:** 1
- **Columns:** Same structure as `investment_withdraws` (20 columns).
- **Model:** `App\Models\DividendWithdraw`

### 5.5 `bank_loans`
- **Engine:** MyISAM (Target InnoDB/Postgres) | **Collation:** `utf8mb4_unicode_ci` | **Rows:** 7
- **Columns:**
  - `id`: `BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY`
  - `shareholder_id`: `BIGINT UNSIGNED NULL INDEX`
  - `bank_name`: `VARCHAR(191) NULL`
  - `loan_amount`: `DECIMAL(15,2) NOT NULL DEFAULT 0.00`
  - `interest_rate`: `DECIMAL(5,2) NOT NULL DEFAULT 0.00`
  - `loan_term_months`: `INT NOT NULL DEFAULT 0`
  - `loan_date`: `DATE NULL`
  - `maturity_date`: `DATE NULL`
  - `installment_count`: `INT NOT NULL DEFAULT 0`
  - `savings_amount`: `DECIMAL(15,2) NOT NULL DEFAULT 0.00`
  - `status`: `VARCHAR(191) NOT NULL DEFAULT 'active'`
  - `remarks`: `TEXT NULL`
  - `created_by`: `BIGINT UNSIGNED NULL`
  - `created_at`, `updated_at`, `deleted_at`: `TIMESTAMP NULL`
- **Model:** `App\Models\BankLoan`

### 5.6 `emi_installments`
- **Engine:** MyISAM (Target InnoDB/Postgres) | **Collation:** `utf8mb4_unicode_ci` | **Rows:** 71
- **Columns:**
  - `id`: `BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY`
  - `bank_loan_id`: `BIGINT UNSIGNED NULL INDEX`
  - `shareholder_id`: `BIGINT UNSIGNED NULL INDEX`
  - `emi_amount`: `DECIMAL(15,2) NOT NULL DEFAULT 0.00`
  - `savings_amount`: `DECIMAL(15,2) NOT NULL DEFAULT 0.00`
  - `payment_date`: `DATE NULL`
  - `payment_method`: `VARCHAR(191) NULL`
  - `paid_by`: `BIGINT UNSIGNED NULL`
  - `received_by`: `BIGINT UNSIGNED NULL`
  - `paid_at`: `TIMESTAMP NULL`
  - `status`: `VARCHAR(191) NOT NULL DEFAULT 'pending'`
  - `remarks`: `TEXT NULL`
  - `created_at`, `updated_at`, `deleted_at`: `TIMESTAMP NULL`
- **Model:** `App\Models\EmiInstallment`

---

## 6. Certifications & Verification Domain

### 6.1 `certificates` (BTEB Technical Board)
- **Engine:** InnoDB | **Collation:** `utf8mb4_unicode_ci` | **Rows:** 128
- **Columns:**
  - `id`: `BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY`
  - `session_id`: `BIGINT UNSIGNED NOT NULL`
  - `student_id`: `BIGINT UNSIGNED NOT NULL`
  - `regNo`: `VARCHAR(191) NOT NULL`
  - `Result`: `VARCHAR(191) NOT NULL`
  - `IsActive`: `VARCHAR(191) NOT NULL DEFAULT '1'`
  - `created_at`, `updated_at`: `TIMESTAMP NULL`
- **Model:** `App\Models\Certificates`

### 6.2 `certificates_icbd` (Internal Institute)
- **Engine:** InnoDB | **Collation:** `latin1_swedish_ci` (Target `utf8mb4`) | **Rows:** 38
- **Columns:**
  - `id`: `BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY`
  - `student_id`: `BIGINT UNSIGNED NOT NULL INDEX`
  - `batch_id`: `BIGINT UNSIGNED NOT NULL INDEX`
  - `course_id`: `BIGINT UNSIGNED NOT NULL INDEX`
  - `certificate_no`: `VARCHAR(100) NULL UNIQUE`
  - `theory_hours`: `INT NULL DEFAULT 0`
  - `practical_hours`: `INT NULL DEFAULT 0`
  - `intern_hours`: `INT NULL DEFAULT 0`
  - `result`: `VARCHAR(50) NULL`
  - `issue_date`: `DATE NULL`
  - `certificate_receiver`: `VARCHAR(150) NULL`
  - `delivery_date`: `DATE NULL`
  - `is_active`: `TINYINT(1) NULL DEFAULT 1`
  - `created_at`, `updated_at`, `deleted_at`: `TIMESTAMP NULL`
- **Model:** `App\Models\Certificate_icbd`
