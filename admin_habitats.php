<?php
require_once('classes/Database.php');
require_once('classes/Habitat.php');

$habitats = Habitat::listerTous();

if(isset($_GET['supprime'])){
    $id = $_GET['supprime'];
    $hab = new Habitat($id, '', '', '', '');
    $hab->supprimer();
    header("Location: admin_habitats.php");
    exit;
}
?>

<h1>Gestion des Habitats</h1>
<a href="ajout_habitat.php">Ajouter un habitat</a>
<table>
    <tr>
        <th>Nom</th><th>Type Climat</th><th>Actions</th>
    </tr>
    <?php foreach($habitats as $h): ?>
    <tr>
        <td><?= $h->getNomHab(); ?></td>
        <td><?= $h->getTypeClimat(); ?></td>
        <td>
            <a href="modifier_habitat.php?id=<?= $h->getIdHab(); ?>">Modifier</a>
            <a href="admin_habitats.php?supprime=<?= $h->getIdHab(); ?>">Supprimer</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>