<?php
namespace App\Models;

abstract class CRUD extends \PDO{

    final public function __construct(){
        parent::__construct('mysql:host=localhost;dbname=stampee;port=3306;charset=utf8', 'root', 'admin');
    }

    // Méthode de test
    public function testConnection() {
        try {
            $stmt = $this->query("SELECT 1");
            return $stmt !== false ? "Connexion réussie !" : "Échec de la connexion.";
        } catch (\PDOException $e) {
            return "Erreur PDO : " . $e->getMessage();
        }
    }

    final public function selectId($value){
        $sql = "SELECT * FROM  $this->table WHERE $this->primaryKey = :$this->primaryKey";
        $stmt = $this->prepare($sql);
        $stmt->bindValue(":$this->primaryKey", $value);
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count == 1){
            return $stmt->fetch();
        }else{
            return false;
        } 
    }

    final public function update($data, $id){
    $data_keys = array_fill_keys($this->fillable, '');
    $data = array_intersect_key($data, $data_keys);

    if (empty($data)) {
        throw new Exception("Aucune entrées valides fournies pour la mise à jour.");
    }

    $fieldName = '';
    foreach($data as $key => $value){
        $fieldName .= "$key = :$key, ";
    }

    $fieldName = rtrim($fieldName, ', ');
    $sql = "UPDATE {$this->table} SET $fieldName WHERE {$this->primaryKey} = :{$this->primaryKey}";
    
    $stmt = $this->prepare($sql);
    $data[$this->primaryKey] = $id;

    return $stmt->execute($data);
}


}