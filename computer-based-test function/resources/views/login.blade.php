<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg, black, #00bfae, black, #00796b, black);
        }

        .container {
            width: 400px;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group .error-message {
            color: red;
            font-size: 12px;
        }

        .btn {
            width: 100%;
            padding: 10px;
            background: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .btn:hover {
            background: #0056b3;
        }

        /* Style for pop-up modal */
        .popup {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            display: none;
            animation: popupAnimation 0.5s ease;
        }

        .popup h4 {
            margin: 0;
        }

        .popup .popup-content {
            margin-top: 10px;
            font-size: 16px;
            text-align: center;
        }

        /* Pop-up animation */
        @keyframes popupAnimation {
            0% {
                opacity: 0;
                transform: translate(-50%, -60%);
            }

            100% {
                opacity: 1;
                transform: translate(-50%, -50%);
            }
        }

        .btn-close {
            margin-top: 10px;
            padding: 5px 10px;
            background: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-close:hover {
            background: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="text-center mb-4">
            <img src="{{ asset('images/logo.png') }}" alt="QuizHub Logo" class="w-32 mx-auto">
        </div>
        <form id="loginForm" action="{{ route('login') }}" method="POST" onsubmit="return validateForm(event)">
            @csrf
            <div class="form-group">
                <label for="email">Email *</label>
                <input type="email" id="email" name="identifier" class="form-control" placeholder="Email" required>
                <span id="emailError" class="error-message"></span>
            </div>
            <div class="form-group">
                <label for="password">Password *</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
                <span id="passwordError" class="error-message"></span>
            </div>
            <button type="submit" class="btn btn-primary">Masuk</button>
        </form>
    </div>

     <!-- Pop-up Modal -->
     <div id="popup" class="popup">
        <h4 id="popupTitle">Login Status</h4>
        <div class="popup-content" id="popupContent"></div>
        <button class="btn-close" onclick="closePopup()">Tutup</button>
    </div>

    <script>
        // Function to show pop-up with message and title
        function showPopup(title, message) {
            document.getElementById("popupTitle").innerText = title;
            document.getElementById("popupContent").innerText = message;
            document.getElementById("popup").style.display = "block";
        }

        // Function to close the pop-up
        function closePopup() {
            document.getElementById("popup").style.display = "none";
        }

        // Function to validate the login form
        function validateForm(event) {
            event.preventDefault(); // Prevent form submission

            let isValid = true;

            document.getElementById("emailError").innerText = "";
            document.getElementById("passwordError").innerText = "";

            const email = document.getElementById("email").value;
            const password = document.getElementById("password").value;

            if (email === "" || !email.includes('@')) {
                document.getElementById("emailError").innerText = "Email tidak valid";
                isValid = false;
            }

            if (password === "" || password.length < 6) {
                document.getElementById("passwordError").innerText = "Password tidak valid";
                isValid = false;
            }

            if (isValid) {
                // Check if there is any error message from backend (flash session)
                let errorMessage = "{{ session('error') }}"; // Get error from session

                if (errorMessage) {
                    // If there's an error message, show it in pop-up
                    showPopup("Login Gagal", errorMessage);
                } else {
                    // If login is successful, show the success pop-up
                    showPopup("Login Berhasil", "Selamat datang! Anda berhasil masuk.");
                    setTimeout(function () {
                        document.getElementById("loginForm").submit(); // Submit the form after 2 seconds
                    }, 2000);
                }
            } else {
                showPopup("Login Gagal", "Periksa kembali email dan password Anda.");
            }

            return false; // Prevent form submission until pop-up is displayed
        }

        // Check if there's any error in session to display pop-up
        @if(session('error'))
            showPopup("Login Gagal", "{{ session('error') }}");
        @endif
    </script>

</body>

</html>
