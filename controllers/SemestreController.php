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

}