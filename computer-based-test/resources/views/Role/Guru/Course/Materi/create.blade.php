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
            <form action="{{ route('Guru.Materi.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
        
                <div class="mb-4">
                    <label for="week" class="block font-bold mb-2">Week</label>
                    <select name="week" class="block w-full p-2 border border-gray-300 rounded-md" required>
                        <option value="" disabled selected>Pilih Week</option>
                        @for ($i = 1; $i <= 26; $i++)
                            <option value="{{ $i }}" {{ old('week') == $i ? 'selected' : '' }}>Week {{ $i }}</option>
                        @endfor
                    </select>
                </div>
        
                <div class="mb-4">
                    <label for="judul_materi" class="block font-bold mb-2">Topik Materi</label>
                    <input type="text" name="judul_materi" class="block w-full p-2 border border-gray-300 rounded-md" required>
                </div>
        
                <div class="mb-4">
                    <label for="deskripsi" class="block font-bold mb-2">Deskripsi</label>
                    <textarea name="deskripsi" class="w-full border p-2" rows="5" required></textarea>
                </div>  
        
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="file_upload">Upload File</label>
                    <input type="file" id="file_upload" name="file" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
        
                <div class="flex justify-end mt-4">
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg flex items-center hover:bg-green-400">
                        <span>Simpan</span>
                        <i class="fas fa-check ml-2"></i>
                    </button>
                </div>
            </form>
        </div>
        
    </div>
</body>

</html>