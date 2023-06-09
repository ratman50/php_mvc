<?php
class DisciplineController extends BaseController
{
    public function gestion()
    {
        $query="
        SELECT  * FROM NIVEAU 
        ";

        $this->model->requete($query);
        $niveau=$this->model->getResultat();
        require_once "views/discipline.php";
    }
   
    public function group($id="")
    {
        $query="
        SELECT GROUPE_DISCIPLINES.id_groupe, GROUPE_DISCIPLINES.nom_groupe FROM INFO_GROUPE INNER JOIN DISCIPLINES ON DISCIPLINES.id_discipline=INFO_GROUPE.discipline INNER JOIN GROUPE_DISCIPLINES ON GROUPE_DISCIPLINES.id_groupe=DISCIPLINES.id_groupe  
        ";
        $params=[];
        if(!empty($id))
        {
            $query=$query." WHERE INFO_GROUPE.niveau= :id";
            $params=[
                ":id"=>$id,
            ];
        }
        $this->model->requete($query." GROUP BY GROUPE_DISCIPLINES.id_groupe", $params);
        echo json_encode(
            [
                "data"=>$this->model->getResultat(),
                "message"=>"SUCCESS",
                "status"=>"200"
            ]
        );

    }
    public function classe($id="")
    {
        
        $query="
        SELECT INFO_GROUPE.id_info,DISCIPLINES.code_discipline, DISCIPLINES.desc_discipline FROM INFO_GROUPE 
        INNER JOIN DISCIPLINES ON DISCIPLINES.id_discipline=INFO_GROUPE.discipline 
        LEFT JOIN GROUPE_DISCIPLINES ON GROUPE_DISCIPLINES.id_groupe=DISCIPLINES.id_groupe WHERE INFO_GROUPE.etat=1
        ";
        $params=[];
        
        if(!empty($id))
        {
            $split=explode("&",$id);
            if(isset($split[0]) && intval($split[0]))
            {
                $query=$query." AND INFO_GROUPE.classe = :id0";
                $params[":id0"]=intval($split[0]);
            }
            if(isset($split[1]) && intval($split[1]))
            {
                $query=$query." AND DISCIPLINES.id_groupe = :id1";
                $params[":id1"]=intval($split[1]);
            }
            if(in_array("null", $split))
            {
                $query.=" AND DISCIPLINES.id_groupe is NULL";
            }

        }
        $this->model->requete($query, $params);
        echo json_encode(
            [
                "data"=>$this->model->getResultat(),
                "message"=>"SUCCESS",
                "status"=>"200"
            ]
        );

    }
   
    public function ajout()
    {
        $request_method=$_SERVER["REQUEST_METHOD"];
        if ($request_method=="POST") {
            $data=$this->receiveData();
          
            $groupe=$data->groupe;
            //verifier si le groupe est à ajouter ou pas 
            if (!ctype_digit($data->groupe) && $groupe!=="null") {
                $res=$this->search("GROUPE_DISCIPLINES",["nom_groupe"],[strtolower($groupe)]);
                if(empty($res))
                {
                    $this->insert("GROUPE_DISCIPLINES", [$groupe], ["nom_groupe"] );
                    $groupe=$this->lastInsert("GROUPE_DISCIPLINES","id_groupe");
                }
                else
                {

                    http_response_code(400);
                    echo json_encode(
                        [
                            "data"=>[],
                            "message"=>"le groupe ".$res[0]["nom_groupe"]." existe déjà",
                            "status"=>"400",
                        ]
                    );
                    die();
                }
            }
            
            $annee=$this->search("ANNEE_SCOLAIRE",["etat"],[1]);

            if (empty($annee)) {
                
                http_response_code(400);
                echo json_encode(
                    [
                        "data"=>[],
                        "message"=>"Aucune année n'a été sélectionné",
                        "status"=>"400",
                    ]
                );
                die();
            }
            $anneeId=$annee[0]["id"];
            $disc=strtoupper($data->discipline);
            
            $ligneDiscipline=$this->search("DISCIPLINES",["desc_discipline"],[$disc]);
            $id_discipline=$ligneDiscipline[0]["id_discipline"];
            if(!empty($ligneDiscipline))
            {
                if($ligneDiscipline[0]["id_groupe"]!==$groupe && $groupe!=="null")
                {
                    $nameGroupe=$this->search("GROUPE_DISCIPLINES", ["id_groupe"], [$ligneDiscipline[0]["id_groupe"]])[0]["nom_groupe"];
                    http_response_code(400);

                    echo json_encode(
                        [
                            "data"=>[],
                            "message"=>"$disc existe déjà dans le groupe $nameGroupe",
                            "status"=>"400"
                        ]
                    );
                    die();
                }
                $res=$this->search("INFO_GROUPE",["classe","discipline","annee"],
                array_map("intval",[$data->classe,$ligneDiscipline[0]["id_discipline"],$anneeId]));
                // echo json_encode($res);
                // die();
                if(!empty($res))
                {
                    if($res[0]["etat"])
                    {

                        $nameClasse=$this->search("CLASSES",["id_classe"], [$data->classe])[0]["nom_classe"];
                        $valAnnee=$annee[0]["name_scol"];
                        $nameDiscipline=$ligneDiscipline[0]["desc_discipline"];
                        http_response_code(400);
    
                        echo json_encode(
                            [
                                "data"=>[],
                                "message"=>"la classe ".$nameClasse." a déjà la discipline ".$nameDiscipline." pour l'année scolaire ".$valAnnee,
                                "status"=>"400"
                            ]
                        );
                        die();
                    }
                    $this->update("INFO_GROUPE",[
                        "nameCol"=>"etat",
                        "valCol"=>"1"
                    ], ["nameCol"=>"id_info", "valCol"=>$res[0]["id_info"]]);
                    echo json_encode([
                        "data"=>[true],
                        "message"=>"discipline  mise  à jour avec succès",
                        "status"=>"200"
                    ]);     
                    die();

                }
            }else{

                $code=$this->generateCode($disc);
                if ($groupe!=="null") {
                    $resp=$this->insert("DISCIPLINES",[$code, $disc, $groupe], ["code_discipline", "desc_discipline", "id_groupe"]);
                }else
                    $resp=$this->insert("DISCIPLINES",[$code, $disc], ["code_discipline", "desc_discipline"]);

                $id_discipline=$this->lastInsert("DISCIPLINES","id_discipline");
            }
            $this->insert("INFO_GROUPE",
                [$data->classe,$id_discipline, $data->niveau,$anneeId],
                ["classe","discipline","niveau","annee"]
            );
            echo json_encode([
                "data"=>[true],
                "message"=>"discipline ajoutée avec succès",
                "status"=>"200"
            ]);
            
        }
    }
    public function set()
    {
        $request_method=$_SERVER["REQUEST_METHOD"];
       
        if($request_method=="POST")
        {
            $data=$this->receiveData();
            $update=[
                "nameCol"=>"etat",
                "valCol"=>"0"
            ];
            foreach ($data->unchecked as  $value) 
            {
                $this->update("INFO_GROUPE", $update, ["nameCol"=>"id_info", "valCol"=>$value]);
            }
            echo json_encode([
                "data"=>[true],
                "message"=>"discipline  mise  à jour avec succès",
                "status"=>"200"
            ]);        }
    }
}