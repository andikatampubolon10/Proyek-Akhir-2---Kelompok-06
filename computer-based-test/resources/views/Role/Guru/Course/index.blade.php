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
        <div class="w-full md:w-1/4 bg-gradient-to-r from-blue-600 via-teal-600 to-green-600 min-h-screen p-4">
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
        <div class="w-full bg-white p-6 shadow-md">
            @foreach ($courses as $kursus)
                <h1 class="text-2xl font-semibold text-blue-600 mb-4">
                    {{ $kursus->nama_kursus }}
                </h1>
            @endforeach
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
                    <a href="{{ route('Guru.Materi.index') }}">
                    <h3 class="text-lg font-semibold">
                        Materi
                    </h3>                        
                    </a>

                </div>
            </div>
            @for ($week = 1; $week <= 26; $week++)
                <h4 class="text-lg font-semibold mb-2">Week {{ $week }}</h4>
                <div class="flex justify-between items-center mb-4">
                    <div class="flex-grow">
                        @foreach ($ujians->where('week', $week) as $exam)
                            <div class="exam-container">
                                <a href="{{ route('Guru.Soal.index') }}">
                                <h2 class="exam-title">{{ $exam->tipe_ujian->nama_tipe_ujian }} : {{ $exam->nama_ujian }}</h2>                                    
                                </a>
                            </div>
                        @endforeach
                    </div>
                    @foreach ($courses as $course)
                    <div class="flex justify-end mb-4">
                        <a class="bg-green-500 text-white px-4 py-2 rounded-lg flex items-center"
                        href="{{ route('Guru.Ujian.create')}}">
                            <i class="fas fa-plus mr-2"></i>
                            Tambah
                        </a>                     
                    </div>
                @endforeach
                
                </div>
            @endfor
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
