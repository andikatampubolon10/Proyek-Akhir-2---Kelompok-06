<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - QuizHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex justify-center items-center min-h-screen bg-gradient-to-r from-blue-900 to-purple-900">

    <div class="bg-white p-8 rounded-lg shadow-lg w-96">
        <!-- Ganti teks dengan gambar logo -->
        <div class="flex justify-center">
            <img src="{{ asset('images/logo.png') }}" alt="QuizHub Logo" class="w-32">
        </div>

        <p class="text-center text-gray-600 text-sm mt-2">
            By signing in you are agreeing to our 
            <a href="#" class="text-blue-500">Terms and Privacy Policy</a>
        </p>

        @if(session('loginError'))
            <p class="text-red-500 text-sm text-center mt-2">{{ session('loginError') }}</p>
        @endif

        <form action="{{ route('login') }}" method="POST" class="mt-4">
            @csrf
            <div class="mb-4">
                <input type="text" name="username" placeholder="USERNAME" required 
                    class="w-full px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="mb-4">
                <input type="password" name="password" placeholder="PASSWORD" required 
                    class="w-full px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <button type="submit" class="w-full bg-blue-700 text-white py-2 rounded-lg hover:bg-blue-800">LOGIN</button>
        </form>
    </div>

</body>
</html>
