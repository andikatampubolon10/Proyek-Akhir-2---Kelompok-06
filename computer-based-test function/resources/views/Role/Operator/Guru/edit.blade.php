<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QuizHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        /* Custom dropdown styles */
        .dropdown-menu {
            display: none;
        }

        .dropdown.open .dropdown-menu {
            display: block;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelector('.dropdown').addEventListener('click', function() {
                this.querySelector('.dropdown-menu').classList.toggle('hidden');
            });
        });
    </script>
</head>

<body class="bg-gray-100">
    <!-- Header -->
    <div class="flex flex-col h-screen">
        <!-- Top Bar -->
        <div class="bg-gradient-to-r from-blue-500 via-teal-500 to-green-500 shadow p-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-white">QUIZHUB</h1>
            <div class="relative dropdown">
                <div class="flex items-center cursor-pointer">
                    <div class="flex flex-col items-center">
                        <span class="text-white">Welcome, Operator</span>
                        <span class="text-white font-semibold">{{ $user->name }}</span>
                    </div>
                    <img alt="Profile picture of Natan Hutahean" class="rounded-full ml-4" height="40"
                        src="https://storage.googleapis.com/a1aa/image/sG3g-w8cayIo0nXWyycQx8dmzPb0_0-Zc6iv6Fls36s.jpg"
                        width="40">
                </div>
                <div class="dropdown-menu absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-2 hidden">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="block px-4 py-2 text-gray-700 hover:bg-gray-100 w-full text-left">Logout</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="flex flex-col md:flex-row">
            <!-- Sidebar -->
            <div class="w-full md:w-1/4 bg-gradient-to-r from-blue-600 via-teal-600 to-green-600 h-screen p-4">
                <ul>
                    <li class="mb-4">
                        <a href="{{ route('Operator.Kelas.index') }}"
                            class="flex items-center text-white p-2 rounded-lg hover:bg-blue-500">
                            <i class="fas fa-home text-white mr-2"></i>
                            Kelas
                        </a>
                    </li>
                    <li class="mb-4">
                        <a href="{{ route('Operator.Siswa.index') }}"
                            class="flex items-center text-white p-2 rounded-lg hover:bg-blue-500">
                            <i class="fas fa-user-graduate text-white mr-2"></i>
                            Daftar Siswa
                        </a>
                    </li>
                    <li class="mb-4">
                        <a href="#" class="flex items-center text-white bg-blue-500 p-2 rounded-lg shadow">
                            <i class="fas fa-chalkboard-teacher text-white mr-2"></i>
                            Daftar Guru
                        </a>
                    </li>
                    <li class="mb-4">
                        <a href="{{ route('Operator.Kurikulum.index') }}"
                            class="flex items-center text-white p-2 rounded-lg hover:bg-blue-500">
                            <i class="fas fa-calendar-alt text-white mr-2"></i>
                            Kurikulum
                        </a>
                    </li>
                    <li class="mb-4">
                        <a href="{{ route('Operator.MataPelajaran.index') }}"
                            class="flex items-center text-white p-2 rounded-lg hover:bg-blue-500">
                            <i class="fas fa-book text-white mr-2"></i>
                            Mata Pelajaran
                        </a>
                    </li>
                </ul>
            </div>
            <!-- Main Content -->
            <div class="w-full md:w-4/5 p-4 flex justify-center items-start">
                <div class="w-full">
                    <form action="{{ route('Operator.Guru.update', $gurus->id) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PATCH')
                        <div class="mb-4">
                            <label class="block font-bold mb-2">NIP</label>
                            <input name="nip" value="{{($gurus->nip)}}" type="text" class="block w-full p-2 border border-gray-300 rounded-md">
                        </div>
                        <div class="mb-4">
                            <label class="block font-bold mb-2">Nama Guru</label>
                            <input name="name" value="{{ ($gurus->name) }}" type="text" class="block w-full p-2 border border-gray-300 rounded-md">
                        </div>
                        <div class="mb-4">
                            <label class="block font-bold mb-2">Password</label>
                            <input name="password" type="password" class="block w-full p-2 border border-gray-300 rounded-md">
                        </div>
                        <div class="mb-4">
                            <label class="block font-bold mb-2">Konfirmasi Password</label>
                            <input name="password_confirmation" type="password" class="block w-full p-2 border border-gray-300 rounded-md">
                        </div>
                        <div class="flex justify-end">
                            <button type="submit"
                                class="bg-green-500 text-white px-4 py-2 rounded-lg flex items-center hover:bg-green-400">
                                <span>Simpan</span>
                                <i class="fas fa-check ml-2"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>