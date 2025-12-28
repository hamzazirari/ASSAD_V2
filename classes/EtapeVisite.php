<?php
require_once('Database.php');

class EtapeVisite {
    private $id_etape;
    private $titreetape;
    private $descriptionetape;
    private $ordreetape;
    private $id_visite;

    public function __construct($id_etape, $titreetape, $descriptionetape, $ordreetape, $id_visite) {
        $this->id_etape = $id_etape;
        $this->titreetape = $titreetape;
        $this->descriptionetape = $descriptionetape;
        $this->ordreetape = $ordreetape;
        $this->id_visite = $id_visite;
    }

    // GETTERS
    public function getIdEtape() { 
        return $this->id_etape; 
    }

    public function getTitreEtape() { 
        return $this->titreetape; 
    }

    public function getDescriptionEtape() { 
        return $this->descriptionetape; 
    }

    public function getOrdreEtape() { 
        return $this->ordreetape; 
    }

    public function getIdVisite() { 
        return $this->id_visite; 
    }

    // AJOUTER une étape
    public function creer() {
        $db = new Database();
        $pdo = $db->getPdo();

        $sql = "INSERT INTO etapesvisite (titreetape, descriptionetape, ordreetape, id_visite) 
                VALUES (:titreetape, :descriptionetape, :ordreetape, :id_visite)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':titreetape' => $this->titreetape,
            ':descriptionetape' => $this->descriptionetape,
            ':ordreetape' => $this->ordreetape,
            ':id_visite' => $this->id_visite
        ]);

        $this->id_etape = $pdo->lastInsertId();
    }

    // LISTER toutes les étapes d'une visite
    public static function listerParVisite($id_visite) {
        $db = new Database();
        $pdo = $db->getPdo();

        $sql = "SELECT * FROM etapesvisite WHERE id_visite = :id_visite ORDER BY ordreetape";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id_visite' => $id_visite]);

        $etapes = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $etapes[] = new EtapeVisite(
                $row['id_etape'],
                $row['titreetape'],
                $row['descriptionetape'],
                $row['ordreetape'],
                $row['id_visite']
            );
        }

        return $etapes;
    }
}
?>