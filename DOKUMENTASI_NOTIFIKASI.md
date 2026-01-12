# Sistem Notifikasi - Dokumentasi

## Overview

Sistem notifikasi telah berhasil diimplementasikan untuk memberikan informasi real-time kepada peminjam tentang status peminjaman mereka.

## Fitur Notifikasi

### 1. **Notifikasi Peminjaman Disetujui**

-   **Trigger**: Ketika petugas menyetujui peminjaman
-   **Icon**: ✅ Hijau (Check mark)
-   **Pesan**: "Peminjaman {nama_alat} Anda telah disetujui. Silakan ambil alat sesuai jadwal yang ditentukan."

### 2. **Notifikasi Peminjaman Ditolak**

-   **Trigger**: Ketika petugas menolak peminjaman
-   **Icon**: ❌ Merah (X mark)
-   **Pesan**: "Peminjaman {nama_alat} Anda ditolak. Alasan: {alasan}"

### 3. **Notifikasi Pengembalian Diproses**

-   **Trigger**: Ketika petugas memproses pengembalian
-   **Icon**: ✓ Biru (Check circle)
-   **Pesan**: "Pengembalian {nama_alat} telah diproses. [Denda: Rp xxx jika ada]"

## Database Schema

### Tabel: `notifications`

| Field         | Type      | Description                           |
| ------------- | --------- | ------------------------------------- |
| id            | bigint    | Primary key                           |
| user_id       | bigint    | Foreign key ke users                  |
| peminjaman_id | bigint    | Foreign key ke peminjamans (nullable) |
| type          | string    | Tipe notifikasi                       |
| title         | string    | Judul notifikasi                      |
| message       | text      | Isi pesan notifikasi                  |
| is_read       | boolean   | Status sudah dibaca (default: false)  |
| created_at    | timestamp | Waktu dibuat                          |
| updated_at    | timestamp | Waktu diupdate                        |

### Tipe Notifikasi

1. `peminjaman_disetujui` - Peminjaman disetujui
2. `peminjaman_ditolak` - Peminjaman ditolak
3. `pengembalian_diproses` - Pengembalian diproses

## Cara Kerja

### 1. **Ketika Peminjaman Disetujui**

```php
// Di PeminjamanController@approve
Notification::create([
    'user_id' => $peminjaman->user_id,
    'peminjaman_id' => $peminjaman->id,
    'type' => 'peminjaman_disetujui',
    'title' => 'Peminjaman Disetujui',
    'message' => "Peminjaman {$peminjaman->alat->nama_alat} Anda telah disetujui..."
]);
```

### 2. **Ketika Peminjaman Ditolak**

```php
// Di PeminjamanController@reject
Notification::create([
    'user_id' => $peminjaman->user_id,
    'peminjaman_id' => $peminjaman->id,
    'type' => 'peminjaman_ditolak',
    'title' => 'Peminjaman Ditolak',
    'message' => "Peminjaman {$peminjaman->alat->nama_alat} Anda ditolak. Alasan: {$request->reason}"
]);
```

### 3. **Ketika Pengembalian Diproses**

```php
// Di PeminjamanController@processReturn
$dendaMessage = $request->denda > 0
    ? " Denda: Rp " . number_format($request->denda, 0, ',', '.')
    : "";

Notification::create([
    'user_id' => $peminjaman->user_id,
    'peminjaman_id' => $peminjaman->id,
    'type' => 'pengembalian_diproses',
    'title' => 'Pengembalian Diproses',
    'message' => "Pengembalian {$peminjaman->alat->nama_alat} telah diproses.{$dendaMessage}"
]);
```

## Tampilan Notifikasi

### Halaman Notifikasi (`/peminjam/notifications`)

**Fitur:**

-   ✅ List semua notifikasi user
-   ✅ Badge "Baru" untuk notifikasi yang belum dibaca
-   ✅ Background berbeda untuk notifikasi baru (indigo-50)
-   ✅ Border kiri biru untuk notifikasi baru
-   ✅ Icon berbeda untuk setiap tipe notifikasi
-   ✅ Detail peminjaman (alat, jumlah, tanggal)
-   ✅ Timestamp relatif (diffForHumans)
-   ✅ Link ke detail peminjaman
-   ✅ Pagination

### Visual Design

**Notifikasi Belum Dibaca:**

-   Background: `bg-indigo-50`
-   Border: `border-l-4 border-indigo-600`
-   Badge: "Baru" dengan `bg-indigo-600 text-white`

**Notifikasi Sudah Dibaca:**

-   Background: `bg-white`
-   Tidak ada border khusus
-   Tidak ada badge

## Testing

### Skenario 1: Test Notifikasi Disetujui

1. Login sebagai `user@app.com`
2. Ajukan peminjaman alat
3. Logout
4. Login sebagai `petugas@app.com`
5. Buka menu "Verifikasi Peminjaman"
6. Setujui peminjaman
7. Logout
8. Login kembali sebagai `user@app.com`
9. Buka menu "Notifikasi"
10. ✅ **Expected**: Muncul notifikasi "Peminjaman Disetujui" dengan icon hijau

### Skenario 2: Test Notifikasi Ditolak

1. Login sebagai `user@app.com`
2. Ajukan peminjaman alat
3. Logout
4. Login sebagai `petugas@app.com`
5. Buka menu "Verifikasi Peminjaman"
6. Tolak peminjaman dengan alasan
7. Logout
8. Login kembali sebagai `user@app.com`
9. Buka menu "Notifikasi"
10. ✅ **Expected**: Muncul notifikasi "Peminjaman Ditolak" dengan icon merah dan alasan

### Skenario 3: Test Notifikasi Pengembalian

1. Pastikan ada peminjaman yang sudah disetujui
2. Login sebagai `petugas@app.com`
3. Buka menu "Pengembalian"
4. Proses pengembalian (dengan/tanpa denda)
5. Logout
6. Login sebagai `user@app.com`
7. Buka menu "Notifikasi"
8. ✅ **Expected**: Muncul notifikasi "Pengembalian Diproses" dengan icon biru

## Model Relationships

### Notification Model

```php
// Relationship ke User
public function user()
{
    return $this->belongsTo(User::class);
}

// Relationship ke Peminjaman
public function peminjaman()
{
    return $this->belongsTo(Peminjaman::class);
}

// Helper method
public function markAsRead()
{
    $this->update(['is_read' => true]);
}
```

## Future Enhancements

### 1. Mark as Read Functionality

Tambahkan route dan method untuk mark notification as read:

```php
// Route
Route::post('/notifications/{notification}/read', [PeminjamController::class, 'markAsRead'])
    ->name('peminjam.notifications.read');

// Controller
public function markAsRead(Notification $notification)
{
    if ($notification->user_id !== auth()->id()) {
        abort(403);
    }

    $notification->markAsRead();
    return back();
}
```

### 2. Notification Badge Count

Tambahkan counter notifikasi belum dibaca di sidebar:

```php
// Di layout atau sidebar
$unreadCount = Notification::where('user_id', auth()->id())
    ->where('is_read', false)
    ->count();
```

### 3. Real-time Notifications

Implementasi dengan Laravel Echo dan Pusher/Socket.io untuk notifikasi real-time.

### 4. Email Notifications

Kirim email ketika ada notifikasi penting menggunakan Laravel Mail.

## Files Modified/Created

### Created:

1. `database/migrations/2026_01_12_160457_create_notifications_table.php`
2. `app/Models/Notification.php`
3. `resources/views/peminjam/notifications.blade.php` (updated)

### Modified:

1. `app/Http/Controllers/PeminjamanController.php`

    - Added notification creation in `approve()`
    - Added notification creation in `reject()`
    - Added notification creation in `processReturn()`

2. `app/Http/Controllers/PeminjamController.php`
    - Updated `notifications()` to fetch Notification model

## Summary

✅ Sistem notifikasi berhasil diimplementasikan
✅ Notifikasi otomatis dibuat saat status peminjaman berubah
✅ Tampilan notifikasi dengan design yang menarik
✅ Support untuk 3 tipe notifikasi
✅ Pagination untuk notifikasi
✅ Detail peminjaman ditampilkan di notifikasi
