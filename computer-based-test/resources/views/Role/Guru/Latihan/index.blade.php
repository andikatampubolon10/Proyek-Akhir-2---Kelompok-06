<html>

<head>
    <title>QuizHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />
</head>

<body class="bg-gray-100">
    <!-- Top Bar -->
    <div class="bg-gradient-to-r from-blue-500 via-teal-500 to-green-500 shadow p-4 flex justify-between items-center w-full">
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
                        
                        {{ $user->name }} <!-- Menampilkan nama user -->
                    </span>
                </div>
                <img alt="Profile picture of {{ $user->name }}" class="rounded-full ml-4" height="40" src="https://storage.googleapis.com/a1aa/image/KO6yf8wvxyOnH9pvZuXN0ujQxQrH2zDDdLtZaIA-KQ8.jpg" width="40" />
            </div>
            <div class="dropdown-menu absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-2 hidden" id="logoutDropdown">
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
                    <a class="flex items-center text-white bg-green-500 p-2 rounded-lg shadow hover:bg-green-400" href="#">
                        <i class="fas fa-book mr-4"></i> Course
                    </a>
                </li>
                <li class="mb-4">
                    <a class="flex items-center text-white bg-blue-500 p-2 rounded-lg shadow hover:bg-blue-400" href="{{ route('Guru.LatihanSoal.index') }}">
                        <i class="fas fa-pencil-alt mr-4"></i> Latihan Soal
                    </a>
                </li>
                <li class="mb-4">
                    <a class="flex items-center text-white bg-green-500 p-2 rounded-lg shadow hover:bg-green-400" href="#">
                        <i class="fas fa-chart-line mr-4"></i> Nilai
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <script>
        const dropdownButton = document.getElementById('dropdownButton');
        const dropdownMenu = document.getElementById('dropdownMenu');
        const dropdownIcon = document.getElementById('dropdownIcon');

        dropdownButton.addEventListener('click', () => {
            const isExpanded = dropdownButton.getAttribute('aria-expanded') === 'true';
            dropdownButton.setAttribute('aria-expanded', !isExpanded);

            if (dropdownMenu.style.maxHeight && dropdownMenu.style.maxHeight !== '0px') {
                dropdownMenu.style.maxHeight = '0px';
                dropdownMenu.style.paddingTop = '0';
                dropdownMenu.style.paddingBottom = '0';
                dropdownIcon.style.transform = 'rotate(0deg)';
            } else {
                dropdownMenu.style.maxHeight = dropdownMenu.scrollHeight + 'px';
                dropdownMenu.style.paddingTop = '0.5rem';
                dropdownMenu.style.paddingBottom = '0.5rem';
                dropdownIcon.style.transform = 'rotate(180deg)';
            }
        });

        // Close dropdown if clicked outside
        window.addEventListener('click', (e) => {
            if (!dropdownButton.contains(e.target) && !dropdownMenu.contains(e.target)) {
                dropdownMenu.style.maxHeight = '0px';
                dropdownMenu.style.paddingTop = '0';
                dropdownMenu.style.paddingBottom = '0';
                dropdownButton.setAttribute('aria-expanded', 'false');
                dropdownIcon.style.transform = 'rotate(0deg)';
            }
        });

        // Initialize dropdown closed
        dropdownMenu.style.maxHeight = '0px';
        dropdownMenu.style.overflow = 'hidden';
        dropdownMenu.style.transition = 'max-height 0.3s ease, padding 0.3s ease';
    </script>
</body>

</html>