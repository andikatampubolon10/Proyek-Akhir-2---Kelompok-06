<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Operator | Tambah Siswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <style>
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
        <div class="bg-white shadow p-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-teal-500">QUIZHUB</h1>
            <div class="relative">
                <div class="flex items-center cursor-pointer" onclick="toggleDropdown('profileDropdown')">
                    <div class="flex flex-col items-center">
                        <span class="text-teal-500">Welcome, Operator</span>
                        <span class="text-teal-500 font-semibold">{{ $user->name }}</span>
                    </div>
                    <img alt="Profile picture" class="rounded-full ml-4" height="40" src="https://storage.googleapis.com/a1aa/image/sG3g-w8cayIo0nXWyycQx8dmzPb0_0-Zc6iv6Fls36s.jpg" width="40">
                </div>
                <div id="profileDropdown" class="dropdown-menu absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-2 hidden">
                    <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Logout</a>
                </div>
            </div>
        </div>
        <div class="flex flex-col md:flex-row">
            <div class="w-full md:w-1/4 bg-gray-200 h-screen p-4">
                <ul>
                    <li class="mb-4">
                        <a href="#" class="flex items-center text-gray-700 bg-white p-2 rounded-lg shadow">
                            <i class="fas fa-user-graduate text-teal-500 mr-2"></i>
                            Daftar Siswa
                        </a>
                    </li>
                    <li class="mb-4">
                        <a href="{{ route('Operator.Guru.index') }}"
                            class="flex items-center text-gray-700 p-2 rounded-lg">
                            <i class="fas fa-chalkboard-teacher text-teal-500 mr-2"></i>
                            Daftar Guru
                        </a>
                    </li>
                    <li class="mb-4">
                        <a href="{{ route('Operator.MataPelajaran.index') }}"
                            class="flex items-center text-gray-700 p-2 rounded-lg">
                            <i class="fas fa-book text-teal-500 mr-2"></i>
                            Mata Pelajaran
                        </a>
                    </li>
                    <li class="mb-4">
                        <a href="{{ route('Operator.Kelas.index') }}"
                            class="flex items-center text-gray-700 p-2 rounded-lg">
                            <i class="fas fa-home text-teal-500 mr-2"></i>
                            Kelas
                        </a>
                    </li>
                    <li class="mb-4">
                        <a href="{{ route('Operator.Kurikulum.index') }}"
                            class="flex items-center text-gray-700 p-2 rounded-lg">
                            <i class="fas fa-calendar-alt text-teal-500 mr-2"></i>
                            Kurikulum
                        </a>
                    </li>
                </ul>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md w-full md:w-3/4">
                <form id="importForm" action="{{ route('Operator.Siswa.import') }}" method="POST" enctype="multipart/form-data" class="flex justify-end mb-4">
                    @csrf
                    <input type="file" id="fileInput" name="file" class="hidden" accept=".xlsx, .xls" />
                    <button type="button" id="importButton" class="bg-blue-500 text-white px-4 py-2 rounded-lg flex items-center">
                        <i class="fas fa-upload mr-2"></i> Import File
                    </button>
                </form>
                <form action="{{ route('Operator.Siswa.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block font-bold mb-2">Kelas</label>
                        <div class="flex items-center mr-4">
                            <select name="kelas" class="block w-full p-2 border border-gray-400 rounded-md" required required>
                                <option value="">Pilih Kelas</option>
                                @foreach($kelas as $k)
                                    <option value="{{ $k->id_kelas }}">{{ $k->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="block font-bold mb-2">NIS</label>
                        <input type="number" name="nis" class="block w-full p-2 border border-gray-400 rounded-md" required>
                    </div>
                    <div class="mb-4">
                        <label class="block font-bold mb-2">Nama Siswa</label>
                        <input type="text" name="name" class="block w-full p-2 border border-gray-400 rounded-md" required>
                    </div>
                    <div class="mb-4">
                        <label class="block font-bold mb-2">Email</label>
                        <input type="email" name="email" class="block w-full p-2 border border-gray-400 rounded-md" required>
                    </div>
                    <div class="mb-4">
                        <label class="block font-bold mb-2">Password</label>
                        <input type="password" name="password" class="block w-full p-2 border border-gray-400 rounded-md" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Konfirmasi Password<span class="text-red-500">*</span></label>
                        <input type="password" name="password_confirmation" class="block w-full p-2 border border-gray-400 rounded-md" required>
                    </div>
                    <div class="flex justify-end mt-4">
                        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg flex items-center">
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

    importButton.addEventListener('click', handleImportButtonClick);
    fileInput.addEventListener('change', handleFileInputChange);

    function handleImportButtonClick(event) {
        fileInput.click(); // Memicu dialog pemilihan file
    }

    function handleFileInputChange(event) {
        const file = event.target.files[0];
        if (file) {
            // Jika file dipilih, submit form
            importForm.submit();
        }
    }
</script>
</body>
</html>