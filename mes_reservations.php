<?php
session_start();

if(!isset($_SESSION['id']) || $_SESSION['role'] != 'visiteur'){
    header("Location: connexion.php");
    exit;
}

require_once('classes/Database.php');
require_once('classes/Reservation.php');

$reservations = Reservation::listerParVisiteur($_SESSION['id']);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes Réservations</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-amber-50 min-h-screen p-6">

    <h1 class="text-3xl font-bold mb-6">Mes Réservations</h1>

    <a href="visites.php" class="bg-green-600 text-white px-4 py-2 rounded inline-block mb-6">
        ← Voir les visites disponibles
    </a>

    <?php if(empty($reservations)): ?>
        <div class="bg-white rounded-lg shadow p-6 text-center">
            <p class="text-gray-600">Vous n'avez aucune réservation pour le moment.</p>
        </div>
    <?php else: ?>
        <div class="space-y-4">
            <?php foreach($reservations as $r): ?>
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold mb-3"><?= $r['titre'] ?></h2>
                    <p><strong>📅 Date de la visite :</strong> <?= date('d/m/Y à H:i', strtotime($r['dateheure'])) ?></p>
                    <p><strong>👥 Nombre de personnes :</strong> <?= $r['nbpersonnes'] ?></p>
                    <p><strong>📝 Réservé le :</strong> <?= date('d/m/Y', strtotime($r['datereservation'])) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</body>
</html>