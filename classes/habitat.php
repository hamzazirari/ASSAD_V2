<?php
require_once('Database.php');

class Habitat {
    private $id_hab;
    private $nom_hab;
    private $typeclimat;
    private $description;
    private $zonezoo;

    public function __construct($id_hab, $nom_hab, $typeclimat, $description, $zonezoo) {
        $this->id_hab = $id_hab;
        $this->nom_hab = $nom_hab;
        $this->typeclimat = $typeclimat;
        $this->description = $description;
        $this->zonezoo = $zonezoo;
    }

    public function getIdHab() { 
        return $this->id_hab; 
    }

    public function getNomHab() { 
        return $this->nom_hab; 
    }

    public function getTypeClimat() { 
        return $this->typeclimat; 
    }

    public function getDescription() { 
        return $this->description; 
    }

    public function getZoneZoo() { 
        return $this->zonezoo; 
    }

    public static function listerTous() {
        $db = new Database();
        $pdo = $db->getPdo();

        $sql = "SELECT * FROM habitats";
        $stmt = $pdo->query($sql);

        $habitats = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $habitats[] = new Habitat(
                $row['id_hab'],
                $row['nom_hab'],
                $row['typeclimat'],
                $row['description'],
                $row['zonezoo']
            );
        }

        return $habitats;
    }

    public static function trouverParId($id_hab) {
        $db = new Database();
        $pdo = $db->getPdo();

        $sql = "SELECT * FROM habitats WHERE id_hab = :id_hab";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id_hab' => $id_hab]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($row) {
            return new Habitat(
                $row['id_hab'],
                $row['nom_hab'],
                $row['typeclimat'],
                $row['description'],
                $row['zonezoo']
            );
        }
        return null;
    }

    public function supprimer() {
        $db = new Database();
        $pdo = $db->getPdo();

        $sql = "DELETE FROM habitats WHERE id_hab = :id_hab";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id_hab' => $this->id_hab]);
    }
}
?>