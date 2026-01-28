# Project Plan: Modul SSGS & Customer Collection

This document outlines the development plan for the SSGS (Sales Support & General Services) and Customer Collection modules of the "Monitoring Aktivitas Sales Government" application.

## 1. Core Responsibilities

-   **Modul Pelanggan:** Full CRUD (Create, Read, Update, Delete) for customer data.
-   **Modul Kunjungan Pelanggan:** Full CRUD for customer visit logs.
-   **Modul Pembayaran Pelanggan:** Full CRUD for customer payment records.
-   **Monitoring:** Develop a dashboard/view to monitor payment statuses and collection activities.

## 2. Database Schema (Migrations & Models)

I will create the following models and their corresponding database migrations:

### a. `Pelanggan` (Customer)
-   `id` (Primary Key)
-   `nama_pelanggan` (string)
-   `alamat` (text)
-   `no_telepon` (string)
-   `email` (string, nullable)
-   `keterangan` (text, nullable)
-   `timestamps`

### b. `KunjunganPelanggan` (Customer Visit)
-   `id` (Primary Key)
-   `pelanggan_id` (Foreign Key to `pelanggan`)
-   `user_id` (Foreign Key to `users` - the marketing team member who visited)
-   `tanggal_kunjungan` (date)
-   `tujuan` (string - e.g., "Penagihan", "Follow Up", "Relasi")
-   `hasil_kunjungan` (text)
-   `timestamps`

### c. `PembayaranPelanggan` (Customer Payment)
-   `id` (Primary Key)
-   `pelanggan_id` (Foreign Key to `pelanggan`)
-   `tanggal_pembayaran` (date)
-   `nominal` (decimal)
-   `status_pembayaran` (enum: 'lancar', 'tertunda')
-   `keterangan` (text, nullable)
-   `timestamps`

## 3. Application Logic (Controllers)

I will create dedicated controllers for each module:
-   `PelangganController.php`
-   `KunjunganPelangganController.php`
-   `PembayaranPelangganController.php`

These controllers will contain the logic for handling all CRUD operations (store, show, edit, update, destroy).

## 4. Routing (routes/web.php)

I will define resourceful routes for each module to map URLs to the controller actions.

```php
// routes/web.php

// Assuming authentication middleware is in place

Route::resource('pelanggan', PelangganController::class);
Route::resource('kunjungan', KunjunganPelangganController::class);
Route.resource('pembayaran', PembayaranPelangganController::class);

Route::get('/monitoring/collection', [PembayaranPelangganController::class, 'monitoring'])->name('collection.monitoring');
```

## 5. User Interface (Blade Views)

I will develop the following Blade templates using Bootstrap for styling:

-   **Layouts:** Utilize the main application layout (`layouts/app.blade.php`) for a consistent look and feel.
-   **Pelanggan:**
    -   `index.blade.php` (List of customers with search/filter)
    -   `create.blade.php` (Form to add a new customer)
    -   `edit.blade.php` (Form to edit a customer)
    -   `show.blade.php` (Detailed view of a customer, including their visit and payment history)
-   **Kunjungan:**
    -   `index.blade.php` (List of all visits)
    -   `create.blade.php` (Form to log a new visit)
    -   `edit.blade.php` (Form to edit a visit log)
-   **Pembayaran:**
    -   `index.blade.php` (List of all payments)
    -   `create.blade.php` (Form to record a new payment)
    -   `edit.blade.php` (Form to edit a payment record)
-   **Monitoring:**
    -   `collection.blade.php` (A read-only view summarizing payment statuses, overdue payments, etc.)

## 6. Development Timeline & Steps

1.  **Week 1: Setup & Database**
    -   [x] Create `projek_plan.md`.
    -   [ ] Generate Models and Migrations for `Pelanggan`, `KunjunganPelanggan`, `PembayaranPelanggan`.
    -   [ ] Run migrations to create the tables in the database.
2.  **Week 2: Backend Logic**
    -   [ ] Generate Controllers.
    -   [ ] Implement the `store` and `update` logic for all CRUD modules.
    -   [ ] Define routes in `web.php`.
3.  **Week 3: Frontend Implementation**
    -   [ ] Create Blade views for all `index` and `create`/`edit` forms.
    -   [ ] Implement the `show` view for `Pelanggan` to display related data.
    -   [ ] Style the pages using Bootstrap to match the specified UI concept.
4.  **Week 4: Monitoring & Finalization**
    -   [ ] Develop the backend logic for the collection monitoring page.
    -   [ ] Create the `collection.blade.php` view.
    -   [ ] Test all CRUD functionalities and the monitoring dashboard.
    -   [ ] Refine UI/UX and ensure responsiveness.
