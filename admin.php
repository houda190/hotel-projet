<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

$pdo = new PDO("mysql:host=localhost;dbname=hotel_reservation", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $pdo->query("SELECT reservations.*, hotels.nom AS hotel_nom 
                     FROM reservations 
                     JOIN hotels ON reservations.hotel_id = hotels.id");
$reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Admin - Réservations</title>
  <link rel="stylesheet" href="styles.css"> <!-- تأكد من وجود هذا الملف -->
  <style>
    body {
      padding: 40px;
      background: #f4f4f4;
      color: #333;
    }

    h1 {
      margin-bottom: 20px;
    }

    .logout {
      float: right;
      margin-top: -50px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background: white;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    th, td {
      padding: 12px 15px;
      text-align: left;
      border-bottom: 1px solid #ccc;
    }

    th {
      background-color: #00c9a7;
      color: white;
    }

    a.delete {
      color: red;
      text-decoration: none;
    }

    a.delete:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <h1>Panneau d'administration</h1>
  <a class="logout" href="logout.php">🔓 Se déconnecter</a>

  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Hôtel</th>
        <th>Client</th>
        <th>Email</th>
        <th>Arrivée</th>
        <th>Départ</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($reservations as $res): ?>
        <tr>
          <td><?= $res['id'] ?></td>
          <td><?= htmlspecialchars($res['hotel_nom']) ?></td>
          <td><?= htmlspecialchars($res['nom_client']) ?></td>
          <td><?= htmlspecialchars($res['email_client']) ?></td>
          <td><?= $res['date_arrivee'] ?></td>
          <td><?= $res['date_depart'] ?></td>
          <td>
            <a class="delete" href="delete_reservation.php?id=<?= $res['id'] ?>" onclick="return confirm('Confirmer la suppression ?')">🗑 Supprimer</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</body>
</html>
