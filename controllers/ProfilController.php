<?php
namespace App\Controllers;

use App\Models\Membre;
use App\Providers\View;
use App\Models\CRUD;
use App\Providers\Validator;

class ProfilController {

    public function index() {
        if (!isset($_SESSION['nom_utilisateur'])) {
            return View::redirect('connexion');
        }
        $membre = new Membre();
        $utilisateur = $membre->getUtilisateurParUtilisateur($_SESSION['nom_utilisateur']);
        $session = $_SESSION ?? null;

        if (!$utilisateur) {
            return View::render('connexion', [
                'title' => 'Connexion',
                'erreur' => 'Utilisateur non trouvé.'
            ]);
        }

        unset($utilisateur['mot_de_passe']);
        return View::render('profil', [
            'title' => 'Profil',
            'utilisateur' => $utilisateur,
            'session' => $session
        ]);
    }

    // Montre le formulaire de modification du profil
    public function modifierProfil() {
        $session = $_SESSION ?? null;
       if (!isset($_SESSION['id_membre'])) {
        return View::redirect('connexion');
}

        $membre = new Membre();
        $utilisateur = $membre->selectId($_SESSION['id_membre']);
        if (!$utilisateur) return View::redirect('connexion');

        unset($utilisateur['mot_de_passe']);
        return View::render('profil_edit', [
            'title' => 'Modifier le profil',
            'utilisateur' => $utilisateur,
            'session' => $session
        ]);
    }

    // Met a jour le profil
  public function updateProfil($data) {
    $id_membre = $_SESSION['id_membre'] ?? null;
    $courriel = $data['courriel'] ?? '';
    $mot_de_passe = $data['mot_de_passe'] ?? '';
    $nom_utilisateur = $data['nom_utilisateur'] ?? '';

    // Validations
    $validator = new Validator();
    $validator
        ->field('courriel', $courriel)
        ->required()
        ->min(3)
        ->max(100);

    if (!empty($mot_de_passe)) {
        $validator
            ->field('mot_de_passe', $mot_de_passe)
            ->min(6)
            ->max(100);
    }

    $validator
        ->field('nom_utilisateur', $nom_utilisateur)
        ->required()
        ->min(3)
        ->max(16);

    if (!$validator->isSuccess()) {
        $errors = $validator->getErrors();
        $membreExistant = (new Membre())->selectId($id_membre);

        return View::render('profil', [
            'errors' => $errors,
            'membreExistant' => $membreExistant,
        ]);
    }

    // Hash le mot de passe si fourni
    if (!empty($mot_de_passe)) {
        $data['mot_de_passe'] = password_hash($mot_de_passe, PASSWORD_DEFAULT);
    } else {
        unset($data['mot_de_passe']); // Au cas où le mot de passe n'est pas modifié
    }

    $membre = new Membre();
    $membre->update($data, $id_membre);

    // Met à jour la session si le nom d'utilisateur ou le courriel à changé
    if (!empty($nom_utilisateur)) {
        $_SESSION['nom_utilisateur'] = $nom_utilisateur;
    }
    if (!empty($courriel)) {
        $_SESSION['courriel'] = $courriel;
    }

    View::redirect("profil?id={$id_membre}");
    exit;
}


}