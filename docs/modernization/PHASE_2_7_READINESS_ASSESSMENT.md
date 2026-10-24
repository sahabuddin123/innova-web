# Phase 2.7 — Scope Confirmation & Readiness Assessment
## Shareholders, Loans & Asset Project APIs

**Project:** INNOVA Computers BD (`innova-web`)  
**Status:** READINESS ASSESSMENT ONLY (Pre-Implementation Gate)  
**Date:** October 2026  
**Document Reference:** `docs/modernization/PHASE_2_7_READINESS_ASSESSMENT.md`  

---

## 1. Authoritative Scope Confirmation

### 1.1 Roadmap Hierarchy & Document Alignment
According to the authoritative modernization roadmap [`docs/modernization/MODULE_API_REACT_MIGRATION_MAP.md`](file:///c:/wamp64/www/innova-web/docs/modernization/MODULE_API_REACT_MIGRATION_MAP.md#L54-L55) and the system architecture baseline [`docs/modernization/CURRENT_SYSTEM_ARCHITECTURE.md`](file:///c:/wamp64/www/innova-web/docs/modernization/CURRENT_SYSTEM_ARCHITECTURE.md#L155-L170), Phase 2.7 covers:

```
[Phase 2.7: Shareholders, Loans & Asset Project]
   └── Capital ledger, dividend records, bank loans, EMI tracking, grant trainee records
```

This consolidates the legacy functional areas formerly categorized under:
- **Module 7: Shareholder Capital, Investments & Loans** (`shareholders`, `invesments`, `investment_withdraws`, `dividend_withdraws`, `bank_loans`, `emi_installments`).
- **Module 8: Government / Training Project (Asset / SEIP)** (`asset_courses`, `asset_registrations`, `asset_registration_feedbacks`).

### 1.2 In-Scope Components
1. **Shareholder Profiles & Capital Contributions**:
   - Shareholder directory CRUD (`shareholders`).
   - Capital investments and deposit records (`invesments`).
   - Running ledger statement calculations (deposits vs. approved withdrawals, running balance).
2. **Capital & Dividend Withdrawal Requests**:
   - Capital investment withdrawals (`investment_withdraws`) with multi-state approval/rejection lifecycle.
   - Dividend payout withdrawals (`dividend_withdraws`) with multi-state approval/rejection lifecycle.
3. **Institutional Bank Loans & EMI Repayments**:
   - Bank loan portfolio management (`bank_loans`).
   - Loan amortization, interest computation, remaining balance, and savings calculations.
   - Scheduled monthly installment repayments (`emi_installments`).
   - Installment settlement (`mark-paid`) and payment tracking.
4. **ASSET Government Skill Training Project**:
   - Specialized grant courses (`asset_courses`).
   - Trainee intake lead pipeline and public registration submission (`asset_registrations`).
   - Trainee candidate qualification workflow (status transitions and call tracking).
   - Multi-step recruitment feedback logging (`asset_registration_feedbacks`).

---

## 2. Legacy Architecture & Business-Rule Inventory

### 2.1 Entity & Model Catalog

| Legacy Model | Database Table | Engine (MySQL) | Migration Status | Live Records | Core Relationships |
| :--- | :--- | :--- | :--- | :--- | :--- |
| [`Shareholder`](file:///c:/wamp64/www/innova-web/app/Models/Shareholder.php) | `shareholders` | InnoDB | `2023_04_27_130942_create_shareholders_table.php` | 6 rows | HasMany `Invesments`, HasMany `BankLoan`, HasMany `InvestmentWithdraw`, HasMany `DividendWithdraw` |
| [`Invesments`](file:///c:/wamp64/www/innova-web/app/Models/Invesments.php) | `invesments` | InnoDB | `2023_04_27_130952_create_invesments_table.php` | 46 rows | BelongsTo `Shareholder` |
| [`InvestmentWithdraw`](file:///c:/wamp64/www/innova-web/app/Models/InvestmentWithdraw.php) | `investment_withdraws` | **MyISAM** | **NONE** (Unmigrated in legacy code) | 11 rows | BelongsTo `Shareholder`, BelongsTo `Admin` (requested_by, processed_by) |
| [`DividendWithdraw`](file:///c:/wamp64/www/innova-web/app/Models/DividendWithdraw.php) | `dividend_withdraws` | **MyISAM** | **NONE** (Unmigrated in legacy code) | 1 row | BelongsTo `Shareholder`, BelongsTo `Admin` (requested_by, processed_by) |
| [`BankLoan`](file:///c:/wamp64/www/innova-web/app/Models/BankLoan.php) | `bank_loans` | **MyISAM** | **NONE** (Unmigrated in legacy code) | 7 rows | BelongsTo `Shareholder`, BelongsTo `Admin` (created_by), HasMany `EmiInstallment` |
| [`EmiInstallment`](file:///c:/wamp64/www/innova-web/app/Models/EmiInstallment.php) | `emi_installments` | **MyISAM** | **NONE** (Unmigrated in legacy code) | 71 rows | BelongsTo `BankLoan`, BelongsTo `Shareholder`, BelongsTo `Admin` (paid_by, received_by) |
| [`AssetCourse`](file:///c:/wamp64/www/innova-web/app/Models/AssetCourse.php) | `asset_courses` | **MyISAM** | `2026_05_20_000300_create_asset_courses_table.php` | 2 rows | HasMany `AssetRegistration` (on `course` name) |
| [`AssetRegistration`](file:///c:/wamp64/www/innova-web/app/Models/AssetRegistration.php) | `asset_registrations` | **MyISAM** | `2026_05_20_000100_create_asset_registrations_table.php` | 31 rows | BelongsTo `AssetCourse` (on string `course`), HasMany `AssetRegistrationFeedback` |
| [`AssetRegistrationFeedback`](file:///c:/wamp64/www/innova-web/app/Models/AssetRegistrationFeedback.php) | `asset_registration_feedbacks` | **MyISAM** | `2026_05_20_000700_create_asset_registration_feedbacks_table.php` | 5 rows | BelongsTo `AssetRegistration` |

### 2.2 Financial Calculations & Core Business Rules

#### A. Shareholder Capital & Outstanding Balance
As implemented in [`Shareholder.php`](file:///c:/wamp64/www/innova-web/app/Models/Shareholder.php#L48-L65):
1. **Total Active Investment**:
   $$\text{Total Investment} = \sum_{\text{isActive}=1} \text{Invesments.amount}$$
2. **Total Approved Withdrawals**:
   $$\text{Total Withdrawn} = \sum_{\text{status}='approved'} \text{InvestmentWithdraw.amount}$$
3. **Outstanding Shareholder Capital**:
   $$\text{Outstanding Balance} = \text{Total Investment} - \text{Total Withdrawn}$$

#### B. Investment Statement Running Ledger
As implemented in legacy [`InvesmentsController@statement`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/InvesmentsController.php#L167-L225):
- Chronological timeline merging:
  - **Deposits (Credits to capital)**: Sourced from `invesments` where `deleted_at IS NULL`.
  - **Withdrawals (Debits against capital)**: Sourced from `investment_withdraws` where `status = 'approved'` and `deleted_at IS NULL`.
- Records are sorted by transaction date, producing a ledger statement with a running balance:
  $$\text{Balance}_t = \text{Balance}_{t-1} + \text{Deposit}_t - \text{Withdrawal}_t$$

#### C. Bank Loan Amortization & Interest Formulas
As implemented in [`BankLoan.php`](file:///c:/wamp64/www/innova-web/app/Models/BankLoan.php#L84-L104):
1. **Simple Interest Calculation**:
   $$\text{Total Interest} = \frac{\text{loan\_amount} \times \text{interest\_rate} \times \left(\frac{\text{loan\_term\_months}}{12}\right)}{100}$$
2. **Total Loan Obligation**:
   $$\text{Total Payable} = \text{loan\_amount} + \text{Total Interest}$$
3. **Remaining EMI Debt**:
   $$\text{Remaining Debt} = \text{Total Payable} - \sum_{\text{status}='paid'} \text{EmiInstallment.emi\_amount}$$
4. **Total Cumulative Savings**:
   $$\text{Total Savings} = (\text{savings\_amount}_{\text{loan}} \text{ or } 0) + \sum_{\text{status}='paid'} \text{EmiInstallment.savings\_amount}$$

#### D. Withdrawal Request State Machine
In both [`InvestmentWithdrawController`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/InvestmentWithdrawController.php#L152-L265) and [`DividendWithdrawController`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/DividendWithdrawController.php#L228-L258):
- **Submission**: Initial record is created with `status = 'pending'`, capturing `requested_by = auth()->id()` and `requested_at = now()`.
- **Approval (`approve`)**: State transitions to `'approved'`. Sets `processed_by = auth()->id()`, `processed_at = now()`, and logs `processed_remarks`.
- **Rejection (`reject`)**: State transitions to `'rejected'`. Sets `processed_by = auth()->id()`, `processed_at = now()`, and logs `processed_remarks`.
- **Integrity Constraint**: Rejected or pending withdrawals do not reduce shareholder capital or affect statement balances.

#### E. EMI Installment Lifecycle
In [`EmiInstallmentController`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/EmiInstallmentController.php#L125-L205):
- Installments are scheduled with `status = 'pending'`.
- Settlement via `markPaid()` transitions status to `'paid'`, persists `paid_at`, updates `payment_date`, and attributes `received_by = auth()->id()`.

#### F. ASSET Project Trainee Qualification & Notification
In [`StudentManagementController`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/StudentManagementController.php#L79-L136):
- Supported `registration_status` enum:
  `['Pending', 'Contacted', 'Converted', 'Follow Up', 'Follow Up Later', 'Lost', 'Not Qualified', 'Qualified', 'Service', 'Wrong Number', 'Not Interested', 'Canceled', 'Don\'t Call Again']`.
- Supported `call_type` enum:
  `['1st call', '2nd call', '3rd call', '4th call', '5th call']`.
- Automated Action: When a candidate's status is updated to `'Qualified'`, if a valid phone number exists, an SMS message (`"আপনাকে সংক্ষিপ্ত তালিকাভুক্ত করা হয়েছে..."`) is triggered via `SMSController`.

---

## 3. Proposed API Scope & Endpoint Matrix

All endpoints will be exposed under `/api/v1/` and return consistent standardized JSON envelopes via `ApiController` (`success`, `data`, `message`, `errors`).

### 3.1 Shareholders & Capital Ledgers

| HTTP Verb | Endpoint | Legacy Mapping | Auth & Guard | Description |
| :--- | :--- | :--- | :--- | :--- |
| `GET` | `/api/v1/shareholders` | `ShareholderController@index` | `auth:sanctum`, `admin.identity` | List shareholders with calculated total investment & outstanding balance |
| `POST` | `/api/v1/shareholders` | `ShareholderController@store` | `auth:sanctum`, `admin.identity` | Create a new shareholder record |
| `GET` | `/api/v1/shareholders/{id}` | `ShareholderController@show` | `auth:sanctum`, `admin.identity` | View single shareholder profile with investment summaries |
| `PUT` | `/api/v1/shareholders/{id}` | `ShareholderController@update` | `auth:sanctum`, `admin.identity` | Update shareholder details |
| `DELETE` | `/api/v1/shareholders/{id}` | `ShareholderController@delete` | `auth:sanctum`, `admin.identity` | Soft-delete shareholder record |
| `GET` | `/api/v1/shareholders/{id}/statement` | `InvesmentsController@statement` | `auth:sanctum`, `admin.identity` | Full financial statement (deposits, withdrawals, running balance) |

### 3.2 Capital Investments

| HTTP Verb | Endpoint | Legacy Mapping | Auth & Guard | Description |
| :--- | :--- | :--- | :--- | :--- |
| `GET` | `/api/v1/investments` | `InvesmentsController@index` | `auth:sanctum`, `admin.identity` | List capital investment vouchers (filterable by `shareholder_id`) |
| `POST` | `/api/v1/investments` | `InvesmentsController@store` | `auth:sanctum`, `admin.identity` | Record a new capital investment deposit |
| `GET` | `/api/v1/investments/{id}` | `InvesmentsController@detail` | `auth:sanctum`, `admin.identity` | Show single investment voucher details |
| `PUT` | `/api/v1/investments/{id}` | `InvesmentsController@update` | `auth:sanctum`, `admin.identity` | Update investment voucher |
| `DELETE` | `/api/v1/investments/{id}` | `InvesmentsController@destroy` | `auth:sanctum`, `admin.identity` | Soft-delete investment voucher |

### 3.3 Investment & Dividend Withdrawals

| HTTP Verb | Endpoint | Legacy Mapping | Auth & Guard | Description |
| :--- | :--- | :--- | :--- | :--- |
| `GET` | `/api/v1/withdrawals/investment` | `InvestmentWithdrawController@index` | `auth:sanctum`, `admin.identity` | List investment withdrawal requests |
| `POST` | `/api/v1/withdrawals/investment` | `InvestmentWithdrawController@store` | `auth:sanctum`, `admin.identity` | Submit investment withdrawal request (status: pending) |
| `GET` | `/api/v1/withdrawals/investment/{id}` | `InvestmentWithdrawController@show` | `auth:sanctum`, `admin.identity` | View single investment withdrawal record |
| `PUT` | `/api/v1/withdrawals/investment/{id}` | `InvestmentWithdrawController@update` | `auth:sanctum`, `admin.identity` | Update pending withdrawal details |
| `DELETE` | `/api/v1/withdrawals/investment/{id}` | `InvestmentWithdrawController@destroy`| `auth:sanctum`, `admin.identity` | Soft-delete withdrawal record |
| `POST` | `/api/v1/withdrawals/investment/{id}/approve` | `InvestmentWithdrawController@approve` | `auth:sanctum`, `admin.identity` | Approve investment withdrawal (commits deduction) |
| `POST` | `/api/v1/withdrawals/investment/{id}/reject` | `InvestmentWithdrawController@reject` | `auth:sanctum`, `admin.identity` | Reject investment withdrawal |
| `GET` | `/api/v1/withdrawals/dividend` | `DividendWithdrawController@index` | `auth:sanctum`, `admin.identity` | List dividend withdrawal requests |
| `POST` | `/api/v1/withdrawals/dividend` | `DividendWithdrawController@store` | `auth:sanctum`, `admin.identity` | Submit dividend withdrawal request |
| `GET` | `/api/v1/withdrawals/dividend/{id}` | `DividendWithdrawController@show` | `auth:sanctum`, `admin.identity` | View single dividend withdrawal record |
| `PUT` | `/api/v1/withdrawals/dividend/{id}` | `DividendWithdrawController@update` | `auth:sanctum`, `admin.identity` | Update pending dividend withdrawal |
| `DELETE` | `/api/v1/withdrawals/dividend/{id}` | `DividendWithdrawController@destroy` | `auth:sanctum`, `admin.identity` | Soft-delete dividend withdrawal |
| `POST` | `/api/v1/withdrawals/dividend/{id}/approve` | `DividendWithdrawController@approve` | `auth:sanctum`, `admin.identity` | Approve dividend withdrawal |
| `POST` | `/api/v1/withdrawals/dividend/{id}/reject` | `DividendWithdrawController@reject` | `auth:sanctum`, `admin.identity` | Reject dividend withdrawal |

### 3.4 Bank Loans & EMI Tracking

| HTTP Verb | Endpoint | Legacy Mapping | Auth & Guard | Description |
| :--- | :--- | :--- | :--- | :--- |
| `GET` | `/api/v1/loans/bank-loans` | `BankLoanController@index` | `auth:sanctum`, `admin.identity` | List institutional bank loans with amortization metrics |
| `POST` | `/api/v1/loans/bank-loans` | `BankLoanController@store` | `auth:sanctum`, `admin.identity` | Create a new bank loan ledger |
| `GET` | `/api/v1/loans/bank-loans/{id}` | `BankLoanController@show` | `auth:sanctum`, `admin.identity` | View loan details and installment summary |
| `PUT` | `/api/v1/loans/bank-loans/{id}` | `BankLoanController@update` | `auth:sanctum`, `admin.identity` | Update loan terms |
| `DELETE` | `/api/v1/loans/bank-loans/{id}` | `BankLoanController@destroy` | `auth:sanctum`, `admin.identity` | Soft-delete loan record |
| `GET` | `/api/v1/loans/bank-loans/{id}/statement` | `BankLoanController@statement` | `auth:sanctum`, `admin.identity` | Comprehensive statement (EMI schedule, interest, savings) |
| `GET` | `/api/v1/loans/emi-installments` | `EmiInstallmentController@index` | `auth:sanctum`, `admin.identity` | List EMI installments (filterable by `bank_loan_id`, `status`) |
| `POST` | `/api/v1/loans/emi-installments` | `EmiInstallmentController@store` | `auth:sanctum`, `admin.identity` | Schedule an EMI installment repayment |
| `GET` | `/api/v1/loans/emi-installments/{id}` | `EmiInstallmentController@show` | `auth:sanctum`, `admin.identity` | View installment record |
| `PUT` | `/api/v1/loans/emi-installments/{id}` | `EmiInstallmentController@update` | `auth:sanctum`, `admin.identity` | Update installment |
| `DELETE` | `/api/v1/loans/emi-installments/{id}` | `EmiInstallmentController@destroy` | `auth:sanctum`, `admin.identity` | Soft-delete installment |
| `POST` | `/api/v1/loans/emi-installments/{id}/mark-paid` | `EmiInstallmentController@markPaid` | `auth:sanctum`, `admin.identity` | Settle installment (updates status to 'paid', logs receiver) |

### 3.5 ASSET Skill Training Project

| HTTP Verb | Endpoint | Legacy Mapping | Auth & Guard | Description |
| :--- | :--- | :--- | :--- | :--- |
| `GET` | `/api/v1/asset-training/courses` | `Admin\CourseController@index` | `auth:sanctum`, `admin.identity` | List government ASSET training courses |
| `POST` | `/api/v1/asset-training/courses` | `Admin\CourseController@store` | `auth:sanctum`, `admin.identity` | Create a new ASSET training course |
| `GET` | `/api/v1/asset-training/courses/{id}` | `Admin\CourseController@edit` | `auth:sanctum`, `admin.identity` | Show course details and outline metadata |
| `PUT` | `/api/v1/asset-training/courses/{id}` | `Admin\CourseController@update` | `auth:sanctum`, `admin.identity` | Update course outline/status |
| `DELETE` | `/api/v1/asset-training/courses/{id}` | `Admin\CourseController@delete` | `auth:sanctum`, `admin.identity` | Delete ASSET course |
| `GET` | `/api/v1/asset-training/registrations` | `StudentManagementController@index` | `auth:sanctum`, `admin.identity` | List trainee registrations (filters: `q`, `course_id`, `status`, `call_type`) |
| `POST` | `/api/v1/asset-training/registrations` | `Frontend\AssetController@store` | **Public** (Optional Admin token) | Public or administrative candidate registration submission |
| `GET` | `/api/v1/asset-training/registrations/{id}` | `StudentManagementController@show` | `auth:sanctum`, `admin.identity` | View candidate profile with multi-step feedback history |
| `DELETE` | `/api/v1/asset-training/registrations/{id}` | `StudentManagementController@delete` | `auth:sanctum`, `admin.identity` | Delete registration record |
| `PATCH` | `/api/v1/asset-training/registrations/{id}/status` | `StudentManagementController@updateStatus` | `auth:sanctum`, `admin.identity` | Update qualification status (with SMS dispatch handling) |
| `PATCH` | `/api/v1/asset-training/registrations/{id}/call-type` | `StudentManagementController@updateCallType` | `auth:sanctum`, `admin.identity` | Update tele-call round ('1st call' to '5th call') |
| `POST` | `/api/v1/asset-training/registrations/{id}/feedback` | `StudentManagementController@storeFeedback` | `auth:sanctum`, `admin.identity` | Append or update multi-step feedback note (step 1–5) |

---

## 4. Authorization Findings & Financial Risks

### 4.1 Legacy RBAC Reality
- As established during the Phase 2.6 audit, [`database/seeds/PermissionTableSeeder.php`](file:///c:/wamp64/www/innova-web/database/seeds/PermissionTableSeeder.php) never generated Spatie permission strings for shareholders, investments, loans, withdrawals, or asset project entities.
- In legacy [`routes/admin.php`](file:///c:/wamp64/www/innova-web/routes/admin.php#L24-L330), all these controllers were protected solely by `auth:admin`.
- **API Boundary Protection Strategy**:
  - The API will guard all administrative endpoints using `auth:sanctum` combined with [`EnsureAdminIdentity`](file:///c:/wamp64/www/innova-web/app/Http/Middleware/EnsureAdminIdentity.php).
  - Any web token belonging to a `User` (student) will be rejected with HTTP 403 Forbidden.
  - This precisely preserves the legacy system's effective access boundary without inventing unseeded permission strings.
  - Super-Admin access is preserved seamlessly via `Gate::before`.

### 4.2 Financial Integrity Risks
1. **String Monetary Calculations**:
   - `invesments.amount` is stored as `VARCHAR(191)` in legacy MySQL.
   - Any mathematical computation or aggregation must sanitize commas via `(float) str_replace(',', '', (string) $val)` before numeric operations to prevent silent zeroing under PHP 8+.
2. **Double Withdrawal Trap**:
   - Submitting duplicate withdrawal requests could theoretically deplete shareholder balance if both are approved.
   - The API must validate requested withdrawal amounts against the current `outstanding_balance` of the shareholder before persisting.
3. **SMS Side-Effect in Status Updates**:
   - In legacy code, changing trainee status to `'Qualified'` synchronously invokes `new SMSController()->send_sms(...)`.
   - If the remote Elitbuzz SMS gateway is unreachable or unresponsive, this can cause HTTP request timeouts.
   - In Phase 2.7 implementation, the SMS invocation must be wrapped in resilient exception handling or decoupled via a notification service.

---

## 5. Schema Anomalies & Technical Debt Register

1. **Four Completely Unmigrated Tables**:
   - `bank_loans`, `dividend_withdraws`, `emi_installments`, `investment_withdraws` have **zero migration files** in `database/migrations/`.
   - They exist purely in MySQL schema and live database tables.
   - *Impact on testing*: The test suite cannot rely on `migrate:fresh`. Dynamic SQLite schema creation must be authored inside the test setup fixture (`createTestTables()`).
2. **Misspelled Table & Model Names**:
   - Table `invesments` is spelled with a missing 't'.
   - The model is named [`Invesments`](file:///c:/wamp64/www/innova-web/app/Models/Invesments.php).
   - In accordance with modernization constraints, table names and models will be preserved as-is.
3. **Duplicate Migration Classes**:
   - `CreateAssetCoursesTable` exists in `2026_05_20_000000` and `2026_05_20_000300`.
   - `CreateAssetStudentsTable` exists in `2026_05_20_000001` and `2026_05_20_000400`.
4. **String Foreign Key Relationship**:
   - In `AssetRegistration.php`, the relationship to `AssetCourse` joins on the course title string (`'course'`, `'name'`) rather than an integer foreign key (`course_id`).
   - The API will support this existing schema mapping without breaking data integrity.

---

## 6. Dependencies & Implementation Sequence

```
Step 1: Form Requests & Validation Rules
  ├── StoreShareholderRequest, UpdateShareholderRequest
  ├── StoreInvestmentRequest, UpdateInvestmentRequest
  ├── StoreWithdrawalRequest, UpdateWithdrawalRequest
  ├── StoreBankLoanRequest, UpdateBankLoanRequest
  ├── StoreEmiInstallmentRequest, UpdateEmiInstallmentRequest
  └── StoreAssetRegistrationRequest, UpdateAssetStatusRequest

Step 2: Controllers Implementation (app/Http/Controllers/Api/V1/)
  ├── ShareholderApiController.php
  ├── InvestmentApiController.php
  ├── WithdrawalApiController.php
  ├── BankLoanApiController.php
  ├── EmiInstallmentApiController.php
  └── AssetTrainingApiController.php

Step 3: Route Registration (routes/api.php)
  └── Register all routes under /api/v1/ with auth:sanctum + admin.identity

Step 4: Automated Testing Suite (tests/Feature/Api/V1/ShareholderLoanAssetApiTest.php)
  ├── SQLite in-memory table creation for unmigrated tables
  ├── Comprehensive CRUD validation for all 6 functional domains
  ├── Mathematical verification of simple interest, statements, and savings
  └── Multi-state lifecycle verification (pending -> approved/rejected)
```

---

## 7. Testing Strategy: Isolated In-Memory SQLite

- **Database Safety Enforcement**:
  - All test executions will be bound to `:memory:` via `phpunit.xml`.
  - Zero SQL writes, alterations, or seeders will touch MySQL database `icbd_web`.
- **Dynamic Schema Authoring for Unmigrated Tables**:
  - `createTestTables()` will explicitly define `Schema::create` for `bank_loans`, `emi_installments`, `investment_withdraws`, `dividend_withdraws`, `shareholders`, `invesments`, `asset_courses`, `asset_registrations`, and `asset_registration_feedbacks`.
- **Target Test Coverage**:
  - Minimum 16 distinct test cases covering all CRUD endpoints, statement running balances, withdrawal approval transitions, loan interest formulas, trainee qualification workflows, and authorization barriers.

---

## 8. Explicit Exclusions

The following items are explicitly **excluded** from Phase 2.7:
1. **CMS Asset Card Stub (`Admin\AssetController`)**:
   - Legacy `Admin\AssetController` is a non-functional view stub (`$assets = collect([])`). It is unrelated to trainee intake or financial loans and will be excluded.
2. **Deprecated `asset_students` Table**:
   - Contains 0 rows and was abandoned in favor of `asset_registrations`. Excluded from API scope.
3. **Phase 2.8 / Certificate Management APIs**:
   - BTEB and ICBD certificate verification will be addressed in its dedicated roadmap phase.
4. **Phase 3 React Frontend Conversion**:
   - No React components, TypeScript interfaces, or frontend views will be created.
5. **Phase 4 PostgreSQL Migration**:
   - No production DDL migrations, engine conversions, or ETL scripts will be executed.

---

## 9. Readiness Recommendation

The codebase, legacy controllers, financial formulas, and database tables have been thoroughly audited. The scope is well-defined, and the missing migrations have an established testing mitigation strategy.

**Phase 2.7 is READY for implementation upon receiving explicit owner approval.**
