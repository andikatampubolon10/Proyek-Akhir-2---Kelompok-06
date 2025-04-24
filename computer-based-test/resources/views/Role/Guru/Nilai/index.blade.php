<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <title>
        QuizHub
    </title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&amp;display=swap" rel="stylesheet" />
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            font-family: "Inter", sans-serif;
        }

        body {
            background-color: #f3f4f6;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        #app {
            flex: 1 1 auto;
            display: flex;
            flex-direction: column;
            min-height: calc(100vh - 56px);
            width: 100vw;
            overflow-x: hidden;
        }

        @media (min-width: 768px) {
            #app {
                flex-direction: row;
            }
        }

        nav::-webkit-scrollbar {
            width: 6px;
        }

        nav::-webkit-scrollbar-thumb {
            background-color: rgba(0, 0, 0, 0.1);
            border-radius: 3px;
        }

        /* Dropdown transition */
        #dropdownMenu {
            overflow: hidden;
            max-height: 0;
            transition: max-height 0.3s ease, padding 0.3s ease;
        }
    </style>
</head>

<body class="bg-[#f3f4f6] min-h-screen">
    <header class="flex justify-between items-center px-4 sm:px-6 md:px-8 py-4 text-white font-semibold text-sm"
        style="background: linear-gradient(90deg, #4f7aff 0%, #4bbf58 100%)">
        <div class="flex items-center space-x-2">
            <span class="font-extrabold text-lg select-none tracking-wide">
                QUIZHUB
            </span>
        </div>
        <div class="flex items-center space-x-3 text-right">
            <div class="text-xs leading-4">
                <div>
                    Welcome, Admin
                </div>
                <div class="font-bold">
                    Abet Manurung
                </div>
            </div>
            <img alt="Profile picture of a person wearing glasses and a hat" class="w-10 h-10 rounded-full object-cover"
                height="40" src="https://storage.googleapis.com/a1aa/image/13555037-e294-45f7-4e6e-6e55eb283b0a.jpg"
                width="40" />
        </div>
    </header>
    <div id="app">
        <nav class="w-full md:w-56 flex-shrink-0 px-3 py-4 md:py-6 space-y-4 overflow-y-auto"
            style="background-image: linear-gradient(90deg, rgb(79, 122, 255) 0%, rgb(75, 191, 88) 100%);">
            <div class="flex flex-col space-y-2" id="dropdown-course">
                <button aria-haspopup="true" aria-expanded="false"
                    class="w-full flex items-center justify-between space-x-2 rounded-md bg-[#4bbf58] px-4 py-3 text-white text-sm font-semibold focus:outline-none hover:bg-[#3a9e3f] transition"
                    id="dropdownButton" type="button">
                    <span class="flex items-center space-x-2">
                        <i class="fas fa-book-open text-sm"></i>
                        <span>
                            Course
                        </span>
                    </span>
                    <i class="fas fa-chevron-down text-xs transition-transform duration-200" id="dropdownIcon"></i>
                </button>
                <ul aria-label="submenu"
                    class="flex flex-col rounded-md bg-[#4bbf58] text-white text-sm font-normal"
                    id="dropdownMenu" role="menu" style="box-shadow: 0 4px 6px rgb(0 0 0 / 0.1); padding-top: 0; padding-bottom: 0;">
                    <li>
                        <a class="block px-4 py-2 hover:bg-[#3a9e3f] cursor-pointer" href="{{ route('Guru.Ujian.create') }}" role="menuitem" tabindex="-1">
                            Ujian
                        </a>
                    </li>
                    <li>
                        <a class="block px-4 py-2 hover:bg-[#3a9e3f] cursor-pointer" href="{{ route('Guru.Soal.create') }}" role="menuitem" tabindex="-1">
                            Soal
                        </a>
                    </li>
                    <li>
                        <a class="block px-4 py-2 hover:bg-[#3a9e3f] cursor-pointer" href="{{ route('Guru.Materi.create') }}" role="menuitem" tabindex="-1">
                            Materi
                        </a>
                    </li>
                </ul>
            </div>
            <a href="{{ route('Guru.Latihan.index') }}">
                <button
                    class="w-full flex items-center space-x-2 rounded-md bg-[#4f7aff] px-4 py-3 text-white text-sm font-semibold hover:bg-[#3a5de0] transition"
                    id="latihanSoalBtn">
                    <i class="fas fa-pen text-sm"></i>
                    <span>Latihan Soal</span>
                </button>
            </a>

            <a href="{{ route('Guru.Nilai.index') }}">
                <button
                    class="w-full flex items-center space-x-2 rounded-md bg-[#4bbf58] px-4 py-3 text-white text-sm font-semibold hover:bg-[#3a9e3f] transition"
                    id="nilaiBtn">
                    <i class="fas fa-chart-line text-sm"></i>
                    <span>Nilai</span>
                </button>
            </a>
        </nav>
        <main class="flex-1 bg-white p-6 md:p-8 rounded-lg shadow-md overflow-auto max-h-[calc(100vh-88px)]">
            <h2 class="text-2xl font-bold mb-6 text-blue-600 tracking-wide">
                Course Information
            </h2>
            <div class="space-y-6">
                @foreach ($courses as $course)
                <div
                    class="p-5 border border-gray-200 rounded-lg shadow-sm flex flex-col sm:flex-row sm:items-center sm:justify-between hover:shadow-lg transition-shadow duration-300 bg-white">
                    <div class="flex items-center mb-4 sm:mb-0 sm:flex-1">
                        <img alt="Thumbnail image of the {{ $course->nama_kursus }} course"
                            class="w-28 h-28 rounded-lg mr-5 object-cover flex-shrink-0" height="112"
                            src="{{ asset('images/' . $course->image) }}" width="112" />

                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">
                                <a href="{{ route('Guru.Persentase.create') }}"
                                    class="text-blue-600 no-underline hover:underline">
                                    {{ $course->nama_kursus }}
                                </a>
                            </h3>
                        </div>
                    </div>
                    <div class="flex justify-end sm:flex-none">
                        <form action="{{ route('Guru.Persentase.edit', $course->id_kursus) }}" method="GET">
                            <button type="submit"
                                class="text-blue-600 flex items-center font-semibold hover:text-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-400 rounded">
                                <i class="fas fa-edit mr-2"></i> EDIT
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        </main>
    </div>
    <script>
        const dropdownButton = document.getElementById('dropdownButton');
        const dropdownMenu = document.getElementById('dropdownMenu');
        const dropdownIcon = document.getElementById('dropdownIcon');

        dropdownButton.addEventListener('click', () => {
            const isExpanded = dropdownButton.getAttribute('aria-expanded') === 'true';
            dropdownButton.setAttribute('aria-expanded', !isExpanded);

            if (dropdownMenu.style.maxHeight && dropdownMenu.style.maxHeight !== '0px') {
                dropdownMenu.style.maxHeight = '0px';
                dropdownMenu.style.paddingTop = '0';
                dropdownMenu.style.paddingBottom = '0';
                dropdownIcon.style.transform = 'rotate(0deg)';
            } else {
                dropdownMenu.style.maxHeight = dropdownMenu.scrollHeight + 'px';
                dropdownMenu.style.paddingTop = '0.5rem';
                dropdownMenu.style.paddingBottom = '0.5rem';
                dropdownIcon.style.transform = 'rotate(180deg)';
            }
        });

        // Close dropdown if clicked outside
        window.addEventListener('click', (e) => {
            if (!dropdownButton.contains(e.target) && !dropdownMenu.contains(e.target)) {
                dropdownMenu.style.maxHeight = '0px';
                dropdownMenu.style.paddingTop = '0';
                dropdownMenu.style.paddingBottom = '0';
                dropdownButton.setAttribute('aria-expanded', 'false');
                dropdownIcon.style.transform = 'rotate(0deg)';
            }
        });

        // Initialize dropdown closed
        dropdownMenu.style.maxHeight = '0px';
        dropdownMenu.style.overflow = 'hidden';
        dropdownMenu.style.transition = 'max-height 0.3s ease, padding 0.3s ease';
    </script>
</body>

</html>