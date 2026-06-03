@extends('layouts.admin')

@section('content')

<div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8">

    <div>

        <nav class="flex items-center gap-1 text-sm text-gray-500 mb-1">

            <span>Master Data</span>

            <span class="material-symbols-outlined text-sm">
                chevron_right
            </span>

            <span class="text-blue-900 font-semibold">
                Daftar Buku
            </span>

        </nav>

        <h1 class="text-4xl font-bold text-slate-900">
            Inventaris Buku
        </h1>

        <p class="text-gray-500 mt-2">
            Kelola seluruh koleksi pustaka dan informasi buku.
        </p>

    </div>

    <a href="{{ route('books.create') }}"
   class="bg-blue-900 text-white px-5 py-3 rounded-xl flex items-center gap-2 hover:bg-blue-800 transition-all">

    <span class="material-symbols-outlined">
        add
    </span>

    Tambah Buku Baru

</a>

</div>

{{-- Statistik --}}

<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">

    <div class="bg-white p-6 rounded-xl shadow-sm border">

        <div class="flex justify-between mb-4">

            <span class="material-symbols-outlined p-3 bg-blue-100 rounded-lg text-blue-900">
                menu_book
            </span>

            <span class="text-green-600 font-semibold">
                +12%
            </span>

        </div>

        <p class="text-gray-500 text-sm">
            Total Judul
        </p>

        <h3 class="text-4xl font-bold">
            {{ $totalBooks ?? 0 }}
        </h3>

    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm border">

        <div class="flex justify-between mb-4">

            <span class="material-symbols-outlined p-3 bg-green-100 rounded-lg text-green-700">
                inventory_2
            </span>

        </div>

        <p class="text-gray-500 text-sm">
            Total Stok
        </p>

        <h3 class="text-4xl font-bold">
            {{ $totalStock ?? 0 }}
        </h3>

    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm border">

        <div class="flex justify-between mb-4">

            <span class="material-symbols-outlined p-3 bg-yellow-100 rounded-lg text-yellow-700">
                category
            </span>

        </div>

        <p class="text-gray-500 text-sm">
            Kategori
        </p>

        <h3 class="text-4xl font-bold">
            {{ $totalCategories ?? 0 }}
        </h3>

    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm border">

        <div class="flex justify-between mb-4">

            <span class="material-symbols-outlined p-3 bg-red-100 rounded-lg text-red-700">
                warning
            </span>

        </div>

        <p class="text-gray-500 text-sm">
            Stok Kritis
        </p>

        <h3 class="text-4xl font-bold">
            {{ $criticalStock ?? 0 }}
        </h3>

    </div>

</div>

{{-- Filter --}}

<div class="bg-white p-4 rounded-xl border shadow-sm mb-6">

    <div class="flex flex-wrap gap-4 items-center">

        <div class="flex-1">

            <input
                type="text"
                placeholder="Cari judul buku..."
                class="w-full rounded-lg border p-3">

        </div>

        <select class="border rounded-lg p-3">

            <option>Semua Kategori</option>

        </select>

    </div>

</div>

{{-- Tabel Buku --}}

<div class="bg-white rounded-xl border shadow-sm overflow-hidden">

    <table class="w-full">

        <thead class="bg-gray-50">

            <tr>

                <th class="p-4 text-left">Cover</th>
                <th class="p-4 text-left">Judul & ISBN</th>
                <th class="p-4 text-left">Penulis</th>
                <th class="p-4 text-left">Penerbit</th>
                <th class="p-4 text-left">Kategori</th>
                <th class="p-4 text-left">Harga</th>
                <th class="p-4 text-center">Aksi</th>

            </tr>

        </thead>

        <tbody>

            @forelse($books ?? [] as $book)

            <tr class="border-t hover:bg-gray-50">

                <td class="p-4">

                    <div class="w-12 h-16 bg-gray-200 rounded">
                    </div>

                </td>

                <td class="p-4">

                    <div class="font-semibold">

                        {{ $book->title }}

                    </div>

                    <div class="text-sm text-gray-500">

                        ISBN:
                        {{ $book->isbn }}

                    </div>

                </td>

                <td class="p-4">

                    {{ $book->author }}

                </td>

                <td class="p-4">

                    {{ $book->publisher }}

                </td>

                <td class="p-4">

                    <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-800 text-xs">

                        {{ $book->category->category_name ?? '-' }}

                    </span>

                </td>

                <td class="p-4">

                    Rp {{ number_format($book->price,0,',','.') }}

                </td>

                <td class="p-4 text-center">
    <div class="flex items-center justify-center gap-4">
        {{-- Tombol Edit --}}
        <a href="{{ route('books.edit', $book->id) }}"
           class="flex items-center gap-1 text-blue-600 hover:text-blue-900 font-medium transition-colors">
            <span class="material-symbols-outlined text-sm">edit</span>
            Edit
        </a>

        {{-- Tombol Delete --}}
        <form action="{{ route('books.destroy', $book->id) }}" 
              method="POST" 
              onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini?');"
              class="inline">
            @csrf
            @method('DELETE')
            
            <button type="submit" 
                    class="flex items-center gap-1 text-red-600 hover:text-red-900 font-medium transition-colors">
                <span class="material-symbols-outlined text-sm">delete</span>
                Hapus
            </button>
        </form>
    </div>
</td>

            </tr>

            @empty

            <tr>

                <td colspan="7"
                    class="text-center p-10 text-gray-500">

                    Belum ada buku

                </td>

            </tr>

            @endforelse

        </tbody>

    </table>

</div>

@endsection