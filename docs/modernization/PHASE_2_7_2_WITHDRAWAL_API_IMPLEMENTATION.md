# Phase 2.7.2 Implementation & Verification Report
## Investment Withdrawal & Dividend Withdrawal APIs

**Document Version:** 1.0.0  
**Execution Date:** 2026-10-24  
**Project:** INNOVA Computers BD (`innova-web`)  
**Phase Status:** **COMPLETE & VERIFIED (PASS WITH LIMITATIONS)**  
**Target Architecture Baseline:** Laravel 8.83.29, PHP 8.2.0, Sanctum Bearer Auth, BCMath Scale 2  
**Deliverable File:** `docs/modernization/PHASE_2_7_2_WITHDRAWAL_API_IMPLEMENTATION.md`  

---

## 1. Executive Summary

In strict accordance with the approved planning document ([`PHASE_2_7_2_READINESS_ASSESSMENT_AND_PLAN.md`](file:///c:/wamp64/www/innova-web/docs/modernization/PHASE_2_7_2_READINESS_ASSESSMENT_AND_PLAN.md)) and the master modernization roadmap ([`MODULE_API_REACT_MIGRATION_MAP.md`](file:///c:/wamp64/www/innova-web/docs/modernization/MODULE_API_REACT_MIGRATION_MAP.md)), **Phase 2.7.2** has been implemented, validated, and documented.

All 14 planned RESTful endpoints covering capital investment withdrawals and shareholder dividend withdrawals have been deployed under `/api/v1/withdrawals/`. Both modules strictly enforce administrator identity authentication (`auth:sanctum` and `EnsureAdminIdentity`), server-managed 3-state lifecycles (`pending` $\rightarrow$ `approved` | `rejected`), decimal-accurate capital balance verifications via BCMath at scale 2, atomic conditional updates to prevent duplicate processing, and strict architectural separation between capital repayments and corporate dividend profit payouts.

All automated tests executed exclusively in an isolated in-memory SQLite environment (`:memory:`), guaranteeing zero mutations or writes to the configured live MySQL database (`icbd_web`).

---

## 2. Implemented Endpoints & Route Specifications

All 14 endpoints are registered in [`routes/api.php`](file:///c:/wamp64/www/innova-web/routes/api.php#L355-L392) under the versioned prefix `/api/v1` and protected by the middleware stack `['auth:sanctum', 'admin.identity']`.

### 2.1 Capital Investment Withdrawals (`/api/v1/withdrawals/investment`)

| HTTP Verb | Route Path | Action / Handler | Route Name | Purpose |
| :--- | :--- | :--- | :--- | :--- |
| `GET` | `/api/v1/withdrawals/investment` | [`InvestmentWithdrawApiController@index`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Api/V1/InvestmentWithdrawApiController.php#L32) | `api.v1.withdrawals.investment.index` | Paginated listing of investment withdrawals with filters (`shareholder_id`, `status`, `start_date`, `end_date`, `search`) |
| `POST` | `/api/v1/withdrawals/investment` | [`InvestmentWithdrawApiController@store`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Api/V1/InvestmentWithdrawApiController.php#L95) | `api.v1.withdrawals.investment.store` | Create withdrawal request (server forces `status = 'pending'`, assigns `requested_by` & `requested_at`) |
| `GET` | `/api/v1/withdrawals/investment/{id}` | [`InvestmentWithdrawApiController@show`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Api/V1/InvestmentWithdrawApiController.php#L137) | `api.v1.withdrawals.investment.show` | View withdrawal request with shareholder, requester, and processor relations |
| `PUT` | `/api/v1/withdrawals/investment/{id}` | [`InvestmentWithdrawApiController@update`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Api/V1/InvestmentWithdrawApiController.php#L167) | `api.v1.withdrawals.investment.update` | Update pending request (blocked with `409 Conflict` if non-pending) |
| `DELETE` | `/api/v1/withdrawals/investment/{id}` | [`InvestmentWithdrawApiController@destroy`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Api/V1/InvestmentWithdrawApiController.php#L215) | `api.v1.withdrawals.investment.destroy` | Soft-delete pending or rejected request (blocked with `409 Conflict` if approved) |
| `POST` | `/api/v1/withdrawals/investment/{id}/approve` | [`InvestmentWithdrawApiController@approve`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Api/V1/InvestmentWithdrawApiController.php#L249) | `api.v1.withdrawals.investment.approve` | Approve request: validates capital balance with BCMath, prevents overdraft, updates status atomically |
| `POST` | `/api/v1/withdrawals/investment/{id}/reject` | [`InvestmentWithdrawApiController@reject`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Api/V1/InvestmentWithdrawApiController.php#L313) | `api.v1.withdrawals.investment.reject` | Reject request: logs remarks, updates status atomically, leaves balance untouched |

### 2.2 Shareholder Dividend Withdrawals (`/api/v1/withdrawals/dividend`)

| HTTP Verb | Route Path | Action / Handler | Route Name | Purpose |
| :--- | :--- | :--- | :--- | :--- |
| `GET` | `/api/v1/withdrawals/dividend` | [`DividendWithdrawApiController@index`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Api/V1/DividendWithdrawApiController.php#L30) | `api.v1.withdrawals.dividend.index` | Paginated listing of dividend withdrawals with filters |
| `POST` | `/api/v1/withdrawals/dividend` | [`DividendWithdrawApiController@store`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Api/V1/DividendWithdrawApiController.php#L93) | `api.v1.withdrawals.dividend.store` | Create dividend withdrawal request (defaults to `pending`) |
| `GET` | `/api/v1/withdrawals/dividend/{id}` | [`DividendWithdrawApiController@show`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Api/V1/DividendWithdrawApiController.php#L135) | `api.v1.withdrawals.dividend.show` | View dividend request details with relations |
| `PUT` | `/api/v1/withdrawals/dividend/{id}` | [`DividendWithdrawApiController@update`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Api/V1/DividendWithdrawApiController.php#L165) | `api.v1.withdrawals.dividend.update` | Update pending dividend request |
| `DELETE` | `/api/v1/withdrawals/dividend/{id}` | [`DividendWithdrawApiController@destroy`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Api/V1/DividendWithdrawApiController.php#L213) | `api.v1.withdrawals.dividend.destroy` | Soft-delete dividend request (blocked if approved) |
| `POST` | `/api/v1/withdrawals/dividend/{id}/approve` | [`DividendWithdrawApiController@approve`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Api/V1/DividendWithdrawApiController.php#L244) | `api.v1.withdrawals.dividend.approve` | Approve dividend payout (does NOT reduce capital balance or alter capital statements) |
| `POST` | `/api/v1/withdrawals/dividend/{id}/reject` | [`DividendWithdrawApiController@reject`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Api/V1/DividendWithdrawApiController.php#L291) | `api.v1.withdrawals.dividend.reject` | Reject dividend request with remarks |

---

## 3. Files Created or Modified

### 3.1 Form Request Validators Created (`app/Http/Requests/Api/V1/`)
- [`StoreInvestmentWithdrawRequest.php`](file:///c:/wamp64/www/innova-web/app/Http/Requests/Api/V1/StoreInvestmentWithdrawRequest.php): Enforces `shareholder_id` (`exists:shareholders,id`), sanitized `amount` (`numeric|min:0.01`), date, string lengths, and comma stripping.
- [`UpdateInvestmentWithdrawRequest.php`](file:///c:/wamp64/www/innova-web/app/Http/Requests/Api/V1/UpdateInvestmentWithdrawRequest.php): Partial updates with `sometimes` validation rules and comma sanitization.
- [`StoreDividendWithdrawRequest.php`](file:///c:/wamp64/www/innova-web/app/Http/Requests/Api/V1/StoreDividendWithdrawRequest.php): Validates dividend payout submissions.
- [`UpdateDividendWithdrawRequest.php`](file:///c:/wamp64/www/innova-web/app/Http/Requests/Api/V1/UpdateDividendWithdrawRequest.php): Validates pending dividend modifications.
- [`ProcessWithdrawRequest.php`](file:///c:/wamp64/www/innova-web/app/Http/Requests/Api/V1/ProcessWithdrawRequest.php): Validates `remarks` (`nullable|string|max:1000`) for approval and rejection workflows.

### 3.2 API Controllers Created (`app/Http/Controllers/Api/V1/`)
- [`InvestmentWithdrawApiController.php`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Api/V1/InvestmentWithdrawApiController.php): Core capital withdrawal controller implementing 7 REST actions, BCMath balance validation, overdraft prevention, and atomic conditional updates.
- [`DividendWithdrawApiController.php`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Api/V1/DividendWithdrawApiController.php): Dividend disbursement controller implementing 7 REST actions, ensuring complete isolation from capital equity accounts.

### 3.3 Routing & Regression Files
- [`routes/api.php`](file:///c:/wamp64/www/innova-web/routes/api.php#L355-L392): Registered all 14 routes in the Sanctum/admin middleware group.
- [`tests/Feature/Api/V1/WithdrawalApiTest.php`](file:///c:/wamp64/www/innova-web/tests/Feature/Api/V1/WithdrawalApiTest.php): 28 automated feature tests validating all endpoints and edge cases.

---

## 4. State Machine & Workflow Rules

Both withdrawal entities follow a strict 3-state transition model:

```
           [ Administrator Submission ]
                        │
                        ▼
               ┌─────────────────┐
               │     PENDING     │  ◄── Allowed: PUT (edit), DELETE (soft delete)
               └────────┬────────┘      Excluded from capital deduction
                        │
             ┌──────────┴──────────┐
             ▼                     ▼
    ┌─────────────────┐   ┌─────────────────┐
    │    APPROVED     │   │    REJECTED     │
    └─────────────────┘   └─────────────────┘
      (Capital Deducted,    (No deduction,
       Processed Logged,     Processed Logged,
       Immutable)            Immutable)
```

1. **Submission:**
   - Any client-submitted `status`, `requested_by`, `requested_at`, `processed_by`, or `processed_at` is discarded.
   - Status defaults to `pending`.
   - `requested_by` is set to `auth()->id()`.
   - `requested_at` is set to current server timestamp `Carbon::now()`.

2. **Approval:**
   - Only records currently in `status = 'pending'` may be approved. Attempting to approve an already approved or rejected record returns `409 Conflict`.
   - For investment withdrawals, available capital balance is recalculated immediately. If `amount > available_balance`, returns `422 Unprocessable Entity`.
   - On approval, status changes to `approved`, `processed_by` is set to `auth()->id()`, `processed_at` is set to server clock, and `processed_remarks` are recorded.
   - Once approved, the record cannot be edited, re-approved, or deleted (`409 Conflict`).

3. **Rejection:**
   - Only records currently in `status = 'pending'` may be rejected.
   - Status changes to `rejected`, `processed_by` and `processed_at` are recorded.
   - Rejected records are never deducted from capital balances and cannot be re-processed.

---

## 5. Financial Precision & BCMath Balance Safety

### 5.1 Decimal Arithmetic Precision
All financial arithmetic strictly uses BCMath at `scale = 2`:
- Amounts with commas (e.g. `'50,000.00'`) are sanitized to standard numeric strings (`'50000.00'`).
- The available active capital balance is computed as:
  $$\text{Available Balance} = \text{Total Active Investments} - \text{Total Approved Capital Withdrawals}$$
- BCMath calculations:
  ```php
  $currentBalance = $this->calculateAvailableCapitalBalance((int) $withdraw->shareholder_id);
  $withdrawAmount = is_numeric($cleanAmount) ? bcadd($cleanAmount, '0', 2) : '0.00';
  $projectedBalance = bcsub($currentBalance, $withdrawAmount, 2);

  if (bccomp($projectedBalance, '0.00', 2) < 0) {
      return $this->error("Cannot approve withdrawal: Shareholder active capital balance ({$currentBalance}) is insufficient for withdrawal amount ({$withdrawAmount}). Resulting balance would be {$projectedBalance}.", 422);
  }
  ```

### 5.2 Balance Boundaries Verified by Automated Tests
1. **Sufficient Balance:** Withdrawal approved without issue.
2. **Exact-Zero Balance:** When `withdrawAmount == currentBalance`, `projectedBalance == '0.00'`, which is permitted (`bccomp >= 0`).
3. **One-Cent Overdraft:** When `withdrawAmount == currentBalance + 0.01`, `projectedBalance == '-0.01'`, triggering an immediate `422 Unprocessable Entity` response.
4. **Statement Reconciliation:** Approved capital withdrawals appear in [`ShareholderApiController@statement`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Api/V1/ShareholderApiController.php#L191) with running balance deductions, whereas pending and rejected withdrawals are excluded.

### 5.3 Dividend Withdrawal Isolation
Shareholder dividend withdrawals represent profit distributions from operational surpluses.
- Dividend payouts do **not** debit shareholder invested equity.
- They do **not** appear in capital ledger statements or balance summaries.
- They cannot cause capital balance overdrafts.

---

## 6. Concurrency, Idempotency & MyISAM Engine Limitations

### 6.1 Implemented Safeguards
Legacy tables `investment_withdraws` and `dividend_withdraws` use the MySQL **MyISAM** storage engine. Because MyISAM lacks ACID transaction rollbacks and row-level locks (`SELECT ... FOR UPDATE`), the following architectural safeguards were implemented:

1. **State Re-verification:** The record's state and current balance are re-fetched immediately before processing.
2. **Conditional Atomic Updates:** The status transition SQL is executed as:
   ```sql
   UPDATE investment_withdraws 
   SET status = 'approved', processed_by = ?, processed_at = ?, processed_remarks = ?, updated_at = ?
   WHERE id = ? AND status = 'pending';
   ```
3. **Affected Row Count Verification:** The application strictly inspects the update statement's affected row count. If affected rows $\ne 1$, another thread or administrator has already transitioned the record, and the controller immediately halts with `409 Conflict`.
4. **Idempotency:** A withdrawal request cannot be counted more than once in the capital statement because the statement query groups by record and only filters `whereIn('status', ['approved', '1'])`.

### 6.2 Explicit MyISAM Concurrency Limitation
> [!WARNING]
> **MyISAM Cross-Request Overspending Race Condition:**
> While conditional atomic updates prevent duplicate approvals of the *same* record, MyISAM table mechanics cannot guarantee serialization across *two different* withdrawal requests submitted for the *same shareholder* in simultaneous concurrent threads.
> 
> If two requests of 50,000 BDT are simultaneously approved for a shareholder who has an available balance of 50,000 BDT, both threads might compute `projectedBalance = 0.00` before either update takes effect. Because MyISAM does not support row-level locks across statements without table-level locking (`LOCK TABLES investment_withdraws WRITE`), cross-request balance overspending cannot be 100% prevented under extreme simultaneous concurrency.
> 
> **Recommendation:** This limitation is inherent to the legacy MyISAM storage engine. During the eventual PostgreSQL/InnoDB migration, row-level transactional locking (`SELECT ... FOR UPDATE` inside `DB::transaction()`) should be added to ensure absolute cross-request serialization.

---

## 7. Automated Test Suite & Isolation Evidence

### 7.1 Test Isolation Verification
All tests inherit from a custom `setUp()` harness verifying the database connection prior to execution:
```php
$connection = DB::connection();
if ($connection->getDriverName() !== 'sqlite' || $connection->getDatabaseName() !== ':memory:') {
    $this->fail('CRITICAL SAFETY CHECK: Test is not running on an isolated SQLite database!');
}
```

### 7.2 Executed Test Suites & Results

#### 1. Phase 2.7.2 Withdrawal API Test Suite
- **Command:** `php vendor/bin/phpunit tests/Feature/Api/V1/WithdrawalApiTest.php`
- **Tests Executed:** 28
- **Assertions:** 133
- **Result:** **100% PASS (0 failures, 0 errors)**

Test scenarios covered:
- Unauthenticated requests rejected with 401 across all 14 routes.
- Student / non-admin user tokens forbidden with 403.
- Capital withdrawal request creation with server-managed pending status and audit fields.
- Client attempt to spoof status or audit fields ignored.
- List with status, date range, and text search filters.
- Detailed show endpoint with shareholder, requester, and processor relations.
- Modifying pending requests permitted; non-pending modification rejected with 409.
- Deleting pending or rejected requests permitted; deleting approved rejected with 409.
- Approving withdrawal exceeding available balance rejected with 422.
- Approving withdrawal with one-cent overdraft (-0.01) rejected with 422.
- Approving withdrawal bringing balance to exactly 0.00 permitted.
- Approved withdrawal reflected in shareholder statement and summary.
- Rejected withdrawal excluded from statement and capital deductions.
- Duplicate approval attempts rejected with 409.
- Dividend withdrawal creation, listing, showing, updating, and deleting.
- Dividend approval does NOT reduce capital balance or appear in capital statements.
- Dividend rejection preserves audit trails.
- Soft-deleted records excluded from queries and approval endpoints.

#### 2. Phase 2.7.1 Shareholders & Capital Ledger Regression Suite
- **Command:** `php vendor/bin/phpunit tests/Feature/Api/V1/ShareholderCapitalApiTest.php`
- **Tests Executed:** 30
- **Assertions:** 194
- **Result:** **100% PASS (0 failures, 0 errors)**

---

## 8. Verification of Safety Constraints

1. **MySQL Database Integrity:** Zero queries, migrations, seeders, or DDL commands were run against `icbd_web`.
2. **Environment & Server Configuration:** `.env`, payment configurations, SMS gateways, and production credentials remain untouched.
3. **Legacy Compatibility:** All legacy table names (`investment_withdraws`, `dividend_withdraws`, `invesments`, `shareholders`) and column structures were preserved without modifications.
4. **Scope Discipline:** No Phase 2.7.3 (Bank Loans/EMI), Phase 2.7.4 (ASSET/SEIP), or React frontend work was performed.

---

## 9. Sign-off & Next Steps

Phase 2.7.2 is fully implemented, thoroughly tested, and ready for owner review.

**Recommended Next Step:**
Upon owner review and formal approval of Phase 2.7.2, proceed to the readiness assessment and implementation of **Phase 2.7.3: Bank Loan & EMI Installment APIs**.
