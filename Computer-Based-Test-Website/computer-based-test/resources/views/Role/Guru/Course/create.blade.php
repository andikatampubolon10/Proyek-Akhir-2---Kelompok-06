<html>

<head>
    <title>QuizHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
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
        <div class="flex justify-between items-center p-4 bg-white shadow-md">
            <div>
                <!-- Placeholder for logo or other content -->
            </div>
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
            <div class="bg-white p-8 rounded-lg shadow-md w-full">
                <h1 class="text-2xl font-bold mb-6">Tambahkan Course</h1>
                <form>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="tahunAjar" class="block text-sm font-medium text-gray-700">Tahun Ajar</label>
                            <div class="mt-1 relative">
                                <select id="tahunAjar" name="tahunAjar" class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                    <option>2021/2022</option>
                                    <option>2022/2023</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                                    <i class="fas fa-chevron-down text-gray-400"></i>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label for="semester" class="block text-sm font-medium text-gray-700">Pilih Semester</label>
                            <div class="mt-1 relative">
                                <select id="semester" name="semester" class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                    <option>Semester 1</option>
                                    <option>Semester 2</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                                    <i class="fas fa-chevron-down text-gray-400"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-6">
                        <label for="kelas" class="block text-sm font-medium text-gray-700">Pilih Kelas</label>
                        <div class="mt-1 relative">
                            <select id="kelas" name="kelas" class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option>Kelas A</option>
                                <option>Kelas B</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                                <i class="fas fa-chevron-down text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                    <div class="mb-6">
                        <label for="namaCourse" class="block text-sm font-medium text-gray-700">Nama Course</label>
                        <input type="text" id="namaCourse" name="namaCourse" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function toggleDropdown(event) {
            const dropdownMenu = event.currentTarget.nextElementSibling;
            dropdownMenu.classList.toggle('hidden');
        }
        // Close the dropdown if the user clicks outside of it
        window.onclick = function(event) {
            if (!event.target.matches('.fa-bars')) {
                const dropdowns = document.getElementsByClassName("dropdown-menu");
                for (let i = 0; i < dropdowns.length; i++) {
                    const openDropdown = dropdowns[i];
                    if (!openDropdown.classList.contains('hidden')) {
                        openDropdown.classList.add('hidden');
                    }
                }
            }
        }
    </script>
</body>

</html>