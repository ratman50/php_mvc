<?php
class AuthController extends BaseController
{
    
    public function login()
    {
        if (Util::isLoggedIn()) {
            header("Location: /home");
            exit();
        }
        if ($_SERVER["REQUEST_METHOD"]="POST" 
        && Util::isFielSet($_POST,["numero","password"])
        && Util::isFieldEmpty($_POST)
        ) {
            var_dump($_POST);
            $res=$this->search("USERS",["num_user","password_user"],[$_POST['numero'], $_POST['password']]);
            if(!empty($res))
            {
                $_SESSION["telephone"] = $res[0]["num_user"];
                $_SESSION["user_name"]=$res[0]["name_user"];
                $annee=$this->search("ANNEE_SCOLAIRE",["etat"], [1]);
                header("Location: /niveau");
                exit();
            }
            $notification="identifiant non valide";
        }
        require_once __DIR__."/../views/login.php";
    }
    public function logout()
    {
        // Détruire la session de l'utilisateur
        session_destroy();
        
        // Rediriger vers la page d'accueil
        header('Location: /home');
        exit();
    }
    
}