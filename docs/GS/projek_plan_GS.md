# Project Plan: Modul Sales Government (GS)

This document outlines the development plan for the Sales Government (GS) core module of the "Monitoring Aktivitas Sales Government" application. This role focuses on the main business process: tracking project opportunities and marketing activities.

## 1. Core Responsibilities

-   **Modul Daftar Peluang Proyek:** Full CRUD for tracking project opportunities (Pipeline to Deal).
-   **Modul Aktivitas Marketing GS:** Full CRUD for recording marketing activities (meetings, visits, etc.).
-   **Dashboard & Monitoring:** Develop the main dashboard for Project Monitoring & Progress tracking.

## 2. Database Schema (Migrations & Models)

I will create the following models and their corresponding database migrations:

### a. `PeluangProyek` (Project Opportunity)
-   `id` (Primary Key)
-   `nama_instansi` (string)
-   `wilayah_id` (Foreign Key to `wilayah`)
-   `jenis_layanan` (string)
-   `status_proyek` (enum: 'Pipeline', 'Proposal', 'Tender', 'Evaluasi', 'Deal', 'Tidak Lanjut')
-   `penanggung_jawab_id` (Foreign Key to `users`)
-   `tanggal_input` (date)
-   `keterangan` (text, nullable)
-   `timestamps`

### b. `AktivitasMarketing` (Marketing Activity)
-   `id` (Primary Key)
-   `user_id` (Foreign Key to `users`)
-   `tanggal_aktivitas` (date)
-   `jenis_aktivitas` (string - e.g., 'Meeting', 'Kunjungan', 'Presentasi')
-   `instansi_tujuan` (string)
-   `wilayah_id` (Foreign Key to `wilayah`)
-   `deskripsi_aktivitas` (text)
-   `timestamps`

### c. `RiwayatProyek` (Project History - Optional/Advanced)
-   To track status changes (e.g., from Pipeline -> Proposal).

## 3. Application Logic (Controllers)

I will create dedicated controllers for the GS module:
-   `PeluangProyekController.php`
-   `AktivitasMarketingController.php`
-   `DashboardController.php` (For the main Dashboard logic)

These controllers will handle the complex logic of project tracking, status updates, and filtering data by region or status.

## 4. Routing (routes/web.php)

I will define the routes for the core business process:

```php
// routes/web.php

Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Peluang Proyek Routes
    Route::resource('proyek', PeluangProyekController::class);
    Route::post('proyek/{id}/update-status', [PeluangProyekController::class, 'updateStatus'])->name('proyek.updateStatus');

    // Aktivitas Marketing Routes
    Route::resource('aktivitas', AktivitasMarketingController::class);
});
```

## 5. User Interface (Blade Views)

I will develop the following Blade templates using Bootstrap for styling:

-   **Dashboard:**
    -   `dashboard.blade.php` (Summary cards: Pipeline count, Deal count, Charts/Tables)
-   **Peluang Proyek:**
    -   `index.blade.php` (List of projects with Status Filters & Region Filters)
    -   `create.blade.php` (Form to input new opportunity)
    -   `edit.blade.php` (Form to update project details)
    -   `show.blade.php` (Detail view: Project Info + History + Follow-up notes)
-   **Aktivitas Marketing:**
    -   `index.blade.php` (List of activities)
    -   `create.blade.php` (Form to log activity)
    -   `edit.blade.php` (Form to edit activity)

## 6. Development Timeline & Steps

1.  **Week 1: Setup & Database**
    -   [ ] Create `projek_plan_GS.md`.
    -   [ ] Generate Models/Migrations for `PeluangProyek` & `AktivitasMarketing`.
    -   [ ] Define Relationships (Proyek belongsTo Wilayah/User).
2.  **Week 2: Backend Logic (Core)**
    -   [ ] Create Controllers.
    -   [ ] Implement specific logic for Status Transitions (Pipeline -> Deal).
    -   [ ] setup Routes.
3.  **Week 3: Frontend Implementation & Dashboard**
    -   [ ] Build the Dashboard UI (Charts/Cards).
    -   [ ] Build CRUD views for Projects.
    -   [ ] Implement Filter Logic (Filter by Status, Filter by Region).
4.  **Week 4: Reporting & Finalization**
    -   [ ] Ensure "Penanggung Jawab" data is linked correctly to Auth User.
    -   [ ] Test the full flow: Input Project -> Update Status -> Deal.
    -   [ ] Refine UI/UX for ease of use.
