# Witel Gov Monitoring System

![Laravel](https://img.shields.io/badge/Laravel-12.0-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white)
![Status](https://img.shields.io/badge/Status-Active-success?style=for-the-badge)

## 📖 Ringkasan Eksekutif

**Witel Gov Monitoring System** adalah solusi perusahaan tingkat lanjut yang dirancang untuk mengoptimalkan dan mendigitalkan pemantauan aktivitas penjualan pemerintah di lingkungan Witel. Platform ini memberikan visibilitas *real-time* terhadap kinerja tim, manajemen hubungan pelanggan (CRM), dan pelacakan peluang proyek strategis. Dengan arsitektur yang kuat dan antarmuka yang intuitif, sistem ini mendukung pengambilan keputusan berbasis data bagi manajemen.

---

## 🌟 Fitur Unggulan

Sistem ini dilengkapi dengan berbagai modul komprehensif untuk mendukung operasional bisnis:

### 1. Manajemen Akses & Keamanan (RBAC)
*   **Hierarki Peran Terstruktur**: Pemisahan hak akses yang ketat antara **Admin**, **SSGS** (Sales Support), dan **GS** (Government Service).
*   **Autentikasi Aman**: Didukung oleh Laravel Breeze untuk keamanan login yang tangguh.

### 2. Dashboard Analitik Cerdas
*   **Visualisasi Data**: Grafik dan metrik kinerja disajikan secara *real-time* untuk setiap peran pengguna.
*   **KPI Tracking**: Pemantauan langsung terhadap target penjualan dan aktivitas harian.

### 3. Manajemen Hubungan Pelanggan (CRM)
*   **Database Pelanggan Terpusat**: Penyimpanan dan pengelolaan data pelanggan instansi pemerintah secara terstruktur.
*   **Log Kunjungan Digital**: Pencatatan detail kunjungan lapangan, hasil pertemuan, dan tindak lanjut.

### 4. Manajemen Peluang & Proyek
*   **Pipeline Tracking**: Pelacakan siklus hidup proyek dari tahap prospek (lead) hingga penyelesaian (closing).
*   **Manajemen Status**: Monitoring status proyek (Won, Lost, In Progress) dengan riwayat aktivitas.

### 5. Kontrol Keuangan & Piutang
*   **Monitoring Pembayaran**: Pelacakan status tagihan dan riwayat pembayaran pelanggan.
*   **Sistem Peringatan Dini**: Notifikasi otomatis untuk tagihan jatuh tempo (*Jatuh Tempo*) guna meminimalisir tunggakan.

### 6. Pelaporan & Ekspor Data
*   **Laporan PDF Profesional**: Pembuatan laporan aktivitas dan kinerja siap cetak.
*   **Kompatibilitas Excel**: Ekspor data komprehensif untuk analisis lanjutan menggunakan spreadsheet.

---

## 🏗️ Arsitektur Teknologi

Dibangun di atas fondasi teknologi modern untuk menjamin performa, skalabilitas, dan kemudahan pemeliharaan:

| Komponen | Teknologi | Deskripsi |
| :--- | :--- | :--- |
| **Framework Backend** | **Laravel 12** | Framework PHP modern dengan performa tinggi dan keamanan standar industri. |
| **Database** | **MySQL 8** | RDBMS yang handal untuk integritas dan kecepatan akses data transaksional. |
| **Frontend** | **Blade & Bootstrap 5** | Antarmuka pengguna yang responsif, modern, dan ringan. |
| **Reporting Engine** | **DomPDF & Maatwebsite** | Mesin pembuatan dokumen digital yang presisi. |

---

## ⚙️ Persyaratan Sistem

Sebelum melakukan instalasi, pastikan lingkungan server Anda memenuhi spesifikasi berikut:

*   **PHP**: Versi 8.2 atau lebih baru.
*   **Composer**: Manajer dependensi PHP.
*   **Node.js & NPM**: Untuk manajemen aset frontend.
*   **MySQL**: Server database.

---

## 🚀 Panduan Instalasi & Deployment

Ikuti prosedur standar berikut untuk menerapkan aplikasi di lingkungan pengembangan lokal:

### Langkah 1: Akuisisi Kode Sumber
```bash
git clone https://github.com/username-anda/witel-gov-monitoring.git
cd witel-gov-monitoring
```

### Langkah 2: Instalasi Dependensi Inti
Instal seluruh pustaka yang dibutuhkan oleh sistem:
```bash
composer install
npm install
```

### Langkah 3: Konfigurasi Lingkungan
Duplikasi file konfigurasi standar dan sesuaikan dengan parameter lokal Anda:
```bash
cp .env.example .env
```
Sunting file `.env` dan sesuaikan parameter koneksi database:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=witel_monitoring_db
DB_USERNAME=root
DB_PASSWORD=
```

### Langkah 4: Inisialisasi Aplikasi
Generate kunci enkripsi aplikasi dan migrasikan struktur database:
```bash
php artisan key:generate
php artisan migrate --seed
npm run build
```
*> **Catatan**: Opsi `--seed` akan mengisi database dengan data pengguna awal (Admin) jika tersedia.*

### Langkah 5: Peluncuran Server
Jalankan server pengembangan lokal:
```bash
php artisan serve
```
Akses sistem melalui browser di alamat: `http://localhost:8000`

---

## 👥 Matriks Peran Pengguna

| Peran | Tanggung Jawab Utama & Akses |
| :--- | :--- |
| **Admin** | **Superuser**. Mengelola seluruh pengguna, konfigurasi wilayah, dan memiliki akses penuh ke semua laporan data. |
| **SSGS** | **Sales Support**. Fokus pada administrasi data pelanggan, input pembayaran, dan validasi kunjungan. |
| **GS** | **Government Service**. Fokus pada eksekusi lapangan, input peluang proyek, dan pencatatan aktivitas pemasaran. |

---

## 📄 Lisensi & Hak Cipta

**Witel Gov Monitoring System** didistribusikan di bawah lisensi **MIT**. Anda bebas menggunakan, memodifikasi, dan mendistribusikan ulang perangkat lunak ini sesuai dengan ketentuan lisensi.

---

<p align="center">
  <small>Dikembangkan oleh Tim Pengembang Witel Gov Monitoring &copy; 2026</small>
</p>
