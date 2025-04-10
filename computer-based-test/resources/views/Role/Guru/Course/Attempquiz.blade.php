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
            <div class="w-full md:w-1/5 bg-gray-200 h-auto md:h-full p-4">
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
            <div class="flex-1 bg-white border border-gray-300">
                <div class="p-4 border-b border-gray-300">
                    <h1 class="text-2xl font-bold text-black">Ilmu Pengetahuan Alam</h1>
                </div>
                <div class="p-4">
                    <div class="flex justify-between items-center mb-4 relative">
                        <h2 class="text-lg font-medium text-black">Latihan Soal Sistem Pencernaan</h2>
                        <div class="relative">
                            <i class="fas fa-cog text-black cursor-pointer" onclick="toggleDropdown('settingsDropdown')"></i>
                            <div id="settingsDropdown" class="absolute right-0 mt-2 w-48 bg-white border border-gray-300 rounded shadow-lg hidden">
                                <a href="#" class="block px-4 py-2 text-black hover:bg-gray-200">Add Question</a>
                                <a href="#" class="block px-4 py-2 text-black hover:bg-gray-200">Edit Question</a>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col items-center space-y-4">
                        <button class="px-4 py-2 bg-gray-200 text-black border border-gray-300">Attempts : 40</button>
                        <button class="px-4 py-2 bg-gray-200 text-black border border-gray-300 mt-4">Preview Quiz Now</button>
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