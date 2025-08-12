<?php 
namespace App\Models;

require_once 'CRUD.php';

class Membre extends CRUD {
    protected $table = 'membres';

    protected $primaryKey = 'id_membre';

    protected $fillable = ['nom', 'prenom', 'courriel', 'mot_de_passe', 'nom_utilisateur'];

public function inscriptionUtilisateur($data) {
    $stmt = $this->prepare("INSERT INTO {$this->table} (nom, prenom, courriel, mot_de_passe, nom_utilisateur)
                            VALUES (:nom, :prenom, :courriel, :mot_de_passe, :nom_utilisateur)");

    $stmt->bindParam(':nom', $data['nom']);
    $stmt->bindParam(':prenom', $data['prenom']);
    $stmt->bindParam(':courriel', $data['courriel']);
    $stmt->bindParam(':nom_utilisateur', $data['nom_utilisateur']);

    $motDePasseHash = password_hash($data['mot_de_passe'], PASSWORD_DEFAULT);
    $stmt->bindParam(':mot_de_passe', $motDePasseHash);

    return $stmt->execute();
}

    public function getUtilisateurParUtilisateur($nom_utilisateur){
        $stmt = $this->prepare("SELECT * FROM {$this->table} WHERE nom_utilisateur = ?");
        $stmt->execute([$nom_utilisateur]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function creerSessionUtilisateur($utilisateur) {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    
        $_SESSION['id_membre'] = $utilisateur['id_membre'];
        $_SESSION['nom_utilisateur'] = $utilisateur['nom_utilisateur'];
        $_SESSION['nom'] = $utilisateur['nom'] ?? null;
        $_SESSION['prenom'] = $utilisateur['prenom'] ?? null;
        $_SESSION['mot_de_passe'] = $utilisateur['mot_de_passe'] ?? null;
        $_SESSION['courriel'] = $utilisateur['courriel'] ?? null;
        $_SESSION['id_role'] = $utilisateur['id_role'] ?? 1;

        
}
}

?>