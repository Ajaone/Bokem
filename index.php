<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Selamat Datang</title>
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
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        h1 {
            margin-bottom: 20px;
            color: #333;
        }

        .button-group {
            display: flex;
            gap: 20px;
        }

        a button {
            padding: 12px 24px;
            border: none;
            border-radius: 6px;
            background-color: #ec1b7b;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }

        a button:hover {
            background-color: #c8146b;
        }
    </style>
</head>
<body>

    <h1>Selamat Datang di Web Kamsis</h1>

    <div class="button-group">
        <a href="login.php"><button>Login</button></a>
        <a href="register.php"><button>Register</button></a>
    </div>

</body>
</html>
