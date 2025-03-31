<html>

<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body class="bg-gray-100">
    <div class="flex flex-col h-screen">
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
        <div class="flex flex-1">
            <!-- Sidebar -->
            <div class="w-full md:w-1/4 bg-gray-200 h-screen p-4">
                <ul>
                    <li class="mb-4">
                        <a href="{{ route('Admin.Akun.index') }}" class="flex items-center text-gray-700 bg-white p-2 rounded-lg shadow hover:bg-gray-300">
                            <i class="fa-solid fa-circle-user mr-4"></i>
                            Operator
                        </a>
                    </li>
                    <li class="mb-4">
                        <a href="{{ route('Admin.Bisnis.index') }}" class="flex items-center text-gray-700 p-2 rounded-lg hover:bg-gray-300">
                            <i class="fa-solid fa-money-bill-wave mr-4"></i>
                            Bisnis
                        </a>
                    </li>
                </ul>
            </div>
            <!-- Main Content -->
            <div class="w-full lg:w-3/4 p-8">
                <form action="{{ route('Admin.Akun.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Nama Sekolah<span class="text-red-500">*</span></label>
                        <input type="text" name="nama_sekolah" class="w-full border border-gray-400 p-2 rounded-lg" required>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Email<span class="text-red-500">*</span></label>
                        <input type="email" name="email" class="w-full border border-gray-400 p-2 rounded-lg" required>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Password<span class="text-red-500">*</span></label>
                        <input type="password" name="password" class="w-full border border-gray-400 p-2 rounded-lg">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Konfirmasi Password<span class="text-red-500">*</span></label>
                        <input type="password" name="password_confirmation" class="w-full border border-gray-400 p-2 rounded-lg">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Durasi<span class="text-red-500">*</span></label>
                        <input type="number" name="durasi" placeholder="12" class="w-full border border-gray-400 p-2 rounded-lg" required>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg flex items-center">
                            <span>Simpan</span>
                            <i class="fas fa-check ml-2"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="bg-red-500 text-white p-4 rounded-lg mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</body>
<script>
    document.querySelector('.dropdown').addEventListener('click', function() {
        this.querySelector('.dropdown-menu').classList.toggle('hidden');
    });
</script>

</html>