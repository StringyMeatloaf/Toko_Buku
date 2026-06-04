@extends('layouts.admin')

@section('content')

<div class="max-w-5xl mx-auto">

```
{{-- Breadcrumb --}}
<div class="mb-8">

    <div class="flex items-center gap-2 text-sm text-gray-500 mb-2">

        <a href="{{ route('inventory.index') }}"
           class="hover:text-blue-900">

            Inventaris Buku

        </a>

        <span class="material-symbols-outlined text-sm">
            chevron_right
        </span>

        <span class="text-blue-900 font-semibold">
            Tambah Transaksi
        </span>

    </div>

    <h1 class="text-4xl font-bold text-slate-900">
        Tambah Transaksi Inventaris
    </h1>

    <p class="text-gray-500 mt-2">
        Catat transaksi buku masuk atau keluar.
    </p>

</div>

{{-- Error Validation --}}
@if ($errors->any())

    <div class="mb-6 bg-red-100 border border-red-200 text-red-700 px-4 py-3 rounded-xl">

        <ul class="list-disc ml-5">

            @foreach ($errors->all() as $error)

                <li>{{ $error }}</li>

            @endforeach

        </ul>

    </div>

@endif

{{-- Form Card --}}
<div class="bg-white rounded-2xl border shadow-sm p-8">

    <form action="{{ route('inventory.store') }}"
          method="POST">

        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Tipe Transaksi --}}
            <div>

                <label class="block mb-2 font-medium">
                    Tipe Transaksi
                </label>

                <select
                    id="transaction_type"
                    name="transaction_type"
                    class="w-full border rounded-xl p-3">

                    <option value="entry">
                        Buku Masuk
                    </option>

                    <option value="sale">
                        Buku Keluar
                    </option>

                </select>

            </div>

            {{-- Buku --}}
            <div>

                <label class="block mb-2 font-medium">
                    Pilih Buku
                </label>

                <select
                    id="book_id"
                    name="book_id"
                    class="w-full border rounded-xl p-3">

                    <option value="">
                        Pilih Buku
                    </option>

                    @foreach($books as $book)

                        <option
                            value="{{ $book->id }}"
                            data-stock="{{ $book->stock }}"
                            data-category="{{ $book->category->category_name ?? '-' }}">

                            {{ $book->title }}

                        </option>

                    @endforeach

                </select>

            </div>

            {{-- Tanggal --}}
            <div>

                <label class="block mb-2 font-medium">
                    Tanggal Transaksi
                </label>

                <input
                    id="transaction_date"
                    type="date"
                    name="transaction_date"
                    value="{{ old('transaction_date', date('Y-m-d')) }}"
                    class="w-full border rounded-xl p-3">

            </div>

            {{-- Jumlah --}}
            <div>

                <label class="block mb-2 font-medium">
                    Jumlah
                </label>

                <input
                    id="quantity"
                    type="number"
                    min="1"
                    name="quantity"
                    value="{{ old('quantity') }}"
                    placeholder="Masukkan jumlah"
                    class="w-full border rounded-xl p-3">

            </div>

        </div>

        {{-- Informasi Buku --}}
        <div class="mt-6">

            <div class="bg-blue-50 border border-blue-100 rounded-xl p-4">

                <div class="flex items-center gap-3">

                    <span class="material-symbols-outlined text-blue-900">
                        inventory_2
                    </span>

                    <div>

                        <p class="text-sm text-gray-500">
                            Informasi Buku
                        </p>

                        <p id="currentStock"
                           class="font-bold text-blue-900">

                            Pilih buku terlebih dahulu

                        </p>

                        <p id="currentCategory"
                           class="text-sm text-gray-500">
                        </p>

                    </div>

                </div>

            </div>

        </div>


        {{-- Keterangan --}}
        <div class="mt-6">

            <label class="block mb-2 font-medium">
                Keterangan
            </label>

            <textarea
                name="notes"
                rows="4"
                placeholder="Contoh: Pembelian dari Supplier A"
                class="w-full border rounded-xl p-3">{{ old('notes') }}</textarea>

        </div>

        {{-- Ringkasan --}}
        <div class="mt-6 bg-gray-50 border rounded-xl p-5">

            <h3 class="font-semibold mb-3">
                Ringkasan Transaksi
            </h3>

            <div class="grid grid-cols-2 gap-4 text-sm">

                <div>
                    <span class="text-gray-500">
                        Tipe:
                    </span>

                    <span id="summaryType">
                        Buku Masuk
                    </span>
                </div>

                <div>
                    <span class="text-gray-500">
                        Buku:
                    </span>

                    <span id="summaryBook">
                        -
                    </span>
                </div>

                <div>
                    <span class="text-gray-500">
                        Jumlah:
                    </span>

                    <span id="summaryQty">
                        0
                    </span>
                </div>

                <div>
                    <span class="text-gray-500">
                        Tanggal:
                    </span>

                    <span id="summaryDate">
                        -
                    </span>
                </div>

            </div>

        </div>

        {{-- Tombol --}}
        <div class="flex justify-end gap-3 mt-8">

            <a href="{{ route('inventory.index') }}"
               class="px-5 py-3 rounded-xl bg-gray-200 hover:bg-gray-300">

                Batal

            </a>

            <button
                type="submit"
                class="px-5 py-3 rounded-xl bg-blue-900 text-white hover:bg-blue-800">

                Simpan Transaksi

            </button>

        </div>

    </form>

</div>
```

</div>

@endsection

@section('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    const typeSelect = document.getElementById('transaction_type');
    const salePriceSection = document.getElementById('sale_price_section');

    const bookSelect = document.getElementById('book_id');
    const quantityInput = document.getElementById('quantity');
    const dateInput = document.getElementById('transaction_date');

    const stockText = document.getElementById('currentStock');
    const categoryText = document.getElementById('currentCategory');

    const summaryType = document.getElementById('summaryType');
    const summaryBook = document.getElementById('summaryBook');
    const summaryQty = document.getElementById('summaryQty');
    const summaryDate = document.getElementById('summaryDate');

    function toggleSalePrice()
    {
        if(typeSelect.value === 'sale')
        {
            salePriceSection.classList.remove('hidden');
            summaryType.textContent = 'Buku Keluar';
        }
        else
        {
            salePriceSection.classList.add('hidden');
            summaryType.textContent = 'Buku Masuk';
        }
    }

    function updateBookInfo()
    {
        const selected =
            bookSelect.options[bookSelect.selectedIndex];

        if(bookSelect.value)
        {
            stockText.textContent =
                'Stok Saat Ini : ' +
                selected.dataset.stock +
                ' Buku';

            categoryText.textContent =
                'Kategori : ' +
                selected.dataset.category;

            summaryBook.textContent =
                selected.text;
        }
        else
        {
            stockText.textContent =
                'Pilih buku terlebih dahulu';

            categoryText.textContent = '';

            summaryBook.textContent = '-';
        }
    }

    function updateSummary()
    {
        summaryQty.textContent =
            quantityInput.value || 0;

        summaryDate.textContent =
            dateInput.value || '-';
    }

    toggleSalePrice();
    updateBookInfo();
    updateSummary();

    typeSelect.addEventListener(
        'change',
        toggleSalePrice
    );

    bookSelect.addEventListener(
        'change',
        updateBookInfo
    );

    quantityInput.addEventListener(
        'input',
        updateSummary
    );

    dateInput.addEventListener(
        'change',
        updateSummary
    );

});

</script>

@endsection
