
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
@extends('layouts.app')
@section('content')
<div class="flex items-center justify-center min-h-screen bg-gradient-to-r from-blue-900 to-purple-900">
    <div class="bg-white p-8 rounded-lg shadow-lg w-96">
        <div class="text-center mb-6">
        <img alt="QuizHub Logo" class="h-12" height="50" src="http://127.0.0.1:8000/storage/images/logo.png">
            <p class="text-gray-600">Welcome</p>
            <p class="text-gray-500 text-sm">By signing in you are agreeing to our <a href="#" class="text-blue-500">Term and privacy policy</a></p>
        </div>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input id="email" type="text" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" name="email" required autofocus>
            </div>
            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input id="password" type="password" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" name="password" required>
            </div>
            <button type="submit" class="w-full bg-blue-900 text-white py-2 rounded-lg hover:bg-blue-700">LOGIN</button>
        </form>
    </div>
</div>
@endsection
