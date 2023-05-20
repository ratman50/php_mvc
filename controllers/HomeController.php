<?php
class HomeController
{
    public function index()
    {
        if (!$this->isLoggedIn()) {
            header('Location: index.php/login');
            exit();
        }
        $user_name="MOUSSA FALL";
        require_once __DIR__."/../views/index.php";
    }
    private function isLoggedIn()
    {
        return isset($_SESSION["telephone"])  ;
    }
}