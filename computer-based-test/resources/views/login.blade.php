<!DOCTYPE html>
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

        .popup {
            display: none;
            padding: 20px;
            background-color: #4CAF50;
            color: white;
            border-radius: 5px;
            position: fixed;
            top: 20%;
            left: 50%;
            transform: translateX(-50%);
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
        }

        .popup.show {
            display: block;
            opacity: 1;
        }

        .alert-danger {
            color: #e74c3c;
            font-size: 14px;
            font-weight: 600;
            margin-top: 5px;
        }
    </style>
</head>

<body>
    <div class="container">
        <form id="loginForm" action="{{ route('login') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="email">Email *</label>
                <input type="email" id="email" name="identifier" class="form-control" placeholder="Email">
                @error('identifier')
                    <span class="alert-danger">
                        {{ $message }}
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="password">Password *</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Password">
                @error('password')
                    <span class="alert-danger">
                        {{ $message }}
                    </span>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Masuk</button>
        </form>
    </div>

    <!-- Popup for login success -->
    <div id="popup-success" class="popup">Login berhasil!</div>

    <script>
        // Function to display popup after successful login
        function showPopup() {
            const popup = document.getElementById('popup-success');
            popup.classList.add('show');

            // Hide popup after 3 seconds
            setTimeout(() => {
                popup.classList.remove('show');
            }, 3000);
        }

        // If session contains success, show the popup
        @if (session('success'))
            showPopup();
        @endif
    </script>
</body>

</html>
