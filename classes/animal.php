<?php
require_once('Database.php');

class Animal {

    private $id;
    private $nom;
    private $description;
    private $image;
    private $habitatId;
    private $habitatNom;

    public function __construct($id,$nom,$description, $image,$habitatId,$habitatNom) {
        
        $this->id = $id;
        $this->nom = $nom;
        $this->description = $description;
        $this->image = $image;
        $this->habitatId = $habitatId;
        $this->habitatNom = $habitatNom;
    }

    // GETTERS

    public function getId(){
        return $this->id;
    }

    public function getNom(){
        return $this->nom;
    }

    public function getDescription(){
        return $this->description;
    }

    public function getImage(){
        return $this->image;
    }

    public function getHabitatId(){
        return $this->habitatId;
    }

    public function getHabitatNom(){
        return $this->habitatNom;
    }

    public static function listerTous(){

    $db = new Database();
    $pdo = $db->getPdo();

    $sql = " SELECT a.id_animal,a.nom,a.description,a.image,a.habitat_id,h.nom AS habitat_nom
        FROM animaux a
        JOIN habitats h ON a.habitat_id = h.id_habitat
    ";

    $stmt = $pdo->query($sql);

    $animaux = [];

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $animaux[] = new Animal(
            $row['id_animal'],
            $row['nom'],
            $row['description'],
            $row['image'],
            $row['habitat_id'],
            $row['habitat_nom']
        );
    }

    return $animaux;
}

}
