<?php
class HomeController
{
    public function index()
    {
        if (!Util::isLoggedIn()) {
            header('Location:/login');
            exit();
        }
        $user_name="MOUSSA FALL";
        require_once __DIR__."/../views/home.php";
    }
}