<?php 
class ClasseController extends BaseController
{
    
    public function ajouterClasse()
    {
        $requestMethod=$_SERVER["REQUEST_METHOD"];
        if($requestMethod=="POST" && 
            Util::isFielSet($_POST, ["id", "classe"])
            && Util::isFieldEmpty($_POST)
        )
        {
            $classe=$_POST['classe'];
            
            $id=$_POST['id'];
            $query="SELECT * FROM CLASSES WHERE nom_classe  LIKE :classe";
            $corres=$this->rechercher($query,[":classe"=>$classe]);
            if(empty($corres))
            {
                $query="INSERT INTO CLASSES(nom_classe, idNiveau) VALUES (:classe, :id)";
                $params=[
                    ":classe"=>strtoupper($classe),
                    ":id"=>$id
                ];
               
                $this->model->requete($query,$params);
                $this->notification="Classe ajoutée avec succès";
            }else
                $this->notification="Classe déja ajoutée";
        }
        $_SESSION["notification"]=$this->notification;
        header('Location:/niveau');

    }
    protected function getUriSegments()
    {
        $uri=parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
        $uri= explode('/', $uri);
        return $uri;
    }
    protected function getQueryStringParams()
    {
        $query=[];
        parse_str($_SERVER['QUERY_STRING'], $query);
        return $query;
    }
    public function listerClasse()
    {
        $requestMethod=$_SERVER["REQUEST_METHOD"];
        $uri=$this->getQueryStringParams();
        if($requestMethod=="GET" && isset($uri["id"]) && !empty($uri["id"]))
        {
            $id=$uri["id"];
            $query="SELECT id_classe, nom_classe FROM CLASSES WHERE idNiveau=:id;";
            $params=[
                ":id"=>$id,
            ];
            $this->model->requete($query, $params);
            echo json_encode(
                [
                    "data"=>$this->model->getResultat(),
                    "message"=>"SUCCESS",
                    "status"=>"200"
                ]
                
            );
           
        }
    }
}