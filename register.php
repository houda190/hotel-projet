<?php
$host = 'localhost';
$dbname = 'hotel_reservation';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $user = trim($_POST['username']);
        $email = trim($_POST['email']);
        $pass = $_POST['password'];
        $confirm_pass = $_POST['confirm_password'];

        // Vérification de mot de passe
        if ($pass !== $confirm_pass) {
            $error = "❌ Les mots de passe ne correspondent pas.";
        } else {
            // Vérifier si l'utilisateur existe déjà
            $stmt = $conn->prepare("SELECT id FROM clients WHERE username = ?");
            $stmt->execute([$user]);
            if ($stmt->fetch()) {
                $error = "⚠️ Ce nom d'utilisateur existe déjà.";
            } else {
                // Hash du mot de passe
                $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);

                // Insertion
                $stmt = $conn->prepare("INSERT INTO clients (username, email, password) VALUES (?, ?, ?)");
                $stmt->execute([$user, $email, $hashed_pass]);

                $success = "✅ Compte créé avec succès. <a href='client_login.php'>Connectez-vous ici</a>.";
            }
        }
    }
} catch (PDOException $e) {
    $error = "Erreur : " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription Client</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Créer un compte client</h1>
        <form method="post">
            <label for="username">Nom d'utilisateur :</label>
            <input type="text" name="username" required>

            <label for="email">Adresse email :</label>
            <input type="email" name="email" required>

            <label for="password">Mot de passe :</label>
            <input type="password" name="password" required>

            <label for="confirm_password">Confirmer le mot de passe :</label>
            <input type="password" name="confirm_password" required>

            <button type="submit">S'inscrire</button>

            <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
            <?php if (!empty($success)) echo "<p style='color:green;'>$success</p>"; ?>
        </form>
    </div>
</body>
</html>
