<html>

<head>
    <title>QuizHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />
</head>

<body class="bg-gray-100">
    <!-- Top Bar -->
    <div
        class="bg-gradient-to-r from-blue-500 via-teal-500 to-green-500 shadow p-4 flex justify-between items-center w-full">
        <h1 class="text-2xl font-bold text-white">
            QUIZHUB
        </h1>
        <div class="relative dropdown">
            <div class="flex items-center cursor-pointer" id="profileDropdown">
                <div class="flex flex-col items-center">
                    <span class="text-white">
                        Welcome, Admin
                    </span>
                    <span class="text-white font-semibold">
                        {{ $user->name }} <!-- Menampilkan nama user -->
                    </span>
                </div>
                <img alt="Profile picture of {{ $user->name }}" class="rounded-full ml-4" height="40"
                    src="https://storage.googleapis.com/a1aa/image/KO6yf8wvxyOnH9pvZuXN0ujQxQrH2zDDdLtZaIA-KQ8.jpg"
                    width="40" />
            </div>
            <div class="dropdown-menu absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-2 hidden"
                id="logoutDropdown">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="block px-4 py-2 text-gray-700 hover:bg-gray-100 w-full text-left" type="submit">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="flex flex-col md:flex-row">
        <!-- Sidebar -->
        <div class="w-full md:w-1/4 bg-gradient-to-r from-blue-600 via-teal-600 to-green-600 min-h-screen p-4">
            <ul>
                <li class="mb-4">
                    <a class="flex items-center text-white bg-green-500 p-2 rounded-lg shadow hover:bg-green-400"
                        href="#">
                        <i class="fas fa-book mr-4"></i> Course
                    </a>
                </li>
                <li class="mb-4">
                    <a class="flex items-center text-white bg-blue-500 p-2 rounded-lg shadow hover:bg-blue-400"
                        href="">
                        <i class="fas fa-pencil-alt mr-4"></i> Latihan Soal
                    </a>
                </li>
                <li class="mb-4">
                    <a class="flex items-center text-white bg-green-500 p-2 rounded-lg shadow hover:bg-green-400"
                        href="#">
                        <i class="fas fa-chart-line mr-4"></i> Nilai
                    </a>
                </li>
            </ul>
        </div>

        <div class="flex-1 p-4 bg-gray-200">
            <div class="flex justify-end mb-4">
                <a href="{{ route('Guru.Latihan.create') }}"
                    class="bg-green-500 text-white px-4 py-2 rounded-lg flex items-center hover:bg-green-400">
                    <i class="fas fa-plus mr-2"></i> Tambahkan
                </a>
            </div>
            <div class="bg-white p-4 md:p-6 rounded-lg shadow-md">
                <h1 class="text-lg font-bold mb-4 text-blue-600">Topik Latihan</h1>
                <div class="space-y-4">
                    <div class="mb-4">
                        <label for="kurikulum" class="block text-sm font-medium text-gray-700">Pilih Kurikulum</label>
                        <select id="kurikulum" name="kurikulum"
                            class="mt-1 block w-full border border-gray-300 rounded-md p-2">
                            <option value="">Kurikulum</option>
                            @foreach ($kurikulums as $kurikulum)
                                <option value="{{ $kurikulum->id_kurikulum }}">{{ $kurikulum->nama_kurikulum }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="mata_pelajaran" class="block text-sm font-medium text-gray-700">Pilih Mata
                            Pelajaran</label>
                        <select id="mata_pelajaran" name="mata_pelajaran"
                            class="mt-1 block w-full border border-gray-300 rounded-md p-2">
                            <option value="">Mata Pelajaran</option>
                            @foreach ($mapel as $mata_pelajaran)
                                <option value="{{ $mata_pelajaran->id_mata_pelajaran }}">
                                    {{ $mata_pelajaran->nama_mata_pelajaran }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="kelas" class="block text-sm font-medium text-gray-700">Pilih Kelas</label>
                        <select id="kelas" name="kelas"
                            class="mt-1 block w-full border border-gray-300 rounded-md p-2">
                            <option value="">Kelas</option>
                            @foreach ($kelas as $class)
                                <option value="{{ $class->id_kelas }}">{{ $class->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div id="latihanContainer" class="mt-4">
                    @foreach ($latihan as $item)
                        <div class="mapel-item p-4 bg-white rounded-lg shadow-md mb-4"
                            data-kurikulum="{{ $item->id_kurikulum }}"
                            data-mata_pelajaran="{{ $item->id_mata_pelajaran }}" data-kelas="{{ $item->id_kelas }}">
                            <a href="{{ route('Guru.Soal.index', ['id_latihan' => $item->id_latihan]) }}">
                                <h2 class="text-lg font-bold text-blue-600">{{ $item->Topik }}</h2>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script>
        // Filter by Kurikulum
        document.getElementById('kurikulum').addEventListener('change', function() {
            const selectedKurikulum = this.value;
            const latihanItems = document.querySelectorAll('.mapel-item');

            latihanItems.forEach(item => {
                const itemKurikulum = item.getAttribute('data-kurikulum');
                if (selectedKurikulum === '' || itemKurikulum === selectedKurikulum) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
        });

        // Filter by Mata Pelajaran
        document.getElementById('mata_pelajaran').addEventListener('change', function() {
            const selectedMapel = this.value;
            const latihanItems = document.querySelectorAll('.mapel-item');

            latihanItems.forEach(item => {
                const itemMapel = item.getAttribute('data-mata_pelajaran');
                if (selectedMapel === '' || itemMapel === selectedMapel) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
        });

        // Filter by Kelas
        document.getElementById('kelas').addEventListener('change', function() {
            const selectedKelas = this.value;
            const latihanItems = document.querySelectorAll('.mapel-item');

            latihanItems.forEach(item => {
                const itemKelas = item.getAttribute('data-kelas');
                if (selectedKelas === '' || itemKelas === selectedKelas) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    </script>
</body>

</html>
