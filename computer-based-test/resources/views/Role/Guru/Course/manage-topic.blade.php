@extends('layouts.app')

@section('content')
    <div class="max-w-xl mx-auto p-6 bg-white rounded-lg shadow-lg">
        <h2 class="text-2xl font-semibold text-teal-500 mb-4">Manage Topic</h2>
        <form action="#" method="POST">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-gray-700">Nama</label>
                <input type="text" id="name" name="name" class="w-full p-2 border border-gray-300 rounded-lg mt-2" required>
            </div>
            <div class="mb-4">
                <label for="description" class="block text-gray-700">Deskripsi</label>
                <textarea id="description" name="description" class="w-full p-2 border border-gray-300 rounded-lg mt-2" required></textarea>
            </div>
            <button type="submit" class="px-6 py-3 bg-teal-500 text-white rounded-lg shadow-md hover:bg-teal-600 transition duration-200">
                Tambahkan
            </button>
        </form>
    </div>
@endsection
