<?php

class NiveauController extends BaseController
{
    private $niveau;
    public function __construct()
    {
        parent::__construct();
        $this->model->requete("SELECT * FROM NIVEAU");  
        $this->niveau=$this->model->getResultat();
    }
    public function index()
    {
        $query="
        SELECT NIVEAU.id_niveau, NIVEAU.libelle_niveau , GROUP_CONCAT(CLASSES.nom_classe,\"@\", CLASSES.id_classe) as CLASSES FROM NIVEAU INNER JOIN CLASSES ON CLASSES.groupe_niveau=NIVEAU.id_niveau GROUP BY NIVEAU.id_niveau;
        ";
        $this->model->requete($query);
        $data=$this->model->getResultat();
        Util::orderClasse($data);
        require_once __DIR__."/../views/niveaux.php";
   
    }
    public function list($id="")
    {
        if(empty($id))
        {
            $this->index();
            exit();
        }
        $query="
        SELECT NIVEAU.id_niveau, NIVEAU.libelle_niveau , GROUP_CONCAT(CLASSES.nom_classe,\"@\", CLASSES.id_classe) as CLASSES 
        FROM NIVEAU INNER JOIN CLASSES ON CLASSES.groupe_niveau=NIVEAU.id_niveau 
        WHERE NIVEAU.id_niveau=$id
        GROUP BY NIVEAU.id_niveau;
        ";
        $this->model->requete($query);
        $data=$this->model->getResultat();
        Util::orderClasse($data);
        require_once __DIR__."/../views/niveaux.php";
    }
    public function rechercherNiveau($name)
    {
        $query="SELECT * FROM NIVEAU WHERE libelle_niveau LIKE :name";
        $this->model->requete($query, [":name"=>$name])[0];
        return !empty($this->model->getResultat()) ;
    }
    public function ajout()
    {
        $requestMethod=$_SERVER["REQUEST_METHOD"];
        // echo "entree";
        if($requestMethod=="POST" && isset($_POST["niveau"]) && !empty($_POST["niveau"]))
        {
            $niveau=strtolower($_POST['niveau']);
            if(!$this->rechercherNiveau($niveau))
            {
                $params=[
                    ":libelle"=>$niveau
                ];
                $query="INSERT INTO NIVEAU (libelle_niveau) VALUES (:libelle)";
                $this->model->requete($query, $params);
                $this->notification="Niveau ajouté avec succès";
            }else
            $this->notification="Niveau deja ajouté";
        }
        else 
            $this->notification="Champs vide pas acceptée";
        $_SESSION["notification"]=$this->notification;
        var_dump($_SESSION['notification']);
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