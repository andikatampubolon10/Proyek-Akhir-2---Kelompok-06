<html>
<head>
    <title>QuizHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="flex flex-col">
        <!-- Top Bar -->
        <div class="flex justify-between items-center p-4 bg-white shadow-md">
            <div></div>
            <div class="relative flex items-center">
                <span class="text-blue-500">Hallo</span>
                <span class="ml-1 text-blue-500 font-bold">Admin</span>
                <div class="ml-2 w-8 h-8 bg-teal-500 rounded-full relative group">
                    <div class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg hidden group-hover:block">
                        <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Logout</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex flex-col md:flex-row">
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
            <div class="w-full md:w-4/5 p-4 md:p-8">
                <div class="flex justify-end mb-4">
                    <button class="bg-green-500 text-white px-4 py-2 rounded-lg flex items-center">
                        <i class="fas fa-plus mr-2"></i> Tambahkan
                    </button>
                </div>
                <div class="bg-white p-4 md:p-6 rounded-lg shadow-md">
                    <h2 class="text-xl font-bold mb-4">Bisnis Information</h2>
                    <div class="space-y-4">
                        <div class="bg-gray-300 p-4 rounded-lg flex flex-col md:flex-row justify-between items-start md:items-center">
                            <div class="mb-4 md:mb-0">
                                <h3 class="font-bold">SHP Budi Dharma</h3>
                                <p>Username: SHP Budi Dharma</p>
                                <p>Jumlah Pendapatan : Rp15.000.000,-</p>
                            </div>
                            <div class="flex space-x-4">
                                <button class="text-red-500 flex items-center">
                                    <i class="fas fa-trash-alt mr-1"></i> DELETE
                                </button>
                                <button class="text-blue-500 flex items-center">
                                    <i class="fas fa-edit mr-1"></i> EDIT
                                </button>
                            </div>
                        </div>
                        <div class="bg-gray-300 p-4 rounded-lg flex flex-col md:flex-row justify-between items-start md:items-center">
                            <div class="mb-4 md:mb-0">
                                <h3 class="font-bold">SHP Budi Dharma</h3>
                                <p>Username: SHP Budi Dharma</p>
                                <p>Jumlah Pendapatan : Rp15.000.000,-</p>
                            </div>
                            <div class="flex space-x-4">
                                <button class="text-red-500 flex items-center">
                                    <i class="fas fa-trash-alt mr-1"></i> DELETE
                                </button>
                                <button class="text-blue-500 flex items-center">
                                    <i class="fas fa-edit mr-1"></i> EDIT
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-center mt-8">
                    <!-- Pagination buttons -->
                </div>
            </div>
        </div>
    </div>
</body>
</html>