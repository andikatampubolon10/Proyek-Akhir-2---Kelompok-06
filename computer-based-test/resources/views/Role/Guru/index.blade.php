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
            <div class="flex items-center cursor-pointer">
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
            <div class="dropdown-menu absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-2 hidden">
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
                        href="{{ route('Guru.LatihanSoal.index') }}">
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
        <!-- Main Content -->
        <div class="w-full md:w-3/4 p-4 md:p-8">
            <!-- Action Button -->
            <div class="flex justify-end mb-4">
                <a class="bg-green-500 text-white px-4 py-2 rounded-lg flex items-center"
                    href="{{ route('Guru.Course.create') }}">
                    <i class="fas fa-plus mr-2">
                    </i>
                    Tambahkan
                </a>
            </div>
            <div class="bg-white p-4 md:p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-bold mb-4 text-blue-600">
                    Course Information
                </h2>
                <div class="space-y-4">
                    @foreach($courses as $course)
                        <div class="p-4 border rounded-lg shadow-sm flex items-center justify-between">
                            <div class="flex items-center">
                                <img alt="Thumbnail image of the {{ $course->nama_kursus }} course"
                                    class="w-24 h-24 rounded-lg mr-4" height="100"
                                    src="{{ asset('images/' . $course->image) }}"
                                    width="100" />
                                <div>
                                    <form action="{{ route('Guru.Ujian.create', ['id_kursus' => $course->id]) }}" method="GET">
                                        <h3 class="text-lg font-semibold text-gray-800">
                                            <a href="{{ route('Guru.Ujian.index') }}" class="text-blue-600 no-underline">
                                                {{ $course->nama_kursus }}
                                            </a>
                                        </h3>
                                    </form>
                                </div>
                            </div>
                            <div class="flex space-x-5">
                                <div>
                                    <form action="{{ route('Guru.Course.destroy', $course->id_kursus) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 flex items-center">
                                            <i class="fas fa-trash-alt mr-1"></i> DELETE
                                        </button>
                                    </form>
                                </div>
                                <div>
                                    <form action="{{ route('Guru.Course.edit', $course->id_kursus) }}" method="GET">
                                        <button type="submit" class="text-blue-500 flex items-center">
                                            <i class="fas fa-edit mr-1"></i> EDIT
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <script>
        document.querySelector('.dropdown').addEventListener('click', function() {
            this.querySelector('.dropdown-menu').classList.toggle('hidden');
        });
    </script>
</body>

</html>
