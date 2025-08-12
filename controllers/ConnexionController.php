<?php

namespace App\Controllers;

use App\Models\Membre;
use App\Providers\View;


class ConnexionController{
    public function index(){
        return View::render('connexion', [
            'title' => 'Connexion'
        ]);
    }

    public function deconnexion(){
        unset($_SESSION['utilisateur']);
        session_destroy();
        return View::render('accueil',[
            'title' => 'Accueil',
            'message' => 'Vous avez été déconnecté avec succès.'
        ]);
    }

    public function connexion(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
         $mot_de_passe = htmlspecialchars($_POST['mot_de_passe']) ?? '';

         $membreModel = new Membre();
         $utilisateur = $membreModel->getUtilisateurParUtilisateur($_POST['nom_utilisateur']);

         if ($utilisateur && password_verify($mot_de_passe, $utilisateur['mot_de_passe'])) {
          $membreModel->creerSessionUtilisateur($utilisateur);
            $session = $_SESSION ?? null;
            return View::render('accueil', [
                'session' => $session,
                'title' => 'Accueil',
            ]);
         }

         else {
            return View::render('connexion', [
                'title' => 'Connexion',
                'erreur' => 'Nom d\'utilisateur ou mot de passe incorrect.'
            ]);
         }
        }

        return View::render('connexion', [
            'title' => 'Connexion'
        ]);
    }
}
?>