<html>

<head>
    <title>QuizHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body class="bg-gray-100">
    <!-- Top Bar -->
    <div class="bg-gradient-to-r from-blue-500 via-teal-500 to-green-500 shadow p-4 flex justify-between items-center w-full">
        <h1 class="text-2xl font-bold text-white">QUIZHUB</h1>
        <div class="relative dropdown">
            <div class="flex items-center cursor-pointer">
                <div class="flex flex-col items-center">
                    <span class="text-white">Welcome, Admin</span>
                    <span class="text-white font-semibold">Kelompok 06</span>
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
                    <a href="{{ route('Admin.Akun.index') }}" class="flex items-center text-white bg-blue-500 p-2 rounded-lg shadow hover:bg-blue-400">
                        <i class="fa-solid fa-circle-user mr-4"></i>
                        Operator
                    </a>
                </li>
                <li class="mb-4">
                    <a href="#" class="flex items-center text-white bg-green-500 p-2 rounded-lg shadow hover:bg-green-400">
                        <i class="fa-solid fa-money-bill-wave mr-4"></i>
                        Bisnis
                    </a>
                </li>
            </ul>
        </div>
        <!-- Main Content -->
        <div class="w-full md:w-3/4 p-4 md:p-8">
            <!-- Action Button -->
            <div class="flex justify-end mb-4">
                <a href="{{ route('Admin.Bisnis.create') }}"
                    class="bg-green-500 text-white px-4 py-2 rounded-lg flex items-center">
                    <i class="fas fa-plus mr-2"></i> Tambahkan
                </a>
            </div>
            <div class="bg-white p-4 md:p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-bold mb-4 text-blue-600">Bisnis Information</h2>
                <div class="space-y-4">
                    @foreach ($bisnises as $bisnis)
                    <div class="bg-gray-100 p-4 rounded-lg flex flex-col md:flex-row justify-between items-start md:items-center">
                        <div class="mb-4 md:mb-0">
                            <h3 class="font-bold text-blue-600">{{ $bisnis->name }}</h3>
                            <p class="text-gray-600">Nama Sekolah: {{ $bisnis ->nama_sekolah }}</p>
                            <p class="text-gray-600">Jumlah Pendapatan : {{ $bisnis->jumlah_pendapatan }}</p>
                        </div>
                        <div class="flex space-x-5">
                            <div>
                                <form action="{{ route('Admin.Bisnis.destroy', $bisnis->id_bisnis) }}" method="POST"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 flex items-center">
                                        <i class="fas fa-trash-alt mr-1"></i> DELETE
                                    </button>
                                </form>
                            </div>
                            <div>
                                <form action="{{ route('Admin.Bisnis.edit', $bisnis->id_bisnis) }}" method="GET">
                                    <button type="submit" class="text-blue-500 flex items-center">
                                        <i class="fas fa-edit mr-1"></i> EDIT
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
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