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
<td class="p-4">
    <div class="flex items-center justify-center gap-2">
        {{-- Tombol Detail (Mata Biru) --}}
        <button type="button"
            class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors btn-detail-buku"
            title="Detail Buku"
            data-book="{{ json_encode($book) }}"
            data-category="{{ $book->category->category_name ?? 'Tanpa Kategori' }}">
            <span class="material-symbols-outlined block">visibility</span>
        </button>

        {{-- Tombol Edit (Pensil Oren) --}}
        <a href="{{ route('books.edit', $book->id) }}"
            class="p-2 text-amber-600 hover:bg-amber-50 rounded-lg transition-colors"
            title="Edit Buku">
            <span class="material-symbols-outlined block">edit</span>
        </a>

        {{-- Form Hapus (Tempat Sampah Merah) --}}
        <form action="{{ route('books.destroy', $book->id) }}"
            method="POST"
            class="inline-block m-0"
            onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini?');">
            @csrf
            @method('DELETE')
            <button type="submit" 
                class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                title="Hapus Buku">
                <span class="material-symbols-outlined block">delete</span>
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

{{-- Modal Detail Buku --}}
<div id="detailModal" class="hidden fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-[99] items-center justify-center p-4 transition-all">
    <div class="bg-white w-full max-w-2xl rounded-2xl shadow-2xl overflow-hidden transform transition-all">
        {{-- Header Modal --}}
        <div class="p-6 border-b flex justify-between items-center bg-slate-50">
            <h2 class="text-xl font-bold text-slate-900 flex items-center gap-2">
                <span class="material-symbols-outlined text-blue-900">info</span>
                Detail Informasi Buku
            </h2>
            <button onclick="closeDetailModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        {{-- Body Modal --}}
        <div class="p-8">
            <div class="flex flex-col md:flex-row gap-8">
                {{-- Sisi Kiri: Preview Cover --}}
                <div class="w-full md:w-1/3 flex flex-col items-center">
                    <div id="modalCoverWrapper" class="w-40 h-56 bg-gray-100 rounded-xl shadow-md border overflow-hidden flex items-center justify-center">
                        <img id="modalCover" src="" class="w-full h-full object-cover hidden">
                        <span id="modalNoCover" class="material-symbols-outlined text-gray-300 text-6xl">image</span>
                    </div>
                    <div id="modalStatus" class="mt-4"></div>
                </div>

                {{-- Sisi Kanan: Detail Teks --}}
                <div class="w-full md:w-2/3 space-y-4">
                    <div>
                        <h3 id="modalTitle" class="text-2xl font-extrabold text-slate-900 leading-tight"></h3>
                        <p id="modalAuthor" class="text-blue-600 font-medium"></p>
                    </div>

                    <div class="grid grid-cols-2 gap-4 pt-4 border-t border-dashed">
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wider font-bold">ISBN</p>
                            <p id="modalIsbn" class="text-slate-700 font-semibold"></p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wider font-bold">Kategori</p>
                            <p id="modalCategory" class="text-slate-700 font-semibold"></p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wider font-bold">Stok Tersedia</p>
                            <p id="modalStock" class="text-slate-700 font-semibold"></p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wider font-bold">Harga Satuan</p>
                            <p id="modalPrice" class="text-blue-900 font-bold"></p>
                        </div>
                    </div>

                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wider font-bold">Deskripsi / Sinopsis</p>
                        <p id="modalDescription" class="text-sm text-gray-600 leading-relaxed italic"></p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Footer Modal --}}
        <div class="p-4 bg-gray-50 border-t flex justify-end">
            <button onclick="closeDetailModal()" class="px-6 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-lg font-bold transition-all">
                Tutup
            </button>
        </div>
    </div>
</div>

{{-- Modal Detail Buku --}}
<div id="detailModal" class="hidden fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-[99] items-center justify-center p-4 transition-all">
    <div class="bg-white w-full max-w-2xl rounded-2xl shadow-2xl overflow-hidden transform transition-all">
        {{-- Header Modal --}}
        <div class="p-6 border-b flex justify-between items-center bg-slate-50">
            <h2 class="text-xl font-bold text-slate-900 flex items-center gap-2">
                <span class="material-symbols-outlined text-blue-900">info</span>
                Detail Informasi Buku
            </h2>
            <button type="button" onclick="closeDetailModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        {{-- Body Modal --}}
        <div class="p-8">
            <div class="flex flex-col md:flex-row gap-8">
                {{-- Sisi Kiri: Preview Cover --}}
                <div class="w-full md:w-1/3 flex flex-col items-center">
                    <div id="modalCoverWrapper" class="w-40 h-56 bg-gray-100 rounded-xl shadow-md border overflow-hidden flex items-center justify-center">
                        <img id="modalCover" src="" class="w-full h-full object-cover hidden" alt="Cover Buku">
                        <span id="modalNoCover" class="material-symbols-outlined text-gray-300 text-6xl">image</span>
                    </div>
                    <div id="modalStatus" class="mt-4"></div>
                </div>

                {{-- Sisi Kanan: Detail Teks --}}
                <div class="w-full md:w-2/3 space-y-4">
                    <div>
                        <h3 id="modalTitle" class="text-2xl font-extrabold text-slate-900 leading-tight"></h3>
                        <p id="modalAuthor" class="text-blue-600 font-medium"></p>
                    </div>

                    <div class="grid grid-cols-2 gap-4 pt-4 border-t border-dashed">
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wider font-bold">ISBN</p>
                            <p id="modalIsbn" class="text-slate-700 font-semibold"></p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wider font-bold">Kategori</p>
                            <p id="modalCategory" class="text-slate-700 font-semibold"></p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wider font-bold">Stok Tersedia</p>
                            <p id="modalStock" class="text-slate-700 font-semibold"></p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wider font-bold">Harga Satuan</p>
                            <p id="modalPrice" class="text-blue-900 font-bold"></p>
                        </div>
                    </div>

                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wider font-bold">Deskripsi / Sinopsis</p>
                        <p id="modalDescription" class="text-sm text-gray-600 leading-relaxed italic"></p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Footer Modal --}}
        <div class="p-4 bg-gray-50 border-t flex justify-end">
            <button type="button" onclick="closeDetailModal()" class="px-6 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-lg font-bold transition-all">
                Tutup
            </button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Mendaftarkan fungsi klik ke semua tombol detail buku
        document.querySelectorAll('.btn-detail-buku').forEach(button => {
            button.addEventListener('click', function () {
                // Ambil data mentah dari atribut HTML5
                const bookData = this.getAttribute('data-book');
                const categoryName = this.getAttribute('data-category');
                
                if (!bookData) return;
                
                const book = JSON.parse(bookData);

                // Isikan data ke elemen modal
                document.getElementById('modalTitle').innerText = book.title || '-';
                document.getElementById('modalAuthor').innerText = "Karya: " + (book.author || '-');
                document.getElementById('modalIsbn').innerText = book.isbn || '-';
                document.getElementById('modalCategory').innerText = categoryName;
                document.getElementById('modalStock').innerText = (book.stock ?? 0) + " Eksemplar";
                document.getElementById('modalPrice').innerText = "Rp " + new Intl.NumberFormat('id-ID').format(book.price ?? 0);
                document.getElementById('modalDescription').innerText = book.description || 'Tidak ada deskripsi untuk buku ini.';

                // Logika Penanganan Cover Buku
                const imgTag = document.getElementById('modalCover');
                const noImgTag = document.getElementById('modalNoCover');
                if (book.cover) {
                    imgTag.src = "/storage/" + book.cover;
                    imgTag.classList.remove('hidden');
                    noImgTag.classList.add('hidden');
                } else {
                    imgTag.src = "";
                    imgTag.classList.add('hidden');
                    noImgTag.classList.remove('hidden');
                }

                // Logika Badge Status Stok di Dalam Modal
                const statusDiv = document.getElementById('modalStatus');
                const stockNum = parseInt(book.stock ?? 0);
                let statusHtml = '';
                
                if (stockNum === 0) {
                    statusHtml = '<span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-bold uppercase tracking-widest">Habis</span>';
                } else if (stockNum <= 10) {
                    statusHtml = '<span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-bold uppercase tracking-widest">Stok Rendah</span>';
                } else {
                    statusHtml = '<span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-bold uppercase tracking-widest">Tersedia</span>';
                }
                statusDiv.innerHTML = statusHtml;

                // Tampilkan Modal secara visual
                const modal = document.getElementById('detailModal');
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            });
        });
    });

    function closeDetailModal() {
        const modal = document.getElementById('detailModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    // Menutup modal otomatis jika area luar modal diklik
    window.addEventListener('click', function (event) {
        const modal = document.getElementById('detailModal');
        if (event.target === modal) {
            closeDetailModal();
        }
    });
</script>