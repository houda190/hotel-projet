<?php
$pdo = new PDO("mysql:host=localhost;dbname=hotel_reservation", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Get hotel ID
$hotel_id = isset($_GET['hotel_id']) ? (int)$_GET['hotel_id'] : 0;

if ($hotel_id > 0) {
    $stmt = $pdo->prepare("SELECT * FROM hotels WHERE id = :id");
    $stmt->execute(['id' => $hotel_id]);
    $hotel = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    echo "Aucun hôtel sélectionné.";
    exit();
}

// Backgrounds selon le nom de l'hôtel
$backgrounds = [
    'hotel-de-luxe-paris' => 'https://images.unsplash.com/photo-1502602898657-3e91760cbb34',
    'hotel-spa-marrakech' => 'https://cdn.pixabay.com/photo/2019/09/24/09/58/marrakech-4500910_1280.jpg',
    'hotel-plage-miami' => 'https://cdn.pixabay.com/photo/2015/10/02/01/14/beach-967980_1280.jpg',
    'hotel-royal-new-york' => 'https://cdn.pixabay.com/photo/2014/11/21/17/23/new-york-540807_1280.jpg',
    'hotel-beachside-bali' => 'https://cdn.pixabay.com/photo/2019/10/17/02/39/villa-4555824_1280.jpg'
];

$hotel_name = $hotel['nom']; 
$hotel_key = strtolower(str_replace(' ', '-', $hotel_name)); 
$image = $backgrounds[$hotel_key] ?? 'https://images.unsplash.com/photo-1506744038136-46273834b3fb';

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Réservation à <?= htmlspecialchars($hotel['nom']) ?></title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background-image: url('<?= $image ?>');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: white;        
        }

        .reservation-form {
            max-width: 500px;
            margin: 100px auto;
            background: rgba(0, 0, 0, 0.65);
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.6);
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
            text-shadow: 1px 1px 4px black;
        }

        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 8px;
            border: none;
            font-size: 16px;
        }

        button {
            margin-top: 25px;
            width: 100%;
            padding: 12px;
            background-color: #28a745;
            border: none;
            border-radius: 8px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

    <div class="reservation-form">
        <h1>Réservez à <?= htmlspecialchars($hotel['nom']) ?></h1>
        <form action="paiement.php" method="POST">
            <input type="hidden" name="hotel_id" value="<?= $hotel['id'] ?>">

            <label>Nom complet :</label>
            <input type="text" name="nom" required>

            <label>Email :</label>
            <input type="email" name="email" required>

            <label>Date d’arrivée :</label>
            <input type="date" name="arrivee" required>

            <label>Date de départ :</label>
            <input type="date" name="depart" required>

            <label>Nombre de nuits :</label>
            <input type="number" name="nuits" min="1" required>

            <label>Méthode de paiement :</label>
            <select name="paiement" required>
              <option value="carte">Carte Bancaire</option>
              <option value="paypal">PayPal</option>
              <option value="espece">Paiement à l'arrivée</option>
            </select>

            <button type="submit">Réserver et Payer</button>
        </form>
    </div>

</body>
</html>
