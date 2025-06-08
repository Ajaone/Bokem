<?php
session_start();
require 'db.php';

$max_attempts = 5;
$lockout_time = 300;

if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
    $_SESSION['last_attempt_time'] = time();
}

if ($_SESSION['login_attempts'] >= $max_attempts) {
    $elapsed = time() - $_SESSION['last_attempt_time'];
    if ($elapsed < $lockout_time) {
        die("Terlalu banyak percobaan login. Silakan coba lagi dalam " . (int)($lockout_time - $elapsed) . " detik.");
    } else {
        $_SESSION['login_attempts'] = 0;
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
    $password_input = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user) {
        $salt = $user['salt'];

        $hashed_input = hash('sha256', $salt . $password_input);

        if (hash_equals($user['password'], $hashed_input)) {
            session_regenerate_id(true);
            $_SESSION['user'] = $user['username'];
            $_SESSION['login_attempts'] = 0;
            header("Location: home.php");
            exit;
        }
    }

    $_SESSION['login_attempts']++;
    $_SESSION['last_attempt_time'] = time();
    echo "Login gagal! Percobaan ke-{$_SESSION['login_attempts']} dari $max_attempts";
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            margin: 0;
            padding: 0;
            background: #f5f6f7;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-box {
            background: white;
            padding: 30px 40px;
            border-radius: 6px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 360px;
        }

        h2 {
            text-align: center;
            margin-bottom: 24px;
            font-weight: 600;
            color: #333;
        }

        label {
            font-size: 14px;
            display: block;
            margin-bottom: 6px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 16px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        .btn {
            width: 100%;
            padding: 10px;
            background-color: #ec1b7b;
            color: white;
            border: none;
            border-radius: 4px;
            font-weight: bold;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #d3176c;
        }

        .register-link {
            text-align: center;
            margin-top: 12px;
            font-size: 13px;
        }

        .register-link a {
            color: #007bff;
            text-decoration: none;
        }

        .register-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <form class="login-box" method="POST" action="login.php">
        <h2>Log In Disini</h2>

        <label for="username">Username</label>
        <input type="text" name="username" required>

        <label for="password">Password</label>
        <input type="password" name="password" required>
        
        <button class="btn" type="submit">Masuk</button>

        <div class="register-link">
            <a href="register.php">Buat Akun disini.</a>
        </div>
    </form>

</body>
</html>
