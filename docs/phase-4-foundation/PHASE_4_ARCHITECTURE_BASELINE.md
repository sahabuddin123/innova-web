# Phase 4 — Architecture Baseline & Modernization Foundation

**Project:** `innova-web` (INNOVA Computers BD / ICBD)  
**Document:** Phase 4 Implementation Baseline & Modernization Blueprint  
**Author:** Lead Full-Stack & Database Migration Architect  
**Date:** October 2026  
**Active Git Branch:** `feature/phase-1-security-hardening`  
**Target Architecture:** Laravel 13 + PHP 8.4 + React + TypeScript + PostgreSQL 16  
**Source Database (Truth):** Existing MySQL 8.0.31 database (`icbd_web`, 52 tables, 15,663 operational records)  
**Phase Status:** Foundation Established (Non-destructive, Zero DB Migration)

---

## 1. Executive Summary & Objective

The objective of Phase 4 is to establish the implementation foundation for the target modernization architecture (**Laravel 13 + PHP 8.4 + React + TypeScript + PostgreSQL 16**) without migrating the active database, breaking existing features, or repeating prior documentation audits.

### Core Engineering Principles:
1. **Zero Database Disruption:** The existing MySQL database remains the authoritative, untouched source of truth. No DDL, migrations, writes, seeders, or data cleanup are executed in this phase.
2. **Preservation of Existing Work:** All uncommitted security hardening work from Phase 1 and prior phases is strictly preserved.
3. **Modular Monolith Architecture:** Modernization proceeds within a clean modular structure. No distributed microservices or unnecessary external complexity is introduced.
4. **Dual-Stack Non-Interference:** Existing Blade templates, jQuery scripts, and admin routes continue to operate without interruption while the modern `/api/v1` REST foundation and TypeScript contracts are established.

---

## 2. Backend Module Boundaries (Modular Monolith)

The backend domain is partitioned into five distinct, decoupled functional modules. Each module maintains explicit ownership over its domain models, business service contracts, and controller endpoints:

```
app/
├── Http/
│   └── Controllers/
│       ├── Admin/               <-- Legacy & transitional admin controller suite
│       ├── Frontend/            <-- Legacy Blade public website controllers
│       └── Api/
│           └── V1/              <-- Modern versioned REST API foundation
│               ├── Academic/    <-- Courses, Batches, Students, Admissions, Certificates
│               ├── Finance/     <-- Fees, Vouchers, bKash, Loans, Ledgers
│               ├── Portal/      <-- Student / Authenticated User Portal endpoints
│               └── System/      <-- Health checks, Ping, App metadata
```

### 2.1 Module Inventory & Domain Responsibilities:

| Module Name | Core Domain Entities | Key Business Capabilities | Internal Dependencies |
|---|---|---|---|
| **1. Academic Management** | `Course`, `CourseCategory`, `AcademicSession`, `Batch`, `Student`, `Admission`, `Certificate` | Course catalog administration, batch scheduling, student enrollment lifecycle, certificate generation and public verification. | Uses `Administration` for RBAC; feeds `Finance` for fees. |
| **2. Finance & Accounting** | `FeesTransection`, `Expanse`, `Income`, `Invesment`, `BankLoan`, `EmiInstallment` | Voucher issuance, student fee installment tracking, bKash payment verification, shareholder loan servicing, ledger balancing. | Consumes student/admission IDs from `Academic`. |
| **3. Student Portal** | `User`, `Student`, `Registration`, `Certificate` | Student authentication, profile view, course progress, dues inquiry, bKash online checkout initiation, certificate lookup. | Queries `Academic` and `Finance`. |
| **4. Corporate & Public** | `Client`, `Concern`, `Product`, `Service`, `Team`, `Technology`, `Workflow`, `Seminar`, `Blog` | Corporate agency showcase, sister concerns directory, seminar registration pipeline, public contact forms. | Autonomous module (minimal cross-module coupling). |
| **5. Core System & Security** | `Admin`, `User`, Roles, Permissions, `Notification` | Role-based authorization (Spatie), SMS delivery (Elitbuzz), audit logs, `/api/v1` base infrastructure. | Shared foundational service for all modules. |

---

## 3. React Frontend Feature Boundaries

The target frontend replaces obsolete asset compilation (Laravel Mix 4, Webpack 4, Vue 2 leftovers) with a modern **React 18+/19 + TypeScript + Vite** architecture.

```
resources/
├── js/
│   ├── api/                     <-- Typed Axios/Fetch API client wrappers
│   ├── components/              <-- Shared UI component library (forms, modals, tables)
│   ├── features/                <-- Domain feature modules
│   │   ├── academic/            <-- Course browsing, admissions, certificates
│   │   ├── admin/               <-- Administrative back-office management
│   │   ├── corporate/           <-- Marketing pages, seminars, corporate showcase
│   │   ├── finance/             <-- Financial voucher entry, ledgers, bKash checkout
│   │   └── portal/              <-- Student dashboard, payment history
│   ├── layouts/                 <-- PublicLayout, PortalLayout, AdminLayout
│   └── types/                   <-- Shared TypeScript interfaces and contracts
```

### 3.1 Feature Boundary Rules:
1. **Colocated State & Components:** Each feature directory manages its own sub-components, queries, and state hooks. Cross-feature re-use is restricted to `resources/js/components/` and `resources/js/types/`.
2. **TypeScript Contracts First:** All frontend data models must strictly align with backend API v1 schemas defined in `resources/js/types/api.ts`.
3. **No Direct DOM Manipulation:** jQuery and legacy inline scripts are barred from new React components.

---

## 4. API Versioning & Response Conventions (`/api/v1`)

All modern backend services communicate through a versioned REST API mounted under the `/api/v1` route prefix.

### 4.1 URL Structure:
- Health check / baseline: `GET /api/v1/ping`
- Resource collection: `GET /api/v1/{module}/{resource}`
- Resource instance: `GET /api/v1/{module}/{resource}/{id}`
- Resource creation: `POST /api/v1/{module}/{resource}`
- Resource mutation: `PUT|PATCH /api/v1/{module}/{resource}/{id}`
- Resource deletion: `DELETE /api/v1/{module}/{resource}/{id}`

### 4.2 Standardized JSON Response Envelopes:

#### Success Response Envelope (`HTTP 200 / 201`):
```json
{
  "success": true,
  "message": "Resource retrieved successfully",
  "data": {
    "id": 1,
    "name": "Professional Web Development",
    "fee": 15000.00
  },
  "meta": {
    "timestamp": "2026-10-24T15:50:00+06:00"
  }
}
```

#### Error Response Envelope (`HTTP 400 / 401 / 403 / 404 / 422 / 500`):
```json
{
  "success": false,
  "message": "The given data was invalid.",
  "errors": {
    "email": ["The email has already been taken."]
  }
}
```

### 4.3 Content Negotiation & Headers:
- Request: `Accept: application/json`, `Content-Type: application/json`
- Response: `Content-Type: application/json`

---

## 5. Authentication & Authorization Boundaries

### 5.1 Dual-Boundary Authentication Model:
1. **Web & Admin Portal (Transitional / Inertia):**
   - Utilizes Laravel's native session-based stateful cookie authentication.
   - Guards: `web` (students/users) and `admin` (institute staff/administrators).
   - CSRF token protection enabled on all mutation routes.
2. **Stateless API Services (`/api/v1`):**
   - Secured via **Laravel Sanctum** token-based authentication (`auth:sanctum`).
   - Mobile and decoupled SPA requests exchange user credentials for a cryptographically signed Bearer token.
   - Public read-only endpoints (e.g. `ping`, course listing, certificate verification) remain open without token requirement.

### 5.2 Authorization via Spatie Permissions:
- Role and permission definitions adhere to the existing `spatie/laravel-permission: ^5.5` library.
- Fine-grained permission gates: `permission:manage-courses`, `permission:manage-fees`, `permission:view-financial-reports`.
- Super-admin bypass configured in `AuthServiceProvider`.

---

## 6. Database Ownership & Migration Rules

1. **MySQL as Read-Only Baseline:** During Phase 4, the active MySQL database `icbd_web` remains read-only for architecture reference.
2. **Zero Incomplete File Fabrication:** Future PostgreSQL migrations will not be reconstructed from fragmented or unmigrated legacy migration files. They will be reverse-engineered directly from the live 52-table schema.
3. **Strict Type Governance for Target PostgreSQL:**
   - **Financials:** `NUMERIC(15,2) NOT NULL DEFAULT 0.00` across all monetary columns (replacing `VARCHAR(191)`).
   - **Dates:** Strict `DATE` and `TIMESTAMPTZ` (zero-dates `'0000-00-00'` rejected and converted to `NULL`).
   - **Foreign Keys:** Explicit relational constraints with cascading rules on all parent-child relationships.
   - **Character Collation:** Uniform `UTF8` encoding across all tables (eliminating `latin1` in `certificates_icbd`).
4. **Disposable Testing Rule:** All migration suites must execute cleanly in a disposable test database (`icbd_disposable_pgsql`) before any staging or production cutover.

---

## 7. Testing & Acceptance Criteria

Every modern feature must satisfy three tiers of automated verification:

1. **Backend Unit & Feature Tests (PHPUnit):**
   - API endpoints must return 100% compliant JSON envelopes.
   - HTTP status codes must match RFC specifications.
   - Validation failures must return 422 with structured field error arrays.
   - Stateless unit tests must run without requiring live database connections.
2. **Frontend Type & Component Validation:**
   - Zero TypeScript compilation errors (`tsc --noEmit`).
   - Component rendering and user interactions verified with Vitest / React Testing Library.
3. **Regression Safety Assertion:**
   - Existing 21 security hardening unit tests (`SecurityHardeningUnitTest.php`) must continue passing at 100% (21 tests, 119 assertions).

---

## 8. Environment Configuration & Deployment Boundaries

1. **Environment Strictness:**
   - Secrets must never be stored in code or committed to Git.
   - External credentials (bKash checkout, Elitbuzz SMS) are centralized strictly in `config/services.php` consuming environment variables.
2. **Build & Asset Isolation:**
   - Modern Vite assets compile to `public/build/`.
   - Legacy Mix assets compile to `public/js/` and `public/css/`.
   - Paths must not collide during the incremental transition.
3. **Runtime Upgrades:**
   - Upgrading from Laravel 8 / PHP 8.2 to Laravel 13 / PHP 8.4 is isolated to the planned clean-slate repository transition, avoiding in-place Composer dependency breakage.
