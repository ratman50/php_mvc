<?php
class HomeController extends BaseController
{
    public function index()
    {
        if (!Util::isLoggedIn()) {
            header('Location:/login');
            exit();
        }
        $telephone=$_SESSION["telephone"];
        $query="SELECT * FROM USERS WHERE num_user=:telephone";
        $model=new BaseModel( );
        $model->requete($query, [':telephone'=>$telephone]);
        $data=$model->getResultat();
        $_SESSION["user_name"]=$data[0]["name_user"];
        require_once __DIR__."/../views/home.php";
    }
}