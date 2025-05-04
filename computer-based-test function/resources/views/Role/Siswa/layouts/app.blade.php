<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frontend Layout</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
    <!-- Header Section -->
    <header>
        <div class="header-middle">
            <div class="greeting">
                <span>Hello,</span><br>
                <span class="name">Natan Hutahaean</span>
            </div>
        </div>
        <div class="header-right">
            <img class="profile-img" src="{{ asset('images/nh.JPG') }}" alt="Profile Picture">
        </div>
    </header>

    <!-- Search Bar with Hamburger Menu Aligned -->
    <div class="search-container">
        <div class="header-left">
            <div class="menu-icon" id="menu-icon">&#9776;</div>
        </div>
        {{-- <div class="search-wrapper">
            <input type="text" class="search-bar" placeholder="Search...">
        </div> --}}
    </div>

    <!-- Sidebar (hidden initially) -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-content">
            <div class="close-btn" id="close-btn">&#10006;</div>
            <ul>
                <li><a href="{{ url('/') }}">Beranda</a></li>  <!-- Link to Beranda (Home) -->
                <li><a href="{{ url('/latihan-soal') }}">Latihan Soal</a></li>  <!-- Link to Latihan Soal -->
                <li><a href="{{ url('/kategori_course-tahun_course') }}">Kategori Course</a></li>
                <li><a href="#">Raport</a></li>
                <li><a href="#">Profil</a></li>
            </ul>
                
            
        </div>
    </div>

    <div class="content">
        @yield('content')
    </div>

    <!-- JavaScript to toggle sidebar -->
    <script>
        // Get the elements
        const menuIcon = document.getElementById("menu-icon");
        const sidebar = document.getElementById("sidebar");
        const closeBtn = document.getElementById("close-btn");

        // Function to show the sidebar
        menuIcon.addEventListener("click", () => {
            sidebar.style.width = "250px"; // Make sidebar visible
        });

        // Function to hide the sidebar
        closeBtn.addEventListener("click", () => {
            sidebar.style.width = "0"; // Hide sidebar
        });
    </script>
</body>
</html>
