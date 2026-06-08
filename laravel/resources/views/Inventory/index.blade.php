@extends('layouts.admin')

@section('content')

<div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8">

    <div>

        <nav class="flex items-center gap-1 text-sm text-gray-500 mb-1">

            <span>Inventaris Buku</span>

        </nav>

        <h1 class="text-4xl font-bold text-slate-900">
            Inventaris Buku
        </h1>

        <p class="text-gray-500 mt-2">
            Monitoring stok dan seluruh aktivitas transaksi buku.
        </p>

    </div>

    <<a href="{{ route('inventory.create') }}"
   class="bg-blue-900 text-white px-5 py-3 rounded-xl flex items-center gap-2 hover:bg-blue-800">

    <span class="material-symbols-outlined">
        add
    </span>

    Tambah Transaksi

</a>

</div>

{{-- Statistik --}}

<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">

    {{-- Total Buku --}}
    <div class="bg-white p-6 rounded-xl border shadow-sm">

        <div class="flex justify-between mb-4">

            <span class="material-symbols-outlined p-3 bg-blue-100 rounded-lg text-blue-900">
                menu_book
            </span>

        </div>

        <p class="text-gray-500 text-sm">
            Total Buku
        </p>

        <h3 class="text-4xl font-bold">
            {{ $totalBooks }}
        </h3>

    </div>

    {{-- Total Stok --}}
    <div class="bg-white p-6 rounded-xl border shadow-sm">

        <div class="flex justify-between mb-4">

            <span class="material-symbols-outlined p-3 bg-green-100 rounded-lg text-green-700">
                inventory_2
            </span>

        </div>

        <p class="text-gray-500 text-sm">
            Total Stok
        </p>

        <h3 class="text-4xl font-bold">
            {{ number_format($totalStock) }}
        </h3>

    </div>

    {{-- Stok Rendah --}}
    <div class="bg-white p-6 rounded-xl border shadow-sm">

        <div class="flex justify-between mb-4">

            <span class="material-symbols-outlined p-3 bg-yellow-100 rounded-lg text-yellow-700">
                warning
            </span>

        </div>

        <p class="text-gray-500 text-sm">
            Stok Rendah
        </p>

        <h3 class="text-4xl font-bold">
            {{ $lowStock }}
        </h3>

    </div>

    {{-- Habis --}}
    <div class="bg-white p-6 rounded-xl border shadow-sm">

        <div class="flex justify-between mb-4">

            <span class="material-symbols-outlined p-3 bg-red-100 rounded-lg text-red-700">
                cancel
            </span>

        </div>

        <p class="text-gray-500 text-sm">
            Stok Habis
        </p>

        <h3 class="text-4xl font-bold">
            {{ $outOfStock }}
        </h3>

    </div>

</div>

{{-- Filter --}}

<form method="GET"
      action="{{ route('inventory.index') }}"
      class="bg-white p-4 rounded-xl border shadow-sm mb-6">

    <div class="flex flex-wrap gap-4 items-center">

        <div class="flex-1">

            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari buku..."
                class="w-full border rounded-lg p-3">

        </div>

        <select
            name="type"
            class="border rounded-lg p-3">

            <option value="">
                Semua Transaksi
            </option>

            <option value="Masuk"
                {{ request('type') == 'Masuk' ? 'selected' : '' }}>
                Masuk
            </option>

            <option value="Keluar"
                {{ request('type') == 'Keluar' ? 'selected' : '' }}>
                Keluar
            </option>

        </select>

        <select
            name="status"
            class="border rounded-lg p-3">

            <option value="">
                Semua Status
            </option>

            <option value="Tersedia"
                {{ request('status') == 'Tersedia' ? 'selected' : '' }}>
                Tersedia
            </option>

            <option value="Stok Rendah"
                {{ request('status') == 'Stok Rendah' ? 'selected' : '' }}>
                Stok Rendah
            </option>

            <option value="Habis"
                {{ request('status') == 'Habis' ? 'selected' : '' }}>
                Habis
            </option>

        </select>

        <button
            type="submit"
            class="bg-blue-900 text-white px-5 py-3 rounded-lg">

            Filter

        </button>

    </div>

</form>

{{-- Tabel Inventaris --}}

<div class="bg-white rounded-xl border shadow-sm overflow-hidden">

    <table class="w-full">

        <thead class="bg-gray-50">

            <tr>

                <th class="p-4 text-left">No</th>
                <th class="p-4 text-left">Judul Buku</th>
                <th class="p-4 text-left">Kategori</th>
                <th class="p-4 text-left">Tipe</th>
                <th class="p-4 text-left">Qty</th>
                <th class="p-4 text-left">Stok Saat Ini</th>
                <th class="p-4 text-left">Status</th>
                <th class="p-4 text-left">Keterangan</th>
                <th class="p-4 text-left">Tanggal</th>

            </tr>

        </thead>

        <tbody>

            @forelse($transactions as $index => $transaction)

            <tr class="border-t hover:bg-gray-50">

                <td class="p-4">
                    {{ $index + 1 }}
                </td>

                <td class="p-4 font-medium">
                    {{ $transaction['book']->title }}
                </td>

                <td class="p-4">
                    {{ $transaction['book']->category->category_name ?? '-' }}
                </td>

                <td class="p-4">

                    @if($transaction['type'] == 'Masuk')

                        <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-800 text-xs">
                            Masuk
                        </span>

                    @else

                        <span class="px-3 py-1 rounded-full bg-purple-100 text-purple-800 text-xs">
                            Keluar
                        </span>

                    @endif

                </td>

                <td class="p-4 font-semibold">
                    {{ $transaction['quantity'] }}
                </td>

                <td class="p-4">
                    {{ $transaction['stock'] }}
                </td>

                <td class="p-4">

                    @if($transaction['stock'] == 0)

                        <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs">
                            Habis
                        </span>

                    @elseif($transaction['stock'] <= 10)

                        <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs">
                            Stok Rendah
                        </span>

                    @else

                        <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs">
                            Tersedia
                        </span>

                    @endif

                </td>

                <td class="p-4">
                    {{ $transaction['notes'] ?? '-' }}
                </td>

                <td class="p-4">
                    {{ \Carbon\Carbon::parse($transaction['date'])->format('d M Y') }}
                </td>

            </tr>

            @empty

            <tr>

                <td colspan="9"
                    class="text-center p-10 text-gray-500">

                    Belum ada transaksi inventaris.

                </td>

            </tr>

            @endforelse

        </tbody>

    </table>

</div>

@endsection