<?php
namespace App\Models;

require_once 'CRUD.php';

class Image extends CRUD
{
    protected $table = 'images';
    protected $primaryKey = 'id_image';

    public function addForTimbre($id_timbre, $url_image, $principale = true): bool
    {
        $sql = "INSERT INTO images (id_timbre, url_image, principale)
                VALUES (:id_timbre, :url_image, :principale)";

        $stmt = $this->prepare($sql);
        return $stmt->execute([
            ':id_timbre'  => $id_timbre,
            ':url_image'  => $url_image,
            ':principale' => $principale ? 1 : 0,
        ]);
    }

    public function findSecondaryByTimbre($idTimbre): array
{
    $sql = "SELECT url_image 
            FROM images 
            WHERE id_timbre = :id AND principale = 0";
    $stmt = $this->prepare($sql);
    $stmt->execute([':id' => $idTimbre]);
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}
}
