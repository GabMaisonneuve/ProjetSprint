<?php 
namespace App\Models;

use App\Providers\View;

require_once 'CRUD.php';

class Encheres extends CRUD
{
    protected $table = 'encheres';
    protected $primaryKey = 'id_enchere';

public function selectEnchere($id) {
    $sql = "SELECT e.*, t.nom, i.url_image AS image_principale
            FROM encheres e
            JOIN timbres t ON e.id_timbre = t.id_timbre
            LEFT JOIN images i ON i.id_timbre = t.id_timbre AND i.principale = 1
            WHERE e.id_enchere = :id";
            
    $stmt = $this->prepare($sql);
    $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
    $stmt->execute();
    $enchere = $stmt->fetch();

    if($enchere) {
        $sql2 = "SELECT url_image
                 FROM images
                 WHERE id_timbre = :id_timbre AND principale = 0";

        $stmt2 = $this->prepare($sql2);
        $stmt2->bindValue(':id_timbre', $enchere['id_timbre'], \PDO::PARAM_INT);
        $stmt2->execute();
        $enchere['images_secondaires'] = $stmt2->fetchAll();
    }

    return $enchere;
}

    public function selectActive() {
        $sql = "SELECT * FROM encheres 
                WHERE date_debut <= NOW() AND date_fin >= NOW()";
        $stmt = $this->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }


    public function selectAllEncheres() {
        $sql = "SELECT 
                    e.*, 
                    t.nom, 
                    i.url_image AS image_principale
                FROM encheres e
                JOIN timbres t ON e.id_timbre = t.id_timbre
                LEFT JOIN images i ON i.id_timbre = t.id_timbre AND i.principale = 1
                ORDER BY e.date_debut DESC";

        $stmt = $this->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function selectCoupsDeCoeur() {
        $sql = "SELECT * FROM encheres WHERE coup_de_coeur_lord = 1 ORDER BY date_debut DESC";
        $stmt = $this->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getEncheresFiltres($filtre, $couleur, $session)
{
    $sql = "SELECT 
                e.*, 
                t.nom, 
                i.url_image AS image_principale
            FROM encheres e
            JOIN timbres t ON e.id_timbre = t.id_timbre
            LEFT JOIN images i ON i.id_timbre = t.id_timbre AND i.principale = 1";
    $params = [];

    switch ($filtre) {
        case 'coupdecoeur':
            $sql .= " WHERE e.coup_de_coeur_lord = 1";
            break;
        case 'prixasc':
            $sql .= " ORDER BY e.prix_plancher ASC";
            break;
        case 'prixdesc':
            $sql .= " ORDER BY e.prix_plancher DESC";
            break;
        case 'date':
            $sql .= " ORDER BY e.date_fin ASC";
            break;
        case 'favoris':
            if ($session && isset($session['id_membre'])) {
                $sql = "SELECT 
                            e.*, 
                            t.nom, 
                            i.url_image AS image_principale
                        FROM encheres e
                        JOIN timbres t ON e.id_timbre = t.id_timbre
                        LEFT JOIN images i ON i.id_timbre = t.id_timbre AND i.principale = 1
                        INNER JOIN favoris f ON e.id_enchere = f.id_enchere 
                        WHERE f.id_membre = :id_membre";
                $params[':id_membre'] = $session['id_membre'];
            } else {
                return [];
            }
            break;
        default:
            $sql .= " ORDER BY e.date_debut DESC";
            break;
    }

    $stmt = $this->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

}
?>