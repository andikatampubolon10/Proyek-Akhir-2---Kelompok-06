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
        <div class="w-full md:w-1/4 bg-gradient-to-r from-blue-600 via-teal-600 to-green-600 h-screen p-4">
            <ul>
                <li class="mb-4">
                    <a class="flex items-center text-white bg-green-500 p-2 rounded-lg shadow hover:bg-green-400"
                        href="#">
                        <i class="fas fa-book mr-4">
                        </i>
                        Course
                    </a>
                </li>
                <li class="mb-4">
                    <a class="flex items-center text-white bg-blue-500 p-2 rounded-lg shadow hover:bg-blue-400"
                        href="#">
                        <i class="fas fa-pencil-alt mr-4">
                        </i>
                        Latihan Soal
                    </a>
                </li>
                <li class="mb-4">
                    <a class="flex items-center text-white bg-green-500 p-2 rounded-lg shadow hover:bg-green-400"
                        href="#">
                        <i class="fas fa-chart-line mr-4">
                        </i>
                        Nilai
                    </a>
                </li>
            </ul>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md h-full w-full">
            <form action="{{ route('Guru.Ujian.update', $ujian->id_ujian) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT') <!-- Menentukan bahwa metode form adalah PUT untuk update -->
                
                <div class="mb-4">
                    <label for="nama_ujian" class="block font-bold mb-2">Judul Ujian</label>
                    <input type="text" name="nama_ujian" value="{{ old('nama_ujian', $ujian->nama_ujian) }}" class="block w-full p-2 border border-gray-300 rounded-md" required>
                </div>
            
                <div class="mb-4">
                    <label for="tipe_ujian" class="block font-bold mb-2">Tipe Ujian</label>
                    <div class="flex items-center space-x-4">
                        <label class="inline-flex items-center">
                            <input type="radio" name="id_tipe_ujian" value="1" class="form-radio text-green-500" {{ $ujian->id_tipe_ujian == 1 ? 'checked' : '' }} required>
                            <span class="ml-2">Kuis</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="id_tipe_ujian" value="2" class="form-radio text-green-500" {{ $ujian->id_tipe_ujian == 2 ? 'checked' : '' }} required>
                            <span class="ml-2">Ujian Tengah Semester</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="id_tipe_ujian" value="2" class="form-radio text-green-500" {{ $ujian->id_tipe_ujian == 3 ? 'checked' : '' }} required>
                            <span class="ml-2">Ujian Akhir Semester</span>
                        </label>
                    </div>
                </div>
            
                <div class="mb-4">
                    <label for="acak" class="block font-bold mb-2">Acak Soal dan Pilihan</label>
                    <select name="acak" class="block w-full p-2 border border-gray-300 rounded-md" required>
                        <option value="Aktif" {{ $ujian->acak == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="Tidak Aktif" {{ $ujian->acak == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>
            
                <div class="mb-4">
                    <label for="status_jawaban" class="block font-bold mb-2">Status Jawaban</label>
                    <select name="status_jawaban" class="block w-full p-2 border border-gray-300 rounded-md" required>
                        <option value="Aktif" {{ $ujian->status_jawaban == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="Tidak Aktif" {{ $ujian->status_jawaban == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>
            
                <div class="mb-4">
                    <label for="grade" class="block font-bold mb-2">Grade</label>
                    <input type="number" name="grade" value="{{ old('grade', $ujian->grade) }}" class="block w-full p-2 border border-gray-300 rounded-md" required>
                </div>
            
                <div class="mb-4">
                    <label for="Waktu_Mulai" class="block font-bold mb-2">Waktu Mulai</label>
                    <input type="datetime-local" name="Waktu_Mulai" value="{{ old('Waktu_Mulai', \Carbon\Carbon::parse($ujian->Waktu_Mulai)->format('Y-m-d\TH:i')) }}" class="block w-full p-2 border border-gray-300 rounded-md" required>
                </div>
            
                <div class="mb-4">
                    <label for="Waktu_Selesai" class="block font-bold mb-2">Waktu Selesai</label>
                    <input type="datetime-local" name="Waktu_Selesai" value="{{ old('Waktu_Selesai', \Carbon\Carbon::parse($ujian->Waktu_Selesai)->format('Y-m-d\TH:i')) }}" class="block w-full p-2 border border-gray-300 rounded-md" required>
                </div>
            
                <div class="flex justify-end mt-4">
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg flex items-center hover:bg-green-400">
                        <span>Simpan</span>
                        <i class="fas fa-check ml-2"></i>
                    </button>
                </div>
            </form>                
        </div>