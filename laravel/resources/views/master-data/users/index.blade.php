@extends('layouts.admin')

@section('content')

<div class="flex justify-between items-end mb-8">

    <div>

        <nav class="flex items-center gap-1 text-sm text-gray-500 mb-1">

            <span>Master Data</span>

            <span class="material-symbols-outlined text-sm">
                chevron_right
            </span>

            <span class="text-blue-900 font-semibold">
                Manajemen Pengguna
            </span>

        </nav>

        <h1 class="text-4xl font-bold text-slate-900">
            Manajemen Pengguna
        </h1>

        <p class="text-gray-500 mt-2">
            Kelola akun administrator sistem.
        </p>

    </div>

    <button
        onclick="document.getElementById('userModal').classList.remove('hidden')"
        class="bg-blue-900 text-white px-5 py-3 rounded-xl flex items-center gap-2 hover:bg-blue-800 transition-all">

        <span class="material-symbols-outlined">
            person_add
        </span>

        Tambah Pengguna

    </button>

</div>

{{-- Statistik --}}

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

    <div class="bg-white p-6 rounded-xl border shadow-sm">

        <div class="flex justify-between items-center">

            <div>

                <p class="text-gray-500 text-sm">
                    Total Administrator
                </p>

                <h3 class="text-4xl font-bold mt-2">
                    {{ $totalAdmins }}
                </h3>

            </div>

            <span class="material-symbols-outlined text-blue-900 text-5xl">
                admin_panel_settings
            </span>

        </div>

    </div>

    <div class="bg-white p-6 rounded-xl border shadow-sm">

        <div class="flex justify-between items-center">

            <div>

                <p class="text-gray-500 text-sm">
                    Hak Akses Aktif
                </p>

                <h3 class="text-4xl font-bold mt-2 text-green-600">
                    {{ $activeUsers }}
                </h3>

            </div>

            <span class="material-symbols-outlined text-green-600 text-5xl">
                verified_user
            </span>

        </div>

    </div>

</div>

{{-- Tabel User --}}

<div class="bg-white rounded-xl border shadow-sm overflow-hidden">

    <div class="p-6 border-b">

        <h2 class="text-xl font-bold">
            Daftar Pengguna
        </h2>

    </div>

    <table class="w-full">

        <thead class="bg-gray-50">

            <tr>

                <th class="p-4 text-left">
                    Nama
                </th>

                <th class="p-4 text-left">
                    Email
                </th>

                <th class="p-4 text-left">
                    Role
                </th>

                <th class="p-4 text-center">
                    Status
                </th>

                <th class="p-4 text-center">
                    Aksi
                </th>

            </tr>

        </thead>

        <tbody>

            @forelse($users as $user)

            <tr class="border-t hover:bg-gray-50">

                <td class="p-4">

                    <div class="font-semibold">
                        {{ $user->name }}
                    </div>

                </td>

                <td class="p-4">

                    {{ $user->email }}

                </td>

                <td class="p-4">

                    <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">

                        {{ $user->role }}

                    </span>

                </td>

                <td class="p-4 text-center">

                    @if($user->is_active)

                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs">
                        Aktif
                    </span>

                    @else

                    <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs">
                        Nonaktif
                    </span>

                    @endif

                </td>

                <td class="p-4 text-center">

                    <div class="flex justify-center gap-4">

                        <button
    onclick="document.getElementById('editUser{{ $user->id }}').classList.remove('hidden')"
    class="text-blue-600 hover:text-blue-900">

                            <span class="material-symbols-outlined">
                                edit
                            </span>

                        </button>

                        <form
                            action="{{ route('users.destroy', $user->id) }}"
                            method="POST"
                            onsubmit="return confirm('Hapus pengguna ini?')">

                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="text-red-600 hover:text-red-900">

                                <span class="material-symbols-outlined">
                                    delete
                                </span>

                            </button>

                        </form>

                    </div>

                </td>

            </tr>
            <div id="editUser{{ $user->id }}" class="hidden fixed inset-0 bg-slate-950/40 backdrop-blur-sm flex items-center justify-center z-50 transition-all">
    <div class="bg-white w-full max-w-2xl rounded-2xl shadow-xl border border-gray-100 overflow-hidden transform transition-all m-4">
        
        <div class="flex justify-between items-center p-6 border-b border-gray-100 bg-slate-50">
            <div>
                <h2 class="text-xl font-bold text-slate-900">Edit Akses Pengguna</h2>
                <p class="text-xs text-gray-500 mt-1">Perbarui data atau hak akses dari {{ $user->name }}</p>
            </div>
            <button onclick="document.getElementById('editUser{{ $user->id }}').classList.add('hidden')" 
                    class="text-gray-400 hover:text-slate-700 p-2 hover:bg-gray-200/60 rounded-lg transition-all">
                <span class="material-symbols-outlined block">close</span>
            </button>
        </div>

        <form action="{{ route('users.update', $user->id) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')

            <div class="space-y-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-1.5 text-sm font-semibold text-slate-700">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ $user->name }}" 
                               class="w-full border border-gray-300 rounded-xl p-3 text-slate-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-900/20 focus:border-blue-900 transition-all" required>
                    </div>
                    <div>
                        <label class="block mb-1.5 text-sm font-semibold text-slate-700">Alamat Email</label>
                        <input type="email" name="email" value="{{ $user->email }}" 
                               class="w-full border border-gray-300 rounded-xl p-3 text-slate-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-900/20 focus:border-blue-900 transition-all" required>
                    </div>
                </div>

                <div>
                    <label class="block mb-1 text-sm font-semibold text-slate-700">Password Baru</label>
                    <p class="text-xs text-gray-400 mb-1.5">Kosongkan kolom ini jika tidak ingin mengubah password.</p>
                    <input type="password" name="password" placeholder="••••••••" 
                           class="w-full border border-gray-300 rounded-xl p-3 text-slate-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-900/20 focus:border-blue-900 transition-all">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-1.5 text-sm font-semibold text-slate-700">Hak Akses / Role</label>
                        <select name="role" class="w-full border border-gray-300 rounded-xl p-3 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-900/20 focus:border-blue-900 transition-all bg-white">
                            <option value="Administrator" {{ $user->role == 'Administrator' ? 'selected' : '' }}>Administrator</option>
                            <option value="Petugas" {{ $user->role == 'Petugas' ? 'selected' : '' }}>Petugas</option>
                        </select>
                    </div>
                    <div>
                        <label class="block mb-1.5 text-sm font-semibold text-slate-700">Status Akun</label>
                        <select name="is_active" class="w-full border border-gray-300 rounded-xl p-3 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-900/20 focus:border-blue-900 transition-all bg-white">
                            <option value="1" {{ $user->is_active ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ !$user->is_active ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-8 pt-4 border-t border-gray-100">
                <button type="button" onclick="document.getElementById('editUser{{ $user->id }}').classList.add('hidden')" 
                        class="px-5 py-3 bg-gray-100 hover:bg-gray-200 text-slate-700 font-medium rounded-xl transition-all">
                    Batal
                </button>
                <button type="submit" 
                        class="px-5 py-3 bg-blue-900 hover:bg-blue-800 text-white font-medium rounded-xl flex items-center gap-2 shadow-sm transition-all">
                    <span class="material-symbols-outlined text-xl">save</span>
                    Simpan Perubahan
                </button>
            </div>
        </form>

    </div>
</div>

            @empty

            <tr>

                <td colspan="5"
                    class="p-10 text-center text-gray-500">

                    Belum ada pengguna

                </td>

            </tr>

            @endforelse

        </tbody>

    </table>

</div>

{{-- Modal Tambah User --}}

<div id="userModal" class="hidden fixed inset-0 bg-slate-950/40 backdrop-blur-sm flex items-center justify-center z-50 transition-all">
    <div class="bg-white w-full max-w-2xl rounded-2xl shadow-xl border border-gray-100 overflow-hidden transform transition-all m-4">
        
        <div class="flex justify-between items-center p-6 border-b border-gray-100 bg-slate-50">
            <div>
                <h2 class="text-xl font-bold text-slate-900">Tambah Akun Baru</h2>
                <p class="text-xs text-gray-500 mt-1">Dafrarkan pengguna/administrator sistem baru ke dalam database.</p>
            </div>
            <button onclick="document.getElementById('userModal').classList.add('hidden')" 
                    class="text-gray-400 hover:text-slate-700 p-2 hover:bg-gray-200/60 rounded-lg transition-all">
                <span class="material-symbols-outlined block">close</span>
            </button>
        </div>

        <form action="{{ route('users.store') }}" method="POST" class="p-6">
            @csrf

            <div class="space-y-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-1.5 text-sm font-semibold text-slate-700">Nama Lengkap</label>
                        <input type="text" name="name" placeholder="Contoh: John Doe"
                               class="w-full border border-gray-300 rounded-xl p-3 text-slate-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-900/20 focus:border-blue-900 transition-all" required>
                    </div>
                    <div>
                        <label class="block mb-1.5 text-sm font-semibold text-slate-700">Alamat Email</label>
                        <input type="email" name="email" placeholder="contoh@domain.com"
                               class="w-full border border-gray-300 rounded-xl p-3 text-slate-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-900/20 focus:border-blue-900 transition-all" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-1.5 text-sm font-semibold text-slate-700">Password</label>
                        <input type="password" name="password" placeholder="Minimal 8 karakter"
                               class="w-full border border-gray-300 rounded-xl p-3 text-slate-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-900/20 focus:border-blue-900 transition-all" required>
                    </div>
                    <div>
                        <label class="block mb-1.5 text-sm font-semibold text-slate-700">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" placeholder="Ulangi password"
                               class="w-full border border-gray-300 rounded-xl p-3 text-slate-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-900/20 focus:border-blue-900 transition-all" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-1.5 text-sm font-semibold text-slate-700">Hak Akses / Role</label>
                        <select name="role" class="w-full border border-gray-300 rounded-xl p-3 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-900/20 focus:border-blue-900 transition-all bg-white">
                            <option value="Administrator">Administrator</option>
                            <option value="Petugas">Petugas</option>
                        </select>
                    </div>
                    <div>
                        <label class="block mb-1.5 text-sm font-semibold text-slate-700">Status Awal</label>
                        <select name="is_active" class="w-full border border-gray-300 rounded-xl p-3 text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-900/20 focus:border-blue-900 transition-all bg-white">
                            <option value="1">Aktif</option>
                            <option value="0">Nonaktif</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-8 pt-4 border-t border-gray-100">
                <button type="button" onclick="document.getElementById('userModal').classList.add('hidden')" 
                        class="px-5 py-3 bg-gray-100 hover:bg-gray-200 text-slate-700 font-medium rounded-xl transition-all">
                    Batal
                </button>
                <button type="submit" 
                        class="px-5 py-3 bg-blue-900 hover:bg-blue-800 text-white font-medium rounded-xl flex items-center gap-2 shadow-sm transition-all">
                    <span class="material-symbols-outlined text-xl">person_add</span>
                    Simpan Pengguna
                </button>
            </div>
        </form>

    </div>
</div>

@endsection