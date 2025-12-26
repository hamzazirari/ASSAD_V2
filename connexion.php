<?php
require_once('../classes/Database.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        echo "Veuillez remplir tous les champs";
        exit;
    }

    $utilisateur = Utilisateur::trouverParEmail($email);

    if (!$utilisateur) {
        echo "Email ou mot de passe incorrect";
        exit;
    }

    if (!$utilisateur->verifierMotDePasse($password)) {
        echo "Email ou mot de passe incorrect";
        exit;
    }

    // visiteurs
    if ($utilisateur->getRole() === 'visiteur' && $utilisateur->getEtat() !== 'actif') {
        echo "Compte désactivé";
        exit;
    }

    // guides
    if ($utilisateur->getRole() === 'guide' && $utilisateur->getApprouve() !== 'oui') {
        header("Location: guide_non_approuve.php");
        exit;
    }

    $_SESSION['id'] = $utilisateur->getId();
    $_SESSION['nom'] = $utilisateur->getNom();
    $_SESSION['role'] = $utilisateur->getRole();

  
    if ($utilisateur->getRole() === 'admin') {
        header("Location: dashboard_admin.php");
    } elseif ($utilisateur->getRole() === 'guide') {
        header("Location: dashboard_guide.php");
    } else {
        header("Location: dashboard_visiteur.php");
    }
    exit;
}
?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Zoo Virtuel ASSAD - Connexion à votre compte">
    <title>Connexion - Zoo Virtuel ASSAD</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-amber-50 via-green-50 to-yellow-50 flex items-center justify-center p-4">
    
    <div class="w-full max-w-md">
        <!-- En-tête avec logo/titre -->
        <header class="text-center mb-8">
            <div class="inline-block bg-gradient-to-r from-amber-600 to-green-700 text-white px-6 py-3 rounded-lg shadow-lg mb-4">
                <h1 class="text-3xl font-bold">🦁 Zoo Virtuel ASSAD</h1>
            </div>
            <p class="text-gray-600 text-sm">CAN 2025 - Projet Pédagogique</p>
        </header>

        <!-- Carte de connexion -->
        <div class="bg-white rounded-2xl shadow-xl p-8 border border-amber-100">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Connexion</h2>
            
            <!-- Formulaire -->
            <form action="connexion.php" method="POST" class="space-y-5">
                
                <!-- Champ Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Adresse email
                    </label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        placeholder="exemple@email.com"
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-200 outline-none"
                    >
                </div>

                <!-- Champ Mot de passe -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Mot de passe
                    </label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        placeholder="••••••••"
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-200 outline-none"
                    >
                </div>

                <!-- Bouton de connexion -->
                <button 
                    type="submit"
                    name="submit"
                    class="w-full bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-semibold py-3 rounded-lg shadow-md hover:shadow-lg transition duration-300 transform hover:scale-105"
                >
                    Se connecter
                </button>
            </form>

            <!-- Lien inscription -->
            <div class="mt-6 text-center">
                <p class="text-gray-600 text-sm">
                    Pas encore inscrit ? 
                    <a href="inscription.php" class="text-green-700 hover:text-green-800 font-semibold hover:underline transition duration-200">
                        S'inscrire
                    </a>
                </p>
            </div>
        </div>

        <!-- Footer -->
        <footer class="mt-8 text-center text-gray-500 text-xs">
            <p>&copy; 2025 Zoo Virtuel ASSAD - Tous droits réservés</p>
        </footer>
    </div>

</body>
</html>