<!DOCTYPE html>
<html lang="en">

<head>
    <title>QuizHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* General Styles */
        body {
            background-color: #f4f5f7;
            font-family: 'Arial', sans-serif;
            padding: 0;
            margin: 0;
            color: #333;
        }

        /* Header Styles */
        .header {
            background: linear-gradient(to right, #00bfae, #00796b);
            color: white;
            padding: 20px 30px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }

        .header .logo img {
            max-width: 120px;
            border-radius: 8px;
        }

        .header .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
            position: relative;
        }

        .header .user-info img {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #ffffff;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .header .user-info img:hover {
            transform: scale(1.1);
        }

        .header .user-info span {
            font-size: 16px;
            font-weight: 600;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
        }

        /* Dropdown Menu Styles */
        .dropdown-menu {
            display: none;
            position: absolute;
            top: 60px;
            right: 0;
            background-color: #ffffff;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.2);
            padding: 10px;
            border-radius: 8px;
            width: 150px;
            z-index: 1500;
        }

        .dropdown-menu.show {
            display: block;
        }

        .logout-btn {
            background-color: #ff4d4d;
            color: white;
            border: none;
            padding: 10px;
            width: 100%;
            border-radius: 6px;
            text-align: center;
        }

        .logout-btn:hover {
            background-color: #e04040;
        }

        .sidebar {
            background: linear-gradient(to bottom, #00796b, #00bfae, #00796b);
            width: 260px;
            padding: 25px 15px;
            position: fixed;
            top: 80px;
            left: 0;
            bottom: 0;
            display: flex;
            flex-direction: column;
            gap: 20px;
            transition: all 0.3s ease;
            z-index: 900;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            padding: 12px 18px;
            color: white;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 17px;
            transition: all 0.3s ease;
        }

        .sidebar a i {
            margin-right: 15px;
            font-size: 22px;
        }

        .sidebar a.active {
            background-color: #00796b;
            color: white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .sidebar a:hover {
            background-color: #004d40;
            color: white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        /* Adjust the "Course" button to match other sidebar items */
        #dropdownButton {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            padding: 12px 18px;
            /* Same as other sidebar items */
            color: white;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 17px;
            transition: all 0.3s ease;
        }

        #dropdownButton i {
            font-size: 22px;
            /* Same icon size as other items */
        }

        #dropdownButton span {
            font-size: 17px;
            /* Same font size as other items */
        }


        /* Button Styles */
        .btn-add-top-right {
            position: absolute;
            top: 100px;
            right: 30px;
            background-color: #00bfae;
            color: white;
            padding: 12px 25px;
            border-radius: 25px;
            font-size: 16px;
            border: none;
            transition: background-color 0.3s ease;
            min-width: 150px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .btn-add-top-right:hover {
            background-color: #00796b;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            background-color: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        }

        table th,
        table td {
            padding: 18px 25px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #14A098;
            color: white;
            font-weight: 700;
            text-transform: uppercase;
        }

        table tr:hover {
            background-color: #f1f1f1;
            transform: scale(1.01);
            transition: all 0.3s ease;
        }

        table td {
            vertical-align: middle;
        }

        /* Main Content */
        .main-content {
            margin-left: 280px;
            padding: 100px 30px 30px;
            flex: 1;
            transition: all 0.3s ease-in-out;
            overflow-y: auto;
        }

        /* Main Content Box */
        .main-content-box {
            padding: 30px;
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        /* Mobile Responsiveness */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                padding: 20px;
                top: 0;
                left: 0;
                height: auto;
                border-radius: 0;
            }

            .main-content {
                margin-left: 0;
                padding: 70px 20px 20px;
            }

            .btn-add-top-right {
                width: 100%;
                padding: 15px 0;
            }
        }

        .breadcrumb {
            padding: 0;
            margin: 0;
            display: flex;
            /* Ensure the items are displayed in a row */
        }

        .breadcrumb-item {
            display: inline-block;
            /* Ensures the items are side by side */
        }

        .breadcrumb-item+.breadcrumb-item::before {
            content: "/";
            /* Use "/" as the separator */
            padding: 0 8px;
            color: #00796b;
            /* Match the active color */
        }

        .breadcrumb-item a {
            color: #00bfae;
            text-decoration: none;
        }

        .breadcrumb-item a:hover {
            color: #004d40;
            text-decoration: underline;
        }

        .breadcrumb-item.active {
            color: #00796b;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header">
        <h1 class="text-2xl font-bold text-white">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-10">
        </h1>

        <div class="relative dropdown">
            <div class="flex items-center cursor-pointer" onclick="toggleDropdown()">
                <div class="flex flex-col items-center">
                    <span class="text-white">Welcome, Guru</span>
                    <span class="text-white font-semibold">{{ $user->name }}</span>
                </div>
                <img alt="Profile picture" class="rounded-full ml-4" height="50"
                    src="https://storage.googleapis.com/a1aa/image/sG3g-w8cayIo0nXWyycQx8dmzPb0_0-Zc6iv6Fls36s.jpg"
                    width="50">
            </div>
            <div id="dropdown-menu" class="dropdown-menu">
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
        <div class="sidebar">
            <a
                href="{{ route('Guru.Course.index') }}"class="d-flex align-items-center text-gray-700 p-2 rounded-lg hover:bg-gray-300">
                <i class="fas fa-book-open text-sm"></i>
                <span>Course</span>
            </a>
            <a
                href="{{ route('Guru.Latihan.index') }}"class="d-flex align-items-center text-gray-700 p-2 rounded-lg hover:bg-gray-300">
                <i class="fas fa-pen text-sm"></i>
                <span>Latihan Soal</span>
            </a>

            <a
                href="{{ route('Guru.Nilai.index') }}"class="d-flex align-items-center text-gray-700 p-2 rounded-lg hover:bg-gray-300">
                <i class="fas fa-chart-line text-sm"></i>
                <span>Nilai</span>
            </a>
        </div>

        <div class="main-content">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-2xl font-bold mb-4">Soal</h2>
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
                                <p class="mt-2 font-semibold">Pilihan Berganda</p>
                            </div>
                            <div onclick="pilihSoal('truefalse')"
                                class="cursor-pointer p-4 border border-gray-300 rounded-lg text-center hover:bg-gray-100 transition">
                                <i class="fas fa-check-circle text-green-500 text-3xl"></i>
                                <p class="mt-2 font-semibold">Benar/Salah</p>
                            </div>
                            <div onclick="pilihSoal('essay')"
                                class="cursor-pointer p-4 border border-gray-300 rounded-lg text-center hover:bg-gray-100 transition">
                                <i class="fas fa-pen text-purple-500 text-3xl"></i>
                                <p class="mt-2 font-semibold">Essai</p>
                            </div>
                        </div>
                        <button onclick="closeTipeSoalModal()"
                            class="mt-4 w-full bg-gray-500 text-white py-2 rounded-lg hover:bg-gray-600">Batal</button>
                    </div>
                </div>
                <div class="space-y-4">
                    <div class="mt-6">
                        <div id="previewModal" class="modal">
                            <div class="modal-content">
                                <span id="modalClose" class="modal-close">&times;</span>
                                <div id="previewContent"></div>
                            </div>
                        </div>
                        @if ($idUjian)
                            @foreach ($soals as $soal)
                                <div
                                    class="bg-gray-100 p-4 rounded-lg shadow-md flex flex-col md:flex-row justify-between items-start md:items-center mb-4">
                                    <div class="mb-4 md:mb-0 md:flex-1">
                                        <h3 class="text-lg font-semibold mb-2 break-words">{{ $soal->soal }}</h3>
                                        <p class="text-sm text-gray-600">Jenis: {{ $soal->tipe_soal->nama_tipe_soal }}
                                        </p>
                                    </div>

                                    <div class="flex space-x-5 justify-end flex-wrap">
                                        <form action="{{ route('Guru.Soal.preview', $soal->id_soal) }}" method="GET"
                                            class="inline">
                                            <button type="submit"
                                                class="text-yellow-500 flex items-center hover:text-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-400 rounded">
                                                <i class="fas fa-eye mr-1"></i> Preview
                                            </button>
                                        </form>

                                        <form action="{{ route('Guru.Soal.destroy', $soal->id_soal) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus soal ini?');"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                class="text-red-500 flex items-center hover:text-red-700 focus:outline-none focus:ring-2 focus:ring-red-400 rounded">
                                                <i class="fas fa-trash-alt mr-1"></i> Delete
                                            </button>
                                        </form>

                                        <form action="{{ route('Guru.Soal.edit', $soal->id_soal) }}" method="GET"
                                            class="inline">
                                            <button type="submit"
                                                class="text-blue-500 flex items-center hover:text-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 rounded">
                                                <i class="fas fa-edit mr-1"></i> Edit
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        @endif

                        <!-- Soal Latihan -->
                        @if ($idLatihan)
                            @foreach ($soals as $soal)
                                <div
                                    class="bg-gray-100 p-4 rounded-lg shadow-md flex flex-col md:flex-row justify-between items-start md:items-center mb-4">
                                    <div class="mb-4 md:mb-0 md:flex-1">
                                        <h3 class="text-lg font-semibold mb-2 break-words">{{ $soal->soal }}</h3>
                                        <p class="text-sm text-gray-600">Jenis: {{ $soal->tipe_soal->nama_tipe_soal }}
                                        </p>
                                        <p class="text-sm text-gray-600">Topik: {{ $soal->latihan->Topik }}</p>
                                    </div>

                                    <div class="flex space-x-5 justify-end flex-wrap">
                                        <form action="{{ route('Guru.Soal.preview', $soal->id_soal) }}"
                                            method="GET" class="inline">
                                            <button type="submit"
                                                class="text-yellow-500 flex items-center hover:text-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-400 rounded">
                                                <i class="fas fa-eye mr-1"></i> Preview
                                            </button>
                                        </form>

                                        <form action="{{ route('Guru.Soal.destroy', $soal->id_soal) }}"
                                            method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus soal ini?');"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-500 flex items-center hover:text-red-700 focus:outline-none focus:ring-2 focus:ring-red-400 rounded">
                                                <i class="fas fa-trash-alt mr-1"></i> Delete
                                            </button>
                                        </form>

                                        <form action="{{ route('Guru.Soal.edit', $soal->id_soal) }}" method="GET"
                                            class="inline">
                                            <button type="submit"
                                                class="text-blue-500 flex items-center hover:text-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 rounded">
                                                <i class="fas fa-edit mr-1"></i> Edit
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        @endif

                        @if (!($idUjian || $idLatihan))
                            <p class="text-center text-gray-600">Silakan pilih ujian atau latihan untuk melihat soal.
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="successModalLabel">Berhasil Menambahkan Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @if (session('success'))
                            {{ session('success') }}
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- JavaScript to show modal if success message exists and auto-close after 3 seconds -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            // Menampilkan modal otomatis jika session success ada
            @if (session('success'))
                var myModal = new bootstrap.Modal(document.getElementById('successModal'));
                myModal.show();

                // Menutup modal setelah 3 detik
                setTimeout(function() {
                    myModal.hide();
                }, 3000); // 3000ms = 3 detik
            @endif


            // Function to toggle dropdown visibility
            function toggleDropdown() {
                const dropdown = document.getElementById("dropdown-menu");
                dropdown.classList.toggle("show");
            }
        </script>
        <script>
            // Dropdown toggle script
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

            function toggleDropdown() {
                const dropdown = document.getElementById("dropdown-menu");
                dropdown.classList.toggle("show");
            }


            document.getElementById('profileDropdown').addEventListener('click', function() {
                document.getElementById('logoutDropdown').classList.toggle('hidden');
            });



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
