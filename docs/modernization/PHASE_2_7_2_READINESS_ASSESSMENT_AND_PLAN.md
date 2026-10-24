# Phase 2.7.2 Readiness Assessment & Implementation Plan
## Investment & Dividend Withdrawal APIs

**Document Version:** 1.0.0  
**Date:** 2026-10-24  
**Project:** INNOVA Computers BD (`innova-web`)  
**Status:** **PLANNING ONLY — PENDING OWNER APPROVAL** (Zero code implementation executed)  
**Deliverable File:** `docs/modernization/PHASE_2_7_2_READINESS_ASSESSMENT_AND_PLAN.md`

---

## 1. Executive Summary & Authoritative Scope Confirmation

In accordance with the modernization roadmap ([`MODULE_API_REACT_MIGRATION_MAP.md`](file:///c:/wamp64/www/innova-web/docs/modernization/MODULE_API_REACT_MIGRATION_MAP.md#L92-L95)) and the Phase 2.7 architecture baseline ([`PHASE_2_7_READINESS_ASSESSMENT.md`](file:///c:/wamp64/www/innova-web/docs/modernization/PHASE_2_7_READINESS_ASSESSMENT.md#L30-L33)), **Phase 2.7.2** is strictly dedicated to:

1. **Capital Investment Withdrawal APIs** (`investment_withdraws` table, `InvestmentWithdraw` model).
2. **Shareholder Dividend Withdrawal APIs** (`dividend_withdraws` table, `DividendWithdraw` model).

### Strictly Out of Scope for Phase 2.7.2:
- Bank loans and EMI installment repayment schedules (Phase 2.7.3).
- ASSET / SEIP government training project modules (Phase 2.7.4).
- React frontend components or screens (Phase 3).
- MySQL schema DDL, table drops, or production migrations (Owner Decision Gates).

---

## 2. Legacy Architecture & Codebase Inspection

### 2.1 Entity & Schema Catalog (Verified against MySQL `icbd_web`)

| Entity | Model Path | Database Table | Engine | Live Rows | Key Attributes & Foreign Keys |
| :--- | :--- | :--- | :--- | :---: | :--- |
| **Capital Withdrawal** | [`App\Models\InvestmentWithdraw`](file:///c:/wamp64/www/innova-web/app/Models/InvestmentWithdraw.php) | `investment_withdraws` | MyISAM | 11 | `shareholder_id` $\rightarrow$ `shareholders.id`<br>`requested_by`, `processed_by` $\rightarrow$ `admins.id`<br>`amount`: `decimal(15,2)`<br>`status`: `varchar(191)` default `'pending'` |
| **Dividend Withdrawal** | [`App\Models\DividendWithdraw`](file:///c:/wamp64/www/innova-web/app/Models/DividendWithdraw.php) | `dividend_withdraws` | MyISAM | 1 | `shareholder_id` $\rightarrow$ `shareholders.id`<br>`requested_by`, `processed_by` $\rightarrow$ `admins.id`<br>`amount`: `decimal(15,2)`<br>`status`: `varchar(191)` default `'pending'` |

### 2.2 Live Column Structure
Direct read-only inspection of MySQL `information_schema.COLUMNS` on `icbd_web` verified that both tables have an identical 20-column schema:

```sql
id                  bigint unsigned      NOT NULL AUTO_INCREMENT PRIMARY KEY
shareholder_id      bigint unsigned      NULL
amount              decimal(15,2)        NOT NULL DEFAULT 0.00
withdraw_date       date                 NULL
method              varchar(191)         NULL
branch_name         varchar(191)         NULL
receiver_name       varchar(191)         NULL
pay_by              varchar(191)         NULL
account_number      varchar(191)         NULL
status              varchar(191)         NOT NULL DEFAULT 'pending'
requested_by        bigint unsigned      NULL
requested_at        timestamp            NULL
processed_by        bigint unsigned      NULL
processed_at        timestamp            NULL
processed_remarks   text                 NULL
remarks             text                 NULL
attachment          varchar(191)         NULL
created_at          timestamp            NULL
updated_at          timestamp            NULL
deleted_at          timestamp            NULL
```

### 2.3 Legacy Controllers & Route Inventory
- **Investment Withdrawals Controller:** [`app/Http/Controllers/Admin/InvestmentWithdrawController.php`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/InvestmentWithdrawController.php) (267 lines)
- **Dividend Withdrawals Controller:** [`app/Http/Controllers/Admin/DividendWithdrawController.php`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/DividendWithdrawController.php) (260 lines)
- **Legacy Routes in [`routes/admin.php`](file:///c:/wamp64/www/innova-web/routes/admin.php#L297-L329):**
  - Prefix `admin/investment-withdraw`: `index`, `data`, `create`, `store`, `show`, `edit`, `update`, `destroy`, `approve`, `reject`.
  - Prefix `admin/dividend-withdraw`: `index`, `data`, `create`, `store`, `show`, `edit`, `update`, `destroy`, `approve`, `reject`.
  - All routes protected by `auth:admin` session middleware.

---

## 3. Business Logic, State Machine & Financial Rules

### 3.1 Three-State Withdrawal Lifecycle
Both withdrawal entities operate on a strict state machine:
```
           [ Admin Submission ]
                    │
                    ▼
           ┌─────────────────┐
           │     PENDING     │  ◄── Editable, Deletable
           └────────┬────────┘      (No financial balance deduction)
                    │
         ┌──────────┴──────────┐
         ▼                     ▼
┌─────────────────┐   ┌─────────────────┐
│    APPROVED     │   │    REJECTED     │
└─────────────────┘   └─────────────────┘
  (Capital Deducted     (No deduction,
   Audit Logged,         Audit Logged,
   Immutable)            Immutable)
```

1. **Submission (`store`):**
   - Default status: `'pending'`.
   - `requested_by` automatically assigned to the authenticated admin ID (`auth()->id()`).
   - `requested_at` automatically assigned to current timestamp (`now()`).
2. **Approval (`approve`):**
   - Status transitions from `'pending'` to `'approved'`.
   - `processed_by` assigned to authenticated admin ID (`auth()->id()`).
   - `processed_at` assigned to current timestamp (`now()`).
   - `processed_remarks` logged from request payload.
3. **Rejection (`reject`):**
   - Status transitions from `'pending'` to `'rejected'`.
   - `processed_by` assigned to authenticated admin ID (`auth()->id()`).
   - `processed_at` assigned to current timestamp (`now()`).
   - `processed_remarks` logged from request payload.

### 3.2 Fundamental Business Rule Distinction
- **Capital Withdrawals (`investment_withdraws`):**
  - **Direct Impact on Capital Ledger:** Approved records are summed in `Shareholder::getOutstandingBalanceAttribute()` and credited as withdrawals in [`ShareholderApiController::statement()`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Api/V1/ShareholderApiController.php#L225).
  - **Capital Balance Safeguard:** Approval **MUST BE BLOCKED** with `422 Unprocessable Entity` if the withdrawal amount exceeds the shareholder's current active capital balance:
    $$\text{Projected Balance} = \text{Current Outstanding Balance} - \text{Withdrawal Amount} \ge 0.00$$
- **Dividend Withdrawals (`dividend_withdraws`):**
  - **Profit Distribution Only:** Dividend payouts represent corporate profit distributions, **NOT** capital returns. They do **not** reduce invested capital or alter the capital statement running balance.
  - They operate in an independent dividend disbursement ledger for shareholder distributions.

### 3.3 State Immutability & Modification Guards
- **Pending Records:** Full edit (`PUT`) and deletion (`DELETE`) permitted.
- **Approved Records:**
  - Cannot be edited or re-approved.
  - Cannot be deleted if deletion would violate referential integrity or historical auditing (or requires explicit super-admin override).
- **Rejected Records:**
  - Cannot be edited or re-rejected.
  - Can be deleted or retained for audit history.

---

## 4. Financial Precision Strategy (BCMath)

To maintain absolute parity with Phase 2.7.1 standards:
1. **Input Normalization:** Comma-separated strings (e.g. `'50,000.00'`) are stripped in Form Requests via `prepareForValidation()`.
2. **Numeric Validation:** `amount` rule: `required|numeric|min:0.01`.
3. **Storage Format:** Standardized decimal string `bcadd($cleanAmount, '0', 2)`.
4. **Balance Verification:**
   ```php
   $projectedBalance = bcsub($currentBalanceStr, $withdrawalAmountStr, 2);
   if (bccomp($projectedBalance, '0.00', 2) < 0) {
       return $this->error('Cannot approve withdrawal: Shareholder outstanding capital balance would become negative (' . (float)$projectedBalance . ').', 422);
   }
   ```
5. **Zero-Balance Allowance:** Exact zero balances (`bccomp('0.00', '0.00', 2) === 0`) are valid and permitted.

---

## 5. Detailed API Endpoint Specifications

All endpoints will be exposed under `/api/v1/withdrawals/` with Sanctum authentication and admin identity middleware.

### 5.1 Capital Investment Withdrawals

| HTTP Verb | Route | Handler Action | Description |
| :--- | :--- | :--- | :--- |
| `GET` | `/api/v1/withdrawals/investment` | `InvestmentWithdrawApiController@index` | List capital withdrawal requests (filters: `shareholder_id`, `status`, `start_date`, `end_date`, `per_page`) |
| `POST` | `/api/v1/withdrawals/investment` | `InvestmentWithdrawApiController@store` | Submit new capital withdrawal request (defaults to status: `'pending'`) |
| `GET` | `/api/v1/withdrawals/investment/{id}` | `InvestmentWithdrawApiController@show` | View details of single capital withdrawal request with relations |
| `PUT` | `/api/v1/withdrawals/investment/{id}` | `InvestmentWithdrawApiController@update` | Update pending capital withdrawal request |
| `DELETE` | `/api/v1/withdrawals/investment/{id}` | `InvestmentWithdrawApiController@destroy` | Soft-delete withdrawal request (blocked if approved and balance violated) |
| `POST` | `/api/v1/withdrawals/investment/{id}/approve` | `InvestmentWithdrawApiController@approve` | Approve capital withdrawal (enforces capital balance integrity check) |
| `POST` | `/api/v1/withdrawals/investment/{id}/reject` | `InvestmentWithdrawApiController@reject` | Reject capital withdrawal request (with remarks) |

### 5.2 Shareholder Dividend Withdrawals

| HTTP Verb | Route | Handler Action | Description |
| :--- | :--- | :--- | :--- |
| `GET` | `/api/v1/withdrawals/dividend` | `DividendWithdrawApiController@index` | List dividend withdrawal requests (filters: `shareholder_id`, `status`, `start_date`, `end_date`, `per_page`) |
| `POST` | `/api/v1/withdrawals/dividend` | `DividendWithdrawApiController@store` | Submit new dividend withdrawal request (defaults to status: `'pending'`) |
| `GET` | `/api/v1/withdrawals/dividend/{id}` | `DividendWithdrawApiController@show` | View details of single dividend withdrawal request with relations |
| `PUT` | `/api/v1/withdrawals/dividend/{id}` | `DividendWithdrawApiController@update` | Update pending dividend withdrawal request |
| `DELETE` | `/api/v1/withdrawals/dividend/{id}` | `DividendWithdrawApiController@destroy` | Soft-delete dividend withdrawal request |
| `POST` | `/api/v1/withdrawals/dividend/{id}/approve` | `DividendWithdrawApiController@approve` | Approve dividend withdrawal request (with remarks) |
| `POST` | `/api/v1/withdrawals/dividend/{id}/reject` | `DividendWithdrawApiController@reject` | Reject dividend withdrawal request (with remarks) |

---

## 6. Implementation Step-by-Step Plan

When explicitly approved by the owner, the implementation will proceed through the following non-disruptive steps:

### Step 1: Create Form Requests
- `app/Http/Requests/Api/V1/StoreInvestmentWithdrawRequest.php`: Validates `shareholder_id`, comma-stripped `amount` (`min:0.01`), `withdraw_date`, `method`, `receiver_name`, `branch_name`, `account_number`, `remarks`, `pay_by`.
- `app/Http/Requests/Api/V1/UpdateInvestmentWithdrawRequest.php`: Same rules with `sometimes`.
- `app/Http/Requests/Api/V1/ProcessWithdrawRequest.php`: Validates `remarks` (`nullable|string|max:1000`).
- `app/Http/Requests/Api/V1/StoreDividendWithdrawRequest.php`: Validates dividend withdrawal parameters.
- `app/Http/Requests/Api/V1/UpdateDividendWithdrawRequest.php`: Same rules with `sometimes`.

### Step 2: Create API Controllers
- `app/Http/Controllers/Api/V1/InvestmentWithdrawApiController.php`: Implements 7 actions (`index`, `store`, `show`, `update`, `destroy`, `approve`, `reject`) utilizing `ApiController` base envelope and BCMath balance checks.
- `app/Http/Controllers/Api/V1/DividendWithdrawApiController.php`: Implements 7 actions for dividend payouts.

### Step 3: Register API Routes
Add the 14 new routes to [`routes/api.php`](file:///c:/wamp64/www/innova-web/routes/api.php) inside the existing `['auth:sanctum', 'admin.identity']` middleware group.

### Step 4: Author Comprehensive Test Suite
Create `tests/Feature/Api/V1/WithdrawalApiTest.php` running exclusively on isolated in-memory SQLite (`:memory:`):
- Authentication & admin identity boundary enforcement (401 & 403).
- Submission lifecycle (defaults to `'pending'`, auto-populates `requested_by` & `requested_at`).
- Capital balance validation: Approving withdrawal exceeding outstanding balance returns 422.
- Successful approval: Deducts from statement and shareholder summary.
- Rejection: Excluded from statement and summary.
- Immutability: Editing approved/rejected records blocked.
- Exact `0.00` balance settlement and `-0.01` overdraft detection.
- Comma-formatted amount inputs.
- Dividend withdrawal lifecycle and independence from capital ledger.

---

## 7. Safety & Isolation Commitments

1. **Zero Database Mutation:** No migrations, DDL, seeders, or write queries will be executed against the configured MySQL database `icbd_web`.
2. **Isolated SQLite Test Environment:** All test executions will run exclusively on `:memory:` SQLite, verified prior to each test run.
3. **Configuration Preservation:** `.env`, production config, and payment gateway configs remain 100% untouched.
4. **Preservation of Existing Work:** Uncommitted changes across all modules will be strictly preserved.
5. **No Speculative Coding:** Zero implementation code will be written until the owner reviews and explicitly approves this plan.

---

## 8. Explicit Stop Condition

**This document represents the readiness assessment and implementation plan only.**  
**Phase 2.7.2 implementation has NOT started.** Execution is halted awaiting explicit owner review and approval.
