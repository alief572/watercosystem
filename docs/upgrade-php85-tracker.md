# Ledger Pelacakan Upgrade Runtime ke PHP 8.5 (watercosystem)

Dokumen ini adalah **single source of truth (SSOT)** lintas sesi untuk proses upgrade runtime ke PHP 8.5 (CodeIgniter 3.1.13 HMVC).
Sistem ini menjamin pengerjaan bersifat deterministik dan context-independent.

---

## 1. Status Ringkasan Per Fase

| Fase | Deskripsi | Status | Commit Checkpoint | Tanggal Selesai |
| :---: | :--- | :---: | :---: | :---: |
| **Fase 0** | Isolasi Branch `upgrade/php85`, Docker PHP 8.5 (`8085`), & Infrastruktur Checkpoint | `[x] LULUS` | `checkpoint-fase-0` | 2026-10-30 |
| **Fase 1** | Audit Database `menus` & Matriks 54 Modul Aktif | `[ ] Belum Mulai` | - | - |
| **Fase 2** | Upgrade Composer (`phpoffice/phpspreadsheet` major, `mpdf` ^8.3) & Fix Shims | `[ ] Belum Mulai` | - | - |
| **Fase 3** | Patch Bedah Core CI3 (`system/`), HMVC MX & Strict Deprecation Mode | `[ ] Belum Mulai` | - | - |
| **Fase 4** | Audit & Perbaikan 54 Modul Aktif di PHP 8.5 (Batch 4A–4D) | `[ ] Belum Mulai` | - | - |
| **Fase 5** | Regresi E2E, Promosi Docker Default PHP 8.5 & Panduan Rilis Apache | `[ ] Belum Mulai` | - | - |

---

## 2. Parameter Environment & Setup

- **Branch Kerja**: `upgrade/php85` (dibuat dari `dev` commit `91bbd96`)
- **Stash Fitur Non-Upgrade**: `stash@{0}`: `wip: master_customers identity and stock_booking (pre-php85)`
- **Container Overlay**: `waterco_web85` di port `http://localhost:8085` (image `watercosystem-web85`, `php:8.5-apache`)
- **Container DB**: `waterco_db` (MySQL 5.7 di port `3306`), database `waterco_demo` (415 tabel)
- **Container Web Existing**: `waterco_web` (port `8080`) tetap berjalan untuk referensi/komparasi
- **Skrip Verifikasi**: `scripts/verify_php85_checkpoint.php`

---

## 3. Cakupan Modul (Total 54 Modul)
- **48 Modul Sidebar Aktif** (`status = 1` & `group_menu = 1` pada tabel `menus`)
- **6 Modul Dependensi Lintas-Modul**: `jurnal_nomor`, `all`, `pembayaran_rutin`, `customer`, `penawaran`, `aktifitas`
- Detail status per-modul disimpan di: `docs/upgrade-php85-modules.json`

---

## 4. Instruksi Resume Sesi (Jika Sesi Berpindah / Chat Baru)

1. Pastikan berada di branch `upgrade/php85`: `git checkout upgrade/php85`
2. Periksa status container: `docker compose -f docker-compose.yml -f docker-compose.php85.yml ps`
3. Jalankan verifikator checkpoint:
   ```bash
   docker exec waterco_web85 php scripts/verify_php85_checkpoint.php --status
   ```
4. Baca baris fase aktif pada tabel di atas dan lanjutkan ke task berikutnya sesuai rencana di [implementation_plan.md](file:///C:/Users/Febry/.gemini/antigravity/brain/c113c298-6a27-4489-83f4-1310415399d0/implementation_plan.md).
