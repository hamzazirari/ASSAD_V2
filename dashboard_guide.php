<?php
session_start();


// Vérifier si l'utilisateur est connecté et est un guide
if(!isset($_SESSION['id']) || $_SESSION['role'] != 'guide'){
    header("Location: connexion.php");
    exit;
}

require_once('classes/Database.php');
require_once('classes/VisiteGuidee.php');
require_once('classes/EtapeVisite.php');
require_once('classes/Reservation.php');

$id_guide = $_SESSION['id'];

// Récupérer toutes les visites du guide
$visites = VisiteGuidee::listerParGuide($id_guide);

// ANNULER une visite
if(isset($_GET['annuler'])){
    $id_visite = $_GET['annuler'];
    $visite = new VisiteGuidee($id_visite, '', '', '', '', '', '', '', $id_guide);
    $visite->annuler();
    header("Location: dashboard_guide.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Guide</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-amber-50 min-h-screen p-6">

    <h1 class="text-3xl font-bold mb-6">Tableau de bord - Guide</h1>
    
    <p class="mb-4">Bienvenue, <strong><?= $_SESSION['nom'] ?></strong></p>

    <a href="creer_visite.php" class="bg-green-600 text-white px-4 py-2 rounded inline-block mb-6">
        ➕ Créer une nouvelle visite
    </a>

    <h2 class="text-2xl font-semibold mb-4">Mes visites guidées</h2>

    <table class="w-full bg-white rounded shadow">
        <tr class="bg-green-700 text-white">
            <th class="p-3">Titre</th>
            <th class="p-3">Date et Heure</th>
            <th class="p-3">Langue</th>
            <th class="p-3">Capacité</th>
            <th class="p-3">Statut</th>
            <th class="p-3">Actions</th>
        </tr>
        <?php foreach($visites as $v): ?>
        <tr class="border-b">
            <td class="p-3"><?= $v->getTitre() ?></td>
            <td class="p-3"><?= $v->getDateHeure() ?></td>
            <td class="p-3"><?= $v->getLangue() ?></td>
            <td class="p-3"><?= $v->getCapaciteMax() ?></td>
            <td class="p-3"><?= $v->getStatut() ?></td>
            <td class="p-3">
                <a href="voir_etapes.php?id=<?= $v->getIdVisite() ?>" class="text-blue-600">Voir étapes</a> |
                <a href="dashboard_guide.php?annuler=<?= $v->getIdVisite() ?>" class="text-red-600">Annuler</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <h2 class="text-2xl font-semibold mb-4 mt-8">Réservations de mes visites</h2>

<?php foreach($visites as $v): ?>
    <?php 
        $reservations = Reservation::listerParVisite($v->getIdVisite());
        if(!empty($reservations)):
    ?>
        <div class="bg-white rounded shadow p-4 mb-4">
            <h3 class="text-xl font-bold mb-3"><?= $v->getTitre() ?></h3>
            <table class="w-full">
                <tr class="bg-gray-100">
                    <th class="p-2 text-left">Nom du visiteur</th>
                    <th class="p-2 text-left">Nombre de personnes</th>
                    <th class="p-2 text-left">Date de réservation</th>
                </tr>
                <?php foreach($reservations as $res): ?>
                <tr class="border-b">
                    <td class="p-2"><?= $res['nom'] ?></td>
                    <td class="p-2"><?= $res['nbpersonnes'] ?></td>
                    <td class="p-2"><?= date('d/m/Y', strtotime($res['datereservation'])) ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    <?php endif; ?>
<?php endforeach; ?>

</body>
</html>