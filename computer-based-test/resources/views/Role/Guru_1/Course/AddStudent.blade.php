<html>
<head>
    <title>QuizHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <style>
        /* Custom dropdown styles */
        .dropdown-menu {
            display: none;
        }
        .dropdown:hover .dropdown-menu {
            display: block;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex flex-col h-screen">
        <!-- Top Bar -->
        <div class="bg-white shadow p-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-teal-500">QUIZHUB</h1>
            <div class="relative dropdown">
                <div class="flex items-center cursor-pointer">
                    <div class="flex flex-col items-center">
                        <span class="text-teal-500">Hello, Guru</span>
                        <span class="text-teal-500 font-semibold">Natan Hutahean</span>
                    </div>
                    <img alt="Profile picture of Natan Hutahean" class="rounded-full ml-4" height="40" src="https://storage.googleapis.com/a1aa/image/sG3g-w8cayIo0nXWyycQx8dmzPb0_0-Zc6iv6Fls36s.jpg" width="40">
                </div>
                <div class="dropdown-menu absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-2 hidden">
                    <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Logout</a>
                </div>
            </div>
        </div>
        <div class="flex flex-1 flex-col md:flex-row">
            <!-- Sidebar -->
            <div class="w-full md:w-1/5 bg-gray-200 h-auto md:h-full p-4">
                <div class="text-center mb-8">
                    <h1 class="text-2xl font-bold text-teal-500">QUIZHUB</h1>
                </div>
                <div class="mb-4">
                    <div class="flex items-center p-2 bg-white rounded-lg shadow-md">
                        <i class="fas fa-user-circle text-2xl text-teal-500"></i>
                        <span class="ml-2 text-lg font-semibold">Course</span>
                    </div>
                </div>
                <div>
                    <div class="flex items-center p-2">
                        <i class="fas fa-id-card text-2xl text-teal-500"></i>
                        <span class="ml-2 text-lg font-semibold">Latihan Soal</span>
                    </div>
                </div>
            </div>
            <div class="flex-1 p-6">
                <div class="grid grid-cols-1 gap-6">
                    <div class="bg-white p-8 rounded-lg shadow-md w-full">
                        <h1 class="text-2xl font-bold mb-6">Add Student</h1>
                        <div class="mb-4">
                            <label class="block text-gray-700 mb-2">Cari Siswa</label>
                            <div class="flex items-center border rounded-lg overflow-hidden">
                                <input type="text" class="flex-grow p-2 outline-none" placeholder="Cari Siswa">
                                <button class="p-2">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <div class="mb-4 flex items-center">
                            <!-- Removed the label for "Undang Siswa" -->
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 mb-2">Password Course</label>
                            <div class="flex items-center border rounded-lg overflow-hidden">
                                <input type="text" class="flex-grow p-2 outline-none" placeholder="Password Course">
                            </div>
                        </div>
                        <button class="bg-green-500 text-white px-4 py-2 rounded-lg flex items-center">
                            Tambahkan <i class="fas fa-plus ml-2"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>