<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Operator</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
</head>
<body class="bg-gray-100">

<div class="flex flex-col min-h-screen">
    <!-- Header -->
    <header class="bg-white shadow-md">
        <div class="container mx-auto flex justify-between items-center py-4 px-6">
        <div class="flex items-center justify-center py-4">
            <img alt="QuizHub Logo" class="h-12" height="50" src="http://127.0.0.1:8000/storage/images/logo.png">
        </div>
            <div class="flex items-center">
                <span class="text-gray-600 mr-2">Hallo</span>
                <span class="text-blue-600 font-bold mr-2">Admin</span>
                <div class="w-8 h-8 bg-blue-600 rounded-full"></div>
            </div>
        </div>
    </header>

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

        <main class="flex-1 p-6">
            <div class="flex justify-end mb-4">
            <a href="{{ route('admin.createBisnis') }}" class="bg-green-500 text-white px-4 py-2 rounded-lg flex items-center hover:bg-green-600">
    <span>Add New</span>
    <i class="fas fa-plus ml-2"></i>
</a>
</div>

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200">
                    <thead>
                        <tr class="bg-blue-800 text-white">
                            <th class="py-2 px-4 border-b">No</th>
                            <th class="py-2 px-4 border-b">Sekolah</th>
                            <th class="py-2 px-4 border-b">Pendapatan</th>
                            <th class="py-2 px-4 border-b">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($businesses as $index => $business)
                            <tr class="{{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-200' }}">
                                <td class="py-2 px-4 border-b">{{ $index + 1 }}</td>
                                <td class="py-2 px-4 border-b">{{ $business->name }}</td>
                                <td class="py-2 px-4 border-b">Rp {{ number_format($business->revenue, 0, ',', '.') }}</td>
                                <td class="py-2 px-4 border-b">
                                <form action="{{ route('admin.bisnis.destroy', $business->id) }}" method="POST" style="display:inline;">
    @csrf
    @method('DELETE')
    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg flex items-center">
        <span>Delete</span>
        <i class="fas fa-trash-alt ml-2"></i>
    </button>
</form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
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
            separator = remainder ? '.' : '';
            rupiah += separator + thousands.join('.');
        }
        
        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        angka.value = 'Rp ' + rupiah;
    }
</script>

</body>
</html>
