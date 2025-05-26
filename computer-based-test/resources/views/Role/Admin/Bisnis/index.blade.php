<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <title>
        QUIZHUB - Admin
    </title>
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

        /* Main Content Box */
        .main-content-box {
            padding: 30px;
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }
        </style>
</head>


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
                <img alt="Profile picture" class="rounded-full ml-4" height="50" src="https://storage.googleapis.com/a1aa/image/sG3g-w8cayIo0nXWyycQx8dmzPb0_0-Zc6iv6Fls36s.jpg" width="50">
            </div>
            <div id="dropdown-menu" class="dropdown-menu">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 w-full text-left">Logout</button>
                </form>
            </div>
        </div>
    </div>

 


        <div class="flex flex-col md:flex-row">
        <!-- Sidebar -->
        <div class="sidebar">
            <ul>
                <li class="mb-4">
                    <a href="{{ route('Admin.Akun.index') }}" class="flex items-center text-white p-2 rounded-lg hover:bg-blue-500">
                        <i class="fas fa-calendar-alt text-white mr-2"></i> Operator
                    </a>
                </li>
                <li class="mb-4">
                    <a href="{{ route('Admin.Bisnis.index') }}" class="flex items-center text-black shadow p-2 rounded-lg hover:bg-blue-500">
                        <i class="fas fa-book text-black mr-2"></i> Bisnis
                    </a>
                </li>
            </ul>
        </div>
        
        <!-- Main Content -->
         
     <div class="main-content">
 
                <div class="flex justify-end mb-4">
                <a href="{{ route('Admin.Bisnis.create') }}"
                     class="bg-green-500 text-white px-4 py-2 rounded-lg flex items-center hover:bg-green-400">
                    <i class="fas fa-plus mr-2"></i> Tambahkan 
                </a>
            </div>
            <h2 class="text-xl font-bold mb-4 text-blue-600">Informasi Operator</h2>
            @foreach ($bisnises as $bisnis)
                <section
                    class="bg-white rounded-2xl shadow-lg p-6 flex flex-col md:flex-row justify-between items-start md:items-center space-y-4 md:space-y-0 md:space-x-6">
                    <div class="flex flex-col space-y-2 max-w-xl">
                        <h2 class="text-2xl font-bold text-teal-700">
                            {{ $bisnis['nama_sekolah'] }}
                        </h2>
                        <p class="text-gray-700 text-base">
                            Email:
                            <span class="font-semibold text-black">
                                {{ $bisnis->jumlah_pendapatan}}
                            </span>
                        </p>
                        
                        
                    </div>
                    <div class="flex space-x-6">
                        <form action="{{ route('Admin.Bisnis.destroy', $bisnis->id_bisnis) }}"
                            class="flex items-center" method="POST"
                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun ini?');">
                            @csrf
                            @method('DELETE')
                            <button
                                class="flex items-center space-x-2 text-red-600 hover:text-red-500 font-semibold transition-transform duration-300 transform hover:scale-110"
                                type="submit">
                                <i class="fas fa-trash-alt text-lg">
                                </i>
                                <span>
                                    Hapus
                                </span>
                            </button>
                        </form>
                        <form action="{{ route('Admin.Bisnis.edit', $bisnis->id_bisnis) }}" class="flex items-center"
                            method="GET">
                            <button
                                class="flex items-center space-x-2 text-teal-700 hover:text-teal-500 font-semibold transition-transform duration-300 transform hover:scale-110"
                                type="submit">
                                <i class="fas fa-edit text-lg">
                                </i>
                                <span>
                                    Edit
                                </span>
                            </button>
                        </form>
                    </div>
                </section>
            @endforeach
        </main>
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
        // Dropdown toggle
        const userBtn = document.getElementById('userBtn');
        const dropdownMenu = document.getElementById('dropdown-menu');

        userBtn.addEventListener('click', () => {
            const isExpanded = userBtn.getAttribute('aria-expanded') === 'true';
            userBtn.setAttribute('aria-expanded', !isExpanded);
            dropdownMenu.classList.toggle('hidden');
        });

        // Close dropdown if clicked outside
        window.addEventListener('click', (e) => {
            if (!userBtn.contains(e.target) && !dropdownMenu.contains(e.target)) {
                dropdownMenu.classList.add('hidden');
                userBtn.setAttribute('aria-expanded', 'false');
            }
        });

        // Modal logic
        const successModal = document.getElementById('successModal');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const closeModalBtnFooter = document.getElementById('closeModalBtnFooter');

        function closeModal() {
            successModal.classList.add('hidden');
        }

        closeModalBtn?.addEventListener('click', closeModal);
        closeModalBtnFooter?.addEventListener('click', closeModal);

        // Show modal if session success exists
        @if (session('success'))
            successModal.classList.remove('hidden');
            setTimeout(() => {
                closeModal();
            }, 3000);
        @endif

            // Function to toggle dropdown visibility
        function toggleDropdown() {
           const dropdown = document.getElementById("dropdown-menu");
           dropdown.classList.toggle("show");
       }
    </script>
</body>

</html>