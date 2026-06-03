<header class="fixed top-0 right-0 w-[calc(100%-280px)] h-16 bg-white border-b">

    <div class="flex justify-between items-center h-full px-8">

        <div class="relative w-96">

            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2">
                search
            </span>

            <input
                type="text"
                placeholder="Cari buku..."
                class="w-full rounded-full border pl-10 pr-4 py-2">

        </div>

        <div class="flex items-center gap-4">

            <button>
                <span class="material-symbols-outlined">
                    notifications
                </span>
            </button>

            <div>

                <p class="font-semibold">
                    {{ Auth::user()->name }}
                </p>

                <p class="text-xs text-gray-500">
                    Administrator
                </p>

            </div>

        </div>

    </div>

</header>