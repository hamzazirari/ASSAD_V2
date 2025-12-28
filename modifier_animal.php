<?php
session_start();

if(!isset($_SESSION['id']) || $_SESSION['role'] != 'admin'){
    header("Location: connexion.php");
    exit;
}

require_once('classes/Database.php');
require_once('classes/Habitat.php');

$id = $_GET['id'];
$habitats = Habitat::listerTous();

$db = new Database();
$pdo = $db->getPdo();

$sql = "SELECT * FROM animaux WHERE id_animal = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id' => $id]);
$animal = $stmt->fetch(PDO::FETCH_ASSOC);

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $nom = $_POST['nom'];
    $espece = $_POST['espece'];
    $alimentation = $_POST['alimentation'];
    $paysorigine = $_POST['paysorigine'];
    $descriptioncourte = $_POST['descriptioncourte'];
    $id_habitat = $_POST['id_habitat'];
    $image = $_POST['image'];
    
    $sql = "UPDATE animaux SET nom = :nom, espece = :espece, alimentation = :alimentation, 
            image = :image, paysorigine = :paysorigine, descriptioncourte = :descriptioncourte, 
            id_habitat = :id_habitat WHERE id_animal = :id";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nom' => $nom,
        ':espece' => $espece,
        ':alimentation' => $alimentation,
        ':image' => $image,
        ':paysorigine' => $paysorigine,
        ':descriptioncourte' => $descriptioncourte,
        ':id_habitat' => $id_habitat,
        ':id' => $id
    ]);
    
    header("Location: admin_animaux.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un animal</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-6">

    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold mb-6">Modifier un animal</h1>

        <form method="POST" class="bg-white rounded-lg shadow p-6">
            
            <div class="mb-4">
                <label class="block font-semibold mb-2">Nom</label>
                <input type="text" name="nom" value="<?= $animal['nom'] ?>" required class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-2">Espèce</label>
                <input type="text" name="espece" value="<?= $animal['espece'] ?>" required class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-2">Alimentation</label>
                <input type="text" name="alimentation" value="<?= $animal['alimentation'] ?>" required class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-2">Pays d'origine</label>
                <input type="text" name="paysorigine" value="<?= $animal['paysorigine'] ?>" required class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-2">Image</label>
                <input type="text" name="image" value="<?= $animal['image'] ?>" required class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-2">Description courte</label>
                <textarea name="descriptioncourte" required class="w-full border rounded px-3 py-2" rows="3"><?= $animal['descriptioncourte'] ?></textarea>
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-2">Habitat</label>
                <select name="id_habitat" required class="w-full border rounded px-3 py-2">
                    <?php foreach($habitats as $h): ?>
                        <option value="<?= $h->getIdHab() ?>" <?= $animal['id_habitat'] == $h->getIdHab() ? 'selected' : '' ?>>
                            <?= $h->getNomHab() ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="flex gap-4">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded">
                    Modifier
                </button>
                <a href="admin_animaux.php" class="bg-gray-400 text-white px-6 py-2 rounded inline-block">
                    Annuler
                </a>
            </div>
        </form>
    </div>

</body>
</html>