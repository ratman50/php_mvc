<?php
define("DB_HOST", "localhost");
define("DB_USERNAME", "root");
define("DB_PASSWORD", "Password123#@!");
define("DB_DATABASE_NAME", "DAARA");


$Controllers=[
    "/login"=>"AuthController@login",
    "/logout"=>"AuthController@logout",
    "/niveau"=>"NiveauController@niveau",
    "/home"=>"HomeController@index",
    "/ajouterNiveau"=>"NiveauController@ajouterNiveau",
    "/supprimerNiveau"=>"NiveauController@supprimerNiveau",
    "/modifierNiveau"=>"NiveauController@modifierNiveau",
    "/ajouterClasse"=>"ClasseController@ajouterClasse",
    "/annee"=>"AnneeController@annee",
    "/ajouterAnnee"=>"AnneeController@ajouterAnnee"
];

define("CONTROLLERS", $Controllers);
