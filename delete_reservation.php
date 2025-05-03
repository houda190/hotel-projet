<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $pdo = new PDO("mysql:host=localhost;dbname=hotel_reservation", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->prepare("DELETE FROM reservations WHERE id = ?");
    $stmt->execute([$id]);
}
header("Location: admin.php");
exit;
