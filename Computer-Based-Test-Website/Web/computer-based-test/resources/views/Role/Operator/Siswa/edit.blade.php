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
        .dropdown.open .dropdown-menu {
            display: block;
        }
    </style>
    <script>
        function toggleDropdown(id) {
            document.getElementById(id).classList.toggle('hidden');
        }
    </script>
</head>
<body class="bg-gray-100">
    <div class="flex flex-col h-screen">
        <!-- Top Bar -->
        <div class="bg-white shadow p-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-teal-500">QUIZHUB</h1>
            <div class="relative">
                <div class="flex items-center cursor-pointer" onclick="toggleDropdown('profileDropdown')">
                    <div class="flex flex-col items-center">
                        <span class="text-teal-500">Hello, Guru</span>
                        <span class="text-teal-500 font-semibold">Natan Hutahean</span>
                    </div>
                    <img alt="Profile picture of Natan Hutahean" class="rounded-full ml-4" height="40" src="https://storage.googleapis.com/a1aa/image/sG3g-w8cayIo0nXWyycQx8dmzPb0_0-Zc6iv6Fls36s.jpg" width="40">
                </div>
                <div id="profileDropdown" class="dropdown-menu absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-2 hidden">
                    <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Logout</a>
                </div>
            </div>
        </div>
        <div class="flex flex-1 flex-col md:flex-row">
            <!-- Sidebar -->
            <div class="w-full md:w-1/4 bg-gray-200 h-screen p-4">
                <ul>
                    <li class="mb-4">
                        <a href="#" class="flex items-center text-gray-700 bg-white p-2 rounded-lg shadow">
                            <i class="fas fa-user-graduate text-teal-500 mr-2"></i>
                            Daftar Siswa
                        </a>
                    </li>
                    <li class="mb-4">
                        <a href="#" class="flex items-center text-gray-700 p-2 rounded-lg">
                            <i class="fas fa-chalkboard-teacher text-teal-500 mr-2"></i>
                            Daftar Guru
                        </a>
                    </li>
                    <li class="mb-4">
                        <a href="#" class="flex items-center text-gray-700 p-2 rounded-lg">
                            <i class="fas fa-book text-teal-500 mr-2"></i>
                            Mata Pelajaran
                        </a>
                    </li>
                    <li class="mb-4">
                        <a href="#" class="flex items-center text-gray-700 p-2 rounded-lg">
                            <i class="fas fa-home text-teal-500 mr-2"></i>
                            Kelas
                        </a>
                    </li>
                    <li class="mb-4">
                        <a href="#" class="flex items-center text-gray-700 p-2 rounded-lg">
                            <i class="fas fa-calendar-alt text-teal-500 mr-2"></i>
                            Kurikulum
                        </a>
                    </li>
                </ul>
            </div>
            <div class="w-full md:w-4/5 p-4 flex justify-center items-start">
                <div class="w-full">
                    <div class="mb-4">
                        <select class="block w-1/4 p-2 border border-gray-400 rounded-md">
                            <option>Kelas 7</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block font-bold mb-2">Nisn</label>
                        <input type="text" class="block w-full p-2 border border-black rounded-md">
                    </div>
                    <div class="mb-4">
                        <label class="block font-bold mb-2">Nama Siswa</label>
                        <input type="text" class="block w-full p-2 border border-black rounded-md">
                    </div>
                    <div class="mb-4">
                        <label class="block font-bold mb-2">Password</label>
                        <input type="password" class="block w-full p-2 border border-black rounded-md">
                    </div>
                    <div class="flex justify-end">
                        <button class="bg-green-600 text-white px-4 py-2 rounded-md">Unggah</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Close dropdowns if clicked outside
        window.onclick = function(event) {
            if (!event.target.matches('.cursor-pointer') && !event.target.matches('.rounded-full')) {
                var dropdowns = document.getElementsByClassName("dropdown-menu");
                for (var i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (!openDropdown.classList.contains('hidden')) {
                        openDropdown.classList.add('hidden');
                    }
                }
            }
        }
    </script>
</body>
</html>