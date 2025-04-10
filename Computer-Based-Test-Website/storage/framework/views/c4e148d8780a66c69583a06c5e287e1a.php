<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - QuizHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Impor font Poppins dari Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Terapkan font Poppins ke seluruh halaman -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="flex justify-center items-center min-h-screen bg-gradient-to-r from-blue-900 to-purple-900">

    <div class="bg-white p-8 rounded-lg shadow-lg w-96">
        <!-- Ganti teks dengan gambar logo -->
        <div class="flex justify-center">
            <img src="<?php echo e(asset('images/logo.png')); ?>" alt="QuizHub Logo" class="w-32">
        </div>

        <p class="text-center text-gray-600 text-sm mt-2">
            By signing in you are agreeing to our 
            <a href="#" class="text-blue-500">Terms and Privacy Policy</a>
        </p>

        <?php if(session('loginError')): ?>
            <p class="text-red-500 text-sm text-center mt-2"><?php echo e(session('loginError')); ?></p>
        <?php endif; ?>

        <form action="<?php echo e(route('login')); ?>" method="POST" class="mt-4">
            <?php echo csrf_field(); ?>
            <div class="mb-4">
                <input type="text" name="username" placeholder="Username" required 
                    class="w-full px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="mb-4">
                <input type="password" name="password" placeholder="Password" required 
                    class="w-full px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <button type="submit" class="w-full bg-blue-700 text-white py-2 rounded-lg hover:bg-blue-800">Login</button>
        </form>
    </div>

</body>
</html><?php /**PATH C:\Users\Nesty\OneDrive\Documents\GitHub\Proyek-Akhir-2---Kelompok-06\Computer-Based-Test-Website\resources\views/login.blade.php ENDPATH**/ ?>