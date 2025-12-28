<?php
session_start();

if(!isset($_SESSION['id']) || $_SESSION['role'] != 'admin'){
    header("Location: connexion.php");
    exit;
}

require_once('classes/Database.php');

$id = $_GET['id'];

$db = new Database();
$pdo = $db->getPdo();

$sql = "SELECT * FROM habitats WHERE id_hab = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id' => $id]);
$habitat = $stmt->fetch(PDO::FETCH_ASSOC);

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $nom_hab = $_POST['nom_hab'];
    $typeclimat = $_POST['typeclimat'];
    $description = $_POST['description'];
    $zonezoo = $_POST['zonezoo'];
    
    $sql = "UPDATE habitats SET nom_hab = :nom_hab, typeclimat = :typeclimat, 
            description = :description, zonezoo = :zonezoo WHERE id_hab = :id";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nom_hab' => $nom_hab,
        ':typeclimat' => $typeclimat,
        ':description' => $description,
        ':zonezoo' => $zonezoo,
        ':id' => $id
    ]);
    
    header("Location: admin_habitats.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un habitat</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-6">

    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold mb-6">Modifier un habitat</h1>

        <form method="POST" class="bg-white rounded-lg shadow p-6">
            
            <div class="mb-4">
                <label class="block font-semibold mb-2">Nom de l'habitat</label>
                <input type="text" name="nom_hab" value="<?= $habitat['nom_hab'] ?>" required class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-2">Type de climat</label>
                <input type="text" name="typeclimat" value="<?= $habitat['typeclimat'] ?>" required class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-2">Description</label>
                <textarea name="description" required class="w-full border rounded px-3 py-2" rows="3"><?= $habitat['description'] ?></textarea>
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-2">Zone du zoo</label>
                <input type="text" name="zonezoo" value="<?= $habitat['zonezoo'] ?>" required class="w-full border rounded px-3 py-2">
            </div>

            <div class="flex gap-4">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded">
                    Modifier
                </button>
                <a href="admin_habitats.php" class="bg-gray-400 text-white px-6 py-2 rounded inline-block">
                    Annuler
                </a>
            </div>
        </form>
    </div>

</body>
</html>