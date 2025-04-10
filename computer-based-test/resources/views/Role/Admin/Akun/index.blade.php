<html>

<head>
    <title>Operator</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body class="bg-gray-100">
    <div class="flex flex-col">
        <!-- Top Bar -->
        <div class="bg-white shadow p-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-teal-500">QUIZHUB</h1>
            <div class="relative dropdown">
                <div class="flex items-center cursor-pointer">
                    <div class="flex flex-col items-center">
                        <span class="text-teal-500">Welcome, Admin</span>
                        <span class="text-teal-500 font-semibold">Kelompok 06</span>
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
                        <a href="#"
                            class="flex items-center text-gray-700 bg-white p-2 rounded-lg shadow hover:bg-gray-300">
                            <i class="fa-solid fa-circle-user mr-4"></i>
                            Operator
                        </a>
                    </li>
                    <li class="mb-4">
                        <a href="{{ route('Admin.Bisnis.index') }}"
                            class="flex items-center text-gray-700 p-2 rounded-lg hover:bg-gray-300">
                            <i class="fa-solid fa-money-bill-wave mr-4"></i>
                            Bisnis
                        </a>
                    </li>
                </ul>
            </div>
            <!-- Main Content -->
            <div class="w-full md:w-4/5 p-4 md:p-8">
                <div class="flex justify-end mb-4">
                    <a href="{{ route('Admin.Akun.create') }}"
                        class="bg-green-500 text-white px-4 py-2 rounded-lg flex items-center">
                        <i class="fas fa-plus mr-2"></i> Tambahkan
                    </a>
                </div>
                <div class="bg-white p-4 md:p-6 rounded-lg shadow-md">
                    <h2 class="text-xl font-bold mb-4">Operator Information</h2>
                    <div class="space-y-4">
                        @foreach ($operators as $operator)
                            <div
                                class="bg-gray-300 p-4 rounded-lg flex flex-col md:flex-row justify-between items-start md:items-center">
                                <div class="mb-4 md:mb-0">
                                    <h3 class="font-bold">{{ $operator['nama_sekolah'] }}</h3>
                                    <p>Email   : {{ $operator->user['email'] }}</p>
                                    <p>Durasi : {{ $operator['durasi'] }}</p>
                                    <p>Status Aktif : {{ $operator['status'] }}</p>
                                </div>
                                <div class="flex space-x-5">
                                    <div>
                                        <form action="{{ route('Admin.Akun.destroy', $operator->id_operator) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 flex items-center">
                                                <i class="fas fa-trash-alt mr-1"></i> DELETE
                                            </button>
                                        </form>
                                    </div>
                                    <div>
                                        <form action="{{ route('Admin.Akun.edit', $operator->user->id) }}" method="GET">
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
    </div>
</body>
<script>
    document.querySelector('.dropdown').addEventListener('click', function() {
        this.querySelector('.dropdown-menu').classList.toggle('hidden');
    });
</script>

</html>
