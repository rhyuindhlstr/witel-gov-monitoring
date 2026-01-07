# Roadmap Pengerjaan: Website Monitoring Sales Gov & SSGS

Berikut adalah detail task (tugas) untuk pengerjaan proyek dari awal sampai selesai, digabungkan untuk 3 anggota tim.

## 🏁 Phase 1: Setup & Pondasi (Minggu 1 - Awal)
*Siapa: Dikerjakan bersama-sama atau oleh Person 1 (Admin)*

- [ ] **Instalasi Project**
    - Install Laravel.
    - Setup Database MySQL (`db_witel_monitoring`).
    - Setup Git Repository.
- [ ] **Autentikasi & Template**
    - Install Laravel Breeze (Login System).
    - Integrasi Template Admin (SB Admin 2 / Stisla).
    - Setup Layout Master (`resources/views/layouts/app.blade.php`).

---

## 🏗 Phase 2: Pengerjaan Paralel per Modul (Minggu 1 - 3)

### 👤 Person 1: Admin & Master Data
- [ ] **Database & Model**
    - Buat migrasi tabel `users` (tambah kolom `role`, `phone`).
    - Buat migrasi tabel `wilayahs` (id, nama, keterangan).
    - Buat Model `Wilayah`.
- [ ] **Fitur Admin**
    - Buat CRUD Data Wilayah (Controller + Views).
    - Buat CRUD Manajemen User (Tambah/Edit/Hapus akun Sales).
    - Setup Middleware untuk membedakan akses Admin vs Sales.

### 👤 Person 2: Sales Gov (GS) - Core Business
- [ ] **Database & Model**
    - Buat migrasi `peluang_proyeks`.
    - Buat migrasi `aktivitas_marketings`.
    - Setup Relasi: Proyek `belongsTo` User, Proyek `belongsTo` Wilayah.
- [ ] **Fitur Sales**
    - Buat CRUD Peluang Proyek (Input baru, Edit data).
    - Buat Fitur Update Status (Tombol untuk ubah Pipeline -> Proposal -> Deal).
    - Buat CRUD Aktivitas Marketing (Log harian sales).
    - Tampilan Daftar Proyek dengan Filter Status & Wilayah.

### 👤 Person 3: SSGS & Collection
- [ ] **Database & Model**
    - Buat migrasi `pelanggans`, `kunjungan_pelanggans`, `pembayaran_pelanggans`.
    - Setup Relasi antar tabel.
- [ ] **Fitur SSGS**
    - Buat CRUD Data Pelanggan.
    - Buat CRUD Input Kunjungan.
    - Buat CRUD Input Pembayaran.
    - Buat status indikator pembayaran (Hutang / Lunas).

---

## 📊 Phase 3: Dashboard & Integrasi (Minggu 4)
*Siapa: Semua Anggota*

- [ ] **Dashboard Utama**
    - Menampilkan Card Total Proyek (Pipeline, Deal).
    - Menampilkan Grafik Pencapaian.
    - Menampilkan Daftar Tagihan Jatuh Tempo (SSGS).
- [ ] **Finishing**
    - Merapikan Sidebar Menu (Menu Admin tidak muncul di Sales, dll).
    - Testing alur dari Login sampai Logout.
    - Perbaikan Bug & UI.

---

## 📝 Checklist Dokumen Laporan (Sambil Jalan)
- [ ] Screenshot setiap form yang sudah jadi.
- [ ] Simpan kodingan Controller & Model untuk lampiran.
- [ ] Catat kendala yang ditemui untuk Bab Pembahasan.
