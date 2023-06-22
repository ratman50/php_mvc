<?php
class SemestreController extends BaseController
{

    public function list($classe)
    {

        $niveau=$this->search("CLASSES",["id_classe"], [$classe])[0];
        if(!empty($niveau))
        {
            $niv=$niveau["groupe_niveau"];
            $semestre=$this->search("SEMESTRE", ["niveau"], [$niv]);
            $semestre_actif="";
            $actif=$this->search("SEMESTRE_ACTIF", ["classe"],[$classe]);
            if(!empty($actif))
            {
                $actif=$actif[0]["semestre"];
                $semestre_actif=$this->search("SEMESTRE", ["id_semestre"], [$actif]);
            }
            echo json_encode([
                "periode_active"=>$semestre_actif[0],
                "periodes"=>$semestre
            ]);
            die();
        }
        
        
    }
    public function set()
    {
        $data=$this->receiveData();
        if (isset($data->classe) && !empty($data->classe)) {
            $classe=$data->classe;
            $actif_semestre=$this->search("SEMESTRE_ACTIF", ["classe"], [$classe]);
            if(isset($data->semestre) && !empty($data->semestre))
            {
                $semestre=$data->semestre;
                if(empty($actif_semestre))
                {
                    $this->insert("SEMESTRE_ACTIF", [$classe, $semestre], ["classe", 'semestre']);
                }
                else
                    $this->update("SEMESTRE_ACTIF", ["nameCol"=>"semestre","valCol"=>$semestre], ["nameCol"=>"classe","valCol"=>$classe]);
                $name_classe=$this->search("CLASSES", ["id_classe"],[$classe])[0]["nom_classe"];
                $name_semestre=$this->search("SEMESTRE",["id_semestre"], [$semestre])[0]["libelle_semestre"];
                echo json_encode($name_semestre." activé pour la classe ".$name_classe );
            }
        }
    }

}