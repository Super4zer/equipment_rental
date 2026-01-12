@extends('layouts.app')

@section('title', 'Petugas Logistik')

@section('sidebar')
    @include('petugas.partials.sidebar')
@endsection

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Stat Card -->
        <div class="card p-6 flex flex-col justify-between h-32 relative overflow-hidden group">
            <div class="flex justify-between items-start z-10">
                <div>
                    <h3 class="text-slate-500 text-xs font-semibold uppercase tracking-wider">Menunggu Verifikasi</h3>
                    <p class="text-3xl font-bold text-slate-800 mt-2">
                        {{ \App\Models\Peminjaman::where('status', 'menunggu')->count() }}
                    </p>
                </div>
                <div class="p-2 bg-yellow-50 text-yellow-600 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <div
                class="absolute -bottom-4 -right-4 text-yellow-50 transform rotate-12 group-hover:scale-110 transition-transform duration-300">
                <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Task List -->
    <div class="card">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-lg font-bold text-slate-800">Tugas Hari Ini</h3>
            <span class="text-xs font-medium px-2 py-1 bg-slate-100 text-slate-500 rounded">Prioritas</span>
        </div>
        <div class="p-6">
            <div class="flex items-start gap-4">
                <div
                    class="w-8 h-8 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0 mt-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <h4 class="font-semibold text-slate-800">Cek Permintaan Peminjaman</h4>
                    <p class="text-slate-500 text-sm mt-1">Silakan cek menu Verifikasi Pinjam untuk memproses permintaan
                        peminjaman alat yang masuk hari ini.</p>
                    <button class="mt-3 text-sm text-indigo-600 font-medium hover:text-indigo-800 flex items-center gap-1">
                        Buka Verifikasi
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
