<?php
session_start();
if (!isset($_SESSION['client'])) {
    header('Location: client_login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de Bord Client</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            background-image: url('https://cdn.pixabay.com/photo/2016/01/18/09/21/conference-room-1146244_1280.jpg');
            background-size: cover;
            background-position: center;
            min-height: 100vh;
            color: #fff;
            display: flex;
            flex-direction: column;
            padding-top: 120px;
        }

        .top-bar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background: rgba(0, 0, 0, 0.7);
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 1000;
            box-shadow: 0 4px 10px rgba(0,0,0,0.5);
            backdrop-filter: blur(6px);
        }

        .welcome {
            font-size: 20px;
        }

        .client-name {
            color: #f1c40f;
            font-weight: bold;
        }

        .logout-link a {
            color: #f1c40f;
            text-decoration: none;
            font-weight: bold;
            font-size: 18px;
            transition: color 0.3s;
        }

        .logout-link a:hover {
            color: #ffffff;
        }

        .dashboard-container {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            gap: 40px;
            padding: 50px 20px;
            flex-wrap: wrap;
        }

        section {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 30px;
            width: 300px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.3);
            backdrop-filter: blur(10px);
            transition: transform 0.3s, background 0.3s;
        }

        section:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.15);
        }

        section h2 {
            margin-bottom: 10px;
            color: #f1c40f;
        }

        section p {
            margin-bottom: 20px;
        }

        .btn {
            display: inline-block;
            background-color: #f1c40f;
            color: #0e1a35;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.3s, color 0.3s;
        }

        .btn:hover {
            background-color: white;
            color: #0e1a35;
        }

        footer {
            text-align: center;
            padding: 20px;
            margin-top: auto;
            background: rgba(0, 0, 0, 0.7);
            font-size: 14px;
        }

        @media screen and (max-width: 600px) {
            .top-bar {
                flex-direction: column;
                gap: 10px;
            }

            .logout-link {
                margin-top: 10px;
            }
        }
    </style>
</head>
<body>

    <div class="top-bar">
        <div class="welcome">Bienvenue cher(e) <span class="client-name"><?= htmlspecialchars($_SESSION['client']) ?></span></div>
        <div class="logout-link">
            <a href="logout.php">Déconnexion</a>
        </div>
    </div>

    <main class="dashboard-container">
        <section>
            <h2>Vos Réservations</h2>
            <p>Consultez et gérez vos réservations en toute simplicité.</p>
            <a href="voir_reservations.php" class="btn">Voir mes réservations</a>
        </section>

        <section>
            <h2>Mon Profil</h2>
            <p>Modifiez vos informations personnelles.</p>
            <a href="modifier_profil.php" class="btn">Modifier mon profil</a>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 Mon Hôtel. Tous droits réservés.</p>
    </footer>

</body>
</html>
