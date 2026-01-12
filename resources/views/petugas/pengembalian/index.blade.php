@extends('layouts.app')

@section('title', 'Proses Pengembalian')

@section('sidebar')
    @include('petugas.partials.sidebar')
@endsection

@section('content')
    <div class="card p-6">
        <h2 class="text-xl font-bold text-slate-800 mb-6">Daftar Peminjaman Aktif</h2>

        @if ($peminjamans->isEmpty())
            <div class="text-center py-12">
                <div
                    class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-400">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                        </path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-slate-900">Tidak Ada Peminjaman Aktif</h3>
                <p class="text-slate-500">Saat ini tidak ada alat yang sedang dipinjam.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 text-xs uppercase tracking-wider">
                            <th class="p-4 font-semibold">User</th>
                            <th class="p-4 font-semibold">Alat</th>
                            <th class="p-4 font-semibold">Jatuh Tempo</th>
                            <th class="p-4 font-semibold">Status</th>
                            <th class="p-4 font-semibold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($peminjamans as $pinjam)
                            @php
                                $isOverdue = now()->gt($pinjam->tanggal_kembali);
                                $daysOverdue = now()->diffInDays($pinjam->tanggal_kembali);
                                $fineEstimation = $isOverdue ? $daysOverdue * 50000 : 0; // Example fine calculation
                            @endphp
                            <tr class="hover:bg-slate-50 transition">
                                <td class="p-4">
                                    <div class="font-medium text-slate-800">{{ $pinjam->user->name }}</div>
                                    <div class="text-xs text-slate-500">{{ $pinjam->user->email }}</div>
                                </td>
                                <td class="p-4">
                                    <div class="font-medium text-slate-800">{{ $pinjam->alat->nama_alat }}</div>
                                    <div class="text-xs text-slate-500">{{ $pinjam->jumlah }} unit</div>
                                </td>
                                <td class="p-4">
                                    <div class="{{ $isOverdue ? 'text-rose-600 font-bold' : 'text-slate-700' }}">
                                        {{ $pinjam->tanggal_kembali->format('d M Y') }}
                                    </div>
                                    @if ($isOverdue)
                                        <span class="text-xs text-rose-500">Terlambat {{ $daysOverdue }} hari</span>
                                    @endif
                                </td>
                                <td class="p-4">
                                    <span
                                        class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-600">Dipinjam</span>
                                </td>
                                <td class="p-4 text-right">
                                    <button
                                        onclick="document.getElementById('return-modal-{{ $pinjam->id }}').classList.remove('hidden')"
                                        class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition">
                                        Proses Kembali
                                    </button>

                                    <!-- Return Modal -->
                                    <div id="return-modal-{{ $pinjam->id }}"
                                        class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
                                        <div class="bg-white rounded-xl shadow-xl max-w-md w-full p-6 text-left">
                                            <h3 class="text-lg font-bold text-slate-900 mb-4">Proses Pengembalian</h3>
                                            <form action="{{ route('pengembalian.process', $pinjam) }}" method="POST">
                                                @csrf

                                                <div class="mb-4 p-4 bg-slate-50 rounded-lg border border-slate-100">
                                                    <div class="flex justify-between text-sm mb-1">
                                                        <span class="text-slate-500">Alat:</span>
                                                        <span class="font-medium">{{ $pinjam->alat->nama_alat }}</span>
                                                    </div>
                                                    <div class="flex justify-between text-sm">
                                                        <span class="text-slate-500">Estimasi Denda:</span>
                                                        <span class="font-medium text-rose-600">Rp
                                                            {{ number_format($fineEstimation, 0, ',', '.') }}</span>
                                                    </div>
                                                </div>

                                                <div class="mb-4">
                                                    <label class="block text-sm font-medium text-slate-700 mb-2">Denda
                                                        (Rp)</label>
                                                    <input type="number" name="denda" value="{{ $fineEstimation }}"
                                                        class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none">
                                                    <p class="text-xs text-slate-500 mt-1">Sesuaikan jika ada kerusakan atau
                                                        keterlambatan.</p>
                                                </div>

                                                <div class="mb-6">
                                                    <label class="block text-sm font-medium text-slate-700 mb-2">Catatan
                                                        Kondisi</label>
                                                    <textarea name="catatan" rows="2"
                                                        class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none"
                                                        placeholder="Kondisi alat saat dikembalikan..."></textarea>
                                                </div>

                                                <div class="flex justify-end gap-2">
                                                    <button type="button"
                                                        onclick="document.getElementById('return-modal-{{ $pinjam->id }}').classList.add('hidden')"
                                                        class="px-4 py-2 text-slate-600 hover:bg-slate-100 rounded-lg">Batal</button>
                                                    <button type="submit"
                                                        class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Selesai</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
