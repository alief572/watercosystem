# Report Piutang per Invoice

PHP 5.6 / CodeIgniter HMVC. GET endpoints: `report_piutang_invoice` (page),
`report_piutang_invoice/data` (DataTables server-side), `report_piutang_invoice/invoice_options`
(outstanding invoice dropdown), and `report_piutang_invoice/export_excel` (workbook).
All endpoints require `Report_Piutang_Invoice.View`. Admins retain their existing permission bypass.

## Deployment

Run from the repository root using the application's PHP executable:

```powershell
& C:/xampp56/php/php.exe tests/report_piutang_invoice_test.php
& C:/xampp56/php/php.exe tests/report_piutang_invoice_controller_test.php
& C:/xampp56/php/php.exe tests/report_piutang_invoice_controller_test.php --database
& C:/xampp56/php/php.exe tests/report_piutang_invoice_test.php --database
& C:/xampp56/php/php.exe scripts/deploy_report_piutang_invoice.php --environment=development
& C:/xampp56/php/php.exe scripts/deploy_report_piutang_invoice.php --environment=development --apply
```

The deployment script defaults to a read-only check. Apply adds two nonunique indexes if no equivalent
index exists, registers the View permission, and installs the menu under the active Reports parent.
It does not grant access to any user/group or change invoice, receipt, journal, or balance records.
Use the application's permission settings to grant View access. `--environment=production` uses the
production override when present, otherwise the base database configuration. Verify the printed database
name with the check command before applying in another environment. Existing equivalent indexes are retained.

## Rules and limitations

The date cutoff uses invoice/receipt business dates from currently available records, rather than an
audit snapshot. Currently deleted invoices and canceled receipts/allocations are excluded. A nonempty
valid print date makes an invoice eligible; print date itself is not the historical cutoff.
Amounts are rounded per invoice/allocation, half up to whole rupiah, before aggregating.
Receipt header bank/admin/PPH amounts are never added again to the allocated detail amount.
Missing receipt headers or invalid receipt dates quarantine their invoice at every cutoff because
their effective date cannot be established. Orphan allocations are listed separately for the
date/customer scope; choosing an existing display invoice excludes unrelated orphan allocations.
No fictitious opening balance or balancing adjustment is generated from legacy stored balances.

The page loads rows via DataTables AJAX (25 invoices by default, selectable 10/25/50/100).
The server calculates the historical dataset in batches, applies whitelisted sorting and pagination,
and sends only the requested invoice groups. Each DataTables record is a complete invoice;
receipt lines align inside its nine cells so pagination never separates an invoice's payments.
The page footer and Excel represent all filtered groups, regardless of the displayed page.
Customer choices omit null/blank names. Searchable invoice options are drawn only from reportable
outstanding invoices at the selected date/customer and ignore the invoice dropdown's own selection.
Choosing an invoice uses exact `no_surat` equality rather than substring search. Date/customer changes
refresh options and clear the previous invoice selection. Reset returns to today in Asia/Jakarta.
UI assets are scoped to this module; Plus Jakarta Sans is served locally with its OFL license.
Excel contains numeric amount cells and explicit text cells for identifiers/customer names.
The second sheet lists verification issues without assigning guessed balances.

## Acceptance and rollback

The read-only integration test asserts the inspected development baseline for 2026-09-28:
350 outstanding invoices, Rp5,466,754,018, one quarantined invoice. The earlier planning query returned
348 / Rp5,466,754,002 because MySQL rounded DOUBLE ties to even. The implemented half-up rule
is checked independently using SQL CAST to DECIMAL before ROUND. If source transactions change,
investigate the difference before updating the baseline. Check empty/filter/validation states,
pagination, unauthenticated and unauthorized access, and opening XLSX in Excel before release.

Rollback: deactivate only the `report_piutang_invoice` menu through menu settings and remove the module.
Do not remove grants or existing indexes automatically. No transaction data needs to be rolled back.
