@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('sidebar')
    @include('admin.partials.sidebar')
@endsection

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Stat Card 1 -->
        <div class="card p-6 flex flex-col justify-between h-32 relative overflow-hidden group">
            <div class="flex justify-between items-start z-10">
                <div>
                    <h3 class="text-slate-500 text-xs font-semibold uppercase tracking-wider">Total User</h3>
                    <p class="text-3xl font-bold text-slate-800 mt-2">{{ \App\Models\User::count() }}</p>
                </div>
                <div class="p-2 bg-blue-50 text-blue-600 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                        </path>
                    </svg>
                </div>
            </div>
            <div
                class="absolute -bottom-4 -right-4 text-blue-50 transform rotate-12 group-hover:scale-110 transition-transform duration-300">
                <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                    </path>
                </svg>
            </div>
        </div>

        <!-- Stat Card 2 -->
        <div class="card p-6 flex flex-col justify-between h-32 relative overflow-hidden group">
            <div class="flex justify-between items-start z-10">
                <div>
                    <h3 class="text-slate-500 text-xs font-semibold uppercase tracking-wider">Total Alat</h3>
                    <p class="text-3xl font-bold text-slate-800 mt-2">{{ \App\Models\Alat::count() }}</p>
                </div>
                <div class="p-2 bg-emerald-50 text-emerald-600 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                        </path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Stat Card 3 -->
        <div class="card p-6 flex flex-col justify-between h-32 relative overflow-hidden group">
            <div class="flex justify-between items-start z-10">
                <div>
                    <h3 class="text-slate-500 text-xs font-semibold uppercase tracking-wider">Peminjaman</h3>
                    <p class="text-3xl font-bold text-slate-800 mt-2">{{ \App\Models\Peminjaman::count() }}</p>
                </div>
                <div class="p-2 bg-purple-50 text-purple-600 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                        </path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Admin Guide Panel -->
    <div class="card p-8 border-l-4 border-indigo-500">
        <h3 class="text-xl font-bold mb-2 text-slate-800">Panduan Admin Sistem</h3>
        <p class="text-slate-600 leading-relaxed max-w-3xl">
            Selamat datang di panel administrasi. Gunakan menu di sidebar sebelah kiri untuk mengelola data master (User,
            Kategori, Alat) dan memantau aktivitas peminjaman.
            Pastikan data alat selalu diperbarui untuk akurasi laporan inventaris.
        </p>
        <div class="mt-6 flex gap-3">
            <button
                class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition">Lihat
                Laporan</button>
            <button
                class="px-4 py-2 bg-white border border-slate-300 text-slate-700 rounded-lg text-sm font-medium hover:bg-slate-50 transition">Pengaturan</button>
        </div>
    </div>
@endsection
