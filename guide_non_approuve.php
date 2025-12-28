<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Compte en attente</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-amber-50 min-h-screen flex items-center justify-center p-6">

    <div class="max-w-md bg-white rounded-lg shadow-lg p-8 text-center">
        <div class="text-6xl mb-4">⏳</div>
        <h1 class="text-2xl font-bold mb-4">Compte Guide en attente d'approbation</h1>
        <p class="text-gray-600 mb-6">
            Votre compte guide a été créé avec succès ! 
            Cependant, il doit être approuvé par un administrateur avant que vous puissiez créer des visites guidées.
        </p>
        <p class="text-gray-600 mb-6">
            Vous recevrez une notification dès que votre compte sera activé.
        </p>
        <a href="connexion.php" class="bg-green-600 text-white px-6 py-2 rounded inline-block">
            Retour à la connexion
        </a>
    </div>

</body>
</html>