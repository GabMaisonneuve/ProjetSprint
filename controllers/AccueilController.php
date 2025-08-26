<?php 
namespace App\Controllers;

use App\Models\Encheres;
use App\Models\Mise;          
use App\Providers\View;

class AccueilController {
    public function index() {
        $session = $_SESSION ?? null;

        $encheresModel = new Encheres();
        $miseModel     = new Mise();  

        
        $encheres = $encheresModel->selectAllEncheres();
        $coups_de_coeur = array_values(array_filter($encheres, function ($e) {
            return !empty($e['coup_de_coeur_lord']);
        }));

        
        foreach ($coups_de_coeur as &$enchere) {
            $lastBid = $miseModel->obtenirDerniereMise($enchere['id_enchere']);
            $enchere['prix_actuel'] = $lastBid['montant'] ?? $enchere['prix_plancher'];
        }
        unset($enchere);

        return View::render('accueil', [
            'session'        => $session,
            'coups_de_coeur' => $coups_de_coeur,
        ]);
    }

    public function error404() {
        http_response_code(404);
        return View::render('error404');
    }
}