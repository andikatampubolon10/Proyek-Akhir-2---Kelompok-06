<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QuizHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        /* Custom dropdown styles */
        .dropdown:hover .dropdown-menu {
            display: block;
        }
    </style>
</head>

<body class="bg-gray-100">
    <!-- Header -->
    <div class="bg-gradient-to-r from-blue-600 via-teal-600 to-green-600 shadow p-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-white">Kelas</h1>
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
        <div class="w-full md:w-1/4 bg-gradient-to-r from-blue-600 via-teal-600 to-green-600 min-h-screen p-4">
            <ul>
                <li class="mb-4">
                    <a href="{{ route('Operator.Kelas.index') }}" class="flex items-center text-white p-2 rounded-lg hover:bg-blue-500">
                        <i class="fas fa-home text-white mr-2"></i>
                        Kelas
                    </a>
                </li>
                <li class="mb-4">
                    <a href="{{ route('Operator.Siswa.index') }}" class="flex items-center text-white p-2 rounded-lg hover:bg-blue-500">
                        <i class="fas fa-user-graduate text-white mr-2"></i>
                        Daftar Siswa
                    </a>
                </li>
                <li class="mb-4">
                    <a href="{{ route('Operator.Guru.index') }}" class="flex items-center text-white p-2 rounded-lg hover:bg-blue-500">
                        <i class="fas fa-chalkboard-teacher text-white mr-2"></i>
                        Daftar Guru
                    </a>
                </li>
                <li class="mb-4">
                    <a href="{{ route('Operator.Kurikulum.index') }}" class="flex items-center text-white p-2 rounded-lg hover:bg-blue-500">
                        <i class="fas fa-calendar-alt text-white mr-2"></i>
                        Kurikulum
                    </a>
                </li>
                <li class="mb-4">
                    <a href="#" class="flex items-center text-white bg-blue-500 p-2 rounded-lg shadow">
                        <i class="fas fa-book text-white mr-2"></i>
                        Mata Pelajaran
                    </a>
                </li>
            </ul>
        </div>
        <!-- Main Content -->
        <div class="flex-1 p-4 bg-gray-200">
            <div class="flex justify-end mb-4">
                <a href="{{ route('Operator.MataPelajaran.create') }}"
                    class="bg-green-500 text-white px-4 py-2 rounded-lg flex items-center hover:bg-green-400">
                    <i class="fas fa-plus mr-2"></i> Tambahkan
                </a>
            </div>
            <div class="bg-white p-4 md:p-6 rounded-lg shadow-md">
                <h1 class="text-lg font-bold mb-4 text-blue-600">Subject Information</h1>
                <div class="space-y-4">
                    <div class="mb-4">
                        <label for="kurikulum" class="block text-sm font-medium text-gray-700">Pilih Kurikulum</label>
                        <select id="kurikulum" name="kurikulum"
                            class="mt-1 block w-full border border-gray-300 rounded-md p-2">
                            <option value="">Semua Kurikulum</option>
                            @foreach ($kurikulums as $kurikulum)
                                <option value="{{ $kurikulum->id_kurikulum }}">{{ $kurikulum->nama_kurikulum }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div id="mapel-list">
                        @foreach ($mataPelajarans as $mapel)
                            <div class="bg-gray-300 p-4 rounded flex justify-between items-center mb-4 mapel-item"
                                data-kurikulum="{{ $mapel->id_kurikulum }}">
                                <span class="text-lg text-blue-600">{{ $mapel->nama_mata_pelajaran }}</span>
                                <a href="{{ route('Operator.MataPelajaran.edit', $mapel->id_mata_pelajaran) }}"
                                    class="text-gray-500 flex items-center hover:text-gray-700">
                                    <i class="fas fa-pen mr-1"></i> EDIT
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <script>
            document.getElementById('kurikulum').addEventListener('change', function() {
                const selectedKurikulum = this.value;
                const mapelItems = document.querySelectorAll('.mapel-item');

                mapelItems.forEach(item => {
                    const itemKurikulum = item.getAttribute('data-kurikulum');
                    if (selectedKurikulum === '' || itemKurikulum === selectedKurikulum) {
                        item.style.display = 'flex';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });

            document.querySelector('.dropdown').addEventListener('click', function() {
                this.querySelector('.dropdown-menu').classList.toggle('hidden');
            });
        </script>
</body>

</html>