<?php 
class AnneeController
{
    private $model;
    public function __construct()
    {
        $this->model=new BaseModel();
    }
    public function annee()
    {
        $query="SELECT * FROM ANNEE_SCOLAIRE;";
        $this->model->requete($query);
        $data=$this->model->getResultat();
        require_once __DIR__."/../views/Annee_scolaire.php";
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
                }
                $notification="Année déja existante";
                echo "\n",$notification;
            }
            echo "\n",$notification;
        }
        header('Location:/annee');

    }
}