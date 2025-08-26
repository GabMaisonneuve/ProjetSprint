<?php 
namespace App\Models;

use App\Providers\View;

class Mise extends CRUD {

    protected $table = 'offres';
    protected $primaryKey = 'id_offre';

    public function ajouterMise($id_enchere, $id_membre, $montant) {
        $sql = "INSERT INTO offres (id_enchere, id_membre, montant, date_offre)
                VALUES (:id_enchere, :id_membre, :montant, NOW())";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(":id_enchere", $id_enchere, \PDO::PARAM_INT);
        $stmt->bindValue(":id_membre", $id_membre, \PDO::PARAM_INT);
        $stmt->bindValue(":montant", $montant, \PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function obtenirDerniereMise($id_enchere) {
        $sql = "SELECT * FROM offres
                WHERE id_enchere = :id_enchere
                ORDER BY montant DESC
                LIMIT 1";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(":id_enchere", $id_enchere, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function obtenirToutesMises($id_enchere) {
        $sql = "SELECT o.*, m.nom AS membre_nom
                FROM offres o
                JOIN membres m ON o.id_membre = m.id_membre
                WHERE 0.id_enchere = :id_enchere
                ORDER BY o.date_offre DESC";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(":id_enchere", $id_enchere, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}

?>