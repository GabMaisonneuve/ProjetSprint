<?php
namespace App\Models;

require_once 'CRUD.php';

class ConditionTimbre extends CRUD
{
    protected $table = 'conditions';
    protected $primaryKey = 'id_condition';

    public function all(): array
    {
        $stmt = $this->query("SELECT id_condition, nom_condition FROM {$this->table} ORDER BY id_condition");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
