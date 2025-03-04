<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QuizHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="flex">
        <!-- Sidebar -->
        <div class="w-1/5 bg-white h-screen shadow-md p-4">
            <!-- Logo -->
            <div class="flex items-center">
                <img src="{{ asset('images/logo.png') }}" alt="QuizHub Logo" class="h-20 mr-5">

            </div>
            
            <nav class="mt-6">
                <a href="{{ route('dashboard') }}" class="flex items-center bg-blue-600 text-white p-2 rounded-lg">
                    📖 <span class="ml-2">Course</span>
                </a>
                <a href="#" class="flex items-center text-gray-600 p-2 mt-2">
                    ✏️ <span class="ml-2">Latihan Soal</span>
                </a>
            </nav>
        </div>

        <!-- Content -->
        <div class="w-4/5 p-6">
            <!-- Navbar -->
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-semibold">Tambah Course</h2>
                <div class="text-blue-600 font-bold">Hallo Guru 🔵</div>
            </div>

            @yield('content')
        </div>
    </div>
</body>
</html>
