@extends('layouts.admin')

@section('content')

<div class="flex justify-between items-center mb-6">

    <div>

        <h1 class="text-3xl font-bold">
            Kategori Buku
        </h1>

        <p class="text-gray-500">
            Kelola kategori buku yang tersedia
        </p>

    </div>

</div>

@if(session('success'))

<div class="bg-green-100 text-green-700 p-4 rounded-lg mb-4">
    {{ session('success') }}
</div>

@endif

<!-- FORM TAMBAH -->

<div class="bg-white rounded-xl shadow border p-6 mb-6">

    <h2 class="text-xl font-semibold mb-4">
        Tambah Kategori
    </h2>

    <form action="{{ route('categories.store') }}"
          method="POST">

        @csrf

        <div class="grid grid-cols-2 gap-4">

            <div>

                <label class="block mb-2">
                    Nama Kategori
                </label>

                <input
                    type="text"
                    name="category_name"
                    class="w-full border rounded-lg p-3"
                    required>

            </div>

            <div>

                <label class="block mb-2">
                    Deskripsi
                </label>

                <input
                    type="text"
                    name="description"
                    class="w-full border rounded-lg p-3">

            </div>

        </div>

        <button
            type="submit"
            class="mt-4 bg-blue-900 text-white px-5 py-3 rounded-lg">

            Simpan

        </button>

    </form>

</div>

<!-- TABEL -->

<div class="bg-white rounded-xl shadow border">

    <table class="w-full">

        <thead class="bg-gray-50">

            <tr>

                <th class="p-4 text-left">No</th>
                <th class="p-4 text-left">Nama Kategori</th>
                <th class="p-4 text-left">Deskripsi</th>
                <th class="p-4 text-center">Aksi</th>

            </tr>

        </thead>

        <tbody>

            @forelse($categories as $category)

            <tr class="border-t">

                <td class="p-4">
                    {{ $loop->iteration }}
                </td>

                <td class="p-4">
                    {{ $category->category_name }}
                </td>

                <td class="p-4">
                    {{ $category->description }}
                </td>

                <td class="p-4">

                    <!-- FORM EDIT -->

                    <form
                        action="{{ route('categories.update',$category->id) }}"
                        method="POST"
                        class="flex gap-2">

                        @csrf
                        @method('PUT')

                        <input
                            type="text"
                            name="category_name"
                            value="{{ $category->category_name }}"
                            class="border rounded px-2 py-1">

                        <input
                            type="text"
                            name="description"
                            value="{{ $category->description }}"
                            class="border rounded px-2 py-1">

                        <button
                            type="submit"
                            class="bg-yellow-500 text-white px-3 py-1 rounded">

                            Update

                        </button>

                    </form>

                    <!-- HAPUS -->

                    <form
                        action="{{ route('categories.destroy',$category->id) }}"
                        method="POST"
                        class="mt-2">

                        @csrf
                        @method('DELETE')

                        <button
                            onclick="return confirm('Hapus kategori ini?')"
                            class="bg-red-500 text-white px-3 py-1 rounded">

                            Hapus

                        </button>

                    </form>

                </td>

            </tr>

            @empty

            <tr>

                <td colspan="4"
                    class="text-center p-6 text-gray-500">

                    Belum ada kategori

                </td>

            </tr>

            @endforelse

        </tbody>

    </table>

</div>

@endsection