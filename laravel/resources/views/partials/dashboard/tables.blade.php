<section class="grid grid-cols-1 xl:grid-cols-2 gap-6">

    {{-- Buku Stok Tertinggi --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-50 flex items-center justify-between">
            <h2 class="text-xl font-bold text-slate-800 flex items-center gap-2">
                <span class="material-symbols-outlined text-green-600">trending_up</span>
                Stok Tertinggi
            </h2>
        </div>

        <div class="p-0">
            <table class="w-full">
                <thead class="bg-gray-50/50">
                    <tr>
                        <th class="text-left py-3 px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Judul Buku
                        </th>
                        <th class="text-right py-3 px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Jumlah Stok
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($highestStockBooks as $book)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-4 px-6">
                            <div class="font-medium text-slate-700 truncate max-w-xs">
                                {{ $book->title }}
                            </div>
                        </td>
                        <td class="py-4 px-6 text-right">
                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-green-100 text-green-700 text-sm font-bold border border-green-200">
                                {{ $book->stock }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="2" class="text-center py-10 text-gray-400 italic">
                            Belum ada data tersedia
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Stok Rendah --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-50 flex items-center justify-between">
            <h2 class="text-xl font-bold text-slate-800 flex items-center gap-2">
                <span class="material-symbols-outlined text-red-500">warning</span>
                Stok Rendah
            </h2>
        </div>

        <div class="p-0">
            <table class="w-full">
                <thead class="bg-gray-50/50">
                    <tr>
                        <th class="text-left py-3 px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Judul Buku
                        </th>
                        <th class="text-right py-3 px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Kondisi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($lowStockBooks as $book)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-4 px-6">
                            <div class="font-medium text-slate-700 truncate max-w-xs">
                                {{ $book->title }}
                            </div>
                        </td>
                        <td class="py-4 px-6 text-right">
                            @if($book->stock == 0)
                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-bold border border-red-200">
                                    HABIS
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-bold border border-yellow-200">
                                    SISA {{ $book->stock }}
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="2" class="text-center py-10 text-gray-400 italic">
                            Semua stok dalam kondisi aman
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</section>