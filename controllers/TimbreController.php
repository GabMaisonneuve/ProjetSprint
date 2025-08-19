<?php
namespace App\Controllers;

use App\Models\Timbre;
use App\Models\Image;
use App\Models\Pays;
use App\Models\Couleur;
use App\Models\ConditionTimbre;
use App\Providers\View;
use App\Models\Membre;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Providers\Validator;



class TimbreController
{
    // Affiche le formulaire
    public function create()
    {

        
        if (!isset($_SESSION['nom_utilisateur'])) {
            return View::redirect('connexion');
        }
        $session = $_SESSION ?? null;

        $pays       = (new Pays())->all();
        $couleurs   = (new Couleur())->all();
        $conditions = (new ConditionTimbre())->all();

        $succes = $_GET['succes'] ?? false;
        return View::render('ajouter', [
            'title'      => 'Ajouter un timbre',
            'pays'       => $pays,
            'couleurs'   => $couleurs,
            'conditions' => $conditions,
            'session' => $session,
            'succes' => $succes,
        ]);
    }

    // Gère le POST
   public function store()
{
    $session = $_SESSION ?? null;
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        return View::redirect('ajouter');
    }

    if (!isset($_SESSION['id_membre'])) {
        return View::redirect('connexion');
    }

    // Récup des champs
    $data = [
        'nom'           => trim($_POST['nom'] ?? ''),
        'date_creation' => !empty($_POST['date_creation']) ? (int)$_POST['date_creation'] : null, // Forcer le INT puisque la date de création avait un bug sans
        'id_pays'       => (int)($_POST['id_pays'] ?? 0),
        'id_couleur'    => (int)($_POST['id_couleur'] ?? 0),
        'id_condition'  => (int)($_POST['id_condition'] ?? 0),
        'tirage'        => (int)($_POST['tirage'] ?? 0),
        'dimensions'    => trim($_POST['dimensions'] ?? ''),
        'certifie'      => isset($_POST['certifie']) ? 1 : 0,
        'id_membre'     => (int)($session['id_membre'] ?? 0),
    ];

    // --- Utilisation de Validator ---
    $validator = new Validator();

    $validator->field('nom', $data['nom'], 'Nom')->required()->max(255);

    $validator->field('date_creation', $data['date_creation'], 'Année')
              ->required();
    if ($data['date_creation'] < 1840 || $data['date_creation'] > (int)date('Y') + 1) {
        // Ajout manuel car Validator n’a pas de règle "between"
        $validator->field('date_creation', $data['date_creation'], 'Année');
        $validator->getErrors()['date_creation'] = "Année invalide.";
    }

    $validator->field('id_pays', $data['id_pays'], 'Pays')->required();
    $validator->field('id_couleur', $data['id_couleur'], 'Couleur')->required();
    $validator->field('id_condition', $data['id_condition'], 'Condition')->required();

    $validator->field('tirage', $data['tirage'], 'Tirage')->required();
    if ($data['tirage'] < 0) {
        $validator->getErrors()['tirage'] = "Le tirage doit être positif.";
    }

    $validator->field('dimensions', $data['dimensions'], 'Dimensions')->required()->max(50);

    if (!isset($_FILES['image']) || $_FILES['image']['error'] === UPLOAD_ERR_NO_FILE) {
        $validator->field('image', null, 'Image');
        $validator->getErrors()['image'] = "Veuillez sélectionner une image.";
    }

    if ($session['id_membre'] <= 0) {
        $validator->field('id_membre', null, 'Session');
        $validator->getErrors()['id_membre'] = "Session invalide (id membre manquant).";
    }

    // Récupérer les erreurs
    $erreurs = $validator->getErrors();

    if (!empty($erreurs)) {
        $pays       = (new Pays())->all();
        $couleurs   = (new Couleur())->all();
        $conditions = (new ConditionTimbre())->all();

        return View::render('ajouter', [
            'title'      => 'Ajouter un timbre',
            'pays'       => $pays,
            'couleurs'   => $couleurs,
            'conditions' => $conditions,
            'erreurs'    => $erreurs,
            'old'        => $_POST,
            'session'    => $session,
        ]);
    }

        // 1) Insertion du timbre
        $timbreModel = new Timbre();
        $idTimbre = $timbreModel->create($data);

        // 2) Traitement de l'image (Intervention Image)
        if (!empty($_FILES['image']['tmp_name'])) {

            $uploadDir = __DIR__ . '/../public/uploads/timbres';

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION) ?: 'jpg');
            $fileName = $idTimbre . '_' . uniqid('', true) . '.' . $ext;
            $destPath = $uploadDir . '/' . $fileName;

            $manager = new ImageManager(new Driver());
            $manager->read($_FILES['image']['tmp_name'])
            // On force la taille max de l'image 
            ->scaleDown(1600, 1600)
            // Puis on sauvegarde
            ->save($destPath, 85);
            // Le lien public 
            $publicUrl = '/uploads/timbres/' . $fileName;

            
            $imageModel = new Image();
            $imageModel->addForTimbre($idTimbre, $publicUrl, true);
        }

        if (!empty($_FILES['images']['name'][0])) {
        $count = count($_FILES['images']['name']);

        if ($count > 4) {
            $count = 4; // limiter à 4
        }

        for ($i = 0; $i < $count; $i++) {
            if ($_FILES['images']['error'][$i] === UPLOAD_ERR_OK) {
                $tmpName = $_FILES['images']['tmp_name'][$i];
                $ext = strtolower(pathinfo($_FILES['images']['name'][$i], PATHINFO_EXTENSION) ?: 'jpg');
                $fileName = $idTimbre . '_sec_' . uniqid('', true) . '.' . $ext;
                $destPath = $uploadDir . '/' . $fileName;

                $manager->read($tmpName)
                    ->scaleDown(400, 400) // un peu plus petit
                    ->save($destPath, 85);

                $publicUrl = '/uploads/timbres/' . $fileName;

                $imageModel->addForTimbre($idTimbre, $publicUrl, false); // false = pas principale
            }
        }
        }
        
        // Redirection
       return View::redirect('ajouter?succes=1');
    }

    

    public function show($id) 
{
    
    // On prends le ID du timbre depuis l'URL
    $id = $_GET['id'];
    
    // Création d'un instance de Timbre
    $timbreModel = new Timbre();
    $timbre = $timbreModel->findWithRelations($id);
    
    // Vérifier si le timbre existe
    if (!$timbre) {
        echo "Timbre non trouvé avec ID: $id";
        return;
    }

    return View::render('detail', [
        'title' => 'Test Détail',
        'timbre' => $timbre,
        'session' => $_SESSION ?? null
    ]);
}
}
