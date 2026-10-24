# Phase 2.7.1 — Shareholders & Capital Ledger API Implementation Report

**Project:** INNOVA Computers BD (`innova-web`)  
**Subphase:** 2.7.1 — Shareholders & Capital Ledger API Implementation  
**Status:** Completed & Validated  
**Date:** 2026-10-24  
**Author:** AI Modernization Agent

---

## 1. Executive Summary

Phase 2.7.1 has been implemented strictly adhering to the owner's instruction to limit scope exclusively to **Shareholder CRUD**, **Capital Investment CRUD**, **Shareholder Investment Summary**, and **Chronological Shareholder Capital Statement with Running Balance**.

No withdrawal approval/rejection endpoints (Phase 2.7.2), bank loans/EMI schedules (Phase 2.7.3), or ASSET training modules (Phase 2.7.4) have been implemented. The implementation preserves legacy database tables, models, business logic formulas, and monetary value sanitization without mutating production schema or configuration.

---

## 2. API Routes Implemented

All Phase 2.7.1 routes are secured under `auth:sanctum` and the `admin.identity` middleware (which enforces `App\Models\Admin` token authentication and rejects student `User` tokens with `403 Forbidden`).

| Method | URI | Route Name | Action / Handler | Middleware |
|---|---|---|---|---|
| `GET` | `/api/v1/shareholders` | `api.v1.shareholders.index` | `ShareholderApiController@index` | `auth:sanctum`, `admin.identity` |
| `POST` | `/api/v1/shareholders` | `api.v1.shareholders.store` | `ShareholderApiController@store` | `auth:sanctum`, `admin.identity` |
| `GET` | `/api/v1/shareholders/{id}` | `api.v1.shareholders.show` | `ShareholderApiController@show` | `auth:sanctum`, `admin.identity` |
| `PUT` | `/api/v1/shareholders/{id}` | `api.v1.shareholders.update` | `ShareholderApiController@update` | `auth:sanctum`, `admin.identity` |
| `DELETE` | `/api/v1/shareholders/{id}` | `api.v1.shareholders.destroy` | `ShareholderApiController@destroy` | `auth:sanctum`, `admin.identity` |
| `GET` | `/api/v1/shareholders/{id}/statement` | `api.v1.shareholders.statement` | `ShareholderApiController@statement` | `auth:sanctum`, `admin.identity` |
| `GET` | `/api/v1/investments` | `api.v1.investments.index` | `InvestmentApiController@index` | `auth:sanctum`, `admin.identity` |
| `POST` | `/api/v1/investments` | `api.v1.investments.store` | `InvestmentApiController@store` | `auth:sanctum`, `admin.identity` |
| `GET` | `/api/v1/investments/{id}` | `api.v1.investments.show` | `InvestmentApiController@show` | `auth:sanctum`, `admin.identity` |
| `PUT` | `/api/v1/investments/{id}` | `api.v1.investments.update` | `InvestmentApiController@update` | `auth:sanctum`, `admin.identity` |
| `DELETE` | `/api/v1/investments/{id}` | `api.v1.investments.destroy` | `InvestmentApiController@destroy` | `auth:sanctum`, `admin.identity` |

---

## 3. Files Created and Modified

### Created Files
1. `app/Http/Requests/Api/V1/StoreShareholderRequest.php`
   - Form request validating shareholder creation (`name`, `designation`, `shareType`, `isActive`, `address`, `nid`, `email`, `phone`).
2. `app/Http/Requests/Api/V1/UpdateShareholderRequest.php`
   - Form request for partial/full shareholder updates with validation rules.
3. `app/Http/Requests/Api/V1/StoreInvestmentRequest.php`
   - Form request validating capital investment creation (`shareholder_id`, `amount`, `recevedBy`, `recevedDate`, `isActive`).
   - Automatically sanitizes comma-formatted input values (e.g., `"50,000"` -> `"50000"`) in `prepareForValidation()`.
4. `app/Http/Requests/Api/V1/UpdateInvestmentRequest.php`
   - Form request for investment updates with automatic comma stripping.
5. `app/Http/Controllers/Api/V1/ShareholderApiController.php`
   - Controller providing shareholder CRUD, financial summaries (`total_investment`, `total_withdrawn`, `outstanding_balance`, `investment_count`), dependent-record deletion safeguards, and chronological statement with running balance.
6. `app/Http/Controllers/Api/V1/InvestmentApiController.php`
   - Controller providing capital investment CRUD using the legacy `invesments` table and `Invesments` model, comma sanitization, search/filtering, and capital balance integrity safeguards on deletion.
7. `tests/Feature/Api/V1/ShareholderCapitalApiTest.php`
   - Focused feature test suite containing 17 comprehensive automated tests verifying all Phase 2.7.1 requirements on isolated SQLite.
8. `docs/modernization/PHASE_2_7_1_SHAREHOLDERS_CAPITAL_API_IMPLEMENTATION.md`
   - This implementation and audit report.

### Modified Files
1. `app/Models/Invesments.php`
   - Added standard `shareholder()` `belongsTo` relationship to complement the legacy `ShareHolderInfo()` `hasMany` relationship without breaking legacy code.
2. `routes/api.php`
   - Registered Phase 2.7.1 routes within the `api/v1` route prefix and `['auth:sanctum', 'admin.identity']` middleware group.

---

## 4. Preserved Legacy Rules & Financial Integrity

### 4.1 Schema and Model Names Preserved
- Preserved existing table name `invesments` and model class `App\Models\Invesments` (retaining the legacy spelling).
- Preserved existing table name `shareholders` and model class `App\Models\Shareholder`.
- Preserved legacy column names: `recevedBy`, `recevedDate`, `shareType`, `isActive`.

### 4.2 Monetary Sanitization
- Legacy MySQL schema stores `invesments.amount` as `VARCHAR(191)` and legacy views format strings with commas (e.g. `50,000`).
- Both controllers and form requests rigorously sanitize all string amounts using `(float) str_replace(',', '', (string) $val)`.
- Numeric calculations, balance summaries, and statement running balances are computed using clean floating point arithmetic.

### 4.3 Capital Balance & Summary Formula
Legacy financial balance behavior is preserved:
$$\text{Total Investment} = \sum (\text{Active Investments for Shareholder})$$
$$\text{Total Withdrawn} = \sum (\text{Approved Withdrawals where } \text{status} = \text{'approved'})$$
$$\text{Outstanding Balance} = \text{Total Investment} - \text{Total Withdrawn}$$

The `ShareholderApiController@index` and `ShareholderApiController@show` return these calculated aggregates alongside each shareholder record.

### 4.4 Chronological Statement with Deterministic Tie-Breaker
The statement endpoint `GET /api/v1/shareholders/{id}/statement`:
1. Queries all investments (`invesments`) and approved withdrawals (`investment_withdraws` where canonical `status = 'approved'`, with dual-compatibility for legacy `status = '1'`).
2. Collects them into a single chronological ledger.
3. Implements a deterministic three-tier tie-breaker:
   - Primary: `date` ascending (`recevedDate` or `withdraw_date`).
   - Secondary: Type ordering (Deposits / Investments appear before Withdrawals on the same date).
   - Tertiary: Record `id` ascending.
4. Computes a progressive running balance:
   $$\text{Running Balance}_i = \text{Running Balance}_{i-1} + \text{Deposit}_i - \text{Withdrawal}_i$$
5. Returns `summary`, `statement` (transactions with running balance), and shareholder information.

### 4.5 Deletion Safeguards & Referential Integrity
1. **Shareholder Deletion Safeguard**:
   - Hard or soft deletion of a shareholder is strictly blocked with HTTP 422 (`Cannot delete shareholder with existing investments or dependent financial records`) if any investments, bank loans, or withdrawal records reference that shareholder.
2. **Investment Deletion Safeguard**:
   - An investment cannot be deleted if the reduction would cause the shareholder's outstanding capital balance to fall below zero (i.e. if existing approved withdrawals exceed remaining investments). This returns HTTP 422.

---

## 5. Security & Authorization

1. **Authentication:**
   - All Phase 2.7.1 routes require Laravel Sanctum bearer token authentication (`auth:sanctum`).
2. **Admin-vs-Student Identity Barrier:**
   - Enforced by `admin.identity` middleware.
   - Tested and verified: Requests made with a student token (`App\Models\User`) are immediately rejected with `403 Forbidden` (`{"message": "Forbidden: Admin access required"}`).
   - Requests without a token are rejected with `401 Unauthenticated`.
3. **Super-Admin & Admin Compatibility:**
   - Admins with role `Super Admin` or standard administrative tokens can manage shareholders and investments.

---

## 6. Test Results & Database Isolation

### 6.1 Database Isolation Evidence
All automated tests strictly executed against an isolated in-memory SQLite database (`:memory:`):
- `config(['database.default' => 'sqlite'])`
- `config(['database.connections.sqlite.database' => ':memory:'])`
- `DB::connection()->getDriverName()` is verified as `'sqlite'`.
- Zero writes, queries, DDL, or seeders touched the configured MySQL database (`icbd_web`).
- No `.env` files or production configuration were altered.

### 6.2 Focused Test Results
**Command:** `php vendor/bin/phpunit tests/Feature/Api/V1/ShareholderCapitalApiTest.php`
```
PHPUnit 9.6.29 by Sebastian Bergmann and contributors.

.................                                                 17 / 17 (100%)

Time: 00:03.421, Memory: 32.00 MB

OK (17 tests, 106 assertions)
```

**Tests Covered:**
1. `test_unauthenticated_request_is_rejected_with_401`
2. `test_student_user_token_is_rejected_with_403`
3. `test_admin_can_list_shareholders_with_financial_summaries`
4. `test_admin_can_filter_shareholders_by_is_active_and_search`
5. `test_admin_can_create_shareholder_with_validation`
6. `test_admin_can_show_shareholder_details`
7. `test_admin_can_update_shareholder`
8. `test_admin_can_soft_delete_shareholder_without_dependent_records`
9. `test_admin_cannot_delete_shareholder_with_active_investments`
10. `test_admin_can_list_investments_with_filters`
11. `test_admin_can_create_investment_with_comma_sanitization`
12. `test_admin_can_show_investment_details`
13. `test_admin_can_update_investment`
14. `test_admin_can_delete_investment_safely`
15. `test_admin_cannot_delete_investment_if_outstanding_balance_would_become_negative`
16. `test_shareholder_statement_calculates_correct_chronological_running_balance`
17. `test_shareholder_statement_handles_deterministic_tie_breaker_for_same_day_transactions`

### 6.3 Full Application Regression Test Results
**Command:** `php vendor/bin/phpunit`
```
PHPUnit 9.6.29 by Sebastian Bergmann and contributors.

...............................................................  63 / 116 ( 54%)
.....................................................           116 / 116 (100%)

Time: 00:19.543, Memory: 50.00 MB

OK (116 tests, 578 assertions)
```
100% of the full test suite (116 tests, 578 assertions) passed without errors or regressions.

---

## 7. Risks and Limitations

1. **Unapproved Withdrawal Visibility in Balance:**
   - In accordance with legacy behavior, pending/rejected withdrawal requests (`status = 'pending'`, `'rejected'`) do not deduct from the outstanding capital balance. Only approved withdrawals (canonical `status = 'approved'`, with dual-compatibility for legacy `status = '1'`) deduct from the balance.
2. **Legacy `VARCHAR` Amounts:**
   - Because the underlying MySQL table uses `VARCHAR(191)` for monetary fields (`invesments.amount`, `investment_withdraws.amount`), the API layer strictly casts and sanitizes all amounts. However, direct raw SQL updates bypassing Eloquent could introduce non-numeric data in legacy workflows.
3. **Phase 2.7.2 Scope Boundary:**
   - Endpoints for creating or approving withdrawal requests remain excluded until Phase 2.7.2.

---

## 8. Verification and Sign-Off Recommendation

Phase 2.7.1 is complete, verified, and adheres to all architectural constraints.
**Next Step:** Await explicit owner review and approval before proceeding to **Phase 2.7.2 (Investment & Dividend Withdrawal APIs)**.
