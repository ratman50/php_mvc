<?php
// index.php

// Point d'entrée unique de l'application


require_once "routers/Route.php";
// if(array_key_exists($path, $Controllers))
// {
//     $controller=explode("@",$Controllers[$path]);
//     $control=$controller[0];
//     $useCase=$controller[1];
//     try {
//         $route= new Route($control, $useCase);
//         $route->route();
//     } catch (Exception $e) {    
//         //throw $th;
//         echo $e->getMessage();
//     }
//     exit();
// }

// $route= new Route("HomeController","index");
// $route->route();
route();