<?php
session_start();

$host = 'localhost';
$dbname = 'hotel_reservation';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $user = htmlspecialchars(trim($_POST['username']));
        $pass = $_POST['password'];

        $stmt = $conn->prepare("SELECT * FROM clients WHERE username = ?");
        $stmt->execute([$user]);
        $client = $stmt->fetch();

        if ($client && isset($client['password']) && password_verify($pass, $client['password'])) {
            $_SESSION['client'] = $client['username'];
            header("Location: client_dashboard.php"); // صفحة العملاء بعد الدخول
            exit;
        } else {
            $error = "⚠️ Nom d'utilisateur ou mot de passe incorrect.";
        }
    }
} catch (PDOException $e) {
    $error = "Erreur de connexion : " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion Client</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', sans-serif;
            background-image: url('https://images.unsplash.com/photo-1606402179428-a57976d71fa4?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'); 
            background-size: cover;
            background-position: center;
            height: 100vh;
        }

        .container {
            display: flex;
            justify-content: center;
            gap: 40px;
            flex-wrap: wrap;
        }

        .card {
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            width: 300px;
            transition: 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card h2 {
            margin-bottom: 15px;
            color:#333;
        }

        .card p {
            margin-bottom: 20px;
        }

        .card a, .card button {
            display: inline-block;
            padding: 10px 20px;
            background: #333;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            border: none;
            cursor: pointer;
        }

        .card a:hover, .card button:hover {
            background: #333;
        }

        form input {
            width: 100%;
            padding: 10px;
            margin-bottom: 12px;
        }

        form button {
            width: 100%;
        }

        .error-message {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Connexion Client</h1>
        <form method="post">
            <label for="username">Nom d'utilisateur :</label>
            <input type="text" name="username" required>

            <label for="password">Mot de passe :</label>
            <input type="password" name="password" required>

            <button type="submit">Se connecter</button>
            <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
        </form>
    </div>
</body>
</html>
