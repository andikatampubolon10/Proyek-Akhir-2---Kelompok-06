<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QUIZHUB - Nilai Mahasiswa</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
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
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: 3px solid #ffffff;
            object-fit: cover;
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease;
        }

        .header .user-info img:hover {
            transform: scale(1.1);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2); /* Add shadow on hover */
        }

        .header .user-info span {
            font-size: 18px;
            font-weight: 600;
            text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.3);
        }

        /* Dropdown Menu Styling */
        .dropdown-menu {
            position: absolute;
            top: 50px;
            right: 0;
            width: 220px;
            background-color: white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            display: none;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0s linear 0.3s;
        }

        .dropdown-menu.show {
            display: block;
            opacity: 1;
            visibility: visible;
            transition: opacity 0.3s ease;
        }

        .dropdown-menu a {
            padding: 12px;
            text-decoration: none;
            display: flex;
            align-items: center;
            color: #333;
            border-bottom: 1px solid #ddd;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }

        .dropdown-menu a:hover {
            background-color: #f1f1f1;
        }

        .dropdown-menu .logout-btn {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .dropdown-menu .logout-btn i {
            font-size: 18px;
        }

        .sidebar {
            background: linear-gradient(to bottom,#00796b, #00bfae, #00796b);
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
            font-size: 28px; /* Increase the icon size */
            margin-right: 15px;
            transition: transform 0.3s ease, color 0.3s ease; /* Smooth transition for hover effect */
        }

        .sidebar a.active i {
            color: #fff; /* Change icon color on hover or active */
            transform: scale(1.2); /* Slightly increase size on hover */
        }

        .sidebar a:hover {
            background-color: #004d40;
            color: white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
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

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tr:hover {
            background-color: #e2f2f2;
            transform: scale(1.01);
            transition: all 0.3s ease;
        }

        table td {
            vertical-align: middle;
        }

        /* Action Button Icons */
        .actions-btns button i {
            font-size: 26px; /* Increase icon size */
            margin-right: 12px;
            transition: transform 0.3s ease, color 0.3s ease, background-color 0.3s ease, box-shadow 0.3s ease; /* Smooth transition for hover effect */
            padding: 12px;
            border-radius: 50%; /* Make icons round */
            background-color: #ffffff; /* Background for the icons */
            color: #00bfae; /* Initial color */
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15); /* Add a strong shadow */
        }

        .actions-btns button:hover i {
            transform: scale(1.3); /* Slightly enlarge icon on hover */
            color: #ffffff; /* Change icon color on hover */
            background-color: #00bfae; /* Change background color on hover */
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3); /* Increase shadow on hover */
        }

        /* Action Buttons Container Styling */
        .actions-btns button {
            border: none;
            background: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 20px;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .actions-btns button:hover {
            background-color: #e5f7f5; /* Subtle background change on hover */
            transform: scale(1.1); /* Slight scaling effect on hover */
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
    </style>
</head>

<body>
  <!-- Header -->
  <div class="header">
    <div class="logo">
        <img src="{{ asset('images/logo.png') }}" alt="QuizHub Logo" class="w-32 mx-auto">
    </div>
    <div class="user-info">
        <span>Admin</span>
        <img alt="Profile picture" class="rounded-full ml-4" height="50" src="https://storage.googleapis.com/a1aa/image/sG3g-w8cayIo0nXWyycQx8dmzPb0_0-Zc6iv6Fls36s.jpg" width="50" onclick="toggleDropdown()">
        <!-- Dropdown Menu -->
        <div id="dropdown-menu" class="dropdown-menu">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn">
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </div>
</div>

    <!-- Sidebar and Main Content -->
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar">
            <a href="{{ route('Admin.Akun.index') }}" class="d-flex align-items-center text-gray-700 p-2 rounded-lg shadow hover:bg-gray-300">
                <i class="fa-solid fa-circle-user mr-4"></i>
                Operator
            </a>

            <a href="{{ route('Admin.Bisnis.index') }}" class="d-flex align-items-center text-gray-700 p-2 rounded-lg hover:bg-gray-300">
                <i class="fa-solid fa-money-bill-wave mr-4"></i>
                Bisnis
            </a>
        </div>

        <!-- Main Content -->
        <div class="main-content">
                  <!-- Breadcrumb -->
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('Admin.Bisnis.index') }}">Akun</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Tambah Akun</li>
                    </ol>
                </nav>
            <div class="w-full md:w-3/4 p-8">
                <form action="{{ route('Admin.Bisnis.update', $bisnis->id_bisnis) }}" method="POST" class="space-y-6" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')  <!-- This is for the HTTP PATCH method to update the resource -->
                
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Nama Sekolah<span class="text-red-500">*</span></label>
                        <input name="nama_sekolah" value="{{ old('nama_sekolah', $bisnis->nama_sekolah) }}" type="text" class="w-full border border-gray-400 p-2 rounded-lg" required>
                    </div>
                
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Jumlah Pendapatan<span class="text-red-500">*</span></label>
                        <input name="jumlah_pendapatan" value="{{ old('jumlah_pendapatan', $bisnis->jumlah_pendapatan) }}" type="text" class="w-full border border-gray-400 p-2 rounded-lg" required>
                    </div>
                
                    <!-- Optional: File upload input for 'perjanjian' if it's being updated -->
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Perjanjian (PDF/Word)</label>
                        <input type="file" name="perjanjian" class="w-full border border-gray-400 p-2 rounded-lg" accept=".pdf, .doc, .docx">
                    </div>
                
                    <div class="flex justify-end">
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
        // Function to toggle dropdown visibility
        function toggleDropdown() {
           const dropdown = document.getElementById("dropdown-menu");
           dropdown.classList.toggle("show");
       }
       </script>
</body>

</html>