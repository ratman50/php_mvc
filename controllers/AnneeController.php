<?php 
class AnneeController
{
    private $model;
    public function __construct()
    {
        $this->model=new BaseModel(); 
    }
    public function supprimerAnnee()
    {
        echo "bn";
        $requestMethod=$_SERVER["REQUEST_METHOD"];
        // echo "entree";
        if($requestMethod=="GET" && isset($_GET["id"]) && !empty($_GET["id"]))
        {
            $id=$_GET['id'];
            $params=[
                ":id_annee"=>$id
            ];
            var_dump($params);
            $query="DELETE FROM  ANNEE_SCOLAIRE  WHERE id = :id_annee ";
            $model= new BaseModel();
            $model->requete($query, $params);
        }
        header('Location:/annee');

    }
    public function index()
    {
        $query="SELECT * FROM ANNEE_SCOLAIRE ORDER BY name_scol DESC;";
        $this->model->requete($query);
        $data=$this->model->getResultat();
        require_once __DIR__."/../views/Annee_scolaire.php";
    }
    public function desactiverAnnee()
    {
        
        $requestMethod=$_SERVER["REQUEST_METHOD"];
        // echo "entree";
        if($requestMethod=="GET" && isset($_GET["id"]) && !empty($_GET["id"]))
        {
            $id=$_GET['id'];
            $params=[
                ":id_annee"=>$id   
            ];
            $query="UPDATE ANNEE_SCOLAIRE SET etat = 0 WHERE id = :id_annee ";
            $model= new BaseModel();
            $model->requete($query, $params);
        }
        header('Location:/annee');
    }
    public function activerAnnee()
    {
        
        $requestMethod=$_SERVER["REQUEST_METHOD"];
        if($requestMethod=="GET" && isset($_GET["id"]) && !empty($_GET["id"]))
        {
            $query="SELECT id FROM ANNEE_SCOLAIRE WHERE etat=1";
            $this->model->requete($query);
            $res=[];
            $res=$this->model->getResultat();
            if(!empty($res))
            {
                    $id=$res[0]["id"];
                    $param=[":id_annee"=>$id];
                    $query="UPDATE ANNEE_SCOLAIRE SET etat = 0 WHERE id = :id_annee ";
                    $this->model->requete($query,$param);

            }

            $id=$_GET['id'];
            $params=[
                ":id_annee"=>$id
            ];
            $query="UPDATE ANNEE_SCOLAIRE SET etat = 1 WHERE id = :id_annee ";
            $model= new BaseModel();
            $model->requete($query, $params);
            $query="SELECT * FROM ANNEE_SCOLAIRE WHERE etat=1";
            $this->model->requete($query);
            $res=[];
            $res=$this->model->getResultat();
            $_SESSION["annee"]=$res[0]["name_scol"];    
        }
        header('Location:/annee');   
    }
    public function modifierAnnee()
    {
        $requestMethod=$_SERVER["REQUEST_METHOD"];
        $tabNotificattion=[
            "Erreur:format non respecter XXXX-YYYY avec X, Y numerique",
            "Erreur: Le pas entre année doit etre de 1 année",
            "Année Valide"
        ];
        var_dump($_POST);
        var_dump(Util::isFielSet($_POST,['name_scol', 'id']));
        if($requestMethod=="POST" && Util::isFielSet($_POST,['name_scol', 'id'])
        && Util::isFieldEmpty($_POST))
        {
            echo "n";
            $name_scol=$_POST['name_scol'];
            $id_name=$_POST['id'];
            $query="SELECT *  FROM ANNEE_SCOLAIRE WHERE name_scol =:name_scol ";
            $params=[
                ":name_scol"=>$name_scol,
                ":id_name"=>$id_name,
            ];
            var_dump($params);
            $valChecking=Util::checkAnnee($name_scol);
            $notification=$tabNotificattion[$valChecking];
            if($valChecking==2 )
            {
                $this->model->requete($query, [":name_scol"=>$name_scol]);
                if($this->model->getRowsAffected()==0)
                {
                    $query="SELECT id FROM ANNEE_SCOLAIRE WHERE etat=1";
                    $this->model->requete($query);
                    $id=$this->model->getResultat();
                    $param=[":id_annee"=>$id[0]["id"]];
                    $query="UPDATE ANNEE_SCOLAIRE SET etat = 0 WHERE id = :id_annee ";
                    $this->model->requete($query,[":id_annee"=>$param[":id_name"]]);
                    $query="UPDATE ANNEE_SCOLAIRE SET name_scol= :name_scol WHERE id = :id_name";
                    $this->model->requete($query,$params);
                    $notification="Année scolaire enregistree";
                }
                $notification="Année déja existante";
            }
            echo "\n",$notification;
        }
        header('Location:/annee');

   
    }
    public function ajouterAnnee()
    {
        $requestMethod=$_SERVER["REQUEST_METHOD"];
        $tabNotificattion=[
            "Erreur:format non respecter XXXX-YYYY avec X, Y numerique",
            "Erreur: Le pas entre année doit etre de 1 année",
            "Année Valide"
        ];
        if($requestMethod=="POST" && isset($_POST["annee"]) && !empty($_POST["annee"]))
        {
            $annee=$_POST['annee'];
            $query="SELECT *  FROM ANNEE_SCOLAIRE WHERE name_scol =:annee ";
            $params=[
                ":annee"=>$annee
            ];
            $valChecking=Util::checkAnnee($annee);
            $notification=$tabNotificattion[$valChecking];
            if($valChecking==2 )
            {
                $this->model->requete($query, $params);
                if($this->model->getRowsAffected()==0)
                {
                    
                    $query="INSERT INTO ANNEE_SCOLAIRE (name_scol) VALUES (:annee)";
                    $this->model->requete($query,$params);
                    $notification="Année scolaire enregistree";
                }else
                $notification="Année déja existante";
            }
            $_SESSION['notification']=$notification;
        }
        header('Location:/annee');

    }
}