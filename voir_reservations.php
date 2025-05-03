<?php
session_start();
if (!isset($_SESSION['client'])) {
    header('Location: client_login.php');
    exit;
}

// EXEMPLE de données fictives – فهاد البلاصة خاصك تربط بقاعدة البيانات
$reservations = [
    ["hotel" => "Hôtel Paris", "date" => "2025-05-10", "nuits" => 3],
    ["hotel" => "Hôtel Marrakech", "date" => "2025-06-02", "nuits" => 5],
];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes Réservations</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-image: url('https://cdn.pixabay.com/photo/2016/01/18/09/21/conference-room-1146244_1280.jpg');
            background-size: cover;
            background-position: center;
            color: #fff;
            padding: 40px;
        }
        h1 {
            text-align: center;
            margin-bottom: 30px;
        }
        .reservation {
            background: rgba(0, 0, 0, 0.5);
            margin: 20px auto;
            padding: 20px;
            border-radius: 12px;
            width: 60%;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
        }
        .reservation h2 {
            color: #f1c40f;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <h1>Mes Réservations</h1>
    <?php foreach ($reservations as $res): ?>
        <div class="reservation">
            <h2><?= htmlspecialchars($res['hotel']) ?></h2>
            <p><strong>Date:</strong> <?= htmlspecialchars($res['date']) ?></p>
            <p><strong>Nombre de nuits:</strong> <?= $res['nuits'] ?></p>
        </div>
    <?php endforeach; ?>
</body>
</html>
