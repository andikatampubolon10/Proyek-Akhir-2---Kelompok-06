<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Operator</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
</head>
<body class="bg-gray-100">

@extends('layouts.app')

@section('content')
<div class="flex">
    <!-- Sidebar -->
    <div class="w-1/4 bg-white h-screen shadow-md">
        <div class="flex items-center justify-center py-4">
        <img alt="QuizHub Logo" class="h-12" height="50" src="http://127.0.0.1:8000/storage/images/logo.png">
        </div>
        <div class="px-4">
            <div class="flex items-center space-x-2 py-2">
                <i class="fas fa-user-circle text-2xl text-blue-500"></i>
                <span class="text-blue-500 font-semibold">Operator</span>
            </div>
            <div class="flex items-center space-x-2 py-2">
                <i class="fas fa-briefcase text-2xl text-yellow-500"></i>
                <span class="text-gray-700 font-semibold">Bisnis</span>
            </div>
        </div>
    </div>
    <div class="w-3/4 p-8">
        <div class="flex justify-between items-center mb-8">
            <div class="text-2xl font-bold text-blue-600">Edit Operator</div>
            <div class="flex items-center space-x-2">
                <span class="text-gray-600">Hallo</span>
                <span class="text-blue-600 font-semibold">Admin</span>
                <div class="w-8 h-8 bg-blue-600 rounded-full"></div>
            </div>
        </div>
        <form action="{{ route('admin.updateOperator', $operator->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-gray-700 font-semibold mb-2" for="sekolah">
                    Nama Sekolah
                    <span class="text-red-500">*</span>
                </label>
                <input class="w-full border border-gray-400 p-2 rounded" type="text" name="sekolah" value="{{ old('sekolah', $operator->sekolah) }}" required>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2" for="username">
                    Username
                    <span class="text-red-500">*</span>
                </label>
                <input class="w-full border border-gray-400 p-2 rounded" type="text" name="username" value="{{ old('username', $operator->username) }}" required>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2" for="password">
                    Password
                    <span class="text-red-500">*</span>
                </label>
                <input class="w-full border border-gray-400 p-2 rounded" type="password" name="password">
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2" for="password_confirmation">
                    Konfirmasi Password
                    <span class="text-red-500">*</span>
                </label>
                <input class="w-full border border-gray-400 p-2 rounded" type="password" name="password_confirmation">
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2" for="duration">
                    Durasi (Bulan)
                    <span class="text-red-500">*</span>
                </label>
                <input class="w-full border border-gray-400 p-2 rounded" type="number" name="duration" value="{{ old('duration', $operator->duration) }}" required>
            </div>

            <div class="flex justify-end">
                <button class="bg-green-500 text-white px-4 py-2 rounded flex items-center space-x-2" type="submit">
                    <span>Simpan</span>
                    <i class="fas fa-check"></i>
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

</body>
</html>
