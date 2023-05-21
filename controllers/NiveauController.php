<?php
class NiveauController
{
    
    public function niveau()
    {
        // $model
        require_once __DIR__."/../views/niveaux.php";
   
    }
    public function ajouterNiveau()
    {
        $requestMethod=$_SERVER["REQUEST_METHOD"];
        if($requestMethod=="POST" && isset($_POST["niveau"]) && !empty($_POST["niveau"]))
        {
            $niveau=$_POST['niveau'];
            $params=[
                ":libelle"=>$niveau
            ];
            $query="INSERT INTO NIVEAU (libelle_niveau) VALUES (:libelle)";
            $model= new BaseModel($query,$params);
            $model->requete();
        }
    }
}