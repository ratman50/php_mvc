<?php 
class ClasseController
{
    public function ajouterClasse()
    {
        $requestMethod=$_SERVER["REQUEST_METHOD"];
        // echo "entree";
        if($requestMethod=="POST" && 
            Util::isFielSet($_POST, ["id", "classe"])
            && Util::isFieldEmpty($_POST)
        )
        {
            $classe=$_POST['classe'];
            $id=$_POST['id'];
            $params=[
                ":classe"=>$classe,
                ":id"=>$id
            ];
            $query="INSERT INTO CLASSES(nom_classe, idNiveau) VALUES (:classe, :id)";
            $model= new BaseModel($query,$params);
            $model->requete();
        }
        header('Location:/niveau');

    }
}