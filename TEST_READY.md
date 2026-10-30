# TEST_READY — E2E Test Suite for PHP 8.5 Upgrade

## 1. Test Runner & Execution Commands

The opaque-box E2E regression test suite is implemented in `tests/e2e_php85_regression_test.php`. It executes comprehensive HTTP requests against the live containerized application running on PHP 8.5.12 and MySQL 5.7.

### Primary Command (All Tiers):
```bash
docker exec waterco_web85 php tests/e2e_php85_regression_test.php
```

### Granular Tier Commands:
```bash
# Tier 1: Feature Coverage only (Auth, Dashboard, DataTables, HTML2PDF, mPDF, PhpSpreadsheet)
docker exec waterco_web85 php tests/e2e_php85_regression_test.php --tier=1

# Tier 2: Boundary & Corner Cases only
docker exec waterco_web85 php tests/e2e_php85_regression_test.php --tier=2

# Tier 3: Cross-Feature Interactions only
docker exec waterco_web85 php tests/e2e_php85_regression_test.php --tier=3

# Tier 4: Real-World Scenarios only (Full Manager Workflow)
docker exec waterco_web85 php tests/e2e_php85_regression_test.php --tier=4
```

### Optional Flags:
- `--base-url=<url>`: Custom target URL (default: `http://127.0.0.1` inside container, auto-detects `http://localhost:8085` on host).
- `--verbose`: Print raw HTTP request headers, response headers, and payload previews.
- `--help`: Display usage documentation.

---

## 2. 4-Tier Test Matrix Breakdown

| Tier | Category | Focus | Test Count | Status |
|---|---|---|---|---|
| **Tier 1** | Feature Coverage | Core functional contracts (Login 303, Dashboard 200, DataTables JSON, HTML2PDF %PDF-1.7, mPDF %PDF-1.4, PhpSpreadsheet XLSX) | 7 | **PASS (7/7)** |
| **Tier 2** | Boundary & Corner Cases | Security, invalid credentials rejection, unauthenticated 307 redirects, zero-match date ranges, missing entity handling | 5 | **PASS (5/5)** |
| **Tier 3** | Cross-Feature Interactions | Sequential session persistence across 5 modules, DataTables pagination offset slicing, clean logout invalidation | 3 | **PASS (3/3)** |
| **Tier 4** | Real-World Scenarios | Full 7-step manager operational lifecycle from login to multi-module reporting, document rendering, export, and teardown | 1 | **PASS (1/1)** |
| **TOTAL** | **Full Regression Suite** | **Comprehensive Opaque-Box E2E Coverage** | **16** | **PASS (16/16)** |

---

## 3. Test Coverage Checklist

### Tier 1: Feature Coverage (Core Functional Contracts)
- [x] **TC-T1-01**: Admin Login (`POST /login` with `iman:iman`) yields HTTP 303 redirect and sets `ci_demo_erp` session cookie without PHP 8.5 deprecation.
- [x] **TC-T1-02**: Dashboard (`GET /`) loads HTTP 200 with `<title>Sentral ERP | Dashboard</title>`, user branding `iman`, and zero deprecation notices.
- [x] **TC-T1-03**: DataTables Piutang Invoice (`GET /report_piutang_invoice/data?tanggal=2026-10-01&draw=1&start=0&length=10`) returns valid server-side JSON envelope with positive `recordsTotal`.
- [x] **TC-T1-04**: DataTables Progress PO (`GET /report_progress_po/data_po?start_date=2026-10-01&end_date=2026-10-31&draw=1&start=0&length=10`) returns valid server-side JSON envelope with `recordsTotal`.
- [x] **TC-T1-05**: HTML2PDF Engine (`GET /wt_delivery_order/printDO/D2200001`) generates valid `%PDF-1.7` stream with `%%EOF` trailer (> 5KB).
- [x] **TC-T1-06**: mPDF Engine (`GET /wt_delivery_order/print_do/D2200001`) generates valid `%PDF-1.4` stream with `%%EOF` trailer (> 10KB).
- [x] **TC-T1-07**: PhpSpreadsheet Export (`GET /report_progress_po/export_excel?start_date=2026-10-01&end_date=2026-10-31`) generates valid PK ZIP XLSX workbook with sheets `Ringkasan` and `Data PO` verified via `\PhpOffice\PhpSpreadsheet\Reader\Xlsx`.

### Tier 2: Boundary & Corner Cases
- [x] **TC-T2-01**: Invalid Credentials Authentication (`POST /login` with `invalid_user_xyz`) rejects login and keeps protected dashboard inaccessible.
- [x] **TC-T2-02**: Unauthenticated Direct Access (`GET /`) redirects to `/login` (HTTP 307 / 303 / 302) with `Location: .../login`.
- [x] **TC-T2-03**: Unauthenticated Protected Module (`GET /wt_delivery_order/delivery_order`) redirects to `/login`.
- [x] **TC-T2-04**: DataTables Zero-Match Query (`GET /report_progress_po/data_po?start_date=2001-01-01&end_date=2001-01-02`) complies with year 2000-2099 rule and returns HTTP 200 with `recordsTotal: 0` and `data: []`.
- [x] **TC-T2-05**: Non-Existent Entity Delivery Order (`GET /wt_delivery_order/print_do/NONEXISTENT_DO_99999`) produces clean PDF without fatal crash.

### Tier 3: Cross-Feature Interactions
- [x] **TC-T3-01**: Session Persistence: Single authenticated session persists across 5 sequential module requests (`/`, `/report_piutang_invoice`, `/report_progress_po`, `/wt_delivery_order/delivery_order`, `/users/setting`) without dropping.
- [x] **TC-T3-02**: DataTables Pagination & Slicing: Page 1 (`start=0&length=10`) and Page 2 (`start=10&length=10`) return distinct record slices according to server-side limit contract.
- [x] **TC-T3-03**: Clean Logout & Session Invalidation: `GET /logout` terminates session and subsequent `GET /` is redirected to `/login`.

### Tier 4: Real-World Scenarios
- [x] **TC-T4-01**: Full Manager Operational Lifecycle End-to-End:
  1. Login as manager (`iman:iman`) -> verify 303 & session cookie.
  2. Access Dashboard -> verify "Sentral ERP | Dashboard" & user profile.
  3. Query Piutang Invoice DataTables -> verify financial metrics.
  4. Issue Delivery Order PDF via HTML2PDF -> verify `%PDF-1.7` stream.
  5. Issue Delivery Order PDF via mPDF -> verify `%PDF-1.4` stream.
  6. Export Progress PO Excel -> verify workbook sheets `Ringkasan` & `Data PO`.
  7. Teardown session cleanly -> verify redirect to `/login` and session cleared.

---

## 4. Verification Evidence

Direct execution output inside `waterco_web85`:
```
Starting PHP 8.5 E2E Regression Test Suite...
Target Base URL: http://127.0.0.1
Active Tier:     all
PHP Runtime:     8.5.12 (cli)

================================================================================
 TIER 1: Feature Coverage
 Validates core functional contracts: Auth, Dashboard, DataTables, HTML2PDF, mPDF, and PhpSpreadsheet
================================================================================
  [TC-T1-01] Admin Login (iman:iman) yields HTTP 303 & session cookie PASS (523ms)
  [TC-T1-02] Dashboard loads HTTP 200 with Sentral ERP branding PASS (409ms)
  [TC-T1-03] DataTables Piutang Invoice returns valid server-side JSON PASS (887ms)
  [TC-T1-04] DataTables Progress PO returns valid server-side JSON PASS (4234ms)
  [TC-T1-05] HTML2PDF (TCPDF) generates valid %PDF- binary stream PASS (2860ms)
  [TC-T1-06] mPDF generates valid %PDF- binary stream           PASS (2808ms)
  [TC-T1-07] PhpSpreadsheet exports valid multi-sheet XLSX file PASS (4134ms)

================================================================================
 TIER 2: Boundary & Corner Cases
 Validates input sanitization, unauthorized redirects, empty ranges, and missing entities
================================================================================
  [TC-T2-01] Invalid credentials rejection without active session PASS (1413ms)
  [TC-T2-02] Unauthenticated request to / redirects to /login   PASS (339ms)
  [TC-T2-03] Unauthenticated request to protected module redirects to /login PASS (783ms)
  [TC-T2-04] DataTables query with zero-match date range handles cleanly PASS (1912ms)
  [TC-T2-05] Request for non-existent Delivery Order PDF handled without crash PASS (3222ms)

================================================================================
 TIER 3: Cross-Feature Interactions
 Validates session persistence across modules, DataTables pagination slicing, and logout
================================================================================
  [TC-T3-01] Session persists across sequential multi-module requests PASS (4859ms)
  [TC-T3-02] DataTables server-side pagination slices distinct records PASS (2043ms)
  [TC-T3-03] Logout cleanly invalidates session and redirects to login PASS (3204ms)

================================================================================
 TIER 4: Real-World Scenarios
 Executes full multi-step manager operational cycle from login to export and teardown
================================================================================
  [TC-T4-01] Full Manager Workflow: Login -> Dashboard -> DataTables -> PDF -> Excel -> Logout PASS (14787ms)

================================================================================
 E2E REGRESSION TEST SUITE SUMMARY (PHP 8.5)
================================================================================
 Total Tests Run:   16
 Passed:            16
 Failed:            0
 Execution Time:    48.42 seconds
--------------------------------------------------------------------------------
 OVERALL STATUS: ALL TESTS PASSED [PASS]
```
