<?php 
namespace App\Controllers;

use App\Models\Membre;
use App\Providers\View;
use App\Providers\Validator;

class InscriptionController {
    
    public function index(){
        return View::render('inscription',[
            'title' => 'Inscription'
        ]);
    }

    public function inscription($data){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nom_utilisateur' => htmlspecialchars($_POST['nom_utilisateur']) ?? '',
                'courriel'        => htmlspecialchars($_POST['courriel']) ?? '',
                'mot_de_passe'    => htmlspecialchars($_POST['mot_de_passe']) ?? '',
                'prenom'          => htmlspecialchars($_POST['prenom']) ?? '',
                'nom'             => htmlspecialchars($_POST['nom']) ?? ''
            ];
        $validator = new Validator();

        
        if (!$validator->isSuccess()){
            $erreurs = $validator->getErrors();
            return View::render('inscription', [
                'title' => 'Inscription',
                'erreurs' => $erreurs
            ]);
        }
        


        $membre = new Membre();
        $membre->inscriptionUtilisateur($data);

        View::render('connexion', [
            'title' => 'Connexion',
            'message' => 'Inscription réussie.'
        ]);
        
    }
}
}

?>