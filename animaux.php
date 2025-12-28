<?php
require_once('classes/Database.php');
require_once('classes/Animal.php');
require_once('classes/Habitat.php');

$habitats = Habitat::listerTous();

$id_hab = isset($_GET['habitat']) ? $_GET['habitat'] : null;

if ($id_hab) {
    $animaux = Animal::listerParHabitat($id_hab);
} else {
    $animaux = Animal::listerTous();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Animaux - Zoo Virtuel ASSAD</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-amber-50 min-h-screen p-6">

    <h1 class="text-3xl font-bold mb-6 text-center">Liste des Animaux</h1>

    <form method="GET" class="mb-6 text-center">
        <label for="habitat" class="mr-2 font-medium">Filtrer par Habitat :</label>
        <select name="habitat" id="habitat" class="border rounded px-2 py-1">
            <option value="">Tous</option>
            <?php foreach($habitats as $hab): ?>
                <option value="<?= $hab->getIdHab() ?>" <?= ($id_hab == $hab->getIdHab()) ? 'selected' : '' ?>>
                    <?= $hab->getNomHab() ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit" class="ml-2 px-4 py-1 bg-green-600 text-white rounded">Filtrer</button>
    </form>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach($animaux as $animal): ?>
            <?php 
                $habitat = Habitat::trouverParId($animal->getIdHabitat()); 
            ?>
            <div class="bg-white rounded-lg shadow p-4">
                <img src="images/<?= $animal->getImage() ?>" alt="<?= $animal->getNom() ?>" class="w-full h-48 object-cover rounded mb-3">
                <h2 class="text-xl font-bold"><?= $animal->getNom() ?> (<?= $animal->getEspece() ?>)</h2>
                <p><strong>Alimentation :</strong> <?= $animal->getAlimentation() ?></p>
                <p><strong>Origine :</strong> <?= $animal->getPaysOrigine() ?></p>
                <p class="mt-2"><?= $animal->getDescriptionCourte() ?></p>
                <p class="mt-2 text-sm text-gray-600"><strong>Habitat :</strong> <?= $habitat ? $habitat->getNomHab() : 'Inconnu' ?></p>
            </div>
        <?php endforeach; ?>
    </div>

</body>
</html>