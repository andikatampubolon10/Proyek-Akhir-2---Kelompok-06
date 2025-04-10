<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Operator | Kelas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        .dropdown:hover .dropdown-menu {
            display: block;
        }
    </style>
</head>

<body class="bg-gray-100">
    <!-- Header -->
    <div class="bg-white shadow p-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-teal-500">QUIZHUB</h1>
        <div class="relative dropdown">
            <div class="flex items-center cursor-pointer">
                <div class="flex flex-col items-center">
                    <span class="text-teal-500">Welcome, Operator</span>
                    <span class="text-teal-500 font-semibold">{{ $user->name }}</span>
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
        <div class="w-full md:w-1/4 bg-gray-200 h-screen p-4">
            <ul>
                <li class="mb-4">
                    <a href="{{ route('Operator.Siswa.index') }}"
                        class="flex items-center text-gray-700 p-2 rounded-lg">
                        <i class="fas fa-user-graduate text-teal-500 mr-2"></i>
                        Daftar Siswa
                    </a>
                </li>
                <li class="mb-4">
                    <a href="{{ route('Operator.Guru.index') }}" class="flex items-center text-gray-700 p-2 rounded-lg">
                        <i class="fas fa-chalkboard-teacher text-teal-500 mr-2"></i>
                        Daftar Guru
                    </a>
                </li>
                <li class="mb-4">
                    <a href="{{ route('Operator.MataPelajaran.index') }}"
                        class="flex items-center text-gray-700 p-2 rounded-lg">
                        <i class="fas fa-book text-teal-500 mr-2"></i>
                        Mata Pelajaran
                    </a>
                </li>
                <li class="mb-4">
                    <a href="#" class="flex items-center text-gray-700 bg-white p-2 rounded-lg shadow">
                        <i class="fas fa-home text-teal-500 mr-2"></i>
                        Kelas
                    </a>
                </li>
                <li class="mb-4">
                    <a href="{{ route('Operator.Kurikulum.index') }}"
                        class="flex items-center text-gray-700 p-2 rounded-lg">
                        <i class="fas fa-calendar-alt text-teal-500 mr-2"></i>
                        Kurikulum
                    </a>
                </li>
            </ul>
        </div>
        <!-- Main Content -->
        <div class="flex-1 p-4">
            <div class="flex justify-end mb-4">
                <a href="{{ route('Operator.Kelas.create') }}"
                    class="bg-green-500 text-white px-4 py-2 rounded-lg flex items-center">
                    <i class="fas fa-plus mr-2"></i> Tambahkan
                </a>
            </div>
            <h1 class="text-lg font-bold mb-4">Class Information</h1>
            <div class="space-y-4">
                @foreach ($kelas as $kelases)
                    <div class="bg-gray-300 p-4 rounded flex justify-between items-center">
                        <h4 class="text-lg text-gray-700">{{ $kelases->nama_kelas }}</h4>
                        <a href="{{ route('Operator.Kelas.edit', $kelases->id_kelas) }}"
                            class="text-gray-500 flex items-center">
                            <i class="fas fa-pen mr-1"></i> EDIT
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <script>
        document.querySelector('.dropdown').addEventListener('click', function() {
            this.querySelector('.dropdown-menu').classList.toggle('hidden');
        });
    </script>
</body>

</html>
