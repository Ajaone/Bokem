<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $username = trim($_POST['username']);
    $password_input = $_POST['password'];

    // Validasi email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Email tidak valid.");
    }

    // Validasi username
    if (strlen($username) < 3 || strlen($username) > 32) {
        die("Username harus 3–32 karakter.");
    }

    if (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
        die("Username hanya boleh huruf, angka, dan underscore.");
    }

    // Validasi password
    if (strlen($password_input) < 8 ||
        !preg_match('/[A-Z]/', $password_input) ||
        !preg_match('/[0-9]/', $password_input) ||
        !preg_match('/[\W_]/', $password_input)) {
        die("Password minimal 8 karakter, dan harus mengandung huruf besar, angka, dan simbol.");
    }

    // Buat salt manual
    $salt = bin2hex(random_bytes(16));

    // Hash password dengan salt manual (sha256)
    $password_hash = hash('sha256', $salt . $password_input);

    $stmt = $pdo->prepare("INSERT INTO users (email, username, password, salt) VALUES (?, ?, ?, ?)");
    try {
        $stmt->execute([$email, $username, $password_hash, $salt]);
        echo "Registrasi berhasil. Akun untuk " . htmlspecialchars($username) . " <a href='login.php'>Login</a>";
    } catch (PDOException $e) {
        echo "Registrasi gagal: " . htmlspecialchars($e->getMessage());
    }
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
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

        .register-box {
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
        input[type="password"],
        input[type="email"] {
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

        .login-link {
            text-align: center;
            margin-top: 12px;
            font-size: 13px;
        }

        .login-link a {
            color: #007bff;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <form class="register-box" method="POST" action="register.php">
        <h2>Register Disini</h2>

        <label for="email">Email</label>
        <input type="email" name="email" required>

        <label for="username">Username</label>
        <input type="text" name="username" required>

        <label for="password">Password</label>
        <input type="password" name="password" required>

        <button class="btn" type="submit">Daftar</button>

        <div class="login-link">
            <a href="login.php">Sudah punya akun? Login disini.</a>
        </div>
    </form>

</body>
</html>

