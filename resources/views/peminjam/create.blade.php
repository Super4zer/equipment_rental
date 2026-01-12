@extends('layouts.app')

@section('title', 'Ajukan Peminjaman')

@section('sidebar')
    @include('peminjam.partials.sidebar')
@endsection

@section('content')
    <div class="mb-6">
        <a href="{{ route('peminjam.alat.show', $alat) }}"
            class="inline-flex items-center text-indigo-600 hover:text-indigo-700 font-medium">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Kembali ke Detail Alat
        </a>
    </div>

    <div class="max-w-3xl mx-auto">
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-slate-800 mb-2">Ajukan Peminjaman</h2>
            <p class="text-slate-600">Isi form berikut untuk mengajukan peminjaman alat</p>
        </div>

        @if (session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card p-6 mb-6">
            <div class="flex gap-4">
                <div class="w-24 h-24 bg-slate-100 rounded-lg overflow-hidden flex-shrink-0">
                    @if ($alat->gambar)
                        <img src="{{ asset('storage/' . $alat->gambar) }}" alt="{{ $alat->nama_alat }}"
                            class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-slate-300">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                    @endif
                </div>
                <div class="flex-1">
                    <p class="text-xs text-indigo-600 font-semibold mb-1 uppercase">{{ $alat->kategori->nama_kategori }}
                    </p>
                    <h3 class="text-xl font-bold text-slate-800 mb-1">{{ $alat->nama_alat }}</h3>
                    <p class="text-sm text-slate-600">Stok tersedia: <span
                            class="font-semibold text-emerald-600">{{ $alat->stok }} unit</span></p>
                    <p class="text-sm text-slate-600">Harga: <span class="font-semibold text-indigo-600">Rp
                            {{ number_format($alat->harga_sewa_per_hari, 0, ',', '.') }}/hari</span></p>
                </div>
            </div>
        </div>

        <form action="{{ route('peminjaman.store') }}" method="POST" class="card p-6" id="peminjamanForm">
            @csrf
            <input type="hidden" name="alat_id" value="{{ $alat->id }}">

            <div class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="tanggal_pinjam" class="block text-sm font-semibold text-slate-700 mb-2">
                            Tanggal Pinjam <span class="text-red-500">*</span>
                        </label>
                        <input type="date" id="tanggal_pinjam" name="tanggal_pinjam" required
                            value="{{ old('tanggal_pinjam', date('Y-m-d')) }}" min="{{ date('Y-m-d') }}"
                            class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
                    </div>

                    <div>
                        <label for="tanggal_kembali" class="block text-sm font-semibold text-slate-700 mb-2">
                            Tanggal Kembali <span class="text-red-500">*</span>
                        </label>
                        <input type="date" id="tanggal_kembali" name="tanggal_kembali" required
                            value="{{ old('tanggal_kembali') }}" min="{{ date('Y-m-d') }}"
                            class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
                    </div>
                </div>

                <div>
                    <label for="jumlah" class="block text-sm font-semibold text-slate-700 mb-2">
                        Jumlah Unit <span class="text-red-500">*</span>
                    </label>
                    <input type="number" id="jumlah" name="jumlah" required min="1" max="{{ $alat->stok }}"
                        value="{{ old('jumlah', 1) }}"
                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
                    <p class="text-xs text-slate-500 mt-1">Maksimal {{ $alat->stok }} unit</p>
                </div>

                <div>
                    <label for="catatan" class="block text-sm font-semibold text-slate-700 mb-2">
                        Catatan (Opsional)
                    </label>
                    <textarea id="catatan" name="catatan" rows="4"
                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none"
                        placeholder="Tambahkan catatan jika diperlukan...">{{ old('catatan') }}</textarea>
                </div>

                <div class="card p-4 bg-slate-50">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm text-slate-600">Harga per hari:</span>
                        <span class="font-semibold text-slate-800">Rp
                            {{ number_format($alat->harga_sewa_per_hari, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm text-slate-600">Jumlah hari:</span>
                        <span class="font-semibold text-slate-800" id="jumlahHari">-</span>
                    </div>
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm text-slate-600">Jumlah unit:</span>
                        <span class="font-semibold text-slate-800" id="jumlahUnit">1</span>
                    </div>
                    <div class="border-t border-slate-200 pt-2 mt-2">
                        <div class="flex justify-between items-center">
                            <span class="font-bold text-slate-800">Estimasi Total:</span>
                            <span class="font-bold text-2xl text-indigo-600" id="totalBiaya">Rp 0</span>
                        </div>
                    </div>
                </div>

                <div class="flex gap-4">
                    <a href="{{ route('peminjam.alat.show', $alat) }}"
                        class="flex-1 px-6 py-3 bg-slate-100 text-slate-700 text-center rounded-lg hover:bg-slate-200 transition font-medium">
                        Batal
                    </a>
                    <button type="submit"
                        class="flex-1 px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-bold">
                        Ajukan Peminjaman
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        const hargaPerHari = {{ $alat->harga_sewa_per_hari }};
        const tanggalPinjamInput = document.getElementById('tanggal_pinjam');
        const tanggalKembaliInput = document.getElementById('tanggal_kembali');
        const jumlahInput = document.getElementById('jumlah');
        const jumlahHariSpan = document.getElementById('jumlahHari');
        const jumlahUnitSpan = document.getElementById('jumlahUnit');
        const totalBiayaSpan = document.getElementById('totalBiaya');

        function hitungTotal() {
            const tanggalPinjam = new Date(tanggalPinjamInput.value);
            const tanggalKembali = new Date(tanggalKembaliInput.value);
            const jumlah = parseInt(jumlahInput.value) || 1;

            if (tanggalPinjam && tanggalKembali && tanggalKembali >= tanggalPinjam) {
                const diffTime = Math.abs(tanggalKembali - tanggalPinjam);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1; // +1 untuk menghitung hari pertama

                const total = hargaPerHari * diffDays * jumlah;

                jumlahHariSpan.textContent = diffDays + ' hari';
                jumlahUnitSpan.textContent = jumlah + ' unit';
                totalBiayaSpan.textContent = 'Rp ' + total.toLocaleString('id-ID');
            } else {
                jumlahHariSpan.textContent = '-';
                totalBiayaSpan.textContent = 'Rp 0';
            }
        }

        tanggalPinjamInput.addEventListener('change', function() {
            // Set minimum tanggal kembali
            tanggalKembaliInput.min = this.value;
            if (tanggalKembaliInput.value && tanggalKembaliInput.value < this.value) {
                tanggalKembaliInput.value = this.value;
            }
            hitungTotal();
        });

        tanggalKembaliInput.addEventListener('change', hitungTotal);
        jumlahInput.addEventListener('input', hitungTotal);

        // Initial calculation
        hitungTotal();
    </script>
@endsection
