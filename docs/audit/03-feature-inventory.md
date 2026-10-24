# 03. Feature and Module Inventory

**Project:** `innova-web` (INNOVA Computers BD / ICBD)  
**Audit Date:** October 13, 2026  
**Auditor:** Antigravity Agentic Audit (Phase 0 Discovery)  
**Strict Constraint:** Read-Only Audit (No code/configuration/data changes made)

---

## 1. Inventory Summary Matrix

| Module Name | Core Features | Status | Supporting Evidence |
|---|---|---|---|
| **M1: Authentication & Access Control** | Admin auth, Student portal auth, Role management | **Partially Implemented & Vulnerable** | No login throttling in admin login; Spatie permissions only applied in `RoleController`, missing in 48 admin controllers. |
| **M2: Student & Academic Management** | Student lifecycle, courses, batches, sessions, staff, ID cards | **Implemented (Fragile)** | Active UI and controllers; fragile manual ID generation (`$sid = $sid->id + 1`), GET deletion routes. |
| **M3: Student Billing & Tuition Fees** | Offline cash fees, invoices, student payment ledger | **Implemented** | Working Blade forms, stores fee transactions, sends payment receipt SMS. |
| **M4: bKash Payment Integration** | Checkout Iframe, token grant, payment execute, receipt | **Partially Implemented / Broken on Cache** | Direct `env()` calls crash if config cached; no idempotency check in `success` route. |
| **M5: ASSET Project Subsystem** | Trainee lead registration, course outline, call follow-ups | **Implemented (Recent 2026)** | Separate modern tables, dual duplicate migrations, dedicated controllers. |
| **M6: Financial Accounting** | Expense tracking, income vouchers, financial reports | **Implemented (Data Risk)** | Money stored as `VARCHAR` with commas; requires `SUM(REPLACE(amount, ',', ''))`. |
| **M7: Investment & Banking** | Shareholders, capital investments, withdrawals, loans, EMI | **Implemented (Missing Migrations)** | Controllers and views exist; 5 tables missing migration files. |
| **M8: SMS Gateway & Communications** | Class postponement alerts, fee SMS, bulk notifications | **Broken on Cache / Insecure** | `CURLOPT_SSL_VERIFYPEER => false`; direct `env()` usage breaks if config cached. |
| **M9: Public CMS & Marketing Website** | Home, courses, admissions, seminars, blogs, gallery, certificate verification | **Implemented** | Complete public Blade views, course search, seminar registration, and certificate verification. |
| **M10: System Administration** | General settings, logo/favicon upload, artisan web hooks | **Buggy / Insecure** | `SettingController` skips text settings on file upload; artisan commands exposed over GET requests. |

---

## 2. Detailed Module & Feature Breakdown

### M1: Authentication & Access Control Module

#### F1.1: Admin Authentication & Password Reset
- **User-Facing Functionality:** Administrative login screen, password reset request via email, reset password form, change password form.
- **Routes & Methods:**
  - `GET /admin/login` (`admin.login`)
  - `POST /admin/login` (`admin.login.post`)
  - `GET /admin/logout` (`admin.logout`)
  - `GET /admin/password/reset` (`admin.password.request`)
  - `POST /admin/password/email` (`admin.password.email`)
  - `GET /admin/password/reset/{token}` (`admin.password.reset`)
  - `POST /admin/password/reset`
  - `GET /admin/changePassword` (`admin.changePassword`)
  - `POST /admin/changePassword` (`changePassword`)
- **Components:**
  - Controllers: [`Admin\LoginController`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/LoginController.php), [`Auth\AdminForgotPasswordController`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Auth/AdminForgotPasswordController.php), [`Auth\AdminResetPasswordController`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Auth/AdminResetPasswordController.php), [`Admin\ChangePasswordController`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/ChangePasswordController.php).
  - Model: [`Admin`](file:///c:/wamp64/www/innova-web/app/Models/Admin.php).
  - Tables: `admins`, `password_resets`.
  - Views: `resources/views/admin/auth/login.blade.php`, `change-password.blade.php`.
- **Validation & Business Rules:** Email required & valid email; password min 6 chars. Bcrypt verification against `admins` table with guard `admin`.
- **Status:** **Partially Implemented & Vulnerable.**
- **Evidence:** `Admin\LoginController::login()` completely overrides Laravel default authentication and omits `ThrottlesLogins`, exposing the admin portal to brute-force attacks.

#### F1.2: Student User Portal Authentication
- **User-Facing Functionality:** Login, registration, dashboard for enrolled students to view course schedules and payment history.
- **Routes & Methods:** Standard `Auth::routes()` in [`routes/web.php`](file:///c:/wamp64/www/innova-web/routes/web.php#L80) (`GET /login`, `POST /login`, `GET /register`, `POST /register`, `GET /logout`).
- **Components:**
  - Controllers: [`Auth\LoginController`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Auth/LoginController.php), [`Auth\RegisterController`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Auth/RegisterController.php), [`UserController`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/UserController.php).
  - Model: [`User`](file:///c:/wamp64/www/innova-web/app/Models/User.php).
  - Tables: `users`.
  - Views: `resources/views/auth/login.blade.php`, `resources/views/users/profile/`.
- **Status:** **Implemented.**
- **Evidence:** Default Laravel UI Bootstrap 4 authentication scaffolding.

#### F1.3: Role & Permission Management (RBAC)
- **User-Facing Functionality:** Create, view, edit, and delete administrative roles with specific assigned permissions.
- **Routes & Methods:** `GET|POST|DELETE /admin/roles/*` (Resource controller routes in `routes/admin.php`).
- **Components:**
  - Controller: [`Admin\RoleController`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/RoleController.php).
  - Models: Spatie `Role`, `Permission`.
  - Tables: `roles`, `permissions`, `model_has_roles`, `role_has_permissions`.
  - Views: `resources/views/admin/roles/`.
- **Status:** **Partially Implemented / Severely Restricted Scope.**
- **Evidence:** The permission middleware `$this->middleware('permission:role-list|role-create|...', ...)` is strictly enforced in `RoleController`, but **completely absent in all other 48 administrative controllers**. Any authenticated admin has unrestricted access to student, financial, and accounting records.

---

### M2: Student & Academic Management Module

#### F2.1: Student Lifecycle Management
- **User-Facing Functionality:** Register student, view student profile, filter by status (Active, Irregular, Completed, Restricted, Postponed), update student details, soft-delete.
- **Routes & Methods:**
  - `GET /admin/students` (`admin.students.index`)
  - `GET /admin/students/create` (`admin.students.create`)
  - `POST /admin/students/store` (`admin.students.store`)
  - `GET /admin/students/{id}/view` (`admin.students.view`)
  - `GET /admin/students/{id}/edit` (`admin.students.edit`)
  - `POST /admin/students/update` (`admin.students.update`)
  - `POST /admin/students/{id}/delete` (`admin.students.delete`)
  - `GET /admin/students/active`, `/irregular`, `/resticted`, `/postpond`, `/complete`
- **Components:**
  - Controller: [`Admin\StudentsController`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/StudentsController.php).
  - Repository: [`StudentsRepository`](file:///c:/wamp64/www/innova-web/app/Repositories/StudentsRepository.php).
  - Model: [`Students`](file:///c:/wamp64/www/innova-web/app/Models/Students.php).
  - Tables: `students`, `courses`, `batchs`, `branches`.
  - Views: `resources/views/admin/students/index.blade.php`, `create.blade.php`, `edit.blade.php`, `view.blade.php`.
- **Validation & Business Rules:**
  - Required: `course_id`, `branch_id`, `batch_id`, `sname`, `gender`, `religion`, `g_phone`, `course_fee`, `rel_g`, `admission_date`.
  - Media: Image mime validation (`jpeg,jpg,png,gif|max:1024`).
  - SMS dispatch: Sends admission confirmation SMS to student phone via `SMSController` upon store.
- **Status:** **Implemented (High Fragility).**
- **Evidence:** In [`StudentsController.php:L232-233`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/StudentsController.php#L232-L233):
  `$sid = Students::orderBy('id', 'desc')->first(); $sid = $sid->id + 1;`
  Fails with null-pointer error if the table is empty and creates race conditions under concurrent requests.

#### F2.2: Course & Batch Scheduling
- **User-Facing Functionality:** Course creation, curriculum modules, pricing, batch creation with day/time schedules (e.g., Friday/Saturday morning/afternoon slots).
- **Routes & Methods:**
  - `admin/courses/*` (`Admin\CoursesController`)
  - `admin/coursecatg/*` (`Admin\CourseCategoryController`)
  - `admin/batchs/*` (`Admin\BatchsController`)
  - `admin/session/*` (`Admin\SessionController`)
- **Components:**
  - Controllers: [`Admin\CoursesController`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/CoursesController.php), [`Admin\BatchsController`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/BatchsController.php), [`Admin\SessionController`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/SessionController.php).
  - Models: [`Courses`](file:///c:/wamp64/www/innova-web/app/Models/Courses.php), [`CourseCategory`](file:///c:/wamp64/www/innova-web/app/Models/CourseCategory.php), [`Batchs`](file:///c:/wamp64/www/innova-web/app/Models/Batchs.php), [`Session`](file:///c:/wamp64/www/innova-web/app/Models/Session.php).
  - Tables: `courses`, `course_categories`, `batchs`, `sessions`.
- **Status:** **Implemented.**

#### F2.3: Student ID Card & Staff ID Card Generation
- **User-Facing Functionality:** Render and print printable graphical ID cards for students and employees with barcodes and institute logos.
- **Routes & Methods:**
  - `GET /admin/idcard/{id}/show` (`Admin\IdCardController@show`)
  - `GET /admin/stuffidcard/{id}/show` (`Admin\StuffIdCardController@show`)
- **Components:**
  - Controllers: [`Admin\IdCardController`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/IdCardController.php), [`Admin\StuffIdCardController`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/StuffIdCardController.php).
  - Views: `resources/views/admin/idcard/show.blade.php`, `resources/views/admin/stuffidcard/show.blade.php`.
- **Status:** **Implemented.**
- **Evidence:** Custom HTML/CSS printable ID card layouts using asset images and data base64 encoding.

#### F2.4: Certificate Generation & Verification
- **User-Facing Functionality:** Issue student course completion certificates, generate QR codes, public verification form for employers.
- **Routes & Methods:**
  - `admin/certificate/*` (`Admin\CertificateController`)
  - `admin/certificate_icbd/*` (`Admin\CertificateICBDController`)
  - `GET /certifiocate-verify/{slnum}` (`Frontend\FrontendController@certificateVerify`)
  - `GET|POST /certifiocate-verify-bteb` (`Frontend\FrontendController@certificateVerifyForm`, `@certificateVerifyCheck`)
- **Components:**
  - Controllers: [`Admin\CertificateController`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/CertificateController.php), [`Frontend\FrontendController`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Frontend/FrontendController.php).
  - Models: [`Certificates`](file:///c:/wamp64/www/innova-web/app/Models/Certificates.php), [`Certificate_icbd`](file:///c:/wamp64/www/innova-web/app/Models/Certificate_icbd.php).
  - Integrations: `simplesoftwareio/simple-qrcode`.
- **Status:** **Implemented.**

---

### M3: Student Billing & Tuition Fees Module

#### F3.1: Counter / Cash Fee Collection
- **User-Facing Functionality:** Record student fee payments (Admission Fee, Monthly Installment, Exam Fee), calculate remaining balance, generate receipt voucher, trigger SMS receipt.
- **Routes & Methods:**
  - `GET /admin/fees` (`admin.fees.index`)
  - `GET /admin/fees/feelog` (`admin.fees.feelog`)
  - `GET /admin/fees/{id}/create` (`admin.fees.create`)
  - `POST /admin/fees/store` (`admin.fees.store`)
  - `GET /admin/fees/{id}/view` (`admin.fees.view`)
  - `GET /admin/fees/{id}/edit` (`admin.fees.edit`)
  - `POST /admin/fees/update` (`admin.fees.update`)
- **Components:**
  - Controller: [`Admin\FeesTransectionsController`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/FeesTransectionsController.php).
  - Repository: [`FeesTransectionsRepository`](file:///c:/wamp64/www/innova-web/app/Repositories/FeesTransectionsRepository.php).
  - Model: [`FeesTransections`](file:///c:/wamp64/www/innova-web/app/Models/FeesTransections.php).
  - Tables: `fees_transections`, `students`.
- **Business Rules:**
  - Updates student balance: deducts paid amount from `students.balance`.
  - Dispatches automated Bengali SMS receipt to student phone upon receipt creation.
- **Status:** **Implemented.**

---

### M4: bKash Payment Gateway Integration

#### F4.1: Online Student Payment Flow
- **User-Facing Functionality:** Student selects due amount on profile portal, initiates bKash checkout iframe, enters PIN/OTP on bKash pop-up, transaction completes and updates ledger.
- **Routes & Methods:**
  - `GET /pay` (`pay`)
  - `GET /user/bkash/create` (`create.bkash`)
  - `GET /user/bkash/execute` (`execute.bkash`)
  - `GET /user/success` (`success.bkash`)
  - `GET /user/fail` (`fail.bkash`)
  - `GET /user/bkash/search` (`search.bkash`)
  - `GET /user/bkash/search-transaction` (`search-transaction.bkash`)
- **Components:**
  - Controller: [`BkashController`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/BkashController.php).
  - Model: [`FeesTransections`](file:///c:/wamp64/www/innova-web/app/Models/FeesTransections.php).
  - Tables: `fees_transections`.
- **Integrations:** Direct cURL integration with `https://checkout.pay.bka.sh/v1.2.0-beta`.
- **Status:** **Partially Implemented / Critical Breakage on Cache.**
- **Evidence:**
  1. Direct calls to `env('BKASH_CHECKOUT_APP_KEY')`, `env('BKASH_CHECKOUT_USER_NAME')`, `env('BKASH_CHECKOUT_PASSWORD')`, `env('BKASH_CHECKOUT_APP_SECRET')`. If `config:cache` is executed, credentials evaluate to `null` and payment initiation fails immediately.
  2. The `/user/success` route is a GET request relying entirely on ephemeral session state (`Session::get('arr')`) without checking if the transaction ID was already recorded or re-querying the bKash API. Refreshing the URL creates duplicate payments or errors.

---

### M5: ASSET Project Subsystem (Newer 2026 Module)

#### F5.1: ASSET Trainee Public Registration & Admin Management
- **User-Facing Functionality:** Dedicated ASSET project landing page, registration form (uploading NID, photo, educational certificates), admin candidate review, feedback call logs (1st call, 2nd call, etc.).
- **Routes & Methods:**
  - `GET /asset-registration` (`asset.index`)
  - `POST /asset-registration-submit` (`asset.store`)
  - `admin/assets/*` (`Admin\AssetController`)
  - `admin/asset-training/*` (`Admin\CourseController`, `Admin\StudentManagementController`)
- **Components:**
  - Controllers: [`Frontend\AssetController`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Frontend/AssetController.php), [`StudentRegistrationController`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/StudentRegistrationController.php), [`Admin\AssetController`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/AssetController.php), [`Admin\CourseController`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/CourseController.php), [`Admin\StudentManagementController`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/StudentManagementController.php).
  - Models: [`AssetCourse`](file:///c:/wamp64/www/innova-web/app/Models/AssetCourse.php), [`AssetStudent`](file:///c:/wamp64/www/innova-web/app/Models/AssetStudent.php), [`AssetRegistration`](file:///c:/wamp64/www/innova-web/app/Models/AssetRegistration.php), [`AssetRegistrationFeedback`](file:///c:/wamp64/www/innova-web/app/Models/AssetRegistrationFeedback.php), [`Asset`](file:///c:/wamp64/www/innova-web/app/Models/Asset.php).
  - Tables: `asset_courses`, `asset_students`, `asset_registrations`, `asset_registration_feedbacks`, `assets`.
- **Status:** **Implemented (Migration Conflicts).**
- **Evidence:** Fully fleshed-out views and controllers; however, migration history contains duplicate class definitions (`CreateAssetCoursesTable` and `CreateAssetStudentsTable`).

---

### M6: Financial Accounting & Expense Module

#### F6.1: Expenditure Management
- **User-Facing Functionality:** Record office expenses, utility bills, rent, trainer honorarium, categorized by expense heads and branches with optional voucher image uploads.
- **Routes & Methods:** `admin/expance/*` (`Admin\ExpanseController`), `admin/expcategoris/*` (`Admin\ExpanseCategorisController`).
- **Components:**
  - Controllers: [`Admin\ExpanseController`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/ExpanseController.php), [`Admin\ExpanseCategorisController`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/ExpanseCategorisController.php).
  - Models: [`Expanse`](file:///c:/wamp64/www/innova-web/app/Models/Expanse.php), [`ExpanseCategoris`](file:///c:/wamp64/www/innova-web/app/Models/ExpanseCategoris.php).
  - Tables: `expanses`, `expanse_categoris`.
- **Status:** **Implemented (Data Type Flaw).**
- **Evidence:** Stored as `VARCHAR(255)`.

#### F6.2: Income Management & Financial Reports
- **User-Facing Functionality:** Record miscellaneous revenue receipts, monthly income-expense balance sheet, branch-wise financial audit reports.
- **Routes & Methods:** `admin/income/*`, `admin/inccategoris/*`, `admin/reports/*`.
- **Components:**
  - Controllers: [`Admin\IncomeController`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/IncomeController.php), [`Admin\ReportController`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/ReportController.php).
  - Models: [`Income`](file:///c:/wamp64/www/innova-web/app/Models/Income.php), [`IncomeCategoris`](file:///c:/wamp64/www/innova-web/app/Models/IncomeCategoris.php).
  - Tables: `incomes`, `income_categoris`.
- **Status:** **Implemented.**

---

### M7: Investment, Shareholder & Banking Module

#### F7.1: Shareholder Equity & Investment Tracking
- **User-Facing Functionality:** Manage company shareholders, record initial capital investments, track investment withdrawals, record dividend payouts.
- **Routes & Methods:**
  - `admin/shareholder/*` (`Admin\ShareholderController`)
  - `admin/investment/*` (`Admin\InvesmentsController`)
  - `admin/investment/withdraw/*` (`Admin\InvestmentWithdrawController`)
  - `admin/dividend/withdraw/*` (`Admin\DividendWithdrawController`)
- **Components:**
  - Controllers: [`Admin\ShareholderController`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/ShareholderController.php), [`Admin\InvesmentsController`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/InvesmentsController.php), [`Admin\InvestmentWithdrawController`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/InvestmentWithdrawController.php), [`Admin\DividendWithdrawController`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/DividendWithdrawController.php).
  - Models: [`Shareholder`](file:///c:/wamp64/www/innova-web/app/Models/Shareholder.php), [`Invesments`](file:///c:/wamp64/www/innova-web/app/Models/Invesments.php), [`InvestmentWithdraw`](file:///c:/wamp64/www/innova-web/app/Models/InvestmentWithdraw.php), [`DividendWithdraw`](file:///c:/wamp64/www/innova-web/app/Models/DividendWithdraw.php).
  - Tables: `shareholders`, `invesments`, `investment_withdraws`, `dividend_withdraws`.
- **Status:** **Implemented (Missing Migrations).**
- **Evidence:** Views and controllers functional, but `investment_withdraws` and `dividend_withdraws` lack migration files.

#### F7.2: Bank Loans & EMI Tracking
- **User-Facing Functionality:** Record institutional bank loans taken by the institute, schedule and record monthly EMI installment payments.
- **Routes & Methods:** `admin/bank-loans/*`, `admin/emi-installments/*`.
- **Components:**
  - Controllers: [`Admin\BankLoanController`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/BankLoanController.php), [`Admin\EmiInstallmentController`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/EmiInstallmentController.php).
  - Models: [`BankLoan`](file:///c:/wamp64/www/innova-web/app/Models/BankLoan.php), [`EmiInstallment`](file:///c:/wamp64/www/innova-web/app/Models/EmiInstallment.php).
  - Tables: `bank_loans`, `emi_installments`.
- **Status:** **Implemented (Missing Migrations).**

---

### M8: SMS Gateway & Communications Module

#### F8.1: Bulk & Event-Triggered SMS Dispatch
- **User-Facing Functionality:** Send automated class postponement notices ("আজকের ক্লাস স্থগিত"), admission confirmation SMS, fee collection receipts, custom batch messages.
- **Routes & Methods:** `admin/sms/*` (`Admin\SMSController`).
- **Components:**
  - Controller: [`Admin\SMSController`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/SMSController.php).
  - Provider: Elitbuzz SMS Gateway (`https://msg.elitbuzz-bd.com/smsapi`).
- **Status:** **Broken on Cache / Insecure.**
- **Evidence:** Disables SSL verification (`CURLOPT_SSL_VERIFYPEER => false`) and calls `env('SMS_URL')` directly in controller.

---

### M9: Public CMS & Marketing Website Module

#### F9.1: Public Website & Course Discovery
- **User-Facing Functionality:** Homepage hero sliders, course category listing, detailed course curriculum view, student admission application, seminar registration, company blog with search, photo gallery, success stories showcase, contact form with Google reCAPTCHA.
- **Routes & Methods:** 60+ frontend routes in [`routes/web.php`](file:///c:/wamp64/www/innova-web/routes/web.php).
- **Components:**
  - Controllers: [`Frontend\FrontendController`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Frontend/FrontendController.php), `FrontendServiceController`, `FrontendProductController`, `FrontendConcernController`, `FrontendWorkflowController`.
  - Views: `resources/views/frontend/`.
- **Status:** **Implemented.**

---

### M10: System Administration & Maintenance Module

#### F10.1: Application Settings & Branding
- **User-Facing Functionality:** Update site title, footer copyright, contact phone/email, upload site logo and favicon.
- **Routes & Methods:** `GET|POST /admin/settings` (`Admin\SettingController@index`, `@update`).
- **Components:**
  - Controller: [`Admin\SettingController`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/SettingController.php).
  - Model: [`Setting`](file:///c:/wamp64/www/innova-web/app/Models/Setting.php).
  - Table: `settings`.
- **Status:** **Buggy & Insecure.**
- **Evidence:**
  1. `if ... elseif ... else` structure prevents saving general settings if logo/favicon is submitted.
  2. Missing file upload validation on logo and favicon inputs.

#### F10.2: Web-Based Artisan Execution Endpoints
- **User-Facing Functionality:** Admin clicks web links to trigger `storage:link`, `optimize:clear`, `config:cache`, `config:clear`, `view:clear`, `cache:clear`.
- **Routes & Methods:**
  - `GET /admin/storagelink`
  - `GET /admin/optimize`
  - `GET /admin/configcatche`
  - `GET /admin/configclear`
  - `GET /admin/viewclear`
  - `GET /admin/cacheclear`
  - `GET /admin/vendorpublish`
- **Status:** **Insecure Anti-Pattern.**
- **Evidence:** Triggers heavy CLI mutations over GET requests. `/vendorpublish` attempts to publish an uninstalled vendor package (`Greggilbert\Recaptcha`).
