<?php
class Database {
private $host = 'localhost';
private $dbname = 'assadv2';
private $username = 'root';
private $password = '';
private $pdo;

public function __construct(){

    try{
        $this->pdo = new PDO(
            "mysql:host={$this->host};dbname={$this->dbname}",
            $this->username,
            $this->password
        );

    }catch(PDOException $e){
        die("Erreur de connexion : ".$e->getMessage());
    }
}

public function getPdo(){
    return $this->pdo;
}
}

?>