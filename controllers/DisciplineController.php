<?php
class DisciplineController extends BaseController
{
    public function gestion($id="")
    {
        $query="
        SELECT  * FROM NIVEAU 
        ";
        $this->model->requete($query);
        $niveau=$this->model->getResultat();
        $classes='';
        $groupes="";
        $ligne_classe="";
        if (!empty($id)) {
            $classe=intval($id);
            $query="
            SELECT * FROM CLASSES 
            INNER JOIN NIVEAU ON CLASSES.groupe_niveau=NIVEAU.id_niveau 
            WHERE CLASSES.id_classe=$id;
            ";
            $this->model->requete($query);
            $ligne_classe=$this->model->getResultat();
            $query="
                SELECT *  FROM CLASSES
            ";
            $this->model->requete($query);
            $classes=$this->model->getResultat();
            $niv=$ligne_classe[0]['id_niveau'];
            $query="
            SELECT GROUPE_DISCIPLINES.id_groupe, GROUPE_DISCIPLINES.nom_groupe 
            FROM INFO_GROUPE 
            INNER JOIN DISCIPLINES ON DISCIPLINES.id_discipline=INFO_GROUPE.discipline 
            INNER JOIN GROUPE_DISCIPLINES ON GROUPE_DISCIPLINES.id_groupe=DISCIPLINES.id_groupe  
            WHERE INFO_GROUPE.niveau= $niv
            GROUP BY GROUPE_DISCIPLINES.id_groupe
            ";
            $this->model->requete($query);
            $groupes=$this->model->getResultat();
        }
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
            if(isset($split[0]) && intval($split[0])>0)
            {
                $query=$query." AND INFO_GROUPE.classe = :id0";
                $params[":id0"]=intval($split[0]);
            }
            if(isset($split[1]) && intval($split[1])>0)
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
                    $groupe=$res[0]["id_groupe"];
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
            $disc=$data->discipline;
            
            $ligneDiscipline=$this->search("DISCIPLINES",["desc_discipline"],[$disc]);
            $id_discipline=$ligneDiscipline[0]["id_discipline"];
            if(!empty($ligneDiscipline))
            {
                
                if($ligneDiscipline[0]["id_groupe"] && $ligneDiscipline[0]["id_groupe"]!=$groupe )
                {
                    $nameGroupe=$this->search("GROUPE_DISCIPLINES", ["id_groupe"], [$ligneDiscipline[0]["id_groupe"]])[0]["nom_groupe"];
                    http_response_code(400);

                    echo json_encode(
                        [
                            "data"=>[],
                            "message"=>"$disc existe déjà dans le groupe $nameGroupe".$ligneDiscipline[0]["id_groupe"],
                            "status"=>"400",
                           
                        ]
                    );
                    die();
                }
                $res=$this->search("INFO_GROUPE",["classe","discipline","annee"],
                array_map("intval",[$data->classe,$ligneDiscipline[0]["id_discipline"],$anneeId]));

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
                    $resp=$this->insert("DISCIPLINES",[$code, mb_strtoupper($disc), $groupe], ["code_discipline", "desc_discipline", "id_groupe"]);
                }else
                    $resp=$this->insert("DISCIPLINES",[$code, mb_strtoupper($disc)], ["code_discipline", "desc_discipline"]);

                $id_discipline=$this->lastInsert("DISCIPLINES","id_discipline");
            }
            $this->insert("INFO_GROUPE",
                [$data->classe,$id_discipline, $data->niveau,$anneeId],
                ["classe","discipline","niveau","annee"]
            );
            $id_info_groupe=$this->lastInsert("INFO_GROUPE","id_info");
            $type_note=$this->search("TYPES_NOTE", ["niveau"], [$data->niveau]);
            foreach ($type_note as  $value) {
                $default=$value["defaut"];
                $id_type=$value["id_type"];
                $this->insert("MAX_NOTES",[$id_info_groupe,$id_type,$default],["discipline", "type_note", "max_note"]);
            }
            echo json_encode([
                "data"=>[$type_note],
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
            foreach ($data as  $value) 
            {
                $this->update("INFO_GROUPE", $update, ["nameCol"=>"id_info", "valCol"=>$value]);
            }
            echo json_encode([
                "data"=>[true],
                "message"=>"discipline  retirée avec succès",
                "status"=>"200"
            ]);       
        }
    }
    public function load_id_discipline($params)
    {
        if(isset($params) && !empty($params))
        {
            $split=explode("&",$params);
            if (!empty($split)) {
                $response=$this->search("MAX_NOTES", ["discipline", "type_note"], [$split[0], $split[1]]);
                echo json_encode($response[0]);
            }

        }
    }

    public function load_valMax_eval($classe)
    {
        $query="
        SELECT INFO_GROUPE.id_info,DISCIPLINES.desc_discipline, GROUP_CONCAT(TYPES_NOTE.type,':', MAX_NOTES.max_note) AS TYPES_NOTES
        FROM INFO_GROUPE INNER JOIN DISCIPLINES ON INFO_GROUPE.discipline=DISCIPLINES.id_discipline 
        INNER JOIN MAX_NOTES ON MAX_NOTES.discipline=INFO_GROUPE.id_info  INNER JOIN TYPES_NOTE ON TYPES_NOTE.id_type=MAX_NOTES.type_note
        WHERE  INFO_GROUPE.etat=1 AND INFO_GROUPE.classe=$classe group by INFO_GROUPE.id_info ;
        ";
        $this->model->requete($query);
        $result=$this->model->getResultat();
        $header=[]; 
        $data=[];
        $tmp=explode(",",$result[0]["TYPES_NOTES"]);
        foreach ($tmp as $value) {
            $name=explode(':',$value);
            $header[]=$name[0];
        };
        foreach ($result as $value) {
            $da=[
                "id_info"=>$value["id_info"],
                "desc_discipline"=>$value["desc_discipline"],
                // "notes_max"=
            ];
            $tmp=explode(',',$value["TYPES_NOTES"]);
            $ac=[];
            foreach ($tmp as  $value) {
                $spli=explode(":",$value);
                $ac[$spli[0]]=$spli[1];
            }
            $da["notes_max"]=$ac;
            $data[]=$da;
        }
        echo json_encode(
            [
                "header"=>$header,
                "data"=>$data
            ]
        );
    }



}