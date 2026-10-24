# Phase 2.6 — Institutional Accounting & Reporting APIs Implementation Report

**Project:** INNOVA Computers BD (`innova-web`)  
**Phase:** 2.6 (Institutional Accounting & Reporting)  
**Execution Context:** Existing Laravel Backend on configured MySQL (`icbd_web`)  
**Testing Isolation:** In-Memory SQLite (`:memory:`)  
**Date:** October 2026  
**Status:** COMPLETE — Awaiting Owner Approval

---

## 1. Executive Summary & Scope Confirmation

As specified in the authoritative `MODULE_API_REACT_MIGRATION_MAP.md`, Phase 2.6 strictly covers **Institutional Accounting & Reporting**. In adherence to roadmap instructions:
- **Certificate Management was NOT implemented** in this phase.
- **Shareholder & Loan Management were NOT implemented** in this phase.
- **Frontend React migration & PostgreSQL migration were NOT initiated.**
- **Zero writes, alterations, or DDL operations** were executed against the configured MySQL database (`icbd_web`).

The Phase 2.6 module delivers a complete, secure, versioned REST API under `/api/v1/accounting/*` that accurately maps legacy accounting behavior (covering incomes, expenses, categories, branches, and cash reconciliation summaries) while enforcing modern API design, strict input validation, server-side data sanitization, and role-based access control.

---

## 2. Existing Accounting Architecture & Legacy Business Rules

### 2.1 Schema Analysis & Legacy Spellings
Investigation of legacy models, migrations, and database structures revealed the following exact database entities:
1. **Branches (`branches`)**:
   - Primary attributes: `bname` (string), `baddress` (string), `startdate` (date), `btype` (int), `IsActive` (int), `deleted_at` (soft deletes).
   - In legacy code, branches are organizational units across which both revenue and expenditure are segmented.
2. **Income Categories (`income_categoris`)**:
   - Primary attributes: `branch_id` (nullable foreign key to `branches`), `categoris` (string category title), `IsActive` (int), `deleted_at` (soft deletes).
3. **Expense Categories (`expanse_categoris`)**:
   - Primary attributes: `branch_id` (nullable foreign key to `branches`), `categoris` (string category title), `IsActive` (int), `deleted_at` (soft deletes).
4. **Income Records (`incomes`)**:
   - Primary attributes: `user_id` (admin/user id), `branch_id` (branch id), `categoris_id` (foreign key to `income_categoris`), `bookNO` (book voucher string), `invoiceID` (invoice string), `invoiceDate` (date), `title` (string), `seller` (string), `recever` (spelled `recever` in schema, representing the client/payer), `description` (text), `amount` (stored as `varchar(191)` in MySQL), `createDate` (entry date), `IsActive` (int), `image` (receipt image path), `deleted_at` (soft deletes).
5. **Expense Records (`expanses`)**:
   - Primary attributes: `user_id`, `branch_id`, `categoris_id` (foreign key to `expanse_categoris`), `invoiceID`, `invoiceDate`, `title`, `seller` (vendor), `recever` (internal receiver/staff), `description`, `amount` (stored as `varchar(191)` in MySQL), `createDate`, `IsActive`, `image` (receipt image path), `deleted_at` (soft deletes).

### 2.2 Amount Representation & Comma Normalization
In the legacy MySQL schema, both `incomes.amount` and `expanses.amount` were configured as `VARCHAR(191)` columns. Historical records contain numeric entries with commas (e.g. `"25,000.00"` or `"15,000"`). Legacy reports used `REPLACE(amount, ',', '')` or `str_replace(',', '', $amount)` to calculate totals.
- **API Modernization Rule**: The API accepts both clean numeric floats and comma-formatted strings. Using `prepareForValidation()`, incoming amounts are sanitized to pure numeric decimal strings before validation, and stored in normalized format (`number_format((float) $cleanAmount, 2, '.', '')`).
- All server-side aggregations and report summaries parse amounts via `str_replace(',', '', $amount)` and round results to 2 decimal places.

### 2.3 Authorization & Existing Permission Constraints
- In accordance with the security directives, **no fictitious permissions were invented**.
- Examination of `PermissionTableSeeder.php` verified that only the following accounting-related permissions exist in the database:
  - `expanse-list`, `expanse-create`, `expanse-edit`, `expanse-delete`
  - `expanse-categoris-list`, `expanse-categoris-create`, `expanse-categoris-edit`, `expanse-categoris-delete`
- No permissions exist for `income-*`, `income-categoris-*`, or `branch-*`.
- Access to all `/api/v1/accounting/*` routes is guarded by Sanctum authentication (`auth:sanctum`) and strict Admin identity verification (`EnsureAdminIdentity`). Super-Administrators have full bypass via `Gate::before`. Expense endpoints strictly enforce the real Spatie permissions.

### 2.4 Soft Delete Preservation & Historical Integrity
- All 5 accounting tables implement soft deletes (`deleted_at`).
- Deleting a branch, category, income, or expense record performs an Eloquent soft delete (`$model->delete()`), setting `deleted_at` without purging records from the database.
- Historical accounting history is strictly preserved.

---

## 3. Implemented Versioned APIs

All endpoints are mounted under `/api/v1/accounting/` and require `auth:sanctum` and `admin.identity`.

### 3.1 Endpoint Summary

| HTTP Method | Route URI | Controller Action | Required Permission | Description |
|:---|:---|:---|:---|:---|
| `GET` | `/api/v1/accounting/branches` | `BranchApiController@index` | Admin Identity | Paginated/filtered branch listing (`is_active`, `btype`, `search`, `all`) |
| `POST` | `/api/v1/accounting/branches` | `BranchApiController@store` | Admin Identity | Create a new branch |
| `GET` | `/api/v1/accounting/branches/{id}` | `BranchApiController@show` | Admin Identity | Retrieve branch details |
| `PUT` | `/api/v1/accounting/branches/{id}` | `BranchApiController@update` | Admin Identity | Update an existing branch |
| `DELETE` | `/api/v1/accounting/branches/{id}` | `BranchApiController@destroy` | Admin Identity | Soft-delete a branch |
| `GET` | `/api/v1/accounting/categories/income` | `IncomeCategoryApiController@index` | Admin Identity | List income categories (`branch_id`, `is_active`, `search`, `all`) |
| `POST` | `/api/v1/accounting/categories/income` | `IncomeCategoryApiController@store` | Admin Identity | Create an income category |
| `GET` | `/api/v1/accounting/categories/income/{id}` | `IncomeCategoryApiController@show` | Admin Identity | Retrieve income category details |
| `PUT` | `/api/v1/accounting/categories/income/{id}` | `IncomeCategoryApiController@update` | Admin Identity | Update an income category |
| `DELETE` | `/api/v1/accounting/categories/income/{id}` | `IncomeCategoryApiController@destroy` | Admin Identity | Soft-delete an income category |
| `GET` | `/api/v1/accounting/categories/expense` | `ExpenseCategoryApiController@index` | `expanse-categoris-list` | List expense categories (`branch_id`, `is_active`, `search`, `all`) |
| `POST` | `/api/v1/accounting/categories/expense` | `ExpenseCategoryApiController@store` | `expanse-categoris-create` | Create an expense category |
| `GET` | `/api/v1/accounting/categories/expense/{id}` | `ExpenseCategoryApiController@show` | `expanse-categoris-list` | Retrieve expense category details |
| `PUT` | `/api/v1/accounting/categories/expense/{id}` | `ExpenseCategoryApiController@update` | `expanse-categoris-edit` | Update an expense category |
| `DELETE` | `/api/v1/accounting/categories/expense/{id}` | `ExpenseCategoryApiController@destroy` | `expanse-categoris-delete` | Soft-delete an expense category |
| `GET` | `/api/v1/accounting/incomes` | `IncomeApiController@index` | Admin Identity | Paginated income list with filters (`branch_id`, `categoris_id`, date range, search) |
| `POST` | `/api/v1/accounting/incomes` | `IncomeApiController@store` | Admin Identity | Create a new income record |
| `GET` | `/api/v1/accounting/incomes/{id}` | `IncomeApiController@show` | Admin Identity | Retrieve income record with relations |
| `PUT` | `/api/v1/accounting/incomes/{id}` | `IncomeApiController@update` | Admin Identity | Update an existing income record |
| `DELETE` | `/api/v1/accounting/incomes/{id}` | `IncomeApiController@destroy` | Admin Identity | Soft-delete an income record |
| `GET` | `/api/v1/accounting/expenses` | `ExpenseApiController@index` | `expanse-list` | Paginated expense list with filters (`branch_id`, `categoris_id`, date range, search) |
| `POST` | `/api/v1/accounting/expenses` | `ExpenseApiController@store` | `expanse-create` | Create a new expense record |
| `GET` | `/api/v1/accounting/expenses/{id}` | `ExpenseApiController@show` | `expanse-list` | Retrieve expense record with relations |
| `PUT` | `/api/v1/accounting/expenses/{id}` | `ExpenseApiController@update` | `expanse-edit` | Update an existing expense record |
| `DELETE` | `/api/v1/accounting/expenses/{id}` | `ExpenseApiController@destroy` | `expanse-delete` | Soft-delete an expense record |
| `GET` | `/api/v1/accounting/reports/daily-summary` | `AccountingReportApiController@dailySummary` | Admin Identity | Daily cash reconciliation across income, student fees, and expenses |
| `GET` | `/api/v1/accounting/reports/expense-by-category` | `AccountingReportApiController@expenseByCategory` | `expanse-list` | Expense report grouped by category for date range and branch |
| `GET` | `/api/v1/accounting/reports/income-by-category` | `AccountingReportApiController@incomeByCategory` | Admin Identity | Income report grouped by category for date range and branch |
| `GET` | `/api/v1/accounting/reports/monthly-summary` | `AccountingReportApiController@monthlySummary` | Admin Identity | Monthly comparison & cumulative balance summary (`year`, `month`, `branch_id`) |
| `GET` | `/api/v1/accounting/reports/category-details/{type}/{id}` | `AccountingReportApiController@categoryDetails` | Admin Identity | Line-item breakdown of expenses or incomes for a specific category |

---

## 4. Reconciliation & Reporting Business Logic

### 4.1 Daily Cash Summary & Reconciliation (`dailySummary`)
The daily summary unifies the three sources of institutional cash flow for any specified date (defaulting to the current date) and optional `branch_id`:
1. **Institutional Incomes (`incomes`)**: Records where `invoiceDate = $date`.
2. **Student Fees Collected (`fees_transections`)**: Records where `paiddate = $date` and `status = 1` (approved/active payments).
3. **Institutional Expenses (`expanses`)**: Records where `invoiceDate = $date`.

**Calculated Reconciliation Totals:**
$$\text{Total Revenue} = \text{Total Income} + \text{Total Fees Collected}$$
$$\text{Net Cash Flow} = \text{Total Revenue} - \text{Total Expense}$$

### 4.2 Monthly Comparison & Cumulative Balances (`monthlySummary`)
Preserves the algorithm from legacy `ReportController@generateReportMonthly`:
- **Current Month:** Sum of incomes and expenses for `(year, month)`.
- **Previous Month:** Sum of incomes and expenses for `(year, month - 1)`.
- **Cumulative Totals:** Sum of all past incomes and expenses from institutional inception up to the end of the selected month.
- **Net Balance:** Cumulative Incomes minus Cumulative Expenses.

### 4.3 Category Breakdown Details (`categoryDetails`)
Preserves the logic of `ReportController@getCategoryDetails` and `ReportController@getIncomeCategoryDetails`:
- Yields day-by-day line items for the category with formatted amounts and aggregate sums.

---

## 5. Request & Response Examples

### 5.1 Create Income Record
**Request:**
`POST /api/v1/accounting/incomes`
```json
{
  "branch_id": 1,
  "categoris_id": 2,
  "invoiceDate": "2026-10-24",
  "title": "Custom ERP Licensing Fee",
  "seller": "INNOVA Software Division",
  "recever": "ABC Technologies Ltd.",
  "amount": "35,000.50",
  "bookNO": "BK-2026-01",
  "invoiceID": "INV-INC-1001",
  "description": "Commercial license delivery for Q4",
  "IsActive": 1
}
```

**Response (`201 Created`):**
```json
{
  "success": true,
  "message": "Income record created successfully",
  "data": {
    "id": 15,
    "user_id": 1,
    "branch_id": 1,
    "categoris_id": 2,
    "bookNO": "BK-2026-01",
    "invoiceID": "INV-INC-1001",
    "invoiceDate": "2026-10-24",
    "title": "Custom ERP Licensing Fee",
    "seller": "INNOVA Software Division",
    "recever": "ABC Technologies Ltd.",
    "description": "Commercial license delivery for Q4",
    "amount": "35000.50",
    "createDate": "2026-10-24",
    "IsActive": 1,
    "image": null,
    "in_categoris": {
      "id": 2,
      "categoris": "Software Sales"
    },
    "branches": {
      "id": 1,
      "bname": "Main Campus Branch"
    }
  }
}
```

### 5.2 Daily Cash Summary
**Request:**
`GET /api/v1/accounting/reports/daily-summary?date=2026-10-24&branch_id=1`

**Response (`200 OK`):**
```json
{
  "success": true,
  "message": "Daily cash summary generated successfully",
  "data": {
    "date": "2026-10-24",
    "branch_id": 1,
    "branch_name": "Main Campus Branch",
    "summary": {
      "total_income": 20000.00,
      "total_fees_collected": 5000.00,
      "total_revenue": 25000.00,
      "total_expense": 8000.00,
      "net_cash_flow": 17000.00
    },
    "income_items": [...],
    "fee_items": [...],
    "expense_items": [...]
  }
}
```

---

## 6. Files Created & Modified

### 6.1 Files Created
1. `app/Http/Requests/Api/V1/StoreBranchRequest.php`
2. `app/Http/Requests/Api/V1/UpdateBranchRequest.php`
3. `app/Http/Requests/Api/V1/StoreIncomeCategoryRequest.php`
4. `app/Http/Requests/Api/V1/UpdateIncomeCategoryRequest.php`
5. `app/Http/Requests/Api/V1/StoreExpenseCategoryRequest.php`
6. `app/Http/Requests/Api/V1/UpdateExpenseCategoryRequest.php`
7. `app/Http/Requests/Api/V1/StoreIncomeRequest.php`
8. `app/Http/Requests/Api/V1/UpdateIncomeRequest.php`
9. `app/Http/Requests/Api/V1/StoreExpenseRequest.php`
10. `app/Http/Requests/Api/V1/UpdateExpenseRequest.php`
11. `app/Http/Controllers/Api/V1/BranchApiController.php`
12. `app/Http/Controllers/Api/V1/IncomeCategoryApiController.php`
13. `app/Http/Controllers/Api/V1/ExpenseCategoryApiController.php`
14. `app/Http/Controllers/Api/V1/IncomeApiController.php`
15. `app/Http/Controllers/Api/V1/ExpenseApiController.php`
16. `app/Http/Controllers/Api/V1/AccountingReportApiController.php`
17. `tests/Feature/Api/V1/AccountingApiTest.php`
18. `docs/modernization/PHASE_2_6_INSTITUTIONAL_ACCOUNTING_API_IMPLEMENTATION.md`

### 6.2 Files Modified
1. `routes/api.php` — Registered `/api/v1/accounting/*` routes.
2. `app/Models/Branch.php` — Added `SoftDeletes` trait and Eloquent relationships (`incomes`, `expenses`, `incomeCategories`, `expenseCategories`).
3. `app/Models/Income.php` — Added `user()` relationship to User model.
4. `app/Models/Expanse.php` — Added `user()` relationship to User model.
5. `app/Http/Middleware/EnsureAdminIdentity.php` — Synchronized authenticated Admin model with default auth driver (`auth()->setUser($user)`) for seamless Spatie permission evaluation in stateless Sanctum requests.

---

## 7. Verification & Test Suite Execution Results

### 7.1 Focused Phase 2.6 Test Suite
```bash
php vendor/bin/phpunit --filter AccountingApiTest
```
**Output:**
```
PHPUnit 9.6.29 by Sebastian Bergmann and contributors.

............                                                      12 / 12 (100%)

Time: 00:02.745, Memory: 34.00 MB

OK (12 tests, 104 assertions)
```

### 7.2 Full Regression Test Suite (All Phases 2.1 – 2.6)
```bash
php vendor/bin/phpunit
```
**Output:**
```
PHPUnit 9.6.29 by Sebastian Bergmann and contributors.

................................................................. 65 / 96 ( 67%)
...............................                                   96 / 96 (100%)

Time: 00:13.109, Memory: 48.00 MB

OK (96 tests, 459 assertions)
```

### 7.3 Test Suite Breakdown
| Module | Test File | Test Count | Result |
|:---|:---|:---:|:---:|
| System Ping | `PingTest.php` | 2 tests | PASS |
| Phase 2.2: Auth API | `AuthApiTest.php` | 13 tests | PASS |
| Phase 2.3: Academic API | `AcademicApiTest.php` | 20 tests | PASS |
| Phase 2.4: Student Lifecycle & Admission API | `StudentAdmissionApiTest.php` | 19 tests | PASS |
| Phase 2.5: Fees Collection, Transactions & bKash Reconciliation API | `FeeBkashApiTest.php` | 30 tests | PASS |
| **Phase 2.6: Institutional Accounting & Reporting API** | `AccountingApiTest.php` | 12 tests | **PASS** |
| **Total Test Suite** | **6 Test Classes** | **96 tests, 459 assertions** | **100% PASS** |

### 7.4 Database Safety Evidence
- Every single test explicitly checks:
  ```php
  $connection = DB::connection();
  if ($connection->getDriverName() !== 'sqlite' || $connection->getDatabaseName() !== ':memory:') {
      $this->fail('CRITICAL SAFETY CHECK: Test is not running on an isolated SQLite database!');
  }
  ```
- **Zero queries, DDL, or seeders were executed against the MySQL database (`icbd_web`).**

---

## 8. Unresolved Schema, Data & Business-Rule Blockers

1. **Varchar Amount Columns**:
   - `incomes.amount` and `expanses.amount` remain `VARCHAR(191)` in MySQL. The API sanitizes and normalizes amounts on input and output, but a future database migration in Phase 4 (PostgreSQL migration) should convert these columns to `DECIMAL(12, 2)`.
2. **Missing Granular Permissions for Income and Branches**:
   - Permissions `income-list`, `income-create`, `branch-list`, etc. do not exist in `PermissionTableSeeder.php`. Currently access is guarded at the Admin role level (`admin.identity`). When formal RBAC expansion is scheduled, appropriate permission seeders can be introduced without breaking current routes.
3. **Century-Typo Data in Historical Records**:
   - As documented in data profiling, historical records contain 9 rows in `expanses` and 6 in `incomes` with century-typo dates (e.g. `0223-xx-xx`). In accordance with database safety rules, these rows were left untouched and documented for Phase 4 migration cleanup.

---

## 10. Post-Implementation Business Logic & Authorization Audit Addendum

### 10.1 Executive Summary
Pursuant to the Phase 2.6 audit mandate, an in-depth code and business logic audit was conducted across the newly implemented Institutional Accounting & Reporting APIs, existing legacy controllers (`ReportController`, `FeesTransectionsController`, `UsersController`, `BkashController`), and authorization middleware.

A critical defect regarding student fee collection status semantics was identified and surgically resolved. Additional authorization barriers and edge-case boundary verifications were implemented and covered with comprehensive automated tests.

---

### 10.2 Student Fee Status Semantics: Confirmed Evidence & Defect Resolution

#### A. Empirical Investigation of Existing Codebase
A potential conflict was audited between Phase 2.5 fee documentation and Phase 2.6 daily cash reporting:
- `FeesTransections` status values were traced across legacy controllers and models:
  1. **Legacy `app/Http/Controllers/Admin/FeesTransectionsController.php` (lines 92–104)**:
     ```php
     public function FessStatus(Request $request, $id)
     {
         $fess = FeesTransections::find($id);
         $fess->status = $request->status;
         $fess->save();
         if ($request->status == 0) {
             $message = 'Payments has been approved';
         } else {
             $message = 'Payments has been Pending !!';
         }
         ...
     }
     ```
     *Authoritative rule*: `status == 0` designates **Approved**, whereas non-zero (`status == 1`) designates **Pending**.
  2. **Legacy `app/Http/Controllers/Admin/UsersController.php` (lines 206–207, 233–234)**:
     Calculates actual realized student fee payments:
     ```php
     FeesTransections::where('student_id', $student->id)
         ->where('paymentType', 1)
         ->where('status', 0)
         ->sum('paidamount');
     ```
     *Authoritative rule*: Realized revenue only counts records with `status = 0`.
  3. **Legacy `app/Http/Controllers/BkashController.php` (line 219)**:
     On successful online payment callback execution:
     ```php
     $fees->status = 1;
     $fees->save();
     ```
     *Authoritative rule*: bKash payments enter the system with `status = 1` (Pending), awaiting administrative verification before being marked `0` (Approved).
  4. **Phase 2.5 `FeeTransactionApiController.php`**:
     - Direct counter collection: persists `'status' => 0` (Approved immediately).
     - Realized student balance aggregation: `where('status', 0)->sum('paidamount')`.
  5. **Phase 2.5 `UpdateFeeStatusRequest.php`**:
     Explicit validation rules document: `0 = Approved, 1 = Pending`.

#### B. Defect Resolution in Phase 2.6
- **Defect Identified**: `AccountingReportApiController::dailySummary()` at line 73 originally queried `FeesTransections::where('status', 1)` under the assumption that `1` was approved.
- **Surgical Correction**: Line 73 of `AccountingReportApiController.php` was corrected to:
  ```php
  $fees = FeesTransections::query()
      ->whereDate('paiddate', $date->format('Y-m-d'))
      ->where('status', 0) // Authoritative: 0 = Approved
      ->get();
  ```
- **Regression Test Added**: `test_daily_cash_summary_distinguishes_approved_vs_pending_and_rejected_fee_status()` in `AccountingApiTest.php` asserts:
  - Fee transaction with `status = 0` (Approved) is included in daily realized revenue.
  - Fee transaction with `status = 1` (Pending) is excluded from daily realized revenue.
  - Fee transaction with `status = 2` (Rejected) is excluded from daily realized revenue.

---

### 10.3 Authorization & Security Findings

| Endpoint Group | Route Pattern | Middleware / Guard | Authorization Rule | Test Verification |
| :--- | :--- | :--- | :--- | :--- |
| **Expenses** | `/api/v1/accounting/expenses/*` | `auth:sanctum`, `admin.identity`, `permission:expanse-*` | Spatie permissions (`expanse-list`, `expanse-create`, `expanse-edit`, `expanse-delete`) | 403 for unauthorized admin; 200 for permitted staff; 200 for super-admin. |
| **Expense Categories** | `/api/v1/accounting/expense-categories/*` | `auth:sanctum`, `admin.identity`, `permission:expanse-categoris-*` | Spatie permissions (`expanse-categoris-list`, `expanse-categoris-create`, etc.) | 403 for unauthorized admin; 200 for permitted staff; 200 for super-admin. |
| **Incomes & Income Categories** | `/api/v1/accounting/incomes/*`, `/api/v1/accounting/income-categories/*` | `auth:sanctum`, `admin.identity` | Role: Admin Identity (mirrors legacy route group). | 403 Forbidden for Student/User token; 200 for Admin tokens. |
| **Branches** | `/api/v1/accounting/branches/*` | `auth:sanctum`, `admin.identity` | Role: Admin Identity (mirrors legacy route group). | 403 Forbidden for Student/User token; 200 for Admin tokens. |
| **Category Drilldown Reports** | `/api/v1/accounting/reports/category-details/expense/*` | `auth:sanctum`, `admin.identity` | Spatie `expanse-list` or super-admin role | 403 for admin lacking `expanse-list`; 200 for expense admin / super admin. |
| **Student / Non-Admin Tokens** | Any `/api/v1/accounting/*` | `EnsureAdminIdentity` | Rejects non-Admin tokens with 403 `"Admin credentials required"` | Blocked across all endpoints. |

- **Security Hardening**:
  - `EnsureAdminIdentity` strictly validates that the token bearer is an instance of `App\Models\Admin` and sets the default auth user via `auth()->setUser($user)`.
  - Super-Admin bypass was verified to correctly hook into `Gate::before` in `AuthServiceProvider` (`$user->hasRole('super-admin')`).

---

### 10.4 Accounting Calculation Findings

1. **Daily Summary Cash Reconciliation**:
   - `realized_income` = Incomes on `$date` + Approved fees (`status = 0`) on `$date`.
   - `realized_expense` = Expenses on `$date`.
   - `net_cash_flow` = `realized_income - realized_expense`.
   - Supports optional `branch_id` filtering.
2. **Monthly Comparison & Year Boundary Rollover**:
   - Current month income & expenses compared against previous month.
   - Audited month boundary handling: When querying January (`month = 1`), previous month rolls back cleanly to `month = 12` and `year = $year - 1` (tested via `test_monthly_summary_handles_january_boundary_correctly`).
3. **Cumulative Balance Aggregation**:
   - Preserves legacy `ReportController@generateReportMonthly` algorithm: sums historical transactions up to `endOfMonth()` of the selected month/year.
4. **Historical Amount Parsing & Numeric Precision**:
   - Legacy records frequently contain commas in amount strings (e.g. `'12,500.00'`).
   - All aggregations sanitize amount fields using `(float) str_replace(',', '', (string) $amount)`.
   - All response totals round explicitly to 2 decimal places (`round($sum, 2)`).
5. **Soft Deletes**:
   - Soft-deleted categories, branches, and expense records are automatically excluded from accounting totals via Eloquent's `SoftDeletes` scope (`whereNull('deleted_at')`), preserving historical audit records in database storage without skewing live figures.

---

### 10.5 Summary of Files Modified in Audit

1. `app/Http/Controllers/Api/V1/AccountingReportApiController.php`:
   - Line 73: Fixed `status = 0` for approved fee collections in `dailySummary()`.
   - Line 378: Added `expanse-list` permission check for expense category details.
2. `tests/Feature/Api/V1/AccountingApiTest.php`:
   - Line 238: Fixed role casing to `'super-admin'` to match `AuthServiceProvider` gate convention.
   - Line 740: Updated fee transaction seed to `'status' => 0`.
   - Lines 1007–1040: Added `test_daily_cash_summary_distinguishes_approved_vs_pending_and_rejected_fee_status()`.
   - Lines 1042–1074: Added `test_expense_category_details_authorization_barrier()`.
   - Lines 1076–1144: Added `test_monthly_summary_handles_january_boundary_correctly()`.
3. `docs/modernization/PHASE_2_6_INSTITUTIONAL_ACCOUNTING_API_IMPLEMENTATION.md`:
   - Added Section 10 Post-Implementation Business Logic & Authorization Audit Addendum.

---

### 10.6 Automated Test Execution & Isolation Evidence

- **Focused Test Suite**:
  ```bash
  php vendor/bin/phpunit tests/Feature/Api/V1/AccountingApiTest.php
  # Result: OK (15 tests, 117 assertions)
  ```
- **Full Application Regression Suite**:
  ```bash
  php vendor/bin/phpunit
  # Result: OK (99 tests, 472 assertions)
  ```
- **Database Safety & Isolation Evidence**:
  - `phpunit.xml` configures:
    ```xml
    <server name="DB_CONNECTION" value="sqlite"/>
    <server name="DB_DATABASE" value=":memory:"/>
    ```
  - Execution runs entirely within an isolated in-memory SQLite instance.
  - Zero SQL writes, alterations, or seeders were executed against MySQL database `icbd_web`.

---

### 10.7 Unresolved Risks Requiring Owner Decisions

1. **Granular RBAC for Income and Branches**:
   - `PermissionTableSeeder.php` does not define `income-*` or `branch-*` permissions. Currently, all authenticated administrators have access to income and branch management (matching the legacy admin dashboard behavior). If more granular permissions (e.g. `income-list`, `income-create`, `branch-list`) are desired for specific staff tiers, a permission seeder migration should be scheduled under a dedicated RBAC expansion phase.

---

## 11. Conclusion & Stop Condition

The Phase 2.6 Post-Implementation Business Logic & Authorization Audit is **100% complete**. All confirmed defects have been resolved, verified against legacy rules, and backed by automated tests.

In accordance with project constraints, **Phase 2.7 has NOT been started**. Work is stopped awaiting owner review and explicit approval.
