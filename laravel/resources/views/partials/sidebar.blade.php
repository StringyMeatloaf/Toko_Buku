<aside class="fixed left-0 top-0 h-full w-[280px] bg-white border-r z-40">

    <div class="p-6">
        <h1 class="text-3xl font-bold text-blue-900 tracking-tight">
            BookStock
        </h1>
        <p class="text-sm text-gray-500 font-medium">
            Inventory System
        </p>
    </div>

    <nav class="px-4 flex flex-col gap-2" 
         x-data="{ openMaster: {{ request()->routeIs('books.*') || request()->routeIs('categories.*') ? 'true' : 'false' }} }">
        
        <a href="{{ route('dashboard') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 
           {{ request()->routeIs('dashboard') ? 'bg-blue-900 text-white shadow-md' : 'text-gray-600 hover:bg-gray-100' }}">
            <span class="material-symbols-outlined">
                dashboard
            </span>
            <span class="font-medium">Dashboard</span>
        </a>

        <a href="{{ route('inventory.index') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200
            {{ request()->routeIs('inventory.*') ? 'bg-blue-900 text-white shadow-md' : 'text-gray-600 hover:bg-gray-100' }}">

            <span class="material-symbols-outlined">
                inventory_2
            </span>

            <span class="font-medium">
                Inventaris Buku
            </span>

        </a>

        <div class="relative">
            <button @click="openMaster = !openMaster"
                    class="w-full flex items-center justify-between px-4 py-3 rounded-lg transition-all duration-200 
                    {{ request()->routeIs('books.*') || request()->routeIs('categories.*') ? 'text-blue-900 font-bold' : 'text-gray-600 hover:bg-gray-100' }}">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined">
                        database
                    </span>
                    <span class="font-medium">Master Data</span>
                </div>
                <span class="material-symbols-outlined transition-transform duration-300"
                      :class="openMaster ? 'rotate-180' : ''">
                    expand_more
                </span>
            </button>

            <div x-show="openMaster" 
                 x-cloak
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 -translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="mt-1 flex flex-col gap-1 pl-12 pr-2">
                
                <a href="{{ route('books.index') }}" 
                   class="py-2 px-3 text-sm rounded-md transition-colors
                   {{ request()->routeIs('books.index') ? 'text-blue-900 font-bold bg-blue-50' : 'text-gray-500 hover:text-blue-900 hover:bg-gray-50' }}">
                    Daftar Buku
                </a>

                <a href="{{ route('categories.index') }}" 
                   class="py-2 px-3 text-sm rounded-md transition-colors
                   {{ request()->routeIs('categories.index') ? 'text-blue-900 font-bold bg-blue-50' : 'text-gray-500 hover:text-blue-900 hover:bg-gray-50' }}">
                    Kategori Buku
                </a>

                <a href="#" 
                   class="py-2 px-3 text-sm text-gray-500 rounded-md hover:text-blue-900 hover:bg-gray-50 transition-colors">
                    Manajemen Pengguna
                </a>
            </div>
        </div>

        <a href="{{ route('reports.index') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-600 hover:bg-gray-100 transition-all">
            <span class="material-symbols-outlined">
                assessment
            </span>
            <span class="font-medium">Laporan</span>
        </a>

        <div class="mt-auto pt-10 border-t border-gray-100">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" 
                        class="w-full flex items-center gap-3 px-4 py-3 text-red-600 hover:bg-red-50 rounded-lg transition-all">
                    <span class="material-symbols-outlined">
                        logout
                    </span>
                    <span class="font-medium">Keluar</span>
                </button>
            </form>
        </div>
    </nav>
</aside>