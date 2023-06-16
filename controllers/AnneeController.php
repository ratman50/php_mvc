<?php 
class AnneeController extends BaseController
{
   
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
            $this->model= new BaseModel();
            $this->model->requete($query, $params);
        }
        header('Location:/annee');

    }
    public function index()
    {
        // $query="SELECT * FROM ANNEE_SCOLAIRE ORDER BY name_scol DESC;";
        // $this->model->requete($query);
        // $data=$this->model->getResultat();
        
        require_once __DIR__."/../views/Annee_scolaire.php";
    }
    public function list()
    {
        $query="
        SELECT * FROM ANNEE_SCOLAIRE  ORDER BY name_scol DESC
        ";
        $this->model->requete($query);
        $data=$this->model->getResultat();
        echo json_encode([
            "annees"=>$this->model->getResultat(),
            "cours"=>$this->search("ANNEE_SCOLAIRE",["etat"],[1])[0]
        ]);
    }
    public function set($id)
    {
        $annee=$this->search("ANNEE_SCOLAIRE", ["id"],[$id]);
        if(empty($annee))
        {
            http_response_code(400);
            echo json_encode(
                [
                    "data"=>[],
                    "message"=>"Année non existante",
                    "status"=>"400",
                ]
            );
            die();   
        } 
        $actif=$this->search("ANNEE_SCOLAIRE",["etat"],['1']);
        if(!empty($actif))
        {
            $id_actif=$actif[0]["id"];
            $this->update("ANNEE_SCOLAIRE",["nameCol"=>"etat","valCol"=>"0"],["nameCol"=>"id","valCol"=>$id_actif]);
            if($id_actif==$annee[0]['id'])
            {

                echo json_encode([
                    "message"=>"Aucune année n'est activée"
                ]);  
                die();
            }
        }
        $annee=$annee[0];
        $etat=$annee["etat"] ? 0 : 1;
        $this->update("ANNEE_SCOLAIRE",["nameCol"=>"etat","valCol"=>$etat],["nameCol"=>"id","valCol"=>$annee["id"]]);

        echo json_encode([
            "message"=>"Annee mise a jour"
        ]);  

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
    public function add()
    {
        $data=$this->receiveData();
        
        $requestMethod=$_SERVER["REQUEST_METHOD"];
        $tabNotificattion=[
            "Erreur:format non respecter XXXX-YYYY avec X, Y numerique",
            "Erreur: Le pas entre année doit etre de 1 année",
            "Année Valide"
        ];
        if($requestMethod=="POST" && !empty($data))
        {
            $annee=$data[0];
            
            $valChecking=Util::checkAnnee($annee);
          
            $notification=$tabNotificattion[$valChecking];
            if($valChecking==2 )
            {
                $query="SELECT *  FROM ANNEE_SCOLAIRE WHERE name_scol LIKE '%$annee%' ";
                
                $this->model->requete($query);
                if($this->model->getRowsAffected()==0)
                {
                    $query="INSERT INTO ANNEE_SCOLAIRE (name_scol) VALUES ($annee)";
                    $this->model->requete($query);
                    $notification="Année scolaire enregistree";
                }else
                $notification="Année déja existante";
            }
        }
        echo json_encode(
            $notification
        );

    }
}