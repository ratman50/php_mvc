<?php

class EleveController extends BaseController
{
    public function liste($id="")
    {
        $query = "SELECT * FROM INSCRIPTION INNER JOIN ELEVES ON ELEVES.id_eleve=INSCRIPTION.eleve INNER JOIN NIVEAU ON NIVEAU.id_niveau=INSCRIPTION.niveau INNER JOIN CLASSES ON CLASSES.id_classe=INSCRIPTION.classe";
        $params=[];
        $classe="";
        $id_classe="";
        if (!empty($id)) {
            $query=$query." WHERE INSCRIPTION.classe= :classe ";            
            $params=[
                    ":classe"=>intval( $id),
            ];
            $this->model->requete("SELECT * FROM CLASSES WHERE id_classe=$id");
            $res=$this->model->getResultat();
            $classe=$res[0]["nom_classe"];
            $id_classe=$res[0]["id_classe"];
        }
        $this->model->requete($query, $params);
        $data=$this->model->getResultat();
        require_once __DIR__."/../views/eleves.php";
    }
    public function form()
    {
        $query="SELECT id_niveau, libelle_niveau FROM NIVEAU LEFT JOIN CLASSES ON NIVEAU.id_niveau=CLASSES.groupe_niveau WHERE CLASSES.groupe_niveau is not null GROUP BY libelle_niveau;
        ";
        $this->model->requete($query);
        $niveau=$this->model->getResultat();
        require_once __DIR__."/../views/form_eleve.php";

    }
    public function prepareRequete($data, &$query1,&$query2, &$params1, &$params2)
    {
        $tabEvit=["classe","niveau"];
        $query1="INSERT INTO ELEVES ( ";
        $query2="INSERT INTO INSCRIPTION ( ";
        foreach ($data as $key => $value) {
             if(in_array($key, $tabEvit))
             {
                 $query2=$query2.$key.',';
                 $params2[":".$key]=$value;

             }
             else{
                 $query1=$query1.$key.',';
                 $params1[":".$key]=$value;

             }
             // $params[":".$key]=$value;
        }
        if(!empty($data->numero))
        {
            $query1=$query1."type,";
            $params1[':type']="interne";
        }
        $query1=substr($query1,0,strlen($query1)-1).") VALUES (";
        foreach ($data as $key => $value) {
            if(!in_array($key, $tabEvit))
            {
                $query1=$query1.":".$key.',';
            }
        }
        if(!empty($data->numero))
        {
            $query1=$query1.":type,";
        }
        $query1=substr($query1,0,strlen($query1)-1).")";


    }
    public function ajoutEleve()
    {
        $requestMethod=$_SERVER["REQUEST_METHOD"];
        // echo "entree";
        $tabRequire=[];
        // echo(json_encode($requestMethod));
        if($requestMethod=="POST")
        {
           $data=$this->receiveData();
        //    echo json_encode($data);
           $params1=[];
           $params2=[];
           $query1="";
           $query2="";
           $this->prepareRequete($data,$query1, $query2,$params1, $params2);
            //    AJOUT DE L'ELEVE
           $this->model->requete($query1,$params1);
            $query2=substr($query2,0,strlen($query2)-1).",eleve,annee) VALUES (";
            $query2=$query2.":niveau,:classe,:eleve,:annee)";

            // RECUPERATION DU DERNIER ELEVE ENREGISTRE
            $this->model->requete("SELECT * FROM ELEVES WHERE id_eleve= LAST_INSERT_ID()");
            $resultat=$this->model->getResultat()[0];
            $params2[":eleve"]=$resultat['id_eleve'];
            
            //RECUPERATION DE L'ANNEE EN COURS
            $this->model->requete("SELECT * FROM ANNEE_SCOLAIRE WHERE etat=1");
            $resultat=$this->model->getResultat()[0];

            // AJOUT INSCRIPTION
            $params2[":annee"]=$resultat['id'];
            $this->model->requete($query2,$params2);
            echo json_encode($this->model->getRowsAffected());

        }
        // header('Location:/listerClasse');

    }
    public function searchEleveByNum()
    {
        $requestMethod=$_SERVER["REQUEST_METHOD"];
        $uri=$this->getQueryStringParams();

        if($requestMethod=="GET" && isset($uri["id"]) && !empty($uri["id"]))
        {
            $id=$uri["id"];
            $query="SELECT numero  FROM ELEVES WHERE numero =:id;";
            $params=[
                ":id"=>$id,
            ];
            $this->model->requete($query, $params);
            $row=$this->model->getRowsAffected();
            echo json_encode(
                [
                    "data"=>$row>0 ? false : true,
                    "message"=>"SUCCESS",
                    "status"=>"200"
                ]

            );

        }

    }
    public function index()
    {
        $query="SELECT * FROM INSCRIPTION INNER JOIN ELEVES ON ELEVES.id_eleve=INSCRIPTION.eleve INNER JOIN NIVEAU ON NIVEAU.id_niveau=INSCRIPTION.niveau INNER JOIN CLASSES ON CLASSES.id_classe=INSCRIPTION.classe;
        ";
        $this->model->requete($query);
        $data=$this->model->getResultat();
        require_once __DIR__."/../views/eleves.php";
    }
}