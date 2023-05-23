<?php
class NiveauController
{
    
    public function niveau()
    {
        $query="SELECT idNiveau, libelle_niveau, GROUP_CONCAT(nom_classe) as CLASSES FROM `NIVEAU` LEFT JOIN CLASSES ON NIVEAU.id_niveau=CLASSES.idNiveau GROUP BY libelle_niveau;
        ";
        $model=new BaseModel();
        $model->requete($query);
        $data=$model->getResultat();
        require_once __DIR__."/../views/niveaux.php";
   
    }
    public function ajouterNiveau()
    {
        $requestMethod=$_SERVER["REQUEST_METHOD"];
        // echo "entree";
        if($requestMethod=="POST" && isset($_POST["niveau"]) && !empty($_POST["niveau"]))
        {
            $niveau=$_POST['niveau'];
            $params=[
                ":libelle"=>$niveau
            ];
            $query="INSERT INTO NIVEAU (libelle_niveau) VALUES (:libelle)";
            $model= new BaseModel();
            $model->requete($query);
        }
        header('Location:/niveau');
    }
    public function supprimerNiveau()
    {
        $requestMethod=$_SERVER["REQUEST_METHOD"];
        if($requestMethod=="GET" && isset($_GET["id"]) && !empty($_GET["id"]))
        {
            $id=$_GET['id'];
            $params=[
                ":id"=>$id
            ];
            $query="DELETE FROM NIVEAU WHERE id_niveau = :id";
            $model= new BaseModel();
            $model->requete($query,$params);
            header('Location:/niveau');
        }


    }
    public function modifierNiveau()
    {
        $requestMethod=$_SERVER["REQUEST_METHOD"];
        var_dump($_POST);
        if($requestMethod=="POST" &&
            Util::isFielSet($_POST, ["niveau", "id"])
            && Util::isFieldEmpty($_POST)
        )
        {
            $niveau=$_POST['niveau'];
            $id=$_POST['id'];
            $params=[
                ":niv"=>$niveau,
                ":id"=>$id
            ];
            $query="UPDATE NIVEAU SET libelle_niveau=:niv WHERE id_niveau = :id";
            $model= new BaseModel();
            $model->requete($query,$params);
            header('Location:/niveau');
        }


    }
}