<?php 
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $message = htmlspecialchars($_POST['message']);

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $conn = new mysqli('localhost', 'root', '', 'hotel_reservation');
        
        if ($conn->connect_error) {
            die("Échec de la connexion à la base de données : " . $conn->connect_error);
        }

        $stmt = $conn->prepare("INSERT INTO contacts (name, email, message) VALUES (?, ?, ?)");
        $stmt->bind_param('sss', $name, $email, $message);

        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Votre message a été envoyé avec succès!";
        } else {
            $_SESSION['error_message'] = "Erreur lors de l'envoi du message. Veuillez réessayer.";
        }

        $stmt->close();
        $conn->close();
    } else {
        $_SESSION['error_message'] = "Email invalide.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
    <style>
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
            width: 100%;
            height: 100vh;
            position: relative;
        }

        .message.success, .message.error {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(0, 0, 0, 0.25);
            color: white;
            font-size: 36px;
            padding: 40px 30px;
            border-radius: 20px;
            text-align: center;
            font-weight: bold;
        }

        .message.error {
            background-color: rgba(150, 0, 0, 0.8);
        }

        .button {
            text-align: center;
            margin-top: 20px;
        }

        .button a {
            text-decoration: none;
            background-color: #fff;
            color: #333;
            padding: 15px 25px;
            border-radius: 8px;
            font-size: 18px;
            font-weight: bold;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.3);
        }

        .form-wrapper {
            position: absolute;
            top: 50%;
            left: 5%;
            transform: translateY(-50%);
            max-width: 500px;
        }

        h1 {
            color: white;
            text-shadow: 1px 1px 4px #000;
        }

        form {
            background-color: rgba(0, 0, 0, 0.25); 
            padding: 30px;
            border-radius: 15px;
            backdrop-filter: blur(6px);
        }


        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
            color: white;
        }

        input, textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 8px;
            border: none;
            background-color: rgba(255, 255, 255, 0.8);
        }

        button[type="submit"] {
            margin-top: 20px;
            background-color: #333;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if(isset($_SESSION['success_message'])): ?>
            <div class="message success">
                <?= $_SESSION['success_message']; ?>
                <div class="button">
                    <a href="index.php">Retour à l'accueil</a>
                </div>
            </div>
            <?php unset($_SESSION['success_message']); ?>

        <?php elseif(isset($_SESSION['error_message'])): ?>
            <div class="message error">
                <?= $_SESSION['error_message']; ?>
            </div>
            <?php unset($_SESSION['error_message']); ?>

        <?php else: ?>
            <div class="form-wrapper">
                <h1>Contactez-nous</h1>
                <form action="contact.php" method="POST">
                    <label for="name">Nom:</label>
                    <input type="text" id="name" name="name" required>

                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>

                    <label for="message">Message:</label>
                    <textarea id="message" name="message" required></textarea>

                    <button type="submit">Envoyer</button>
                </form>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
