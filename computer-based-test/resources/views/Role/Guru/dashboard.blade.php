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
                        Admin Name
                    </span>
                </div>
                <img alt="Profile picture of Admin" class="rounded-full ml-4" height="40"
                    src="https://placehold.co/40x40" width="40" />
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
        <div class="w-full bg-white p-6 shadow-md">
            <h1 class="text-2xl font-semibold text-blue-600 mb-4">
                4142201 - Distributed Application Development
            </h1>
            <h2 class="text-xl font-semibold mb-4">
                Course Content
            </h2>
            <div class="border-b border-gray-300 mb-4">
            </div>
            <div class="flex mb-4">
                <div class="w-1/2 border-b-2 border-blue-600 pb-2">
                    <h3 class="text-lg font-semibold">
                        Ujian
                    </h3>
                </div>
                <div class="w-1/2 pb-2">
                    <h3 class="text-lg font-semibold">
                        Materi
                    </h3>
                </div>
            </div>
            <div>
                <h4 class="text-lg font-semibold mb-2">
                    Week 1
                </h4>
                <div class="flex justify-between items-center mb-4">
                    <div class="flex-grow">
                    </div>
                    <button class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-400 flex items-center">
                        Tambah
                        <i class="fas fa-plus ml-2">
                        </i>
                    </button>
                </div>
                <h4 class="text-lg font-semibold mb-2">
                    Week 2
                </h4>
                <div class="flex justify-between items-center mb-4">
                    <div class="flex-grow">
                    </div>
                    <button class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-400 flex items-center">
                        Tambah
                        <i class="fas fa-plus ml-2">
                        </i>
                    </button>
                </div>
                <h4 class="text-lg font-semibold mb-2">
                    Week 3
                </h4>
                <div class="flex justify-between items-center mb-4">
                    <div class="flex-grow">
                    </div>
                    <button class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-400 flex items-center">
                        Tambah
                        <i class="fas fa-plus ml-2">
                        </i>
                    </button>
                </div>
                <h4 class="text-lg font-semibold mb-2">
                    Week 4
                </h4>
                <div class="flex justify-between items-center mb-4">
                    <div class="flex-grow">
                    </div>
                    <button class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-400 flex items-center">
                        Tambah
                        <i class="fas fa-plus ml-2">
                        </i>
                    </button>
                </div>
                <h4 class="text-lg font-semibold mb-2">
                    Week 5
                </h4>
                <div class="flex justify-between items-center mb-4">
                    <div class="flex-grow">
                    </div>
                    <button class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-400 flex items-center">
                        Tambah
                        <i class="fas fa-plus ml-2">
                        </i>
                    </button>
                </div>
                <h4 class="text-lg font-semibold mb-2">
                    Week 6
                </h4>
                <div class="flex justify-between items-center mb-4">
                    <div class="flex-grow">
                    </div>
                    <button class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-400 flex items-center">
                        Tambah
                        <i class="fas fa-plus ml-2">
                        </i>
                    </button>
                </div>
                <h4 class="text-lg font-semibold mb-2">
                    Week 7
                </h4>
                <div class="flex justify-between items-center mb-4">
                    <div class="flex-grow">
                    </div>
                    <button class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-400 flex items-center">
                        Tambah
                        <i class="fas fa-plus ml-2">
                        </i>
                    </button>
                </div>
                <h4 class="text-lg font-semibold mb-2">
                    Week 8
                </h4>
                <div class="flex justify-between items-center mb-4">
                    <div class="flex-grow">
                    </div>
                    <button class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-400 flex items-center">
                        Tambah
                        <i class="fas fa-plus ml-2">
                        </i>
                    </button>
                </div>
                <h4 class="text-lg font-semibold mb-2">
                    Week 9
                </h4>
                <div class="flex justify-between items-center mb-4">
                    <div class="flex-grow">
                    </div>
                    <button class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-400 flex items-center">
                        Tambah
                        <i class="fas fa-plus ml-2">
                        </i>
                    </button>
                </div>
                <h4 class="text-lg font-semibold mb-2">
                    Week 10
                </h4>
                <div class="flex justify-between items-center mb-4">
                    <div class="flex-grow">
                    </div>
                    <button class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-400 flex items-center">
                        Tambah
                        <i class="fas fa-plus ml-2">
                        </i>
                    </button>
                </div>
                <h4 class="text-lg font-semibold mb-2">
                    Week 11
                </h4>
                <div class="flex justify-between items-center mb-4">
                    <div class="flex-grow">
                    </div>
                    <button class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-400 flex items-center">
                        Tambah
                        <i class="fas fa-plus ml-2">
                        </i>
                    </button>
                </div>
                <h4 class="text-lg font-semibold mb-2">
                    Week 12
                </h4>
                <div class="flex justify-between items-center mb-4">
                    <div class="flex-grow">
                    </div>
                    <button class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-400 flex items-center">
                        Tambah
                        <i class="fas fa-plus ml-2">
                        </i>
                    </button>
                </div>
                <h4 class="text-lg font-semibold mb-2">
                    Week 13
                </h4>
                <div class="flex justify-between items-center mb-4">
                    <div class="flex-grow">
                    </div>
                    <button class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-400 flex items-center">
                        Tambah
                        <i class="fas fa-plus ml-2">
                        </i>
                    </button>
                </div>
                <h4 class="text-lg font-semibold mb-2">
                    Week 14
                </h4>
                <div class="flex justify-between items-center mb-4">
                    <div class="flex-grow">
                    </div>
                    <button class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-400 flex items-center">
                        Tambah
                        <i class="fas fa-plus ml-2">
                        </i>
                    </button>
                </div>
                <h4 class="text-lg font-semibold mb-2">
                    Week 15
                </h4>
                <div class="flex justify-between items-center mb-4">
                    <div class="flex-grow">
                    </div>
                    <button class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-400 flex items-center">
                        Tambah
                        <i class="fas fa-plus ml-2">
                        </i>
                    </button>
                </div>
                <h4 class="text-lg font-semibold mb-2">
                    Week 16
                </h4>
                <div class="flex justify-between items-center mb-4">
                    <div class="flex-grow">
                    </div>
                    <button class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-400 flex items-center">
                        Tambah
                        <i class="fas fa-plus ml-2">
                        </i>
                    </button>
                </div>
                <h4 class="text-lg font-semibold mb-2">
                    Week 17
                </h4>
                <div class="flex justify-between items-center mb-4">
                    <div class="flex-grow">
                    </div>
                    <button class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-400 flex items-center">
                        Tambah
                        <i class="fas fa-plus ml-2">
                        </i>
                    </button>
                </div>
                <h4 class="text-lg font-semibold mb-2">
                    Week 18
                </h4>
                <div class="flex justify-between items-center mb-4">
                    <div class="flex-grow">
                    </div>
                    <button class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-400 flex items-center">
                        Tambah
                        <i class="fas fa-plus ml-2">
                        </i>
                    </button>
                </div>
                <h4 class="text-lg font-semibold mb-2">
                    Week 19
                </h4>
                <div class="flex justify-between items-center mb-4">
                    <div class="flex-grow">
                    </div>
                    <button class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-400 flex items-center">
                        Tambah
                        <i class="fas fa-plus ml-2">
                        </i>
                    </button>
                </div>
                <h4 class="text-lg font-semibold mb-2">
                    Week 20
                </h4>
                <div class="flex justify-between items-center mb-4">
                    <div class="flex-grow">
                    </div>
                    <button class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-400 flex items-center">
                        Tambah
                        <i class="fas fa-plus ml-2">
                        </i>
                    </button>
                </div>
                <h4 class="text-lg font-semibold mb-2">
                    Week 21
                </h4>
                <div class="flex justify-between items-center mb-4">
                    <div class="flex-grow">
                    </div>
                    <button class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-400 flex items-center">
                        Tambah
                        <i class="fas fa-plus ml-2">
                        </i>
                    </button>
                </div>
                <h4 class="text-lg font-semibold mb-2">
                    Week 22
                </h4>
                <div class="flex justify-between items-center mb-4">
                    <div class="flex-grow">
                    </div>
                    <button class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-400 flex items-center">
                        Tambah
                        <i class="fas fa-plus ml-2">
                        </i>
                    </button>
                </div>
                <h4 class="text-lg font-semibold mb-2">
                    Week 23
                </h4>
                <div class="flex justify-between items-center mb-4">
                    <div class="flex-grow">
                    </div>
                    <button class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-400 flex items-center">
                        Tambah
                        <i class="fas fa-plus ml-2">
                        </i>
                    </button>
                </div>
                <h4 class="text-lg font-semibold mb-2">
                    Week 24
                </h4>
                <div class="flex justify-between items-center mb-4">
                    <div class="flex-grow">
                    </div>
                    <button class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-400 flex items-center">
                        Tambah
                        <i class="fas fa-plus ml-2">
                        </i>
                    </button>
                </div>
                <h4 class="text-lg font-semibold mb-2">
                    Week 25
                </h4>
                <div class="flex justify-between items-center mb-4">
                    <div class="flex-grow">
                    </div>
                    <button class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-400 flex items-center">
                        Tambah
                        <i class="fas fa-plus ml-2">
                        </i>
                    </button>
                </div>
                <h4 class="text-lg font-semibold mb-2">
                    Week 26
                </h4>
                <div class="flex justify-between items-center mb-4">
                    <div class="flex-grow">
                    </div>
                    <button class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-400 flex items-center">
                        Tambah
                        <i class="fas fa-plus ml-2">
                        </i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('addButton').addEventListener('click', function() {
            document.getElementById('modal').classList.remove('hidden');
        });

        document.getElementById('closeButton').addEventListener('click', function() {
            document.getElementById('modal').classList.add('hidden');
        });

        document.getElementById('profileDropdown').addEventListener('click', function() {
            document.getElementById('logoutDropdown').classList.toggle('hidden');
        });
    </script>
</body>

</html>
