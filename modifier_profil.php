<?php
session_start();
if (!isset($_SESSION['client'])) {
    header('Location: client_login.php');
    exit;
}

// Pour l’exemple – données simulées
$client_email = "client@example.com";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Ici on devrait mettre à jour dans la base de données
    $client_email = $_POST['email'];
    $message = "Profil mis à jour avec succès.";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier Profil</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-image: url('https://cdn.pixabay.com/photo/2016/01/18/09/21/conference-room-1146244_1280.jpg');
            background-size: cover;
            background-position: center;
            color: #fff;
            padding: 40px;
        }
        form {
            background: rgba(0,0,0,0.6);
            padding: 30px;
            border-radius: 12px;
            max-width: 500px;
            margin: 0 auto;
        }
        label, input {
            display: block;
            width: 100%;
            margin-bottom: 15px;
        }
        input[type="email"], input[type="submit"] {
            padding: 10px;
            border-radius: 8px;
            border: none;
        }
        input[type="submit"] {
            background-color: #f1c40f;
            font-weight: bold;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: white;
            color: #000;
        }
        .success {
            text-align: center;
            margin-top: 20px;
            color: #f1c40f;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <form method="POST">
        <h2>Modifier mon profil</h2>
        <label for="email">Adresse e-mail :</label>
        <input type="email" name="email" id="email" value="<?= htmlspecialchars($client_email) ?>" required>
        <input type="submit" value="Enregistrer">
        <?php if (!empty($message)): ?>
            <div class="success"><?= $message ?></div>
        <?php endif; ?>
    </form>
</body>
</html>
