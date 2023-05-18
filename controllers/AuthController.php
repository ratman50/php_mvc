<?php
class AuthController
{
    private $field="";
    private $password="";
    public function __construct()
    {
        if ($_SERVER["REQUEST_METHOD"]=="POST") {
            $this->field=$_POST["field"];
            $this->password=$_POST["password"];
        }
        
    }
    public function login()
    {
        if ($this->isLoggedIn()) {
            header("Location: index.php");
            exit();
        }
        var_dump($_SERVER["REQUEST_METHOD"]);
  // Vérifier si le formulaire de connexion est soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérer les données du formulaire
            $field = $_POST['username'];
            $password = $_POST['password'];
            echo "\n",$field;
            echo "\n",$password;
            exit();
            // Effectuer la validation des informations d'identification
            // if ($this->validate($username, $password)) {
            //     // Créer une session pour l'utilisateur
            //     $_SESSION['username'] = $username;
                
            //     // Rediriger vers la page d'accueil
            //     header('Location: index.php');
            //     exit();
            // } else {
            //     // Afficher un message d'erreur
            //     echo 'Identifiants invalides.';
            // }
        }        //   Afficher le formulaire de connexion
         require_once __DIR__."/../views/connexion.php";
    }
    public function logout()
    {
        // Détruire la session de l'utilisateur
        session_destroy();
        
        // Rediriger vers la page d'accueil
        header('Location: index.php');
        exit();
    }
    private function isLoggedIn()
    {
        // Vérifier si l'utilisateur est authentifié
        return isset($_SESSION["username"]);
    }
    private function validate($field, $password) {
        echo"\n",$field;
        echo"\n",$password;
        return false;
    }
    
}
