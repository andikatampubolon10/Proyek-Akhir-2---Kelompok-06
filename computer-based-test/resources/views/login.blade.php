<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <title>Login - Computer Based Test</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link
            href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&amp;display=swap"
            rel="stylesheet"
        />
        <link
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
            rel="stylesheet"
        />
        <style>
            body {
                font-family: "Poppins", sans-serif;
            }
        </style>
    </head>
    <body class="bg-white min-h-screen flex items-center justify-center px-4">
        <div
            class="max-w-4xl w-full bg-white shadow-2xl rounded-3xl flex flex-col md:flex-row overflow-hidden"
        >
            <div
                class="md:w-1/2 bg-gradient-to-tr from-green-600 to-green-700 p-10 flex flex-col justify-center relative"
            >
                <img
                    alt="Illustration of a student taking a computer-based test in a modern classroom with digital elements and futuristic style"
                    class="w-full h-auto rounded-xl mb-8"
                    height="400"
                    src="{{ asset('images/logo.png') }}" alt="Logo" class="w-32 mx-auto"
                    width="400"
                />
             
                <div
                    class="absolute bottom-6 left-10 text-green-300 text-sm flex space-x-4"
                >
                    <div class="flex items-center space-x-2">
                        <img src="{{ asset('images/del.png') }}" alt="Logo" class="w-10 mx-auto">
                        <span>Institut Teknologi Del</span>
                    </div>

                    <div class="flex items-center space-x-2">
                        
                    </div>
                    <div class="flex items-center space-x-2">
                        <img src="{{ asset('images/tut.jpg') }}" alt="Logo" class="w-10 mx-auto">
                        <span>Tut Wuri Handayani </span>
                    </div>
                </div>
            </div>
            <div class="md:w-1/2 p-10 flex flex-col justify-center">
                <h1
                    class="text-3xl font-extrabold text-gray-900 mb-6 text-center"
                >
                    Selamat Datang
                </h1>
                <form action="{{ route('login') }}" class="space-y-6" method="POST" novalidate="">
                    @csrf
                    <div>
                        <label
                            class="block text-gray-700 font-semibold mb-2"
                            for="email"
                        >
                            Email Address
                        </label>
                        <div class="relative">
                            <input
                                class="w-full border border-gray-300 rounded-lg py-3 px-4 pr-12 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition"
                                id="email"
                                name="identifier"
                                placeholder="you@example.com"
                                required=""
                                type="email"
                            />
                            <i
                                class="fas fa-envelope absolute right-4 top-3.5 text-gray-400"
                            >
                            </i>
                        </div>
                        @error('identifier')
                            <span class="alert-danger text-red-500">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div>
                        <label
                            class="block text-gray-700 font-semibold mb-2"
                            for="password"
                        >
                            Password
                        </label>
                        <div class="relative">
                            <input
                                class="w-full border border-gray-300 rounded-lg py-3 px-4 pr-12 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition"
                                id="password"
                                name="password"
                                placeholder="Enter your password"
                                required=""
                                type="password"
                            />
                            <i
                                class="fas fa-lock absolute right-4 top-3.5 text-gray-400"
                            >
                            </i>
                        </div>
                        @error('password')
                            <span class="alert-danger text-red-500">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="flex items-center justify-between">
                        <label class="inline-flex items-center text-gray-700">
                            <span class="ml-2">  </span>
                        </label>
                    </div>
                    <button
                        class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-3 rounded-lg shadow-md transition"
                        type="submit"
                    >
                        Masuk
                    </button>
                </form>
                <p class="mt-8 text-center text-gray-600">
                    <a
                        class="text-green-600 font-semibold hover:text-green-800"
                        href="#"
                    >
                    </a>
                </p>
            </div>
        </div>
    </body>
</html>
