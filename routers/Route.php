<?php
require_once "models/BaseModel.php";
require_once "controllers/Util.php";
require_once "inc/config.php";
require_once "controllers/BaseController.php";
require_once "controllers/HomeController.php";
session_start();

function route()
{
    $url=$_SERVER["REQUEST_URI"];
    $url=strtolower($url);
    $path=parse_url($url, PHP_URL_PATH);
    $split=explode('/',substr($path, 1));
    $pathController="controllers/".ucfirst($split[0])."Controller.php";
    if (file_exists($pathController)) {
        require_once $pathController;
        $controllerName=ucfirst($split[0])."Controller";
        $control= new $controllerName();
        if(!method_exists($control, $split[1]))
        {
            $control->index();
        }
        else
            isset($split[2]) ? $control->{$split[1]}($split[2]) :$control->{$split[1]}()  ;
        exit();
    }
    $control= new HomeController();
    $control->index();
    

}

