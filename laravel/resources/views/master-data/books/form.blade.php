@extends('layouts.admin')

@section('content')

<div class="max-w-5xl mx-auto">
    {{-- Breadcrumb & Header --}}
    <div class="mb-8">
        <nav class="flex items-center gap-1 text-sm text-gray-500 mb-2">
            <span>Master Data</span>
            <span class="material-symbols-outlined text-sm">chevron_right</span>
            <a href="{{ route('books.index') }}" class="hover:text-blue-900 transition-colors">Daftar Buku</a>
            <span class="material-symbols-outlined text-sm">chevron_right</span>
            <span class="text-blue-900 font-semibold">{{ isset($book) ? 'Edit Buku' : 'Tambah Buku Baru' }}</span>
        </nav>
        
        <h1 class="text-4xl font-bold text-slate-900">
            {{ isset($book) ? 'Edit Buku' : 'Tambah Buku Baru' }}
        </h1>
        <p class="text-gray-500 mt-2">Pastikan semua informasi buku sudah sesuai dengan database fisik.</p>
    </div>

    <form action="{{ isset($book) ? route('books.update', $book->id) : route('books.store') }}" 
          method="POST" 
          enctype="multipart/form-data">
        @csrf
        @if(isset($book)) @method('PUT') @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- KOLOM KIRI: UPLOAD COVER --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm sticky top-8" x-data="{ photoPreview: null }">
                    <h2 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined text-blue-900">image</span>
                        Cover Buku
                    </h2>
                    
                    <div class="relative group">
                        {{-- Preview Box --}}
                        <div class="w-full aspect-[3/4] rounded-xl bg-slate-50 border-2 border-dashed border-slate-200 overflow-hidden flex items-center justify-center relative">
                            @if(isset($book) && $book->cover)
                                <img src="{{ asset('storage/'.$book->cover) }}" class="w-full h-full object-cover">
                            @else
                                <div class="text-center p-4" x-show="!photoPreview">
                                    <span class="material-symbols-outlined text-slate-300 text-5xl">add_photo_alternate</span>
                                    <p class="text-xs text-slate-400 mt-2">Format: JPG, PNG (Maks. 2MB)</p>
                                </div>
                            @endif
                            
                            {{-- Alpine Preview --}}
                            <template x-if="photoPreview">
                                <img :src="photoPreview" class="absolute inset-0 w-full h-full object-cover rounded-xl">
                            </template>
                        </div>

                        {{-- Hidden Input --}}
                        <input type="file" name="cover" class="hidden" id="coverInput" 
                               @change="const file = $event.target.files[0]; if (file) { const reader = new FileReader(); reader.onload = (e) => { photoPreview = e.target.result; }; reader.readAsDataURL(file); }">
                        
                        <label for="coverInput" class="mt-4 w-full flex items-center justify-center gap-2 py-2 px-4 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg cursor-pointer transition-all font-semibold text-sm">
                            <span class="material-symbols-outlined text-sm">upload</span>
                            {{ isset($book) ? 'Ganti Cover' : 'Pilih Gambar' }}
                        </label>
                    </div>
                    
                    @error('cover') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- KOLOM KANAN: DETAIL DATA --}}
            <div class="lg:col-span-2 space-y-6">
                
                {{-- Card Utama --}}
                <div class="bg-white rounded-2xl border border-slate-200 p-8 shadow-sm">
                    <h2 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
                        <span class="material-symbols-outlined text-blue-900">description</span>
                        Detail Informasi Pustaka
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Kategori --}}
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-slate-700 mb-2">Kategori Buku</label>
                            <select name="category_id" class="w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 p-3 bg-slate-50">
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $book->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                        {{ $category->category_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- ISBN --}}
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Nomor ISBN</label>
                            <input type="text" name="isbn" value="{{ old('isbn', $book->isbn ?? '') }}" 
                                   class="w-full rounded-xl border-slate-200 p-3" placeholder="Contoh: 978-602-03...">
                        </div>

                        {{-- Tahun --}}
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Tahun Terbit</label>
                            <input type="number" name="publication_year" value="{{ old('publication_year', $book->publication_year ?? '') }}" 
                                   class="w-full rounded-xl border-slate-200 p-3" placeholder="YYYY">
                        </div>

                        {{-- Judul --}}
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-slate-700 mb-2">Judul Lengkap Buku</label>
                            <input type="text" name="title" value="{{ old('title', $book->title ?? '') }}" 
                                   class="w-full rounded-xl border-slate-200 p-3" placeholder="Masukkan judul buku">
                        </div>

                        {{-- Penulis --}}
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Penulis</label>
                            <input type="text" name="author" value="{{ old('author', $book->author ?? '') }}" 
                                   class="w-full rounded-xl border-slate-200 p-3" placeholder="Nama lengkap penulis">
                        </div>

                        {{-- Penerbit --}}
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Penerbit</label>
                            <input type="text" name="publisher" value="{{ old('publisher', $book->publisher ?? '') }}" 
                                   class="w-full rounded-xl border-slate-200 p-3" placeholder="Nama perusahaan penerbit">
                        </div>

                        {{-- Harga --}}
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2 text-blue-900">Harga Satuan (Rp)</label>
                            <input type="number" name="price" value="{{ old('price', $book->price ?? '') }}" 
                                   class="w-full rounded-xl border-blue-100 bg-blue-50/30 p-3 font-semibold" placeholder="0">
                        </div>

                        {{-- Stok --}}
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Jumlah Stok</label>
                            <input type="number" name="stock" value="{{ old('stock', $book->stock ?? '') }}" 
                                   class="w-full rounded-xl border-slate-200 p-3" placeholder="0">
                        </div>
                    </div>

                    {{-- Deskripsi --}}
                    <div class="mt-6">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Sinopsis / Deskripsi Buku</label>
                        <textarea name="description" rows="5" 
                                  class="w-full rounded-xl border-slate-200 p-3" 
                                  placeholder="Tuliskan ringkasan buku di sini...">{{ old('description', $book->description ?? '') }}</textarea>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex items-center justify-end gap-4 bg-slate-50 p-4 rounded-2xl border border-dashed border-slate-200">
                    <a href="{{ route('books.index') }}" 
                       class="px-6 py-3 text-sm font-bold text-slate-500 hover:text-slate-700 transition-colors">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-8 py-3 bg-blue-900 text-white rounded-xl font-bold shadow-lg shadow-blue-900/20 hover:bg-blue-800 active:scale-95 transition-all flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">check_circle</span>
                        {{ isset($book) ? 'Simpan Perubahan' : 'Daftarkan Buku' }}
                    </button>
                </div>

            </div>
        </div>
    </form>
</div>

@endsection