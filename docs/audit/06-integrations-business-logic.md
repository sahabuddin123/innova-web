# 06. Integrations and Business Logic Inventory

**Project:** `innova-web` (INNOVA Computers BD / ICBD)  
**Audit Date:** October 13, 2026  
**Auditor:** Antigravity Agentic Audit (Phase 0 Discovery)  
**Strict Constraint:** Read-Only Audit (No code/configuration/data changes made; all secret values redacted)

---

## 1. External Integrations Inventory

| Integration Category | Provider / Service | Protocol / API Type | Required Env Variables (Names Only) | Status & Failure Handling |
|---|---|---|---|---|
| **Payment Gateway** | bKash Checkout (Iframe v1.2.0-beta) | REST API via raw cURL | `BKASH_CHECKOUT_APP_KEY`<br>`BKASH_CHECKOUT_APP_SECRET`<br>`BKASH_CHECKOUT_USER_NAME`<br>`BKASH_CHECKOUT_PASSWORD` | **Fragile / Broken on Config Cache.** No webhook; relies on browser redirects and session variables; no database retry table. |
| **SMS Gateway** | Elitbuzz BD SMS Gateway | HTTP POST via raw cURL | `SMS_URL`<br>`SMS_API_KEY`<br>`SMS_SENDER_ID` | **Insecure & Fragile.** SSL verification disabled; direct `env()` calls crash if config cached; no delivery status callback. |
| **Email Service** | SMTP / cPanel Webmail / Gmail | SMTP via SwiftMailer | `MAIL_DRIVER`<br>`MAIL_HOST`<br>`MAIL_PORT`<br>`MAIL_USERNAME`<br>`MAIL_PASSWORD`<br>`MAIL_ENCRYPTION` | **Legacy.** SwiftMailer is abandoned; configured for `sendmail`/`smtp`. |
| **Captcha Verification**| Google reCAPTCHA v2/v3 | REST API via Biscolab package | `RECAPTCHA_SITE_KEY`<br>`RECAPTCHA_SECRET_KEY`<br>`RECAPTCHA_SITE` | **Abandoned Package.** `biscolab/laravel-recaptcha` is abandoned. |
| **Document Generation**| Barcode / QR Code / PDF | PHP extensions & local packages | N/A | Fully local generation (`dompdf`, `simple-qrcode`). |

---

## 2. Detailed Integration Workflows

### 2.1 bKash Checkout Iframe Workflow
- **Controller Implementation:** [`App\Http\Controllers\BkashController`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/BkashController.php)
- **Live Endpoint Base URL:** `https://checkout.pay.bka.sh/v1.2.0-beta`
- **Sandbox Endpoint Base URL:** `https://checkout.sandbox.bka.sh/v1.2.0-beta` (commented out in constructor)
- **Lifecycle Flow:**
  1. **Token Grant (`grant()`):** Sends `app_key` and `app_secret` with HTTP basic headers (`username`, `password`) to `/checkout/token/grant`. Extracts `id_token` and stores in `Session::put('bkash_token', $token)`.
  2. **Payment Creation (`create()`):** Pulls `Session::get('due_amount')`. Formats JSON payload with amount, currency `BDT`, intent `sale`, and random invoice number `"Inv" . Str::random(8)`. Posts to `/checkout/payment/create`. Stores `paymentID` in session.
  3. **Payment Execution (`execute()`):** Posts to `/checkout/payment/execute/{paymentID}`. If execute API returns a transient message, it calls `sleep(1)` and performs a fallback query to `/checkout/payment/query/{paymentID}`. Stores raw API response in `Session::put('arr', $arr)`.
  4. **Payment Finalization (`success()`):** Browser redirects to GET `/user/success`. Pulls `$arr = Session::get('arr')`. Instantiates a new [`FeesTransections`](file:///c:/wamp64/www/innova-web/app/Models/FeesTransections.php) record:
     ```php
     $fees = new FeesTransections;
     $fees->student_id = Session::get('student_id');
     $fees->paidamount = $arr['amount'];
     $fees->paymentType = Session::get('payment_type');
     $fees->paiddate = Carbon::now()->format('Y-m-d');
     $fees->paidremark = "Pay by Bkash";
     $fees->channel = 2; // 2 = bKash
     $fees->status = 1;
     $fees->trxID = $arr['trxID'];
     $fees->paymentID = $arr['paymentID'];
     $fees->save();
     ```
- **Architectural Gaps & Failure Handling:**
  - **No Webhook:** If a student closes their browser between execution and redirection to `/user/success`, bKash captures the payment but **the database record is never created**.
  - **No Idempotency:** The transaction ID (`trxID`) is not validated for uniqueness. Refreshing `/user/success` will re-execute the store or crash if session data has expired.
  - **Direct `env()` Calls:** Lines 30, 67, 68, 72 call `env()` directly. If `config:cache` is executed, credentials evaluate to `null`, breaking all payments.

### 2.2 Elitbuzz SMS Gateway Workflow
- **Controller Implementation:** [`App\Http\Controllers\Admin\SMSController`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/SMSController.php)
- **Endpoint URL:** Defined in `.env` (`SMS_URL`, e.g., `https://msg.elitbuzz-bd.com/smsapi`)
- **Payload Structure:**
  ```php
  $data = [
      "api_key" => env('SMS_API_KEY'),
      "type" => "text",
      "contacts" => "88" . $phone,
      "senderid" => env('SMS_SENDER_ID'),
      "msg" => $msg
  ];
  ```
- **Automated Trigger Points in Business Code:**
  1. **New Student Admission (`StudentsController@store`):**
     Dispatches Bengali welcome message containing Student Name, Course Name, Batch Number, Module Count, and Class Days/Times.
  2. **Fee Receipt Creation (`FeesTransectionsController@store`):**
     Dispatches payment receipt SMS:
     `"প্রিয় [Name], আপনার [Amount] টাকা ফি জমা হয়েছে। বর্তমান বকেয়া [Due] টাকা। ইনোভা কম্পিউটারস বিডি।"`
  3. **Class Postponement Alerts (`SMSController@todayPostpond`, `@tomorrowPostpond`):**
     Dispatches class postponement notices with hardcoded helpline phone number `01844463954`.
- **Architectural Gaps & Failure Handling:**
  - Disables SSL peer validation (`CURLOPT_SSL_VERIFYPEER => false`).
  - SMS dispatch runs synchronously inside HTTP requests. If the Elitbuzz API is slow or times out, the user's browser hangs.
  - No database logging of sent messages, delivery receipts, or SMS credit balances.

---

## 3. Financial Calculation and Accounting Logic

### 3.1 Student Balance and Payment Calculations
In [`StudentsController`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/StudentsController.php) and [`FeesTransectionsController`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/FeesTransectionsController.php):
- **Formula:**
  $$\text{Net Payable} = \text{course\_fee} - \text{discount}$$
  $$\text{Balance Due} = \text{Net Payable} - \sum(\text{paidamount})$$
- **Technical Risk:**
  - `course_fee`, `discount`, and `paidamount` are stored as strings in MySQL.
  - When storing a fee transaction, the controller executes:
    ```php
    $student = Students::find($request->student_id);
    $student->balance = (float)$student->balance - (float)$request->paidamount;
    $student->save();
    ```
  - Storing a denormalized running balance on the `students` table without wrapping the transaction and update in a database transaction (`DB::transaction`) creates balance drift under concurrent entries.

### 3.2 Income vs. Expense Balance Sheet Aggregation
In [`Admin\ReportController.php:L55-65, L105-115`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/ReportController.php#L55-L65):
- The application generates monthly financial summaries by executing:
  ```php
  DB::table('expanses')
      ->select(
          DB::raw('REPLACE(expanses.amount, ",", "") AS amount_without_commas'),
          DB::raw('SUM(REPLACE(expanses.amount, ",", "")) as total_amount')
      )
      ->whereBetween('invoiceDate', [$startDate, $endDate])
      ->first();
  ```
- **Technical Risk:**
  - Because `amount` was saved as a formatted string with commas (e.g., `'15,000'`), standard SQL aggregation functions (`SUM(amount)`) fail without string sanitization.
  - This query bypasses indexes, causing full-table scans for financial reports.

### 3.3 Shareholder Dividend & Investment Logic
In [`ShareholderController`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/ShareholderController.php), [`InvesmentsController`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/InvesmentsController.php), and [`InvestmentWithdrawController`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/InvestmentWithdrawController.php):
- Shareholders hold capital equity percentage (`share_percentage`).
- Capital investments are credited to `invesments`.
- Capital withdrawals are recorded in `investment_withdraws` and deducted from the shareholder's running capital.
- Dividends are distributed based on net monthly institute profit multiplied by `share_percentage / 100`.

---

## 4. Document and Media Generation Logic

### 4.1 Printable Student & Staff ID Cards
- **Controller Implementation:** [`Admin\IdCardController@show`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/IdCardController.php), [`Admin\StuffIdCardController@show`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/StuffIdCardController.php).
- **Technology:** Pure HTML/CSS with print media queries (`@media print`).
- **Assets:** Embeds institute signature (`sing_img`), official stamp, student photograph from `storage/students/{image}`, and generated barcode.

### 4.2 Certificate QR Code Generation
- **Controller Implementation:** [`Admin\CertificateController`](file:///c:/wamp64/www/innova-web/app/Http/Controllers/Admin/CertificateController.php).
- **Technology:** `SimpleSoftwareIO\QrCode\Facades\QrCode`.
- **Payload:** Generates QR code encoding the public certificate verification URL:
  `http://innovacomputersbd.com/certifiocate-verify/{slnum}`.

### 4.3 Bengali Number & Currency Conversion
- **Technology:** `lemonpatwari/number-to-bangla` (registered as a singleton in [`AppServiceProvider`](file:///c:/wamp64/www/innova-web/app/Providers/AppServiceProvider.php)).
- **Usage:** Converts numeric fee amounts into Bengali words (e.g., `৫,০০০` → `পাঁচ হাজার টাকা মাত্র`) for printable money receipts.

---

## 5. Asynchronous Processing, Queues, and Scheduled Tasks

### 5.1 Asynchronous Processing Inventory
- **Queues:** `QUEUE_CONNECTION=sync`. No asynchronous job workers, supervisor configs, or queue listeners are implemented.
- **Impact:** All external network I/O operations (Elitbuzz SMS dispatch, bKash REST calls, email transmission, image processing) execute on the PHP-FPM web server thread, directly degrading request latency.

### 5.2 Scheduled Tasks Inventory
- **Scheduler:** [`app/Console/Kernel.php`](file:///c:/wamp64/www/innova-web/app/Console/Kernel.php) contains an empty `schedule()` method.
- **CRON Jobs:** No automated daily backups, payment reconciliation, or database maintenance tasks are registered in the codebase.
