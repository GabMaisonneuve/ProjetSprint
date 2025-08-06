<?php 
namespace App\Controllers;
use App\Providers\View;

class AccueilController {
    public function index(){
        View::render('accueil');
    }
}

?>