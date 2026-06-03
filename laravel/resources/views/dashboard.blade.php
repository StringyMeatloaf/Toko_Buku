@extends('layouts.admin')

@section('content')

<h2 class="text-2xl font-bold mb-6">
    Dashboard
</h2>

<div class="grid grid-cols-4 gap-6">

    <div class="bg-white rounded-xl shadow p-6">
        <h3 class="text-gray-500">Total Judul Buku</h3>
        <p class="text-3xl font-bold mt-2">0</p>
    </div>

    <div class="bg-white rounded-xl shadow p-6">
        <h3 class="text-gray-500">Total Buku Masuk</h3>
        <p class="text-3xl font-bold mt-2">0</p>
    </div>

    <div class="bg-white rounded-xl shadow p-6">
        <h3 class="text-gray-500">Total Buku Terjual</h3>
        <p class="text-3xl font-bold mt-2">0</p>
    </div>

    <div class="bg-white rounded-xl shadow p-6">
        <h3 class="text-gray-500">Total Stok</h3>
        <p class="text-3xl font-bold mt-2">0</p>
    </div>

</div>

@endsection