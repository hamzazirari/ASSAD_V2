<?php 
require_once('../classes/Database.php');

$db = new Database();
$pdo = $db->getPdo();

echo "Connexion OK";
?>