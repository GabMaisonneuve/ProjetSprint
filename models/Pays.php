<?php
namespace App\Models;

require_once 'CRUD.php';

class Pays extends CRUD
{
    protected $table = 'pays';
    protected $primaryKey = 'id_pays';

    public function all(): array
    {
        $stmt = $this->query("SELECT id_pays, nom_pays FROM {$this->table} ORDER BY nom_pays");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
