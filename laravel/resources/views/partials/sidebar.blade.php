<aside class="fixed left-0 top-0 h-full w-[280px] bg-white border-r">

    <div class="p-6">

        <h1 class="text-3xl font-bold text-blue-900">
            BookStock
        </h1>

        <p class="text-sm text-gray-500">
            Inventory System
        </p>

    </div>

    <nav class="px-4 flex flex-col gap-2">

        <a href="{{ route('dashboard') }}"
           class="flex items-center gap-3 bg-blue-900 text-white px-4 py-3 rounded-lg">

            <span class="material-symbols-outlined">
                dashboard
            </span>

            Dashboard

        </a>

        <a href="#"
           class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-100">

            <span class="material-symbols-outlined">
                inventory_2
            </span>

            Inventaris Buku

        </a>

        <a href="#"
           class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-100">

            <span class="material-symbols-outlined">
                database
            </span>

            Master Data

        </a>

        <a href="#"
           class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-100">

            <span class="material-symbols-outlined">
                assessment
            </span>

            Laporan

        </a>

    </nav>

</aside>