<?php

namespace Database\Seeders;

use App\Models\Alat;
use App\Models\Kategori;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Buat User
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

        User::updateOrCreate(
            ['email' => 'petugas@app.com'],
            [
                'name' => 'Petugas Logistik',
                'password' => Hash::make('password'),
                'role' => 'petugas',
                'no_telp' => '081234567891',
                'alamat' => 'Gudang Utama'
            ]
        );

        $peminjam = User::updateOrCreate(
            ['email' => 'user@app.com'],
            [
                'name' => 'Mahasiswa Peminjam',
                'password' => Hash::make('password'),
                'role' => 'peminjam',
                'no_telp' => '081234567892',
                'alamat' => 'Asrama Putra'
            ]
        );

        // Buat Kategori
        $katElektronik = Kategori::firstOrCreate(['nama_kategori' => 'Elektronik']);
        $katIT = Kategori::firstOrCreate(['nama_kategori' => 'Perangkat IT']);
        $katAudio = Kategori::firstOrCreate(['nama_kategori' => 'Audio Visual']);
        $katFoto = Kategori::firstOrCreate(['nama_kategori' => 'Fotografi']);

        // Buat Alat
        Alat::firstOrCreate(
            ['nama_alat' => 'Laptop ASUS ROG'],
            [
                'kategori_id' => $katIT->id,
                'deskripsi' => 'Laptop gaming high-end untuk keperluan multimedia berat.',
                'stok' => 5,
                'harga_sewa_per_hari' => 150000,
                'gambar' => null
            ]
        );

        Alat::firstOrCreate(
            ['nama_alat' => 'Proyektor Epson EB-X450'],
            [
                'kategori_id' => $katAudio->id,
                'deskripsi' => 'Proyektor 3600 lumens, cocok untuk presentasi aula.',
                'stok' => 3,
                'harga_sewa_per_hari' => 100000,
                'gambar' => null
            ]
        );

        Alat::firstOrCreate(
            ['nama_alat' => 'Kamera DSLR Canon 80D'],
            [
                'kategori_id' => $katFoto->id,
                'deskripsi' => 'Kamera semi-pro, lensa kit 18-55mm.',
                'stok' => 4,
                'harga_sewa_per_hari' => 200000,
                'gambar' => null
            ]
        );
        
        Alat::firstOrCreate(
            ['nama_alat' => 'Tripod Manfrotto'],
            [
                'kategori_id' => $katFoto->id,
                'deskripsi' => 'Tripod kokoh untuk video.',
                'stok' => 10,
                'harga_sewa_per_hari' => 50000,
                'gambar' => null
            ]
        );
        
        Alat::firstOrCreate(
            ['nama_alat' => 'Speaker Portable JBL'],
            [
                'kategori_id' => $katElektronik->id,
                'deskripsi' => 'Speaker bluetooth besar dengan mic wireless.',
                'stok' => 2,
                'harga_sewa_per_hari' => 75000,
                'gambar' => null
            ]
        );
    }
}
