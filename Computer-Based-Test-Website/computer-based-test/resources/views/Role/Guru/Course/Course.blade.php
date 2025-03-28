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
            <div class="flex-1 p-4">
                <div class="w-full bg-white p-8 border border-gray-300">
                    <div class="flex justify-between items-center mb-8 relative">
                        <h1 class="text-2xl font-bold">Ilmu Pengetahuan Alam</h1>
                        <div class="relative">
                            <button id="dropdownButton" class="bg-green-500 text-white px-4 py-2 rounded">Tambahkan</button>
                            <div id="dropdownMenu" class="hidden absolute right-0 mt-2 w-48 bg-white border border-gray-300 rounded shadow-lg z-50">
                                <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Tambah Quiz</a>
                                <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Tambah Ujian</a>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between border border-gray-300 p-4 bg-white relative">
                            <div class="flex items-center">
                                <i class="fas fa-file-alt text-blue-500 mr-2"></i>
                                <span>Quiz 1 Sistem Pencernaan</span>
                            </div>
                            <div class="relative">
                                <i id="cogButton1" class="fas fa-cog cursor-pointer"></i>
                                <div id="cogMenu1" class="hidden absolute right-0 mt-2 w-48 bg-white border border-gray-300 rounded shadow-lg z-50">
                                    <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Tambah Pertanyaan</a>
                                    <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Edit Pertanyaan</a>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center justify-between border border-gray-300 p-4 bg-white relative">
                            <div class="flex items-center">
                                <i class="fas fa-file-alt text-blue-500 mr-2"></i>
                                <span>Quiz 2 Sistem Pernapasan</span>
                            </div>
                            <div class="relative">
                                <i id="cogButton2" class="fas fa-cog cursor-pointer"></i>
                                <div id="cogMenu1" class="hidden absolute right-0 mt-2 w-48 bg-white border border-gray-300 rounded shadow-lg z-50">
                                    <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Tambah Pertanyaan</a>
                                    <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Edit Pertanyaan</a>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center justify-between border border-gray-300 p-4 bg-white relative">
                            <div class="flex items-center">
                                <i class="fas fa-file-alt text-blue-500 mr-2"></i>
                                <span>Quiz 3 Hewan & Tumbuhan</span>
                            </div>
                            <div class="relative">
                                <i id="cogButton3" class="fas fa-cog cursor-pointer"></i>
                                <div id="cogMenu1" class="hidden absolute right-0 mt-2 w-48 bg-white border border-gray-300 rounded shadow-lg z-50">
                                    <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Tambah Pertanyaan</a>
                                    <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Edit Pertanyaan</a>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center justify-between border border-gray-300 p-4 bg-white relative">
                            <div class="flex items-center">
                                <i class="fas fa-file-alt text-red-500 mr-2"></i>
                                <span>Ujian Tengah Semester</span>
                            </div>
                            <div class="relative">
                                <i id="cogButton4" class="fas fa-cog cursor-pointer"></i>
                                <div id="cogMenu1" class="hidden absolute right-0 mt-2 w-48 bg-white border border-gray-300 rounded shadow-lg z-50">
                                    <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Tambah Pertanyaan</a>
                                    <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Edit Pertanyaan</a>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center justify-between border border-gray-300 p-4 bg-white relative">
                            <div class="flex items-center">
                                <i class="fas fa-file-alt text-blue-500 mr-2"></i>
                                <span>Quiz 4 Virus</span>
                            </div>
                            <div class="relative">
                                <i id="cogButton5" class="fas fa-cog cursor-pointer"></i>
                                <div id="cogMenu1" class="hidden absolute right-0 mt-2 w-48 bg-white border border-gray-300 rounded shadow-lg z-50">
                                    <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Tambah Pertanyaan</a>
                                    <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Edit Pertanyaan</a>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center justify-between border border-gray-300 p-4 bg-white relative">
                            <div class="flex items-center">
                                <i class="fas fa-file-alt text-blue-500 mr-2"></i>
                                <span>Quiz 5 Bakteri</span>
                            </div>
                            <div class="relative">
                                <i id="cogButton6" class="fas fa-cog cursor-pointer"></i>
                                <div id="cogMenu1" class="hidden absolute right-0 mt-2 w-48 bg-white border border-gray-300 rounded shadow-lg z-50">
                                    <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Tambah Pertanyaan</a>
                                    <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Edit Pertanyaan</a>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center justify-between border border-gray-300 p-4 bg-white relative">
                            <div class="flex items-center">
                                <i class="fas fa-file-alt text-blue-500 mr-2"></i>
                                <span>Quiz 6 Pewarisan Sifat</span>
                            </div>
                            <div class="relative">
                                <i id="cogButton7" class="fas fa-cog cursor-pointer"></i>
                                <div id="cogMenu1" class="hidden absolute right-0 mt-2 w-48 bg-white border border-gray-300 rounded shadow-lg z-50">
                                    <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Tambah Pertanyaan</a>
                                    <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Edit Pertanyaan</a>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center justify-between border border-gray-300 p-4 bg-white relative">
                            <div class="flex items-center">
                                <i class="fas fa-file-alt text-red-500 mr-2"></i>
                                <span>Ujian Akhir Semester</span>
                            </div>
                            <div class="relative">
                                <i id="cogButton8" class="fas fa-cog cursor-pointer"></i>
                                <div id="cogMenu1" class="hidden absolute right-0 mt-2 w-48 bg-white border border-gray-300 rounded shadow-lg z-50">
                                    <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Tambah Pertanyaan</a>
                                    <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Edit Pertanyaan</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('dropdownButton').addEventListener('click', function() {
            var dropdownMenu = document.getElementById('dropdownMenu');
            dropdownMenu.classList.toggle('hidden');
        });

        window.addEventListener('click', function(e) {
            var dropdownMenu = document.getElementById('dropdownMenu');
            if (!document.getElementById('dropdownButton').contains(e.target)) {
                dropdownMenu.classList.add('hidden');
            }
        });

        function toggleCogMenu(cogButtonId, cogMenuId) {
            document.getElementById(cogButtonId).addEventListener('click', function() {
                var cogMenu = document.getElementById(cogMenuId);
                cogMenu.classList.toggle('hidden');
            });

            window.addEventListener('click', function(e) {
                var cogMenu = document.getElementById(cogMenuId);
                if (!document.getElementById(cogButtonId).contains(e.target)) {
                    cogMenu.classList.add('hidden');
                }
            });
        }

        toggleCogMenu('cogButton1', 'cogMenu1');
        toggleCogMenu('cogButton2', 'cogMenu2');
        toggleCogMenu('cogButton3', 'cogMenu3');
        toggleCogMenu('cogButton4', 'cogMenu4');
        toggleCogMenu('cogButton5', 'cogMenu5');
        toggleCogMenu('cogButton6', 'cogMenu6');
        toggleCogMenu('cogButton7', 'cogMenu7');
        toggleCogMenu('cogButton8', 'cogMenu8');
    </script>
</body>
</html>