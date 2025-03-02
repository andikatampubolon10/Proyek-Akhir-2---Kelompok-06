<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Operator</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
</head>
<body class="bg-gray-100">

@extends('layouts.app')

@section('content')
<div class="flex">
    <div class="w-1/5 bg-white h-screen p-4">
        <div class="flex items-center mb-8">
        <img alt="QuizHub Logo" class="h-12" height="50" src="http://127.0.0.1:8000/storage/images/logo.png">
        </div>
        <div class="mb-4">
            <button class="flex items-center w-full p-2 text-left text-white bg-blue-600 rounded">
                <i class="fas fa-user-circle mr-2"></i>
                <span>Operator</span>
            </button>
        </div>
        <div>
        <a href="{{ route('admin.bisnisDashboard') }}">
            <button class="flex items-center w-full p-2 text-left text-gray-700 bg-yellow-400 rounded">
                <i class="fas fa-briefcase mr-2"></i>
                <span>Bisnis</span>
            </button>
        </a>
        </div>
    </div>
    <div class="w-4/5 p-8">
        <div class="flex justify-between items-center mb-4">
            <div></div>
            <div class="flex items-center">
                <span class="mr-2">Hallo Admin</span>
                <div class="w-8 h-8 bg-blue-600 rounded-full"></div>
            </div>
        </div>
        <div class="flex justify-end mb-4">
            <a href="{{ route('admin.createOperator') }}">
                <button class="flex items-center px-4 py-2 text-white bg-green-500 rounded">
                    <i class="fas fa-plus-circle mr-2"></i>
                    <span>Tambah Operator</span>
                </button>
            </a>
        </div>
        <table class="w-full bg-white rounded shadow">
            <thead class="bg-blue-600 text-white">
                <tr>
                    <th class="p-2">No</th>
                    <th class="p-2">Sekolah</th>
                    <th class="p-2">Username</th>
                    <th class="p-2">Status</th>
                    <th class="p-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($operators as $operator)
                <tr class="border-b">
                    <td class="p-2 text-center">{{ $loop->iteration }}</td>
                    <td class="p-2 text-center">{{ $operator->sekolah }}</td>
                    <td class="p-2 text-center">{{ $operator->username }}</td>
                    <td class="p-2 text-center">{{ $operator->status }}</td>
                    <td class="p-2 text-center">
                        <a href="{{ route('admin.editOperator', $operator->id) }}">
                            <button class="px-4 py-2 text-white bg-yellow-400 rounded mr-2">
                                Edit
                            </button>
                        </a>
                        <button class="px-4 py-2 text-white bg-red-500 rounded" onclick="deleteOperator({{ $operator->id }})">
                            Hapus
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection

<script>
    function deleteOperator(operatorId) {
        if (confirm('Apakah Anda yakin ingin menghapus operator ini?')) {
            fetch(`/admin/operators/${operatorId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Operator berhasil dihapus!');
                    location.reload(); // Reload halaman untuk melihat perubahan
                } else {
                    alert('Gagal menghapus operator!');
                }
            })
            .catch(error => console.error('Error:', error));
        }
    }
</script>

</body>
</html>
