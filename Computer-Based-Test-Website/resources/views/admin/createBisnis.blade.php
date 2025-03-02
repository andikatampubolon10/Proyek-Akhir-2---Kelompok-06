<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Bisnis</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
</head>
<body class="bg-gray-100">

<div class="flex flex-col min-h-screen">
    <!-- Header -->
    <header class="bg-white shadow-md">
        <div class="container mx-auto flex justify-between items-center py-4 px-6">
            <div class="flex items-center">
            <div class="flex items-center justify-center py-4">
            <img alt="QuizHub Logo" class="h-12" height="50" src="http://127.0.0.1:8000/storage/images/logo.png">
        </div>
            <span class="text-2xl font-bold text-blue-600 ml-2">QuizHub</span>
                <span class="text-sm text-gray-500 ml-2">secure your team.</span>
            </div>
            <div class="flex items-center">
                <span class="text-gray-600 mr-2">Hallo</span>
                <span class="text-blue-600 font-bold mr-2">Admin</span>
                <div class="w-8 h-8 bg-blue-600 rounded-full"></div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="flex flex-1">
        <!-- Sidebar -->
        <aside class="bg-white w-1/4 md:w-64 shadow-md">
            <div class="p-6">
                <div class="flex items-center mb-6">
                <i class="fas fa-user-circle text-2xl text-blue-500"></i>
                <span class="text-xl font-bold text-blue-600 ml-2">Operator</span>
                </div>
                <div class="flex items-center bg-blue-600 text-white rounded-lg p-4">
                <i class="fas fa-briefcase text-2xl text-yellow-500"></i>
                <span class="text-lg font-bold ml-2">Bisnis</span>
                </div>
            </div>
        </aside>

    <!-- Main Content -->
    <div class="flex flex-1">
        <main class="flex-1 p-6">
            <h1 class="text-2xl font-semibold mb-6">Tambah Bisnis</h1>
            @if (session('success'))
                <div class="bg-green-500 text-white p-3 rounded-lg mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Perbaikan utama: mengubah method dan action form -->
            <form action="{{ route('admin.storeBisnis') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-lg font-bold text-gray-700">Nama Sekolah</label>
                    <input type="text" id="name" name="name" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500" required value="{{ old('name') }}">
                    @error('name')
                        <div class="text-red-500 mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="revenue" class="block text-lg font-bold text-gray-700">Pendapatan</label>
                    <input type="text" id="revenue" name="revenue" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500" required value="{{ old('revenue') }}" onkeyup="formatRupiah(this)">
                    @error('revenue')
                        <div class="text-red-500 mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-green-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-green-600 flex items-center">
                        <span>Submit</span>
                        <i class="fas fa-check ml-2"></i>
                    </button>
                </div>
            </form>

        </main>
    </div>
</div>

<script>
    function formatRupiah(angka) {
        var number_string = angka.value.replace(/[^,\d]/g, '').toString();
        var split = number_string.split(',');
        var remainder = split[0].length % 3;
        var rupiah = split[0].substr(0, remainder);
        var thousands = split[0].substr(remainder).match(/\d{3}/gi);
        
        if (thousands) {
            var separator = remainder ? '.' : '';
            rupiah += separator + thousands.join('.');
        }
        
        rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
    }
</script>

</body>
</html>