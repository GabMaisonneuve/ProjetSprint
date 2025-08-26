<?php
namespace App\Models;

class Favoris extends CRUD {
    protected $table = 'favoris';

    public function ajouterFavori($id_membre, $id_enchere) {
        $sql = "INSERT IGNORE INTO favoris (id_membre, id_enchere) VALUES (:id_membre, :id_enchere)";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(':id_membre', $id_membre, \PDO::PARAM_INT);
        $stmt->bindValue(':id_enchere', $id_enchere, \PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function supprimerFavori($id_membre, $id_enchere) {
        $sql = "DELETE FROM favoris WHERE id_membre = :id_membre AND id_enchere = :id_enchere";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(':id_membre', $id_membre, \PDO::PARAM_INT);
        $stmt->bindValue(':id_enchere', $id_enchere, \PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function obtenirFavoris($id_membre) {
        $sql = "SELECT e.* 
                FROM favoris f
                JOIN encheres e ON f.id_enchere = e.id_enchere
                WHERE f.id_membre = :id_membre";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(':id_membre', $id_membre, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function estFavori($id_membre, $id_enchere) {
        $sql = "SELECT COUNT(*) as count 
                FROM favoris 
                WHERE id_membre = :id_membre AND id_enchere = :id_enchere";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(':id_membre', $id_membre, \PDO::PARAM_INT);
        $stmt->bindValue(':id_enchere', $id_enchere, \PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['count'] > 0;
    }
}