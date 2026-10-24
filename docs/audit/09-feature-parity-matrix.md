# 09. Feature Parity Matrix (Legacy to Modern Architecture)

**Project:** `innova-web` (INNOVA Computers BD / ICBD)  
**Audit Date:** October 13, 2026  
**Auditor:** Antigravity Agentic Audit (Phase 0 Discovery)  
**Strict Constraint:** Planning & Specification Only (No implementation code written)

---

## 1. Overview and Migration Architecture Assumptions

This matrix maps **every discovered legacy feature** in `innova-web` to the proposed modern architecture:
- **Backend:** Modern Laravel (10 / 11) API-driven architecture, PostgreSQL database, Sanctum authentication, FormRequests, API Resources, and queued jobs.
- **Frontend:** Modern React / TypeScript (Next.js for the public marketing site for SEO / SSR; React SPA with Vite / Tailwind / shadcn for the Admin & Student portals).
- **Rule:** **No existing feature may be silently omitted.**

---

## 2. Complete Feature Parity Mapping Table

### Module 1: Authentication & Access Control

| Feature ID & Name | Legacy Implementation | Proposed Modern API / Backend | Proposed React Frontend (TypeScript) | Database Tables | Acceptance Criteria | Tests Required | Risks & Open Items |
|---|---|---|---|---|---|---|---|
| **F1.1: Admin Authentication** | `Admin\LoginController`, Blade `admin.auth.login`, session guard `admin`. Overridden without rate limiting. | `POST /api/v1/admin/auth/login`, `POST /api/v1/admin/auth/logout`. Sanctum tokens with abilities. `ThrottleRequests` (5 attempts / min). | `AdminLoginPage.tsx` with react-hook-form, zod validation, secure httpOnly cookie or Bearer storage. | `admins`, `personal_access_tokens` | Admin can log in securely; 5 invalid attempts locks out account for 60s; credentials match legacy hashes. | `AdminLoginTest` (unit), `BruteForceThrottlingTest` (feature), Cypress E2E. | Ensure existing Bcrypt password hashes in `admins` table work without re-hashing. |
| **F1.2: Student Portal Auth** | `Auth\LoginController`, `Auth\RegisterController`, Blade auth views. | `POST /api/v1/auth/login`, `POST /api/v1/auth/register`, `POST /api/v1/auth/forgot-password`. | `StudentLoginPage.tsx`, `StudentRegisterPage.tsx`. Client-side validation. | `users`, `password_resets` | Students can register and log in to view course records. | `StudentAuthTest`, `PasswordResetNotificationTest`. | Coordinate student account linking with `students.user_id`. |
| **F1.3: Granular RBAC Management** | `Admin\RoleController`, Spatie permissions v5, Blade forms. Middleware only on role controller. | `GET/POST/PUT/DELETE /api/v1/admin/roles`. Spatie v6 permissions enforced across all admin endpoints via middleware/policies. | `RoleManagementPage.tsx`, permission checklist matrix with search filter. | `roles`, `permissions`, `model_has_roles`, `role_has_permissions` | Admins can create roles and assign discrete permissions; non-permitted users receive HTTP 403. | `RoleAuthorizationTest`, `PolicyEnforcementTest`. | 48 legacy controllers currently lack permissions; must define permission mapping for all endpoints. |

---

### Module 2: Student & Academic Management

| Feature ID & Name | Legacy Implementation | Proposed Modern API / Backend | Proposed React Frontend (TypeScript) | Database Tables | Acceptance Criteria | Tests Required | Risks & Open Items |
|---|---|---|---|---|---|---|---|
| **F2.1: Student Enrollment & Lifecycle** | `Admin\StudentsController`, `StudentsRepository`. Manual `$sid+1` ID generation. Blade views. | `GET/POST/PUT/DELETE /api/v1/admin/students`. Database transaction wrapping student insert and balance creation. | `StudentListPage.tsx`, `StudentCreateModal.tsx`, multi-step enrollment wizard. | `students`, `courses`, `batchs`, `branches` | Student enrolled; sequence automatically assigned; SMS triggered via queue. | `StudentEnrollmentTest`, `ConcurrentEnrollmentRaceConditionTest`. | Remove `$sid + 1` logic; rely on PostgreSQL identity sequence. |
| **F2.2: Student Filtering by Status** | Dedicated routes in `StudentsController` (`/active`, `/irregular`, `/resticted`, `/postpond`, `/complete`). | `GET /api/v1/admin/students?status=active`. Dynamic query scope with pagination. | Status badge filter pills (`Active`, `Irregular`, `Restricted`, `Postponed`, `Completed`). | `students` | Filtering returns exact status subset; search by name/phone works with ILIKE. | `StudentStatusFilterTest`, `CaseInsensitiveSearchTest`. | Note: `students.IsActive` stores integer `1..5`, not a boolean! |
| **F2.3: Course Curriculum & Categories** | `Admin\CoursesController`, `Admin\CourseCategoryController`. | `GET/POST/PUT/DELETE /api/v1/admin/courses`, `/api/v1/admin/course-categories`. | `CourseManagementPage.tsx`, curriculum module builder component. | `courses`, `course_categories` | Admin can define course modules, fees, descriptions, category groupings. | `CourseCrudTest`, `CourseCategoryAssociationTest`. | Preserve course fee numeric precision. |
| **F2.4: Batch Scheduling** | `Admin\BatchsController`. Weekly day flags (`day1..day7`) and time strings (`schedule1..schedule7`). | `GET/POST/PUT/DELETE /api/v1/admin/batches`. Normalized time slot array or JSONB schedule column. | `BatchSchedulerPage.tsx` with weekly calendar slot picker. | `batchs`, `courses` | Admins can schedule day/time combinations and assign active batches to students. | `BatchScheduleValidationTest`. | Refactor legacy `day1..day7` columns into structured schedule model. |
| **F2.5: Printable Student ID Cards** | `Admin\IdCardController@show`, Blade HTML print template with barcodes. | `GET /api/v1/admin/students/{id}/id-card`. Returns data payload for React print or generated PDF. | `StudentIdCardPrintView.tsx` with react-to-print and printable vector graphics. | `students`, `courses`, `branches` | Render printable ID card with photo, barcode, blood group, validity date matching legacy print layout. | `IdCardGenerationTest`, Visual Regression Test. | Ensure student photo URLs resolve correctly from storage. |
| **F2.6: Certificate Issuance & Verification** | `Admin\CertificateController`, `simplesoftwareio/simple-qrcode`, public verification route. | `POST /api/v1/admin/certificates`, `GET /api/v1/public/certificates/{slnum}`. Signed QR code payload. | `CertificateGeneratorPage.tsx`, public `CertificateVerificationPage.tsx`. | `certificates`, `certificate_icbds` | QR code scans and opens public verification page displaying student name, course, GPA, issue date. | `CertificateVerificationTest`, `QrCodePayloadTest`. | Tables `certificate_icbds` missing migration; verify schema in production. |

---

### Module 3: Student Billing & Tuition Fees

| Feature ID & Name | Legacy Implementation | Proposed Modern API / Backend | Proposed React Frontend (TypeScript) | Database Tables | Acceptance Criteria | Tests Required | Risks & Open Items |
|---|---|---|---|---|---|---|---|
| **F3.1: Counter / Cash Fee Collection** | `Admin\FeesTransectionsController@store`. Denormalized balance update on `students`. | `POST /api/v1/admin/fees/collect`. Wrapped in `DB::transaction`. Computes remaining balance dynamically. | `FeeCollectionModal.tsx` with instant balance preview and printable receipt dialog. | `fees_transections`, `students` | Records cash receipt, updates student ledger, prints receipt in Bengali words, dispatches SMS. | `FeeCollectionTransactionTest`, `StudentBalanceAuditTest`. | Migrate string `paidamount` to `NUMERIC(12, 2)`. |
| **F3.2: Printable Money Receipts** | `FeesTransectionsController`, `lemonpatwari/number-to-bangla`. | `GET /api/v1/admin/fees/{id}/receipt`. Generates Bengali in-words currency string. | `ReceiptPrintModal.tsx` with dual copy (Student / Office) layout. | `fees_transections`, `students`, `settings` | Generates official printed receipt with voucher number, date, in-words amount. | `NumberToBanglaTest`, `PrintReceiptSnapshotTest`. | Ensure Bangla font rendering in PDF / print view. |

---

### Module 4: Digital Payments (bKash Checkout)

| Feature ID & Name | Legacy Implementation | Proposed Modern API / Backend | Proposed React Frontend (TypeScript) | Database Tables | Acceptance Criteria | Tests Required | Risks & Open Items |
|---|---|---|---|---|---|---|---|
| **F4.1: bKash Online Payment** | `BkashController`, raw cURL, direct `env()` calls, GET `/user/success` without idempotency. | `POST /api/v1/payments/bkash/initiate`, `POST /api/v1/payments/bkash/execute`, webhook handler. Config in `services.bkash`. | `BkashPaymentModal.tsx` triggering bKash checkout iframe SDK, animated success/failure states. | `fees_transections`, `payment_logs` | Student completes bKash payment; backend executes and verifies transaction; ledger credited; duplicate prevented. | `BkashPaymentExecutionTest`, `IdempotencyDuplicateTrxTest`, `ConfigCacheIsolationTest`. | Move bKash credentials to `config/services.php`; implement webhook/status inquiry fallback. |

---

### Module 5: ASSET Project Subsystem (Newer 2026 Module)

| Feature ID & Name | Legacy Implementation | Proposed Modern API / Backend | Proposed React Frontend (TypeScript) | Database Tables | Acceptance Criteria | Tests Required | Risks & Open Items |
|---|---|---|---|---|---|---|---|
| **F5.1: ASSET Trainee Public Registration** | `Frontend\AssetController`, `StudentRegistrationController`. Uploads NID, photo, certificate. | `POST /api/v1/asset/register`. Multi-part file upload with strict MIME validation. | `AssetRegistrationWizard.tsx` with drag-and-drop file uploaders and preview. | `asset_registrations`, `asset_students`, `asset_courses` | Candidate registers with educational background and uploaded documents; received notification. | `AssetRegistrationValidationTest`, `FileUploadSecurityTest`. | Resolve duplicate migration classes (`CreateAssetCoursesTable`, `CreateAssetStudentsTable`). |
| **F5.2: ASSET Admin Candidate Call Log** | `Admin\AssetController`, `AssetRegistrationFeedback` model. | `GET /api/v1/admin/asset/registrations`, `POST /api/v1/admin/asset/feedback`. | `AssetCandidateDirectory.tsx`, call feedback drawer (1st call, 2nd call, call notes). | `asset_registrations`, `asset_registration_feedbacks` | Staff records call outcomes and updates registration status (Pending, Contacted, Enrolled). | `AssetCallFeedbackTest`. | Maintain historical follow-up call notes. |

---

### Module 6: Financial Accounting & Expense Management

| Feature ID & Name | Legacy Implementation | Proposed Modern API / Backend | Proposed React Frontend (TypeScript) | Database Tables | Acceptance Criteria | Tests Required | Risks & Open Items |
|---|---|---|---|---|---|---|---|
| **F6.1: Expense Tracking & Vouchers** | `Admin\ExpanseController`, `expanses` table storing amount as VARCHAR. | `GET/POST/PUT/DELETE /api/v1/admin/expenses`. Validates numeric amount; uploads voucher to S3/local. | `ExpenseManagementPage.tsx`, quick-entry voucher form, receipt thumbnail preview. | `expanses`, `expanse_categoris`, `branches` | Records expense voucher; categorized by head and branch; total computed automatically. | `ExpenseCreationTest`, `NumericAmountValidationTest`. | Migrate string amounts containing commas to numeric decimal. |
| **F6.2: Revenue & Financial Balance Sheet** | `Admin\ReportController`, raw SQL `REPLACE(amount, ',', '')`. | `GET /api/v1/admin/reports/financial-summary?start_date=...&end_date=...`. Clean SQL aggregation. | `FinancialDashboard.tsx` with revenue vs expense charts, printable monthly P&L sheet. | `expanses`, `incomes`, `fees_transections` | Accurately computes net profit = (fees + incomes) - expenses; zero SQL errors. | `FinancialReportCalculationTest`, `DateRangeFilterTest`. | Replace raw MySQL string queries with database-agnostic Eloquent/PostgreSQL syntax. |

---

### Module 7: Investment, Shareholder & Debt Tracking

| Feature ID & Name | Legacy Implementation | Proposed Modern API / Backend | Proposed React Frontend (TypeScript) | Database Tables | Acceptance Criteria | Tests Required | Risks & Open Items |
|---|---|---|---|---|---|---|---|
| **F7.1: Shareholder Equity & Withdrawals** | `Admin\ShareholderController`, `Admin\InvestmentWithdrawController`, `Admin\DividendWithdrawController`. | `api/v1/admin/shareholders/*`, `/investments/*`, `/dividends/*`. | `ShareholderEquityPage.tsx`, dividend calculation dialog, withdrawal history. | `shareholders`, `invesments`, `investment_withdraws`, `dividend_withdraws` | Tracks capital investments, computes monthly dividend by share percentage, logs payouts. | `DividendCalculationTest`, `InvestmentWithdrawalTest`. | `investment_withdraws` and `dividend_withdraws` missing migration files. |
| **F7.2: Bank Loans & EMI Management** | `Admin\BankLoanController`, `Admin\EmiInstallmentController`. | `api/v1/admin/bank-loans/*`, `/emi-installments/*`. | `BankLoanTrackingPage.tsx`, monthly EMI payment schedule calendar. | `bank_loans`, `emi_installments` | Logs loan principal, interest, term, and tracks monthly EMI payments and outstanding debt. | `EmiInstallmentCalculationTest`. | Missing migration files; reconstruct schema from production. |

---

### Module 8: SMS Communications Gateway

| Feature ID & Name | Legacy Implementation | Proposed Modern API / Backend | Proposed React Frontend (TypeScript) | Database Tables | Acceptance Criteria | Tests Required | Risks & Open Items |
|---|---|---|---|---|---|---|---|
| **F8.1: Class Postponement & Bulk Alerts** | `Admin\SMSController`, raw cURL with SSL disabled, direct `env()` calls. | Queued Job `SendPostponementSmsJob`, dedicated `SmsGatewayService` implementing interface. | `SmsBroadcastPage.tsx`, batch recipient selector, dynamic message template builder. | `sms_logs` (new table proposed) | Dispatches Unicode Bengali SMS via Elitbuzz with verified SSL; logs delivery status in DB. | `SmsServiceMockTest`, `PostponementBroadcastJobTest`. | Enable SSL verification; decouple SMS from HTTP request threads into background queue. |

---

### Module 9: Public CMS & Marketing Website

| Feature ID & Name | Legacy Implementation | Proposed Modern API / Backend | Proposed React Frontend (TypeScript) | Database Tables | Acceptance Criteria | Tests Required | Risks & Open Items |
|---|---|---|---|---|---|---|---|
| **F9.1: Public Website & Course Discovery** | `Frontend\FrontendController`, 60 Blade views in `resources/views/frontend/`. | Public Next.js SSR / SSG endpoints: `GET /api/v1/public/home`, `/courses`, `/blogs`, `/seminars`. | Next.js Marketing App with Tailwind CSS, course catalog, interactive course syllabus, search. | `courses`, `sliders`, `blogs`, `seminors`, `reviews`, `galleries` | Next.js renders public website with SEO metadata, instant page loads, and mobile responsiveness. | Next.js Cypress E2E, SEO Lighthouse Audit (>90). | Maintain existing URL route parity (`/about`, `/courses`, `/contact`) for SEO preservation. |
| **F9.2: Seminar Registration** | `FrontendController@SeminorsRegStore`. | `POST /api/v1/public/seminars/{id}/register`. | `SeminarRegistrationModal.tsx` with instant confirmation dialog. | `seminors`, `seminor_registrations` | Prospective attendees register for free workshops; admin views attendee roster. | `SeminarRegistrationTest`. | Clean schema and add phone validation. |
| **F9.3: Online Admission Form** | `FrontendController@storeAdmission`. | `POST /api/v1/public/admissions`. | `OnlineAdmissionForm.tsx` with course selection and branch picker. | `admissions`, `courses`, `branches` | Prospective students submit admission interest; leads populate admin admissions table. | `OnlineAdmissionLeadTest`. | Add duplicate lead prevention. |

---

### Module 10: System Administration & Settings

| Feature ID & Name | Legacy Implementation | Proposed Modern API / Backend | Proposed React Frontend (TypeScript) | Database Tables | Acceptance Criteria | Tests Required | Risks & Open Items |
|---|---|---|---|---|---|---|---|
| **F10.1: Application Settings & Branding** | `Admin\SettingController`, buggy `if-elseif-else` logic, unvalidated file uploads. | `GET /api/v1/admin/settings`, `POST /api/v1/admin/settings`. Atomic update of key-value settings and media. | `SystemSettingsPage.tsx` with logo cropper, site meta fields, contact details. | `settings` | Admin updates site title, footer text, contact phone, and uploads new logo simultaneously without bug. | `SettingsUpdateTest`, `LogoUploadValidationTest`. | Fix legacy bug where uploading a logo skips all other text settings. |
| **F10.2: System Maintenance & Artisan Tools** | Dangerous GET routes running `storage:link`, `config:cache`, `optimize:clear`. | Restrict CLI actions to authorized terminal or authenticated `POST /api/v1/admin/system/cache-clear`. | `SystemMaintenanceTab.tsx` with confirmation modal. | N/A | Only Super Admin can clear cache via secure POST request; no GET execution endpoints. | `CacheClearAuthorizationTest`. | Remove vulnerable artisan GET routes completely. |
