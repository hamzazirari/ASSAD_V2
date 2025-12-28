<?php
require_once('Database.php');

class Habitat {

    private $id;
    private $nom;
    private $description;

    public function __construct($id, $nom, $description){
        $this->id = $id;
        $this->nom = $nom;
        $this->description = $description;
    }

    // getters
    public function getId(){
        return $this->id;
    }

    public function getNom(){
        return $this->nom;
    }

    public function getDescription(){
        return $this->description;
    }

    public static function listerTous(){
        $db = new Database();
        $pdo = $db->getPdo();

        $sql = "SELECT * FROM habitats";
        $stmt = $pdo->query($sql);

        $habitats = [];

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $habitats[] = new Habitat(
                $row['id_habitat'],
                $row['nom'],
                $row['description']
            );
        }

        return $habitats;
    }
}
