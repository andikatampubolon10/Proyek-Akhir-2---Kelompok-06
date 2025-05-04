<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QUIZHUB - Nilai Mahasiswa</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        /* General Styles */
        body {
            background-color: #f4f5f7;
            font-family: 'Roboto', sans-serif;
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
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .header .user-info span {
            font-size: 18px;
            font-weight: 600;
            text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.3);
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
            font-size: 28px;
            margin-right: 15px;
            transition: transform 0.3s ease, color 0.3s ease;
        }

        .sidebar a.active i {
            color: #fff;
            transform: scale(1.2);
        }

        .sidebar a:hover {
            background-color: #004d40;
            color: white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        /* Main Content */
        .main-content {
            margin-left: 270px;
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

        .actions-btns {
            display: flex;
            gap: 15px;
        }

        .actions-btns i {
            font-size: 22px;
            color: #00796b;
            cursor: pointer;
            transition: transform 0.3s ease, color 0.3s ease;
        }

        .actions-btns i:hover {
            transform: scale(1.2);
            color: #00bfae;
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
            <a href="{{ route('Admin.Akun.index') }}" class="d-flex align-items-center text-gray-700 p-2 rounded-lg  hover:bg-gray-300">
                <i class="fa-solid fa-circle-user mr-4"></i>
                Operator
            </a>

            <a href="{{ route('Admin.Bisnis.index') }}" class="d-flex align-items-center text-gray-700 p-2 rounded-lg shadow hover:bg-gray-300">
                <i class="fa-solid fa-money-bill-wave mr-4"></i>
                Bisnis
            </a>
        </div>

        <!-- Main Content -->
        <div class="main-content">
           
                <!-- Action Button -->
                <div class="d-flex justify-content-end mb-4">
                    <a href="{{ route('Admin.Bisnis.create') }}" class="btn btn-success d-flex align-items-center">
                        <i class="fas fa-plus mr-2"></i> Tambahkan
                    </a>
                </div>
                <div class="bg-white p-4 md:p-6 rounded-lg shadow-md">
                    <h2 class="text-xl font-bold mb-4 text-blue-600">Bisnis Information</h2>
                    <div class="space-y-4">
                        @foreach ($bisnises as $bisnis)
                        <div class="bg-gray-100 p-4 rounded-lg flex flex-col md:flex-row justify-between items-start md:items-center">
                            <div class="mb-4 md:mb-0">
                                <h3 class="font-bold text-blue-600">{{ $bisnis->nama_sekolah }}</h3>
                                <p class="text-gray-600">Jumlah Pendapatan : {{ $bisnis->jumlah_pendapatan }}</p>
                            </div>
                            <div class="flex space-x-5">
                                <div>
                                    <form action="{{ route('Admin.Bisnis.destroy', $bisnis->id_bisnis) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 flex items-center">
                                            <i class="fas fa-trash-alt mr-1"></i> DELETE
                                        </button>
                                    </form>
                                </div>
                                <div>
                                    <form action="{{ route('Admin.Bisnis.edit', $bisnis->id_bisnis) }}" method="GET">
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
    <!-- Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Berhasil Menambahkan Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if(session('success'))
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
           @if(session('success'))
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
</body>

</html>
