<?php
// Connexion à la base de données
$host = 'localhost';
$dbname = 'hotel_reservation';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Erreur : " . $e->getMessage());
}

// Traitement
$hotel_nom = $ville = $nom = $email = $paiement = '';
$nuits = $total = 0;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $hotel_id = $_POST['hotel_id'];
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $nuits = $_POST['nuits'];
    $paiement = $_POST['paiement'];

    $prix_par_nuit = 300;
    $total = $nuits * $prix_par_nuit;

    $stmt = $conn->prepare("SELECT nom, ville FROM hotels WHERE id = :id");
    $stmt->execute([':id' => $hotel_id]);
    $hotel = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($hotel) {
        $hotel_nom = $hotel['nom'];
        $ville = $hotel['ville'];
    }

    $stmt = $conn->prepare("INSERT INTO reservations (hotel_id, nom_client, email_client, nombre_nuits, methode_paiement)
                            VALUES (:hotel_id, :nom, :email, :nuits, :paiement)");
    $stmt->execute([
        ':hotel_id' => $hotel_id,
        ':nom' => $nom,
        ':email' => $email,
        ':nuits' => $nuits,
        ':paiement' => $paiement
    ]);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Confirmation du Paiement</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background-image: url('https://cdn.pixabay.com/photo/2020/02/01/06/12/upholstery-4809588_1280.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: white;
        }

        .confirmation-box {
            max-width: 700px;
            margin: 80px auto;
            padding: 40px;
            background: rgba(0, 0, 0, 0.7);
            border-radius: 12px;
            text-align: center;
        }

        h1 {
            color: #00ffcc;
            margin-bottom: 20px;
        }

        p {
            font-size: 18px;
            line-height: 1.6;
        }

        .btns {
            margin-top: 30px;
        }

        .btns a {
            display: inline-block;
            margin: 10px;
            padding: 12px 25px;
            background-color: #00c4a7;
            color: white;
            border-radius: 8px;
            text-decoration: none;
            transition: 0.3s ease;
        }

        .btns a:hover {
            background-color: #008f82;
        }
    </style>
</head>
<body>

<div class="confirmation-box">
    <h1>✅ Confirmation du Paiement</h1>
    <p>Merci, <strong><?= htmlspecialchars($nom) ?></strong> !</p>
    <p>Vous avez réservé à <strong><?= htmlspecialchars($hotel_nom) ?></strong> situé à <strong><?= htmlspecialchars($ville) ?></strong>.</p>
    <p>Email : <?= htmlspecialchars($email) ?></p>
    <p>Nombre de nuits : <?= htmlspecialchars($nuits) ?></p>
    <p>Méthode de paiement : <?= htmlspecialchars($paiement) ?></p>
    <p><strong>Total à payer :</strong> <?= $total ?> DH</p>
    <p style="margin-top: 25px; font-size: 20px; color: #5aff9d;">✅ Votre réservation a été prise en compte avec succès !</p>

    <div class="btns">
        <a href="index.php">🏠 Retour à l'accueil</a>
    </div>
</div>

</body>
</html>
