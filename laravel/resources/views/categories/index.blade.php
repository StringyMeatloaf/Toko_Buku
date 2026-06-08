@extends('layouts.admin')

@section('content')

<div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8">
    <div>
        <nav class="flex items-center gap-1 text-sm text-gray-500 mb-1">
            <span>Master Data</span>
            <span class="material-symbols-outlined text-sm">chevron_right</span>
            <span class="text-blue-900 font-semibold">Kategori Buku</span>
        </nav>
        <h1 class="text-4xl font-bold text-slate-900">Kategori Buku</h1>
        <p class="text-gray-500 mt-2">Kelola pengelompokan pustaka berdasarkan genre atau topik.</p>
    </div>
</div>

@if(session('success'))
<div class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 p-4 rounded-xl mb-6">
    <span class="material-symbols-outlined">check_circle</span>
    <p class="font-medium">{{ session('success') }}</p>
</div>
@endif

<div class="grid grid-cols-1 xl:grid-cols-3 gap-8">

    <div class="xl:col-span-1">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 sticky top-8">
            <div class="flex items-center gap-3 mb-6">
                <span class="material-symbols-outlined p-2 bg-blue-50 text-blue-900 rounded-lg">category</span>
                <h2 class="text-xl font-bold text-slate-800">Tambah Kategori</h2>
            </div>

            <form action="{{ route('categories.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Kategori</label>
                    <input type="text" name="category_name"
                        class="w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 p-3"
                        placeholder="Contoh: Fiksi, Teknologi..." required>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Deskripsi</label>
                    <textarea name="description" rows="3"
                        class="w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 p-3"
                        placeholder="Penjelasan singkat kategori..."></textarea>
                </div>

                <button type="submit"
                    class="w-full bg-blue-900 text-white font-bold py-3 rounded-xl hover:bg-blue-800 transition-all flex items-center justify-center gap-2 shadow-lg shadow-blue-900/20">
                    <span class="material-symbols-outlined text-sm">save</span>
                    Simpan Kategori
                </button>
            </form>
        </div>
    </div>

    <div class="xl:col-span-2">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-5 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-bold text-slate-800">Daftar Kategori Terdaftar</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-slate-500 border-b border-slate-100">
                            <th class="p-4 text-left font-semibold">No</th>
                            <th class="p-4 text-left font-semibold">Informasi Kategori</th>
                            <th class="p-4 text-center font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($categories as $category)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="p-4 text-slate-500 font-medium">#{{ $loop->iteration }}</td>
                            <td class="p-4">
                                <div class="font-bold text-slate-900 text-base">{{ $category->category_name }}</div>
                                <div class="text-slate-500 italic">{{ $category->description ?? 'Tidak ada deskripsi' }}</div>
                            </td>
                            <td class="p-4">
                                <div class="flex items-center justify-center gap-2"
                                    x-data="{ editing: false, showingDetail: false }">

                                    <button @click="showingDetail = true"
                                        class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">

                                        <span class="material-symbols-outlined">
                                            visibility
                                        </span>

                                    </button>
                                    <button @click="editing = true" class="p-2 text-amber-600 hover:bg-amber-50 rounded-lg transition-colors">
                                        <span class="material-symbols-outlined">edit</span>
                                    </button>

                                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                            <span class="material-symbols-outlined">delete</span>
                                        </button>
                                    </form>
                                    {{-- MODAL DETAIL --}}
                                    <template x-if="showingDetail">

                                        <div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4">

                                            <div class="bg-white rounded-2xl w-full max-w-xl shadow-2xl overflow-hidden">

                                                {{-- Header --}}
                                                <div class="flex justify-between items-center p-6 border-b bg-slate-50">

                                                    <h2 class="text-xl font-bold text-slate-900">
                                                        Detail Kategori
                                                    </h2>

                                                    <button type="button"
                                                        @click="showingDetail = false"
                                                        class="text-gray-400 hover:text-slate-700">

                                                        <span class="material-symbols-outlined">
                                                            close
                                                        </span>

                                                    </button>

                                                </div>

                                                {{-- Body --}}
                                                <div class="p-6">

                                                    <div class="flex flex-col items-center mb-6">

                                                        <div class="w-24 h-24 rounded-2xl bg-blue-100 flex items-center justify-center mb-4">

                                                            <span class="material-symbols-outlined text-5xl text-blue-900">
                                                                category
                                                            </span>

                                                        </div>

                                                        <h3 class="text-2xl font-bold text-slate-900">
                                                            {{ $category->category_name }}
                                                        </h3>

                                                    </div>

                                                    {{-- Statistik --}}
                                                    <div class="grid grid-cols-2 gap-4 mb-6">

                                                        <div class="bg-slate-50 border rounded-xl p-4">

                                                            <p class="text-xs uppercase text-gray-400 font-bold">
                                                                Jumlah Buku
                                                            </p>

                                                            <p class="text-3xl font-bold text-blue-900 mt-2">
                                                                {{ $category->books->count() }}
                                                            </p>

                                                        </div>

                                                        <div class="bg-slate-50 border rounded-xl p-4">

                                                            <p class="text-xs uppercase text-gray-400 font-bold">
                                                                Total Stok
                                                            </p>

                                                            <p class="text-3xl font-bold text-green-700 mt-2">
                                                                {{ $category->books->sum('stock') }}
                                                            </p>

                                                        </div>

                                                    </div>

                                                    {{-- Status --}}
                                                    <div class="mb-6">

                                                        <p class="text-xs uppercase text-gray-400 font-bold mb-2">
                                                            Status
                                                        </p>

                                                        @if($category->books->count() > 0)

                                                        <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-bold">
                                                            Aktif Digunakan
                                                        </span>

                                                        @else

                                                        <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-bold">
                                                            Belum Digunakan
                                                        </span>

                                                        @endif

                                                    </div>

                                                    {{-- Deskripsi --}}
                                                    <div class="mb-6">

                                                        <p class="text-xs uppercase text-gray-400 font-bold mb-2">
                                                            Deskripsi
                                                        </p>

                                                        <p class="text-slate-600 italic">
                                                            {{ $category->description ?? 'Tidak ada deskripsi kategori.' }}
                                                        </p>

                                                    </div>

                                                    {{-- Dibuat --}}
                                                    <div>

                                                        <p class="text-xs uppercase text-gray-400 font-bold mb-2">
                                                            Dibuat Pada
                                                        </p>

                                                        <p class="text-slate-700">
                                                            {{ $category->created_at->format('d F Y') }}
                                                        </p>

                                                    </div>

                                                </div>

                                                {{-- Footer --}}
                                                <div class="p-4 border-t bg-slate-50 flex justify-end">

                                                    <button @click="showingDetail = false"
                                                        class="px-5 py-2 bg-slate-200 hover:bg-slate-300 rounded-lg font-semibold">

                                                        Tutup

                                                    </button>

                                                </div>

                                            </div>

                                        </div>

                                    </template>

                                    <template x-if="editing">
                                        <div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4">
                                            <div class="bg-white rounded-2xl p-6 w-full max-w-md shadow-2xl">
                                                <h2 class="text-xl font-bold mb-4">Edit Kategori</h2>
                                                <form action="{{ route('categories.update', $category->id) }}" method="POST">
                                                    @csrf @method('PUT')
                                                    <div class="space-y-4">
                                                        <input type="text" name="category_name" value="{{ $category->category_name }}" class="w-full rounded-xl border-slate-200 p-3">
                                                        <textarea name="description" class="w-full rounded-xl border-slate-200 p-3">{{ $category->description }}</textarea>
                                                        <div class="flex gap-2">
                                                            <button type="button" @click="editing = false" class="flex-1 py-3 bg-slate-100 rounded-xl font-bold text-slate-600">Batal</button>
                                                            <button type="submit" class="flex-1 py-3 bg-blue-900 rounded-xl font-bold text-white">Update</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="p-12 text-center">
                                <span class="material-symbols-outlined text-slate-300 text-5xl mb-2">folder_off</span>
                                <p class="text-slate-400">Belum ada kategori yang ditambahkan.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection