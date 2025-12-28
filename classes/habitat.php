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

    // GETTERS
    public function getIdHab() {
         return $this->id_hab; }

    public function getNomHab() {
         return $this->nom_hab; }

    public function getTypeClimat() { 
        return $this->typeclimat; }

    public function getDescription() {
         return $this->description; }
         
    public function getZoneZoo() {
         return $this->zonezoo; }

    // SETTERS
    public function setNomHab($nom_hab) {
         $this->nom_hab = $nom_hab; }

    public function setTypeClimat($typeclimat) {
         $this->typeclimat = $typeclimat; }

    public function setDescription($description) {
         $this->description = $description; }

    public function setZoneZoo($zonezoo) { 
        $this->zonezoo = $zonezoo; }


    public static function listerTous() {
        $db = new Database();
        $pdo = $db->getPdo();

        $sql = "SELECT * FROM habitat"; 
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
}
?>
