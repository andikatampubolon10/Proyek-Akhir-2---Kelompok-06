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
                        Welcome, Guru
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
            <form action="{{ route('Guru.Ujian.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="nama_ujian" class="block font-bold mb-2">Judul Ujian</label>
                    <input type="text" name="nama_ujian" class="block w-full p-2 border border-gray-300 rounded-md"
                        required>
                </div>

                <div class="mb-6">
                    <label class="block text-lg font-semibold mb-2">Tipe Ujian</label>
                    <div class="flex items-center space-x-4">
                        <label class="inline-flex items-center">
                            <input type="radio" name="id_tipe_ujian" value="1" class="form-radio text-green-500"
                                required>
                            <span class="ml-2">Kuis</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="id_tipe_ujian" value="2" class="form-radio text-green-500"
                                required>
                            <span class="ml-2">Ujian</span>
                        </label>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="acak" class="block font-bold mb-2">Acak Soal dan Pilihan</label>
                    <select name="acak" class="block w-full p-2 border border-gray-300 rounded-md" required>
                        <option value="" disabled selected>Pilih opsi</option>
                        <option value="Aktif">Aktif</option>
                        <option value="Tidak Aktif">Tidak Aktif</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="status_jawaban" class="block font-bold mb-2">Status Jawaban</label>
                    <select name="status_jawaban" class="block w-full p-2 border border-gray-300 rounded-md" required>
                        <option value="" disabled selected>Pilih opsi</option>
                        <option value="Aktif">Aktif</option>
                        <option value="Tidak Aktif">Tidak Aktif</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="grade" class="block font-bold mb-2">Grade</label>
                    <input type="number" name="grade" class="block w-full p-2 border border-gray-300 rounded-md"
                        required>
                </div>

                <div class="mb-4">
                    <label for="Waktu_Mulai" class="block font-bold mb-2">Waktu Mulai</label>
                    <input type="datetime-local" name="Waktu_Mulai"
                        class="block w-full p-2 border border-gray-300 rounded-md" required>
                </div>

                <div class="mb-4">
                    <label for="Waktu_Selesai" class="block font-bold mb-2">Waktu Selesai</label>
                    <input type="datetime-local" name="Waktu_Selesai"
                        class="block w-full p-2 border border-gray-300 rounded-md" required>
                </div>

                <div class="mb-4">
                    <label for="password" class="block font-bold mb-2">Password</label>
                    <input type="password" name="password" class="block w-full p-2 border border-gray-300 rounded-md"
                        required>
                </div>

                <div class="flex justify-end mt-4">
                    <button type="submit"
                        class="bg-green-500 text-white px-4 py-2 rounded-lg flex items-center hover:bg-green-400">
                        <span>Simpan</span>
                        <i class="fas fa-check ml-2"></i>
                    </button>
                </div>
            </form>
        </div>

        <script>
            document.querySelector('form').addEventListener('submit', function(event) {
                const waktuMulai = document.querySelector('input[name="Waktu_Mulai"]').value;
                const waktuSelesai = document.querySelector('input[name="Waktu_Selesai"]').value;

                // Validasi untuk memastikan format waktu tidak menggunakan AM/PM
                const validFormat = /^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}$/; // Format: YYYY-MM-DDTHH:MM (24-hour format)
                if (!validFormat.test(waktuMulai) || !validFormat.test(waktuSelesai)) {
                    event.preventDefault();
                    alert("Waktu harus menggunakan format 24 jam (misal: 14:30) tanpa AM/PM.");
                    return;
                }

                // Validasi jika Waktu Mulai lebih besar dari Waktu Selesai
                if (new Date(waktuMulai) >= new Date(waktuSelesai)) {
                    event.preventDefault();
                    alert("Waktu Mulai tidak boleh lebih besar atau sama dengan Waktu Selesai.");
                    return;
                }

                console.log('Waktu Mulai:', waktuMulai);
                console.log('Waktu Selesai:', waktuSelesai);

                // Validasi atau manipulasi waktu lainnya jika diperlukan
            });
        </script>
