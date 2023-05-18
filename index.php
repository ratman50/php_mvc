<?php
// index.php

// Point d'entrée unique de l'application

// Inclusion des fichiers nécessaires
require_once 'controllers/AuthController.php';
require_once 'controllers/HomeController.php';
require_once 'routers/RouteConnect.php';

$route = new RouteConnect();
$route->route();
