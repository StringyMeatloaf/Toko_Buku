<section class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-6">

    <!-- Total Judul Buku -->
    <div class="bg-white p-6 rounded-xl shadow-sm border hover:shadow-md transition-all">

        <div class="flex justify-between items-start mb-4">

            <div class="p-3 bg-blue-100 text-blue-700 rounded-lg">
                <span class="material-symbols-outlined">
                    menu_book
                </span>
            </div>

            <span class="text-green-600 text-sm flex items-center gap-1">
                +12%
                <span class="material-symbols-outlined text-base">
                    trending_up
                </span>
            </span>

        </div>

        <p class="text-gray-500 text-xs uppercase tracking-wider mb-2">
            Total Judul Buku
        </p>

        <h3 class="text-4xl font-bold text-slate-800">
            {{ number_format($totalBooks ?? 0) }}
        </h3>

    </div>

    <!-- Total Buku Masuk -->
    <div class="bg-white p-6 rounded-xl shadow-sm border hover:shadow-md transition-all">

        <div class="flex justify-between items-start mb-4">

            <div class="p-3 bg-green-100 text-green-700 rounded-lg">
                <span class="material-symbols-outlined">
                    download
                </span>
            </div>

            <span class="text-green-600 text-sm flex items-center gap-1">
                +5.2%
                <span class="material-symbols-outlined text-base">
                    trending_up
                </span>
            </span>

        </div>

        <p class="text-gray-500 text-xs uppercase tracking-wider mb-2">
            Total Buku Masuk
        </p>

        <h3 class="text-4xl font-bold text-slate-800">
            {{ number_format($totalEntries ?? 0) }}
        </h3>

    </div>

    <!-- Total Buku Terjual -->
    <div class="bg-white p-6 rounded-xl shadow-sm border hover:shadow-md transition-all">

        <div class="flex justify-between items-start mb-4">

            <div class="p-3 bg-orange-100 text-orange-700 rounded-lg">
                <span class="material-symbols-outlined">
                    sell
                </span>
            </div>

            <span class="text-red-500 text-sm flex items-center gap-1">
                -2.1%
                <span class="material-symbols-outlined text-base">
                    trending_down
                </span>
            </span>

        </div>

        <p class="text-gray-500 text-xs uppercase tracking-wider mb-2">
            Total Buku Terjual
        </p>

        <h3 class="text-4xl font-bold text-slate-800">
            {{ number_format($totalSales ?? 0) }}
        </h3>

    </div>

    <!-- Total Stok -->
    <div class="bg-blue-900 p-6 rounded-xl shadow-lg text-white relative overflow-hidden">

        <div class="absolute -right-6 -bottom-6 opacity-10">

            <span class="material-symbols-outlined text-[120px]">
                inventory
            </span>

        </div>

        <div class="relative z-10">

            <div class="p-3 bg-blue-700 rounded-lg inline-flex mb-4">

                <span class="material-symbols-outlined">
                    inventory
                </span>

            </div>

            <p class="text-blue-100 text-xs uppercase tracking-wider mb-2">
                Total Stok Keseluruhan
            </p>

            <h3 class="text-4xl font-bold">
                {{ number_format($totalStock ?? 0) }}
            </h3>

        </div>

    </div>

</section>