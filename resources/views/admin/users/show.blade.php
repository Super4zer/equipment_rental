@extends('layouts.app')

@section('title', 'Detail User')

@section('sidebar')
    @include('admin.partials.sidebar')
@endsection

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="card p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-slate-800">Detail User</h2>
                <a href="{{ route('users.index') }}"
                    class="px-4 py-2 bg-slate-100 text-slate-600 rounded-lg hover:bg-slate-200 transition font-medium text-sm">Kembali</a>
            </div>

            <div class="space-y-6">
                <!-- Profile Header -->
                <div class="flex items-center gap-4 pb-6 border-b border-slate-200">
                    <div
                        class="w-20 h-20 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white text-2xl font-bold">
                        {{ strtoupper(substr($user->name, 0, 2)) }}
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-slate-800">{{ $user->name }}</h3>
                        <span
                            class="inline-block mt-1 px-3 py-1 text-xs font-semibold rounded-full 
                            {{ $user->role == 'admin' ? 'bg-purple-100 text-purple-600' : '' }}
                            {{ $user->role == 'petugas' ? 'bg-blue-100 text-blue-600' : '' }}
                            {{ $user->role == 'peminjam' ? 'bg-emerald-100 text-emerald-600' : '' }}
                        ">
                            {{ ucfirst($user->role) }}
                        </span>
                    </div>
                </div>

                <!-- User Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-500 mb-1">Email</label>
                        <p class="text-slate-800 font-medium">{{ $user->email }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-500 mb-1">No. Telepon</label>
                        <p class="text-slate-800 font-medium">{{ $user->no_telp ?? '-' }}</p>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-500 mb-1">Alamat</label>
                        <p class="text-slate-800 font-medium">{{ $user->alamat ?? '-' }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-500 mb-1">Terdaftar Sejak</label>
                        <p class="text-slate-800 font-medium">{{ $user->created_at->format('d M Y, H:i') }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-500 mb-1">Terakhir Diupdate</label>
                        <p class="text-slate-800 font-medium">{{ $user->updated_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>

                <!-- Statistics (if user is peminjam) -->
                @if ($user->role === 'peminjam')
                    <div class="pt-6 border-t border-slate-200">
                        <h4 class="text-lg font-bold text-slate-800 mb-4">Statistik Peminjaman</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-blue-50 rounded-lg p-4">
                                <p class="text-sm text-blue-600 font-medium">Total Peminjaman</p>
                                <p class="text-2xl font-bold text-blue-700 mt-1">{{ $user->peminjamans->count() }}</p>
                            </div>
                            <div class="bg-emerald-50 rounded-lg p-4">
                                <p class="text-sm text-emerald-600 font-medium">Sedang Dipinjam</p>
                                <p class="text-2xl font-bold text-emerald-700 mt-1">
                                    {{ $user->peminjamans->where('status', 'dipinjam')->count() }}</p>
                            </div>
                            <div class="bg-purple-50 rounded-lg p-4">
                                <p class="text-sm text-purple-600 font-medium">Sudah Dikembalikan</p>
                                <p class="text-2xl font-bold text-purple-700 mt-1">
                                    {{ $user->peminjamans->where('status', 'dikembalikan')->count() }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Actions -->
                <div class="flex justify-end gap-3 pt-6 border-t border-slate-200">
                    <a href="{{ route('users.edit', $user) }}"
                        class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-medium">
                        Edit User
                    </a>
                    @if ($user->id !== auth()->id())
                        <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline"
                            onsubmit="return confirm('Yakin ingin menghapus user {{ $user->name }}?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="px-6 py-2 bg-rose-600 text-white rounded-lg hover:bg-rose-700 transition font-medium">
                                Hapus User
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
