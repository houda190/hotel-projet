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
    echo "Erreur : " . $e->getMessage();
    exit();
}

// Variables par défaut
$hotel_nom = "Inconnu";
$ville = "Ville inconnue";
$total = 0;

// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $hotel_id = $_POST['hotel_id'];
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $nuits = $_POST['nuits'];
    $paiement = $_POST['paiement'];

    // Exemple de tarif : 300 DH/nuit
    $prix_par_nuit = 300;
    $total = $nuits * $prix_par_nuit;

    // Récupérer le nom et ville de l'hôtel
    $stmt = $conn->prepare("SELECT nom, ville FROM hotels WHERE id = :id");
    $stmt->execute([':id' => $hotel_id]);
    $hotel = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($hotel) {
        $hotel_nom = $hotel['nom'];
        $ville = $hotel['ville'];
    }

    // Insérer la réservation
    $sql = "INSERT INTO reservations (hotel_id, nom_client, email_client, nombre_nuits, methode_paiement)
            VALUES (:hotel_id, :nom, :email, :nuits, :paiement)";
    $stmt = $conn->prepare($sql);
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
    <title>Confirmation de Réservation</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background-image: url('https://cdn.pixabay.com/photo/2016/10/28/13/09/usa-1777986_1280.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: #fff;
        }

        .confirmation-container {
            background-color: rgba(0, 0, 0, 0.7);
            max-width: 700px;
            margin: 80px auto;
            padding: 30px;
            border-radius: 15px;
            text-align: center;
        }

        h1 {
            color: #00ffcc;
        }

        p {
            font-size: 18px;
            line-height: 1.6;
        }

        .btn-group {
            margin-top: 25px;
        }

        .btn-group a {
            display: inline-block;
            padding: 12px 20px;
            margin: 10px;
            background-color: #00c4a7;
            color: #fff;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .btn-group a:hover {
            background-color: #009985;
        }
    </style>
</head>
<body>

<div class="confirmation-container">
    <h1>✅ Réservation Confirmée</h1>
    <p>Merci, <strong><?= htmlspecialchars($nom) ?></strong> !</p>
    <p>Vous avez réservé à <strong><?= htmlspecialchars($hotel_nom) ?></strong> situé à <strong><?= htmlspecialchars($ville) ?></strong>.</p>
    <p>Email : <?= htmlspecialchars($email) ?></p>
    <p>Nombre de nuits : <?= htmlspecialchars($nuits) ?></p>
    <p>Méthode de paiement : <?= htmlspecialchars($paiement) ?></p>
    <p><strong>Total à payer :</strong> <?= $total ?> DH</p>

    <div class="btn-group">
        <a href="index.php">🏠 Retour à l'accueil</a>
        <a href="#">📥 Télécharger le reçu</a>
    </div>
</div>

</body>
</html>
