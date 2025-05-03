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
        $user = trim($_POST['username']);
        $pass = $_POST['password'];

        $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ?");
        $stmt->execute([$user]);
        $admin = $stmt->fetch();

        if ($admin && isset($admin['password']) && password_verify($pass, $admin['password'])) {
            $_SESSION['admin'] = $admin['username'];
            header("Location: admin.php");
            exit;
        } else {
            $error = "Nom d'utilisateur ou mot de passe incorrect.";
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
    <title>Connexion</title>
    <link rel="stylesheet" href="styles.css"> <!-- Si t'as d'autres styles globaux -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-image: url('https://images.unsplash.com/photo-1606402179428-a57976d71fa4?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');
            background-size: cover;
            background-position: center;
            height: 100vh;
            color: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 100px;
            position: relative;
        }

        h1 {
            text-align: center;
            font-size: 42px;
            color: rgb(230, 154, 3);
            font-weight: bold;
            margin-bottom: 10px;
        }

        .subheading {
            text-align: center;
            color:rgb(230, 154, 3);
            font-size: 26px;
            margin-bottom: 40px;
            font-style: italic;
        }

        .container {
            display: flex;
            justify-content: center;
            gap: 80px;
            flex-wrap: wrap;
            z-index: 1;
        }

        .card {
            background: rgba(255, 255, 255, 0.25);
            border-radius: 15px;
            padding: 30px;
            width: 100%;
            max-width: 340px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.3);
            transition: transform 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .card:hover {
            transform: translateY(-8px);
        }

        .card h2 {
            margin-bottom: 15px;
            font-size: 24px;
            color: #fff;
        }

        .card p {
            margin-bottom: 20px;
            color: #eee;
        }

        .card a,
        .card button {
            display: block;
            width: 100%;
            margin-bottom: 10px;
            padding: 12px;
            background-color: #0e1a35;
            color: white;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            text-align: center;
            font-weight: bold;
            transition: background 0.3s;
        }

        .card a:hover,
        .card button:hover {
            background-color: #f1c40f;
            color: #0e1a35;
        }

    </style>
</head>
<body>

    <h1>Bienvenue</h1>
    <p class="subheading">Choisissez votre espace pour accéder à une expérience de réservation fluide et personnalisée.</p>


    <div class="container">

        <!-- Espace Client -->
        <div class="card">
            <h2>Espace Client</h2>
            <p>Réservez vos hôtels rapidement en créant un compte.</p>
            <a href="register.php">S'inscrire</a>
            <a href="client_login.php">Se connecter</a>
        </div>

        <!-- Espace Admin -->
        <div class="card">
            <h2>Espace Admin</h2>
            <p>Accédez à la gestion des réservations.</p>
            <a href="admin_login.php">Se connecter</a>
        </div>

    </div>

</body>
</html>
