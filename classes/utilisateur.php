<?php 
require_once('../classes/Database.php');

class Utilisateur {
    private $id;
    private $nom;
    private $email;
    private $role;
    private $motDePasseHashe;
    private $etat;
    private $approuve;

    function __construct($nom,$email,$role,$motDePasseHashe,$etat,$approuve){
        $this->nom = $nom;
        $this->email =$email;  
        $this->role =$role;  
        $this->motDePasseHashe =$motDePasseHashe;  
        $this->etat =$etat;  
        $this->approuve =$approuve;  
    }

    //GETTER

    public function getId(){
        return $this->id;
    }

    public function getNom(){
        return $this->nom;
    }
    public function getEmail(){
        return $this->email;
    }

     public function getRole(){
        return $this->role;
    }

     public function getMotDePasseHashe(){
        return $this->motDePasseHashe;
    }

    public function getEtat(){
        return $this->etat;
    }

    public function getApprouve(){
        return $this->approuve;
    }

    //SETTER

    public function setNom($nom){
    $this->nom = $nom;
}

  public function setEmail($email){
    $this->email = $email;
}

public function setRole($role){
    $this->role = $role;
}

public function setMotDePasseHashe($motDePasseHashe){
    $this->motDePasseHashe = $motDePasseHashe;
}

public function setEtat($etat){
    $this->etat = $etat;
}

public function setApprouve($approuve){
    $this->approuve = $approuve;
}


public  function creer(){
    $db = new Database();
    $pdo = $db->getPdo();
    
 $sql = "INSERT INTO utilisateurs (nom, email, role, motPasseHash, etat, approuve) 
        VALUES (:nom, :email, :role, :motPasseHash, :etat, :approuve)";
 $stmt = $pdo->prepare($sql);

 $stmt->execute([
    ':nom' => $this->nom,
    ':email' => $this->email,
    ':role' => $this->role,
    ':motPasseHash' => $this->motDePasseHashe,
    ':etat' => $this->etat,
    ':approuve' => $this->approuve
]);

$this->id = $pdo->lastInsertId();
}

public function trouverParEmail($email){
    $db = new Database();
    $pdo = $db->getPdo();

    $sql ="SELECT *FROM utilisateurs WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':email'=>$email]);

    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if($data){
       
        return new Utilisateur(
            $data['nom'],
            $data['email'],
            $data['role'],
            $data['motPasseHash'],
            $data['etat'],
            $data['approuve']
        );
    }else{
        return null;
    }
}

public function verifierMotDePasse($motDePasse){
    if(password_verify($motDePasse, $this->motDePasseHashe)){
        return true ; 
    }else {
        return false;
    }
}

}
?>