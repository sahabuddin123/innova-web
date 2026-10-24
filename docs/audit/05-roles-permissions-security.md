# 05. Roles, Permissions, and Security Audit

**Project:** `innova-web` (INNOVA Computers BD / ICBD)  
**Audit Date:** October 13, 2026  
**Auditor:** Antigravity Agentic Audit (Phase 0 Discovery)  
**Strict Constraint:** Read-Only Audit (No code/configuration/data changes made; all secrets strictly redacted)

---

## 1. Authentication Systems and Guards

The application implements multi-auth guards in [`config/auth.php`](file:///c:/wamp64/www/innova-web/config/auth.php):

| Guard Name | Driver | Provider / Model | Storage / Session | Security Assessment |
|---|---|---|---|---|
| `web` | `session` | `users` ([`User.php`](file:///c:/wamp64/www/innova-web/app/Models/User.php)) | Cookie session (`users` table) | Standard Laravel session auth |
| `admin` | `session` | `admins` ([`Admin.php`](file:///c:/wamp64/www/innova-web/app/Models/Admin.php)) | Cookie session (`admins` table) | Independent admin guard; **missing login throttling** |
| `api` | `token` | `users` | Plaintext API token | **Insecure:** `'hash' => false` stores API tokens unhashed |
| `admin-api` | `token` | `admins` | Plaintext API token | **Insecure:** `'hash' => false` stores API tokens unhashed |

---

## 2. Roles, Permissions, and Authorization (RBAC) Inventory

### 2.1 Spatie Permission Setup
The application includes `spatie/laravel-permission: ^5.5`.
- **Database Tables:** `roles`, `permissions`, `model_has_roles`, `model_has_permissions`, `role_has_permissions`.
- **Discovered Roles (from verified SQL dump):** 3 roles (`Admin`, `Super Admin`, `Manager`).
- **Discovered Permissions:** 55 discrete permissions covering modules (e.g., `role-list`, `role-create`, `role-edit`, `role-delete`, `user-list`, `user-create`).

### 2.2 Critical Finding: Complete Absence of RBAC in Business Controllers
- While permissions are defined in the database, the Spatie permission middleware `$this->middleware('permission:...')` is **only implemented in a single controller**: [`Admin\RoleController.php`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/RoleController.php).
- **The other 48 administrative controllers contain ZERO permission checks or policy checks.**
- The routes in [`routes/admin.php`](file:///c:/wamp64/www/innova-web/routes/admin.php) are wrapped solely in `['middleware' => ['auth:admin']]`.
- **Impact:** Any user authenticated with the `admin` guard—regardless of whether their assigned role is "Manager", "Receptionist", or "Viewer"—can create, modify, delete, and view student payments, institutional expenses, incomes, investments, and shareholder dividends. There is zero horizontal or vertical segregation of duties.

---

## 3. Middleware and Request Pipeline Review

### 3.1 Global & Route Middleware Inventory (`app/Http/Kernel.php`)
- **Global HTTP Middleware:**
  - `CheckForMaintenanceMode`
  - `ValidatePostSize`
  - `TrimStrings`
  - `ConvertEmptyStringsToNull`
  - `TrustProxies` (`fideloper/proxy`)
- **Web Middleware Group:**
  - `EncryptCookies`
  - `AddQueuedCookiesToResponse`
  - `StartSession`
  - `ShareErrorsFromSession`
  - `VerifyCsrfToken`
  - `SubstituteBindings`
- **Route Middleware:**
  - `auth` → `Authenticate`
  - `auth.basic` → `AuthenticateWithBasicAuth`
  - `guest` → `RedirectIfAuthenticated`
  - `signed` → `ValidateSignature`
  - `throttle` → `ThrottleRequests`
  - `role` → `Spatie\Permission\Middlewares\RoleMiddleware`
  - `permission` → `Spatie\Permission\Middlewares\PermissionMiddleware`

### 3.2 CSRF Protection Evaluation
- CSRF verification is globally active on the `web` middleware group via [`App\Http\Middleware\VerifyCsrfToken`](file:///c:/wamp64/www/innova-web/app/Http/Middleware/VerifyCsrfToken.php).
- The `$except` array is empty (`protected $except = [];`).
- **Bypass / Exposure Point:** Multiple operations that alter database state or execute heavy CLI commands are routed over HTTP `GET` requests (e.g. `/admin/configcatche`, `/admin/storagelink`, `/user/success`, and legacy `/delete` routes in `app/Http/Controllers/Admin/admin.php`). Because HTTP GET requests are immune to CSRF verification by specification, these state-changing actions are vulnerable to CSRF and prefetching.

---

## 4. File Upload Security Assessment

### 4.1 Unrestricted File Upload in System Settings (RCE Vulnerability)
- **Location:** [`SettingController.php:L35-50`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/SettingController.php#L35-L50)
- **Implementation:**
  ```php
  if ($request->has('site_logo') && ($request->file('site_logo') instanceof UploadedFile)) {
      if (config('settings.site_logo') != null) {
          $this->deleteOne(config('settings.site_logo'));
      }
      $logo = $this->uploadOne($request->file('site_logo'), 'img');
      Setting::set('site_logo', $logo);
  }
  ```
- **Vulnerability:**
  1. The controller applies **no validation rules** (`$request->validate(...)` is absent).
  2. The underlying trait [`UploadAble.php:L27`](file:///c:/wamp64/www/innova-web/app/Traits/UploadAble.php#L27) saves the file as `$name . "." . $file->getClientOriginalExtension()`.
  3. The client supplies the extension directly. An attacker can upload a file named `shell.php` as the site logo, which will be stored on the public storage disk as `storage/img/shell.php`.
  4. Root [`.htaccess:L9-12`](file:///c:/wamp64/www/innova-web/.htaccess#L9-L12) explicitly contains:
     ```apache
     <FilesMatch ".(php7|phtml|php)$">
     Order allow,deny
     Allow from all
     </FilesMatch>
     ```
     This allows Apache to execute PHP scripts inside web-accessible storage directories, leading directly to **Remote Code Execution (RCE)**.

### 4.2 Known Vulnerabilities in Filemanager (`unisharp/laravel-filemanager`)
- Package version: `^2.5`
- Known CVEs:
  - `CVE-2024-21546` (**High Severity Code Injection / RCE**): Insufficient sanitization of uploaded files in file manager routes allows arbitrary script execution.
  - `CVE-2022-40734` (**Medium Severity Directory Traversal**): Allows traversing parent directories outside designated media folders.

---

## 5. Authentication, Passwords, and Session Security

### 5.1 Password Hashing
- Algorithm: Bcrypt (BcryptHasher) with work factor `10` (`config/hashing.php`).
- Hashing implementation: Standard `Hash::make()` in controllers and seeders.
- **Verification:** Verified in SQL dump; admin passwords and user passwords are stored as valid `$2y$10$` Bcrypt hashes. No plaintext passwords discovered in database schemas.

### 5.2 Login Throttling Failure
- In [`Admin\LoginController.php:L43-56`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/LoginController.php#L43-L56), the `login()` method overrides `AuthenticatesUsers`:
  ```php
  public function login(Request $request)
  {
      $this->validate($request, [
          'email'   => 'required|email',
          'password' => 'required|min:6'
      ]);
      if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
          return redirect()->intended(route('admin.dashboard'));
      }
      return back()->withInput($request->only('email', 'remember'));
  }
  ```
- **Finding:** No check for `hasTooManyLoginAttempts($request)`, no call to `incrementLoginAttempts($request)`, and no lockout response. The administrative login endpoint is unprotected against automated dictionary and credential-stuffing attacks.

---

## 6. Integrations Security Assessment

### 6.1 bKash Payment Gateway Integration
- **Credentials Storage:**
  - `BKASH_CHECKOUT_APP_KEY`, `BKASH_CHECKOUT_APP_SECRET`, `BKASH_CHECKOUT_USER_NAME`, `BKASH_CHECKOUT_PASSWORD` stored in plain text in `.env`.
- **Architectural Flaw:**
  - Called via `env()` in [`BkashController.php:L30, L67-68, L72`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/BkashController.php#L30) rather than `config()`.
- **Payment Verification Integrity:**
  - The payment completion endpoint `GET /user/success` does not verify payment status with bKash's `/checkout/payment/query` API or check transaction uniqueness against existing `fees_transections` rows before insertion.

### 6.2 SMS Gateway Integration (Elitbuzz)
- **Insecure cURL Transport:**
  - In [`SMSController.php:L32`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/SMSController.php#L32):
    ```php
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    ```
  - Disabling SSL peer certificate verification permits Man-in-the-Middle (MitM) interception and modification of SMS payloads.
- **Message Injection Risk:**
  - Student names (`$students['sname']`) are directly interpolated into Bengali message text strings without input sanitization or length truncation, risking multi-part SMS credit exhaustion.

---

## 7. Security Findings Matrix by Severity

| ID | Title | Severity | Location | Evidence / Mechanism | Remediation |
|---|---|---|---|---|---|
| **SEC-01** | Production Database Dump Exposed | **CRITICAL** | `resources/views/admin/report/innovacomputer_pay.sql` | 1.4 MB plain SQL dump with 5,045 lines of live records and password hashes. | Immediately remove from repository and Git history; rotate all credentials. |
| **SEC-02** | Hardcoded Production DB Credentials | **CRITICAL** | `config/database.php:L51-53` | Live MySQL username and password committed as default fallbacks. | Remove hardcoded credentials; change live database passwords. |
| **SEC-03** | Arbitrary File Upload to Storage (RCE Risk) | **HIGH** | `Admin\SettingController.php:L35-50`, `UploadAble.php:L27` | No file extension or mime validation; preserves client-supplied extension. | Implement strict validation (`mimes:png,jpg,jpeg,webp|max:2048`); hash filenames. |
| **SEC-04** | Remote Code Execution in UniSharp Filemanager | **HIGH** | `composer.json:L24` (`unisharp/laravel-filemanager`) | `CVE-2024-21546` & `CVE-2022-40734`. | Replace package with modern secure media library (e.g. Spatie Media Library). |
| **SEC-05** | Missing RBAC Authorization in Admin Controllers | **HIGH** | `app/Http/Controllers/Admin/*.php` (48 controllers) | Spatie middleware only present in `RoleController`. | Enforce permission middleware or policies across all admin resources. |
| **SEC-06** | Missing Login Throttling on Admin Portal | **HIGH** | `Admin\LoginController.php:L43-56` | Overridden login method omits `ThrottlesLogins`. | Restore Laravel's standard login throttling with exponential lockout. |
| **SEC-07** | SSL Verification Disabled in SMS cURL | **MEDIUM** | `Admin\SMSController.php:L32` | `CURLOPT_SSL_VERIFYPEER => false`. | Set `CURLOPT_SSL_VERIFYPEER => true` and verify CA certificates. |
| **SEC-08** | State-Changing Operations via HTTP GET | **MEDIUM** | `routes/admin.php:L31-51`, `routes/web.php:L103` | Artisan commands and payment completions mapped to GET. | Convert all state mutations to `POST` / `DELETE` with CSRF tokens. |
| **SEC-09** | Direct `env()` Usage Breaking Config Caching | **MEDIUM** | `BkashController.php`, `SMSController.php`, `FeesTransectionsController.php` | Direct `env()` returns `null` after `config:cache`. | Move all environment variables to `config/services.php` and use `config()`. |
| **SEC-10** | Unhashed API Token Driver Configuration | **LOW** | `config/auth.php:L47, L58` | `'hash' => false` for `api` and `admin-api` token guards. | Set `'hash' => true` or migrate to Laravel Sanctum. |
