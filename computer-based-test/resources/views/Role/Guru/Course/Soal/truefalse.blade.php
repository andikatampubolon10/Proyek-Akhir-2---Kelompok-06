<html>

<head>
    <title>QuizHub</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mathquill/0.10.1/mathquill.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mathquill/0.10.1/mathquill.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />
</head>

<body class="bg-gray-100">
    <!-- Top Bar -->
    <div class="bg-gradient-to-r from-blue-500 via-teal-500 to-green-500 shadow p-4 flex justify-between items-center w-full">
        <h1 class="text-2xl font-bold text-white">QUIZHUB</h1>
        <div class="relative dropdown">
            <div class="flex items-center cursor-pointer" id="profileDropdown">
                <div class="flex flex-col items-center">
                    <span class="text-white">Welcome, Admin</span>
                    <span class="text-white font-semibold">{{ $user->name }}</span>
                </div>
                <img alt="Profile picture" class="rounded-full ml-4" height="40" src="https://storage.googleapis.com/a1aa/image/KO6yf8wvxyOnH9pvZuXN0ujQxQrH2zDDdLtZaIA-KQ8.jpg" width="40" />
            </div>
            <div class="dropdown-menu absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-2 hidden" id="logoutDropdown">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="block px-4 py-2 text-gray-700 hover:bg-gray-100 w-full text-left" type="submit">Logout</button>
                </form>
            </div>
        </div>
    </div>
    <div class="flex flex-col md:flex-row">
        <!-- Sidebar -->
        <div class="w-full md:w-1/4 bg-gradient-to-r from-blue-600 via-teal-600 to-green-600 min-h-screen p-4">
            <ul>
                <li class="mb-4">
                    <a class="flex items-center text-white bg-green-500 p-2 rounded-lg shadow hover:bg-green-400" href="#">
                        <i class="fas fa-book mr-4"></i> Course
                    </a>
                </li>
                <li class="mb-4">
                    <a class="flex items-center text-white bg-blue-500 p-2 rounded-lg shadow hover:bg-blue-400" href="#">
                        <i class="fas fa-pencil-alt mr-4"></i> Latihan Soal
                    </a>
                </li>
                <li class="mb-4">
                    <a class="flex items-center text-white bg-green-500 p-2 rounded-lg shadow hover:bg-green-400" href="#">
                        <i class="fas fa-chart-line mr-4"></i> Nilai
                    </a>
                </li>
            </ul>
        </div>
        <!-- Main Content -->
        <div class="w-full md:w-3/4 p-4">
            <form action="{{ route('Guru.Soal.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="question_type">Tipe Soal</label>
                    <select id="question_type" name="id_tipe_soal" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="2">True / False</option>
                    </select>
                </div>
                <!-- Soal -->
                <label class="block text-gray-700 text-sm font-bold mb-2">Soal</label>
                <div class="border p-2">
                    <div class="flex space-x-2 mb-2">
                        <button class="border p-1"><i class="fas fa-list"></i></button>
                        <button class="border p-1"><i class="fas fa-bold"></i></button>
                        <input type="file" id="image-input" name="image" accept="image/*" style="display: none;">
                        <button class="border p-1" id="image-button" data-preview="image-preview"><i class="fas fa-image"></i></button>
                    </div>
                    <textarea name="soal" class="w-full border p-2" rows="4" required></textarea>
                    <div id="image-preview" class="mt-2"></div> <!-- Tempat untuk menampilkan gambar -->
                </div>
            
                <!-- Jawaban 1 -->
                <div class="border p-2 mb-4">
                    <div class="flex space-x-2 mb-2">
                        <button class="border p-1"><i class="fas fa-list"></i></button>
                        <button class="border p-1"><i class="fas fa-bold"></i></button>
                        <input type="file" id="image-input-1" accept="image/*" style="display: none;">
                        <button class="border p-1" id="image-button-1" data-preview="image-preview-1"><i class="fas fa-image"></i></button>
                    </div>
                    <textarea name="jawaban_1" placeholder="Jawaban 1" class="w-full border p-2" rows="2" required></textarea>
                    <div id="image-preview-1" class="mt-2"></div> <!-- Tempat untuk menampilkan gambar -->
                </div>
            
                <!-- Jawaban 2 -->
                <div class="border p-2 mb-4">
                    <div class="flex space-x-2 mb-2">
                        <button class="border p-1"><i class="fas fa-list"></i></button>
                        <button class="border p-1"><i class="fas fa-bold"></i></button>
                        <input type="file" id="image-input-2" accept="image/*" style="display: none;">
                        <button class="border p-1" id="image-button-2" data-preview="image-preview-2"><i class="fas fa-image"></i></button>
                    </div>
                    <textarea name="jawaban_2" placeholder="Jawaban 2" class="w-full border p-2" rows="2" required></textarea>
                    <div id="image-preview-2" class="mt-2"></div> <!-- Tempat untuk menampilkan gambar -->
                </div>

                <!-- Correct Answer Selection -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="correct_answer">Jawaban Benar</label>
                    <select id="correct_answer" name="correct_answer" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="jawaban_1">True</option>
                        <option value="jawaban_2">False</option>
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
</body>

<script>
    document.querySelectorAll('.fa-list').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const textarea = this.closest('.flex').nextElementSibling;
            textarea.value += '\n- ';
        });
    });

    document.getElementById('question_type').addEventListener('change', function() {
        var selectedValue = this.value;
        if (selectedValue) {
            window.location.href = '/Guru/Soal/create/' + selectedValue;
        }
    });

    document.querySelectorAll('.fa-bold').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const textarea = this.closest('.flex').nextElementSibling;
            const selectedText = textarea.value.substring(textarea.selectionStart, textarea.selectionEnd);
            const newText = `<strong>${selectedText}</strong>`;
            textarea.value = textarea.value.substring(0, textarea.selectionStart) + newText + textarea.value.substring(textarea.selectionEnd);
        });
    });

    // Fungsi untuk menangani gambar
    function handleImageInput(imageInput, previewElement) {
        const file = imageInput.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // Menampilkan gambar di elemen preview
                const imgTag = `<img src="${e.target.result}" alt="Gambar" style="max-width: 100%; height: auto;">`;
                previewElement.innerHTML = imgTag; // Menampilkan gambar
            };
            reader.readAsDataURL(file);
        }
    }

    // Menangani gambar untuk semua input
    document.querySelectorAll('button[id^="image-button"]').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const inputId = this.id.replace('image-button', 'image-input');
            document.getElementById(inputId).click();
        });
    });

    // Menangani perubahan pada semua input gambar
    document.querySelectorAll('input[type="file"]').forEach(input => {
        input.addEventListener('change', function() {
            const previewId = this.id.replace('image-input', 'image-preview');
            const previewElement = document.getElementById(previewId);
            handleImageInput(this, previewElement);
        });
    });
</script>

</html>