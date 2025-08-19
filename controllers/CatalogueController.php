<?php 
 namespace App\Controllers;

use App\Models\Encheres;
use App\Providers\View;

class CatalogueController
{
    public function index()
    {
        $session = $_SESSION ?? null;
        $encheres = new Encheres();
        $listeEncheres = $encheres->selectAllEncheres();


         return View::render('catalogue',[
            'title' => 'Catalogue',
            'encheres' => $listeEncheres,
            'session' => $session
        ]);
    }

   public function show()
{
    $id = $_GET['id'] ?? null;

    $session = $_SESSION ?? null;
    $encheres = new Encheres();
    $enchere = $encheres->selectEnchere($id);

    if (!$enchere) {
        echo "Enchère non trouvée";
        return;
    }

    return View::render('enchere', [
        'title' => $enchere['nom'],
        'enchere' => $enchere,
        'session' => $session
    ]);
}
}

?>