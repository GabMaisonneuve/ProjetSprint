<?php
use App\Routes\Route;
use App\Controllers\AccueilController;

// Route pour la page d'accueil
Route::get('', 'AccueilController@index');

// Route pour test connexion
Route::get('accueil', 'TestController@connexion');



Route::dispatch();
?>