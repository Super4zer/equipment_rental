@extends('layouts.app')

@section('title', 'Edit Alat')

@section('sidebar')
    @include('admin.partials.sidebar')
@endsection

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="card p-6">
            <h2 class="text-xl font-bold text-slate-800 mb-6">Edit Alat</h2>

            <form action="{{ route('alat.update', $alat) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Nama Alat</label>
                    <input type="text" name="nama_alat" value="{{ $alat->nama_alat }}"
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition"
                        required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Kategori</label>
                    <select name="kategori_id"
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition"
                        required>
                        <option value="">Pilih Kategori</option>
                        @foreach ($kategoris as $cat)
                            <option value="{{ $cat->id }}" {{ $alat->kategori_id == $cat->id ? 'selected' : '' }}>
                                {{ $cat->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Stok</label>
                        <input type="number" name="stok" value="{{ $alat->stok }}"
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition"
                            min="0" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Harga Sewa / Hari (Rp)</label>
                        <input type="number" name="harga_sewa_per_hari" value="{{ $alat->harga_sewa_per_hari }}"
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition"
                            min="0" required>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">URL Gambar (Opsional)</label>
                    <input type="url" name="gambar" value="{{ $alat->gambar }}"
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition"
                        placeholder="https://example.com/image.jpg">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Deskripsi</label>
                    <textarea name="deskripsi" rows="3"
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">{{ $alat->deskripsi }}</textarea>
                </div>

                <div class="flex justify-end gap-3 pt-4">
                    <a href="{{ route('alat.index') }}"
                        class="px-4 py-2 bg-slate-100 text-slate-600 rounded-lg hover:bg-slate-200 transition font-medium">Batal</a>
                    <button type="submit"
                        class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-medium">Update</button>
                </div>
            </form>
        </div>
    </div>
@endsection
