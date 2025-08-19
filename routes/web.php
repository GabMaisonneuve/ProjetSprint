<?php
use App\Routes\Route;
use App\Controllers\AccueilController;
use App\Controllers\InscriptionController;
use App\Controllers\ConnexionController;
use App\Controllers\TimbreController;


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

// Formulaire d'ajout
Route::get('/ajouter', 'TimbreController@create');
// Traitement du POST
Route::post('/ajouter', 'TimbreController@store');

//Route pour le detail d'un timbre
Route::get('/detail', 'TimbreController@show');
Route::post('/detail', 'TimbreControllew@store');

//Route pour le catalogue d'enchères
Route::get('/catalogue', 'CatalogueController@index');

//Route pour le detail d'une enchère
Route::get('/enchere', 'CatalogueController@show');





Route::dispatch();
?>