<html>
<head>
    <title>QuizHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <style>
        /* Custom dropdown styles */
        .dropdown-menu {
            display: none;
        }
        .dropdown:hover .dropdown-menu {
            display: block;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex flex-col h-screen">
        <!-- Top Bar -->
        <div class="bg-white shadow p-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-teal-500">QUIZHUB</h1>
            <div class="relative dropdown">
                <div class="flex items-center cursor-pointer">
                    <div class="flex flex-col items-center">
                        <span class="text-teal-500">Hello, Guru</span>
                        <span class="text-teal-500 font-semibold">Natan Hutahean</span>
                    </div>
                    <img alt="Profile picture of Natan Hutahean" class="rounded-full ml-4" height="40" src="https://storage.googleapis.com/a1aa/image/sG3g-w8cayIo0nXWyycQx8dmzPb0_0-Zc6iv6Fls36s.jpg" width="40">
                </div>
                <div class="dropdown-menu absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-2 hidden">
                    <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Logout</a>
                </div>
            </div>
        </div>
        <div class="flex flex-1 flex-col md:flex-row">
            <!-- Sidebar -->
            <div class="w-full md:w-1/5 bg-gray-200 h-auto md:h-full p-4">
                <div class="text-center mb-8">
                    <h1 class="text-2xl font-bold text-teal-500">QUIZHUB</h1>
                </div>
                <div class="mb-4">
                    <div class="flex items-center p-2 bg-white rounded-lg shadow-md">
                        <i class="fas fa-user-circle text-2xl text-teal-500"></i>
                        <span class="ml-2 text-lg font-semibold">Course</span>
                    </div>
                </div>
                <div>
                    <div class="flex items-center p-2">
                        <i class="fas fa-id-card text-2xl text-teal-500"></i>
                        <span class="ml-2 text-lg font-semibold">Latihan Soal</span>
                    </div>
                </div>
            </div>
            <div class="flex-1 p-6">
                <div class="w-full bg-white p-6 shadow-md">
                    <h1 class="text-2xl font-bold mb-4">Ilmu Pengetahuan Alam</h1>
                    
                    <div class="border p-4 mb-6">
                        <div class="flex space-x-2 mb-2">
                            <button class="border p-2"><i class="fas fa-list"></i></button>
                            <button class="border p-2"><i class="fas fa-list-ol"></i></button>
                            <button class="border p-2"><i class="fas fa-bold"></i></button>
                            <button class="border p-2"><i class="fas fa-image"></i></button>
                            <button class="border p-2"><i class="fas fa-file-image"></i></button>
                        </div>
                        <textarea class="w-full border p-2 h-32"></textarea>
                    </div>
                    
                    <h2 class="text-lg font-semibold mb-2">Answere</h2>
                    
                    <div class="space-y-4">
                        <div class="border p-4">
                            <div class="flex items-center mb-2">
                                <span class="w-20">Choice A</span>
                                <div class="flex space-x-2 ml-4">
                                    <button class="border p-2"><i class="fas fa-list"></i></button>
                                    <button class="border p-2"><i class="fas fa-list-ol"></i></button>
                                    <button class="border p-2"><i class="fas fa-bold"></i></button>
                                </div>
                            </div>
                            <textarea class="w-full border p-2 h-16 mb-2"></textarea>
                            <div class="flex items-center">
                                <span class="w-20">Grade</span>
                                <select class="border p-2">
                                    <option>100%</option>
                                    <option>50%</option>
                                    <option>33%</option>
                                    <option>25%</option>
                                    <option>20%</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="border p-4">
                            <div class="flex items-center mb-2">
                                <span class="w-20">Choice B</span>
                                <div class="flex space-x-2 ml-4">
                                    <button class="border p-2"><i class="fas fa-list"></i></button>
                                    <button class="border p-2"><i class="fas fa-list-ol"></i></button>
                                    <button class="border p-2"><i class="fas fa-bold"></i></button>
                                </div>
                            </div>
                            <textarea class="w-full border p-2 h-16 mb-2"></textarea>
                            <div class="flex items-center">
                                <span class="w-20">Grade</span>
                                <select class="border p-2">
                                    <option>100%</option>
                                    <option>50%</option>
                                    <option>33%</option>
                                    <option>25%</option>
                                    <option>20%</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="border p-4">
                            <div class="flex items-center mb-2">
                                <span class="w-20">Choice C</span>
                                <div class="flex space-x-2 ml-4">
                                    <button class="border p-2"><i class="fas fa-list"></i></button>
                                    <button class="border p-2"><i class="fas fa-list-ol"></i></button>
                                    <button class="border p-2"><i class="fas fa-bold"></i></button>
                                </div>
                            </div>
                            <textarea class="w-full border p-2 h-16 mb-2"></textarea>
                            <div class="flex items-center">
                                <span class="w-20">Grade</span>
                                <select class="border p-2">
                                    <option>100%</option>
                                    <option>50%</option>
                                    <option>33%</option>
                                    <option>25%</option>
                                    <option>20%</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="border p-4">
                            <div class="flex items-center mb-2">
                                <span class="w-20">Choice D</span>
                                <div class="flex space-x-2 ml-4">
                                    <button class="border p-2"><i class="fas fa-list"></i></button>
                                    <button class="border p-2"><i class="fas fa-list-ol"></i></button>
                                    <button class="border p-2"><i class="fas fa-bold"></i></button>
                                </div>
                            </div>
                            <textarea class="w-full border p-2 h-16 mb-2"></textarea>
                            <div class="flex items-center">
                                <span class="w-20">Grade</span>
                                <select class="border p-2">
                                    <option>100%</option>
                                    <option>50%</option>
                                    <option>33%</option>
                                    <option>25%</option>
                                    <option>20%</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="border p-4">
                            <div class="flex items-center mb-2">
                                <span class="w-20">Choice E</span>
                                <div class="flex space-x-2 ml-4">
                                    <button class="border p-2"><i class="fas fa-list"></i></button>
                                    <button class="border p-2"><i class="fas fa-list-ol"></i></button>
                                    <button class="border p-2"><i class="fas fa-bold"></i></button>
                                </div>
                            </div>
                            <textarea class="w-full border p-2 h-16 mb-2"></textarea>
                            <div class="flex items-center">
                                <span class="w-20">Grade</span>
                                <select class="border p-2">
                                    <option>100%</option>
                                    <option>50%</option>
                                    <option>33%</option>
                                    <option>25%</option>
                                    <option>20%</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-6 flex justify-end">
                        <button class="bg-green-600 text-white px-4 py-2 rounded">Upload</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>