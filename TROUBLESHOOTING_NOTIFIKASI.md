# Troubleshooting - Sistem Notifikasi

## Error: Table 'notifications' doesn't exist

### Penyebab

Error ini biasanya terjadi karena:

1. Cache Laravel yang belum di-refresh
2. Migration belum dijalankan
3. Database connection issue

### Solusi

#### 1. Clear All Cache

```bash
cd /home/fahcreza/peminjama-alat
php artisan optimize:clear
php artisan config:cache
```

#### 2. Verifikasi Tabel Exists

```bash
php artisan tinker --execute="echo \Illuminate\Support\Facades\Schema::hasTable('notifications') ? 'Table exists' : 'Table NOT exists';"
```

**Expected Output:** `Table exists`

#### 3. Cek Struktur Tabel

```bash
php artisan tinker --execute="\$columns = \Illuminate\Support\Facades\DB::select('DESCRIBE notifications'); foreach(\$columns as \$col) { echo \$col->Field . PHP_EOL; }"
```

**Expected Output:**

```
id
user_id
peminjaman_id
type
title
message
is_read
created_at
updated_at
```

#### 4. Test Create Notification

```bash
php artisan tinker --execute="
\$user = \App\Models\User::where('email', 'user@app.com')->first();
\$notification = \App\Models\Notification::create([
    'user_id' => \$user->id,
    'peminjaman_id' => null,
    'type' => 'test',
    'title' => 'Test Notifikasi',
    'message' => 'Test message',
    'is_read' => false
]);
echo 'Success! ID: ' . \$notification->id;
"
```

**Expected Output:** `Success! ID: 1` (atau nomor lain)

## Error: db:seed - Duplicate Entry

### Penyebab

Seeder mencoba membuat user yang sudah ada di database.

### Solusi

#### Opsi 1: Hapus Data Lama (HATI-HATI!)

```bash
php artisan migrate:fresh --seed
```

⚠️ **WARNING**: Ini akan menghapus SEMUA data!

#### Opsi 2: Skip Seeder (Recommended)

Tidak perlu run seeder lagi jika data sudah ada. Cukup:

```bash
php artisan optimize:clear
```

#### Opsi 3: Update Seeder dengan Check

Edit `database/seeders/DatabaseSeeder.php`:

```php
// Ganti User::create() dengan updateOrCreate()
User::updateOrCreate(
    ['email' => 'admin@app.com'],
    [
        'name' => 'Admin Sistem',
        'password' => Hash::make('password'),
        'role' => 'admin',
        'no_telp' => '081234567890',
        'alamat' => 'Ruang Admin Lt. 1'
    ]
);
```

## Verifikasi Sistem Berfungsi

### 1. Cek Jumlah Notifikasi User

```bash
php artisan tinker --execute="
\$user = \App\Models\User::where('email', 'user@app.com')->first();
echo 'User ID: ' . \$user->id . PHP_EOL;
\$count = \App\Models\Notification::where('user_id', \$user->id)->count();
echo 'Jumlah notifikasi: ' . \$count;
"
```

### 2. Lihat Semua Notifikasi User

```bash
php artisan tinker --execute="
\$notifications = \App\Models\Notification::where('user_id', 3)->get();
foreach(\$notifications as \$notif) {
    echo \$notif->title . ' - ' . \$notif->message . PHP_EOL;
}
"
```

### 3. Test Route Notifications

```bash
php artisan route:list | grep notifications
```

**Expected Output:**

```
GET|HEAD  peminjam/notifications  peminjam.notifications › PeminjamController@notifications
```

## Testing End-to-End

### Skenario Lengkap: Test Notifikasi Disetujui

#### Step 1: Buat Peminjaman

```bash
# Login sebagai user@app.com
# Buka /peminjam/browse
# Pilih alat dan ajukan peminjaman
```

#### Step 2: Approve Peminjaman

```bash
# Login sebagai petugas@app.com
# Buka /verifikasi
# Klik "Setujui" pada peminjaman
```

#### Step 3: Cek Notifikasi (Via Tinker)

```bash
php artisan tinker --execute="
\$user = \App\Models\User::where('email', 'user@app.com')->first();
\$latest = \App\Models\Notification::where('user_id', \$user->id)
    ->orderBy('created_at', 'desc')
    ->first();
if (\$latest) {
    echo 'Title: ' . \$latest->title . PHP_EOL;
    echo 'Message: ' . \$latest->message . PHP_EOL;
    echo 'Type: ' . \$latest->type . PHP_EOL;
} else {
    echo 'Tidak ada notifikasi';
}
"
```

#### Step 4: Lihat di Browser

```bash
# Login sebagai user@app.com
# Buka /peminjam/notifications
# Harus muncul notifikasi "Peminjaman Disetujui"
```

## Common Issues & Solutions

### Issue 1: Halaman Notifikasi Blank/Error 500

**Solusi:**

```bash
# Clear cache
php artisan optimize:clear

# Cek error log
tail -f storage/logs/laravel.log
```

### Issue 2: Notifikasi Tidak Muncul Setelah Approve

**Debug:**

```bash
# Cek apakah notifikasi tercreate
php artisan tinker --execute="
\$latest = \App\Models\Notification::orderBy('created_at', 'desc')->first();
echo \$latest ? 'Latest: ' . \$latest->title : 'No notifications';
"
```

**Solusi:**

-   Pastikan `PeminjamanController` sudah di-update
-   Pastikan `use App\Models\Notification;` ada di controller
-   Clear cache: `php artisan optimize:clear`

### Issue 3: Error "Class 'App\Models\Notification' not found"

**Solusi:**

```bash
# Regenerate autoload
composer dump-autoload

# Clear cache
php artisan optimize:clear
```

### Issue 4: Relationship Error (peminjaman.alat)

**Debug:**

```bash
php artisan tinker --execute="
\$notif = \App\Models\Notification::first();
if (\$notif && \$notif->peminjaman) {
    echo 'Peminjaman ID: ' . \$notif->peminjaman->id . PHP_EOL;
    if (\$notif->peminjaman->alat) {
        echo 'Alat: ' . \$notif->peminjaman->alat->nama_alat;
    }
}
"
```

## Quick Fix Commands

### Reset Everything (HATI-HATI!)

```bash
cd /home/fahcreza/peminjama-alat
php artisan migrate:fresh --seed
php artisan optimize:clear
```

### Soft Reset (Recommended)

```bash
cd /home/fahcreza/peminjama-alat
php artisan optimize:clear
php artisan config:cache
composer dump-autoload
```

### Create Test Notification

```bash
php artisan tinker --execute="
\App\Models\Notification::create([
    'user_id' => 3,
    'peminjaman_id' => null,
    'type' => 'test',
    'title' => 'Test Notification',
    'message' => 'This is a test notification',
    'is_read' => false
]);
echo 'Test notification created!';
"
```

## Verification Checklist

-   [ ] Tabel `notifications` exists
-   [ ] Model `Notification.php` exists
-   [ ] Migration ran successfully
-   [ ] Cache cleared
-   [ ] Route `/peminjam/notifications` exists
-   [ ] Controller method `notifications()` updated
-   [ ] View `peminjam/notifications.blade.php` exists
-   [ ] Can create notification via tinker
-   [ ] Can view notifications in browser

## Status Saat Ini

✅ Migration berhasil dijalankan
✅ Tabel `notifications` sudah ada
✅ Struktur tabel sudah benar
✅ Test notification berhasil dibuat
✅ User dapat query notifications

**Sistem sudah siap digunakan!**

Jika masih ada error, jalankan:

```bash
php artisan optimize:clear
```

Kemudian refresh browser dan coba lagi.
