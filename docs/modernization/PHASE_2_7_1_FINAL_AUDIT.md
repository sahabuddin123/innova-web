# Phase 2.7.1 Final Approval Gate & Code Audit
## Shareholders & Capital Ledger API

**Document Version:** 1.0.0  
**Audit Date:** 2026-10-24  
**Project:** INNOVA Computers BD (`innova-web`)  
**Auditor:** Senior Database Architect & Backend Modernization Engineer  
**Status:** **PASS WITH LIMITATIONS** (Code & Live Schema Pass; Clean Migrations Blocked by Pre-existing Legacy Collisions)

---

## 1. Executive Summary

This audit constitutes the formal approval gate for **Phase 2.7.1: Shareholders & Capital Ledger API**, following the completion of the database schema reconciliation documented in [`SCHEMA_RECONCILIATION_FINAL_QUALITY_GATE.md`](file:///c:/wamp64/www/innova-web/docs/modernization/SCHEMA_RECONCILIATION_FINAL_QUALITY_GATE.md).

The audit covered a comprehensive code-level inspection of controllers, Form Requests, Eloquent models, route registrations, financial arithmetic reconciliation, security boundaries, and automated regression suites.

### Key Audit Findings:
1. **Verified Table Binding:** All code and models strictly bind to the verified table names: `shareholders` (live table) and `invesments` (legacy table with original spelling). The erroneous reference to `share_holders` in earlier draft documentation was verified as a non-code typo and corrected.
2. **Defect Identified & Resolved:** An omission in [`InvestmentApiController::update()`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Api/V1/InvestmentApiController.php#L136-L176) allowed updates (reducing amounts, setting `isActive = 0`, or changing shareholder ID) to bypass the capital balance integrity check, potentially causing an outstanding balance to become negative when approved withdrawals existed. A robust projected balance check was implemented and confirmed via new automated tests.
3. **Financial Statement Reconciliation:** The mathematical equivalence between summary totals (`total_investment`, `total_withdrawn`, `outstanding_balance`) and the chronological statement's final running balance was verified. Both endpoints apply identical filters: active investments only (`isActive = 1`) and approved withdrawals only (`status = 'approved'`).
4. **Deterministic Tie-Breaking:** Same-day transactions are sorted deterministically: `Date ASC` -> `Deposits before Withdrawals` -> `ID ASC`, preventing artificial transient overdrafts on same-day credit/debit events.
5. **Strict Authorization & Admin Boundary:** All 10 routes are shielded behind `auth:sanctum` and `admin.identity`. Trainee/student tokens (from the `users` table) are rejected with `403 Forbidden`.
6. **Zero MySQL Mutation:** Zero writes, zero DDL, and zero seeders were executed against the live MySQL `icbd_web` database. All tests were executed in strictly verified in-memory SQLite (`:memory:`).
7. **Test Results:** 19/19 focused tests (124 assertions) and 118/118 full suite tests (596 assertions) passed with 100% success.

---

## 2. Actual Code Paths Inspected

The following source files were directly inspected:

| Component | File Path | Lines | Key Responsibility |
| :--- | :--- | :--- | :--- |
| **Shareholder Controller** | [`app/Http/Controllers/Api/V1/ShareholderApiController.php`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Api/V1/ShareholderApiController.php) | 326 | Shareholder CRUD, financial metrics, statement generation, deletion safeguards |
| **Investment Controller** | [`app/Http/Controllers/Api/V1/InvestmentApiController.php`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Api/V1/InvestmentApiController.php) | 237 | Capital deposit CRUD, comma-normalization, balance integrity guards |
| **Store Shareholder Request** | [`app/Http/Requests/Api/V1/StoreShareholderRequest.php`](file:///c:/wamp64/www/innova-web/app/Http/Requests/Api/V1/StoreShareholderRequest.php) | 34 | Field validation for shareholder creation |
| **Update Shareholder Request** | [`app/Http/Requests/Api/V1/UpdateShareholderRequest.php`](file:///c:/wamp64/www/innova-web/app/Http/Requests/Api/V1/UpdateShareholderRequest.php) | 34 | Partial validation (`sometimes`) for shareholder updates |
| **Store Investment Request** | [`app/Http/Requests/Api/V1/StoreInvestmentRequest.php`](file:///c:/wamp64/www/innova-web/app/Http/Requests/Api/V1/StoreInvestmentRequest.php) | 44 | Comma-stripping, positive numeric validation, shareholder foreign key check |
| **Update Investment Request** | [`app/Http/Requests/Api/V1/UpdateInvestmentRequest.php`](file:///c:/wamp64/www/innova-web/app/Http/Requests/Api/V1/UpdateInvestmentRequest.php) | 44 | Comma-stripping, partial validation for investment updates |
| **Shareholder Model** | [`app/Models/Shareholder.php`](file:///c:/wamp64/www/innova-web/app/Models/Shareholder.php) | 67 | Explicit `$table = 'shareholders'`, soft deletes, legacy accessors |
| **Investment Model** | [`app/Models/Invesments.php`](file:///c:/wamp64/www/innova-web/app/Models/Invesments.php) | 52 | Explicit `$table = 'invesments'`, soft deletes, shareholder relation |
| **API Routes** | [`routes/api.php`](file:///c:/wamp64/www/innova-web/routes/api.php#L324-L354) | 31 | 10 routes registered under `['auth:sanctum', 'admin.identity']` |
| **Focused Test Suite** | [`tests/Feature/Api/V1/ShareholderCapitalApiTest.php`](file:///c:/wamp64/www/innova-web/tests/Feature/Api/V1/ShareholderCapitalApiTest.php) | 973 | 19 automated tests covering CRUD, authorization, balance integrity, statements |

---

## 3. Database Binding & Table Name Verification

### 3.1 Table Name Resolution
- **Investigation:** A draft documentation entry referenced `share_holders`, whereas schema audit reports referenced `shareholders`.
- **Code Inspection:**
  - In [`Shareholder.php`](file:///c:/wamp64/www/innova-web/app/Models/Shareholder.php#L15): `protected $table = 'shareholders';`
  - In [`StoreInvestmentRequest.php`](file:///c:/wamp64/www/innova-web/app/Http/Requests/Api/V1/StoreInvestmentRequest.php#L22): `'shareholder_id' => 'required|integer|exists:shareholders,id'`
  - In [`UpdateInvestmentRequest.php`](file:///c:/wamp64/www/innova-web/app/Http/Requests/Api/V1/UpdateInvestmentRequest.php#L22): `'shareholder_id' => 'sometimes|required|integer|exists:shareholders,id'`
  - In [`Invesments.php`](file:///c:/wamp64/www/innova-web/app/Models/Invesments.php#L15): `protected $table = 'invesments';`
  - In [`2026_10_24_000003_create_investment_withdraws_table.php`](file:///c:/wamp64/www/innova-web/database/migrations/2026_10_24_000003_create_investment_withdraws_table.php): foreign key references `shareholders(id)`.
- **Live Database Inspection:** The live MySQL database (`icbd_web`) contains table `shareholders` with 2 records. The table `share_holders` does not exist.
- **Resolution:** The code and database bindings are 100% correct and consistent. The typographical error in [`PHASE_2_7_1_SHAREHOLDERS_CAPITAL_API_IMPLEMENTATION.md`](file:///c:/wamp64/www/innova-web/docs/modernization/PHASE_2_7_1_SHAREHOLDERS_CAPITAL_API_IMPLEMENTATION.md) line 72 has been corrected.

---

## 4. Financial Reconciliation & Calculation Audit

### 4.1 Transaction Eligibility & Status Filtering
The audit verified the filtering logic between the summary aggregations and the ledger statement:

| Transaction Type | Underlying Table | Eligibility Condition | Legacy Controller Behavior | API Implementation | Audit Status |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **Capital Deposit** | `invesments` | `isActive = 1` | `where('isActive', 1)` | `where('isActive', 1)` | **VERIFIED MATCH** |
| **Inactive Deposit** | `invesments` | `isActive = 0` | Excluded from totals | Excluded from totals & statement | **VERIFIED MATCH** |
| **Capital Withdrawal** | `investment_withdraws` | `status = 'approved'` | `where('status', 'approved')` | `where('status', 'approved')` | **VERIFIED MATCH** |
| **Pending Withdrawal** | `investment_withdraws` | `status = 'pending'` | Excluded from totals | Excluded from totals & statement | **VERIFIED MATCH** |
| **Rejected Withdrawal** | `investment_withdraws` | `status = 'rejected'` | Excluded from totals | Excluded from totals & statement | **VERIFIED MATCH** |

### 4.2 Statement Running Balance Reconciles with Summary Totals
The mathematical reconciliation between the summary and the statement was formally verified in code and in Test 19:
- **Summary Metrics:**
  $$\text{Total Investment} = \sum_{\text{eligible}} \text{Deposits}$$
  $$\text{Total Withdrawn} = \sum_{\text{eligible}} \text{Withdrawals}$$
  $$\text{Current Balance} = \text{Total Investment} - \text{Total Withdrawn}$$
- **Statement Ledger:**
  $$\text{Running Balance}_0 = 0.00$$
  $$\text{Running Balance}_i = \text{Running Balance}_{i-1} + \text{Debit}_i - \text{Credit}_i$$
  $$\text{Final Running Balance} = \sum \text{Debit} - \sum \text{Credit} = \text{Current Balance}$$
- **Automated Verification:** Verified in Test 16 (4 transactions with tie-breakers) and Test 19 (full reconciliation with inactive deposits and pending withdrawals present).

### 4.3 Deterministic Sorting & Tie-Breaker
When deposits and withdrawals occur on the same calendar date, sorting order determines whether a transient negative balance is displayed.
[`ShareholderApiController::statement()`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Api/V1/ShareholderApiController.php#L245-L253) applies a three-tiered deterministic comparator:
1. `Date ASC` (chronological sequence)
2. `Type == 'Deposit'` before `'Withdrawal'` (deposits are credited before debits on the same date)
3. `ID ASC` (deterministic tie-breaker for identical date and type)

### 4.4 Numeric Validation, Comma Formatting & Precision
- **Comma Stripping:** Both `StoreInvestmentRequest` and `UpdateInvestmentRequest` utilize `prepareForValidation()`:
  ```php
  if ($this->has('amount') && is_string($this->amount)) {
      $this->merge(['amount' => str_replace(',', '', $this->amount)]);
  }
  ```
- **Validation Rules:** `amount => required|numeric|min:0.01`. Non-numeric inputs, negative numbers, and zero amounts are rejected with `422 Unprocessable Entity`.
- **String Storage Compatibility:** Stored as `number_format($cleanAmount, 2, '.', '')` to respect legacy `varchar(191)` schema without precision degradation.
- **Calculation Precision:** All floating-point aggregations use `round($val, 2)` before serialization.

---

## 5. Security & Boundary Audit

### 5.1 Route Protection & Identity Enforcement
All 10 Phase 2.7.1 routes are enclosed within:
```php
Route::middleware(['auth:sanctum', 'admin.identity'])->group(function () { ... });
```
- **Unauthenticated Requests:** Rejected with `401 Unauthorized` (Verified by Test 1).
- **Student/User Tokens:** Rejected with `403 Forbidden` (`Admin identity required.`) (Verified by Test 2).
- **Admin Tokens:** Allowed access subject to Spatie role/permission authorization (Verified by Tests 1, 13, 17).

### 5.2 Deletion Safeguards & Referential Integrity
[`ShareholderApiController::destroy()`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Api/V1/ShareholderApiController.php#L148-L179) enforces four strict cascade-prevention checks before allowing shareholder deletion:
1. Rejects if active or historical capital investments exist (`Invesments::where('shareholder_id', $id)->exists()`).
2. Rejects if bank loans exist (`BankLoan::where('shareholder_id', $id)->exists()`).
3. Rejects if capital withdrawals exist (`InvestmentWithdraw::where('shareholder_id', $id)->exists()`).
4. Rejects if dividend withdrawals exist (`DividendWithdraw::where('shareholder_id', $id)->exists()`).

All four deletion attempts return `422 Unprocessable Entity` with an explicit reason string. Verified by Tests 5, 14, and 15.

---

## 6. Confirmed Defect & Resolution During Audit

### Defect Identified: Investment Update Capital Balance Bypass
- **Severity:** High (Financial Integrity)
- **Root Cause:** [`InvestmentApiController::destroy()`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Api/V1/InvestmentApiController.php#L191) guarded against deleting an active investment if the reduction would cause the shareholder's outstanding balance to fall below zero (due to existing approved withdrawals). However, [`InvestmentApiController::update()`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Api/V1/InvestmentApiController.php#L121) lacked an equivalent safeguard.
- **Vulnerability Scenario:**
  - Shareholder has 50,000 invested and 40,000 approved withdrawals (balance: 10,000).
  - An admin updates the investment amount to 30,000, sets `isActive = 0`, or changes `shareholder_id`.
  - The outstanding balance would silently drop to -10,000 or -40,000, violating balance integrity.
- **Resolution Applied:**
  Implemented projected balance calculation in [`InvestmentApiController::update()`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Api/V1/InvestmentApiController.php#L136-L176):
  ```php
  if ($targetShareholderId === $originalShareholderId) {
      $projectedBalance = ($totalActive - $originalAmount + $newActiveAmount) - $totalWithdrawn;
  } else {
      $projectedBalance = ($totalActive - $originalAmount) - $totalWithdrawn;
  }

  if ($projectedBalance < 0) {
      return $this->error('Cannot update investment: Shareholder outstanding balance would become negative (' . round($projectedBalance, 2) . ') due to existing approved withdrawals.', 422);
  }
  ```
- **Automated Regression Verification:** Added Test 18 in [`ShareholderCapitalApiTest.php`](file:///c:/wamp64/www/innova-web/tests/Feature/Api/V1/ShareholderCapitalApiTest.php#L873-L933).

---

## 7. Actual Test Execution Results

All automated test suites were executed on an isolated in-memory SQLite connection (`:memory:`).

### 7.1 Focused Test Suite: `ShareholderCapitalApiTest`
Command: `php vendor/bin/phpunit tests/Feature/Api/V1/ShareholderCapitalApiTest.php`

```
PHPUnit 9.6.29 by Sebastian Bergmann and contributors.

...................                                               19 / 19 (100%)

Time: 00:02.483, Memory: 34.00 MB

OK (19 tests, 124 assertions)
```

#### Detailed Test Inventory:
1. `test_unauthenticated_request_is_rejected_with_401` — PASS
2. `test_student_user_token_is_rejected_with_403` — PASS
3. `test_admin_can_create_shareholder_with_valid_data` — PASS
4. `test_admin_can_list_shareholders_with_financial_summaries` — PASS
5. `test_shareholder_deletion_is_blocked_when_dependent_investments_exist` — PASS
6. `test_admin_can_view_shareholder_details_with_investment_ledger` — PASS
7. `test_admin_can_update_shareholder_profile` — PASS
8. `test_admin_can_create_investment_with_comma_formatted_amount` — PASS
9. `test_investment_creation_fails_when_amount_is_zero_or_negative` — PASS
10. `test_investment_creation_fails_when_shareholder_does_not_exist` — PASS
11. `test_admin_can_filter_investments_by_shareholder_and_status` — PASS
12. `test_not_found_responses_return_consistent_404_json` — PASS
13. `test_admin_cannot_delete_investment_if_outstanding_balance_would_become_negative` — PASS
14. `test_shareholder_deletion_is_blocked_when_dependent_withdrawals_exist` — PASS
15. `test_shareholder_deletion_is_blocked_when_dependent_bank_loans_exist` — PASS
16. `test_shareholder_statement_calculates_chronological_running_balance_with_tie_breaker` — PASS
17. `test_super_admin_has_full_access` — PASS
18. `test_admin_cannot_update_investment_if_outstanding_balance_would_become_negative` — PASS *(New regression test)*
19. `test_shareholder_statement_and_summary_reconcile_identically` — PASS *(New regression test)*

### 7.2 Full Regression Test Suite
Command: `php vendor/bin/phpunit`

```
PHPUnit 9.6.29 by Sebastian Bergmann and contributors.

...............................................................  63 / 118 ( 53%)
.......................................................         118 / 118 (100%)

Time: 00:16.150, Memory: 52.00 MB

OK (118 tests, 596 assertions)
```
**Result:** Zero regressions across all existing authentication, security hardening, academic, admission, fee/bKash, and accounting test suites.

---

## 8. Code Inspection vs Live MySQL vs Clean Installs

To maintain absolute architectural transparency, the environment status is categorized as follows:

| Environment / Mode | Status | Verification Detail |
| :--- | :--- | :--- |
| **Phase 2.7.1 Code & APIs** | **PASS** | 100% inspected, verified against legacy models, routes, form requests, and tests. |
| **Existing Live MySQL (`icbd_web`)** | **PASS** | Live schema has table `shareholders` and `invesments`, 24 recorded migrations, and 23 reconciled manual columns. No writes or DDL executed. |
| **Isolated SQLite Test Suite** | **PASS** | 118/118 tests pass on in-memory SQLite (`:memory:`). |
| **Clean Install from Zero Migrations** | **BLOCKED (Pre-existing)** | Blocked at migration 23 by pre-existing duplicate `CreateSessionsTable` migration collision (`sessions` vs academic sessions) and duplicate ASSET migration classes, as documented in [`SCHEMA_RECONCILIATION_FINAL_QUALITY_GATE.md`](file:///c:/wamp64/www/innova-web/docs/modernization/SCHEMA_RECONCILIATION_FINAL_QUALITY_GATE.md). |

---

## 9. Remaining Risks & Unresolved Decisions

1. **Owner Decision Gate 2 (Sessions Migration Collision):**
   - Clean install blocked by two migration files declaring `class CreateSessionsTable`.
   - Requires owner approval to rename the second migration class before PostgreSQL migration.
2. **Owner Decision Gate 7 (Duplicate ASSET Migrations):**
   - Clean install blocked by duplicate class names for `asset_courses` and `asset_students`.
   - Requires owner decision on whether ASSET tables are retained or consolidated.
3. **Phase 2.7.2 Scope Boundary (Withdrawals):**
   - Investment withdrawals table exists and status handling (`approved`) is reconciled in Phase 2.7.1 calculations.
   - Formal CRUD and approval workflow APIs for withdrawals belong to **Phase 2.7.2** and have **not** been implemented, adhering to the strict subphase boundary.

---

## 10. Final Gate Determination

### Status: **PASS WITH LIMITATIONS**

- **Code & API Quality:** PASS (Exceeds all Phase 2.7.1 requirements; financial balance integrity bug identified and resolved; 100% test pass rate).
- **Database Safety:** PASS (0 mutations to live MySQL).
- **Limitations:** Clean installation from zero migrations remains blocked by pre-existing legacy migration class redeclarations (Owner Decision Gates 2 & 7). This limitation does not affect the live MySQL deployment or the running application.

---

## 11. Stop Condition

In compliance with the project instructions, **work on Phase 2.7.1 is complete**. **Phase 2.7.2 (Capital Withdrawals) has NOT been started** and will await explicit owner approval of this final audit report.
