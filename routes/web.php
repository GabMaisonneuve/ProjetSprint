<?php
use App\Routes\Route;
use App\Controllers\AccueilController;
use App\Controllers\InscriptionController;
use App\Controllers\ConnexionController;


// Route pour la page d'accueil
Route::get('', 'AccueilController@index');

// Route pour test connexion
Route::get('accueil', 'TestController@connexion');


// Routes pour l'inscription
Route::get('/inscription', 'InscriptionController@index');
Route::post('/inscription', 'InscriptionController@inscription');

//Routes pour la connexion
Route::get('/connexion', 'ConnexionController@index');
Route::post('/connexion', 'ConnexionController@connexion');

// Route pour la déconnexion
Route::get('/deconnexion', 'ConnexionController@deconnexion');


// Routes pour le profil
Route::get('/profil', 'ProfilController@index');
// Pour le formulaire de modification de profil
Route::get('/profil_edit', 'ProfilController@modifierProfil');
// Met a jour le profil
Route::post('/profil', 'ProfilController@updateProfil');



Route::dispatch();
?>