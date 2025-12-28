<?php
require_once('Database.php');

class Statistiques {
    
    // Nombre total de visiteurs inscrits
    public static function nombreVisiteurs() {
        $db = new Database();
        $pdo = $db->getPdo();

        $sql = "SELECT COUNT(*) as total FROM utilisateurs WHERE role = 'visiteur'";
        $stmt = $pdo->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result['total'];
    }

    // Nombre de visiteurs par pays
    public static function visiteursParPays() {
        $db = new Database();
        $pdo = $db->getPdo();

        $sql = "SELECT paysorigine, COUNT(*) as total 
                FROM animaux 
                GROUP BY paysorigine 
                ORDER BY total DESC";
        
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Nombre total d'animaux
    public static function nombreAnimaux() {
        $db = new Database();
        $pdo = $db->getPdo();

        $sql = "SELECT COUNT(*) as total FROM animaux";
        $stmt = $pdo->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result['total'];
    }

    // Visites les plus réservées
    public static function visitesPlusReservees() {
        $db = new Database();
        $pdo = $db->getPdo();

        $sql = "SELECT v.titre, COUNT(r.id) as nb_reservations, SUM(r.nbpersonnes) as total_personnes
                FROM visitesguidees v
                LEFT JOIN reservations r ON v.id_visite = r.idvisite_reservation
                GROUP BY v.id_visite
                ORDER BY nb_reservations DESC
                LIMIT 5";
        
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Nombre total de guides
    public static function nombreGuides() {
        $db = new Database();
        $pdo = $db->getPdo();

        $sql = "SELECT COUNT(*) as total FROM utilisateurs WHERE role = 'guide'";
        $stmt = $pdo->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result['total'];
    }

    // Nombre total de réservations
    public static function nombreReservations() {
        $db = new Database();
        $pdo = $db->getPdo();

        $sql = "SELECT COUNT(*) as total FROM reservations";
        $stmt = $pdo->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result['total'];
    }
}
?>