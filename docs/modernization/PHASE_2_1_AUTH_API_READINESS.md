# PHASE 2.1 — AUTHENTICATION & AUTHORIZATION API READINESS REPORT
**Project:** INNOVA Computers BD Web System Modernization  
**Phase:** Phase 2.1 — Authentication & Authorization API Readiness  
**Status:** COMPLETE (Read-Only Readiness Assessment)  
**Date:** October 24, 2026  
**Auditor:** Senior Laravel API Engineer & Backend Architect  

---

## 1. Current Authentication Architecture

The INNOVA Computers BD web application utilizes a **multi-guard, multi-provider monolithic authentication architecture** built on Laravel 8.83.29.

### Key Architectural Characteristics:
- **Dual Identity Boundaries:** The application completely segregates administrative staff (`admins` table) from learners and public portal users (`users` table).
- **Session-Centric Web Pipeline:** The existing Blade user interfaces rely exclusively on session cookies (`laravel_session`), encrypted cookies, and CSRF token verification across `routes/web.php` and `routes/admin.php`.
- **API Placeholder Configuration:** In `config/auth.php`, `api` and `admin-api` guards are configured with the legacy `'driver' => 'token'`, which expects a static `api_token` column on the underlying database tables. However, neither `admins` nor `users` tables possess an `api_token` column. As a result, the default token driver is entirely inactive and non-functional.
- **Password Security:** Both `Admin` and `User` accounts authenticate using standard Bcrypt (`$2y$`) hashes verified via `Illuminate\Support\Facades\Hash`.

---

## 2. Existing Authentication Packages and Actual Configuration

A line-by-line inspection of `composer.json`, `composer.lock`, and configuration files confirms the following actual package state:

| Package | Status | Version / Details | Purpose in Existing Codebase |
| :--- | :---: | :--- | :--- |
| **`laravel/framework`** | Installed | `v8.83.29` | Core framework providing `Illuminate\Auth` session and token drivers |
| **`spatie/laravel-permission`** | Installed | `v5.5.0` (`^5.5`) | Role-based and permission-based authorization for administrative users |
| **`laravel/ui`** | Installed | `v3.4.6` (`^3.4`) | Scaffolds Blade authentication controllers and views (`AuthenticatesUsers` trait) |
| **`laravel/sanctum`** | **NOT INSTALLED** | Absent from `composer.json` & `composer.lock` | Not configured. No personal access token table exists |
| **`laravel/passport`** | **NOT INSTALLED** | Absent from `composer.json` & `composer.lock` | Not present |
| **`tymon/jwt-auth`** | **NOT INSTALLED** | Absent from `composer.json` & `composer.lock` | Not present |

### Verified `config/auth.php` Configuration:
```php
'defaults' => [
    'guard' => 'web',
    'passwords' => 'users',
],

'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'users',
    ],
    'api' => [
        'driver' => 'token',
        'provider' => 'users',
        'hash' => false,
    ],
    'admin' => [
        'driver' => 'session',
        'provider' => 'admins',
    ],
    'admin-api' => [
        'driver' => 'token',
        'provider' => 'admins',
        'hash' => false,
    ],
],

'providers' => [
    'users' => [
        'driver' => 'eloquent',
        'model' => App\Models\User::class,
    ],
    'admins' => [
        'driver' => 'eloquent',
        'model' => App\Models\Admin::class,
    ],
],
```

---

## 3. Admin and User Authentication Differences

The system treats `Admin` and `User` as distinct entities with different workflows, tables, and privileges:

| Characteristic | Administrative Staff (`Admin`) | Students / Public Learners (`User`) |
| :--- | :--- | :--- |
| **Database Table** | `admins` (InnoDB, primary key `id`) | `users` (InnoDB, primary key `id`) |
| **Eloquent Model** | `App\Models\Admin` | `App\Models\User` |
| **Active Web Guard** | `admin` (session driver) | `web` (session driver) |
| **Login Controller** | `App\Http\Controllers\Admin\LoginController` | `App\Http\Controllers\Auth\LoginController` |
| **Web Login URL** | `/admin/login` | `/login` |
| **Post-Login Target**| `/admin` (`admin.dashboard`) | `/home` $\rightarrow$ `/user/dashboard` |
| **Rate Limiting** | Strict: `throttle:5,1` (5 attempts / 1 min) + IP/email lockout checks | Standard Laravel web throttling |
| **Role/Permission** | Uses `Spatie\Permission\Traits\HasRoles` (active) | `HasRoles` is commented out (`// use HasRoles;`) |
| **Primary Capabilities**| Student management, batch schedules, fees receipting, financial ledgers, settings | Student self-service: enrolled batches, invoices, online bKash payments |

---

## 4. Existing Authorization and Permission Enforcement

### 4.1 Spatie Permissions Architecture
- **Configuration:** Defined in `config/permission.php`. Caching is active for 24 hours (`spatie.permission.cache`).
- **Middleware Registered in `app/Http/Kernel.php`:**
  - `'role' => \Spatie\Permission\Middlewares\RoleMiddleware::class`
  - `'permission' => \Spatie\Permission\Middlewares\PermissionMiddleware::class`
- **Route-Level Enforcement:** Extensively enforced across `routes/admin.php` using pipe-delimited syntax:
  ```php
  Route::group(['middleware' => ['permission:student-list|student-create|student-edit|student-delete']], function () {
      Route::resource('students', 'Admin\StudentsController');
  });
  ```
- **Blade Directive Enforcement:** Enforced in Blade templates via `@can('permission-name') ... @endcan`.

### 4.2 Observed Authorization Defect in `App\Exceptions\Handler`
Inspection of `app/Exceptions/Handler.php` revealed a non-standard response for unauthorized access:
```php
if ($exception instanceof \Spatie\Permission\Exceptions\UnauthorizedException) {
    return response()->json(['User have not permission for this page access.']);
}
```
- **Impact:** When a user lacks permission, it currently returns a raw string inside an array with default HTTP status code **200 OK** rather than a standard **403 Forbidden** status with an error envelope.
- **Modernization Requirement:** This must be updated to return `{ "success": false, "message": "Forbidden", "errors": null }` with HTTP status **403** when handling JSON/API requests.

---

## 5. Recommended API Authentication Approach with Rationale

### 5.1 Evaluated Alternatives

1. **Option A: Activate Legacy Token Driver (`config/auth.php`)**
   - *Description:* Add `api_token` column (`VARCHAR(80)`) to `admins` and `users` tables.
   - *Verdict:* **REJECTED.** Static tokens lack expiration, cannot be individually revoked per device, cannot be safely refreshed, and require altering the core user tables.
2. **Option B: Session-Cookie-Only Authentication for API**
   - *Description:* Share Laravel session cookies between Blade and API routes.
   - *Verdict:* **REJECTED AS PRIMARY.** While workable for a same-origin React app, it fails for mobile applications, external webhooks, CLI tools, and decoupled Vite development servers (`localhost:5173` connecting to `localhost/innova-web`).
3. **Option C: Laravel Sanctum (`laravel/sanctum`) Token Authentication**
   - *Description:* Industry-standard lightweight API token engine for Laravel. Uses a standalone polymorphic table (`personal_access_tokens`).
   - *Verdict:* **RECOMMENDED.**

### 5.2 Rationale for Laravel Sanctum
- **Polymorphic Multi-Auth Support:** Sanctum’s `personal_access_tokens` table stores `tokenable_type` and `tokenable_id`. It natively supports both `App\Models\Admin` and `App\Models\User` simultaneously without any schema collisions.
- **Zero Impact on Blade:** Blade session logins (`auth:admin`, `auth:web`) remain 100% untouched. Sanctum operates strictly on the `/api/*` route pipeline.
- **Token Granularity:** Enables naming tokens (e.g. `"admin-web-console"`, `"student-mobile"`), tracking last used timestamps, and selective revocation upon logout.
- **Spatie Compatibility:** Because Sanctum resolves the authenticated model to the exact Eloquent instance (`Admin`), all existing Spatie permission checks (`$admin->can()`, `permission:xyz`) work out of the box.

---

## 6. Proposed Endpoint List and Access Requirements

The initial API scope is strictly confined to authentication and identity verification. No business domain APIs (courses, students, accounting) will be created until this foundation is validated.

```
+---------------------------------------------------------------------------------------------------+
|                                 PROPOSED PHASE 2.1 AUTH API ENDPOINTS                             |
+---------------------------------------------------------------------------------------------------+
| HTTP Method | Route URI                      | Auth Required | Scope / Access Guard               |
+-------------+--------------------------------+---------------+------------------------------------+
| POST        | /api/v1/admin/auth/login       | Public (Rate) | Admin provider (authenticates Admin)|
| POST        | /api/v1/admin/auth/logout      | Bearer Token  | Admin guard (revokes current token)|
| GET         | /api/v1/admin/auth/me          | Bearer Token  | Admin guard (returns Admin + Perms)|
|             |                                |               |                                    |
| POST        | /api/v1/auth/login             | Public (Rate) | User provider (authenticates User) |
| POST        | /api/v1/auth/logout            | Bearer Token  | User guard (revokes current token) |
| GET         | /api/v1/auth/me                | Bearer Token  | User guard (returns Student User)  |
|             |                                |               |                                    |
| GET         | /api/v1/ping                   | Public        | Stateless Health Check (Active)    |
+---------------------------------------------------------------------------------------------------+
```

### Access Boundaries:
- An Admin token cannot access student-specific private endpoints.
- A Student/User token cannot access administrative routes or Spatie-protected endpoints.
- All protected endpoints return HTTP 401 Unauthenticated if the bearer token is missing or invalid.

---

## 7. Proposed Request Validation and JSON Response Conventions

All responses will strictly extend [ApiController.php](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Api/V1/ApiController.php) to ensure uniform envelopes.

### 7.1 Login Request Payload & Validation
```json
{
  "email": "required|email",
  "password": "required|string|min:6",
  "device_name": "nullable|string|max:100"
}
```

### 7.2 Standardized JSON Response Envelopes

#### Successful Admin Login (HTTP 200)
```json
{
  "success": true,
  "message": "Admin authentication successful",
  "data": {
    "token_type": "Bearer",
    "access_token": "1|xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx",
    "user": {
      "id": 1,
      "name": "Super Admin",
      "email": "admin@innovacomputersbd.com",
      "is_admin": true,
      "roles": ["super-admin"],
      "permissions": ["student-list", "course-create", "..."]
    }
  }
}
```

#### Validation Error (HTTP 422)
```json
{
  "success": false,
  "message": "The given data was invalid.",
  "errors": {
    "email": ["The email field is required."],
    "password": ["The password must be at least 6 characters."]
  }
}
```

#### Authentication Failure / Bad Credentials (HTTP 401)
```json
{
  "success": false,
  "message": "Invalid email or password.",
  "errors": null
}
```

#### Rate Limiting Lockout (HTTP 429)
```json
{
  "success": false,
  "message": "Too many login attempts. Please try again in 60 seconds.",
  "errors": null
}
```

#### Unauthorized Permission Access (HTTP 403)
```json
{
  "success": false,
  "message": "User does not have the required permissions.",
  "errors": null
}
```

---

## 8. Required Files That Would Need Modification in Implementation Phase

When implementation is approved, the following surgical modifications will be required:

| Target File | Planned Action | Details |
| :--- | :---: | :--- |
| `composer.json` | Package Addition | Require `laravel/sanctum:^2.15` (fully compatible with Laravel 8 & PHP 8.2) |
| `database/migrations/` | Schema Addition | Add Sanctum's standard `personal_access_tokens` migration table |
| `app/Models/Admin.php` | Model Update | Import `Laravel\Sanctum\HasApiTokens` trait; declare `protected $guard_name = 'admin';` |
| `app/Models/User.php` | Model Update | Import `Laravel\Sanctum\HasApiTokens` trait |
| `config/auth.php` | Guard Update | Configure Sanctum driver for `api` and `admin-api` guards |
| `app/Http/Kernel.php` | Middleware Update | Ensure Sanctum middleware is registered in `api` group |
| `app/Exceptions/Handler.php` | Bugfix & Error Normalization | Format `UnauthorizedException` (403) and `AuthenticationException` (401) for JSON |
| `app/Http/Controllers/Api/V1/` | New Controllers | Create `AdminAuthController.php` and `UserAuthController.php` extending `ApiController` |
| `routes/api.php` | Route Registration | Register `/api/v1/admin/auth/*` and `/api/v1/auth/*` route groups |
| `tests/Feature/Api/V1/` | New Feature Tests | Create `AdminAuthApiTest.php` and `UserAuthApiTest.php` |

---

## 9. Test Plan and Regression Criteria

### 9.1 New Automated API Tests (Zero Database Mutation during Unit Execution)
1. **Admin Authentication Test Suite:**
   - `test_admin_login_with_valid_credentials_returns_token_and_permissions()`
   - `test_admin_login_with_invalid_password_returns_401()`
   - `test_admin_login_rate_limiting_triggers_429_after_5_attempts()`
   - `test_admin_me_endpoint_returns_current_profile_when_authenticated()`
   - `test_admin_me_endpoint_returns_401_when_unauthenticated()`
   - `test_admin_logout_revokes_token()`
2. **User Authentication Test Suite:**
   - `test_user_login_with_valid_credentials_returns_token()`
   - `test_user_login_with_invalid_credentials_returns_401()`
   - `test_user_me_endpoint_returns_student_profile()`
   - `test_user_cannot_access_admin_endpoints()`
3. **Permission Enforcement Test Suite:**
   - `test_admin_with_permission_can_access_protected_route()`
   - `test_admin_without_permission_receives_standard_403_json()`

### 9.2 Regression Testing Criteria (Preserving Existing Web/Blade System)
- **Web Admin Login:** `POST /admin/login` must authenticate via session cookie and redirect to `admin.dashboard`.
- **Web Student Login:** `POST /login` must authenticate via session cookie and redirect to `/home`.
- **LFM Routes:** `unisharp.lfm.show` must continue to enforce `auth:admin`.
- **Existing Tests:** All 23 existing unit and feature tests in `tests/Unit/SecurityHardeningUnitTest.php` and `tests/Feature/Api/V1/PingTest.php` must continue to pass at 100%.

---

## 10. Risks, Dependencies, and Unresolved Decisions

### 10.1 Key Risks & Mitigation
1. **Spatie Multi-Guard Permission Resolution Risk:**
   - *Risk:* Spatie checks permissions against the guard name of the authenticating model. If permissions were created under guard `admin`, but Sanctum authenticates under guard `sanctum`, Spatie may throw an `UnauthorizedException`.
   - *Mitigation:* Explicitly set `protected $guard_name = 'admin';` on `App\Models\Admin` and `protected $guard_name = 'web';` on `App\Models\User`.
2. **Exception Handling Regression Risk:**
   - *Risk:* Changing `app/Exceptions/Handler.php` could inadvertently alter Blade error redirection.
   - *Mitigation:* Restrict JSON error formatting strictly to requests where `$request->expectsJson()` is true. All non-JSON web requests will continue following default Blade redirection.

### 10.2 Prerequisite Dependencies
- Approval of Sanctum package installation (`composer require laravel/sanctum:^2.15`).
- Creation of `personal_access_tokens` table in the existing MySQL database.

---

## 11. Short Implementation Sequence for the Next Approved Step

Once this assessment report is reviewed and approved, implementation will proceed through these exact, incremental stages:

```
Step 1: Install `laravel/sanctum:^2.15` and publish its migration.
   │
Step 2: Run migration to create `personal_access_tokens` table on MySQL.
   │
Step 3: Add `HasApiTokens` trait to `Admin` and `User` models with explicit guard declarations.
   │
Step 4: Update `app/Exceptions/Handler.php` for standard JSON 401 and 403 error envelopes.
   │
Step 5: Create `AdminAuthController` and `UserAuthController` extending `ApiController`.
   │
Step 6: Register `/api/v1/admin/auth/*` and `/api/v1/auth/*` routes in `routes/api.php`.
   │
Step 7: Author and execute automated tests; verify 100% test pass rate and zero Blade regression.
```

---

## 12. Verification & Safety Compliance

- **Application code modified:** NONE (0 files).
- **Packages installed or updated:** NONE (0 packages).
- **Database operations executed:** NONE (0 SQL/DDL operations).
- **Git status:** Clean, working tree unchanged, all prior hardening work preserved.
