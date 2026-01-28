# Project Plan: Admin & Master Data System

This document outlines the development plan for the Admin and Master Data components of the "Monitoring Aktivitas Sales Government" application. This role focuses on the system foundation, security, and master data management.

## 1. Core Responsibilities

-   **Modul Login & Autentikasi:** Implement secure login and standard Laravel authentication.
-   **Modul Manajemen User:** Full CRUD (Create, Read, Update, Delete) for system users (Admin & Marketing Team).
-   **Modul Data Wilayah:** Full CRUD for marketing region data (Lampung, Bengkulu, etc.).
-   **Hak Akses (Role Management):** Implement middleware/policies to distinguish between Admin and Marketing Team access.

## 2. Database Schema (Migrations & Models)

I will manage the following models and database migrations:

### a. `User` (Modified Default Laravel Model)
-   `id` (Primary Key)
-   `name` (string)
-   `email` (string, unique)
-   `password` (string)
-   `role` (enum: 'admin', 'marketing')
-   `timestamps`

### b. `Wilayah` (Region)
-   `id` (Primary Key)
-   `nama_wilayah` (string - e.g., "Witel Lampung", "Witel Bengkulu")
-   `keterangan` (text, nullable)
-   `timestamps`

## 3. Application Logic (Controllers)

I will create/modify the following controllers:
-   `AuthenticatedSessionController.php` (for Login/Logout logic - using Breeze/Standard Auth)
-   `UserController.php` (for managing accounts)
-   `WilayahController.php` (for managing regions)

These controllers will contain the logic for authentication and master data CRUD operations.

## 4. Routing (routes/web.php)

I will define the base routes and administrative routes:

```php
// routes/web.php

// Authentication Routes (Breeze default or custom)
require __DIR__.'/auth.php';

// Admin Routes (Protected by Middleware)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('wilayah', WilayahController::class);
});
```

## 5. User Interface (Blade Views)

I will develop the following Blade templates using Bootstrap:

-   **Auth Views:**
    -   `login.blade.php` (Custom styled login page)
-   **User Management:**
    -   `index.blade.php` (List of all users)
    -   `create.blade.php` (Form to add new user)
    -   `edit.blade.php` (Form to edit user data/password)
-   **Wilayah Management:**
    -   `index.blade.php` (List of regions)
    -   `create.blade.php` (Form to add region)
    -   `edit.blade.php` (Form to edit region)

## 6. Development Timeline & Steps

1.  **Week 1: Setup & Foundation**
    -   [ ] Create `projek_plan_Admin.md`.
    -   [ ] Install Laravel & Configure Database.
    -   [ ] Setup Authentication (Laravel Breeze/Jetstream or custom).
    -   [ ] Create `Wilayah` model and migration.
2.  **Week 2: User Management & Roles**
    -   [ ] Modify `User` table for roles.
    -   [ ] Create `UserController` and Views.
    -   [ ] Implement Middleware for Role Access (Admin vs Marketing).
3.  **Week 3: Master Data Implementation**
    -   [ ] Create `WilayahController`.
    -   [ ] Develop Views for Wilayah CRUD.
    -   [ ] Test data integrity (Foreign Key checks if needed later).
4.  **Week 4: Reporting & Finalization**
    -   [ ] Ensure Admin can view global dashboards (collaborate with other modules).
    -   [ ] Final Security Testing (Login, unauthorized access checks).
    -   [ ] Refine UI/UX for Admin panel.
