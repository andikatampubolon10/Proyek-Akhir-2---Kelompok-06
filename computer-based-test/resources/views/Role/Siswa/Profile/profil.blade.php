<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/your-kit-code.js" crossorigin="anonymous"></script>

    <style>
        .active-feedback {
            transform: scale(0.95);
            transition: transform 0.2s ease-in-out, background-color 0.2s;
            background-color: #2563eb !important;
            color: white !important;
        }
    </style>

</head>
<body class="bg-gray-100 flex flex-col items-center justify-center min-h-screen p-4">

    <!-- Foto Profil -->
    <div class="w-24 h-24 rounded-full overflow-hidden bg-gray-300 flex items-center justify-center shadow-lg">
        <img src="{{ asset('images/' . $student['photo']) }}" alt="Profile" class="w-full h-full object-cover">
    </div>

    <!-- Profil Form -->
    <div class="w-full max-w-sm mt-6 space-y-4">

        <!-- Nama -->
        <div class="clickable flex items-center bg-blue-100 border border-blue-300 rounded-lg p-3 transition duration-200 cursor-pointer hover:bg-blue-200 active:scale-95 shadow-md">
            <i class="fas fa-user mr-3 text-gray-500"></i>
            <div>
                <label class="text-gray-500 text-sm">Nama</label>
                <div class="text-gray-900 font-semibold">{{ $student['name'] }}</div>
            </div>
        </div>

        <!-- NIS -->
        <div class="clickable flex items-center bg-blue-100 border border-blue-300 rounded-lg p-3 transition duration-200 cursor-pointer hover:bg-blue-200 active:scale-95 shadow-md">
            <i class="fas fa-id-badge mr-3 text-gray-500"></i>
            <div>
                <label class="text-gray-500 text-sm">NIS</label>
                <div class="text-gray-900 font-semibold">{{ $student['nis'] }}</div>
            </div>
        </div>

        <!-- Kelas -->
        <div class="clickable flex items-center bg-blue-100 border border-blue-300 rounded-lg p-3 transition duration-200 cursor-pointer hover:bg-blue-200 active:scale-95 shadow-md">
            <i class="fas fa-school mr-3 text-gray-500"></i>
            <div>
                <label class="text-gray-500 text-sm">Kelas</label>
                <div class="text-gray-900 font-semibold">Kelas {{ $student['kelas'] }}</div>
            </div>
        </div>

        <!-- Tombol Logout -->
        <button id="logoutBtn" class="w-full bg-blue-600 text-white font-semibold py-2 rounded-lg shadow-md hover:bg-blue-700 active:scale-95 transition duration-200">
            🔒 Keluar
        </button>

    </div>

    <script>
        // Konfirmasi saat logout
        document.getElementById('logoutBtn').addEventListener('click', function() {
            if (confirm("Apakah Anda yakin ingin keluar?")) {
                alert("Anda telah keluar!");
            }
        });
    </script>
</body>
</html>
