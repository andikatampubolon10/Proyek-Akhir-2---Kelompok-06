<html lang="en">

<head>
    <title>QuizHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gray-100">
    <!-- Top Bar -->
    <div
        class="bg-gradient-to-r from-blue-500 via-teal-500 to-green-500 shadow p-4 flex justify-between items-center w-full">
        <h1 class="text-2xl font-bold text-white">QUIZHUB</h1>
        <div class="relative dropdown">
            <div class="flex items-center cursor-pointer select-none" id="profileDropdown" tabindex="0" aria-haspopup="true" aria-expanded="false" role="button">
                <div class="flex flex-col items-center">
                    <span class="text-white">Welcome, Admin</span>
                    <span class="text-white font-semibold">{{ $user->name }}</span>
                </div>
                <img alt="Profile picture of the logged in user showing a smiling person with short hair wearing a blue shirt" class="rounded-full ml-4" height="40"
                    src="https://storage.googleapis.com/a1aa/image/KO6yf8wvxyOnH9pvZuXN0ujQxQrH2zDDdLtZaIA-KQ8.jpg"
                    width="40" />
            </div>
            <div class="dropdown-menu absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-2 hidden z-50"
                id="logoutDropdown" role="menu" aria-label="User menu">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="block px-4 py-2 text-gray-700 hover:bg-gray-100 w-full text-left" type="submit" role="menuitem" tabindex="-1">Logout</button>
                </form>
            </div>
        </div>
    </div>
    <div class="flex flex-col md:flex-row min-h-screen">
        <!-- Sidebar -->
        <nav class="w-full md:w-1/4 bg-gradient-to-r from-blue-600 via-teal-600 to-green-600 p-4" aria-label="Sidebar Navigation">
            <ul>
                <li class="mb-4">
                    <a class="flex items-center text-white bg-green-500 p-2 rounded-lg shadow hover:bg-green-400 transition" href="#">
                        <i class="fas fa-book mr-4"></i> Course
                    </a>
                </li>
                <li class="mb-4">
                    <a class="flex items-center text-white bg-blue-500 p-2 rounded-lg shadow hover:bg-blue-400 transition" href="#">
                        <i class="fas fa-pencil-alt mr-4"></i> Latihan Soal
                    </a>
                </li>
                <li class="mb-4">
                    <a class="flex items-center text-white bg-green-500 p-2 rounded-lg shadow hover:bg-green-400 transition" href="#">
                        <i class="fas fa-chart-line mr-4"></i> Nilai
                    </a>
                </li>
            </ul>
        </nav>
        <!-- Main Content -->
        <main class="w-full md:w-3/4 p-4">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-2xl font-bold mb-4">Soal</h2>
                <!-- Modal untuk memilih tipe soal -->
                <div class="flex justify-end mb-4">
                    <button onclick="showTipeSoalModal()"
                        class="bg-green-500 text-white px-4 py-2 rounded-lg flex items-center hover:bg-green-600 transition focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-offset-1">
                        <i class="fas fa-plus mr-2"></i> Tambahkan
                    </button>
                </div>
                <div id="tipeSoalModal"
                    class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center z-50"
                    role="dialog" aria-modal="true" aria-labelledby="tipeSoalModalTitle" tabindex="-1">
                    <div class="bg-white p-6 rounded-lg shadow-lg w-11/12 max-w-md mx-auto" role="document">
                        <h2 id="tipeSoalModalTitle" class="text-lg font-semibold text-gray-700 text-center">Pilih Tipe Soal</h2>
                        <div class="grid grid-cols-2 gap-4 mt-4">
                            <button type="button" onclick="pilihSoal('pilgan')"
                                class="cursor-pointer p-4 border border-gray-300 rounded-lg text-center hover:bg-gray-100 transition focus:outline-none focus:ring-2 focus:ring-blue-400">
                                <i class="fas fa-question-circle text-blue-500 text-3xl"></i>
                                <p class="mt-2 font-semibold">Pilgan</p>
                            </button>
                            <button type="button" onclick="pilihSoal('truefalse')"
                                class="cursor-pointer p-4 border border-gray-300 rounded-lg text-center hover:bg-gray-100 transition focus:outline-none focus:ring-2 focus:ring-green-400">
                                <i class="fas fa-check-circle text-green-500 text-3xl"></i>
                                <p class="mt-2 font-semibold">True/False</p>
                            </button>
                            <button type="button" onclick="pilihSoal('essay')"
                                class="cursor-pointer p-4 border border-gray-300 rounded-lg text-center hover:bg-gray-100 transition focus:outline-none focus:ring-2 focus:ring-purple-400">
                                <i class="fas fa-pen text-purple-500 text-3xl"></i>
                                <p class="mt-2 font-semibold">Essay</p>
                            </button>
                        </div>
                        <button onclick="closeTipeSoalModal()"
                            class="mt-4 w-full bg-gray-500 text-white py-2 rounded-lg hover:bg-gray-600 transition focus:outline-none focus:ring-2 focus:ring-gray-600">Batal</button>
                    </div>
                </div>

                <div class="mt-6">
                        <!-- Soal Ujian -->
                        @if ($idUjian)
                            @foreach ($soals as $soal)
                                <div class="bg-gray-100 p-4 rounded-lg shadow-md flex flex-col md:flex-row justify-between items-start md:items-center mb-4">
                                    <div class="mb-4 md:mb-0 md:flex-1">
                                        <h3 class="text-lg font-semibold mb-2 break-words">{{ $soal->soal }}</h3>
                                        <p class="text-sm text-gray-600">Jenis: {{ $soal->tipe_soal->nama_tipe_soal }}</p>
                                    </div>

                                    <div class="flex space-x-5 justify-end flex-wrap">
                                        <form action="{{ route('Guru.Soal.preview', $soal->id_soal) }}" method="GET" class="inline">
                                            <button type="submit" class="text-yellow-500 flex items-center hover:text-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-400 rounded">
                                                <i class="fas fa-eye mr-1"></i> PREVIEW
                                            </button>
                                        </form>

                                            <form action="{{ route('Guru.Soal.destroy', $soal->id_soal) }}" method="POST"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus soal ini?');" class="inline">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="text-red-500 flex items-center hover:text-red-700 focus:outline-none focus:ring-2 focus:ring-red-400 rounded">
                                                    <i class="fas fa-trash-alt mr-1"></i> DELETE
                                                </button>
                                            </form>

                                        <form action="{{ route('Guru.Soal.edit', $soal->id_soal) }}" method="GET" class="inline">
                                            <button type="submit" class="text-blue-500 flex items-center hover:text-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 rounded">
                                                <i class="fas fa-edit mr-1"></i> EDIT
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        @endif

                        <!-- Soal Latihan -->
                        @if ($idLatihan)
                            @foreach ($soals as $soal)
                                <div class="bg-gray-100 p-4 rounded-lg shadow-md flex flex-col md:flex-row justify-between items-start md:items-center mb-4">
                                    <div class="mb-4 md:mb-0 md:flex-1">
                                        <h3 class="text-lg font-semibold mb-2 break-words">{{ $soal->soal }}</h3>
                                        <p class="text-sm text-gray-600">Jenis: {{ $soal->tipe_soal->nama_tipe_soal }}</p>
                                        <p class="text-sm text-gray-600">Topik: {{ $soal->latihan->Topik }}</p>
                                    </div>

                                    <div class="flex space-x-5 justify-end flex-wrap">
                                        <form action="{{ route('Guru.Soal.preview', $soal->id_soal) }}" method="GET" class="inline">
                                            <button type="submit" class="text-yellow-500 flex items-center hover:text-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-400 rounded">
                                                <i class="fas fa-eye mr-1"></i> PREVIEW
                                            </button>
                                        </form>

                                        <form action="{{ route('Guru.Soal.destroy', $soal->id_soal) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus soal ini?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 flex items-center hover:text-red-700 focus:outline-none focus:ring-2 focus:ring-red-400 rounded">
                                                <i class="fas fa-trash-alt mr-1"></i> DELETE
                                            </button>
                                        </form>

                                        <form action="{{ route('Guru.Soal.edit', $soal->id_soal) }}" method="GET" class="inline">
                                            <button type="submit" class="text-blue-500 flex items-center hover:text-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 rounded">
                                                <i class="fas fa-edit mr-1"></i> EDIT
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        @endif

                        <!-- If no selection -->
                        @if (!($idUjian || $idLatihan))
                            <p class="text-center text-gray-600">Silakan pilih ujian atau latihan untuk melihat soal.</p>
                        @endif
                    </div>
                </div>
            </div>
        </main>

    <script>
        // Toggle dropdown menu for profile
        const profileDropdown = document.getElementById('profileDropdown');
        const logoutDropdown = document.getElementById('logoutDropdown');

        profileDropdown.addEventListener('click', function (e) {
            e.stopPropagation();
            logoutDropdown.classList.toggle('hidden');
            const expanded = profileDropdown.getAttribute('aria-expanded') === 'true';
            profileDropdown.setAttribute('aria-expanded', !expanded);
        });

        // Close dropdown if clicked outside
        document.addEventListener('click', function () {
            if (!logoutDropdown.classList.contains('hidden')) {
                logoutDropdown.classList.add('hidden');
                profileDropdown.setAttribute('aria-expanded', 'false');
            }
        });

        // Keyboard accessibility for profile dropdown
        profileDropdown.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' || e.key === 'Tab') {
                logoutDropdown.classList.add('hidden');
                profileDropdown.setAttribute('aria-expanded', 'false');
            }
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                logoutDropdown.classList.toggle('hidden');
                const expanded = profileDropdown.getAttribute('aria-expanded') === 'true';
                profileDropdown.setAttribute('aria-expanded', !expanded);
            }
        });

        function showTipeSoalModal() {
            const modal = document.getElementById('tipeSoalModal');
            modal.classList.remove('hidden');
            modal.focus();
        }

        function closeTipeSoalModal() {
            const modal = document.getElementById('tipeSoalModal');
            modal.classList.add('hidden');
        }

        function pilihSoal(tipe) {
            Swal.fire({
                title: 'Anda memilih ' + (tipe === 'pilgan' ? 'Pilgan' : tipe === 'truefalse' ? 'True/False' : 'Essay'),
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                closeTipeSoalModal();
                if (tipe === 'pilgan') {
                    window.location.href = "{{ route('Guru.Soal.create', ['type' => 'pilgan']) }}";
                } else if (tipe === 'truefalse') {
                    window.location.href = "{{ route('Guru.Soal.create', ['type' => 'truefalse']) }}";
                } else if (tipe === 'essay') {
                    window.location.href = "{{ route('Guru.Soal.create', ['type' => 'essay']) }}";
                }
            });
        }
    </script>

</body>

</html>