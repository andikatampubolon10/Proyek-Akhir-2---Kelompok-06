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
                    <div class="w-full bg-white p-8 rounded-lg shadow-md">
                        <h1 class="text-3xl font-bold mb-6">Manage Course</h1>
                        <form>
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="nama">Nama</label>
                                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="nama" type="text">
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="deskripsi">Deskripsi</label>
                                <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="deskripsi" rows="4"></textarea>
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Waktu Akses</label>
                                <div class="flex flex-col md:flex-row items-center mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2 w-full md:w-1/3" for="waktu-buka">Waktu Buka Course</label>
                                    <div class="flex items-center w-full md:w-2/3">
                                        <div class="relative flex items-center w-full">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class="fas fa-calendar-alt text-gray-400"></i>
                                            </div>
                                            <input class="shadow appearance-none border rounded-l w-full py-2 pl-10 pr-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="waktu-buka" type="datetime-local">
                                            <div class="flex flex-col">
                                                <button class="shadow appearance-none border-t border-b border-r rounded-r py-1 px-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                                    <i class="fas fa-chevron-up"></i>
                                                </button>
                                                <button class="shadow appearance-none border-t border-b border-r rounded-r py-1 px-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                                    <i class="fas fa-chevron-down"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-col md:flex-row items-center">
                                    <label class="block text-gray-700 text-sm font-bold mb-2 w-full md:w-1/3" for="waktu-tutup">Waktu Tutup Course</label>
                                    <div class="flex items-center w-full md:w-2/3">
                                        <div class="relative flex items-center w-full">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class="fas fa-calendar-alt text-gray-400"></i>
                                            </div>
                                            <input class="shadow appearance-none border rounded-l w-full py-2 pl-10 pr-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="waktu-tutup" type="datetime-local">
                                            <div class="flex flex-col">
                                                <button class="shadow appearance-none border-t border-b border-r rounded-r py-1 px-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                                    <i class="fas fa-chevron-up"></i>
                                                </button>
                                                <button class="shadow appearance-none border-t border-b border-r rounded-r py-1 px-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                                    <i class="fas fa-chevron-down"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-end">
                                <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded flex items-center">
                                    Tambahkan <i class="fas fa-plus ml-2"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>