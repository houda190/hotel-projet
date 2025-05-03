<?php
$pdo = new PDO("mysql:host=localhost;dbname=hotel_reservation", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $pdo->query("SELECT * FROM hotels");
$hotels = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Nos Hôtels</title>
  <link rel="stylesheet" href="hotels.css">
  <style>
    body {
        margin: 0;
        padding: 0;
        font-family: 'Segoe UI', sans-serif;
    }

    .dynamic-background {
        min-height: 100vh;
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
        background-attachment: fixed;
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 60px 20px;
    }

    h1 {
        color: white;
        text-shadow: 2px 2px 6px rgba(0,0,0,0.8);
        margin-bottom: 40px;
        font-size: 3rem;
    }

    .hotel-list {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(340px, 1fr));
        gap: 30px;
        width: 100%;
        max-width: 1200px;
    }

    .hotel-card {
        background: rgba(255, 255, 255, 0.15);
        color: white;
        border: 1px solid rgba(255,255,255,0.3);
        padding: 20px;
        border-radius: 16px;
        backdrop-filter: blur(10px);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4);
        transition: transform 0.3s ease, background 0.3s ease;
        position: relative;
    }

    .hotel-card:hover {
        transform: translateY(-5px);
        background: rgba(255, 255, 255, 0.25);
    }

    .hotel-card h2 {
        margin-top: 0;
        font-size: 1.6rem;
    }

    .show-form-btn {
        margin-top: 15px;
        padding: 10px 20px;
        background-color: #007BFF;
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 14px;
        font-weight: bold;
        transition: background-color 0.3s ease;
        text-decoration: none;
        display: inline-block;
        text-align: center;
    }

    .show-form-btn:hover {
        background-color: #0056b3;
    }
  </style>
</head>
<body>

<div class="dynamic-background" id="background">
  <h1>Nos Hôtels</h1>
  <div class="hotel-list">
    <?php foreach ($hotels as $hotel): ?>
      <div class="hotel-card">
        <h2><?= htmlspecialchars($hotel['nom']) ?></h2>
        <p><strong>Ville:</strong> <?= htmlspecialchars($hotel['ville']) ?></p>
        <p><strong>Adresse:</strong> <?= htmlspecialchars($hotel['adresse']) ?></p>
        <p><strong>Prix:</strong> <?= htmlspecialchars($hotel['prix']) ?> DH/nuit</p>

        <button class="show-form-btn" onclick="window.location.href='reservations.php?hotel_id=<?= $hotel['id'] ?>'">Réserver maintenant</button>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<script>
  const backgrounds = [
    "images/bg1.jpg",
    "images/bg2.jpg",
    "images/bg3.jpg",
    "images/bg4.jpg",
    "images/bg5.jpg",
    "images/bg6.jpg"
  ];
  backgrounds.forEach(src => {
    const img = new Image();
    img.src = src;
  });
  let index = 0;
  const bgDiv = document.getElementById('background');

  function changeBackground() {
    bgDiv.style.backgroundImage = `url('${backgrounds[index]}')`;
    index = (index + 1) % backgrounds.length;
  }

  changeBackground();
  setInterval(changeBackground, 2000); // chaque 5 secondes
</script>

</body>
</html>
