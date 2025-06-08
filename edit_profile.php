<!-- <?php
session_start();
require 'db.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$currentUsername = $_SESSION['user'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $newUsername = trim($_POST['username']);
    $newPassword = $_POST['password'];

    if (strlen($newUsername) < 3 || strlen($newUsername) > 32 || 
        !preg_match('/^[a-zA-Z0-9_]+$/', $newUsername)) {
        die("❌ Username harus 3–32 karakter, hanya huruf/angka/underscore.");
    }

    if (!empty($newPassword)) {
        if (strlen($newPassword) < 8 ||
            !preg_match('/[A-Z]/', $newPassword) ||
            !preg_match('/[0-9]/', $newPassword) ||
            !preg_match('/[\W_]/', $newPassword)) {
            die(" Password harus min. 8 karakter, ada huruf besar, angka, simbol.");
        }

        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE users SET username = ?, password = ? WHERE username = ?");
        $stmt->execute([$newUsername, $hashedPassword, $currentUsername]);
    } else {
        $stmt = $pdo->prepare("UPDATE users SET username = ? WHERE username = ?");
        $stmt->execute([$newUsername, $currentUsername]);
    }

    $_SESSION['user'] = $newUsername;
    header("Location: home.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Profile</title>
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

        .form-box {
            background: white;
            padding: 30px 40px;
            border-radius: 6px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 380px;
        }

        h2 {
            text-align: center;
            margin-bottom: 24px;
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
            background-color: #c8146b;
        }

        .back-link {
            text-align: center;
            margin-top: 12px;
            font-size: 13px;
        }

        .back-link a {
            color: #007bff;
            text-decoration: none;
        }

        .back-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <form class="form-box" method="POST">
        <h2>Edit Profil</h2>

        <label for="username">Username Baru</label>
        <input type="text" name="username" value="<?= htmlspecialchars($currentUsername) ?>" required>

        <label for="password">Password Baru (opsional)</label>
        <input type="password" name="password">

        <button class="btn" type="submit">Simpan Perubahan</button>

        <div class="back-link">
            <a href="home.php">← Kembali ke Beranda</a>
        </div>
    </form>

</body>
</html> -->
