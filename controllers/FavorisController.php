<?php
namespace App\Controllers;

use App\Models\Favoris;
use App\Providers\View;

class FavorisController {

    public function toggle() {
    $id_membre = $_SESSION['id_membre'] ?? null;
    $id_enchere = $_GET['id'] ?? null;

    header('Content-Type: application/json');

    if (!$id_membre || !$id_enchere) {
        echo json_encode(['error' => 'Utilisateur ou enchère manquant']);
        exit;
    }

    $favoris = new Favoris();
    $exists = $favoris->estFavori($id_membre, $id_enchere);

    if ($exists) {
        $favoris->supprimerFavori($id_membre, $id_enchere);
        echo json_encode(['removed' => true]);
    } else {
        $favoris->ajouterFavori($id_membre, $id_enchere);
        echo json_encode(['added' => true]);
    }
    exit;
}


    public function liste() {
        $id_membre = $_SESSION['id_membre'] ?? null;

        if (!$id_membre) {
            return View::render('erreur', ['message' => 'Utilisateur non connecté']);
        }

        $favori = new Favoris();
        $favoris = $favori->obtenirFavoris($id_membre);

        return View::render('profil', [
            'title' => 'Mes favoris',
            'favoris' => $favoris
        ]);
    }
}
