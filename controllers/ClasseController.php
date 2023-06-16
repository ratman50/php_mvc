<?php 
class ClasseController extends BaseController
{
    
    public function ajout()
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
    public function coeff($id)
    {
        $classe=$this->search("CLASSES",["id_classe"], [$id])[0];
       
        require_once __DIR__."/../views/coefficient.php";

        
    }
    public function discipline($id)
    {
        $query="
        SELECT INFO_GROUPE.id_info, INFO_GROUPE.ressource,INFO_GROUPE.composition,DISCIPLINES.code_discipline, DISCIPLINES.desc_discipline
        FROM INFO_GROUPE INNER JOIN DISCIPLINES ON INFO_GROUPE.discipline=DISCIPLINES.id_discipline 
        WHERE INFO_GROUPE.classe=$id AND INFO_GROUPE.etat=1;
        ";
        $this->model->requete($query);
        echo json_encode([
            "data"=>$this->model->getResultat(),
            "message"=>"les disciplines",
            "status"=>"200"
        ]);
    }
    public function list($id="")
    {
        $query="
        SELECT * FROM `CLASSES`
        ";
        $params=[];
        if(!empty($id))
        {
            $query=$query." WHERE groupe_niveau=:id";
            $params=[
                ":id"=>$id,
            ];
        }
        $this->model->requete($query, $params);
        $data=$this->model->getResultat();
        echo json_encode(
            [
                "data"=>$data,
                "message"=>"SUCCESS",
                "status"=>"200"
            ]
        );
           
    }

    public function maxval()
    {
        $data=$this->receiveData();
       
        foreach ($data as  $value) {
            $name_eval=$value->name;
            $id_name_eval=$this->search("TYPES_NOTE",["type"],[$name_eval])[0]["id_type"];
            $id_max_note=$this->search("MAX_NOTES",["discipline","type_note"],[$value->discipline, $id_name_eval])[0];
            $update=[
                "nameCol"=>"max_note",
                "valCol"=>$value->value
            ];
            $this->update("MAX_NOTES", $update, ["nameCol"=>"id_max_note","valCol"=>$id_max_note["id_max_note"]]);
           

            
        }
        echo json_encode(
            [
                "message"=>"note(s) maximale(s) mise à jour"
            ]
            );
        // echo json_encode($data->updates);
    }

    public function type_eval($niveau)
    {
        $resultat=$this->search("TYPES_NOTE",["niveau"],[$niveau]);
        echo json_encode($resultat);
    }
    
}