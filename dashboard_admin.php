<?php
session_start();

// SÉCURITÉ : Vérifier si admin
if(!isset($_SESSION['id']) || $_SESSION['role'] != 'admin'){
    header("Location: connexion.php");
    exit;
}

require_once('classes/Database.php');
require_once('classes/Statistiques.php');
require_once('classes/Utilisateur.php');

// Récupérer toutes les statistiques
$nb_visiteurs = Statistiques::nombreVisiteurs();
$nb_animaux = Statistiques::nombreAnimaux();
$nb_guides = Statistiques::nombreGuides();
$nb_reservations = Statistiques::nombreReservations();
$visites_populaires = Statistiques::visitesPlusReservees();
$pays_animaux = Statistiques::visiteursParPays();

// Récupérer tous les utilisateurs pour gestion
$db = new Database();
$pdo = $db->getPdo();

$sql = "SELECT * FROM utilisateurs ORDER BY role, nom";
$stmt = $pdo->query($sql);
$utilisateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Gérer activation/désactivation
if(isset($_GET['action']) && isset($_GET['id'])){
    $id_user = $_GET['id'];
    $action = $_GET['action'];
    
    if($action == 'activer'){
        $sql = "UPDATE utilisateurs SET etat = 'actif' WHERE id_utilisateur = :id";
    } elseif($action == 'desactiver'){
        $sql = "UPDATE utilisateurs SET etat = 'inactif' WHERE id_utilisateur = :id";
    } elseif($action == 'approuver'){
        $sql = "UPDATE utilisateurs SET approuve = 'oui' WHERE id_utilisateur = :id";
    }
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id_user]);
    
    header("Location: dashboard_admin.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-6">

    <div class="max-w-7xl mx-auto">
        
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-4xl font-bold">Dashboard Administrateur</h1>
            <p class="text-gray-600">Bienvenue, <strong><?= $_SESSION['nom'] ?></strong></p>
        </div>

        <!-- STATISTIQUES EN CARTES -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Visiteurs</p>
                        <p class="text-3xl font-bold text-green-600"><?= $nb_visiteurs ?></p>
                    </div>
                    <div class="text-4xl">👥</div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Animaux</p>
                        <p class="text-3xl font-bold text-blue-600"><?= $nb_animaux ?></p>
                    </div>
                    <div class="text-4xl">🦁</div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Guides</p>
                        <p class="text-3xl font-bold text-purple-600"><?= $nb_guides ?></p>
                    </div>
                    <div class="text-4xl">🧭</div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Réservations</p>
                        <p class="text-3xl font-bold text-orange-600"><?= $nb_reservations ?></p>
                    </div>
                    <div class="text-4xl">🎟️</div>
                </div>
            </div>

        </div>

        <!-- VISITES LES PLUS RÉSERVÉES -->
        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <h2 class="text-2xl font-bold mb-4">📊 Visites les plus réservées</h2>
            <table class="w-full">
                <tr class="bg-gray-100">
                    <th class="p-3 text-left">Titre de la visite</th>
                    <th class="p-3 text-left">Nb réservations</th>
                    <th class="p-3 text-left">Total personnes</th>
                </tr>
                <?php foreach($visites_populaires as $v): ?>
                <tr class="border-b">
                    <td class="p-3"><?= $v['titre'] ?></td>
                    <td class="p-3"><?= $v['nb_reservations'] ?? 0 ?></td>
                    <td class="p-3"><?= $v['total_personnes'] ?? 0 ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>

        <!-- ANIMAUX PAR PAYS -->
        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <h2 class="text-2xl font-bold mb-4">🌍 Animaux par pays d'origine</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <?php foreach($pays_animaux as $p): ?>
                <div class="bg-gray-50 p-4 rounded text-center">
                    <p class="text-2xl font-bold text-green-600"><?= $p['total'] ?></p>
                    <p class="text-gray-600"><?= $p['paysorigine'] ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- GESTION DES UTILISATEURS -->
        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <h2 class="text-2xl font-bold mb-4">👥 Gestion des utilisateurs</h2>
            
            <table class="w-full">
                <tr class="bg-gray-100">
                    <th class="p-3 text-left">Nom</th>
                    <th class="p-3 text-left">Email</th>
                    <th class="p-3 text-left">Rôle</th>
                    <th class="p-3 text-left">État</th>
                    <th class="p-3 text-left">Approuvé</th>
                    <th class="p-3 text-left">Actions</th>
                </tr>
                <?php foreach($utilisateurs as $u): ?>
                <tr class="border-b">
                    <td class="p-3"><?= $u['nom'] ?></td>
                    <td class="p-3"><?= $u['email'] ?></td>
                    <td class="p-3">
                        <span class="px-2 py-1 rounded text-xs font-semibold
                            <?= $u['role'] == 'admin' ? 'bg-red-200 text-red-800' : '' ?>
                            <?= $u['role'] == 'guide' ? 'bg-purple-200 text-purple-800' : '' ?>
                            <?= $u['role'] == 'visiteur' ? 'bg-green-200 text-green-800' : '' ?>">
                            <?= $u['role'] ?>
                        </span>
                    </td>
                    <td class="p-3">
                        <span class="px-2 py-1 rounded text-xs font-semibold
                            <?= $u['etat'] == 'actif' ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' ?>">
                            <?= $u['etat'] ?>
                        </span>
                    </td>
                    <td class="p-3">
                        <?php if($u['role'] == 'guide'): ?>
                            <span class="px-2 py-1 rounded text-xs font-semibold
                                <?= $u['approuve'] == 'oui' ? 'bg-green-200 text-green-800' : 'bg-yellow-200 text-yellow-800' ?>">
                                <?= $u['approuve'] ?>
                            </span>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                    <td class="p-3">
                        <?php if($u['role'] != 'admin'): ?>
                            <?php if($u['etat'] == 'actif'): ?>
                                <a href="?action=desactiver&id=<?= $u['id_utilisateur'] ?>" 
                                   class="text-red-600 text-sm">Désactiver</a>
                            <?php else: ?>
                                <a href="?action=activer&id=<?= $u['id_utilisateur'] ?>" 
                                   class="text-green-600 text-sm">Activer</a>
                            <?php endif; ?>
                            
                            <?php if($u['role'] == 'guide' && $u['approuve'] == 'non'): ?>
                                | <a href="?action=approuver&id=<?= $u['id_utilisateur'] ?>" 
                                     class="text-blue-600 text-sm">Approuver</a>
                            <?php endif; ?>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>

        <!-- LIENS DE GESTION -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <a href="admin_animaux.php" class="bg-blue-600 text-white p-6 rounded-lg shadow hover:bg-blue-700 text-center">
                <h3 class="text-xl font-bold">🦁 Gérer les Animaux</h3>
                <p class="text-sm mt-2">Ajouter, modifier, supprimer des animaux</p>
            </a>

            <a href="admin_habitats.php" class="bg-green-600 text-white p-6 rounded-lg shadow hover:bg-green-700 text-center">
                <h3 class="text-xl font-bold">🏞️ Gérer les Habitats</h3>
                <p class="text-sm mt-2">Ajouter, modifier, supprimer des habitats</p>
            </a>
        </div>

    </div>

</body>
</html>