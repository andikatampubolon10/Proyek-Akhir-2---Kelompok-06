<html>

<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body class="bg-gray-100">
    <div class="flex flex-col h-screen">
        <!-- Top Bar -->
        <div class="bg-gradient-to-r from-blue-500 via-teal-500 to-green-500 shadow p-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-white">QUIZHUB</h1>
            <div class="relative dropdown">
                <div class="flex items-center cursor-pointer">
                    <div class="flex flex-col items-center">
                        <span class="text-white">Welcome, Admin</span>
                        <span class="text-white font-semibold">Kelompok 06</span>
                    </div>
                    <img alt="Profile picture of Natan Hutahean" class="rounded-full ml-4" height="40"
                        src="https://storage.googleapis.com/a1aa/image/SygB_B8OD6HL7ktN3fTTBU9u-dB07RcjrX94oROPEDA.jpg"
                        width="40">
                </div>
                <div class="dropdown-menu absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-2 hidden">
                    <form action="#" method="POST">
                        <button type="submit"
                            class="block px-4 py-2 text-gray-700 hover:bg-gray-100 w-full text-left">Logout</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="flex flex-1 flex-col md:flex-row">
            <!-- Sidebar -->
            <div class="w-full md:w-1/4 bg-gradient-to-r from-blue-600 via-teal-600 to-green-600 h-auto md:h-screen p-4">
                <ul>
                    <li class="mb-4">
                        <a href="#" class="flex items-center text-white bg-blue-500 p-2 rounded-lg shadow hover:bg-blue-400">
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
            <div class="w-full md:w-3/4 p-8">
                <form action="{{ route('Admin.Bisnis.update', ['id_bisnis' => $bisnis->id_bisnis]) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Nama Sekolah<span class="text-red-500">*</span></label>
                        <input name="nama" value="{{ $bisnis->nama_sekolah }}" type="text" class="w-full border border-gray-400 p-2 rounded-lg" required>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Jumlah Pendapatan<span class="text-red-500">*</span></label>
                        <input name="jumlah_pendapatan" value="{{ $bisnis->jumlah_pendapatan }}" type="text" class="w-full border border-gray-400 p-2 rounded-lg" required>
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
    <script>
        document.querySelector('.dropdown').addEventListener('click', function() {
            this.querySelector('.dropdown-menu').classList.toggle('hidden');
        });
    </script>
</body>

</html>