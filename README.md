# Equipment Rental System (Sistem Peminjaman Alat)

![Laravel](https://img.shields.io/badge/Laravel-11.x-red)
![PHP](https://img.shields.io/badge/PHP-8.2+-blue)
![License](https://img.shields.io/badge/License-MIT-green)

Sistem manajemen peminjaman alat laboratorium berbasis web menggunakan Laravel 11. Aplikasi ini memungkinkan mahasiswa untuk meminjam alat laboratorium dengan sistem verifikasi dari petugas.

## 🌟 Features

### 👤 Multi-Role System

-   **Admin**: Manajemen user, kategori, dan alat
-   **Petugas**: Verifikasi peminjaman dan pengembalian
-   **Peminjam**: Browse, ajukan peminjaman, dan tracking status

### 🔔 Notification System

-   Notifikasi real-time untuk status peminjaman
-   Notifikasi saat peminjaman disetujui
-   Notifikasi saat peminjaman ditolak (dengan alasan)
-   Notifikasi saat pengembalian diproses (dengan info denda)

### 📦 Equipment Management

-   CRUD alat dan kategori
-   Upload gambar alat
-   Manajemen stok otomatis
-   Filter dan search alat

### 📋 Borrowing System

-   Form peminjaman dengan kalkulasi otomatis
-   Verifikasi oleh petugas
-   Tracking status peminjaman
-   Sistem denda untuk keterlambatan
-   History peminjaman

### 🎨 Modern UI/UX

-   Responsive design
-   Pastel gradient color scheme
-   Smooth animations
-   Clean and intuitive interface

## 🚀 Installation

### Prerequisites

-   PHP >= 8.2
-   Composer
-   MySQL/MariaDB
-   Node.js & NPM

### Steps

1. **Clone Repository**

```bash
git clone https://github.com/Super4zer/equipment_rental.git
cd equipment_rental
```

2. **Install Dependencies**

```bash
composer install
npm install
```

3. **Environment Setup**

```bash
cp .env.example .env
php artisan key:generate
```

4. **Database Configuration**

Edit `.env` file:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=peminjaman_alat
DB_USERNAME=root
DB_PASSWORD=your_password
```

5. **Run Migrations & Seeders**

```bash
php artisan migrate
php artisan db:seed
```

6. **Storage Link**

```bash
php artisan storage:link
```

7. **Build Assets**

```bash
npm run build
# or for development
npm run dev
```

8. **Run Application**

```bash
php artisan serve
```

Access: `http://localhost:8000`

## 👥 Default Accounts

| Role     | Email           | Password |
| -------- | --------------- | -------- |
| Admin    | admin@app.com   | password |
| Petugas  | petugas@app.com | password |
| Peminjam | user@app.com    | password |

## 📱 Usage

### For Borrowers (Peminjam)

1. **Login** with `user@app.com`
2. **Browse** available equipment at `/peminjam/browse`
3. **Search & Filter** equipment by name or category
4. **View Details** by clicking on equipment card
5. **Submit Borrowing Request** with dates and quantity
6. **Track Status** at `/peminjam/my-bookings`
7. **Check Notifications** at `/peminjam/notifications`

### For Staff (Petugas)

1. **Login** with `petugas@app.com`
2. **Verify Requests** at `/verifikasi`
    - Approve or reject borrowing requests
    - Add notes if rejecting
3. **Process Returns** at `/pengembalian`
    - Mark equipment as returned
    - Add late fees if applicable

### For Admin

1. **Login** with `admin@app.com`
2. **Manage Users** at `/users`
3. **Manage Categories** at `/kategori`
4. **Manage Equipment** at `/alat`
    - Add new equipment
    - Update stock
    - Upload images

## 🗂️ Project Structure

```
equipment_rental/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AlatController.php
│   │   │   ├── AuthController.php
│   │   │   ├── DashboardController.php
│   │   │   ├── KategoriController.php
│   │   │   ├── PeminjamController.php
│   │   │   ├── PeminjamanController.php
│   │   │   └── UserController.php
│   │   └── Middleware/
│   │       └── CheckRole.php
│   └── Models/
│       ├── Alat.php
│       ├── Kategori.php
│       ├── Notification.php
│       ├── Peminjaman.php
│       └── User.php
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   └── views/
│       ├── admin/
│       ├── petugas/
│       └── peminjam/
└── routes/
    └── web.php
```

## 🔐 Security Features

-   Authentication & Authorization
-   Role-based Access Control (RBAC)
-   CSRF Protection
-   Password Hashing
-   SQL Injection Prevention
-   XSS Protection

## 📊 Database Schema

### Users

-   id, name, email, password, role, no_telp, alamat

### Kategoris

-   id, nama_kategori

### Alats

-   id, kategori_id, nama_alat, deskripsi, stok, harga_sewa_per_hari, gambar

### Peminjamans

-   id, user_id, alat_id, tanggal_pinjam, tanggal_kembali, tanggal_dikembalikan, status, jumlah, total_biaya, catatan, denda, catatan_petugas

### Notifications

-   id, user_id, peminjaman_id, type, title, message, is_read

## 🛠️ Tech Stack

-   **Backend**: Laravel 11
-   **Frontend**: Blade Templates, Tailwind CSS
-   **Database**: MySQL
-   **Authentication**: Laravel Auth
-   **Build Tool**: Vite

## 📚 Documentation

-   [Notification System Documentation](DOKUMENTASI_NOTIFIKASI.md)
-   [Seeder Documentation](DOKUMENTASI_SEEDER.md)
-   [Peminjam Features Guide](PERBAIKAN_FITUR_PEMINJAM.md)
-   [Testing Guide](TESTING_GUIDE_PEMINJAM.md)
-   [Troubleshooting](TROUBLESHOOTING_NOTIFIKASI.md)

## 🐛 Troubleshooting

### Common Issues

1. **Table not found error**

```bash
php artisan migrate
php artisan optimize:clear
```

2. **Seeder duplicate entry**

```bash
# Seeder is now idempotent, safe to run multiple times
php artisan db:seed
```

3. **Assets not loading**

```bash
npm run build
php artisan storage:link
```

## 🤝 Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📝 License

This project is licensed under the MIT License.

## 👨‍💻 Author

**Super4zer**

-   GitHub: [@Super4zer](https://github.com/Super4zer)

## 🙏 Acknowledgments

-   Laravel Framework
-   Tailwind CSS
-   All contributors

## 📞 Support

For support, email your-email@example.com or open an issue in this repository.

---

Made with ❤️ using Laravel
