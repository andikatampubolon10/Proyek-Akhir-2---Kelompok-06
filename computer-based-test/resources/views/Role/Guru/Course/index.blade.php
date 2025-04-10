<html>

<head>
    <title>
        QuizHub
    </title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <style>
        /* Custom dropdown styles */
        .dropdown-menu {
            display: none;
        }

        .dropdown-menu.show {
            display: block;
        }
    </style>
</head>

<body class="bg-gray-100">
    <div class="flex flex-col h-screen">
        <div class="bg-white shadow p-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-teal-500">QUIZHUB</h1>
            <div class="relative dropdown">
                <div class="flex items-center cursor-pointer">
                    <div class="flex flex-col items-center">
                        <span class="text-teal-500">Hello, Guru</span>
                        <span class="text-teal-500 font-semibold">Natan Hutahean</span>
                    </div>
                    <img alt="Profile picture of Natan Hutahean" class="rounded-full ml-4" height="40"
                        src="https://storage.googleapis.com/a1aa/image/sG3g-w8cayIo0nXWyycQx8dmzPb0_0-Zc6iv6Fls36s.jpg"
                        width="40">
                </div>
                <div class="dropdown-menu absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-2 hidden">
                    <a href="{{ route('logout') }} class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Logout</a>
                </div>
            </div>
        </div>
        <div class="flex flex-1">
            <!-- Sidebar -->
            <div class="w-full md:w-1/5 bg-gray-200 h-auto md:h-full p-4">
                <div class="text-center mb-8">
                </div>
                <div class="mb-4">
                    <div class="flex items-center p-2 bg-white rounded-lg shadow-md">
                        <a href = "{{ route('Guru.Course.index') }}">
                            <i class="fas fa-user-circle text-2xl text-teal-500">
                            </i>
                            <span class="ml-2 text-lg font-semibold">
                                Course
                            </span>
                        </a>
                    </div>
                </div>
                <div>
                    <a href="{{ route('Guru.LatihanSoal.index') }}">
                    <div class="flex items-center p-2">
                        <i class="fas fa-id-card text-2xl text-teal-500">
                        </i>
                        <span class="ml-2 text-lg font-semibold">
                            Latihan Soal
                        </span>
                    </div>                        
                    </a>
                </div>
            </div>
            <div class="flex-1 p-6">
                <div class="flex justify-end mb-4">
                    <a href="{{ route('Guru.Course.create') }}"
                        class="bg-green-500 text-white px-4 py-2 rounded-lg flex items-center">
                        <i class="fas fa-plus mr-2"></i> Tambahkan
                    </a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach ($courses as $course)
                        <div class="bg-white shadow-lg rounded-lg overflow-visible">
                            <img alt="Course image" class="w-full h-32 object-cover"
                                src="{{ asset('images/' . $course->image) }}" />
                            <div class="p-4 flex justify-between items-center">
                                <div>
                                    <h2 class="text-lg font-bold">
                                        {{ $course->nama_kursus }}
                                    </h2>
                                </div>
                                <div class="relative dropdown">
                                    <i class="fas fa-bars text-gray-500 cursor-pointer"
                                        onclick="toggleDropdown(event, 'course-dropdown-{{ $course->id_kursus }}')">
                                    </i>
                                    <div id="course-dropdown-{{ $course->id_kursus }}"
                                        class="dropdown-menu absolute right-0 mt-2 w-48 bg-white border rounded shadow-lg z-10">
                                        <a class="block px-4 py-2 text-gray-800 hover:bg-gray-200"
                                            href="{{ route('Guru.Ujian.index'), $course->id_kursus }}">
                                            Exam
                                        </a>
                                        <a class="block px-4 py-2 text-gray-800 hover:bg-gray-200"
                                            href="{{ route('Guru.Course.destroy', $course->id_kursus) }}">
                                            Delete Course
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <script>
        function toggleDropdown(event, dropdownId) {
            event.stopPropagation(); 
            const dropdownMenu = document.getElementById(dropdownId);

            document.querySelectorAll('.dropdown-menu.show').forEach((menu) => {
                if (menu.id !== dropdownId) {
                    menu.classList.remove('show');
                }
            });

            dropdownMenu.classList.toggle('show');
        }

        document.addEventListener('click', function(event) {
            if (!event.target.closest('.dropdown')) {
                document.querySelectorAll('.dropdown-menu.show').forEach((menu) => {
                    menu.classList.remove('show');
                });
            }
        });
    </script>
</body>

</html>
