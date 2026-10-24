# Phase 3 — Audit Evidence Reconciliation & Backup Safety Plan (Read-Only)

**Project:** `innova-web` — INNOVA Computers BD (ICBD)  
**Phase:** Phase 3 Architecture Audit & Evidence Reconciliation  
**Author:** Senior Database Migration Architect & Lead Engineer  
**Date:** October 2026  
**Active Git Branch:** `feature/phase-1-security-hardening`  
**Operational Database:** `icbd_web` on MySQL 8.0.31 (`127.0.0.1:3306`, 52 Base Tables, 15,663 Operational Records)  
**Audited Documents Reconciled:**
- [`docs/phase-3-planning/PHASE_3_READINESS_REVIEW.md`](file:///c:/wamp64/www/innova-web/docs/phase-3-planning/PHASE_3_READINESS_REVIEW.md)
- [`docs/phase-3-planning/PHASE_3_DATA_PROFILING_AND_BACKUP_REVIEW.md`](file:///c:/wamp64/www/innova-web/docs/phase-3-planning/PHASE_3_DATA_PROFILING_AND_BACKUP_REVIEW.md)
- [`docs/phase-3-planning/PHASE_3_MIGRATION_RECONSTRUCTION_PLAN.md`](file:///c:/wamp64/www/innova-web/docs/phase-3-planning/PHASE_3_MIGRATION_RECONSTRUCTION_PLAN.md)
- [`docs/phase-2-database/PHASE_2_BLOCKERS_AND_DECISIONS.md`](file:///c:/wamp64/www/innova-web/docs/phase-2-database/PHASE_2_BLOCKERS_AND_DECISIONS.md)

---

## 1. Executive Summary & Reconciliation Status

This document reconciles all technical evidence, arithmetic discrepancies, terminology inconsistencies, and safety prerequisites identified across Phase 2 and Phase 3 planning artifacts. 

Every claim has been cross-referenced against confirmed stored values in the live database audit logs, static source code analysis, and database engine specifications. **No database connections, writes, DDL operations, migrations, backups, or restores were executed during this review.**

### Official Reconciliation Status:
```
RECONCILIATION COMPLETE — OWNER REVIEW REQUIRED
```

> [!IMPORTANT]
> **Implementation remains strictly blocked.** Achieving `RECONCILIATION COMPLETE` signifies that all conflicting evidence, arithmetic mismatches, and architectural assumptions have been fully untangled and documented. Physical execution cannot begin until all 8 Owner Decision Gates receive formal sign-off and an authorized backup-and-restore verification is completed on an isolated disposable database.

---

## 2. Check 1: Reconciliation of Century-Typo Counts

### 2.1 The Discrepancy Defined
In [`docs/phase-3-planning/PHASE_3_DATA_PROFILING_AND_BACKUP_REVIEW.md`](file:///c:/wamp64/www/innova-web/docs/phase-3-planning/PHASE_3_DATA_PROFILING_AND_BACKUP_REVIEW.md), three conflicting counts were stated or implied:
1. The text headers (Section 2 bullet 3 and Section 3.3) stated **"13 operational records"**.
2. Adding the numbers as written in Section 2 bullet 3 (*"expanses: 8 rows... incomes: 6 rows... fees_transections: 1 row"*) yields **15 records** (8 + 6 + 1 = 15).
3. Summing the individual row counts in the Section 3.3 Markdown table yields **16 records**.

### 2.2 Independent Evidence Audit & Arithmetic Total
The actual query output from the live profiling script (`check_dates.php`) was audited line-by-line. The exact stored values, distinct dates, and affected database rows are detailed below:

| # | Target Table | Target Column | Confirmed Stored Value in MySQL | Row Count (Affected Rows) | Inferred Corrected Real-World Date | Evidence Source |
|---|---|---|---|---|---|---|
| 1 | `expanses` | `invoiceDate` | `'0023-11-20'` | **1** | `2023-11-20` (Inferred) | Live DB Query |
| 2 | `expanses` | `invoiceDate` | `'0023-11-22'` | **1** | `2023-11-22` (Inferred) | Live DB Query |
| 3 | `expanses` | `invoiceDate` | `'0023-11-30'` | **1** | `2023-11-30` (Inferred) | Live DB Query |
| 4 | `expanses` | `invoiceDate` | `'0024-05-20'` | **1** | `2024-05-20` (Inferred) | Live DB Query |
| 5 | `expanses` | `invoiceDate` | `'0025-01-26'` | **1** | `2025-01-26` (Inferred) | Live DB Query |
| 6 | `expanses` | `invoiceDate` | `'0026-05-22'` | **3** | `2026-05-22` (Inferred) | Live DB Query |
| 7 | `expanses` | `invoiceDate` | `'0026-07-02'` | **1** | `2026-07-02` (Inferred) | Live DB Query |
| **—** | **Subtotal (expanses)** | | **7 Distinct Values** | **9 Affected Rows** | | |
| 8 | `incomes` | `invoiceDate` | `'0023-11-20'` | **2** | `2023-11-20` (Inferred) | Live DB Query |
| 9 | `incomes` | `invoiceDate` | `'0223-10-07'` | **1** | `2023-10-07` (Inferred) | Live DB Query |
| 10 | `incomes` | `invoiceDate` | `'0024-11-20'` | **1** | `2024-11-20` (Inferred) | Live DB Query |
| 11 | `incomes` | `invoiceDate` | `'0024-11-24'` | **1** | `2024-11-24` (Inferred) | Live DB Query |
| 12 | `incomes` | `invoiceDate` | `'0025-06-26'` | **1** | `2025-06-26` (Inferred) | Live DB Query |
| **—** | **Subtotal (incomes)** | | **5 Distinct Values** | **6 Affected Rows** | | |
| 13 | `fees_transections`| `paiddate` | `'0226-06-04'` | **1** | `2026-06-04` (Inferred) | Live DB Query |
| **—** | **Subtotal (fees)** | | **1 Distinct Value** | **1 Affected Row** | | |
| **TOTAL** | **Entire Database** | | **13 Distinct Values** | **16 Affected Rows** | | |

### 2.3 Exact Explanation of the Discrepancy
The discrepancy arose from two separate reporting errors:
1. **Conflating Distinct Date Values with Affected Rows (13 vs. 16):**
   There are exactly **13 distinct date-string values** (which formed the 13 rows of the summary table). Because `'0026-05-22'` in `expanses` occurs 3 times, and `'0023-11-20'` in `incomes` occurs 2 times, the total number of **affected database records is 16**, not 13.
2. **Text Typo in `expanses` Subtotal (8 vs. 9):**
   In Section 2 bullet 3, the text stated: *"expanses.invoiceDate: 8 rows with years 0023 (3 rows), 0024 (1 row), 0025 (1 row), 0026 (4 rows)"*. Adding the explicit parenthetical values (3 + 1 + 1 + 4) correctly equals **9 rows**, but the preceding summary word wrote `"8 rows"`. Summing the erroneous text figures (8 + 6 + 1) produced the apparent total of **15**.

### 2.4 Stored Values vs. Inferred Corrections
- **Confirmed Stored Values:** The 16 database records literally store dates in the first and third centuries CE (`0023`, `0024`, `0025`, `0026`, `0223`, `0226`).
- **Inferred Corrected Dates:** Dates such as `2023-11-20` or `2026-06-04` are **inferences** based on typical two-digit year entry errors (e.g. user typed `"23-11-20"` and MySQL coerced it to year `0023`). 
- **Safety Rule:** These inferred corrections **must not be applied automatically**. They represent financial vouchers and student payment dates that must be formally reviewed and approved by INNOVA Computers BD accounting under Decision Gate 5.

---

## 3. Check 2: Zero-Date and Date-Anomaly Evidence Reconciliation

### 3.1 Zero-Date Consensus Across All Reports
Every audit document across Phase 2 and Phase 3 is in **100% agreement** regarding zero dates (`'0000-00-00'`):
- [`PHASE_2_DATABASE_INVENTORY.md:155, 175, 252`](file:///c:/wamp64/www/innova-web/docs/phase-2-database/PHASE_2_DATABASE_INVENTORY.md#L155): `expanses.invoiceDate` (6 rows) and `incomes.invoiceDate` (8 rows).
- [`PHASE_2_SCHEMA_DRIFT_REPORT.md:26, 175-179`](file:///c:/wamp64/www/innova-web/docs/phase-2-database/PHASE_2_SCHEMA_DRIFT_REPORT.md#L26): Exactly 14 zero-date rows.
- [`PHASE_2_POSTGRESQL_COMPATIBILITY.md:27, 133-145`](file:///c:/wamp64/www/innova-web/docs/phase-2-database/PHASE_2_POSTGRESQL_COMPATIBILITY.md#L27): Exactly 14 zero-date rows.
- [`PHASE_2_BLOCKERS_AND_DECISIONS.md:88-96`](file:///c:/wamp64/www/innova-web/docs/phase-2-database/PHASE_2_BLOCKERS_AND_DECISIONS.md#L88): Decision Gate 5 covers exactly 14 zero-date rows.
- [`PHASE_3_READINESS_REVIEW.md:38, 227`](file:///c:/wamp64/www/innova-web/docs/phase-3-planning/PHASE_3_READINESS_REVIEW.md#L38): Reconfirmed 14 zero-date rows.
- [`PHASE_3_DATA_PROFILING_AND_BACKUP_REVIEW.md:44, 131-136`](file:///c:/wamp64/www/innova-web/docs/phase-3-planning/PHASE_3_DATA_PROFILING_AND_BACKUP_REVIEW.md#L44): Universal scan across 163 date columns confirmed that no other table or column contains `'0000-00-00'`.

### 3.2 Clear Boundary: Zero Dates vs. Century-Typo Dates
The two categories of date anomalies are fundamentally distinct in database engine handling, data semantics, and remediation:

```
+----------------------------------------------------------------------------------------------------+
| Dimension              | Zero-Date Anomalies ('0000-00-00')     | Century-Typo Anomalies ('0023-..')       |
+----------------------------------------------------------------------------------------------------+
| Total Records          | Exactly 14 rows                        | Exactly 16 rows                          |
| Tables Affected        | expanses (6), incomes (8)              | expanses (9), incomes (6), fees (1)      |
| PostgreSQL Syntax      | Fatal Error: SQL State 22008           | Valid Date Syntax: Accepted as CE year   |
| Engine Coercion        | MySQL permitted with NO_ZERO_DATE off  | MySQL expanded 2-digit '23' to '0023'    |
| Business Semantics     | Date was omitted or reset to zero      | Real transaction occurred in 2023-2026   |
| Safe Target Resolution | Convert strictly to NULL (Gate 5)      | Correct century prefix to 202x (Gate 5)  |
| Execution Status       | Unaltered (Requires owner approval)    | Unaltered (Requires owner approval)      |
+----------------------------------------------------------------------------------------------------+
```

**Grand Total of Date Anomalies:** Exactly **30 anomalous records** across the entire 15,663-row database (14 zero-dates + 16 century-typos), all confined to 3 transactional columns (`expanses.invoiceDate`, `incomes.invoiceDate`, `fees_transections.paiddate`).

---

## 4. Check 3: Backup Methodology & Safety Architecture Review

### 4.1 Why `mysqldump --single-transaction` is Insufficient for MyISAM Tables
Earlier planning documents frequently referenced:
`mysqldump --single-transaction --routines --triggers --hex-blob icbd_web > backup.sql`

This command is **architecturally flawed for `icbd_web`** due to its storage engine composition:
1. **The Mechanism of `--single-transaction`:**
   `--single-transaction` issues a `START TRANSACTION WITH CONSISTENT SNAPSHOT` in MySQL. This utilizes InnoDB's Multi-Version Concurrency Control (MVCC) to read an isolated snapshot at a specific point in time without acquiring global table locks.
2. **The MyISAM Failure Mode:**
   **MyISAM tables do not support transactions.** MyISAM has no undo logs, no MVCC, and no snapshot isolation.
   When `mysqldump` reaches a MyISAM table during a `--single-transaction` dump:
   - It reads the MyISAM table in whatever state it exists at the millisecond the `SELECT` query runs.
   - Any concurrent write (INSERT, UPDATE, DELETE) by a web user, background cron job, or administrator will write directly to the table mid-dump.
   - If a loan EMI payment occurs mid-dump, child records in `emi_installments` (MyISAM) may be captured while parent records in `bank_loans` (MyISAM) or `shareholders` (InnoDB) reflect a different timestamp.
3. **The Risk to `icbd_web`:**
   In `icbd_web`, **14 tables use the MyISAM engine**, including core operational and financial modules: `bank_loans`, `emi_installments`, `investment_withdraws`, `dividend_withdraws`, `asset_registrations`, and `asset_registration_feedbacks`. A naive `--single-transaction` dump cannot guarantee point-in-time consistency across these tables.

---

### 4.2 Proposed Backup Safety Strategy (Plan Only — Not Executed)

To achieve genuine consistency across a mixed InnoDB/MyISAM database without risking data divergence, the following two-tier procedure is specified:

```mermaid
graph TD
    subgraph Tier1 [Option A: Scheduled Maintenance Window - Recommended]
        A1[1. Announce Maintenance Window] --> A2[2. Activate Maintenance Mode: php artisan down]
        A2 --> A3[3. Flush & Lock All Tables Globally]
        A3 --> A4[4. Consistent Dump with --lock-all-tables]
        A4 --> A5[5. Unlock Tables & Reopen Application]
    end

    subgraph Tier2 [Option B: True Cold Offline Backup - Maximum Safety]
        B1[1. Stop Apache / Web Server Traffic] --> B2[2. Gracefully Stop MySQL Service]
        B2 --> B3[3. Copy Raw Data Files / Binary Snapshot]
        B3 --> B4[4. Start MySQL in Read-Only Mode]
        B4 --> B5[5. Execute Authoritative Logical Dump]
    end
```

#### Option A: Consistent Logical Dump under Maintenance Lock (Recommended for Production Cutover)
1. **Activate Maintenance Mode:**
   Take the application offline to halt all web requests, queue workers, and cron jobs:
   ```bash
   php artisan down --secret="phase3-maintenance-gate" --render="errors::503"
   ```
2. **Execute Full Consistent Logical Export:**
   Use `--lock-all-tables` (which executes `FLUSH TABLES WITH READ LOCK`) to acquire a global read lock across all InnoDB and MyISAM tables simultaneously:
   ```bash
   mysqldump -u root -p \
     --lock-all-tables \
     --routines \
     --triggers \
     --events \
     --hex-blob \
     --default-character-set=utf8mb4 \
     icbd_web > C:\innova_secure_backups\icbd_web_pre_migration_locked.sql
   ```
3. **Deactivate Maintenance Mode:**
   Once the dump completes and the file is verified, release the maintenance lock:
   ```bash
   php artisan up
   ```

#### Option B: True Cold Offline Backup
- **Definition of "Cold Backup":** A backup can only be truthfully described as a "cold backup" if the database management daemon is either completely stopped or running in an enforced `--read-only=ON` state where zero client writes can occur. Running `mysqldump` against an active, writable MySQL instance is a **warm or hot dump**, not a cold backup.
- **Offline Procedure:** Gracefully stop MySQL service (`net stop wampmysqld64`), copy physical data files (`icbd_web` data directory and InnoDB redo logs), restart MySQL in read-only mode, and take the logical dump.

---

### 4.3 Checksum Verification vs. Actual Restore Verification

```
+---------------------------------------------------------------------------------------------------+
| Verification Type      | What It Proves                           | What It Does NOT Prove        |
+---------------------------------------------------------------------------------------------------+
| Checksum Verification  | • File transport integrity               | • SQL statement syntax        |
| (SHA-256)              | • File is not truncated or modified      | • Schema validity             |
|                        | • Bit-for-bit storage preservation       | • Absence of collation errors|
|                        |                                          | • Database restorable         |
+---------------------------------------------------------------------------------------------------+
| Actual Restore Test    | • Full restorable capability proved      | • Requires isolated target    |
| (Disposable DB)        | • All 52 tables created successfully     | • Must never run on live DB   |
|                        | • 15,663 rows imported cleanly           | • Requires explicit owner     |
|                        | • Zero foreign-key or encoding errors    |   pre-authorization           |
+---------------------------------------------------------------------------------------------------+
```

- **Checksum alone is insufficient:** A dump file can have a perfectly matching SHA-256 checksum but contain invalid SQL syntax, unsupported character sets, or exceed `max_allowed_packet` on import.
- **Mandatory Restore Protocol:** A backup is **unverified** until it has been imported into an isolated, disposable target database (`icbd_web_verify_restore`) with zero errors, and validated using row count checksums across all 52 tables.

---

### 4.4 Mandatory Backup Storage & Security Rules
1. **Never Store Dumps in Repository:** Under no circumstances should database dumps (`.sql`, `.sql.gz`, `.dump`) be committed to Git or stored anywhere within the repository tree (`c:\wamp64\www\innova-web`).
2. **Never Store Dumps in Web Root:** Storing dumps in `public/`, `storage/`, or web-accessible directories creates a catastrophic remote information disclosure vulnerability (as was remediated in Phase 1 for `innovacomputer_pay.sql`).
3. **Encrypted, Access-Restricted Storage:** Backups must be written to a dedicated, encrypted external directory (e.g. `C:\innova_secure_backups\`) with filesystem permissions restricted strictly to administrative accounts.

---

## 5. Check 4: Reconciliation of Decisions, Terminology & Contradictions

### 5.1 Confirmation of Pending Owner Decisions
All **8 architectural decision gates** established in Phase 2 remain **100% PENDING** owner review and sign-off:

```
+---------------+-------------------------------------------------------------+-----------------+
| Decision Gate | Core Architecture Question                                  | Decision Status |
+---------------+-------------------------------------------------------------+-----------------+
| Gate 1        | Reverse-engineer migrations for 5 unmigrated tables         | PENDING SIGN-OFF|
| Gate 2        | Academic sessions vs. HTTP sessions (rename to academic_...) | PENDING SIGN-OFF|
| Gate 3        | fees_transections.trxID deduplication (IDs 332-337)         | PENDING SIGN-OFF|
| Gate 4        | Monetary normalization (VARCHAR -> NUMERIC(15,2))           | PENDING SIGN-OFF|
| Gate 5        | Zero-dates (NULL) & Century-typo dates correction           | PENDING SIGN-OFF|
| Gate 6        | 14 MyISAM tables conversion to strict transactional tables  | PENDING SIGN-OFF|
| Gate 7        | Table/column misspelling modernization (expanses, etc.)     | PENDING SIGN-OFF|
| Gate 8        | React frontend & UTF-8 / ISO 8601 target architecture       | PENDING SIGN-OFF|
+---------------+-------------------------------------------------------------+-----------------+
```
**Conclusion:** No decision gate has been bypassed, assumed, or silently resolved. Implementation cannot proceed without explicit owner approval.

---

### 5.2 Summary of Contradictions Reconciled Across Reports

```
+---------------------------------------------------------------------------------------------------------------------------------------+
| Topic                 | Earlier Report Claim                    | Reconciled Reality (Backed by Audit Evidence)               |
+---------------------------------------------------------------------------------------------------------------------------------------+
| Century-Typo Count    | "13 records" (header) / "15 records"    | 13 distinct date strings affecting exactly 16 database rows. |
|                       | (arithmetic in Section 2 text)          | (9 in expanses, 6 in incomes, 1 in fees_transections).       |
+---------------------------------------------------------------------------------------------------------------------------------------+
| Zero-Date Count       | 14 rows across expanses (6) & incomes(8)| Confirmed: Exactly 14 rows across entire database.          |
|                       |                                         | 100% consistent across all Phase 2 and Phase 3 reports.     |
+---------------------------------------------------------------------------------------------------------------------------------------+
| Financial Comma Myth  | Widespread comma-formatted monetary     | Refuted: Zero commas exist in any financial field across     |
|                       | strings (e.g. '15,000') in 6 tables     | 13,689 records. Only anomaly: 2 trailing dots ("50.").      |
+---------------------------------------------------------------------------------------------------------------------------------------+
| Unmigrated Columns    | "23 unmigrated columns" (Section 4.2    | Minor typo in section header: Table and live audit confirm  |
|                       | title in Reconstruction Plan)           | exactly 24 distinct unmigrated columns across 6 tables.      |
+---------------------------------------------------------------------------------------------------------------------------------------+
| Total Table Count     | "49 tables" cited in early Phase 0      | Reconciled in Phase 2: Live database contains exactly       |
|                       | exploration reports                     | 52 base tables (49 operational + 3 session/system tables).  |
+---------------------------------------------------------------------------------------------------------------------------------------+
| Backup Description    | Described as "cold dump" via mysqldump  | Reconciled: mysqldump against live server is an online dump. |
|                       | --single-transaction                    | Consistent backup requires maintenance lock or service stop.|
+---------------------------------------------------------------------------------------------------------------------------------------+
```

---

## 6. Preserved Uncertainties & Real-World Limitations

To maintain absolute documentation integrity, the following uncertainties are explicitly recorded as requiring real-world human input:

1. **Accounting Verification of Century-Typo Dates:**
   While dates like `'0023-11-20'` are logically inferred to mean `'2023-11-20'`, software cannot assume legal accounting intent. The 16 affected vouchers and fee receipts must be verified against physical receipts or bank records before updating dates.
2. **Payment IDs 332–337 Resolution:**
   Whether records 333–337 represent repeated bKash webhook retries or separate legitimate partial payments for the same student cannot be decided by SQL queries alone. This requires INNOVA Computers BD accounting ledger reconciliation.
3. **Ghost Modules Intent (`assets` & `asset_students`):**
   These tables exist in migration files but were never created in MySQL. Trainee leads are stored in `asset_registrations`. The project owner must confirm whether these empty ghost modules should be retained or retired.

---

## 7. Implementation Blockers & Final Status

### Summary of Blocking Prerequisites:
1. **Owner Approval on Decision Gates 1 through 8:** Complete formal recorded sign-off required.
2. **Authoritative Backup Creation:** Execution of `--lock-all-tables` dump into encrypted storage outside web root.
3. **Authorized Restore Test:** Owner authorization and execution of test restore on an isolated disposable database (`icbd_web_verify_restore`).
4. **Codebase Query Builder Patches:** Patching raw `DB::table('sessions')` calls in `UserController.php` and `SessionController.php` before database migration.

### Final Determination:
```
RECONCILIATION COMPLETE — OWNER REVIEW REQUIRED
```

*All technical evidence, arithmetic discrepancies, and backup safety requirements are fully reconciled and documented. Implementation remains strictly paused until the project owner provides formal authorization.*
