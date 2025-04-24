<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <!-- Menggunakan Bootstrap dari CDN -->
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
            background: linear-gradient(to right, #1e3c72, #2a5298, #1e3c72, #2a5298, #1e3c72);
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
    </style>
</head>

<body>
    <div class="container">
        <h2>Sign In</h2>
        <form id="loginForm" action="{{ route('login.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="email">Email *</label>
                <input type="email" id="email" name="identifier" class="form-control" placeholder="Email" required>
                <span id="emailError" class="error-message"></span>
            </div>
            <div class="form-group">
                <label for="password">Password *</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Password"
                    required>
                <span id="passwordError" class="error-message"></span>
            </div>
            <button type="submit" class="btn btn-primary">Masuk</button>
        </form>
    </div>

    <script>
        function validateForm() {
            let isValid = true;

            // Clear previous error messages
            document.getElementById("emailError").innerText = "";
            document.getElementById("passwordError").innerText = "";

            // Get the input values
            const email = document.getElementById("email").value;
            const password = document.getElementById("password").value;

            // Validate email
            if (email === "" || !email.includes('@')) {
                document.getElementById("emailError").innerText = "Email tidak valid";
                isValid = false;
            }

            // Validate password
            if (password === "" || password.length < 6) {
                document.getElementById("passwordError").innerText = "Password tidak valid";
                isValid = false;
            }

            return isValid;
        }
    </script>
</body>

</html>