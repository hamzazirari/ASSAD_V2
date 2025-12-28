<?php
require_once('classes/Database.php');
require_once('classes/Animal.php');

$animaux = Animal::listerTous();

if(isset($_GET['supprime'])){
    $id = $_GET['supprime'];
    $animal = new Animal($id, '', '', '', '', '', '', '');
    $animal->supprimer();
    header("Location: admin_animaux.php");
    exit;
}
?>

<h1>Gestion des Animaux</h1>
<a href="ajout_animal.php">Ajouter un animal</a>
<table>
    <tr>
        <th>Nom</th><th>Espèce</th><th>Alimentation</th><th>Actions</th>
    </tr>
    <?php foreach($animaux as $a): ?>
    <tr>
        <td><?= $a->getNom(); ?></td>
        <td><?= $a->getEspece(); ?></td>
        <td><?= $a->getAlimentation(); ?></td>
        <td>
            <a href="modifier_animal.php?id=<?= $a->getIdAnimal(); ?>">Modifier</a>
            <a href="admin_animaux.php?supprime=<?= $a->getIdAnimal(); ?>">Supprimer</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>