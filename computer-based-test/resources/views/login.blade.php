<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - QuizHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Import font Poppins from Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .background-gradient {
            background: linear-gradient(135deg, black, #00bfae, black, #00796b, black);
        }

        .form-container {
            width: 100%;
            max-width: 400px;
            background-color: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .form-button {
            background-color: #1d4ed8;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 5px;
            width: 100%;
            font-weight: 600;
        }

        .form-button:hover {
            background-color: #2563eb;
        }

        .terms-text {
            text-align: center;
            margin-top: 1rem;
            font-size: 0.875rem;
        }

        .terms-text a {
            color: #1d4ed8;
            text-decoration: underline;
        }

        /* Popup Styles */
        .popup {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .popup-content {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            text-align: center;
            max-width: 400px;
            width: 100%;
        }
    </style>
</head>

<body class="background-gradient min-h-screen flex justify-center items-center">

    <div class="form-container">
        <!-- Replace the QUIZHUB text with an image -->
        <div class="text-center mb-4">
            <img src="{{ asset('images/logo.png') }}" alt="QuizHub Logo" class="w-32 mx-auto">
        </div>
        <p class="text-center text-sm text-gray-600 mb-6">Welcome</p>
        
        <!-- Login Form -->
        <form method="POST" action="{{ route('login') }}" id="login-form">
            @csrf

            <!-- Username Field -->
            <div class="mb-4">
                <label for="username" class="block text-sm font-semibold text-gray-700">USERNAME</label>
                <input id="username" name="identifier" type="text" class="block w-full mt-1 p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500" required autofocus placeholder="Enter your username">
            </div>

            <!-- Password Field -->
            <div class="mb-6">
                <label for="password" class="block text-sm font-semibold text-gray-700">PASSWORD</label>
                <input id="password" name="password" type="password" class="block w-full mt-1 p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500" required placeholder="Enter your password">
            </div>

            <!-- Login Button -->
            <button type="submit" class="form-button">LOGIN</button>

            <!-- Terms and Privacy Text -->
            <p class="terms-text">
                By signing in you are agreeing to our <a href="#" class="hover:underline">Terms</a> and <a href="#" class="hover:underline">privacy policy</a>
            </p>
        </form>
    </div>

   <!-- Pop-up Modal for Success/Error -->
   <div id="popup" class="popup">
        <div class="popup-content">
            <h4 id="popupTitle">Login Status</h4>
            <div class="popup-content" id="popupContent"></div>
            <button class="btn-close" onclick="closePopup()">Tutup</button>
        </div>
    </div>

<script>
    // Show popup for login errors (email/password or account status)
    @if(session('error'))
        document.getElementById("popupTitle").innerText = "Login Gagal";
        document.getElementById("popupContent").innerText = "{{ session('error') }}";
        document.getElementById("popup").style.display = "flex";
    @endif

    function closePopup() {
        document.getElementById("popup").style.display = "none";
    }
</script>

</body>

</html>
