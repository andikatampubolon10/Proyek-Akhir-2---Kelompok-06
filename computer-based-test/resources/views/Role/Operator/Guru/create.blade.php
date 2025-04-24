<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QuizHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        .dropdown:hover .dropdown-menu {
            display: block;
        }
    </style>
</head>

<body class="bg-gray-100">
    <!-- Header -->
    <div class="bg-gradient-to-r from-blue-600 via-teal-600 to-green-600 shadow p-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-white">Daftar Guru</h1>
        <div class="relative dropdown">
            <div class="flex items-center cursor-pointer">
                <div class="flex flex-col items-center">
                    <span class="text-white">Welcome, Operator</span>
                    <span class="text-white font-semibold">{{ $user->name }}</span>
                </div>
                <img alt="Profile picture of Natan Hutahean" class="rounded-full ml-4" height="40"
                    src="https://storage.googleapis.com/a1aa/image/sG3g-w8cayIo0nXWyycQx8dmzPb0_0-Zc6iv6Fls36s.jpg"
                    width="40">
            </div>
            <div class="dropdown-menu absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-2 hidden">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="block px-4 py-2 text-gray-700 hover:bg-gray-100 w-full text-left">Logout</button>
                </form>
            </div>
        </div>
    </div>
    <div class="flex flex-col md:flex-row">
        <!-- Sidebar -->
        <div class="w-full md:w-1/4 bg-gradient-to-r from-blue-600 via-teal-600 to-green-600 min-h-screen p-4">
            <ul>
                <li class="mb-4">
                    <a href="{{ route('Operator.Kelas.index') }}"
                        class="flex items-center text-white p-2 rounded-lg hover:bg-blue-500">
                        <i class="fas fa-home text-white mr-2"></i>
                        Kelas
                    </a>
                </li>
                <li class="mb-4">
                    <a href="{{ route('Operator.Siswa.index') }}"
                        class="flex items-center text-white p-2 rounded-lg hover:bg-blue-500">
                        <i class="fas fa-user-graduate text-white mr-2"></i>
                        Daftar Siswa
                    </a>
                </li>
                <li class="mb-4">
                    <a href="#" class="flex items-center text-white bg-blue-500 p-2 rounded-lg shadow">
                        <i class="fas fa-chalkboard-teacher text-white mr-2"></i>
                        Daftar Guru
                    </a>
                </li>
                <li class="mb-4">
                    <a href="{{ route('Operator.Kurikulum.index') }}"
                        class="flex items-center text-white p-2 rounded-lg hover:bg-blue-500">
                        <i class="fas fa-calendar-alt text-white mr-2"></i>
                        Kurikulum
                    </a>
                </li>
                <li class="mb-4">
                    <a href="{{ route('Operator.MataPelajaran.index') }}"
                        class="flex items-center text-white p-2 rounded-lg hover:bg-blue-500">
                        <i class="fas fa-book text-white mr-2"></i>
                        Mata Pelajaran
                    </a>
                </li>
            </ul>
        </div>
        <div class="flex-1 p-4">
            <div class="flex flex-col md:flex-row justify-between items-center mb-8">
                <form id="importForm" action="{{ route('Operator.Guru.import') }}" method="POST"
                    enctype="multipart/form-data" class="flex justify-end mb-4 w-full">
                    @csrf
                    <input type="file" id="fileInput" name="file" class="hidden" accept=".xlsx, .xls" />
                    <div class="ml-auto"> <!-- This div will push the button to the right -->
                        <button type="button" id="importButton"
                            class="bg-blue-500 text-white px-4 py-2 rounded-lg flex items-center hover:bg-blue-400">
                            <i class="fas fa-upload mr-2"></i> Import File
                        </button>
                    </div>
                </form>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md h-full w-full">
                <form action="{{ route('Operator.Guru.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block font-bold mb-2">NIP</label>
                        <input type="number" name="nip" class="block w-full p-2 border border-gray-300 rounded-md" required>
                    </div>
                    <div class="mb-4">
                        <label class="block font-bold mb-2">Nama Guru</label>
                        <input type="text" name="name" class="block w-full p-2 border border-gray-300 rounded-md" required>
                    </div>
                    <div class="mb-4">
                        <label class="block font-bold mb-2">Email</label>
                        <input type="email" name="email" class="block w-full p-2 border border-gray-300 rounded-md" required>
                    </div>
                    <div class="mb-4">
                        <label class="block font-bold mb-2">Password</label>
                        <input type="password" name="password" class="block w-full p-2 border border-gray-300 rounded-md" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Konfirmasi Password<span
                                class="text-red-500">*</span></label>
                        <input type="password" name="password_confirmation"
                            class="w-full border border-gray-300 p-2 rounded-md" required>
                    </div>
                    <div class="flex justify-end mt-4">
                        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg flex items-center hover:bg-green-400">
                            <span>Simpan</span>
                            <i class="fas fa-check ml-2"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        const importButton = document.getElementById('importButton');
        const fileInput = document.getElementById('fileInput');
        const importForm = document.getElementById('importForm');

        document.querySelector('.dropdown').addEventListener('click', function() {
            this.querySelector('.dropdown-menu').classList.toggle('hidden');
        });

        importButton.addEventListener('click', handleImportButtonClick);
        fileInput.addEventListener('change', handleFileInputChange);

        function handleImportButtonClick(event) {
            fileInput.click();
        }

        function handleFileInputChange(event) {
            const file = event.target.files[0];
            if (file) {
                importForm.submit();
            }
        }
    </script>
</body>

</html>