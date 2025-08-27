<?php 
namespace App\Controllers;

use App\Models\Mise;
use App\Providers\View;
use App\Providers\Validator;

Class miseController {

public function ajouter() {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $id_enchere = $_GET['id'] ?? null;
        $id_membre = $_SESSION["id_membre"] ?? null;
        $montant = $_POST["montant"];
        $session = $_SESSION ?? null;

        $validator = new Validator();
        $validator->field("montant", $montant, "Montant")->required();

        if (!$id_membre) {
            $validator->field("id_membre", "", "Utilisateur")->required();
        }

        $enchereModel = new \App\Models\Encheres();
        $enchere = $enchereModel->selectEnchere($id_enchere);

        $mise = new Mise();
        $derniereMise = $mise->obtenirDerniereMise($id_enchere);
        $currentBid = $derniereMise['montant'] ?? $enchere['prix_plancher'];

        // Vérifie les erreurs avec la classe Validator
        if (!$validator->isSuccess() || ($derniereMise && $montant <= $currentBid)) {
            $errors = $validator->getErrors() ?? [];
            if ($derniereMise && $montant <= $currentBid) {
                $errors['montant'] = "L'offre doit être plus haute que la dernière: $currentBid $";
            }

            return View::render("enchere", [
                "erreurs" => $errors,
                "enchere" => $enchere,
                "currentBid" => $currentBid
            ]);
        }

        // Met une nouvelle Mise
        $mise->ajouterMise($id_enchere, $id_membre, $montant);
        $currentBid = $montant;
        

        return View::render("enchere", [
            "success" => "Votre mise a été ajoutée avec succès!",
            "enchere" => $enchere,
            "currentBid" => $currentBid,
            "session" => $session
        ]);
    }
}

}

?>