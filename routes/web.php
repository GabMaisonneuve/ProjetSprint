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


// Route pour le profil
Route::get('/profil', 'ProfilController@index');
Route::get('/profil/edit', 'ProfilController@editProfil');
Route::post('/profil/edit', 'ProfilController@updateProfil');



Route::dispatch();
?>