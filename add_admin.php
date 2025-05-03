<?php
$host = 'localhost';
$dbname = 'hotel_reservation';
$username = 'root';
$password = '';

$conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $admin_username = $_POST['username'];
    $admin_password = $_POST['password'];
    
    // Hasher le mot de passe
    $hashed_password = password_hash($admin_password, PASSWORD_DEFAULT);
    
    // Insertion dans la base de données
    $stmt = $conn->prepare("INSERT INTO admin (username, password) VALUES (?, ?)");
    $stmt->execute([$admin_username, $hashed_password]);

    echo "Admin ajouté avec succès!";
}
?>

<form method="POST">
    <label for="username">Nom d'utilisateur:</label>
    <input type="text" name="username" id="username" required>

    <label for="password">Mot de passe:</label>
    <input type="password" name="password" id="password" required>

    <button type="submit">Ajouter Admin</button>
</form>
