<?php
namespace App\Models;

require_once 'CRUD.php';

class Couleur extends CRUD
{
    protected $table = 'couleurs';
    protected $primaryKey = 'id_couleur';

    public function all(): array
    {
        $stmt = $this->query("SELECT id_couleur, nom_couleur FROM {$this->table} ORDER BY nom_couleur");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
