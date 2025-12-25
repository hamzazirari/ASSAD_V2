<?php 
require_once('../classes/Database.php');

if ($_SERVER['REQUEST_METHOD']=='POST'){
    $nom = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];
    $role = $_POST['role'];
}

if(empty($nom) || empty($email) || empty($password) || empty($confirmPassword) || empty($role)){
    echo"Veuiller remplir tout les champs";
    return;
}

if(!preg_match("/^[^\s\W]{4,}@[^\d\s]{1,5}\.[a-zA-Z]{1,4}$/", $email)){
    echo"Email invalalid";
    return ; 
}

if(!preg_match("/^[^\s]{3,15}$/", $password)){
    echo"Password invalid";
    return; 
}

if($confirmPassword !== $password){
    echo"veuillez entrer le meme password";
    return;
}else {
     $password_hash = password_hash($confirmPassword,PASSWORD_DEFAULT);
}
if($role == 'visiteur'){
    $approuve = 'oui';
}else if($role == 'guide'){
    $approuve = 'non';
}

$etat = 'actif';

$utilisateur = new Utilisateur($nom , $email, $role, $password_hash, $etat, $approuve);
$utilisateur->creer();

echo"Inscription avec succes";

header("Location: /connexion.php");

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Zoo Virtuel ASSAD - Créer un compte">
    <title>Inscription - Zoo Virtuel ASSAD</title>
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

        <!-- Carte d'inscription -->
        <div class="bg-white rounded-2xl shadow-xl p-8 border border-amber-100">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Créer un compte</h2>
            
            <!-- Formulaire -->
            <form action="inscription.php" method="POST" class="space-y-5">
                
                <!-- Champ Nom complet -->
                <div>
                    <label for="fullname" class="block text-sm font-medium text-gray-700 mb-2">
                        Nom complet
                    </label>
                    <input 
                        type="text" 
                        id="fullname" 
                        name="fullname" 
                        placeholder="Jean Dupont"
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-200 outline-none"
                    >
                </div>

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

                <!-- Champ Confirmer mot de passe -->
                <div>
                    <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-2">
                        Confirmer le mot de passe
                    </label>
                    <input 
                        type="password" 
                        id="confirm_password" 
                        name="confirm_password" 
                        placeholder="••••••••"
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-200 outline-none"
                    >
                </div>

                <!-- Choix du rôle -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">
                        Type de compte
                    </label>
                    <div class="space-y-3">
                        <label class="flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-green-50 transition duration-200">
                            <input 
                                type="radio" 
                                name="role" 
                                value="visiteur" 
                                checked
                                required
                                class="w-4 h-4 text-green-600 focus:ring-green-500"
                            >
                            <span class="ml-3 text-gray-700 font-medium">Visiteur</span>
                        </label>
                        
                        <label class="flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-amber-50 transition duration-200">
                            <input 
                                type="radio" 
                                name="role" 
                                value="guide"
                                required
                                class="w-4 h-4 text-green-600 focus:ring-green-500"
                            >
                            <span class="ml-3 text-gray-700 font-medium">Guide</span>
                        </label>
                    </div>
                </div>

                <!-- Message informatif -->
                <div class="bg-amber-50 border border-amber-200 rounded-lg p-3">
                    <p class="text-xs text-amber-800 flex items-start">
                        <svg class="w-4 h-4 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        Les comptes Guide doivent être approuvés par l'administrateur avant activation.
                    </p>
                </div>

                <!-- Bouton d'inscription -->
                <button 
                    type="submit"
                    class="w-full bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-semibold py-3 rounded-lg shadow-md hover:shadow-lg transition duration-300 transform hover:scale-105"
                >
                    S'inscrire
                </button>
            </form>

            <!-- Lien connexion -->
            <div class="mt-6 text-center">
                <p class="text-gray-600 text-sm">
                    Déjà inscrit ? 
                    <a href="connexion.php" class="text-green-700 hover:text-green-800 font-semibold hover:underline transition duration-200">
                        Se connecter
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