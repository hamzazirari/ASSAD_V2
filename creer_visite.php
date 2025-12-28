<?php
session_start();

if(!isset($_SESSION['id']) || $_SESSION['role'] != 'guide'){
    header("Location: connexion.php");
    exit;
}

require_once('../classes/Database.php');
require_once('../classes/VisiteGuidee.php');
require_once('../classes/EtapeVisite.php');

$id_guide = $_SESSION['id'];

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $titre = $_POST['titre'];
    $date = $_POST['date'];
    $heure = $_POST['heure'];
    $duree = $_POST['duree'];
    $prix = $_POST['prix'];
    $langue = $_POST['langue'];
    $capacite = $_POST['capacite'];
    
    $dateheure = $date . ' ' . $heure;
    
    // Créer la visite
    $visite = new VisiteGuidee(null, $titre, $dateheure, $langue, $capacite, 'disponible', $duree, $prix, $id_guide);
    $id_visite = $visite->creer();
    
    // Ajouter les étapes
    if(isset($_POST['titre_etape'])){
        $titres_etapes = $_POST['titre_etape'];
        $descriptions_etapes = $_POST['description_etape'];
        
        for($i = 0; $i < count($titres_etapes); $i++){
            if(!empty($titres_etapes[$i])){
                $etape = new EtapeVisite(null, $titres_etapes[$i], $descriptions_etapes[$i], $i + 1, $id_visite);
                $etape->creer();
            }
        }
    }
    
    header("Location: dashboard_guide.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer une visite</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-amber-50 min-h-screen p-6">

    <h1 class="text-3xl font-bold mb-6">Créer une nouvelle visite guidée</h1>

    <form method="POST" class="bg-white p-6 rounded shadow max-w-2xl">
        
        <div class="mb-4">
            <label class="block font-semibold mb-2">Titre de la visite</label>
            <input type="text" name="titre" required class="w-full border rounded px-3 py-2">
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block font-semibold mb-2">Date</label>
                <input type="date" name="date" required class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block font-semibold mb-2">Heure</label>
                <input type="time" name="heure" required class="w-full border rounded px-3 py-2">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block font-semibold mb-2">Durée (minutes)</label>
                <input type="number" name="duree" required class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block font-semibold mb-2">Prix (MAD)</label>
                <input type="number" step="0.01" name="prix" required class="w-full border rounded px-3 py-2">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block font-semibold mb-2">Langue</label>
                <select name="langue" required class="w-full border rounded px-3 py-2">
                    <option value="Français">Français</option>
                    <option value="Arabe">Arabe</option>
                    <option value="Anglais">Anglais</option>
                </select>
            </div>
            <div>
                <label class="block font-semibold mb-2">Capacité maximale</label>
                <input type="number" name="capacite" required class="w-full border rounded px-3 py-2">
            </div>
        </div>

        <h3 class="text-xl font-semibold mb-4 mt-6">Étapes de la visite</h3>
        
        <div id="etapes">
            <div class="mb-4 p-4 border rounded">
                <label class="block font-semibold mb-2">Étape 1</label>
                <input type="text" name="titre_etape[]" placeholder="Titre de l'étape" class="w-full border rounded px-3 py-2 mb-2">
                <textarea name="description_etape[]" placeholder="Description" class="w-full border rounded px-3 py-2" rows="2"></textarea>
            </div>
        </div>

        <button type="button" onclick="ajouterEtape()" class="bg-blue-600 text-white px-4 py-2 rounded mb-4">
            ➕ Ajouter une étape
        </button>

        <div class="flex gap-4">
            <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded">
                Créer la visite
            </button>
            <a href="dashboard_guide.php" class="bg-gray-400 text-white px-6 py-2 rounded inline-block">
                Annuler
            </a>
        </div>
    </form>

    <script>
        let compteur = 1;
        
        function ajouterEtape() {
            compteur++;
            const div = document.createElement('div');
            div.className = 'mb-4 p-4 border rounded';
            div.innerHTML = `
                <label class="block font-semibold mb-2">Étape ${compteur}</label>
                <input type="text" name="titre_etape[]" placeholder="Titre de l'étape" class="w-full border rounded px-3 py-2 mb-2">
                <textarea name="description_etape[]" placeholder="Description" class="w-full border rounded px-3 py-2" rows="2"></textarea>
            `;
            document.getElementById('etapes').appendChild(div);
        }
    </script>

</body>
</html>