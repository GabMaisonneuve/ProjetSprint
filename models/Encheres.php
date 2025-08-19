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
    return $stmt->fetch();
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

}


?>