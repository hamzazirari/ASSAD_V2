<?php
require_once('Database.php');

class Reservation {
    private $id;
    private $idvisite_reservation;
    private $idutilisateur_reservation;
    private $nbpersonnes;
    private $datereservation;

    public function __construct($id, $idvisite_reservation, $idutilisateur_reservation, $nbpersonnes, $datereservation) {
        $this->id = $id;
        $this->idvisite_reservation = $idvisite_reservation;
        $this->idutilisateur_reservation = $idutilisateur_reservation;
        $this->nbpersonnes = $nbpersonnes;
        $this->datereservation = $datereservation;
    }

    // GETTERS
    public function getId() { 
        return $this->id; 
    }

    public function getIdVisite() { 
        return $this->idvisite_reservation; 
    }

    public function getIdUtilisateur() { 
        return $this->idutilisateur_reservation; 
    }

    public function getNbPersonnes() { 
        return $this->nbpersonnes; 
    }

    public function getDateReservation() { 
        return $this->datereservation; 
    }

    // CRÉER une réservation
    public function creer() {
        $db = new Database();
        $pdo = $db->getPdo();

        $sql = "INSERT INTO reservations (idvisite_reservation, idutilisateur_reservation, nbpersonnes, datereservation) 
                VALUES (:idvisite, :idutilisateur, :nbpersonnes, NOW())";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':idvisite' => $this->idvisite_reservation,
            ':idutilisateur' => $this->idutilisateur_reservation,
            ':nbpersonnes' => $this->nbpersonnes
        ]);

        $this->id = $pdo->lastInsertId();
    }

    // LISTER les réservations d'une visite
    public static function listerParVisite($id_visite) {
        $db = new Database();
        $pdo = $db->getPdo();

        $sql = "SELECT r.*, u.nom 
                FROM reservations r 
                JOIN utilisateurs u ON r.idutilisateur_reservation = u.id_utilisateur 
                WHERE r.idvisite_reservation = :idvisite";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':idvisite' => $id_visite]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // LISTER les réservations d'un visiteur
    public static function listerParVisiteur($id_utilisateur) {
        $db = new Database();
        $pdo = $db->getPdo();

        $sql = "SELECT r.*, v.titre, v.dateheure 
                FROM reservations r 
                JOIN visitesguidees v ON r.idvisite_reservation = v.id_visite 
                WHERE r.idutilisateur_reservation = :idutilisateur";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':idutilisateur' => $id_utilisateur]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // COMPTER le nombre de personnes réservées pour une visite
    public static function compterPersonnesReservees($id_visite) {
        $db = new Database();
        $pdo = $db->getPdo();

        $sql = "SELECT SUM(nbpersonnes) as total FROM reservations WHERE idvisite_reservation = :idvisite";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':idvisite' => $id_visite]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ? $result['total'] : 0;
    }
}
?>