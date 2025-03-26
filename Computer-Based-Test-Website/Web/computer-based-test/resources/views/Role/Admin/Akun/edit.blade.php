<html>
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="flex flex-col h-screen">
        <!-- Header -->
        <div class="flex justify-between items-center p-4 bg-white shadow-md">
            <div></div>
            <div class="flex items-center">
                <span class="text-gray-500 mr-2">Hallo</span>
                <span class="text-blue-600 font-bold mr-2">Admin</span>
                <div class="w-8 h-8 bg-teal-400 rounded-full"></div>
            </div>
        </div>
        <div class="flex flex-1 flex-col lg:flex-row">
            <!-- Sidebar -->
            <div class="w-full md:w-1/5 bg-gray-200 h-auto md:h-screen p-4">
                <div class="text-center mb-8">
                    <h1 class="text-2xl font-bold text-teal-500">QUIZHUB</h1>
                </div>
                <div class="mb-4">
                    <div class="flex items-center p-2 bg-white rounded-lg shadow-md">
                        <i class="fas fa-user-circle text-2xl text-teal-500"></i>
                        <span class="ml-2 text-lg font-semibold">Operator</span>
                    </div>
                </div>
                <div>
                    <div class="flex items-center p-2 bg-white rounded-lg shadow-md">
                        <i class="fas fa-id-card text-2xl text-teal-500"></i>
                        <span class="ml-2 text-lg font-semibold">Bisnis</span>
                    </div>
                </div>
            </div>
            <!-- Main Content -->
            <div class="w-full lg:w-3/4 p-8">
                <form class="space-y-6">
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Nama Sekolah<span class="text-red-500">*</span></label>
                        <input type="text" class="w-full border border-gray-400 p-2 rounded-lg">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Username<span class="text-red-500">*</span></label>
                        <input type="text" class="w-full border border-gray-400 p-2 rounded-lg">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Password<span class="text-red-500">*</span></label>
                        <input type="password" class="w-full border border-gray-400 p-2 rounded-lg">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Konfirmasi Password<span class="text-red-500">*</span></label>
                        <input type="password" class="w-full border border-gray-400 p-2 rounded-lg">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Durasi (Bulan)<span class="text-red-500">*</span></label>
                        <input type="text" class="w-full border border-gray-400 p-2 rounded-lg">
                    </div>
                    <div class="flex justify-end">
                        <button class="bg-green-500 text-white px-4 py-2 rounded-lg flex items-center">
                            <span>Simpan</span>
                            <i class="fas fa-check ml-2"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>