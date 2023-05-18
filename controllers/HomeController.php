<?php
class HomeController
{
    public function index()
    {
        if (!$this->isLoggedIn()) {
            header('Location: index.php?route=login');
            exit();
        }
        echo "Bienvenue sur la page d'accueil";
    }
    private function isLoggedIn()
    {
        echo " hello";
        return isset($_SESSION["username"]);
    }
}
