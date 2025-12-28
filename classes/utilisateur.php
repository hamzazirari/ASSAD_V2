<?php 
require_once('Database.php');

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
    
 $sql = "INSERT INTO utilisateurs (nom, email, role, motpasse_hash, etat, approuve) 
        VALUES (:nom, :email, :role, :motpasse_hash, :etat, :approuve)";
 $stmt = $pdo->prepare($sql);

 $stmt->execute([
    ':nom' => $this->nom,
    ':email' => $this->email,
    ':role' => $this->role,
    ':motpasse_hash' => $this->motDePasseHashe,
    ':etat' => $this->etat,
    ':approuve' => $this->approuve
]);

$this->id = $pdo->lastInsertId();
}

public static function trouverParEmail($email){
    $db = new Database();
    $pdo = $db->getPdo();

    $sql ="SELECT * FROM utilisateurs WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':email'=>$email]);

    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if($data){
        $utilisateur = new Utilisateur(
            $data['nom'],
            $data['email'],
            $data['role'],
            $data['motpasse_hash'],
            $data['etat'],
            $data['approuve']
        );
        $utilisateur->id = $data['id_utilisateur'];
        return $utilisateur;
    }else{
        return null;
    }
}

public  function verifierMotDePasse($motDePasse){
    return password_verify($motDePasse, $this->motDePasseHashe);
}

}
?>