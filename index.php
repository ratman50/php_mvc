<?php
// index.php

// Point d'entrée unique de l'application

// Inclusion des fichiers nécessaires
// require_once "vendor/autoload.php";
// use Routers\Route;
// use Inc\$Controllers;

require_once "inc/config.php";
require_once "controllers/BaseController.php";
require_once 'controllers/AuthController.php';
require_once 'controllers/HomeController.php';
require_once 'controllers/NiveauController.php';
require_once "routers/Route.php";
require_once "models/BaseModel.php";
require_once "controllers/Util.php";
require_once "controllers/ClasseController.php";
require_once "controllers/AnneeController.php";
require_once "controllers/EleveController.php";
session_start();
$url=$_SERVER["REQUEST_URI"];
$path=parse_url($url, PHP_URL_PATH);

if(array_key_exists($path, $Controllers))
{
    $controller=explode("@",$Controllers[$path]);
    $control=$controller[0];
    $useCase=$controller[1];
    try {
        $route= new Route($control, $useCase);
        $route->route();
    } catch (Exception $e) {    
        //throw $th;
        echo $e->getMessage();
    }
    exit();
}

$route= new Route("HomeController","index");
$route->route();
