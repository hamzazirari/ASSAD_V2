<?php
session_start();

require_once('classes/Database.php');
require_once('classes/VisiteGuidee.php');
require_once('classes/Reservation.php');
require_once('classes/EtapeVisite.php');

// Récupérer toutes les visites disponibles
$db = new Database();
$pdo = $db->getPdo();

$sql = "SELECT * FROM visitesguidees WHERE statut = 'disponible' ORDER BY dateheure";
$stmt = $pdo->query($sql);
$visites_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Visites Guidées</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-amber-50 min-h-screen p-6">

    <h1 class="text-3xl font-bold mb-6 text-center">Visites Guidées Disponibles</h1>

    <?php if(!isset($_SESSION['id'])): ?>
        <div class="bg-yellow-100 border border-yellow-400 text-yellow-800 px-4 py-3 rounded mb-6 text-center">
            <p>Vous devez être connecté pour réserver une visite. <a href="connexion.php" class="underline font-semibold">Se connecter</a></p>
        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <?php foreach($visites_data as $v): ?>
            <?php 
                $personnes_reservees = Reservation::compterPersonnesReservees($v['id_visite']);
                $places_restantes = $v['capacite_max'] - $personnes_reservees;
                $etapes = EtapeVisite::listerParVisite($v['id_visite']);
            ?>
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-2xl font-bold mb-3"><?= $v['titre'] ?></h2>
                
                <div class="space-y-2 mb-4">
                    <p><strong>📅 Date :</strong> <?= date('d/m/Y', strtotime($v['dateheure'])) ?></p>
                    <p><strong>🕐 Heure :</strong> <?= date('H:i', strtotime($v['dateheure'])) ?></p>
                    <p><strong>⏱️ Durée :</strong> <?= $v['duree'] ?> minutes</p>
                    <p><strong>💰 Prix :</strong> <?= $v['prix'] ?> MAD</p>
                    <p><strong>🗣️ Langue :</strong> <?= $v['langue'] ?></p>
                    <p><strong>👥 Places restantes :</strong> 
                        <span class="<?= $places_restantes > 5 ? 'text-green-600' : 'text-red-600' ?> font-bold">
                            <?= $places_restantes ?> / <?= $v['capacite_max'] ?>
                        </span>
                    </p>
                </div>

                <div class="bg-gray-50 p-3 rounded mb-4">
                    <h3 class="font-semibold mb-2">Parcours de la visite :</h3>
                    <ol class="list-decimal list-inside space-y-1 text-sm">
                        <?php foreach($etapes as $e): ?>
                            <li><?= $e->getTitreEtape() ?></li>
                        <?php endforeach; ?>
                    </ol>
                </div>

                <?php if(isset($_SESSION['id']) && $_SESSION['role'] == 'visiteur'): ?>
                    <?php if($places_restantes > 0): ?>
                        <a href="reserver_visite.php?id=<?= $v['id_visite'] ?>" 
                           class="block text-center bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                            🎟️ Réserver
                        </a>
                    <?php else: ?>
                        <button disabled class="w-full bg-gray-400 text-white px-4 py-2 rounded cursor-not-allowed">
                            Complet
                        </button>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>

</body>
</html>