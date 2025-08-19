<?php
namespace App\Models;

require_once 'CRUD.php';

class Timbre extends CRUD
{
    protected $table = 'timbres';
    protected $primaryKey = 'id_timbre';

    public function create($data): int
    {
        $sql = "INSERT INTO timbres
                (nom, date_creation, id_pays, id_couleur, id_condition, tirage, dimensions, certifie, id_membre)
                VALUES (:nom, :date_creation, :id_pays, :id_couleur, :id_condition, :tirage, :dimensions, :certifie, :id_membre)";

        $stmt = $this->prepare($sql);
        $stmt->execute([
            ':nom'           => $data['nom'],
            ':date_creation' => $data['date_creation'],
            ':id_pays'       => $data['id_pays'],
            ':id_couleur'    => $data['id_couleur'],
            ':id_condition'  => $data['id_condition'],
            ':tirage'        => $data['tirage'],
            ':dimensions'    => $data['dimensions'],
            ':certifie'      => $data['certifie'],
            ':id_membre'     => $data['id_membre'],
        ]);

        return $this->lastInsertId();
    }

public function findWithRelations($id): ?array
{
    $sql = "SELECT t.*, 
                   p.nom_pays,
                   c.nom_couleur, 
                   cond.nom_condition,
                   url_image as image_principale
            FROM timbres t
            LEFT JOIN pays p ON t.id_pays = p.id_pays  
            LEFT JOIN couleurs c ON t.id_couleur = c.id_couleur
            LEFT JOIN conditions cond ON t.id_condition = cond.id_condition
            LEFT JOIN images i ON t.id_timbre = i.id_timbre AND i.principale = 1
            WHERE t.id_timbre = :id";
            
    $stmt = $this->prepare($sql);
    $stmt->execute([':id' => $id]);
    $result = $stmt->fetch();
    
    // Si pas d'image principale, ajouter une image par défaut
    if ($result && empty($result['image_principale'])) {
        $result['image_principale'] = '/uploads/default-timbre.jpg';
    }
    
    return $result ?: null;
}
}
