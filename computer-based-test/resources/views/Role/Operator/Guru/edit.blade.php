<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Operator | Edit Guru</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

    <style>
        body {
            background-color: #f4f5f7;
            font-family: 'Arial', sans-serif;
            padding: 0;
            margin: 0;
            color: #333;
        }

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
            height: 40px;
            object-fit: contain;
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
            line-height: 1.2;
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            top: 60px;
            right: 0;
            background-color: #ffffff;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.2);
            padding: 10px 0;
            border-radius: 8px;
            width: 160px;
            z-index: 1100;
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
            overflow-y: auto;
        }

        .sidebar ul {
            padding: 0;
            margin: 0;
            list-style: none;
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
            background-color: #14a098;
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

        .main-content {
            margin-left: 280px;
            padding: 100px 30px 30px;
            flex: 1;
            transition: all 0.3s ease-in-out;
            overflow-y: auto;
            min-height: 100vh;
        }

        .main-content-box {
            padding: 30px;
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

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
                overflow-x: auto;
                gap: 10px;
            }

            .sidebar ul {
                display: flex;
                gap: 10px;
                width: 100%;
            }

            .sidebar li {
                flex: 1 0 auto;
            }

            .sidebar a {
                font-size: 14px;
                padding: 10px 12px;
                border-radius: 8px;
                justify-content: center;
            }

            .sidebar a i {
                margin-right: 0;
                font-size: 18px;
            }

            .sidebar a span {
                display: none;
            }

            .main-content {
                margin-left: 0;
                padding: 90px 20px 20px;
            }

            .btn-add-top-right {
                width: 100%;
                padding: 15px 0;
                position: static;
                margin-bottom: 20px;
                border-radius: 12px;
                min-width: auto;
            }
        }

        .breadcrumb {
            background-color: #ffffff;
            padding: 10px 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 20px;
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
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

        .alert-danger {
            color: #e74c3c;
            font-size: 14px;
            font-weight: 600;
            margin-top: 5px;
            display: block;
        }

        select#status {
            width: 100%;
            padding: 0.5rem 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            font-size: 1rem;
            font-weight: 500;
            margin-top: 0.25rem;
            margin-bottom: 0.5rem;
            color: #374151;
            background-color: white;
            transition: border-color 0.3s ease;
        }

        select#status:focus {
            outline: none;
            border-color: #14a098;
            box-shadow: 0 0 0 3px rgba(20, 160, 152, 0.3);
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header class="header" role="banner">
        <h1 class="logo">
            <img src="{{ asset('images/logo.png') }}" alt="Logo of the application with green and teal colors" />
        </h1>

        <div class="relative dropdown user-info" aria-haspopup="true" aria-expanded="false">
            <div class="flex items-center cursor-pointer select-none" onclick="toggleDropdown()" tabindex="0" role="button" aria-label="User menu toggle">
                <div class="flex flex-col items-center leading-tight">
                    <span class="text-white text-sm md:text-base">Welcome, Operator</span>
                    <span class="text-white font-semibold text-base md:text-lg">{{ $user->name }}</span>
                </div>
                <img alt="Profile picture of the logged in operator, showing a smiling person with short hair" class="rounded-full ml-4" height="50" src="https://storage.googleapis.com/a1aa/image/sG3g-w8cayIo0nXWyycQx8dmzPb0_0-Zc6iv6Fls36s.jpg" width="50" />
            </div>
            <div id="dropdown-menu" class="dropdown-menu" role="menu" aria-label="User dropdown menu">
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="logout-btn" role="menuitem" tabindex="0">Logout</button>
                </form>
            </div>
        </div>
    </header>

    <div class="flex flex-col md:flex-row min-h-screen">
        <!-- Sidebar -->
        <nav class="sidebar" aria-label="Primary Navigation">
            <ul>
                <li class="mb-4">
                    <a href="{{ route('Operator.Kurikulum.index') }}" class="flex items-center text-white p-2 rounded-lg hover:bg-blue-500" tabindex="0">
                        <i class="fas fa-calendar-alt text-white mr-2" aria-hidden="true"></i><span>Kurikulum</span>
                    </a>
                </li>
                <li class="mb-4">
                    <a href="{{ route('Operator.MataPelajaran.index') }}" class="flex items-center text-white p-2 rounded-lg hover:bg-blue-500" tabindex="0">
                        <i class="fas fa-book text-white mr-2" aria-hidden="true"></i><span>Mata Pelajaran</span>
                    </a>
                </li>
                <li class="mb-4">
                    <a href="{{ route('Operator.Kelas.index') }}" class="flex items-center text-white p-2 rounded-lg hover:bg-blue-500" tabindex="0">
                        <i class="fas fa-home text-white mr-2" aria-hidden="true"></i><span>Kelas</span>
                    </a>
                </li>
                <li class="mb-4">
                    <a href="{{ route('Operator.Guru.index') }}" class="flex items-center text-white p-2 rounded-lg shadow hover:bg-blue-500 active" tabindex="0" aria-current="page">
                        <i class="fas fa-chalkboard-teacher text-white mr-2" aria-hidden="true"></i><span>Daftar Guru</span>
                    </a>
                </li>
                <li class="mb-4">
                    <a href="{{ route('Operator.Siswa.index') }}" class="flex items-center text-white p-2 rounded-lg hover:bg-blue-500" tabindex="0">
                        <i class="fas fa-user-graduate text-white mr-2" aria-hidden="true"></i><span>Daftar Siswa</span>
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Main Content -->
        <main class="main-content" role="main">
            <div class="bg-white p-6 rounded-lg shadow-md h-full w-full">
                <form action="{{ route('Operator.Guru.update', $guru->id_guru) }}" method="POST" class="space-y-6" novalidate>
                    @csrf
                    @method('PATCH')
                    <div class="mb-4">
                        <label class="block font-bold mb-2">NIP</label>
                        <input type="number" value="{{ old('nip', $guru->nip) }}" maxlength="20" pattern="\d{20}" name="nip"
                            class="block w-full p-2 border border-gray-300 rounded-md">
                        @error('nip')
                            <span class="alert-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label class="block font-bold mb-2">Nama Guru</label>
                        <input type="text" name="name" value="{{ old('nama_guru', $guru->nama_guru) }}"
                            class="block w-full p-2 border border-gray-300 rounded-md">
                        @error('name')
                            <span class="text-red-500 text-sm">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label class="block font-bold mb-2">Email</label>
                        <input type="email" name="email" value="{{ old('email', $guru->user->email) }}"
                            class="block w-full p-2 border border-gray-300 rounded-md">
                        @error('email')
                            <span class="text-red-500 text-sm">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="status">Status Aktif<span class="text-red-500">*</span></label>
                        <select id="status" name="status">
                            <option value="Aktif"
                                {{ old('status', $guru->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="Tidak Aktif"
                                {{ old('status', $guru->status) == 'Tidak Aktif' ? 'selected' : '' }}>Tidak
                                Aktif</option>
                        </select>
                        @error('status')
                            <span class="alert-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <!-- Password Field -->
<div class="mb-4">
    <label class="block font-bold mb-2">Password</label>
    <input type="password" name="password"
        class="block w-full p-2 border border-gray-300 rounded-md">
    @error('password')
        <span class="text-red-500 text-sm">{{ $message }}</span>
    @enderror
</div>

<!-- Confirm Password Field -->
<div class="mb-4">
    <label class="block text-gray-700 font-bold mb-2">Konfirmasi Password<span class="text-red-500">*</span></label>
    <input type="password" name="password_confirmation"
        class="w-full border border-gray-300 p-2 rounded-md">
    @error('password_confirmation')
        <span class="text-red-500 text-sm">{{ $message }}</span>
    @enderror
</div>

                    <div class="flex justify-end mt-4">
                        <button type="submit"
                            class="bg-green-500 text-white px-4 py-2 rounded-lg flex items-center hover:bg-green-400">
                            <span>Simpan</span>
                            <i class="fas fa-check ml-2"></i>
                        </button>
                    </div>
                </form>                    
            </div>
        </main>
    </div>

    <script>
        function toggleDropdown() {
            const dropdown = document.getElementById("dropdown-menu");
            dropdown.classList.toggle("show");
        }
    </script>
</body>

</html>