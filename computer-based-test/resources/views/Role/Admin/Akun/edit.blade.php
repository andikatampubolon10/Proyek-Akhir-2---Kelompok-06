<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QUIZHUB - Nilai Mahasiswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
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

        /* Sidebar Styles */
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

        /* Main Content */
        .main-content {
            margin-left: 280px;
            padding: 100px 30px 30px;
            flex: 1;
            transition: all 0.3s ease-in-out;
            overflow-y: auto;
        }

        /* Content Box */
        .main-content-box {
            padding: 30px;
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        /* Form Container */
        .form-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            max-width: auto;
            margin: 0 auto;
        }

        /* Form Elements */
        .form-container label {
            font-size: 16px;
            font-weight: 600;
            color: #333;
            margin-bottom: 10px;
            display: inline-block;
        }

        .form-container input[type="text"],
        .form-container input[type="email"],
        .form-container input[type="password"],
        .form-container input[type="number"] {
            width: 100%;
            padding: 12px 18px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            color: #333;
            background-color: #f9f9f9;
            margin-bottom: 20px;
            transition: border 0.3s ease;
        }

        .form-container input[type="text"]:focus,
        .form-container input[type="email"]:focus,
        .form-container input[type="password"]:focus,
        .form-container input[type="number"]:focus {
            border-color: #00bfae;
            outline: none;
        }

        /* Submit Button */
        .form-container button[type="submit"] {
            width: 100%;
            padding: 15px;
            background-color: #00bfae;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .form-container button[type="submit"]:hover {
            background-color: #00796b;
        }

        /* Breadcrumb Styling */
        .breadcrumb {
            background-color: #ffffff;
            padding: 10px 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            font-size: 16px;
            font-weight: 600;
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
                    <span class="text-white">Admin</span>

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
            <ul>
                <li class="mb-4">
                    <a href="{{ route('Admin.Akun.index') }}"
                        class="flex items-center text-black shadow p-2 rounded-lg hover:bg-blue-500">
                        <i class="fas fa-calendar-alt text-black mr-2"></i> Operator
                    </a>
                </li>
                <li class="mb-4">
                    <a href="{{ route('Admin.Bisnis.index') }}"
                        class="flex items-center text-white p-2 rounded-lg hover:bg-blue-500">
                        <i class="fas fa-book text-white mr-2"></i> Bisnis
                    </a>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('Admin.Akun.index') }}">Akun</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tambah Akun</li>
                </ol>
                <div class="form-container">
                    <form action="{{ route('Admin.Akun.update', $operator->id_operator) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="nama_sekolah">Nama Sekolah<span class="text-red-500">*</span></label>
                            <input type="text" id="nama_sekolah" name="nama_sekolah"
                                value="{{ old('nama_sekolah', $operator['nama_sekolah']) }}" required>
                            @error('nama_sekolah')
                                <span class="alert-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Email<span class="text-red-500">*</span></label>
                            <input type="email" id="email" name="email"
                                value="{{ old('email', $operator->user['email']) }}" required>
                            @error('email')
                                <span class="alert-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="status">Status Aktif<span class="text-red-500">*</span></label>
                            <select id="status" name="status">
                                <option value="Aktif"
                                    {{ old('status', $operator->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="Tidak Aktif"
                                    {{ old('status', $operator->status) == 'Tidak Aktif' ? 'selected' : '' }}>Tidak
                                    Aktif</option>
                            </select>
                            @error('status')
                                <span class="alert-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password">Password<span class="text-red-500">*</span></label>
                            <input type="password" id="password" name="password">
                            @error('password')
                                <span class="alert-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Konfirmasi Password<span
                                    class="text-red-500">*</span></label>
                            <input type="password" id="password_confirmation" name="password_confirmation">
                            @error('password_confirmation')
                                <span class="alert-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex justify-end">
                            <button type="submit"
                                class="bg-green-500 text-white px-4 py-2 rounded-lg flex items-center hover:bg-green-400">
                                <span>Simpan</span>
                                <i class="fas fa-check ml-2"></i>
                            </button>
                        </div>
                    </form>
                </div>
        </div>
    </div>

    <script>
        // Function to toggle dropdown visibility
        function toggleDropdown() {
            const dropdown = document.getElementById("dropdown-menu");
            dropdown.classList.toggle("show");
        }
    </script>
</body>

</html>
