<?php
class AuthController
{
    private $numero="";
    private $password="";
    public function __construct()
    {
        if ($_SERVER["REQUEST_METHOD"]=="POST") {
            $this->numero=$_POST["numero"];
            $this->password=$_POST["password"];
        }
        
    }
    private function isNotFieldEmpty()
    {
        $fields=get_object_vars($this);
        foreach ($fields as $value) {
            if (empty($value)) {
                return false;
            }
        }
        return true;
    }
    public function login()
    {
        if ($this->isLoggedIn()) {
            header("Location: index.php");
            exit();
        }
        if ($this->isNotFieldEmpty() && $this->validate()) {
            $_SESSION["telephone"] = $this->numero;
            header("Location: index.php");
            exit();
        }
        $notification="identifiant non valide";
        require_once __DIR__."/../views/login.php";
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
        return isset($_SESSION["telephone"]);
    }
    private function validate()
    {
        $info=[
            ":num"=>$this->numero,
            ":pass"=>$this->password
        ];
        $model= new UserModel();
        return count($model->connect($info))>0;
    }
    
}