<html>

<head>
    <title>
        QuizHub
    </title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />
</head>

<body class="bg-gray-100">
    <!-- Top Bar -->
    <div
        class="bg-gradient-to-r from-blue-500 via-teal-500 to-green-500 shadow p-4 flex justify-between items-center w-full">
        <h1 class="text-2xl font-bold text-white">QUIZHUB</h1>
        <div class="relative dropdown">
            <div class="flex items-center cursor-pointer" id="profileDropdown">
                <div class="flex flex-col items-center">
                    <span class="text-white">
                        Welcome, Admin
                    </span>
                    <span class="text-white font-semibold">
                        {{ $user->name }}
                    </span>
                </div>
                <img alt="Profile picture" class="rounded-full ml-4" height="40"
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
                        href="#">
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

        <!-- Content Area -->
        <div class="w-full bg-white p-6 shadow-md">
            <h2 class="text-xl font-semibold mb-4">
                Course Content
            </h2>

            <div class="flex justify-end mb-4">
                <a href="{{ route('Guru.Materi.create') }}"
                    class="bg-green-500 text-white px-4 py-2 rounded-lg flex items-center">
                    <i class="fas fa-plus mr-2"></i> Tambahkan
                </a>
            </div>

            <div class="border-b border-gray-300 mb-4"></div>

            @foreach ($materi->groupBy(function ($date) {
                return \Carbon\Carbon::parse($date->tanggal_materi)->format('d M Y');
            }) as $date => $materiGroup)
                <div class="p-4 border rounded-lg mb-4 bg-white">
                    <h3 class="text-xl font-bold mb-2">{{ $date }}</h3>

                    @foreach ($materiGroup as $materi)
                        <div class="flex justify-between items-center p-4 border rounded-lg mb-4">
                            <div class="flex items-center">
                                <h4 class="text-lg font-semibold">{{ $materi->judul_materi }}</h4>
                            </div>

                            <!-- Menampilkan deskripsi materi -->
                            <p class="text-sm text-gray-600 mb-2">{{ $materi->deskripsi }}</p>

                            <!-- Menampilkan link download file materi -->
                            @if ($materi->file)
                                <p class="text-blue-600 mt-2">
                                    <a href="{{ Storage::url($materi->file) }}" target="_blank" class="hover:underline">Download Materi</a>
                                </p>
                            @else
                                <p class="text-red-500">Tidak ada file yang di-upload.</p>
                            @endif

                            <div class="flex justify-end space-x-3">
                                <form action="{{ route('Guru.Materi.edit', $materi->id_materi) }}" method="GET">
                                    <button type="submit" class="text-blue-500 flex items-center hover:text-blue-700">
                                        <i class="fas fa-edit mr-1"></i> Edit
                                    </button>
                                </form>

                                <!-- Tombol hapus materi -->
                                <form action="{{ route('Guru.Materi.destroy', $materi->id_materi) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus materi ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 flex items-center hover:text-red-700">
                                        <i class="fas fa-trash-alt mr-1"></i> DELETE
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>

    <script>
        document.getElementById('profileDropdown').addEventListener('click', function() {
            document.getElementById('logoutDropdown').classList.toggle('hidden');
        });
    </script>
</body>

</html>
