<?php

class EleveController extends BaseController
{
    public function liste($id="")
    {
        $query = "
        SELECT * FROM INSCRIPTION 
        INNER JOIN ELEVES ON ELEVES.id_eleve=INSCRIPTION.eleve 
        INNER JOIN NIVEAU ON NIVEAU.id_niveau=INSCRIPTION.niveau 
        INNER JOIN CLASSES ON CLASSES.id_classe=INSCRIPTION.classe
        ";
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
    public function add()
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
    public function find($numero)
    {
        $requestMethod=$_SERVER["REQUEST_METHOD"];
        if($requestMethod=="GET")
        {
           $row_eleve=$this->search("ELEVES", ["numero"], [$numero]);
            echo json_encode(
                [
                    "data"=>!empty($row_eleve),
                    "message"=>"SUCCESS",
                    "status"=>"200"
                ]

            );

        }

    }
    public function get($id_inscription)
    {
        $requete="
        SELECT * FROM INSCRIPTION 
        INNER JOIN ELEVES ON INSCRIPTION.eleve=ELEVES.id_eleve 
        INNER JOIN CLASSES ON CLASSES.id_classe=INSCRIPTION.classe 
        INNER JOIN ANNEE_SCOLAIRE ON ANNEE_SCOLAIRE.id=INSCRIPTION.annee
        WHERE INSCRIPTION.id_inscrip=$id_inscription;
        ";
        $this->model->requete($requete);
        $resultat=$this->model->getResultat();
        $classe=$resultat[0]["classe"];
        $query="
            SELECT COUNT(eleve) as effectif FROM INSCRIPTION WHERE classe=$classe;
        ";
        $this->model->requete($query);
        $effectif=$this->model->getResultat()[0]["effectif"];
        echo json_encode(
            [
                "eleve"=>$resultat[0],
                "effectif"=>$effectif

            ]
        );
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