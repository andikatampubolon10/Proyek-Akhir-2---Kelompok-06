<html>

<head>
    <title>QuizHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <style>
        /* Custom dropdown styles */
        .dropdown-menu {
            display: none;
        }

        .dropdown-menu.show {
            display: block;
        }
    </style>
</head>

<body class="bg-gray-100">
    <div class="flex flex-col h-screen">
        <div class="bg-white shadow p-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-teal-500">QUIZHUB</h1>
            <div class="relative dropdown">
                <div class="flex items-center cursor-pointer">
                    <div class="flex flex-col items-center">
                        <span class="text-teal-500">Hello, Guru</span>
                        <span class="text-teal-500 font-semibold">Natan Hutahean</span>
                    </div>
                    <img alt="Profile picture of Natan Hutahean" class="rounded-full ml-4" height="40"
                        src="https://storage.googleapis.com/a1aa/image/sG3g-w8cayIo0nXWyycQx8dmzPb0_0-Zc6iv6Fls36s.jpg"
                        width="40">
                </div>
                <div class="dropdown-menu absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-2 hidden">
                    <a href="{{ route('logout') }} class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Logout</a>
                </div>
            </div>
        </div>
        <div class="flex flex-1">
            <!-- Sidebar -->
            <div class="w-full md:w-1/5 bg-gray-200 h-auto md:h-full p-4">
                <div class="text-center mb-8">
                </div>
                <div class="mb-4">
                    <div class="flex items-center p-2 bg-white rounded-lg shadow-md">
                        <a href = "{{ route('Guru.Course.index') }}">
                            <i class="fas fa-user-circle text-2xl text-teal-500">
                            </i>
                            <span class="ml-2 text-lg font-semibold">
                                Course
                            </span>
                        </a>
                    </div>
                </div>
                <div>
                    <a href="{{ route('Guru.LatihanSoal.index') }}">
                        <div class="flex items-center p-2">
                            <i class="fas fa-id-card text-2xl text-teal-500">
                            </i>
                            <span class="ml-2 text-lg font-semibold">
                                Latihan Soal
                            </span>
                        </div>
                    </a>
                </div>
            </div>
            <div class="flex-1 p-6">
                <div class="w-full bg-white p-6 shadow-md">
                    <h1 class="text-2xl font-bold mb-4">Ujian: {{ $ujian->nama_ujian }}</h1>

                    <div class="border p-4 mb-6">
                        <div class="flex flex-col space-y-4">
                            <div>
                                <label class="block mb-1">ID Ujian</label>
                                <input type="text" class="border p-2 w-full" value="{{ $ujian->id_ujian }}"
                                    readonly />
                            </div>
                            <div>
                                <label class="block mb-1">Nama Ujian</label>
                                <input type="text" class="border p-2 w-full" value="{{ $ujian->nama_ujian }}"
                                    readonly />
                            </div>
                            <div>
                                <label class="block mb-1">Acak</label>
                                <select class="border p-2 w-full" disabled>
                                    <option value="1" {{ $ujian->acak ? 'selected' : '' }}>Ya</option>
                                    <option value="0" {{ !$ujian->acak ? 'selected' : '' }}>Tidak</option>
                                </select>
                            </div>
                            <div>
                                <label class="block mb-1">Status Jawaban</label>
                                <select class="border p-2 w-full" disabled>
                                    <option value="1" {{ $ujian->status_jawaban ? 'selected' : '' }}>Aktif</option>
                                    <option value="0" {{ !$ujian->status_jawaban ? 'selected' : '' }}>Tidak Aktif
                                    </option>
                                </select>
                            </div>
                            <div>
                                <label class="block mb-1">Grade</label>
                                <input type="text" class="border p-2 w-full" value="{{ $ujian->grade }}" readonly />
                            </div>
                            <div>
                                <label class="block mb-1">ID Kursus</label>
                                <input type="text" class="border p-2 w-full" value="{{ $ujian->id_kursus }}"
                                    readonly />
                            </div>
                            <div>
                                <label class="block mb-1">ID Guru</label>
                                <input type="text" class="border p-2 w-full" value="{{ $ujian->id_guru }}"
                                    readonly />
                            </div>
                            <div>
                                <label class="block mb-1">ID Tipe Ujian</label>
                                <input type="text" class="border p-2 w-full" value="{{ $ujian->id_tipe_ujian }}"
                                    readonly />
                            </div>
                        </div>
                    </div>

                    <h2 class="text-lg font-semibold mb-2">Jawaban</h2>

                    <div class="space-y-4">
                        @foreach ($choices as $index => $choice)
                            <div class="border p-4">
                                <div class="flex items-center mb-2">
                                    <span class="w-20">Choice {{ chr(65 + $index) }}</span>
                                    <div class="flex space-x-2 ml-4">
                                        <button class="border p-2"><i class="fas fa-list"></i></button>
                                        <button class="border p-2"><i class="fas fa-list-ol"></i></button>
                                        <button class="border p-2"><i class="fas fa-bold"></i></button>
                                    </div>
                                </div>
                                <textarea class="w-full border p-2 h-16 mb-2">{{ $choice->text }}</textarea>
                                <div class="flex items-center">
                                    <span class="w-20">Grade</span>
                                    <select class="border p-2">
                                        <option value="100%" {{ $choice->grade == '100%' ? 'selected' : '' }}>100%
                                        </option>
                                        <option value="50%" {{ $choice->grade == '50%' ? 'selected' : '' }}>50%
                                        </option>
                                        <option value="33%" {{ $choice->grade == '33%' ? 'selected' : '' }}>33%
                                        </option>
                                        <option value="25%" {{ $choice->grade == '25%' ? 'selected' : '' }}>25%
                                        </option>
                                        <option value="20%" {{ $choice->grade == '20%' ? 'selected' : '' }}>20%
                                        </option>
                                    </select>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button class="bg-green-600 text-white px-4 py-2 rounded">Upload</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script>
        function toggleDropdown(event, dropdownId) {
            event.stopPropagation();
            const dropdownMenu = document.getElementById(dropdownId);

            document.querySelectorAll('.dropdown-menu.show').forEach((menu) => {
                if (menu.id !== dropdownId) {
                    menu.classList.remove('show');
                }
            });

            dropdownMenu.classList.toggle('show');
        }

        document.addEventListener('click', function(event) {
            if (!event.target.closest('.dropdown')) {
                document.querySelectorAll('.dropdown-menu.show').forEach((menu) => {
                    menu.classList.remove('show');
                });
            }
        });

        function insertAtCursor(textarea, text) {
            const start = textarea.selectionStart;
            const end = textarea.selectionEnd;
            const value = textarea.value;
            textarea.value = value.substring(0, start) + text + value.substring(end);
            textarea.selectionStart = textarea.selectionEnd = start + text.length;
            textarea.focus();
        }

        function addList() {
            const textarea = document.querySelector('textarea');
            insertAtCursor(textarea, '- Item\n');
        }

        function addOrderedList() {
            const textarea = document.querySelector('textarea');
            insertAtCursor(textarea, '1. Item\n');
        }

        function addBold() {
            const textarea = document.querySelector('textarea');
            insertAtCursor(textarea, '**Bold Text**');
        }

        document.getElementById('imageInput').addEventListener('change', function(event) {
                    const file = event.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            addImage(e.target.result);
                        };
                        reader.readAsDataURL(file);
                    }

                    function addFileImage() {
                        const textarea = document.querySelector('textarea');
                        insertAtCursor(textarea, '[File Image](file_url)');
                    }

                    document.querySelectorAll('.icon-button').forEach(button => {
                        button.addEventListener('click', function() {
                            const action = this.getAttribute('data-action');
                            switch (action) {
                                case 'list':
                                    addList();
                                    break;
                                case 'ordered-list':
                                    addOrderedList();
                                    break;
                                case 'bold':
                                    addBold();
                                    break;
                                case 'image':
                                    addImage();
                                    break;
                                case 'file-image':
                                    addFileImage();
                                    break;
                            }
                        });
                    });
    </script>
</body>

</html>
