@extends('layouts.admin')

@section('content')
<div class="p-6"> {{-- Tambahan wrapper padding agar layout tidak terlalu mepet ke layar --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8">
        <div>
            <nav class="flex items-center gap-1 text-sm text-gray-500 mb-1">
                <span>Master Data</span>
                <span class="material-symbols-outlined text-sm">chevron_right</span>
                <span class="text-blue-900 font-semibold">Daftar Buku</span>
            </nav>
            <h1 class="text-4xl font-bold text-slate-900">Inventaris Buku</h1>
            <p class="text-gray-500 mt-2">Kelola seluruh koleksi pustaka dan informasi buku.</p>
        </div>

        <a href="{{ route('books.create') }}"
            class="bg-blue-900 text-white px-5 py-3 rounded-xl flex items-center gap-2 hover:bg-blue-800 transition-all">
            <span class="material-symbols-outlined">add</span>
            Tambah Buku Baru
        </a>
    </div>

    {{-- Statistik --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
        {{-- Card Total Judul --}}
        <div class="bg-white p-6 rounded-xl shadow-sm border">
            <div class="flex justify-between mb-4">
                <span class="material-symbols-outlined p-3 bg-blue-100 rounded-lg text-blue-900">menu_book</span>
                <span class="text-green-600 font-semibold">+12%</span>
            </div>
            <p class="text-gray-500 text-sm">Total Judul</p>
            <h3 class="text-4xl font-bold">{{ $totalBooks ?? 0 }}</h3>
        </div>

        {{-- Card Total Stok --}}
        <div class="bg-white p-6 rounded-xl shadow-sm border">
            <div class="flex justify-between mb-4">
                <span class="material-symbols-outlined p-3 bg-green-100 rounded-lg text-green-700">inventory_2</span>
            </div>
            <p class="text-gray-500 text-sm">Total Stok</p>
            <h3 class="text-4xl font-bold">{{ $totalStock ?? 0 }}</h3>
        </div>

        {{-- Card Kategori --}}
        <div class="bg-white p-6 rounded-xl shadow-sm border">
            <div class="flex justify-between mb-4">
                <span class="material-symbols-outlined p-3 bg-yellow-100 rounded-lg text-yellow-700">category</span>
            </div>
            <p class="text-gray-500 text-sm">Kategori</p>
            <h3 class="text-4xl font-bold">{{ $totalCategories ?? 0 }}</h3>
        </div>

        {{-- Card Stok Kritis --}}
        <div class="bg-white p-6 rounded-xl shadow-sm border">
            <div class="flex justify-between mb-4">
                <span class="material-symbols-outlined p-3 bg-red-100 rounded-lg text-red-700">warning</span>
            </div>
            <p class="text-gray-500 text-sm">Stok Kritis</p>
            <h3 class="text-4xl font-bold">{{ $criticalStock ?? 0 }}</h3>
        </div>
    </div>

    {{-- Filter --}}
    <div class="bg-white p-4 rounded-xl border shadow-sm mb-6">
        <div class="flex flex-wrap gap-4 items-center">
            <div class="flex-1">
                <input type="text" placeholder="Cari judul buku..." class="w-full rounded-lg border p-3">
            </div>
            <select class="border rounded-lg p-3">
                <option>Semua Kategori</option>
            </select>
        </div>
    </div>

    {{-- Tabel Buku --}}
    <div class="bg-white rounded-xl border shadow-sm overflow-hidden">
        <table class="w-full border-collapse">
            <thead class="bg-gray-50">
                <tr>
                    <th class="p-5 text-left w-24">Cover</th>
                    <th class="p-5 text-left">Informasi Buku</th> {{-- Menambah padding agar lebih ke tengah --}}
                    <th class="p-5 text-left">Kategori</th>
                    <th class="p-5 text-center">Stok</th>
                    <th class="p-5 text-center">Status</th>
                    <th class="p-5 text-left">Harga</th>
                    <th class="p-5 text-center w-40">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($books as $book)
                <tr class="border-t hover:bg-gray-50 transition-colors">
                    {{-- Cover --}}
                    <td class="p-5">
                        <div class="w-14 h-20 bg-gray-200 rounded-lg shadow-sm flex items-center justify-center overflow-hidden">
                            @if($book->cover)
                            <img src="{{ asset('storage/' . $book->cover) }}"
                                class="w-full h-full object-cover"
                                alt="{{ $book->title }}">
                            @else
                            <span class="material-symbols-outlined text-gray-400">image</span>
                            @endif
                        </div>
                    </td>

                    {{-- Informasi Buku --}}
                    <td class="p-5">
                        <div class="font-bold text-slate-900 text-base">
                            {{ $book->title }}
                        </div>
                        <div class="text-sm text-gray-500 mt-1 flex flex-col gap-0.5">
                            <span><span class="font-medium text-gray-400">ISBN:</span> {{ $book->isbn ?: '-' }}</span>
                            <span><span class="font-medium text-gray-400">Penulis:</span> {{ $book->author }}</span>
                        </div>
                    </td>

                    {{-- Kategori --}}
                    <td class="p-5">
                        <span class="px-3 py-1 rounded-full bg-blue-50 text-blue-700 text-xs font-semibold border border-blue-100">
                            {{ $book->category->category_name ?? 'Tanpa Kategori' }}
                        </span>
                    </td>

                    {{-- Stok --}}
                    <td class="p-5 text-center">
                        <span class="font-bold text-slate-700 text-lg">
                            {{ $book->stock }}
                        </span>
                    </td>

                    {{-- Status --}}
                    <td class="p-5 text-center">
                        @php
                        $stock = (int) $book->stock;
                        @endphp
                        @if($stock === 0)
                        <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-bold">Habis</span>
                        @elseif($stock <= 10)
                            <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-bold">Rendah</span>
                            @else
                            <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-bold">Tersedia</span>
                            @endif
                    </td>

                    {{-- Harga --}}
                    <td class="p-5 font-bold text-slate-900">
                        Rp {{ number_format($book->price, 0, ',', '.') }}
                    </td>

                    {{-- Aksi --}}
                    <td class="p-5">
                        <div class="flex items-center justify-center gap-4">
                            <a href="{{ route('books.edit', $book->id) }}"
                                class="flex items-center gap-1 text-blue-600 hover:text-blue-900 font-medium">
                                <span class="material-symbols-outlined text-lg">edit</span>
                                Edit
                            </a>

                            <form action="{{ route('books.destroy', $book->id) }}"
                                method="POST"
                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="flex items-center gap-1 text-red-600 hover:text-red-900 font-medium">
                                    <span class="material-symbols-outlined text-lg">delete</span>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center p-12 text-gray-400 italic">
                        Belum ada data buku yang tersedia.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection