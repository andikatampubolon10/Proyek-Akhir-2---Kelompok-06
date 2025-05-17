<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <title>
        Operator | Siswa
    </title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <style>
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
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .logout-btn:hover {
            background-color: #e04040;
        }

        /* Sidebar */
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
            min-width: 22px;
            text-align: center;
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
            min-height: 100vh;
            background-color: #f4f5f7;
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
                position: relative;
                flex-direction: row;
                justify-content: space-around;
                gap: 0;
            }

            .sidebar a {
                font-size: 14px;
                padding: 10px 12px;
                border-radius: 8px;
                font-weight: 600;
            }

            .sidebar a i {
                margin-right: 8px;
                font-size: 18px;
            }

            .main-content {
                margin-left: 0;
                padding: 90px 20px 20px;
            }

            .btn-add-top-right {
                width: 100%;
                padding: 15px 0;
                position: fixed;
                bottom: 0;
                right: 0;
                left: 0;
                border-radius: 0;
                font-size: 18px;
                z-index: 1000;
            }
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header class="header" role="banner">
        <a href="#" class="logo flex items-center" aria-label="Homepage">
            <img src="{{ asset('images/logo.png') }}" alt="Company logo with green and teal colors" />
        </a>

        <div class="relative dropdown" id="userDropdown">
            <div class="user-info flex items-center" onclick="toggleDropdown()" tabindex="0" role="button"
                aria-haspopup="true" aria-expanded="false" aria-controls="dropdown-menu">
                <div class="flex flex-col items-end leading-tight">
                    <span class="text-white select-none">Welcome, Guru</span>
                    <span class="text-white font-semibold select-text truncate max-w-[140px]">{{ $user->name }}</span>
                </div>
                <img alt="Profile picture of {{ $user->name }}" class="rounded-full ml-4" height="50"
                    src="https://storage.googleapis.com/a1aa/image/sG3g-w8cayIo0nXWyycQx8dmzPb0_0-Zc6iv6Fls36s.jpg"
                    width="50" />
            </div>
            <div id="dropdown-menu" class="dropdown-menu" role="menu" aria-label="User menu">
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="logout-btn" role="menuitem" tabindex="0">
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </header>
    <div class="flex flex-col md:flex-row min-h-screen">
        <!-- Sidebar -->
        <nav aria-label="Sidebar navigation" class="sidebar">
            <a aria-current="page" class="active" href="#">
                <i aria-hidden="true" class="fas fa-book-open">
                </i>
                <span>
                    Course
                </span>
            </a>
            <a href="#">
                <i aria-hidden="true" class="fas fa-pen">
                </i>
                <span>
                    Latihan Soal
                </span>
            </a>
            <a href="#">
                <i aria-hidden="true" class="fas fa-chart-line">
                </i>
                <span>
                    Nilai
                </span>
            </a>
        </nav>
        <!-- Main Content -->
        <div class="main-content">
            <div class="bg-white p-6 rounded-lg shadow-md h-full w-full">
                <form action="{{ route('Guru.Latihan.update', $latihan->id_latihan) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block font-bold mb-2 text-gray-700" for="Topik">
                            Topik Latihan
                        </label>
                        <input
                            class="block w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500"
                            id="Topik" name="Topik" required="" type="text" />
                    </div>
                    <div>
                        <label class="block font-bold mb-2 text-gray-700" for="id_kurikulum">
                            Pilih Kurikulum
                        </label>
                        <select
                            class="block w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500"
                            id="id_kurikulum" name="id_kurikulum" required="">
                            <option disabled="" selected="" value="">
                                Pilih kurikulum
                            </option>
                            <option value="1">
                                Kurikulum 2013
                            </option>
                            <option value="2">
                                Kurikulum Merdeka
                            </option>
                            <option value="3">
                                Kurikulum KTSP
                            </option>
                        </select>
                    </div>
                    <div>
                        <label class="block font-bold mb-2 text-gray-700" for="id_mata_pelajaran">
                            Pilih Mata Pelajaran
                        </label>
                        <select
                            class="block w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500"
                            id="id_mata_pelajaran" name="id_mata_pelajaran" required="">
                            <option disabled="" selected="" value="">
                                Pilih Mata Pelajaran
                            </option>
                            <option value="1">
                                Matematika
                            </option>
                            <option value="2">
                                Bahasa Indonesia
                            </option>
                            <option value="3">
                                IPA
                            </option>
                        </select>
                    </div>
                    <div>
                        <label class="block font-bold mb-2 text-gray-700" for="id_kelas">
                            Pilih Kelas
                        </label>
                        <select
                            class="block w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500"
                            id="id_kelas" name="id_kelas" required="">
                            <option disabled="" selected="" value="">
                                Pilih kelas
                            </option>
                            <option value="1">
                                Kelas 7
                            </option>
                            <option value="2">
                                Kelas 8
                            </option>
                            <option value="3">
                                Kelas 9
                            </option>
                        </select>
                    </div>
                    <div>
                        <label class="block font-bold mb-2 text-gray-700" for="acak">
                            Acak Soal dan Pilihan
                        </label>
                        <select
                            class="block w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500"
                            id="acak" name="acak" required="">
                            <option disabled="" selected="" value="">
                                Pilih opsi
                            </option>
                            <option value="Aktif">
                                Aktif
                            </option>
                            <option value="Tidak Aktif">
                                Tidak Aktif
                            </option>
                        </select>
                    </div>
                    <div>
                        <label class="block font-bold mb-2 text-gray-700" for="status_jawaban">
                            Status Jawaban
                        </label>
                        <select
                            class="block w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500"
                            id="status_jawaban" name="status_jawaban" required="">
                            <option disabled="" selected="" value="">
                                Pilih opsi
                            </option>
                            <option value="Aktif">
                                Aktif
                            </option>
                            <option value="Tidak Aktif">
                                Tidak Aktif
                            </option>
                        </select>
                    </div>
                    <div>
                        <label class="block font-bold mb-2 text-gray-700" for="grade">
                            Grade
                        </label>
                        <input
                            class="block w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500"
                            id="grade" name="grade" required="" type="number" />
                    </div>
                    <div class="flex justify-end">
                        <button
                            class="bg-green-500 text-white px-6 py-3 rounded-lg flex items-center hover:bg-green-400 transition"
                            type="submit">
                            <span>
                                Simpan
                            </span>
                            <i class="fas fa-check ml-2">
                            </i>
                        </button>
                    </div>
                </form>
            </div>
            </main>
        </div>
        <script>
            function toggleDropdown() {
                const menu = document.getElementById('dropdown-menu');
                menu.classList.toggle('show');
            }

            // Close dropdown if clicked outside
            window.addEventListener('click', function(e) {
                const dropdown = document.getElementById('userDropdown');
                const menu = document.getElementById('dropdown-menu');
                if (!dropdown.contains(e.target)) {
                    menu.classList.remove('show');
                }
            });
        </script>
</body>

</html>
