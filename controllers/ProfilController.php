<?php
namespace App\Controllers;

use App\Models\Membre;
use App\Providers\View;

class ProfilController {

    public function index() {
        if (!isset($_SESSION['utilisateur'])) {
            return View::redirect('connexion');
        }

        $membre = new Membre();
        $utilisateur = $membre->getUtilisateurParUtilisateur($_SESSION['utilisateur']['nom_utilisateur']);

        if (!$utilisateur) {
            return View::render('connexion', [
                'title' => 'Connexion',
                'erreur' => 'Utilisateur non trouvé.'
            ]);
        }

        unset($utilisateur['mot_de_passe']);

        return View::render('profil', [
            'title' => 'Profil',
            'utilisateur' => $utilisateur
        ]);
    }

    // Montre le formulaire de modification du profil
    public function modifierProfil() {
        if (!isset($_SESSION['utilisateur'])) {
            return View::redirect('connexion');
        }

        $membre = new Membre();
        $utilisateur = $membre->selectId($_SESSION['id_membre']);
        if (!$utilisateur) return View::redirect('connexion');

        unset($utilisateur['mot_de_passe']);
        return View::render('profil_edit', [
            'title' => 'Modifier le profil',
            'utilisateur' => $utilisateur
        ]);
    }

    // Met a jour le profil
    public function updateProfil() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return View::redirect('profil/edit');
        }

        if (!isset($_SESSION['id_membre'])) {
            return View::redirect('connexion');
        }

        $data = [
            'nom' => trim($_POST['nom'] ?? ''),
            'prenom' => trim($_POST['prenom'] ?? ''),
            'courriel' => trim($_POST['courriel'] ?? '')
        ];

        //Rentre un nouveau mot de passe si modifié
        if (!empty($_POST['mot_de_passe'])) {
            if (strlen($_POST['mot_de_passe']) < 8) {
                // Montre un message d'erreur et retourne à la vue de modification
                return View::render('profil_edit', [
                    'title' => 'Modifier le profil',
                    'utilisateur' => $data,
                    'erreur' => 'Le mot de passe doit contenir au moins 8 caractères'
                ]);
            }
            $data['mot_de_passe'] = password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT);
        }

        $membre = new Membre();
        $succes = $membre->update($data, $_SESSION['membre_id']);

        if ($succes) {
            $_SESSION['succes'] = 'Profil mis à jour.';
            return View::redirect('profil');
        } else {
            return View::render('profil_edit', [
                'title' => 'Modifier le profil',
                'utilisateur' => $data,
                'erreur' => 'Impossible de mettre à jour le profil.'
            ]);
        }
    }


}