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
}