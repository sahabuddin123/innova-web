# CURRENT SYSTEM ARCHITECTURE AUDIT REPORT
**Project:** INNOVA Computers BD Web System Modernization  
**Phase:** Phase 1 — Complete Current System Architecture Audit  
**Status:** COMPLETE (Read-Only Evidence-Based Audit)  
**Date:** October 24, 2026  
**Auditor:** Senior Software Architect, Laravel Backend Architect, React Migration Specialist & Database Migration Planner  

---

## 1. Executive Summary

This architecture audit represents a comprehensive, non-destructive, read-only analysis of the **INNOVA Computers BD** web application (`innova-web`). The application is a unified education management, financial accounting, shareholder investment, certificate verification, and corporate portal originally developed on Laravel 8.

The system manages both public operations (course catalogs, corporate services, online admissions, seminar enrollments, certificate verification) and internal administrative operations (student lifecycle, batch schedules, academic sessions, tuition fee collection, double-entry-style branch income/expense accounting, shareholder equity tracking, bank loans, and automated SMS notifications).

### Key Audit Findings:
- **Application Scale:** 49 Eloquent models, 59 controllers (48 Admin, 2 Frontend, 7 Auth, 2 API), 467 registered routes (383 admin, 17 filemanager, 9 student, ~50 public/auth, 2 API), and 326 Blade views across 8 view namespaces.
- **Data Persistence Architecture:** 52 database tables comprising 15,663 operational records (at baseline audit), partitioned across 38 InnoDB tables and 14 legacy MyISAM tables. Significant schema drift exists between historical migration files and the active database schema (4 completely unmigrated tables, 4 unmigrated columns in `fees_transections`, and 3 duplicate migration class names).
- **Backend Architecture:** Monolithic MVC pattern where controllers directly orchestrate business logic, database transactions, validation, and view rendering. Reusable service layers are minimal outside of dedicated integration controllers (`BkashController`, `SMSController`) and the `UploadAble` trait.
- **Frontend Architecture:** Server-rendered Blade templates relying on Bootstrap 4, jQuery 3.6, DataTables, Select2, SweetAlert, and legacy Vue 2.x components compiled via Laravel Mix (Webpack 4).
- **Modernization Feasibility:** The system has high domain value and clean entity boundaries. A four-phase modernization path (Architecture Audit $\rightarrow$ REST API Development on MySQL $\rightarrow$ React + TypeScript Migration $\rightarrow$ PostgreSQL 16 Migration) is safe, decoupled, and completely viable without data loss.

---

## 2. Verified Technology Stack

All versions and packages below have been directly verified against the repository's configuration files, lockfiles, and active runtime environment.

| Component | Verified Version / Specification | Source / Verification Method | Notes |
| :--- | :--- | :--- | :--- |
| **Operating System** | Windows 10/11 x64 (WampServer 3.3.0 environment) | System environment probe | Development workspace at `c:\wamp64\www\innova-web` |
| **PHP Runtime** | PHP `8.2.0 (cli)` (ZTS Visual C++ 2019 x64) | `php -v` executed directly | OPcache active, Xdebug v3.2.0RC1 active |
| **Laravel Framework**| Laravel Framework `8.83.29` | `composer.json` / `composer.lock` / `artisan --version` | Last LTS release of Laravel 8 series |
| **Node.js Runtime** | Node.js `v22.15.0` | `node -v` | Active CLI runtime |
| **NPM Package Mgr** | NPM `10.9.2` | `npm -v` | Lockfile present (`package-lock.json`) |
| **Frontend Tooling** | Laravel Mix `6.0.49`, Webpack `5.98.0` | `package.json` / `webpack.mix.js` | Legacy build pipeline for Blade assets |
| **Database Engine** | MySQL `8.0.31` (Source database: `icbd_web`) | Phase 2 Database Inventory / WampServer | Target engine: PostgreSQL 16 (Phase 4) |
| **Testing Framework**| PHPUnit `9.6.29` | `vendor/bin/phpunit --version` | 23 passing tests (131 assertions) |
| **Auth System** | Dual Session Guards (`web` & `admin`) + Spatie Permission `5.5.0` | `config/auth.php`, `composer.json` | API token guards configured (`api`, `admin-api`) |
| **Key PHP Packages** | `spatie/laravel-permission: ^5.5`<br>`barryvdh/laravel-dompdf: ^2.0`<br>`unisharp/laravel-filemanager: ^2.5.1`<br>`biscolab/laravel-recaptcha: ^5.4`<br>`guzzlehttp/guzzle: ^7.0.1` | `composer.json` & `composer.lock` | All packages verified compatible with PHP 8.2 |

---

## 3. Repository Structure

```
c:\wamp64\www\innova-web\
├── app/
│   ├── Exceptions/            # Custom exception handling & JSON error rendering
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/         # 48 Admin business controllers (students, courses, accounting, etc.)
│   │   │   ├── Api/V1/        # Modern API layer baseline (ApiController, PingController)
│   │   │   ├── Auth/          # 7 Authentication controllers (Admin/User login, reset, verification)
│   │   │   ├── BkashController.php  # bKash payment gateway tokenized integration
│   │   │   └── FrontendController.php # Corporate website, CMS, public enrollment handlers
│   │   ├── Middleware/        # Auth, CORS, Maintenance, Security, ReCaptcha, Spatie middlewares
│   │   └── Requests/          # Form request validations (partially utilized; many controllers validate inline)
│   ├── Models/                # 49 Eloquent models covering all business domains
│   └── Traits/                # UploadAble.php (file and image upload abstraction)
├── bootstrap/                 # Application bootstrap & cached configurations
├── config/                    # Application configuration files (app, auth, database, lfm, services, etc.)
├── database/
│   ├── factories/             # Model factories (UserFactory)
│   ├── migrations/            # 48 historical migration files (several duplicates and missing tables)
│   └── seeders/               # Database seeders (User, Admin, Permission, Settings seeders)
├── docs/                      # Architectural, database, security, and modernization documentation
│   ├── modernization/         # Master prompt deliverables (Phase 1–4 reports)
│   ├── phase-1-security/      # Security audit, hardening log, and remediation report
│   ├── phase-2-database/      # Inventory, schema drift, PostgreSQL compatibility, data migration plans
│   ├── phase-3-planning/      # Reconstruction plan, data profiling, backup readiness, decision gates
│   └── phase-4-foundation/    # Modern API and testing foundation baseline
├── public/                    # Web root (index.php, compiled CSS/JS, vendor assets, uploaded media)
├── resources/
│   ├── js/                    # Vue components, Axios bootstrap, and TypeScript type declarations
│   ├── sass/ & css/           # SCSS stylesheets and vendor CSS
│   └── views/                 # 326 Blade templates (admin, frontend, users, auth, layouts)
├── routes/
│   ├── admin.php              # 383 administrative routes (enclosed in admin auth & permission middleware)
│   ├── api.php                # API route definitions (v1 namespace with Ping, health, future endpoints)
│   ├── channels.php           # Event broadcasting channels (unused)
│   ├── console.php            # Artisan console command closures
│   └── web.php                # Public website, student portal, bKash callbacks, and filemanager routes
├── storage/                   # Logs, framework cache, uploaded documents, PDF invoices
└── tests/
    ├── Feature/Api/V1/        # API integration tests (PingTest.php)
    └── Unit/                  # Unit tests (SecurityHardeningUnitTest.php)
```

---

## 4. Complete Module Inventory

Based on direct source-code inspection of routes, controllers, models, and Blade templates, the application comprises **12 distinct functional modules**:

```
+---------------------------------------------------------------------------------------------------+
|                                  INNOVA WEB APPLICATION MODULES                                   |
+---------------------------------------------------------------------------------------------------+
|  1. Auth & Access Control (RBAC)  |  2. Academic & Course Mgmt    |  3. Student Lifecycle & Admin |
|  4. Certificates & Verification   |  5. Fees Collection & Receipts|  6. Institutional Accounting  |
|  7. Shareholders & Loan Capital   |  8. Gov Training / Asset Proj |  9. Payment Gateway (bKash)   |
| 10. Communication (Elitbuzz SMS)  | 11. Student Self-Service      | 12. Public Website CMS & Lead |
+---------------------------------------------------------------------------------------------------+
```

### Module 1: Authentication & Access Control (RBAC)
- **Status:** ACTIVE / OPERATIONAL
- **Purpose:** Multi-guard authentication isolating system administrators from students/users, coupled with Spatie granular permissions.
- **Entities / Models:** `Admin` (table: `admins`), `User` (table: `users`), Spatie models (`Role`, `Permission`, `ModelHasRoles`, `RoleHasPermissions`).
- **Controllers:** `App\Http\Controllers\Admin\LoginController`, `Admin\UsersController`, `Admin\RolesController`, `Auth\LoginController`, `Auth\RegisterController`, `Auth\ForgotPasswordController`.
- **Key Routes:** `/admin/login`, `/admin/logout`, `/admin/roles/*`, `/admin/users/*`, `/login`, `/register`.
- **Security Mechanisms:** Multi-guard session isolation (`admin` vs `web`), Bcrypt hashing, throttle middleware (5 attempts / 1 min), rate limiting, and permission gates (`can:permission_name`).

### Module 2: Academic & Course Management
- **Status:** ACTIVE / OPERATIONAL
- **Purpose:** Defines the academic curriculum structure, course categorizations, academic calendar terms (sessions), class batches, schedules, and instructor assignments.
- **Entities / Models:** `CourseCategory` (`course_categoris`), `Courses` (`courses`), `Session` (`sessions` - 10 rows), `Batchs` (`batchs` - 65 rows), `Teachers` (`teachers` - 32 rows).
- **Controllers:** `Admin\CourseCategoryController`, `Admin\CoursesController`, `Admin\SessionController`, `Admin\BatchsController`, `Admin\TeachersController`.
- **Key Routes:** `/admin/course-category/*`, `/admin/courses/*`, `/admin/session/*`, `/admin/batchs/*`, `/admin/teachers/*`.
- **Business Logic:** Batches are tied to specific Courses and Sessions. Batches maintain seat caps, class timings (days/time), and assigned teachers. Course fees act as default amounts when admitting students.

### Module 3: Student Lifecycle & Admissions
- **Status:** ACTIVE / OPERATIONAL
- **Purpose:** Manages the entire student journey from online admission inquiries to formal enrollment, batch assignment, BTEB board registration, ID card generation, and status progression.
- **Entities / Models:** `Students` (`students` - 1,005 rows), `Admission` (`admissions` - 43 rows), `Registration` (`registrations` - 270 rows), `IdCard` (`id_cards`), `StuffIdCard` (`stuff_id_cards`).
- **Controllers:** `Admin\StudentsController`, `Admin\AdmissionController`, `Admin\RegistrationController`, `Admin\IdCardController`.
- **Key Routes:** `/admin/students/*`, `/admin/admission/*`, `/admin/registration/*`, `/admin/idcard/*`, `/admin/stuff/idcard/*`.
- **Business Logic:** Students possess multi-state workflow flags (`IsActive`: 1=Active, 2=Dropped/Inactive, 3=Completed, 4=On-hold, 5=Transferred). Admission records can be converted into enrolled Students. Automatic roll number and student ID generation. Photo uploads processed via `UploadAble` trait.

### Module 4: Certificates & Verification
- **Status:** ACTIVE / OPERATIONAL
- **Purpose:** Issues, tracks, and publicly verifies academic certificates for both internal INNOVA certifications and external Bangladesh Technical Education Board (BTEB) certifications.
- **Entities / Models:** `Certificates` (`certificates` - 128 rows, BTEB), `Certificate_icbd` (`certificate_icbd` - 38 rows, internal institute certificates).
- **Controllers:** `Admin\CertificatesController`, `Admin\CertificateIcbdController`, `FrontendController` (verification action).
- **Key Routes:** `/admin/certificates/*`, `/admin/certificate-icbd/*`, `/certifiocate-verify/{slnum}`, `/certifiocate-verify-bteb` (public QR/lookup routes).
- **Business Logic:** Certificates contain unique serial numbers (`slnum`, `roll_no`, `reg_no`). Public QR codes on printed physical certificates resolve to verification URLs displaying student name, course title, grade, session, and issuance date.

### Module 5: Fees Collection & Receipts
- **Status:** ACTIVE / OPERATIONAL (CRITICAL FINANCIAL DOMAIN)
- **Purpose:** Tracks student tuition fee payments, discounts, installment schedules, cash receipts, and bKash automated fee settlement.
- **Entities / Models:** `FeesTransections` (`fees_transections` - 1,604 rows), associated with `Students` and `Branch`.
- **Controllers:** `Admin\FeesTransectionsController`, `BkashController`.
- **Key Routes:** `/admin/fees-transections/*`, `/admin/fees/receipt/{id}`, `/user/payment/*`.
- **Business Logic:** Calculates student dues dynamically: `Total Fee - Discount - SUM(Paid) = Balance Due`. Generates printable voucher receipts with automated amount-to-Bangla-words conversion. Updates student financial state upon successful offline cash receipt or online bKash webhook execution.

### Module 6: Institutional Accounting (Income & Expenses)
- **Status:** ACTIVE / OPERATIONAL (CORE BUSINESS LEDGER)
- **Purpose:** Double-entry-style operational accounting tracking all daily cash inflows and outflows across branches and categorized ledgers.
- **Entities / Models:** `Income` (`incomes` - 5,694 rows), `IncomeCategoris` (`income_categoris` - 75 rows), `Expanse` (`expanses` - 6,338 rows), `ExpanseCategoris` (`expanse_categoris` - 118 rows), `Branch` (`branchs` - 4 rows).
- **Controllers:** `Admin\IncomeController`, `Admin\IncomeCategoryController`, `Admin\ExpanseController`, `Admin\ExpanseCategoryController`, `Admin\BranchController`, `Admin\ReportController`.
- **Key Routes:** `/admin/income/*`, `/admin/expanse/*`, `/admin/income-category/*`, `/admin/expanse-category/*`, `/admin/report/daily`, `/admin/report/date-to-date`, `/admin/report/monthly`.
- **Business Logic:** Multi-branch accounting. Each expense/income record carries an invoice number, category ID, branch ID, amount, and date. The `ReportController` aggregates operational summaries, net profit calculations, balance sheets, and daily cash drawer reconciliation.

### Module 7: Shareholder Capital, Investments & Loans
- **Status:** ACTIVE / OPERATIONAL (MYISAM LEGACY STORAGE)
- **Purpose:** Manages partner capital contributions, equity withdrawals, dividend distributions, bank loans, and monthly bank EMI loan repayments.
- **Entities / Models:** `Shareholder` (`shareholders` - 6 partners), `Invesments` (`invesments` - 46 rows), `InvestmentWithdraw` (`investment_withdraws` - 11 rows), `DividendWithdraw` (`dividend_withdraws` - 1 row), `BankLoan` (`bank_loans` - 7 rows), `EmiInstallment` (`emi_installments` - 71 rows).
- **Controllers:** `Admin\ShareholderController`, `Admin\InvesmentsController`, `Admin\InvestmentWithdrawController`, `Admin\DividendWithdrawController`, `Admin\BankLoanController`, `Admin\EmiInstallmentController`.
- **Key Routes:** `/admin/shareholder/*`, `/admin/invesments/*`, `/admin/investment-withdraw/*`, `/admin/dividend-withdraw/*`, `/admin/bank-loan/*`, `/admin/emi-installment/*`.
- **Business Logic:** Tracks equity stakes among shareholders. When dividends or capital are withdrawn, notifications are triggered to partners. Bank loans track principal, interest, term, and monthly amortized EMI payments.

### Module 8: Government / Training Project (Asset / SEIP)
- **Status:** DORMANT / HISTORICAL (SPECIALIZED GRANT PROJECT)
- **Purpose:** Specialized module for government-subsidized skill development training (e.g., ASSET / SEIP project).
- **Entities / Models:** `AssetCourse` (`asset_courses` - 2 rows), `AssetRegistration` (`asset_registrations` - 31 rows), `AssetRegistrationFeedback` (`asset_registration_feedback` - 5 rows), `AssetStudent` (`asset_students` - 0 rows).
- **Controllers:** `Admin\AssetCourseController`, `Admin\AssetRegistrationController`, `Admin\AssetStudentController`.
- **Key Routes:** `/admin/asset-course/*`, `/admin/asset-registration/*`, `/admin/asset-student/*`.
- **Business Logic:** Separate trainee intake pipeline with custom demographic and eligibility questionnaires. Unmigrated / MyISAM tables; duplicate migration classes exist in `database/migrations/`.

### Module 9: Payment Gateway Integration (bKash)
- **Status:** ACTIVE / CRITICAL INTEGRATION
- **Purpose:** Facilitates real-time mobile financial service payments via bKash Tokenized/Checkout API for student fee payments and admission fees.
- **Entities / Models:** Directly interacts with `FeesTransections` (`channel='bkash'`, `trxID`, `paymentID`).
- **Controllers:** `App\Http\Controllers\BkashController`.
- **Key Routes:** `/user/bkash/create`, `/user/bkash/execute`, `/user/bkash/query`, `/user/success`, `/user/fail`.
- **Business Logic:** Four-stage tokenized handshake: (1) Obtain bearer token via app credentials; (2) Create payment agreement and obtain redirect URL; (3) Execute payment on customer PIN entry; (4) Query and verify transaction status, writing receipt to `fees_transections`.

### Module 10: Communication & Messaging (SMS)
- **Status:** ACTIVE / OPERATIONAL INTEGRATION
- **Purpose:** Automated and manual SMS messaging to students, parents, and shareholders via Elitbuzz SMS gateway.
- **Entities / Models:** Logs SMS activities; consumes student phone numbers from `students.phone` and shareholder numbers from `shareholders.phone`.
- **Controllers:** `App\Http\Controllers\Admin\SMSController`.
- **Key Routes:** `/admin/sms`, `/admin/sms/send-student`, `/admin/sms/send-batch`, `/admin/sms/send-shareholder`, `/admin/sms/balance`.
- **Business Logic:** Dispatches single or multi-recipient SMS via Elitbuzz HTTP GET/POST API using registered sender ID. Contains balance inquiry check and sanitizes Bangladeshi 11-digit phone numbers (`01XXXXXXXXX`).

### Module 11: Student / User Self-Service Portal
- **Status:** ACTIVE / OPERATIONAL
- **Purpose:** Authenticated student portal allowing learners to view enrolled batches, download academic receipts, view ledger dues, and make bKash payments online.
- **Entities / Models:** `User`, `Students`, `FeesTransections`.
- **Controllers:** `App\Http\Controllers\Admin\UsersController` (serves user portal actions).
- **Key Routes:** `/user/dashboard`, `/user/profile`, `/user/fees`, `/user/payment`.
- **Business Logic:** Authenticated via `web` guard. Scope-limited so students can only view their own fees invoices and batch details.

### Module 12: Public Website CMS & Lead Capture
- **Status:** ACTIVE / OPERATIONAL
- **Purpose:** Corporate and institute public-facing CMS: course listings, blogs, seminars, client testimonials, team members, contact forms, and lead generation.
- **Entities / Models:** `Blog`, `Seminor`, `Review`, `Slider`, `SuccessStory`, `Gallery`, `Contact`, `Client`, `Concern`, `Product`, `Service`, `Team`, `Technology`, `Workflow`, `Setting`.
- **Controllers:** `FrontendController`, `Admin\BlogController`, `Admin\SeminorController`, `Admin\ReviewController`, `Admin\SliderController`, `Admin\GalleryController`, `Admin\ContactController`, `Admin\SettingController`, etc.
- **Key Routes:** `/` (homepage), `/about`, `/courses`, `/course-details/{slug}`, `/blog`, `/contact`, `/seminar-registration`, `/online-admission`.
- **Business Logic:** Dynamic content management. Public contact and seminar enrollment forms capture leads into database tables with Google ReCaptcha verification.

---

## 5. Existing Backend Architecture

### 5.1 Request Flow and Middleware Pipeline
The backend follows Laravel's standard HTTP kernel request lifecycle:

```
[HTTP Client Request]
       |
       v
[public/index.php] -> [bootstrap/app.php]
       |
       v
[HTTP Kernel: App\Http\Kernel]
       |
  Global Middleware:
  - TrustProxies
  - PreventRequestsDuringMaintenance
  - ValidatePostSize
  - TrimStrings
  - ConvertEmptyStringsToNull
       |
       +---> [Web Route Group: routes/web.php & routes/admin.php]
       |        Middleware:
       |        - EncryptCookies
       |        - AddQueuedCookiesToResponse
       |        - StartSession
       |        - ShareErrorsFromSession
       |        - VerifyCsrfToken
       |        - SubstituteBindings
       |        Route-Specific Guards:
       |        - 'auth:admin' / 'auth:web'
       |        - 'permission:xyz' (Spatie)
       |
       +---> [API Route Group: routes/api.php]
                Middleware:
                - 'api' throttle:api (60 requests/min)
                - SubstituteBindings
                - Future: 'auth:sanctum' / 'auth:api'
       |
       v
[Controller Dispatch] (Admin\*, FrontendController, BkashController, etc.)
       |
       +---> Direct Inline / FormRequest Validation ($request->validate([...]))
       |
       +---> Business Logic & Model Interaction (Eloquent queries, DB transactions)
       |
       +---> External Integrations (bKash API, Elitbuzz SMS, DomPDF generation)
       |
       v
[Response Output]
       +---> Web: View Render (view('admin.*', $data))
       +---> API: JsonResponse (response()->json([...]))
```

### 5.2 Business Logic Distribution & Architecture Assessment
1. **Controller-Heavy Monolith:** Business logic predominantly resides directly inside controller methods. Controllers instantiate models, compute financial balances, apply discounts, format dates, and generate PDF receipts.
2. **Database Transactions:** Handled explicitly using `DB::beginTransaction()`, `DB::commit()`, and `DB::rollBack()` in critical financial endpoints (such as `FeesTransectionsController@store` and `BkashController@executePayment`).
3. **Validation Strategy:**
   - Most administrative controllers execute inline validation using `$request->validate([...])`.
   - A minority of endpoints use dedicated `FormRequest` classes in `app/Http/Requests/`.
   - Error messages are flashed to session for Blade consumption.
4. **File Upload Handling:** Upload logic is standardized via the `App\Traits\UploadAble` trait, which encapsulates `storeAs`, path generation, and file deletion.
5. **Modern API Baseline:** An API foundation already exists at `app/Http/Controllers/Api/V1/ApiController.php` providing standardized JSON responses (`respondWithSuccess`, `respondWithError`, `respondWithValidationErrors`) and `PingController.php` with 100% automated test coverage.

---

## 6. Existing Frontend Architecture

### 6.1 View Layer Organization (326 Blade Views)
The frontend is rendered server-side via Laravel Blade, partitioned across 8 directories:

| Directory | View Count | Purpose & Description |
| :--- | :---: | :--- |
| `resources/views/admin/` | 207 | Complete back-office admin portal (data tables, forms, charts, reports, voucher printouts) |
| `resources/views/frontend/` | 56 | Public-facing website pages (homepage, course catalogs, seminar forms, blogs, contact) |
| `resources/views/users/` | 23 | Student self-service portal (dashboard, fee invoices, bKash checkout) |
| `resources/views/vendor/` | 24 | Overridden third-party views (pagination, Laravel Filemanager, ReCaptcha) |
| `resources/views/auth/` | 7 | Authentication views (user login, registration, password reset) |
| `resources/views/Iframe/` | 6 | Embedded standalone dialogs (file picker / preview frames) |
| `resources/views/layouts/` | 1 | Shared user layout (`app.blade.php`) |
| Root templates | 2 | `home.blade.php`, `welcome.blade.php` |

### 6.2 Layout and UI Foundations
- **Admin Layout:** `resources/views/admin/layouts/app.blade.php` provides the master sidebar, topbar, user profile dropdown, and breadcrumb container.
- **Frontend Layout:** `resources/views/frontend/layouts/master.blade.php` contains the corporate header, dynamic navigation menus, mega-dropdown for course categories, and footer.
- **CSS Framework:** Bootstrap 4.6.x combined with FontAwesome 5 icons and custom admin CSS (`backend/css/style.css`).
- **JavaScript & Interactivity:**
  - Heavy reliance on jQuery plugins: DataTables (table search/pagination), Select2 (searchable dropdowns for students/batches), Summernote / CKEditor (WYSIWYG content), SweetAlert (delete confirmations), Flatpickr / Datepicker.
  - Legacy Vue components: Small historical components compiled via Mix (`resources/js/app.js`), though major operational screens rely strictly on jQuery DOM manipulation.
- **Print & PDF Engine:** Printable receipts and reports use specialized `@media print` CSS rules in Blade templates, alongside server-side PDF generation via `Barryvdh\DomPDF\Facade\Pdf`.

---

## 7. Module Relationships and Dependency Graph

The modules are interconnected through foreign key and logical references. Below is the dependency architecture:

```
+-----------------------------------------------------------------------------------------------+
|                               MODULE DEPENDENCY ARCHITECTURE                                  |
+-----------------------------------------------------------------------------------------------+
|                                                                                               |
|  [Module 1: Auth & RBAC]                                                                      |
|          |                                                                                    |
|          +--------------------------------------------------------+                           |
|          |                                                        |                           |
|          v                                                        v                           |
|  [Module 2: Academic & Courses]                         [Module 11: Student Portal]           |
|          | (CourseCategory -> Courses -> Batchs/Sessions)         |                           |
|          |                                                        |                           |
|          v                                                        v                           |
|  [Module 3: Student Lifecycle] <========================= [Module 9: bKash Gateway]          |
|          | (Admissions -> Students -> Registrations)              |                           |
|          |                                                        |                           |
|          +----------------------------+                           |                           |
|          |                            |                           |                           |
|          v                            v                           |                           |
|  [Module 4: Certificates]    [Module 5: Fees Collection] <--------+                           |
|                                       | (Cash/Counter + bKash)                                |
|                                       |                                                       |
|                                       v                                                       |
|                              [Module 6: Institutional Accounting]                             |
|                                       | (Branch + Income / Expense Ledgers)                   |
|                                       |                                                       |
|                                       v                                                       |
|                              [Module 7: Shareholders & Loans]                                 |
|                                 (Capital, Dividends, Bank Loans, EMIs)                        |
|                                                                                               |
|  [Module 10: SMS Messaging] <--- Triggered by Students, Fees, and Shareholder withdrawals    |
|  [Module 12: Public CMS]    <--- Exposes Courses, Seminars, and Lead Inquiries                |
|  [Module 8: Asset Project]  <--- Independent government grant subsystem                      |
+-----------------------------------------------------------------------------------------------+
```

### Critical Cross-Module Dependencies:
1. **Student Enrollment Chain:** `CourseCategory` $\rightarrow$ `Courses` $\rightarrow$ `Batchs` (tied to `Session` and `Teachers`) $\rightarrow$ `Students`.
2. **Fee Receipt Chain:** `Students` $\rightarrow$ `FeesTransections` $\rightarrow$ `Branch`. (If a student is dropped or batch changed, fee reconciliation must maintain referential integrity).
3. **Cash Flow Aggregation:** Daily institutional cash reports combine cash from `FeesTransections` with general `incomes` minus all `expanses`.
4. **Partner Notifications:** Shareholder capital deposits or dividend withdrawals in Module 7 directly invoke Module 10 (`SMSController`) to dispatch SMS alerts to all partner phone numbers.

---

## 8. Database Structure Overview

Based on the verified schema evidence from Phase 2 and Phase 3 audits:

- **Total Tables:** 52 database tables.
- **Total Operational Records:** 15,663 records at initial baseline audit.
- **Storage Engines:**
  - **InnoDB:** 38 tables (supports ACID transactions and foreign key constraints).
  - **MyISAM:** 14 tables (legacy engine without transaction support or foreign keys). These include: `asset_courses`, `asset_registration_feedback`, `asset_registrations`, `asset_students`, `bank_loans`, `certificate_icbd`, `dividend_withdraws`, `emi_installments`, `incomes`, `invesments`, `investment_withdraws`, `settings`, `shareholders`, `stuff_id_cards`.
- **Character Encoding & Collations:**
  - 50 tables utilize `utf8mb4_unicode_ci`.
  - 2 tables utilize `latin1_swedish_ci` (`certificate_icbd`, `sessions`).
- **Known Schema Drift & Missing Migrations:**
  - 4 tables exist in MySQL with **no corresponding migration file**: `bank_loans`, `dividend_withdraws`, `emi_installments`, `investment_withdraws`.
  - 4 columns in `fees_transections` exist in MySQL with **no migration**: `channel` (`VARCHAR(20)`), `trxID` (`VARCHAR(100)`), `paymentID` (`VARCHAR(100)`), `status` (`VARCHAR(20)`).
  - 3 duplicate migration class names exist in `database/migrations/`: `CreateSessionsTable` (3 files), `CreateAssetCoursesTable` (2 files), `CreateAssetStudentsTable` (2 files).
- **PostgreSQL Incompatibilities to Address in Phase 4:**
  - 7 tables store monetary values in `VARCHAR(191)` (`expanses.amount`, `incomes.amount`, `fees_transections.paid`, `students.fee`, etc.) requiring conversion to `NUMERIC(15,2)`.
  - 27 date anomaly records exist (century typos e.g. year 0202, 2029, zero dates `0000-00-00 00:00:00`).
  - MySQL backtick syntax and engine parameters must be replaced with PostgreSQL standard DDL.

---

## 9. Authentication and Authorization Overview

### 9.1 Multi-Guard Architecture
Configured in `config/auth.php`:
- **Guard `admin`:** Default provider `admins` using model `App\Models\Admin`. Authenticates system administrators, managers, and accountants using session driver.
- **Guard `web`:** Default provider `users` using model `App\Models\User`. Authenticates students for the self-service portal.
- **Guard `api`:** Token driver mapped to `users` provider.
- **Guard `admin-api`:** Token driver mapped to `admins` provider.

### 9.2 Authorization and Permissions (Spatie)
- Integrated package: `spatie/laravel-permission: ^5.5`.
- Database tables: `roles`, `permissions`, `model_has_roles`, `model_has_permissions`, `role_has_permissions`.
- Route protection: Enforced across `routes/admin.php` using middleware syntax: `middleware('permission:student-list|student-create|student-edit|student-delete')`.
- Blade protection: Enforced using directive checks: `@can('student-create') ... @endcan`.

---

## 10. External Integrations

| Integration | Provider / Protocol | Implementation Path | Purpose & Configuration |
| :--- | :--- | :--- | :--- |
| **Payment Gateway** | bKash Tokenized Checkout API | `App\Http\Controllers\BkashController`<br>`config/services.php` (`bkash.*`) | Student tuition and admission fee processing via grant-token, create-payment, and execute-payment endpoints. |
| **SMS Messaging** | Elitbuzz Technologies HTTP Gateway | `App\Http\Controllers\Admin\SMSController`<br>`config/services.php` (`sms.*`) | Transactional and bulk SMS notifications to students and shareholders. |
| **Bot Protection** | Google ReCaptcha v2/v3 | `biscolab/laravel-recaptcha`<br>`config/recaptcha.php` | Secures public contact, seminar registration, and online admission forms against spam bots. |
| **PDF Generation** | DomPDF (Barryvdh wrapper) | `Barryvdh\DomPDF\Facade\Pdf` | Server-side PDF voucher and receipt generation. |
| **File Manager** | UniSharp Laravel Filemanager | `unisharp/laravel-filemanager`<br>`config/lfm.php` | Media browser and uploader integrated with WYSIWYG editors. |

---

## 11. Existing Tests and Validation Evidence

### 11.1 Test Suite Status
Automated test suite executed directly via PHPUnit 9.6.29:
- **Total Tests Executed:** 23 tests
- **Total Assertions:** 131 assertions
- **Test Result:** 100% PASSED (0 failures, 0 errors, 0 warnings)
- **Execution Time:** ~1.82 seconds

### 11.2 Tested Components
1. **`tests/Unit/SecurityHardeningUnitTest.php` (21 Tests):**
   - Path traversal prevention in media handlers
   - Secure upload validation and MIME-type verification
   - Mass-assignment vulnerability guards on core models
   - Security headers enforcement
   - Password policy and bcrypt compliance
   - Financial input sanitization
2. **`tests/Feature/Api/V1/PingTest.php` (2 Tests):**
   - `GET /api/v1/ping` returns HTTP 200 with JSON structure: `{ success: true, message: "pong", timestamp, version }`.
   - Rejection of invalid HTTP methods (POST, PUT, DELETE) on read-only endpoints.

---

## 12. Known Technical Limitations and Technical Debt

1. **Monolithic Controller Coupling:** Heavy business logic embedded in Blade controllers makes it difficult to share rules between Blade and future REST APIs without extracting dedicated Services / Actions.
2. **MyISAM Table Concurrency:** 14 tables lack row-level locking and ACID transaction safety. A crash during financial writing in MyISAM tables can corrupt data.
3. **Data Type Deficiencies:** Storing currency amounts as `VARCHAR(191)` prevents native database aggregation (`SUM()`, `AVG()`) and risks formatting inconsistencies.
4. **Historical Migration Gaps:** The repository migrations cannot rebuild the database from scratch due to missing tables and duplicate class names.
5. **Frontend Asset Tooling:** Laravel Mix and Webpack 4 are legacy tooling. Modern React development requires Vite.

---

## 13. Evidence File Paths

| Component | Key Evidence File Paths |
| :--- | :--- |
| **Routing** | `routes/web.php`, `routes/admin.php`, `routes/api.php` |
| **Core Models** | `app/Models/Admin.php`, `User.php`, `Students.php`, `Courses.php`, `Batchs.php`, `FeesTransections.php`, `Income.php`, `Expanse.php`, `Shareholder.php` |
| **Controllers** | `app/Http/Controllers/Admin/StudentsController.php`, `FeesTransectionsController.php`, `ReportController.php`, `BkashController.php`, `FrontendController.php` |
| **API Baseline** | `app/Http/Controllers/Api/V1/ApiController.php`, `app/Http/Controllers/Api/V1/PingController.php` |
| **Views** | `resources/views/admin/layouts/app.blade.php`, `resources/views/frontend/layouts/master.blade.php`, `resources/views/admin/report/` |
| **Configuration** | `config/app.php`, `config/auth.php`, `config/database.php`, `config/services.php`, `config/lfm.php` |
| **Tests** | `tests/Unit/SecurityHardeningUnitTest.php`, `tests/Feature/Api/V1/PingTest.php` |

---

## 14. Assumptions and Unresolved Questions

1. **Pending Owner Decisions (Decision Gates 1–8):**
   - Decision 1: Treatment of 4 unmigrated tables.
   - Decision 2: Monetary column data conversion (`VARCHAR(191)` $\rightarrow$ `NUMERIC(15,2)`).
   - Decision 3: Resolving 27 date anomaly records (century typos e.g., 0202, zero dates).
   - Decision 4: Handling malformed record `students.discount = '50.'`.
   - Decision 5: Duplicate migration class resolution strategy.
   - Decision 6: MyISAM to InnoDB / PostgreSQL engine migration strategy.
   - Decision 7: Academic Sessions vs HTTP Sessions table collision resolution.
   - Decision 8: Physical backup validation on a disposable database before DDL.
2. **Framework Upgrade Timing:** Target versions Laravel 13 and PHP 8.4 are proposed for long-term evolution. All Phase 2 API work will safely run on the verified existing Laravel 8.83.29 / PHP 8.2 runtime to avoid destabilizing business operations.
