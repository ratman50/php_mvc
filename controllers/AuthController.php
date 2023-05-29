<?php
class AuthController
{
    private $model;
    // public function __construct()
    // {
    // }
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
            $query="SELECT * FROM USERS WHERE num_user = :num AND  password_user= :pass";
            $info=[
                ":num"=>$_POST['numero'],
                ":pass"=>$_POST['password']
            ];
            var_dump($info);
            $model=new BaseModel();
            $model->requete($query, $info);
            if($model->getRowsAffected()==1)
            {
                $_SESSION["telephone"] = $info[":num"];
                header("Location: /home");
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
        header('Location: index.php');
        exit();
    }
    
}