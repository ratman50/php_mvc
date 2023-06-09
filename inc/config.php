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
    "/eleve"=>"EleveController@eleve",
    "/ajouterNiveau"=>"NiveauController@ajouterNiveau",
    "/supprimerNiveau"=>"NiveauController@supprimerNiveau",
    "/modifierNiveau"=>"NiveauController@modifierNiveau",
    "/ajouterClasse"=>"ClasseController@ajouterClasse",
    "/annee"=>"AnneeController@annee",
    "/ajouterAnnee"=>"AnneeController@ajouterAnnee",
    "/desactiverAnnee"=>"AnneeController@desactiverAnnee",
    "/activerAnnee"=>"AnneeController@activerAnnee",
    "/modifierAnnee"=>"AnneeController@modifierAnnee",
    "/supprimerAnnee"=>"AnneeController@supprimerAnnee",
    "/listerClasse"=>"ClasseController@listerClasse",
    "/searchEleveByNum"=>"EleveController@searchEleveByNum",
    "/ajouterEleve"=>"EleveController@ajoutEleve",
    "/form_eleve"=>"EleveController@form_eleve",
    "/rechercherByClass"=>"EleveController@rechercherByClass",
    "/gestion"=>"DisciplineController@gestion"
];

define("CONTROLLERS", $Controllers);
