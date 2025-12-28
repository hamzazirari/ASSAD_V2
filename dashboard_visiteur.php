<?php
session_start();

if(!isset($_SESSION['id']) || $_SESSION['role'] != 'visiteur'){
    header("Location: connexion.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Visiteur</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-amber-50 min-h-screen p-6">

    <h1 class="text-3xl font-bold mb-6">Bienvenue, <?= $_SESSION['nom'] ?> !</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <a href="visites.php" class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition">
            <h2 class="text-2xl font-bold mb-2">🎟️ Visites Guidées</h2>
            <p class="text-gray-600">Découvrir et réserver des visites</p>
        </a>

        <a href="mes_reservations.php" class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition">
            <h2 class="text-2xl font-bold mb-2">📋 Mes Réservations</h2>
            <p class="text-gray-600">Voir mes réservations</p>
        </a>

        <a href="animaux.php" class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition">
            <h2 class="text-2xl font-bold mb-2">🦁 Les Animaux</h2>
            <p class="text-gray-600">Explorer les animaux du zoo</p>
        </a>
    </div>

</body>
</html>