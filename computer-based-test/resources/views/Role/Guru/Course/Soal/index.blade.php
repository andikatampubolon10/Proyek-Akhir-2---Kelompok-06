<!DOCTYPE html>
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
            <div class="flex items-center cursor-pointer" id="profileDropdown">
                <div class="flex flex-col items-center">
                    <span class="text-white">Welcome, Admin</span>
                    <span class="text-white font-semibold">{{ $user->name }}</span>
                </div>
                <img alt="Profile picture" class="rounded-full ml-4" height="40"
                    src="https://storage.googleapis.com/a1aa/image/KO6yf8wvxyOnH9pvZuXN0ujQxQrH2zDDdLtZaIA-KQ8.jpg"
                    width="40" />
            </div>
            <div class="dropdown-menu absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-2 hidden"
                id="logoutDropdown">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="block px-4 py-2 text-gray-700 hover:bg-gray-100 w-full text-left"
                        type="submit">Logout</button>
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
                        <i class="fas fa-book mr-4"></i> Course
                    </a>
                </li>
                <li class="mb-4">
                    <a class="flex items-center text-white bg-blue-500 p-2 rounded-lg shadow hover:bg-blue-400"
                        href="#">
                        <i class="fas fa-pencil-alt mr-4"></i> Latihan Soal
                    </a>
                </li>
                <li class="mb-4">
                    <a class="flex items-center text-white bg-green-500 p-2 rounded-lg shadow hover:bg-green-400"
                        href="#">
                        <i class="fas fa-chart-line mr-4"></i> Nilai
                    </a>
                </li>
            </ul>
        </div>
        <!-- Main Content -->
        <div class="w-full md:w-3/4 p-4">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-2xl font-bold mb-4">Soal</h2>
                <!-- Modal untuk memilih tipe soal -->
                <div class="flex justify-end mb-4">
                    <button onclick="showTipeSoalModal()"
                        class="bg-green-500 text-white px-4 py-2 rounded-lg flex items-center">
                        <i class="fas fa-plus mr-2"></i> Tambahkan
                    </button>
                </div>
                <div id="tipeSoalModal"
                    class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center z-50">
                    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
                        <h2 class="text-lg font-semibold text-gray-700 text-center">Pilih Tipe Soal</h2>
                        <div class="grid grid-cols-2 gap-4 mt-4">
                            <div onclick="pilihSoal('pilgan')"
                                class="cursor-pointer p-4 border border-gray-300 rounded-lg text-center hover:bg-gray-100 transition">
                                <i class="fas fa-question-circle text-blue-500 text-3xl"></i>
                                <p class="mt-2 font-semibold">Pilgan</p>
                            </div>
                            <div onclick="pilihSoal('truefalse')"
                                class="cursor-pointer p-4 border border-gray-300 rounded-lg text-center hover:bg-gray-100 transition">
                                <i class="fas fa-check-circle text-green-500 text-3xl"></i>
                                <p class="mt-2 font-semibold">True/False</p>
                            </div>
                            <div onclick="pilihSoal('essay')"
                                class="cursor-pointer p-4 border border-gray-300 rounded-lg text-center hover:bg-gray-100 transition">
                                <i class="fas fa-pen text-purple-500 text-3xl"></i>
                                <p class="mt-2 font-semibold">Essay</p>
                            </div>
                        </div>
                        <button onclick="closeTipeSoalModal()"
                            class="mt-4 w-full bg-gray-500 text-white py-2 rounded-lg hover:bg-gray-600">Batal</button>
                    </div>
                </div>
                <div class="space-y-4">
                    <!-- Question 1 -->
                    @foreach ($soals as $soal)
                        <div class="bg-gray-100 p-4 rounded-lg shadow-md flex justify-between items-center">
                            <div>
                                <h3 class="text-lg font-semibold mb-2">{{ $soal->soal }} </h3>
                                <p class="text-sm text-gray-600">Jenis: {{ $soal->tipe_soal->nama_tipe_soal }} </p>
                            </div>

                            <div class="flex space-x-5 justify-end">
                                <form action="{{ route('Guru.Soal.destroy', $soal->id_ujian) }}" method="POST"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus soal ini?');">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="text-red-500 flex items-center hover:text-red-700">
                                        <i class="fas fa-trash-alt mr-1"></i> DELETE
                                    </button>
                                </form>
                                <form action="{{ route('Guru.Soal.edit', $soal->id_soal) }}" method="GET">
                                    <button type="submit" class="text-blue-500 flex items-center hover:text-blue-700" data-id="{{ $soal->id_soal }}">
                                        <i class="fas fa-edit mr-1"></i> EDIT
                                    </button>
                                </form>                                
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('profileDropdown').addEventListener('click', function() {
            document.getElementById('logoutDropdown').classList.toggle('hidden');
        });

        function showTipeSoalModal() {
            document.getElementById('tipeSoalModal').classList.remove('hidden');
        }

        function closeTipeSoalModal() {
            document.getElementById('tipeSoalModal').classList.add('hidden');
        }

        function pilihSoal(tipe) {
            Swal.fire({
                title: 'Anda memilih ' + (tipe === 'pilgan' ? 'Pilgan' : tipe === 'truefalse' ? 'True/False' :
                    'Essay'),
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
