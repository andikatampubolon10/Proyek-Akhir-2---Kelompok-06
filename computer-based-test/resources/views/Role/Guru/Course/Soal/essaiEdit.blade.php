<!DOCTYPE html>
<html lang="en">

<head>
    <title>QuizHub - Edit Essay</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

        /* Dropdown Menu Styles */
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
            z-index: 1500;
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
                    <span class="text-white">Welcome, Guru</span>
                    <span class="text-white font-semibold">{{ $user->name }}</span>
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
        <div class="sidebar">
            <a href="{{ route('Guru.Course.index') }}"
                class="d-flex align-items-center text-gray-700 p-2 rounded-lg hover:bg-gray-300">
                <i class="fas fa-book-open text-sm"></i>
                <span>Course</span>
            </a>
            <a href="{{ route('Guru.Latihan.index') }}"
                class="d-flex align-items-center text-gray-700 p-2 rounded-lg hover:bg-gray-300">
                <i class="fas fa-pen text-sm"></i>
                <span>Latihan Soal</span>
            </a>
            <a href="{{ route('Guru.Nilai.index') }}"
                class="d-flex align-items-center text-gray-700 p-2 rounded-lg hover:bg-gray-300">
                <i class="fas fa-chart-line text-sm"></i>
                <span>Nilai</span>
            </a>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="bg-white p-6 rounded-lg shadow-md h-full w-full">
                <h2 class="text-2xl font-bold mb-6">Edit Soal Essay</h2>

                <form action="{{ route('Guru.Soal.update', $soal->id_soal) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="id_tipe_soal" value="{{ $soal->id_tipe_soal }}">

                    <!-- Soal -->
                    <label class="block text-gray-700 text-sm font-bold mb-2">Soal</label>
                    <div class="border p-2">
                        <div class="flex space-x-2 mb-2">
                            <button type="button" class="border p-1" id="list-button-soal"><i
                                    class="fas fa-list"></i></button>
                            <button type="button" class="border p-1" id="bold-button-soal"><i
                                    class="fas fa-bold"></i></button>
                            <button type="button" class="border p-1" id="image-button-soal"><i
                                    class="fas fa-image"></i></button>
                        </div>
                        <textarea id="soal-textarea" name="soal" class="w-full border p-2" rows="4">{{ $soal->soal }}</textarea>
                        <div id="image-preview-soal" class="mt-2">
                            @if ($soal->image)
                                <div class="relative mt-2 inline-block">
                                    <img src="{{ $soal->image_url }}" alt="Soal Image"
                                        class="max-w-full h-auto max-h-40 border rounded">
                                    <span
                                        class="absolute top-0 right-0 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center cursor-pointer"
                                        onclick="removeImage('soal')">×</span>
                                </div>
                            @endif
                        </div>
                        <input type="file" id="image-input-soal" name="image" class="hidden" accept="image/*" />
                        @error('soal')
                            <span class="alert-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Get jawaban_soal data -->
                    @php
                        $jawaban = $soal->jawaban_soal->sortBy('id_jawaban_soal')->values();
                    @endphp

                    <!-- Jawaban Essay -->
                    <div class="border p-2 mb-4 mt-4">
                        <div class="flex space-x-2 mb-2">
                            <button type="button" class="border p-1" id="list-button-1"><i
                                    class="fas fa-list"></i></button>
                            <button type="button" class="border p-1" id="bold-button-1"><i
                                    class="fas fa-bold"></i></button>
                        </div>
                        <textarea id="jawaban-1-textarea" name="jawaban_1" placeholder="Jawaban Essay" class="w-full border p-2" rows="4">{{ $jawaban[0]->jawaban ?? '' }}</textarea>
                        @error('jawaban_1')
                            <span class="alert-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Correct Answer Selection (Essay) -->
                    <div class="mb-4">
                        <input type="hidden" name="correct_answer" value="jawaban_1">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="id_latihan">Latihan</label>
                        <select name="id_latihan" id="id_latihan"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="">Pilih Latihan (Opsional)</option>
                            @foreach ($latihan as $latihans)
                                <option value="{{ $latihans->id_latihan }}"
                                    {{ $soal->id_latihan == $latihans->id_latihan ? 'selected' : '' }}>
                                    {{ $latihans->Topik }}
                                </option>
                            @endforeach
                        </select>
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
        // Dropdown toggle script
        function toggleDropdown() {
            const dropdown = document.getElementById("dropdown-menu");
            dropdown.classList.toggle("show");
        }

        // Close dropdown when clicking outside
        window.addEventListener('click', function(e) {
            const dropdown = document.getElementById("dropdown-menu");
            if (!e.target.closest('.dropdown') && dropdown.classList.contains('show')) {
                dropdown.classList.remove('show');
            }
        });

        // Setup for soal section
        // List button handler for soal
        document.getElementById('list-button-soal').addEventListener('click', function(e) {
            e.preventDefault();
            const textarea = document.getElementById('soal-textarea');
            textarea.value += '\n- ';
            textarea.focus();
        });

        // Bold button handler for soal
        document.getElementById('bold-button-soal').addEventListener('click', function(e) {
            e.preventDefault();
            const textarea = document.getElementById('soal-textarea');
            const start = textarea.selectionStart;
            const end = textarea.selectionEnd;
            const selectedText = textarea.value.substring(start, end);
            const newText = `<strong>${selectedText}</strong>`;

            textarea.value = textarea.value.substring(0, start) + newText + textarea.value.substring(end);
            textarea.focus();
            // Position cursor after the inserted text
            textarea.selectionStart = start + newText.length;
            textarea.selectionEnd = start + newText.length;
        });

        // Image button handler for soal
        document.getElementById('image-button-soal').addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('image-input-soal').click();
        });

        // Image input change handler for soal
        document.getElementById('image-input-soal').addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imgPreview = document.getElementById('image-preview-soal');
                    imgPreview.innerHTML = `
                        <div class="relative mt-2 inline-block">
                            <img src="${e.target.result}" alt="Preview" class="max-w-full h-auto max-h-40 border rounded">
                            <span class="absolute top-0 right-0 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center cursor-pointer" 
                                  onclick="removeImage('soal')">×</span>
                        </div>
                    `;
                };
                reader.readAsDataURL(file);
            }
        });

        // Setup for answer section
        // List button handler
        document.getElementById('list-button-1').addEventListener('click', function(e) {
            e.preventDefault();
            const textarea = document.getElementById('jawaban-1-textarea');
            textarea.value += '\n- ';
            textarea.focus();
        });

        // Bold button handler
        document.getElementById('bold-button-1').addEventListener('click', function(e) {
            e.preventDefault();
            const textarea = document.getElementById('jawaban-1-textarea');
            const start = textarea.selectionStart;
            const end = textarea.selectionEnd;
            const selectedText = textarea.value.substring(start, end);
            const newText = `<strong>${selectedText}</strong>`;

            textarea.value = textarea.value.substring(0, start) + newText + textarea.value.substring(end);
            textarea.focus();
            // Position cursor after the inserted text
            textarea.selectionStart = start + newText.length;
            textarea.selectionEnd = start + newText.length;
        });

        // Function to remove image
        function removeImage(section) {
            document.getElementById(`image-preview-${section}`).innerHTML = '';
            document.getElementById(`image-input-${section}`).value = '';
        }
    </script>
</body>

</html>
