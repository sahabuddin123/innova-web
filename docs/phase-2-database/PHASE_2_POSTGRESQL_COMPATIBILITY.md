# Phase 2 — MySQL-to-PostgreSQL Compatibility & SQL Architecture Audit

**Project:** `innova-web` — INNOVA Computers BD (ICBD)  
**Audit Phase:** Phase 2 (Database Architecture Audit & Migration Planning — Audit Only)  
**Source Engine:** MySQL 8.0.31 / InnoDB & MyISAM (`strict: false`, `utf8mb4_unicode_ci`)  
**Target Engine:** PostgreSQL 15 / 16 (Strict SQL, `UTF8`, Default Schema `public`)  
**Audit Date:** October 2026  
**Status:** CONFIRMED — Evidence-Based Static Code Analysis & Live DB Inspection  

---

## 1. Executive Summary

Migrating `innova-web` from MySQL to PostgreSQL is technically feasible and essential for data integrity, financial auditing, and concurrency safety. However, the application relies on several MySQL-specific non-strict behaviors that will crash in PostgreSQL unless proactively refactored.

This audit documents **12 specific compatibility risk categories**, complete with exact code locations, severity ratings, behavioral impacts, and concrete remediation patterns.

---

## 2. Master Compatibility Risk Matrix

| Finding ID | Compatibility Area | Severity | Impacted Files & Lines | PostgreSQL Failure Mode | Remediation Pattern |
|---|---|---|---|---|---|
| **PG-01** | Strict `GROUP BY` Non-Aggregated Columns | **Critical** | [`ReportController.php:54-74`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/ReportController.php#L54)<br/>[`ReportController.php:105-125`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/ReportController.php#L105) | SQL State 42803: `column must appear in the GROUP BY clause or be used in an aggregate function` | Refactor report query to group properly or use CTE / subquery |
| **PG-02** | Case-Sensitive `LIKE` Search Breakage | **High** | 31 Lines across [`StudentsController.php`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/StudentsController.php), [`StudentManagementController.php`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/StudentManagementController.php), [`FrontendController.php`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Frontend/FrontendController.php), etc. | Searching `"karim"` returns 0 rows if student name is `"Karim"` | Convert all `where('col', 'like', ...)` to `where('col', 'ilike', ...)` |
| **PG-03** | Currency String Anti-Pattern (`VARCHAR` → `NUMERIC`) | **High** | 6 Tables (`expanses`, `incomes`, `fees_transections`, `students`, `invesments`, `courses`) | `invalid input syntax for type numeric` if strings with commas or spaces are inserted directly | ETL cleansing pipeline with regex sanitization; migrate column to `NUMERIC(15,2)` |
| **PG-04** | Invalid Zero Dates (`0000-00-00`) | **High** | `expanses.invoiceDate` (6 rows)<br/>`incomes.invoiceDate` (8 rows) | SQL State 22008: `date out of range for "0000-00-00"` | Convert all `0000-00-00` to `NULL` prior to PostgreSQL restore |
| **PG-05** | Boolean vs. Multi-State Integer (`students.IsActive`) | **Critical** | [`app/Models/Students.php`](file:///c:/wamp64/www/innova-web/app/Models/Students.php)<br/>[`StudentsController.php:80-160`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/StudentsController.php#L80) | If mapped to `BOOLEAN`, statuses 2, 3, 4, 5 coerce to `TRUE`, permanently destroying academic status | Map `students.IsActive` strictly to `SMALLINT`, never `BOOLEAN` |
| **PG-06** | Unsigned Integer Types | **Medium** | All migrations & tables (`bigint unsigned`, `int unsigned`, `tinyint unsigned`) | PostgreSQL lacks native unsigned integers | Map `unsignedBigInteger` → `BIGINT`, `unsignedInteger` → `INTEGER`, `unsignedTinyInteger` → `SMALLINT` |
| **PG-07** | Identity Sequences vs. `AUTO_INCREMENT` | **High** | All 52 tables post-data import | Duplicate key error on primary key insert because sequence is at 1 while `MAX(id)` is > 1000 | Post-import sequence synchronization script (`SELECT setval(...)`) |
| **PG-08** | Storage Engine & ACID Inconsistency | **Medium** | 14 MyISAM tables (`bank_loans`, `emi_installments`, `investment_withdraws`, etc.) | MyISAM tables currently lack foreign keys and rollback support | Convert all tables to PostgreSQL standard transactional tables with explicit FK constraints |
| **PG-09** | Collation Mismatch (`latin1_swedish_ci`) | **High** | `certificates_icbd` (38 rows) | Inserting Bangla Unicode into `latin1` results in corrupted `????` characters | Explicitly convert all columns to `UTF8` in PostgreSQL |
| **PG-10** | Reserved Words in Identifiers | **Low** | `teams.order`, `settings.key`, `users.name` | Unquoted keywords in raw SQL queries cause syntax errors | Always use Eloquent or quote identifiers with double quotes (`"order"`, `"key"`) |
| **PG-11** | Raw SQL String Replacements (`REPLACE`) | **Medium** | [`ReportController.php:57, 108`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/ReportController.php#L57) | `REPLACE(col, ',', '')` is redundant and slow once column is numeric | Refactor to native aggregate `SUM(amount)` once migrated to `NUMERIC` |
| **PG-12** | Database-Level Unique Constraint on `trxID` | **Critical** | `fees_transections.trxID` | Duplicate key violation on IDs 332–337; failure on multiple `NULL`s if misconfigured | Create partial unique index: `WHERE trxID IS NOT NULL AND TRIM(trxID) != ''` |

---

## 3. Detailed Technical Findings & Remediation Patterns

### 3.1 PG-01: Non-Strict `GROUP BY` Queries in Reports
- **Severity:** Critical
- **Location:** [`app/Http/Controllers/Admin/ReportController.php:54-74, 105-125`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/ReportController.php#L54-L74)
- **Current MySQL Code:**
  ```php
  $query = Expanse::select(
          'expanses.id',
          'expanses.title',
          DB::raw('REPLACE(expanses.amount, ",", "") AS amount_without_commas'),
          'ec.categoris as category_name',
          DB::raw('SUM(REPLACE(expanses.amount, ",", "")) as total_amount')
      )
      ->from('expanses AS expanses')
      ->join('expanse_categoris AS ec', 'expanses.categoris_id', '=', 'ec.id')
      ->whereBetween('expanses.invoiceDate', [$startDate, $endDate])
      ->whereNull('expanses.deleted_at');
  ...
  $result = $query->groupBy('ec.categoris')->get();
  ```
- **Why It Fails in PostgreSQL:**
  In MySQL, this query only succeeded because `'strict' => false` was configured in `config/database.php`. In PostgreSQL and standard ANSI SQL, selecting non-aggregated columns (`expanses.id`, `expanses.title`, `expanses.amount`) while grouping exclusively by `ec.categoris` raises:
  `ERROR: column "expanses.id" must appear in the GROUP BY clause or be used in an aggregate function`.
  The expense and income reporting dashboards will completely crash.
- **Recommended Remediation Pattern:**
  Refactor the query to aggregate purely at the category level:
  ```php
  $query = Expanse::select(
          'ec.id as category_id',
          'ec.categoris as category_name',
          DB::raw('SUM(expanses.amount) as total_amount'),
          DB::raw('COUNT(expanses.id) as total_vouchers')
      )
      ->join('expanse_categoris AS ec', 'expanses.categoris_id', '=', 'ec.id')
      ->whereBetween('expanses.invoiceDate', [$startDate, $endDate])
      ->whereNull('expanses.deleted_at')
      ->groupBy('ec.id', 'ec.categoris');
  ```

---

### 3.2 PG-02: Case-Sensitivity in String Searches (`LIKE` vs `ILIKE`)
- **Severity:** High
- **Locations Affected (31 Lines Confirmed):**
  - [`app/Http/Controllers/Admin/StudentsController.php:43, 65, 87, 109, 131, 153, 325`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/StudentsController.php#L43)
  - [`app/Http/Controllers/Admin/StudentManagementController.php:22-25`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/StudentManagementController.php#L22-L25)
  - [`app/Http/Controllers/Admin/DividendWithdrawController.php:52-56`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/DividendWithdrawController.php#L52-L56)
  - [`app/Http/Controllers/Admin/EmiInstallmentController.php:59-61`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/EmiInstallmentController.php#L59-L61)
  - [`app/Http/Controllers/Admin/InvestmentWithdrawController.php:52-56`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/InvestmentWithdrawController.php#L52-L56)
  - [`app/Http/Controllers/Frontend/FrontendController.php:175`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Frontend/FrontendController.php#L175)
- **Current Behavior in MySQL:**
  Because the MySQL collation is `utf8mb4_unicode_ci` (`_ci` = case-insensitive), `WHERE sname LIKE '%sahab%'` matches `"Sahab Uddin"`, `"SAHAB UDDIN"`, and `"sahab"`.
- **Why It Fails in PostgreSQL:**
  In PostgreSQL, the `LIKE` operator is **strictly case-sensitive**. Searching `"sahab"` will return **0 records** because all student names are entered with initial capitals or in uppercase (e.g. `"SAHAB UDDIN"` in ID 1).
- **Recommended Remediation Pattern:**
  Replace `like` with PostgreSQL's native case-insensitive pattern matcher `ilike`:
  ```php
  // Target PostgreSQL search syntax:
  $q->where('sname', 'ilike', '%' . $search . '%')
    ->orWhere('phone', 'like', '%' . $search . '%');
  ```
  Or use database-agnostic lowercase wrapping:
  ```php
  $q->whereRaw('LOWER(sname) LIKE ?', ['%' . strtolower($search) . '%']);
  ```

---

### 3.3 PG-03: Currency Amount Storage Normalization
- **Severity:** High
- **Locations Affected:**
  - `expanses.amount` (`varchar(191)`) — 6,338 records
  - `incomes.amount` (`varchar(191)`) — 5,694 records
  - `fees_transections.paidamount` (`varchar(191)`) — 1,604 records
  - `students.course_fee`, `students.discount`, `students.balance` (`varchar(191)`) — 1,005 records
  - `invesments.amount` (`varchar(191)`) — 46 records
- **Why It Fails in PostgreSQL:**
  In MySQL, loose type coercion allowed storing strings like `'15,000'`, `'2500'`, `'00'`, or `''`. Attempting to insert these strings directly into PostgreSQL `NUMERIC(15,2)` causes bulk load failure with:
  `ERROR: invalid input syntax for type numeric: "15,000"`.
  Furthermore, in PHP 8.0+, mathematical operations on formatted strings (`+= $income->amount`) truncate at the comma or throw TypeErrors!
- **Recommended Remediation Pattern:**
  1. Define PostgreSQL columns strictly as `NUMERIC(15, 2) NOT NULL DEFAULT 0.00`.
  2. Apply an ETL cleansing transform during data ingestion:
     ```sql
     CASE 
         WHEN amount IS NULL OR TRIM(amount) = '' THEN 0.00
         ELSE CAST(REGEXP_REPLACE(TRIM(amount), '[^0-9.]', '', 'g') AS NUMERIC(15, 2))
     END
     ```

---

### 3.4 PG-04: Invalid Zero Dates (`0000-00-00`)
- **Severity:** High
- **Confirmed Live Database Records:**
  - `expanses.invoiceDate`: 6 records with `'0000-00-00'`
  - `incomes.invoiceDate`: 8 records with `'0000-00-00'`
- **Why It Fails in PostgreSQL:**
  MySQL permitted `'0000-00-00'` when `NO_ZERO_DATE` was disabled. PostgreSQL strictly enforces Gregorian calendar dates. Attempting to insert `'0000-00-00'` throws:
  `ERROR: date out of range for "0000-00-00"`.
- **Recommended Remediation Pattern:**
  During the ETL pipeline, convert any date value `'0000-00-00'` or `'0000-00-00 00:00:00'` to `NULL`:
  ```sql
  NULLIF(invoiceDate, '0000-00-00')
  ```

---

### 3.5 PG-05: Multi-State Integer Trap (`students.IsActive`)
- **Severity:** Critical Data Integrity Risk
- **Location:** [`app/Models/Students.php`](file:///c:/wamp64/www/innova-web/app/Models/Students.php), [`app/Http/Controllers/Admin/StudentsController.php:80-160`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/StudentsController.php#L80)
- **Current Behavior in Application:**
  In MySQL, `students.IsActive` is stored as `TINYINT(1)` or `INT`. Inspecting `StudentsController.php` reveals that `IsActive` is an **academic state enumeration**:
  - `1` = Active Students (`StudentsController@active`)
  - `2` = Irregular Students (`StudentsController@inactive`)
  - `3` = Completed Course Students (`StudentsController@complete`)
  - `4` = Restricted Students (`StudentsController@restricted`)
  - `5` = Postponed Students (`StudentsController@postpond`)
- **Why It Fails in PostgreSQL:**
  Automated migration utilities often map MySQL `TINYINT(1)` directly to PostgreSQL `BOOLEAN`. If applied here, all statuses `2, 3, 4, 5` will be coerced to `TRUE`, irreversibly corrupting the academic statuses of hundreds of students!
- **Recommended Remediation Pattern:**
  Define `students.IsActive` in PostgreSQL strictly as `SMALLINT NOT NULL DEFAULT 1`:
  ```sql
  "IsActive" SMALLINT NOT NULL DEFAULT 1
  ```
  Add a check constraint to enforce valid states:
  ```sql
  CONSTRAINT check_student_status CHECK ("IsActive" BETWEEN 1 AND 5)
  ```

---

### 3.6 PG-07: Identity Sequence Synchronization
- **Severity:** High
- **Scope:** All 52 tables
- **Why It Matters:**
  PostgreSQL uses sequences to generate values for `GENERATED BY DEFAULT AS IDENTITY` or `SERIAL` columns. When data is imported with explicit primary keys (`INSERT INTO students (id, ...) VALUES (1, ...), (2, ...)`), the sequence counter **remains at 1**.
  The next insert attempt via Laravel (`$student->save()`) will fail with:
  `ERROR: duplicate key value violates unique constraint "students_pkey" (Key (id)=(1) already exists)`.
- **Recommended Remediation Pattern:**
  A post-migration synchronization script must be run for all tables:
  ```sql
  SELECT setval(pg_get_serial_sequence('students', 'id'), COALESCE(MAX(id), 1)) FROM students;
  SELECT setval(pg_get_serial_sequence('fees_transections', 'id'), COALESCE(MAX(id), 1)) FROM fees_transections;
  SELECT setval(pg_get_serial_sequence('expanses', 'id'), COALESCE(MAX(id), 1)) FROM expanses;
  SELECT setval(pg_get_serial_sequence('incomes', 'id'), COALESCE(MAX(id), 1)) FROM incomes;
  SELECT setval(pg_get_serial_sequence('bank_loans', 'id'), COALESCE(MAX(id), 1)) FROM bank_loans;
  SELECT setval(pg_get_serial_sequence('emi_installments', 'id'), COALESCE(MAX(id), 1)) FROM emi_installments;
  ```

---

### 3.7 PG-12: `fees_transections.trxID` Unique Constraint Implementation
- **Severity:** Critical
- **Confirmed Evidence:**
  - 1,604 total records in `fees_transections`.
  - 1,598 records have `trxID IS NULL`.
  - Exactly 1 key (`AAN****SE0`) has 6 duplicate records (`ids: 332, 333, 334, 335, 336, 337`).
- **Remediation Rule:**
  1. Do not apply a unique constraint until IDs 332–337 are resolved by owner decision.
  2. In PostgreSQL, implement a **partial unique index**:
     ```sql
     CREATE UNIQUE INDEX fees_transections_trxid_unique 
     ON fees_transections ("trxID") 
     WHERE "trxID" IS NOT NULL AND TRIM("trxID") != '';
     ```

---

## 4. Full-System Compatibility Verification Sign-Off
- **Raw SQL Compatibility:** Confirmed restricted to `ReportController.php:57, 108`. No unsupported raw queries found elsewhere.
- **Bcrypt Password Compatibility:** `admins` (7 rows) and `users` (149 rows) use standard `$2y$10$` Bcrypt hashes. 100% natively compatible with Laravel 13 on PostgreSQL. Zero password resets required.
- **Media Path Verbatim Compatibility:** Media paths in `students.image`, `teachers.image`, `expanses.image` are relative disk strings (e.g. `'stuff/Rn9g0Ag...png'`). Verbatim migration preserves 100% of asset references.
