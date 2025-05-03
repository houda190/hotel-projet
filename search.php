<?php
$host = 'localhost';
$dbname = 'hotel_reservation';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = isset($_GET['query']) ? trim($_GET['query']) : '';

    $stmt = $conn->prepare("SELECT * FROM hotels WHERE ville LIKE ? OR pays LIKE ?");
    $stmt->execute(["%$query%", "%$query%"]);
    $hotels = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($hotels) > 0) {
        foreach ($hotels as $hotel) {
            echo '<div class="hotel-card">';
            echo '<img src="assets/' . htmlspecialchars($hotel['image_url']) . '" alt="Image">';
            echo '<h2>' . htmlspecialchars($hotel['nom']) . '</h2>';
            echo '<p>' . htmlspecialchars($hotel['ville']) . ', ' . htmlspecialchars($hotel['pays']) . '</p>';
            echo '</div>';
        }
    } else {
        echo "<p>Aucun hôtel trouvé.</p>";
    }

} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
