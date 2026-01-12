# Database Seeder - Dokumentasi

## Perubahan Seeder

Seeder telah diupdate untuk menghindari error duplicate entry ketika dijalankan berkali-kali.

### Sebelum (Error Prone)

```php
// Akan error jika data sudah ada
User::create([
    'name' => 'Admin Sistem',
    'email' => 'admin@app.com',
    'password' => Hash::make('password'),
    'role' => 'admin',
    // ...
]);
```

**Error yang terjadi:**

```
SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry 'admin@app.com' for key 'users.users_email_unique'
```

### Sesudah (Idempotent)

```php
// Tidak akan error, akan update jika sudah ada
User::updateOrCreate(
    ['email' => 'admin@app.com'], // Cari berdasarkan email
    [
        'name' => 'Admin Sistem',
        'password' => Hash::make('password'),
        'role' => 'admin',
        // ...
    ]
);
```

## Method yang Digunakan

### 1. `updateOrCreate()`

Digunakan untuk **Users** karena kita ingin update data jika sudah ada.

**Cara kerja:**

-   Cari record berdasarkan kondisi pertama (email)
-   Jika ditemukan: **UPDATE** dengan data baru
-   Jika tidak ditemukan: **CREATE** record baru

**Contoh:**

```php
User::updateOrCreate(
    ['email' => 'user@app.com'],  // Kondisi pencarian
    [                               // Data untuk create/update
        'name' => 'Mahasiswa Peminjam',
        'password' => Hash::make('password'),
        'role' => 'peminjam',
        // ...
    ]
);
```

### 2. `firstOrCreate()`

Digunakan untuk **Kategori** dan **Alat** karena kita tidak ingin update data yang sudah ada.

**Cara kerja:**

-   Cari record berdasarkan kondisi pertama
-   Jika ditemukan: **RETURN** record yang ada (tidak update)
-   Jika tidak ditemukan: **CREATE** record baru

**Contoh:**

```php
// Kategori
$katIT = Kategori::firstOrCreate(['nama_kategori' => 'Perangkat IT']);

// Alat
Alat::firstOrCreate(
    ['nama_alat' => 'Laptop ASUS ROG'],  // Kondisi pencarian
    [                                      // Data untuk create (jika belum ada)
        'kategori_id' => $katIT->id,
        'deskripsi' => 'Laptop gaming...',
        'stok' => 5,
        // ...
    ]
);
```

## Keuntungan

### ✅ Idempotent

Seeder bisa dijalankan berkali-kali tanpa error:

```bash
php artisan db:seed  # OK
php artisan db:seed  # OK (tidak error)
php artisan db:seed  # OK (tidak error)
```

### ✅ Safe untuk Development

Tidak perlu reset database setiap kali run seeder:

```bash
# Tidak perlu ini lagi (yang akan hapus semua data):
php artisan migrate:fresh --seed

# Cukup ini:
php artisan db:seed
```

### ✅ Konsisten

Data yang sama akan selalu ada dengan nilai yang sama.

## Cara Menggunakan

### Run Seeder

```bash
cd /home/fahcreza/peminjama-alat
php artisan db:seed
```

**Output yang diharapkan:**

```
INFO  Seeding database.
```

### Run Seeder untuk Class Tertentu

```bash
php artisan db:seed --class=DatabaseSeeder
```

### Reset dan Seed (HATI-HATI!)

```bash
# Ini akan HAPUS semua data dan run migration + seeder dari awal
php artisan migrate:fresh --seed
```

## Data yang Di-seed

### Users (3 users)

| Email           | Password | Role     | Nama               |
| --------------- | -------- | -------- | ------------------ |
| admin@app.com   | password | admin    | Admin Sistem       |
| petugas@app.com | password | petugas  | Petugas Logistik   |
| user@app.com    | password | peminjam | Mahasiswa Peminjam |

### Kategori (4 kategori)

1. Elektronik
2. Perangkat IT
3. Audio Visual
4. Fotografi

### Alat (5 alat)

1. **Laptop ASUS ROG** (Perangkat IT) - Rp 150,000/hari - Stok: 5
2. **Proyektor Epson EB-X450** (Audio Visual) - Rp 100,000/hari - Stok: 3
3. **Kamera DSLR Canon 80D** (Fotografi) - Rp 200,000/hari - Stok: 4
4. **Tripod Manfrotto** (Fotografi) - Rp 50,000/hari - Stok: 10
5. **Speaker Portable JBL** (Elektronik) - Rp 75,000/hari - Stok: 2

## Troubleshooting

### Error: "Class 'Database\Seeders\User' not found"

**Solusi:**
Pastikan import model di bagian atas seeder:

```php
use App\Models\User;
use App\Models\Kategori;
use App\Models\Alat;
use Illuminate\Support\Facades\Hash;
```

### Seeder Tidak Update Data

Jika menggunakan `firstOrCreate()`, data yang sudah ada **tidak akan diupdate**.

**Solusi:**

-   Gunakan `updateOrCreate()` jika ingin update
-   Atau hapus data manual dulu, baru run seeder

### Ingin Reset Semua Data

```bash
# HATI-HATI: Ini akan hapus semua data!
php artisan migrate:fresh --seed
```

## Best Practices

### 1. Gunakan `updateOrCreate` untuk Data Master

Data yang mungkin berubah (seperti user info):

```php
User::updateOrCreate(['email' => '...'], [...]);
```

### 2. Gunakan `firstOrCreate` untuk Data Referensi

Data yang tidak berubah (seperti kategori):

```php
Kategori::firstOrCreate(['nama_kategori' => '...']);
```

### 3. Gunakan Transaction untuk Konsistensi

```php
DB::transaction(function () {
    // Seed users
    // Seed kategori
    // Seed alat
});
```

### 4. Tambahkan Output untuk Debugging

```php
$user = User::updateOrCreate(...);
$this->command->info("Created/Updated user: {$user->email}");
```

## Summary

✅ Seeder sekarang **idempotent** (bisa dijalankan berkali-kali)
✅ Tidak ada error duplicate entry
✅ Menggunakan `updateOrCreate()` untuk users
✅ Menggunakan `firstOrCreate()` untuk kategori dan alat
✅ Aman untuk development dan testing

## File yang Dimodifikasi

-   `database/seeders/DatabaseSeeder.php`

## Testing

```bash
# Test 1: Run seeder pertama kali
php artisan db:seed
# Expected: Success

# Test 2: Run seeder kedua kali
php artisan db:seed
# Expected: Success (tidak error)

# Test 3: Cek data
php artisan tinker --execute="
echo 'Users: ' . \App\Models\User::count() . PHP_EOL;
echo 'Kategori: ' . \App\Models\Kategori::count() . PHP_EOL;
echo 'Alat: ' . \App\Models\Alat::count() . PHP_EOL;
"
# Expected:
# Users: 3
# Kategori: 4
# Alat: 5
```
