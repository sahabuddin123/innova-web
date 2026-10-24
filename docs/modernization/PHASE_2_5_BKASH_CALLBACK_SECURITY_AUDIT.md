# PHASE 2.5 — CRITICAL BKASH CALLBACK SECURITY AUDIT REPORT
**Project:** INNOVA Computers BD Web System Modernization  
**Phase:** Phase 2.5 Security Audit — bKash Checkout v1.2 Payment Lifecycle & Callback Architecture  
**Status:** COMPLETED & FULLY VERIFIED (84 of 84 tests passing, 100% success rate)  
**Date:** October 24, 2026  
**Auditor:** Senior Software Architect & Laravel Backend Security Specialist  

---

## 1. Executive Summary

This critical security audit investigates the payment lifecycle, gateway integration, and callback handling of the newly implemented Phase 2.5 bKash REST API module (`/api/v1/fees/bkash/*`) against the legacy Blade implementation (`BkashController.php`) and the bKash Checkout v1.2-beta gateway architecture.

### Key Audit Findings:
1. **bKash Checkout Architecture Clarified:** The configured bKash integration uses **bKash JS Checkout (Popup/iFrame Modal)**, not an asynchronous server-to-server webhook. The customer's authenticated browser receives authorization from the bKash JavaScript SDK hook and triggers the merchant server's execution endpoint via AJAX.
2. **`auth:sanctum` Middleware is Mandatory & Compatible:** Because the callback/execute request originates from the customer's authenticated client session, requiring `auth:sanctum` is not only compatible but critical to prevent anonymous public users from spamming the payment execution endpoint or hijacking payment sessions.
3. **Identified & Mitigated Cross-Student Payment Hijack Vulnerability:** Without server-side payment intent binding, an authenticated student (Student B) could submit a `payment_id` initiated by Student A, causing Student A's captured funds to credit Student B's account. **This vulnerability was neutralized by introducing server-side Payment Intent Binding via atomic cache storage (`bkash_intent_{paymentID}`).**
4. **Independent Server-Side Gateway Verification:** The application never trusts client-submitted statuses, amounts, or redirect parameters. Payment execution and status verification are performed strictly server-to-server (`BkashService::executePayment`).
5. **Reconciliation Read-Only Safety:** Gateway reconciliation endpoints (`/bkash/query` and `/bkash/search`) are strictly read-only and never mutate financial ledgers or auto-approve pending transactions.
6. **Zero Database Modifications:** The production MySQL database `icbd_web` remained completely untouched. All tests executed in an isolated SQLite `:memory:` database with mocked gateway responses.

---

## 2. Complete Payment Lifecycle Trace

```
+──────────────────────────────────────────────────────────────────────────────────────────────+
| 1. CHECKOUT INITIATION                                                                       |
| Client (Student/Admin) ──> POST /api/v1/fees/bkash/create                                    |
|   ├── Validates caller identity via Sanctum auth (User vs Admin)                             |
|   ├── Validates amount <= outstanding course balance (prevents overpayment)                  |
|   ├── Contacts bKash API: /checkout/token/grant and /checkout/payment/create                 |
|   ├── Receives paymentID from bKash                                                          |
|   └── CRITICAL FIX: Stores immutable Payment Intent in Server Cache (30 min TTL):            |
|       bkash_intent_{paymentID} => { student_id, user_id, expected_amount, payment_type }     |
+──────────────────────────────────────────────────────────────────────────────────────────────+
                                               │
                                               ▼
+──────────────────────────────────────────────────────────────────────────────────────────────+
| 2. CUSTOMER AUTHENTICATION (bKash iFrame/Popup)                                              |
| Customer enters Wallet Number, OTP, and PIN directly inside bKash's secured iFrame           |
| On authorization, bKash JS SDK calls client hook: executeRequestOnAuthorization()             |
+──────────────────────────────────────────────────────────────────────────────────────────────+
                                               │
                                               ▼
+──────────────────────────────────────────────────────────────────────────────────────────────+
| 3. CAPTURE & SERVER CALLBACK EXECUTION                                                       |
| Client (Student) ──> POST /api/v1/fees/bkash/callback (with Sanctum Bearer Token)            |
|   ├── Fast-path Idempotency Check: FeesTransections::where('paymentID', $id)->first()        |
|   │   └── If exists: verifies ownership; returns HTTP 200 OK (is_duplicate: true)            |
|   ├── Intent Binding Check: Cache::get('bkash_intent_' . $paymentID)                         |
|   │   ├── If missing/expired: REJECT with HTTP 422 (unrecognized session)                    |
|   │   └── Anti-Hijack Check: if ($caller->student_id !== $intent['student_id'])              |
|   │       └── REJECT with HTTP 403 Forbidden!                                                |
|   ├── Atomic Distributed Lock: Cache::lock('bkash_payment_exec_' . $paymentID, 15)           |
|   ├── Direct Gateway Verification: BkashService::executePayment($paymentID)                  |
|   │   ├── Verifies transactionStatus === 'Completed'                                         |
|   │   ├── Verifies errorCode === '0000'                                                      |
|   │   └── Verifies Gateway Amount === Intent Expected Amount (anti-tampering)                |
|   ├── Secondary trxID Deduplication: Checks if trxID was previously recorded                 |
|   └── DB::transaction: Persists FeesTransections record with status = 1 (Pending admin)      |
+──────────────────────────────────────────────────────────────────────────────────────────────+
                                               │
                                               ▼
+──────────────────────────────────────────────────────────────────────────────────────────────+
| 4. ADMINISTRATIVE RECONCILIATION & APPROVAL                                                  |
| Admin ──> GET /api/v1/fees/bkash/query/{paymentID} (Read-only status cross-check)             |
| Admin ──> PUT /api/v1/fees/transactions/{id}/status (Approve: status = 0, updates due BDT)   |
+──────────────────────────────────────────────────────────────────────────────────────────────+
```

---

## 3. Detailed Audit Findings Across the 8 Critical Checks

### Check 1: Gateway Callback Mechanism (Redirect vs Webhook)
- **Investigation:** Inspected `app/Http/Controllers/BkashController.php`, `resources/views/users/profile/payments-history.blade.php`, and `config/services.php`.
- **Finding:** bKash Checkout v1.2-beta operates as a **client-side JavaScript SDK modal (iFrame)**. The flow is:
  1. Frontend calls merchant backend `create` endpoint to obtain a `paymentID`.
  2. Frontend passes `paymentID` to `bKash.create().onSuccess(data)`.
  3. Customer interacts with the bKash modal.
  4. Upon PIN verification, bKash's JavaScript SDK fires `executeRequestOnAuthorization()`.
  5. The frontend AJAX issues a request to the merchant server's execution endpoint to capture funds.
  6. There is **no asynchronous server-to-server webhook notification** configured or supported by this version of bKash Checkout.
- **Verdict:** The callback is an authenticated client-driven capture request, not a webhook.

---

### Check 2: Compatibility of `auth:sanctum` on Callback Endpoint
- **Investigation:** Analyzed whether bKash servers ever make direct unauthenticated HTTP requests to `/api/v1/fees/bkash/callback`.
- **Finding:** Because bKash uses the client-side JavaScript execution trigger, the callback endpoint is called directly by the customer's client application (React SPA or mobile client) using the customer's active session.
- **Security Assessment:**
  - If `auth:sanctum` were removed, the endpoint would be completely public. Any anonymous attacker could submit payment IDs, trigger arbitrary payment captures, or probe gateway states.
  - Retaining `auth:sanctum` ensures that every request is tied to a verified `User` (student) or `Admin` principal.
- **Verdict:** `auth:sanctum` is 100% compatible and required for authorization integrity.

---

### Check 3: Student, Expected Amount, and Session Association
- **Vulnerability Discovered (Pre-Mitigation):** In the initial REST controller, `createPayment` contacted bKash but did not record the payment intent on the server. In `callback`, the system accepted any `payment_id` and credited whoever called the callback endpoint.
- **Risk Scenario:** Student A initiates a payment of 15,000 BDT. Student B observes the `paymentID` and invokes `/callback` using Student B's bearer token. Student A's bKash account is debited 15,000 BDT, but Student B's tuition balance is credited!
- **Mitigation Implemented:**
  - In `createPayment`, the server stores an authoritative **Payment Intent** in Cache with a 30-minute TTL:
    ```php
    Cache::put('bkash_intent_' . $paymentId, [
        'payment_id'      => $paymentId,
        'student_id'      => (int) $student->id,
        'user_id'         => (int) $student->user_id,
        'initiator_id'    => (int) $currentUser->id,
        'expected_amount' => (string) $amount,
        'payment_type'    => (int) ($request->payment_type ?? 1),
    ], now()->addMinutes(30));
    ```
  - In `callback`, the server checks `Cache::get('bkash_intent_' . $paymentId)`. If missing, the request is rejected with HTTP `422`. If the authenticated student does not match `intent['student_id']`, it is immediately rejected with HTTP `403 Forbidden`.
- **Verdict:** Student association is strictly enforced and bound to the server-side intent.

---

### Check 4: Independent Server-Side Verification
- **Investigation:** Traced `BkashApiController@callback` lines 175–195.
- **Finding:**
  - The server never trusts client-supplied amounts, transaction IDs, or status flags.
  - The server calls `BkashService::executePayment($paymentId)` which makes a direct cURL call to `https://checkout.pay.bka.sh/v1.2.0-beta/checkout/payment/execute/{paymentID}`.
  - The transaction is rejected unless:
    1. `result['errorCode'] === '0000'`
    2. `strtolower(result['transactionStatus']) === 'completed'`
    3. `result['trxID']` is non-empty.
    4. `abs((float) result['amount'] - (float) intent['expected_amount']) <= 0.01`
- **Verdict:** Full independent server-side verification is verified.

---

### Check 5: Forged Callbacks, Altered Amounts & Failed Responses
- **Tests Added & Verified:**
  1. **Forged / Uninitiated `paymentID`:** Submitting an uninitiated or expired `paymentID` returns HTTP `422 Unprocessable Content` (`"Payment session not found, expired, or was not initiated by this system."`).
  2. **Cross-Student Hijacking:** Student B executing Student A's `paymentID` returns HTTP `403 Forbidden` (`"Forbidden: This payment session belongs to a different student account"`).
  3. **Altered Amount (Tampering):** If the gateway captures an amount differing from the initiated amount (e.g. 10.00 BDT instead of 5,000.00 BDT), the transaction is aborted with HTTP `422` (`"Payment verification failed: Gateway captured amount does not match initiated amount"`).
  4. **Failed / Declined Gateway Status:** Gateway responses with `transactionStatus !== 'Completed'` return HTTP `422` and record zero database entries.
- **Verdict:** All edge cases are guarded.

---

### Check 6: Duplicate Callbacks, Concurrency & Atomic Locking
- **Investigation:** Evaluated cache locking and deduplication mechanics.
- **Findings:**
  - **Fast-Path Deduplication:** If `fees_transections` already contains `paymentID`, the endpoint immediately returns HTTP `200 OK` with `is_duplicate: true` without invoking bKash execute or performing database writes.
  - **Privacy on Replay:** If Student B attempts to replay Student A's completed `paymentID`, the fast-path check enforces student ownership and returns HTTP `403 Forbidden`.
  - **Atomic Locking:** `Cache::lock('bkash_payment_exec_' . $paymentId, 15)` serializes concurrent requests.
  - **Cache Driver Audit:** Verified that `config/cache.php` default is `file` on WampServer. In Laravel 8+, `FileStore` implements `LockProvider` returning `Illuminate\Cache\CacheLock`. Concurrent processes on the same host are locked at the filesystem level.
  - **Database Unique Deduplication:** Secondary check on `trxID` under `DB::transaction()` guarantees that even if a different `paymentID` returned the same gateway `trxID`, duplicate insertion is prevented.
- **Verdict:** Concurrent and replayed execution requests are properly handled.

---

### Check 7: Cross-Account Parameter Tampering
- **Investigation:** Checked whether an Admin or Student could pass a fraudulent `student_id` in the callback payload.
- **Finding:**
  - The persisted record always uses `intent['student_id']` and `intent['user_id']`.
  - Client-submitted `student_id` fields are validated against `intent['student_id']`. Any mismatch returns HTTP `422`.
- **Verdict:** Cross-account tampering is prevented.

---

### Check 8: Reconciliation Safety (Read-Only)
- **Investigation:** Inspected `BkashApiController@query` and `BkashApiController@search`.
- **Finding:**
  - Both routes (`/fees/bkash/query/{paymentID}` and `/fees/bkash/search/{trxID}`) use HTTP `GET`.
  - They execute read-only queries against bKash (`/checkout/payment/query` and `/checkout/payment/search`) and compare gateway results against `fees_transections`.
  - Zero `UPDATE`, `INSERT`, or status changes occur during reconciliation queries.
- **Verdict:** Reconciliation is read-only and safe.

---

## 4. Files Modified During Security Hardening

| File Path | Nature of Change |
| :--- | :--- |
| `app/Http/Controllers/Api/V1/BkashApiController.php` | Added server-side payment intent binding (`Cache::put`) in `createPayment`; added intent retrieval, caller authorization, amount verification, and replayed privacy checks in `callback`. |
| `tests/Feature/Api/V1/FeeBkashApiTest.php` | Updated existing callback tests to seed intent; added 4 new security test cases covering uninitiated sessions, cross-student hijacking, amount tampering, and unauthorized replay attempts. |

---

## 5. Automated Test Suite Results

### 5.1 Focused bKash & Fee Test Suite
Command executed:
```bash
php vendor/bin/phpunit --filter FeeBkashApiTest
```
Output:
```
PHPUnit 9.6.29 by Sebastian Bergmann and contributors.

....................                                              20 / 20 (100%)

Time: 00:03.823, Memory: 36.00 MB

OK (20 tests, 96 assertions)
```

### 5.2 Full Application Regression Test Suite
Command executed:
```bash
php vendor/bin/phpunit
```
Output:
```
PHPUnit 9.6.29 by Sebastian Bergmann and contributors.

................................................................. 65 / 84 ( 77%)
...................                                               84 / 84 (100%)

Time: 00:09.694, Memory: 46.00 MB

OK (84 tests, 355 assertions)
```
- **Total Tests:** 84
- **Total Assertions:** 355
- **Failures / Errors:** 0 (100% Pass)
- **Regression:** 0 regressions across Authentication (Phase 2.2), Academic Management (Phase 2.3), Student Lifecycle (Phase 2.4), and Fees/bKash (Phase 2.5).

---

## 6. Database and Gateway Safety Confirmation

- **MySQL Database `icbd_web`:** 100% unwritten and unmodified. Zero DDL or SQL writes were executed against MySQL.
- **Live / Sandbox Payment Gateway:** 100% untouched. All gateway interactions were simulated via PHPUnit Mockery against `BkashService`.
- **Environment & Credentials:** No `.env` variables, gateway keys, or configuration settings were modified.

---

## Stop Condition Met

The bKash callback security audit is complete and all vulnerabilities have been mitigated and validated. In accordance with project instructions, I will pause here and await your explicit approval before proceeding to any subsequent phases.
