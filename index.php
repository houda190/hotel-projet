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
}

// Récupération des hôtels
$sql = "SELECT * FROM hotels";
$stmt = $conn->prepare($sql);
$stmt->execute();
$hotels = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Hotel Luxury</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">  
  <style>
    .hotel-card {
      border: 1px solid #ddd;
      padding: 16px;
      border-radius: 10px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
      margin-bottom: 20px;
      background-color: #fff;
    }
    .hotel-card img {
      width: 100%;
      height: 200px;
      object-fit: cover;
      border-radius: 10px;
    }
    #results {
      margin-top: 30px;
    }
  </style>
</head>
<body>

<!-- NAVBAR -->
<header class="navbar">
  <div class="logo">Hotel Luxury</div>
  <nav>
    <ul>
      <li><a href="index.php">Accueil</a></li>
      <li><a href="hotels.php">Hôtels</a></li>
      <li><a href="login.php">Connexion</a></li>
      <li><a href="contact.php">Contact</a></li>
    </ul>
  </nav>
</header>

<!-- HERO SECTION -->
<section class="hero">
  <div class="hero-content">
    <h1>Bienvenue sur Hotel Luxury</h1>
    <p class="hero-description">
      Découvrez et réservez facilement parmi les meilleurs hôtels dans les plus belles destinations du monde.
    </p>
    
    <!-- FORMULAIRE DE RECHERCHE -->
    <form class="search-form" id="search-form">
      <div class="form-group">
        <input type="text" id="search-input" name="query" placeholder="Entrez une ville ou un pays">
      </div>
      <div class="form-group">
        <button type="submit">🔍 Rechercher</button>
      </div>
    </form>

    <!-- ZONE RÉSULTATS AJAX -->
    <div id="results"></div>
  </div>
</section>

<!-- SCRIPT AJAX -->
<script>
document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("search-form");
  const input = document.getElementById("search-input");
  const results = document.getElementById("results");

  form.addEventListener("submit", function (e) {
    e.preventDefault();

    const query = input.value.trim();

    if (query !== "") {
      fetch("search.php?query=" + encodeURIComponent(query))
        .then((res) => res.text())
        .then((data) => {
          results.innerHTML = data;
        })
        .catch((err) => {
          results.innerHTML = "<p>Erreur lors de la recherche.</p>";
        });
    } else {
      results.innerHTML = "<p>Veuillez entrer une ville ou un pays.</p>";
    }
  });
});
</script>

</body>
</html>
