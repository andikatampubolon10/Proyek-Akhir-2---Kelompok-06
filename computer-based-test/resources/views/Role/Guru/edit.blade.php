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
                        {{ $user->name }}
                    </span>
                </div>
                <img alt="Profile picture of Natan Hutahean" class="rounded-full ml-4" height="40"
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
        <div class="sidebar">
            <a
                href="{{ route('Guru.Course.index') }}"class="d-flex align-items-center text-gray-700 p-2 rounded-lg hover:bg-gray-300">
                <i class="fas fa-book-open text-sm"></i>
                <span>Course</span>
            </a>
            <a
                href="{{ route('Guru.Latihan.index') }}"class="d-flex align-items-center text-gray-700 p-2 rounded-lg hover:bg-gray-300">
                <i class="fas fa-pen text-sm"></i>
                <span>Latihan Soal</span>
            </a>

            <a
                href="{{ route('Guru.Nilai.index') }}"class="d-flex align-items-center text-gray-700 p-2 rounded-lg hover:bg-gray-300">
                <i class="fas fa-chart-line text-sm"></i>
                <span>Nilai</span>
            </a>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md h-full w-full">
            <form action="{{ route('Guru.Course.update', $course->id_kursus) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="nama_kursus" class="block font-bold mb-2">Nama Kursus</label>
                    <!-- Isi input dengan nilai kursus yang sudah ada -->
                    <input type="text" value="{{ old('nama_kursus', $course->nama_kursus) }}" name="nama_kursus" class="block w-full p-2 border border-gray-300 rounded-md" required>
                </div>
                <div class="mb-4">
                    <label for="image" class="block font-bold mb-2">Pilih Gambar</label>
                    <!-- Jika ada gambar sebelumnya, tampilkan -->
                    <input type="file" name="image" class="block w-full p-2 border border-gray-300 rounded-md">
                    @if ($course->image)
                        <img src="{{ asset('images/' . $course->image) }}" alt="Current Image" class="mt-2 w-32">
                    @endif
                </div>
                <div class="flex justify-end mt-4">
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg flex items-center hover:bg-green-400">
                        <span>Simpan</span>
                        <i class="fas fa-check ml-2"></i>
                    </button>
                </div>
            </form>            
        </div>