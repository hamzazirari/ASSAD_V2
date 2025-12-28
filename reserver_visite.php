<?php
session_start();

if(!isset($_SESSION['id']) || $_SESSION['role'] != 'visiteur'){
    header("Location: connexion.php");
    exit;
}

require_once('classes/Database.php');
require_once('classes/VisiteGuidee.php');
require_once('classes/Reservation.php');

$id_visite = $_GET['id'];

// Récupérer les infos de la visite
$db = new Database();
$pdo = $db->getPdo();

$sql = "SELECT * FROM visitesguidees WHERE id_visite = :id_visite";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id_visite' => $id_visite]);
$visite = $stmt->fetch(PDO::FETCH_ASSOC);

// Calculer places restantes
$personnes_reservees = Reservation::compterPersonnesReservees($id_visite);
$places_restantes = $visite['capacite_max'] - $personnes_reservees;

// Traiter le formulaire
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $nb_personnes = $_POST['nb_personnes'];
    
    if($nb_personnes > $places_restantes){
        $erreur = "Il ne reste que $places_restantes place(s) disponible(s) !";
    } else {
        $reservation = new Reservation(null, $id_visite, $_SESSION['id'], $nb_personnes, null);
        $reservation->creer();
        
        header("Location: mes_reservations.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Réserver une visite</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-amber-50 min-h-screen p-6">

    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold mb-6">Réserver : <?= $visite['titre'] ?></h1>

        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <p><strong>📅 Date :</strong> <?= date('d/m/Y à H:i', strtotime($visite['dateheure'])) ?></p>
            <p><strong>⏱️ Durée :</strong> <?= $visite['duree'] ?> minutes</p>
            <p><strong>💰 Prix :</strong> <?= $visite['prix'] ?> MAD / personne</p>
            <p><strong>👥 Places restantes :</strong> <?= $places_restantes ?></p>
        </div>

        <?php if(isset($erreur)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <?= $erreur ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="bg-white rounded-lg shadow p-6">
            <div class="mb-4">
                <label class="block font-semibold mb-2">Nombre de personnes</label>
                <input type="number" name="nb_personnes" min="1" max="<?= $places_restantes ?>" required 
                       class="w-full border rounded px-3 py-2">
                <p class="text-sm text-gray-600 mt-1">Maximum : <?= $places_restantes ?> personne(s)</p>
            </div>

            <div class="bg-blue-50 p-4 rounded mb-4">
                <p class="font-semibold">Total à payer : <span id="total"><?= $visite['prix'] ?></span> MAD</p>
            </div>

            <div class="flex gap-4">
                <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
                    Confirmer la réservation
                </button>
                <a href="visites.php" class="bg-gray-400 text-white px-6 py-2 rounded inline-block">
                    Annuler
                </a>
            </div>
        </form>
    </div>

    <script>
        // Calculer le total en temps réel
        const input = document.querySelector('input[name="nb_personnes"]');
        const prix = <?= $visite['prix'] ?>;
        
        input.addEventListener('input', function(){
            const total = this.value * prix;
            document.getElementById('total').textContent = total;
        });
    </script>

</body>
</html>