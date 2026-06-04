@extends('layouts.admin')

@section('content')

{{-- Header --}}

<div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8">

    <div>

        <h1 class="text-4xl font-bold text-slate-900">
            Laporan Inventaris
        </h1>

        <p class="text-gray-500 mt-2">
            Riwayat transaksi buku masuk dan keluar.
        </p>

    </div>

    <button
        class="bg-blue-900 text-white px-5 py-3 rounded-xl flex items-center gap-2 hover:bg-blue-800 transition-all">

        <span class="material-symbols-outlined">
            picture_as_pdf
        </span>

        Export PDF

    </button>

</div>

{{-- Filter --}}

<div class="bg-white rounded-xl border shadow-sm p-6 mb-8">

    <h2 class="text-lg font-semibold mb-4">
        Filter Laporan
    </h2>

    <form method="GET"
        action="{{ route('reports.index') }}">

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

            <div>

                <label class="block mb-2 text-sm text-gray-600">
                    Tanggal
                </label>

                <select
                    name="day"
                    class="w-full border rounded-lg p-3">

                    <option value="">
                        Semua Tanggal
                    </option>

                    @for($i = 1; $i <= 31; $i++)

                        <option value="{{ $i }}"
                        {{ $day == $i ? 'selected' : '' }}>

                        {{ $i }}

                        </option>

                        @endfor

                </select>

            </div>

            <div>

                <label class="block mb-2 text-sm text-gray-600">
                    Bulan
                </label>

                <select
                    name="month"
                    class="w-full border rounded-lg p-3">

                    <option value="">
                        Semua Bulan
                    </option>

                    @for($i = 1; $i <= 12; $i++)

                        <option value="{{ $i }}"
                        {{ $month == $i ? 'selected' : '' }}>

                        {{ date('F', mktime(0,0,0,$i,1)) }}

                        </option>

                        @endfor

                </select>

            </div>

            <div>

                <label class="block mb-2 text-sm text-gray-600">
                    Tahun
                </label>

                <select
                    name="year"
                    class="w-full border rounded-lg p-3">

                    <option value="">
                        Semua Tahun
                    </option>

                    @for($i = date('Y'); $i >= 2020; $i--)

                    <option value="{{ $i }}"
                        {{ $year == $i ? 'selected' : '' }}>

                        {{ $i }}

                    </option>

                    @endfor

                </select>

            </div>

            <div class="flex items-end gap-2">

                <button
                    type="submit"
                    class="bg-blue-900 text-white px-5 py-3 rounded-lg">

                    Terapkan

                </button>

                <a href="{{ route('reports.index') }}"
                    class="bg-gray-200 px-5 py-3 rounded-lg">

                    Reset

                </a>

            </div>

        </div>

    </form>

</div>

{{-- Statistik --}}

<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">

    <div class="bg-white p-6 rounded-xl border shadow-sm">

        <p class="text-gray-500 text-sm">
            Total Judul Buku
        </p>

        <h3 class="text-4xl font-bold mt-2">
            {{ $totalBooks }}
        </h3>

    </div>

    <div class="bg-white p-6 rounded-xl border shadow-sm">

        <p class="text-gray-500 text-sm">
            Total Stok
        </p>

        <h3 class="text-4xl font-bold mt-2">
            {{ $totalStock }}
        </h3>

    </div>

    <div class="bg-white p-6 rounded-xl border shadow-sm">

        <p class="text-gray-500 text-sm">
            Buku Masuk
        </p>

        <h3 class="text-4xl font-bold mt-2 text-green-600">
            {{ $totalEntries }}
        </h3>

    </div>

    <div class="bg-white p-6 rounded-xl border shadow-sm">

        <p class="text-gray-500 text-sm">
            Buku Keluar
        </p>

        <h3 class="text-4xl font-bold mt-2 text-red-600">
            {{ $totalSales }}
        </h3>

    </div>

</div>

{{-- Tabel Laporan --}}

<div class="bg-white rounded-xl border shadow-sm overflow-hidden">

    <div class="p-6 border-b">

        <h2 class="text-xl font-bold">
            Data Laporan Detail
        </h2>

    </div>

    <table class="w-full">

        <thead class="bg-gray-50">

            <tr>

                <th class="p-4 text-left">Tanggal</th>
                <th class="p-4 text-left">ISBN</th>
                <th class="p-4 text-left">Judul Buku</th>
                <th class="p-4 text-left">Kategori</th>
                <th class="p-4 text-center">Jenis</th>
                <th class="p-4 text-center">Jumlah</th>
                <th class="p-4 text-center">Stok</th>
                <th class="p-4 text-center">Status</th>

            </tr>

        </thead>

        <tbody>

            @forelse($reports as $report)

            <tr class="border-t hover:bg-gray-50">

                <td class="p-4">

                    {{ \Carbon\Carbon::parse($report['date'])->format('d-m-Y') }}

                </td>

                <td class="p-4">

                    {{ $report['isbn'] }}

                </td>

                <td class="p-4 font-medium">

                    {{ $report['title'] }}

                </td>

                <td class="p-4">

                    {{ $report['category'] }}

                </td>

                <td class="p-4 text-center">

                    @if($report['type'] == 'Masuk')

                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs">
                        Masuk
                    </span>

                    @else

                    <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs">
                        Keluar
                    </span>

                    @endif

                </td>

                <td class="p-4 text-center font-semibold">

                    {{ $report['quantity'] }}

                </td>

                <td class="p-4 text-center">

                    {{ $report['stock'] }}

                </td>

                <td class="p-4 text-center">

                    @if($report['stock'] == 0)

                    <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs">
                        Habis
                    </span>

                    @elseif($report['stock'] <= 10)

                        <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs">
                        Rendah
                        </span>

                        @else

                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs">
                            Tersedia
                        </span>

                        @endif

                </td>

            </tr>

            @empty

            <tr>

                <td colspan="8"
                    class="text-center p-10 text-gray-500">

                    Belum ada data laporan

                </td>

            </tr>

            @endforelse

        </tbody>

    </table>

</div>

@endsection