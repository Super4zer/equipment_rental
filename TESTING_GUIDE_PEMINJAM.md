# Testing Guide - Fitur Peminjam

## Kredensial Login

### User Peminjam

-   **Email**: `user@app.com`
-   **Password**: `password`
-   **Role**: `peminjam`
-   **Nama**: Mahasiswa Peminjam

## Langkah Testing

### 1. Login

1. Buka browser dan akses aplikasi
2. Klik tombol "Login" atau akses `/login`
3. Masukkan kredensial:
    - Email: `user@app.com`
    - Password: `password`
4. Klik "Login"
5. **Expected**: Otomatis redirect ke halaman Browse (`/peminjam/browse`)

### 2. Test Browse Alat

**URL**: `/peminjam/browse`

✅ **Fitur yang harus berfungsi:**

-   Menampilkan semua alat dalam grid layout
-   Search box untuk mencari alat
-   Filter berdasarkan kategori
-   Checkbox "Hanya tampilkan alat yang tersedia"
-   Tombol "Cari" untuk apply filter
-   Tombol "Reset" untuk clear filter
-   Pagination jika alat lebih dari 12
-   Klik card alat untuk ke detail

**Test Cases:**

1. Cari "laptop" di search box → klik Cari
2. Pilih kategori "Perangkat IT" → klik Cari
3. Centang "Hanya tampilkan alat yang tersedia" → klik Cari
4. Klik "Reset" untuk clear semua filter

### 3. Test Detail Alat

**URL**: `/peminjam/alat/{id}`

✅ **Fitur yang harus berfungsi:**

-   Menampilkan gambar alat (atau placeholder)
-   Nama alat dan kategori
-   Deskripsi lengkap
-   Harga sewa per hari
-   Stok tersedia
-   Status badge (Tersedia/Habis)
-   Tombol "Ajukan Peminjaman" (jika stok > 0)
-   Tombol "Kembali ke Browse"

**Test Cases:**

1. Klik salah satu alat dari browse
2. Verifikasi semua informasi tampil
3. Klik "Ajukan Peminjaman"

### 4. Test Ajukan Peminjaman

**URL**: `/peminjam/peminjaman/create?alat={id}`

✅ **Fitur yang harus berfungsi:**

-   Form dengan field:
    -   Tanggal Pinjam (required, min: today)
    -   Tanggal Kembali (required, min: tanggal pinjam)
    -   Jumlah Unit (required, min: 1, max: stok)
    -   Catatan (optional)
-   Kalkulasi otomatis:
    -   Jumlah hari
    -   Jumlah unit
    -   Estimasi total biaya
-   Tombol "Batal" dan "Ajukan Peminjaman"

**Test Cases:**

1. Isi tanggal pinjam: hari ini
2. Isi tanggal kembali: 3 hari dari sekarang
3. Isi jumlah: 1
4. Verifikasi kalkulasi otomatis benar
5. Isi catatan (optional)
6. Klik "Ajukan Peminjaman"
7. **Expected**: Redirect ke My Bookings dengan pesan sukses

### 5. Test My Bookings

**URL**: `/peminjam/my-bookings`

✅ **Fitur yang harus berfungsi:**

-   Menampilkan semua peminjaman user
-   Card untuk setiap peminjaman dengan:
    -   Gambar alat
    -   Nama alat dan kategori
    -   Status badge (Menunggu/Disetujui/Ditolak/Kembali)
    -   Tanggal pinjam dan kembali
    -   Jumlah unit
    -   Total biaya
    -   Catatan (jika ada)
    -   Waktu dibuat
-   Pagination jika lebih dari 10 peminjaman
-   Pesan "Belum ada peminjaman" jika kosong

**Test Cases:**

1. Verifikasi peminjaman yang baru dibuat muncul
2. Cek status badge warna sesuai status
3. Verifikasi semua informasi benar

### 6. Test Favorites

**URL**: `/peminjam/favorites`

✅ **Fitur yang harus berfungsi:**

-   Menampilkan alat-alat favorit (saat ini: semua alat tersedia)
-   Grid layout sama seperti browse
-   Icon heart di setiap card
-   Klik card untuk ke detail
-   Pagination

**Test Cases:**

1. Akses menu Favorites
2. Verifikasi alat-alat tampil
3. Klik salah satu alat

### 7. Test Notifications

**URL**: `/peminjam/notifications`

✅ **Fitur yang harus berfungsi:**

-   Menampilkan notifikasi berdasarkan peminjaman
-   Timeline layout
-   Status update untuk setiap peminjaman
-   Badge warna sesuai status
-   Informasi lengkap peminjaman

**Test Cases:**

1. Akses menu Notifications
2. Verifikasi notifikasi tampil
3. Cek informasi lengkap

### 8. Test Sidebar Navigation

**Semua halaman peminjam harus memiliki sidebar dengan menu:**

-   ✅ Browse Alat
-   ✅ My Bookings
-   ✅ Favorites
-   ✅ Notifikasi

**Test Cases:**

1. Dari Browse, klik "My Bookings" → harus pindah ke My Bookings
2. Dari My Bookings, klik "Favorites" → harus pindah ke Favorites
3. Dari Favorites, klik "Notifikasi" → harus pindah ke Notifications
4. Dari Notifications, klik "Browse Alat" → harus pindah ke Browse

## Status Peminjaman

| Status      | Warna Badge | Keterangan                  |
| ----------- | ----------- | --------------------------- |
| `menunggu`  | Yellow      | Menunggu verifikasi petugas |
| `disetujui` | Blue        | Disetujui, sedang dipinjam  |
| `ditolak`   | Red         | Ditolak oleh petugas        |
| `kembali`   | Green       | Sudah dikembalikan          |

## Expected Behavior

### Setelah Login sebagai Peminjam:

1. ✅ Otomatis redirect ke `/peminjam/browse`
2. ✅ Sidebar menampilkan 4 menu utama
3. ✅ Semua link di sidebar berfungsi
4. ✅ Bisa search dan filter alat
5. ✅ Bisa lihat detail alat
6. ✅ Bisa ajukan peminjaman
7. ✅ Bisa lihat history peminjaman
8. ✅ Bisa akses favorites dan notifications

### URL Structure:

-   Browse: `/peminjam/browse`
-   Detail: `/peminjam/alat/{id}`
-   Create: `/peminjam/peminjaman/create?alat={id}`
-   Bookings: `/peminjam/my-bookings`
-   Favorites: `/peminjam/favorites`
-   Notifications: `/peminjam/notifications`

## Troubleshooting

### Jika fitur tidak berfungsi:

1. Clear cache: `php artisan optimize:clear`
2. Cek routes: `php artisan route:list | grep peminjam`
3. Cek database: pastikan user ada dengan role `peminjam`
4. Cek browser console untuk error JavaScript
5. Cek Laravel log: `storage/logs/laravel.log`

## Kredensial Lengkap untuk Testing

### Admin

-   Email: `admin@app.com`
-   Password: `password`
-   Role: `admin`

### Petugas

-   Email: `petugas@app.com`
-   Password: `password`
-   Role: `petugas`

### Peminjam

-   Email: `user@app.com`
-   Password: `password`
-   Role: `peminjam`
