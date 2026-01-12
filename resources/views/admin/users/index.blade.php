@extends('layouts.app')

@section('title', 'Kelola User')

@section('sidebar')
    @include('admin.partials.sidebar')
@endsection

@section('content')
    <div class="card p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-slate-800">Daftar User</h2>
            <a href="{{ route('users.create') }}"
                class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-medium text-sm">Tambah
                User</a>
        </div>

        @if (session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-lg mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-lg mb-6">
                {{ session('error') }}
            </div>
        @endif

        <!-- Search and Filter -->
        <form method="GET" action="{{ route('users.index') }}" class="mb-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="md:col-span-2">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari nama, email, atau no. telepon..."
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
                </div>
                <div class="flex gap-2">
                    <select name="role"
                        class="flex-1 px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
                        <option value="">Semua Role</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="petugas" {{ request('role') == 'petugas' ? 'selected' : '' }}>Petugas</option>
                        <option value="peminjam" {{ request('role') == 'peminjam' ? 'selected' : '' }}>Peminjam</option>
                    </select>
                    <button type="submit"
                        class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-medium">
                        Cari
                    </button>
                    @if (request('search') || request('role'))
                        <a href="{{ route('users.index') }}"
                            class="px-4 py-2 bg-slate-100 text-slate-600 rounded-lg hover:bg-slate-200 transition font-medium">
                            Reset
                        </a>
                    @endif
                </div>
            </div>
        </form>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 text-xs uppercase tracking-wider">
                        <th class="p-4 font-semibold">Nama</th>
                        <th class="p-4 font-semibold">Email</th>
                        <th class="p-4 font-semibold">No. Telepon</th>
                        <th class="p-4 font-semibold">Role</th>
                        <th class="p-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($users as $user)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="p-4 text-slate-800 font-medium">{{ $user->name }}</td>
                            <td class="p-4 text-slate-600">{{ $user->email }}</td>
                            <td class="p-4 text-slate-600">{{ $user->no_telp ?? '-' }}</td>
                            <td class="p-4">
                                <span
                                    class="px-2 py-1 text-xs font-semibold rounded-full 
                                    {{ $user->role == 'admin' ? 'bg-purple-100 text-purple-600' : '' }}
                                    {{ $user->role == 'petugas' ? 'bg-blue-100 text-blue-600' : '' }}
                                    {{ $user->role == 'peminjam' ? 'bg-emerald-100 text-emerald-600' : '' }}
                                ">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="p-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('users.show', $user) }}"
                                        class="text-blue-600 hover:text-blue-800 font-medium text-sm">Detail</a>
                                    <a href="{{ route('users.edit', $user) }}"
                                        class="text-indigo-600 hover:text-indigo-800 font-medium text-sm">Edit</a>
                                    <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline"
                                        onsubmit="return confirm('Yakin ingin menghapus user {{ $user->name }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-rose-600 hover:text-rose-800 font-medium text-sm">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-slate-500">
                                Belum ada data user
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($users->hasPages())
            <div class="mt-6">
                {{ $users->links() }}
            </div>
        @endif
    </div>
@endsection
