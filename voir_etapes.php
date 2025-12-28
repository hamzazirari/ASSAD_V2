<?php
session_start();

if(!isset($_SESSION['id']) || $_SESSION['role'] != 'guide'){
    header("Location: connexion.php");
    exit;
}

require_once('../classes/Database.php');
require_once('../classes/EtapeVisite.php');

$id_visite = $_GET['id'];
$etapes = EtapeVisite::listerParVisite($id_visite);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Étapes de la visite</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-amber-50 min-h-screen p-6">

    <h1 class="text-3xl font-bold mb-6">Étapes de la visite</h1>

    <a href="dashboard_guide.php" class="text-blue-600 mb-4 inline-block">← Retour</a>

    <?php foreach($etapes as $e): ?>
    <div class="bg-white p-4 rounded shadow mb-4">
        <h3 class="font-bold text-lg">Étape <?= $e->getOrdreEtape() ?> : <?= $e->getTitreEtape() ?></h3>
        <p class="text-gray-700"><?= $e->getDescriptionEtape() ?></p>
    </div>
    <?php endforeach; ?>

</body>
</html>