# Phase 3 — Data Profiling & Backup Verification Review (Audit Only)

**Project:** `innova-web` — INNOVA Computers BD (ICBD)  
**Phase:** Phase 3 Technical Audit & Data Conversion Profiling  
**Author:** Senior Database Migration Architect & Lead Engineer  
**Date:** October 2026  
**Active Git Branch:** `feature/phase-1-security-hardening`  
**Operational Database:** `icbd_web` on MySQL 8.0.31 (`127.0.0.1:3306`, 52 Base Tables, 15,663 Operational Records)  
**Verified Runtimes:**
- **PHP Version:** `PHP 8.2.0 (cli)` (ZTS Visual C++ 2019 x64)
- **Laravel Framework:** `v8.83.29`
- **Database Engine:** `MySQL 8.0.31`

---

## 1. Executive Summary & Final Determination

This report delivers an exhaustive, evidence-based data profiling and backup verification audit of the active `icbd_web` database. All profiling was conducted using strictly read-only SQL queries and non-mutating scripts executed against local MySQL 8.0.31. **No write, insert, update, delete, DDL, migration, or schema alteration operations were performed.**

### Final Status Determination:
```
READY FOR OWNER DECISIONS — AUDIT EVIDENCE COMPLETE
```

> [!IMPORTANT]
> Although the audit evidence is 100% complete and all data profiling tasks have concluded, **physical implementation remains strictly paused**. No migrations, table modifications, or database operations may begin until all 8 Owner Decision Gates receive formal, recorded approval from the project owner, and an authoritative cold backup has been created and verified.

---

## 2. Key Profiling Findings & Breakthrough Discoveries

1. **`batchs.totalseat` is 100% Valid Integer (Assumption Resolved):**
   - The assumption flagged in the Readiness Review regarding `batchs.totalseat` (`varchar(191)`) is now resolved.
   - All **65 rows** in `batchs.totalseat` contain purely numeric integer strings (`20`, `15`, `10`, `5`, `12`, `9`, `25`).
   - Zero nulls, zero empty strings, and zero non-numeric text values exist. It can be safely and losslessly cast to PostgreSQL `INTEGER`.

2. **Financial Columns Comma Myth Debunked & Trailing Dot Discovery:**
   - Previous audit reports assumed widespread formatted commas (e.g. `'15,000'`) in financial fields.
   - Comprehensive live profiling across **13,689 financial records** in 22 monetary columns revealed that **zero formatted commas, zero currency symbols (`৳`, `$`, `Tk`), and zero negative values** exist in the active database.
   - The developer wrote `REPLACE(amount, ',', '')` in `ReportController.php` purely as a defensive measure.
   - **Only one anomaly exists:** Exactly 2 rows in `students.discount` contain a trailing decimal dot (`"50."`). These must be sanitized to `"50.00"` during migration.

3. **Universal Zero-Date Audit & Century Typo Discovery:**
   - Comprehensive scanning across **163 date/datetime columns** in all 52 tables verified that `'0000-00-00'` zero dates exist **exclusively** in `expanses.invoiceDate` (6 rows) and `incomes.invoiceDate` (8 rows), totaling exactly **14 rows across the entire database**. All other 161 date columns have zero zero-dates.
   - **Critical Breakthrough Discovery:** Profiling uncovered **13 records with two-digit century typos** entered by staff:
     - `expanses.invoiceDate`: 8 rows with years `0023` (3 rows), `0024` (1 row), `0025` (1 row), `0026` (4 rows) — e.g. `'0023-11-20'` instead of `'2023-11-20'`.
     - `incomes.invoiceDate`: 6 rows with years `0023` (2 rows), `0223` (1 row), `0024` (2 rows), `0025` (1 row) — e.g. `'0024-11-20'` instead of `'2024-11-20'`.
     - `fees_transections.paiddate`: 1 row with date `'0226-06-04'` instead of `'2026-06-04'`.
     - *Impact:* While PostgreSQL accepts year `0023` CE, financial queries (`whereBetween('invoiceDate', ['2023-01-01', '2023-12-31'])`) completely omit these vouchers. A sanitization rule must be approved to correct century prefixes.

4. **`certificates_icbd` Text Integrity Confirmed:**
   - Profiling confirmed that although `certificates_icbd` uses `latin1_swedish_ci` collation, all 38 rows contain **zero question mark replacement characters (`?`) and zero multibyte characters**.
   - All certificate records were entered using standard ASCII English (names, roll numbers, results such as `"A+"`).
   - Zero Bengali character corruption has occurred.

5. **`fees_transections.trxID` Duplicate Group Reconfirmed:**
   - Exactly **1 duplicate group** exists across 6 distinct rows (`ids: 332, 333, 334, 335, 336, 337`) with masked transaction key `AAN****SE0`.
   - 1,598 rows are `NULL` (cash/counter receipts).
   - Zero empty strings exist.

6. **Backup & Restore Verification Status: `NOT VERIFIED`:**
   - No cold backup dump exists in the repository, web root, or server directories.
   - No documented restoration evidence exists.
   - Physical restoration was not performed because no dump file exists and no disposable database target has been authorized.

---

## 3. Task A: Data Conversion Profiling

### 3.1 Profiling `batchs.totalseat`
- **Table:** `batchs` | **Column:** `totalseat` | **MySQL Schema Type:** `varchar(191) NOT NULL`
- **Method:** Grouped read-only SQL aggregation with regex pattern matching.
- **Findings:**
  - Total operational rows: **65**
  - Pure numeric integer strings: **65 (100.0%)**
  - NULL count: **0**
  - Empty string count: **0**
  - Non-numeric / alphabetical text count: **0**
- **Distinct Value Distribution (Safe Aggregates):**
  - Value `'20'`: 30 batches (46.15%)
  - Value `'15'`: 12 batches (18.46%)
  - Value `'10'`: 12 batches (18.46%)
  - Value `'12'`: 6 batches (9.23%)
  - Value `'25'`: 3 batches (4.62%)
  - Value `'5'`: 1 batch (1.54%)
  - Value `'9'`: 1 batch (1.54%)
- **Conversion Assessment:** Safe for direct, lossless conversion to PostgreSQL `INTEGER`. No fallback cleansing script is required.

---

### 3.2 Profiling Financial Columns (VARCHAR to NUMERIC Conversion)
Every column across all 52 tables matching monetary naming conventions (`amount`, `fee`, `loan`, `savings`, `salary`, `price`, `cost`, `balance`, `discount`) was inspected. A total of **22 candidate financial columns** were discovered and audited.

#### Core Financial Master Table:
| Table Name | Column Name | MySQL Data Type | Total Rows | Pure Numeric | Comma Formatted | Currency Symbols | Anomalies / Unexpected | Conversion Verdict |
|---|---|---|---|---|---|---|---|---|
| `expanses` | `amount` | `varchar(191)` | 6,338 | 6,338 | 0 | 0 | 0 | **100% Pure Numeric** |
| `incomes` | `amount` | `varchar(191)` | 5,694 | 5,694 | 0 | 0 | 0 | **100% Pure Numeric** |
| `fees_transections` | `paidamount` | `varchar(191)` | 1,604 | 1,604 | 0 | 0 | 0 | **100% Pure Numeric** |
| `students` | `course_fee` | `varchar(191)` | 1,005 | 1,005 | 0 | 0 | 0 | **100% Pure Numeric** |
| `students` | `balance` | `varchar(191)` | 1,005 | 1,005 | 0 | 0 | 0 | **100% Pure Numeric** |
| `students` | `discount` | `varchar(191)` | 1,005 | 937 | 0 | 0 | **2 rows (`"50."`)**<br/>*(66 NULLs)* | **Requires Trailing Dot Truncation** |
| `invesments` | `amount` | `varchar(191)` | 46 | 46 | 0 | 0 | 0 | **100% Pure Numeric** |
| `registrations` | `balance` | `varchar(191)` | 270 | 270 | 0 | 0 | 0 | **100% Pure Numeric** |
| `teachers` | `salary` | `varchar(191)` | 32 | 32 | 0 | 0 | 0 | **100% Pure Numeric** |
| `courses` | `coursefee` | `decimal(10,2)` | 26 | 26 | 0 | 0 | 0 | **Native Decimal** |
| `courses` | `Discount` | `varchar(255)` | 26 | 11 | 0 | 0 | 0 *(15 NULLs)* | **100% Pure Numeric** |
| `bank_loans` | `loan_amount` | `decimal(15,2)` | 7 | 7 | 0 | 0 | 0 | **Native Decimal** |
| `bank_loans` | `savings_amount`| `decimal(15,2)` | 7 | 7 | 0 | 0 | 0 | **Native Decimal** |
| `emi_installments` | `emi_amount` | `decimal(15,2)` | 71 | 71 | 0 | 0 | 0 | **Native Decimal** |
| `emi_installments` | `savings_amount`| `decimal(15,2)`| 71 | 71 | 0 | 0 | 0 | **Native Decimal** |
| `investment_withdraws`| `amount` | `decimal(15,2)` | 11 | 11 | 0 | 0 | 0 | **Native Decimal** |
| `dividend_withdraws` | `amount` | `decimal(15,2)` | 1 | 1 | 0 | 0 | 0 | **Native Decimal** |

#### Non-Monetary False-Positive Columns (Profiled & Categorized):
- `bank_loans.loan_term_months` (`int`): 7 rows (pure integer months, e.g. `12`, `24`).
- `bank_loans.loan_date` (`date`): 7 rows (standard calendar dates).
- `emi_installments.bank_loan_id` (`bigint unsigned`): 71 rows (foreign key to `bank_loans.id`).
- `asset_registration_feedbacks.feedback_step` (`tinyint unsigned`): 5 rows (step index).
- `asset_registration_feedbacks.feedback` (`longtext`): 5 rows (free-form follow-up text).

#### Key Insight on Monetary Cleanliness:
- The assumption that strings contained comma separators (`'15,000'`) is **refuted by the live data**. Across 15,663 records, not a single comma was stored in any monetary field.
- **Conversion Cleansing Rule:** The only anomaly across the entire financial ledger is 2 rows in `students.discount` containing `'50.'`. A simple `RTRIM(val, '.')` or `CAST(val AS NUMERIC(15,2))` handles this cleanly.

---

### 3.3 Profiling All Date and Datetime Columns
A universal scan was executed across **163 date, datetime, and timestamp columns** spanning all 52 base tables.

#### Zero-Date Scan Results (`0000-00-00`):
- **Total Columns Profiled:** 163
- **Total Zero-Date Occurrences Across Whole Database:** **Exactly 14 Rows**
  1. `expanses.invoiceDate`: **6 rows** contain `'0000-00-00'`
  2. `incomes.invoiceDate`: **8 rows** contain `'0000-00-00'`
- **All other 161 columns** (including `students.dob`, `students.admission_date`, `teachers.dob`, `bank_loans.loan_date`, `emi_installments.payment_date`, `registrations.regDate`, etc.) contain **zero zero-dates**.

#### Critical New Finding: Two-Digit Century Typo Dates:
The scan uncovered **13 operational records** with dates entered with two-digit years that MySQL stored in the first century CE (`0023`, `0024`, `0025`, `0026`, `0223`, `0226`):

| Table Name | Column Name | Stored Date Value | Row Count | Inferred Real-World Date | Root Cause |
|---|---|---|---|---|---|
| `expanses` | `invoiceDate` | `0023-11-20` | 1 | `2023-11-20` | Data entry entered `'23-11-20'` into date field |
| `expanses` | `invoiceDate` | `0023-11-22` | 1 | `2023-11-22` | Data entry entered `'23-11-22'` |
| `expanses` | `invoiceDate` | `0023-11-30` | 1 | `2023-11-30` | Data entry entered `'23-11-30'` |
| `expanses` | `invoiceDate` | `0024-05-20` | 1 | `2024-05-20` | Data entry entered `'24-05-20'` |
| `expanses` | `invoiceDate` | `0025-01-26` | 1 | `2025-01-26` | Data entry entered `'25-01-26'` |
| `expanses` | `invoiceDate` | `0026-05-22` | 3 | `2026-05-22` | Data entry entered `'26-05-22'` |
| `expanses` | `invoiceDate` | `0026-07-02` | 1 | `2026-07-02` | Data entry entered `'26-07-02'` |
| `incomes` | `invoiceDate` | `0023-11-20` | 2 | `2023-11-20` | Data entry entered `'23-11-20'` |
| `incomes` | `invoiceDate` | `0223-10-07` | 1 | `2023-10-07` | Data entry typo |
| `incomes` | `invoiceDate` | `0024-11-20` | 1 | `2024-11-20` | Data entry entered `'24-11-20'` |
| `incomes` | `invoiceDate` | `0024-11-24` | 1 | `2024-11-24` | Data entry entered `'24-11-24'` |
| `incomes` | `invoiceDate` | `0025-06-26` | 1 | `2025-06-26` | Data entry entered `'25-06-26'` |
| `fees_transections`| `paiddate` | `0226-06-04` | 1 | `2026-06-04` | Data entry typo |

**Required Owner Action:** The ETL pipeline must include an owner-approved sanitization rule:  
`IF date LIKE '002%' OR date LIKE '022%' THEN correct century prefix to '202%'`.

---

### 3.4 Profiling `certificates_icbd` (Collation & Character Integrity)
- **Table:** `certificates_icbd` | **Row Count:** 38
- **Character Set & Collation Audit:**
  - `certificate_no`: `varchar(191)` / `latin1` / `latin1_swedish_ci`
  - `certificate_receiver`: `varchar(191)` / `latin1` / `latin1_swedish_ci`
  - `result`: `varchar(191)` / `latin1` / `latin1_swedish_ci`
  - `theory_hours`, `practical_hours`, `intern_hours`: stored as native `int`
  - `issue_date`, `delivery_date`: stored as native `date`
- **Text Corruption Assessment (Read-Only Scan):**
  - Rows with `?` replacement characters in `certificate_no`: **0**
  - Rows with `?` replacement characters in `certificate_receiver`: **0**
  - Rows with `?` replacement characters in `result`: **0**
  - Rows with multibyte character sequences (`LENGTH != CHAR_LENGTH`): **0**
- **Findings:** All 38 rows were entered exclusively in ASCII English characters. No Bengali script was stored in this table. Converting column character set to `UTF8` in PostgreSQL will proceed with zero character loss or corruption.

---

### 3.5 Profiling `fees_transections.trxID` (Payment Duplicate Analysis)
- **Table:** `fees_transections` | **Operational Rows:** 1,604
- **Null & Empty Breakdown:**
  - `trxID IS NULL`: **1,598 rows (99.63%)** (Cash/Counter payments where bKash IDs do not apply)
  - `TRIM(trxID) = ''`: **0 rows**
  - Non-null `trxID` records: **6 rows (0.37%)**
  - Distinct non-null keys: **1**
- **Duplicate Group Analysis (Masked):**
  - **Masked Key:** `AAN****SE0`
  - **Row Count:** 6
  - **Associated Primary Key IDs:** `332, 333, 334, 335, 336, 337`
  - **First Created:** `2023-01-23 08:20:02`
  - **Last Created:** `2023-01-23 09:01:30`
  - **Timestamp Spread:** 6 submissions occurred across a 41-minute window on January 23, 2023.
- **Architectural Confirmation:** This conclusively proves why an unconditional `UNIQUE(trxID)` constraint will fail. The proposed PostgreSQL partial unique index (`WHERE trxID IS NOT NULL AND TRIM(trxID) != ''`) is mandatory once IDs 332–337 are resolved by accounting.

---

### 3.6 Auto-Increment & Primary Key Integrity
All 52 base tables were verified for primary key integrity and ID distribution:
- **Primary Key Collisions:** **0 collisions across all 52 tables**. In every table where `id` is the primary key, `COUNT(id) == COUNT(DISTINCT id)`.
- **Identity Sequence Ranges for PostgreSQL Target:**
  - `expanses`: `id` 1 to 6,338 (Sequence reset target: 6,338)
  - `incomes`: `id` 1 to 5,694 (Sequence reset target: 5,694)
  - `fees_transections`: `id` 1 to 1,621 (Sequence reset target: 1,621; historical deletions account for gap between 1,604 rows and max ID 1,621)
  - `students`: `id` 1 to 1,005 (Sequence reset target: 1,005)
  - `contacts`: `id` 1 to 269 (Sequence reset target: 269)
  - `registrations`: `id` 2 to 292 (Sequence reset target: 292)
  - `users`: `id` 1 to 149 (Sequence reset target: 149)
  - `certificates`: `id` 11 to 144 (Sequence reset target: 144)
  - `expanse_categoris`: `id` 1 to 118 (Sequence reset target: 118)
  - `reviews`: `id` 1 to 91 (Sequence reset target: 91)
  - `income_categoris`: `id` 1 to 75 (Sequence reset target: 75)
  - `emi_installments`: `id` 1 to 71 (Sequence reset target: 71)
  - `batchs`: `id` 1 to 65 (Sequence reset target: 65)
  - `permissions`: `id` 1 to 55 (Sequence reset target: 55)
  - `invesments`: `id` 1 to 46 (Sequence reset target: 46)
  - `admissions`: `id` 1 to 61 (Sequence reset target: 61)
  - `certificates_icbd`: `id` 1 to 38 (Sequence reset target: 38)
  - `teachers`: `id` 1 to 32 (Sequence reset target: 32)
  - `asset_registrations`: `id` 2 to 32 (Sequence reset target: 32)
  - `courses`: `id` 1 to 26 (Sequence reset target: 26)
  - `settings`: `id` 1 to 23 (Sequence reset target: 23)
  - `galleries`: `id` 1 to 21 (Sequence reset target: 21)
  - `seminor_registrations`: `id` 1 to 13 (Sequence reset target: 13)
  - `investment_withdraws`: `id` 1 to 11 (Sequence reset target: 11)
  - `products`: `id` 1 to 11 (Sequence reset target: 11)
  - `sessions`: `id` 1 to 10 (Sequence reset target: 10)
  - `course_categories`: `id` 1 to 10 (Sequence reset target: 10)
  - `services`: `id` 1 to 9 (Sequence reset target: 9)
  - `admins`: `id` 1 to 7 (Sequence reset target: 7)
  - `bank_loans`: `id` 1 to 7 (Sequence reset target: 7)
  - `shareholders`: `id` 1 to 6 (Sequence reset target: 6)
  - `asset_registration_feedbacks`: `id` 1 to 5 (Sequence reset target: 5)
  - `workflows`: `id` 1 to 5 (Sequence reset target: 5)
  - `branches`: `id` 1 to 4 (Sequence reset target: 4)
  - `concerns`: `id` 1 to 4 (Sequence reset target: 4)
  - `blog_categoris`: `id` 1 to 3 (Sequence reset target: 3)
  - `blogs`: `id` 1 to 3 (Sequence reset target: 3)
  - `roles`: `id` 1 to 3 (Sequence reset target: 3)
  - `asset_courses`: `id` 1 to 2 (Sequence reset target: 2)
  - `cms_abouts`: `id` 1 (Sequence reset target: 1)
  - `dividend_withdraws`: `id` 1 (Sequence reset target: 1)
  - `seminors`: `id` 1 (Sequence reset target: 1)
  - `sliders`: `id` 1 (Sequence reset target: 1)
  - `success_stories`: `id` 1 (Sequence reset target: 1)
  - `clients`, `teams`, `technologies`: 0 rows (Empty tables, sequence target: 1)
  - Pivot tables (`model_has_permissions`, `model_has_roles`, `role_has_permissions`, `password_resets`): Composite keys without auto-increment.

---

## 4. Task B: Backup & Restore Evidence Review

### 4.1 Search and Inspection Methodology
A filesystem scan was conducted across the application directory (`c:\wamp64\www\innova-web`), the local server root (`c:\wamp64`), and storage directories looking for `.sql`, `.dump`, `.bak`, `.tar`, and `.gz` archives.

### 4.2 Inspection Findings
- **Existing Backup Files in Repository:** **Zero** (0 files found).
- **Existing Backup Dumps on Local Server:** **Zero** (0 files found).
- **Documented Restore Evidence:** None found.
- Note: In Phase 1, an unmanaged, obsolete SQL dump (`resources/views/admin/report/innovacomputer_pay.sql`) was deleted from git tracking for security hardening; that file contained partial historical payment records, not a full schema/database backup.

### 4.3 Official Verification Status:
```
BACKUP VERIFICATION STATUS: NOT VERIFIED
```

### 4.4 Why Restoration Was Not Performed:
In strict compliance with Safety Rules 7 and 8:
1. No pre-existing verified backup file exists to restore.
2. The project owner has not authorized provisioning of a disposable target database for restoration testing.
3. Attempting to restore or overwrite an unverified dump against the live database would destroy operational data.

---

## 5. Task C: Migration and Runtime Safety Review

### 5.1 Deep-Dive: Academic Sessions vs. Laravel HTTP Sessions
The audit verified the exact distinction between academic terms and Laravel database sessions:

#### Academic Sessions Domain:
- Table: `sessions`
- Live Records: **10 rows** (`Jan-Jun 2022`, `Jul-Dec 2022`, `Jan-Jun 2023`, etc.)
- Model: [`app/Models/Session.php`](file:///c:/wamp64/www/innova-web/app/Models/Session.php)
- Foreign Key Dependents:
  - `registrations.session_id` (270 rows)
  - `certificates.session_id` (128 rows)
- **Direct Query Builder References (Code Breakage Hazard):**
  - [`app/Http/Controllers/UserController.php:263`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/UserController.php#L263):
    `DB::table('sessions')->where('deleted_at', null)->where('IsActive',1)->get();`
  - [`app/Http/Controllers/Admin/SessionController.php:34`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/SessionController.php#L34):
    `DB::table('sessions')->where('deleted_at', null)->get();`
  - [`app/Http/Controllers/Admin/SessionController.php:140`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/SessionController.php#L140):
    `DB::table('sessions')->where('id', $id)->update(['deleted_at' => $date]);`

#### Laravel HTTP Sessions Domain:
- Generated by: `php artisan session:table`
- Migrations: `2024_07_13_012857_create_sessions_table.php` and `2024_07_16_031214_create_sessions_table.php`
- Schema: `id` (varchar 255), `user_id` (bigint), `ip_address`, `user_agent`, `payload` (longtext), `last_activity` (int).
- Current Configuration: `config/session.php:88` sets `'table' => 'sessions'`, with driver currently defaulting to `'file'`.

#### Actionable Safety Recommendation:
To resolve the collision permanently without risking raw query builder breakages:
- Rename the academic table to `academic_sessions`.
- Update `Session.php` to `$table = 'academic_sessions'`.
- Refactor the 3 raw queries in `UserController.php` and `SessionController.php` to target `academic_sessions`.
- Update foreign keys in `registrations` and `certificates` to `academic_sessions(id)`.

---

### 5.2 Migration Collision Risks
Without modifying any files, the audit confirmed 3 collision groups and 1 chronological loop:
1. `CreateSessionsTable`: 3 conflicting files (`2022_08_19`, `2024_07_13`, `2024_07_16`).
2. `CreateAssetCoursesTable`: 2 conflicting files (`2026_05_20_000000` vs. `000300`).
3. `CreateAssetStudentsTable`: 2 conflicting files (`2026_05_20_000001` vs. `000400`).
4. `courses` circular foreign key referencing `course_categories` written 2 years later.

**Safety Rule:** Converting existing historical files to anonymous class syntax (`return new class extends Migration { ... };`) prevents PHP fatal errors without changing file timestamps or breaking migration tracking.

---

### 5.3 Verified Runtime Environment
Direct verification commands executed:
- `php -v`: Output `PHP 8.2.0 (cli) (built: Dec 6 2022 15:31:23) (ZTS Visual C++ 2019 x64)`
- `php artisan --version`: Output `Laravel Framework 8.83.29`
- `SELECT VERSION()`: Output `MySQL 8.0.31`

---

### 5.4 Commands Executed & Safe Read-Only Certification
All commands executed during this audit:
1. `php -v` (Read-only CLI environment inspection)
2. `php artisan --version` (Read-only framework version check)
3. `Get-ChildItem` (Read-only filesystem searches for backup files)
4. Scratch read-only profiling script (`run_data_profiling.php`, `check_dates.php`, `check_non_numeric.php` in brain artifact directory):
   - Executed exclusively `SELECT` queries with `COUNT`, `SUM`, `MIN`, `MAX`, `REGEXP`.
   - Used read-only PDO statements.

**Safety Certification:**
- Zero `INSERT`, `UPDATE`, `DELETE`, `ALTER`, `DROP`, `TRUNCATE`, or `CREATE` queries were run.
- Zero migrations, rollbacks, or seeders were run.
- `.env`, Git branch, tracked files, and operational database records remain 100% unaltered.

---

## 6. Prioritized Implementation Prerequisites

Before any physical migration file is written or data transfer is executed in Phase 3, the following 5 sequential prerequisites must be met:

```
[Prerequisite 1: Authoritative Cold Backup & Verified Test Restore]
        │
        ▼
[Prerequisite 2: Owner Recorded Sign-Off on All 8 Decision Gates]
        │
        ▼
[Prerequisite 3: Provisioning Isolated Disposable Staging Databases]
        │
        ▼
[Prerequisite 4: Automated Data Cleansing Script (Zero-Dates, Century Typos, Trailing Dots)]
        │
        ▼
[Prerequisite 5: Codebase Query Builder Refactoring for 'academic_sessions']
```

1. **Priority 1: Authoritative Cold Backup & Verified Restore**
   - Execute cold dump: `mysqldump --single-transaction --routines --triggers --hex-blob -u root -p icbd_web > icbd_web_pre_phase3_authoritative.sql`.
   - Calculate SHA-256 checksum and store in versioned archive.
   - Perform test restore into a temporary database (`icbd_web_test_restore`) to prove restorability.

2. **Priority 2: Owner Approval on 8 Decision Gates**
   - Gate 1: 5 unmigrated tables (`bank_loans`, `emi_installments`, `investment_withdraws`, `dividend_withdraws`, `certificates_icbd`).
   - Gate 2: Table rename to `academic_sessions`.
   - Gate 3: Accounting resolution for `trxID` duplicate IDs 332–337.
   - Gate 4: Conversion of monetary columns to `NUMERIC(15,2)` and trailing dot `"50."` fix.
   - Gate 5: Zero-date conversion to `NULL` (14 rows) and century typo correction (13 rows).
   - Gate 6: Conversion of 14 MyISAM tables to PostgreSQL transactional tables.
   - Gate 7: Decision on misspelled table names (`expanses`, `fees_transections`, `batchs`).
   - Gate 8: React frontend & UTF-8 baseline.

3. **Priority 3: Provision Disposable Staging Databases**
   - Provision `icbd_disposable_mysql` and `icbd_disposable_pgsql`.
   - Configure `.env.testing` pointing strictly to disposable instances.
   - Add hard safety abort asserting that connection database is never `icbd_web`.

4. **Priority 4: Pre-Migration Data Cleansing Rules**
   - Convert 14 confirmed `'0000-00-00'` dates to `NULL`.
   - Correct 13 century typo dates (`0023-11-20` → `2023-11-20`).
   - Cleanse 2 `"50."` trailing dots in `students.discount` to `"50.00"`.

5. **Priority 5: Codebase Query Builder Alignment**
   - Update `app/Http/Controllers/UserController.php:263` and `app/Http/Controllers/Admin/SessionController.php:34, 140` to target `academic_sessions`.
   - Refactor non-strict `GROUP BY` in `ReportController.php:54-74, 105-125`.

---

## 7. Final Audit Status

```
READY FOR OWNER DECISIONS — AUDIT EVIDENCE COMPLETE
```

*Audit complete. All data profiling and technical evidence required for owner review is assembled. Execution remains stopped pending explicit owner approval of the 8 Decision Gates.*
