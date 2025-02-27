<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QuizHub - Login</title>
</head>
<body>
    <h1>QuizHub</h1>
    <p>Welcome</p>
    <p>By signing in you are agreeing our <a href="#">Term and privacy policy</a></p>
    <form action="/login" method="POST">
        @csrf
        <label for="username">USERNAME</label>
        <input type="text" id="username" name="username" required>
        <label for="password">PASSWORD</label>
        <input type="password" id="password" name="password" required>
        <button type="submit">LOGIN</button>
    </form>
</body>
</html>