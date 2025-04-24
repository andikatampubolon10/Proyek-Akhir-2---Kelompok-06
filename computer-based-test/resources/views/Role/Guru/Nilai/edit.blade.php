<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <title>QuizHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />
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
            min-height: calc(100vh - 48px);
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
    </style>
</head>

<body class="bg-[#f3f4f6] min-h-screen">
    <header class="flex justify-between items-center px-4 sm:px-6 md:px-8 py-3 text-white font-semibold text-sm"
        style="background: linear-gradient(90deg, #4f7aff 0%, #4bbf58 100%)">
        <div class="flex items-center space-x-2">
            <span class="font-extrabold text-lg select-none">
                QUIZHUB
            </span>
        </div>
    </header>

    <div id="app" class="flex-1 bg-white p-6 rounded-lg shadow-md overflow-auto max-w-4xl mx-auto my-6 w-full">
        <form action="{{ route('Guru.Persentase.update', $persentase->first()->id_kursus) }}" method="POST" class="space-y-6 w-full">
            @csrf
            @method('PUT')
        
            <h2 class="text-xl font-semibold mb-4">Edit Persentase</h2>
        
            <div class="flex flex-col space-y-6 w-full">
                <!-- Dropdown untuk Kursus -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between w-full">
                    <label for="id_kursus" class="text-sm font-medium text-gray-700 mb-1 sm:mb-0 sm:mr-4 flex-shrink-0 w-full sm:w-auto">
                        Kursus
                    </label>
                    <select name="id_kursus" id="id_kursus" class="w-full sm:max-w-xs px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="">Pilih Kursus</option>
                        @foreach ($kursus as $kursus_item)
                            <option value="{{ $kursus_item->id_kursus }}"
                                {{ $kursus_item->id_kursus == old('id_kursus', $persentase->first()->id_kursus) ? 'selected' : '' }}>
                                {{ $kursus_item->nama_kursus }}
                            </option>
                        @endforeach
                    </select>
                </div>
        
                <!-- Input untuk Persentase Kuis -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between w-full">
                    <label for="persentase_kuis" class="text-sm font-medium text-gray-700 flex-shrink-0 w-full sm:w-auto">Persentase Kuis</label>
                    <input type="number" id="persentase_kuis" name="persentase_kuis"
                        value="{{ old('persentase_kuis', $persentase->where('id_tipe_persentase', 1)->first()->persentase ?? '') }}" required
                        class="w-full sm:max-w-xs px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-right">
                </div>
        
                <!-- Input untuk Persentase UTS -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between w-full">
                    <label for="persentase_UTS" class="text-sm font-medium text-gray-700 flex-shrink-0 w-full sm:w-auto">Persentase UTS</label>
                    <input type="number" id="persentase_UTS" name="persentase_UTS"
                        value="{{ old('persentase_UTS', $persentase->where('id_tipe_persentase', 2)->first()->persentase ?? '') }}" required min="0" max="100" step="0.01"
                        class="w-full sm:max-w-xs px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-right">
                </div>
        
                <!-- Input untuk Persentase UAS -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between w-full">
                    <label for="persentase_UAS" class="text-sm font-medium text-gray-700 flex-shrink-0 w-full sm:w-auto">Persentase UAS</label>
                    <input type="number" id="persentase_UAS" name="persentase_UAS"
                        value="{{ old('persentase_UAS', $persentase->where('id_tipe_persentase', 3)->first()->persentase ?? '') }}" required min="0" max="100" step="0.01"
                        class="w-full sm:max-w-xs px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-right">
                </div>
            </div>
        
            <div id="warning-message" class="text-sm text-yellow-600 font-semibold mt-1" style="display:none;">
                Jumlah persentase tidak boleh lebih dari 100%.
            </div>
        
            <button type="submit" class="mt-6 w-full px-4 py-3 bg-green-600 text-white rounded-md hover:bg-green-700 transition flex justify-center items-center font-semibold text-lg">
                <i class="fa fa-save mr-2"></i> Simpan
            </button>
        </form>
        
    </div>
    <script>
        document.querySelector('form').addEventListener('input', function() {
            let kuis = parseFloat(document.getElementById('persentase_kuis').value) || 0;
            let uts = parseFloat(document.getElementById('persentase_UTS').value) || 0;
            let uas = parseFloat(document.getElementById('persentase_UAS').value) || 0;

            let total = kuis + uts + uas;

            if (total > 100) {
                document.getElementById('warning-message').style.display = 'block';
            } else {
                document.getElementById('warning-message').style.display = 'none';
            }
        });
    </script>

</body>

</html>
