    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Operator | Siswa</title>
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
        <div class="bg-white shadow p-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-teal-500">Kelas</h1>
            <div class="relative dropdown">
                <div class="flex items-center cursor-pointer">
                    <div class="flex flex-col items-center">
                        <span class="text-teal-500">Welcome, Operator</span>
                        <span class="text-teal-500 font-semibold">{{ $user->name }}</span>
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
            <div class="w-full md:w-3/4 p-8">
                <div class="flex justify-end mb-4">
                    <a href="{{ route('Operator.Siswa.create') }}"
                        class="bg-green-500 text-white px-4 py-2 rounded-lg flex items-center">
                        <i class="fas fa-plus mr-2"></i> Tambahkan
                    </a>
                </div>
                <div class="mb-4">
                    <label for="kelas" class="block text-sm font-medium text-gray-700">Pilih Kelas</label>
                    <select id="kelas" name="kelas"
                        class="mt-1 block w-full border border-gray-300 rounded-md p-2">
                        <option value="">Kelas</option>
                        @foreach ($kelas as $k)
                            <option value="{{ $k->id_kelas }}">{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="bg-white p-4 md:p-6 rounded-lg shadow-md">
                    <h2 class="text-xl font-bold mb-4">Student Information</h2>
                    <div class="space-y-4">
                        @foreach ($siswa as $student)
                            <div class="bg-gray-300 p-4 rounded-lg flex flex-col md:flex-row justify-between items-start md:items-center"
                                data-kelas="{{ $student->id_kelas }}"> <!-- Tambahkan data-kelas -->
                                <div class="mb-4 md:mb-0">
                                    <h4 class="font-bold">{{ $student->name }}</h4>
                                    <h5 class="text-gray-600">Nama: {{ $student->nama_siswa }}</h5>
                                    <h5 class="text-gray-600">NIS: {{ $student->nis }}</h5>
                                    <h5 class="text-gray-600">Email: {{ $student->user->email }}</h5>
                                    <h5 class="text-gray-600">Status: {{ $student->status }}</h5>
                                </div>
                                <div class="flex space-x-5">
                                    <div>
                                        <form action="{{ route('Operator.Siswa.destroy', $student->id_siswa) }}"
                                            method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 flex items-center">
                                                <i class="fas fa-trash-alt mr-1"></i> DELETE
                                            </button>
                                        </form>
                                    </div>
                                    <div>
                                        <form action="{{ route('Operator.Siswa.edit', $student->id_siswa) }}"
                                            method="GET">
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
        </div>
        <script>
            document.getElementById('kelas').addEventListener('change', function() {
                const selectedKelas = this.value;
                const studentItems = document.querySelectorAll('.bg-gray-300'); 

                studentItems.forEach(item => {
                    const itemKelas = item.getAttribute('data-kelas'); 
                    if (selectedKelas === '' || itemKelas === selectedKelas) {
                        item.style.display = 'flex'; 
                    } else {
                        item.style.display = 'none'; 
                    }
                });
            });

            document.querySelector('.dropdown').addEventListener('click', function() {
                this.querySelector('.dropdown-menu').classList.toggle('hidden');
            });
        </script>
    </body>

    </html>
