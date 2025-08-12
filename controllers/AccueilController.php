<?php 
namespace App\Controllers;

use App\Models\Membre;
use App\Providers\View;

class AccueilController {
    public function index(){
        $session = $_SESSION ?? null;
        return View::render('accueil' , [
            'session' => $session
        ]);
    }

    public function error404() {
        http_response_code(404);
        return View::render('error404');
    }
}

?>