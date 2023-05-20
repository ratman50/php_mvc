<?php
// index.php

// Point d'entrée unique de l'application

// Inclusion des fichiers nécessaires
require_once "inc/config.php";
require_once 'controllers/AuthController.php';
require_once 'controllers/HomeController.php';
require_once 'controllers/NiveauController.php';
require_once 'routers/Route.php';
require_once "models/BaseModel.php";
require_once "models/UserModel.php";
session_start();
$url=$_SERVER["REQUEST_URI"];
$path=parse_url($url, PHP_URL_PATH);
// var_dump($path);

$path=explode("/",$path);
$Controllers=[
    "login"=>"AuthController@login",
    "logout"=>"AuthController@logout",
    "niveau"=>"NiveauController@niveau",
    "ajouterNiveau"=>"NiveauController@niveau"
];
if(array_key_exists($path[2], $Controllers))
{
    $element=$path[2];
    $control=$Controllers[$element];
    $control=explode("@",$control)[0];
    echo "<br>",$control;
    echo "<br>",$element;
    // $route= new Route($control, $element);
    // $route->route();
    exit();
}

$route= new Route("HomeController","index");
$route->route();
