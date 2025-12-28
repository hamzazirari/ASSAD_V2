<?php
require_once('Database.php');

class Animal {
    private $id_animal;
    private $nom;
    private $espece;
    private $alimentation;
    private $image;
    private $paysorigine;
    private $descriptioncourte;
    private $id_habitat;

    public function __construct($id_animal, $nom, $espece, $alimentation, $image, $paysorigine, $descriptioncourte, $id_habitat) {
        $this->id_animal = $id_animal;
        $this->nom = $nom;
        $this->espece = $espece;
        $this->alimentation = $alimentation;
        $this->image = $image;
        $this->paysorigine = $paysorigine;
        $this->descriptioncourte = $descriptioncourte;
        $this->id_habitat = $id_habitat;
    }

    public function getIdAnimal() { 
        return $this->id_animal; 
    }

    public function getNom() { 
        return $this->nom; 
    }

    public function getEspece() {
         return $this->espece; 
    }

    public function getAlimentation() {
         return $this->alimentation; 
    }

    public function getImage() {
         return $this->image; 
    }

    public function getPaysOrigine() {
         return $this->paysorigine; 
    }

    public function getDescriptionCourte() {
         return $this->descriptioncourte; 
    }

    public function getIdHabitat() { 
        return $this->id_habitat; 
    }

    public static function listerTous() {
        $db = new Database();
        $pdo = $db->getPdo();

        $sql = "SELECT * FROM animaux"; 
        $stmt = $pdo->query($sql);

        $animaux = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $animaux[] = new Animal(
                $row['id_animal'],
                $row['nom'],
                $row['espece'],
                $row['alimentation'],
                $row['image'],
                $row['paysorigine'],
                $row['descriptioncourte'],
                $row['id_habitat']
            );
        }

        return $animaux;
    }

    public static function listerParHabitat($id_hab) {
        $db = new Database();
        $pdo = $db->getPdo();

        $sql = "SELECT * FROM animaux WHERE id_habitat = :id_habitat"; 
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id_habitat' => $id_hab]);

        $animaux = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $animaux[] = new Animal(
                $row['id_animal'],
                $row['nom'],
                $row['espece'],
                $row['alimentation'],
                $row['image'],
                $row['paysorigine'],
                $row['descriptioncourte'],
                $row['id_habitat']
            );
        }

        return $animaux;
    }

    public function supprimer() {
        $db = new Database();
        $pdo = $db->getPdo();

        $sql = "DELETE FROM animaux WHERE id_animal = :id_animal";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id_animal' => $this->id_animal]);
    }
}
?>