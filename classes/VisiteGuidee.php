<?php
require_once('Database.php');

class VisiteGuidee {
    private $id_visite;
    private $titre;
    private $dateheure;
    private $langue;
    private $capacite_max;
    private $statut;
    private $duree;
    private $prix;
    private $id_guide;

    public function __construct($id_visite, $titre, $dateheure, $langue, $capacite_max, $statut, $duree, $prix, $id_guide) {
        $this->id_visite = $id_visite;
        $this->titre = $titre;
        $this->dateheure = $dateheure;
        $this->langue = $langue;
        $this->capacite_max = $capacite_max;
        $this->statut = $statut;
        $this->duree = $duree;
        $this->prix = $prix;
        $this->id_guide = $id_guide;
    }

    // GETTERS
    public function getIdVisite() { 
        return $this->id_visite; 
    }

    public function getTitre() { 
        return $this->titre; 
    }

    public function getDateHeure() { 
        return $this->dateheure; 
    }

    public function getLangue() { 
        return $this->langue; 
    }

    public function getCapaciteMax() { 
        return $this->capacite_max; 
    }

    public function getStatut() { 
        return $this->statut; 
    }

    public function getDuree() { 
        return $this->duree; 
    }

    public function getPrix() { 
        return $this->prix; 
    }

    public function getIdGuide() { 
        return $this->id_guide; 
    }

    // CRÉER une nouvelle visite
    public function creer() {
        $db = new Database();
        $pdo = $db->getPdo();

        $sql = "INSERT INTO visitesguidees (titre, dateheure, langue, capacite_max, statut, duree, prix, id_guide) 
                VALUES (:titre, :dateheure, :langue, :capacite_max, :statut, :duree, :prix, :id_guide)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':titre' => $this->titre,
            ':dateheure' => $this->dateheure,
            ':langue' => $this->langue,
            ':capacite_max' => $this->capacite_max,
            ':statut' => $this->statut,
            ':duree' => $this->duree,
            ':prix' => $this->prix,
            ':id_guide' => $this->id_guide
        ]);

        $this->id_visite = $pdo->lastInsertId();
        return $this->id_visite;
    }

    // LISTER toutes les visites d'un guide
    public static function listerParGuide($id_guide) {
        $db = new Database();
        $pdo = $db->getPdo();

        $sql = "SELECT * FROM visitesguidees WHERE id_guide = :id_guide";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id_guide' => $id_guide]);

        $visites = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $visites[] = new VisiteGuidee(
                $row['id_visite'],
                $row['titre'],
                $row['dateheure'],
                $row['langue'],
                $row['capacite_max'],
                $row['statut'],
                $row['duree'],
                $row['prix'],
                $row['id_guide']
            );
        }

        return $visites;
    }

    // ANNULER une visite (changer le statut)
    public function annuler() {
        $db = new Database();
        $pdo = $db->getPdo();

        $sql = "UPDATE visitesguidees SET statut = 'annulee' WHERE id_visite = :id_visite";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id_visite' => $this->id_visite]);
    }
}
?>