<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            margin: 0;
            padding: 0;
            background: #f5f6f7;
            height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .header {
            display: flex;
            justify-content: flex-end;
            padding: 16px 24px;
            background: white;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        }

        .header a button {
            margin-left: 12px;
            padding: 8px 16px;
            background-color: #ec1b7b;
            color: white;
            border: none;
            border-radius: 4px;
            font-weight: bold;
            cursor: pointer;
        }

        .header a button:hover {
            background-color: #c8146b;
        }

        .content {
            flex-grow: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        h2 {
            font-size: 24px;
            color: #333;
        }
    </style>
</head>
<body>

    <div class="header">
        <a href="edit_profile.php"><button>Edit Profile</button></a>
        <a href="logout.php"><button>Logout</button></a>
    </div>

    <div class="content">
        <h2>Selamat datang, <?= htmlspecialchars($_SESSION['user']) ?> </h2>
    </div>

</body>
</html>
