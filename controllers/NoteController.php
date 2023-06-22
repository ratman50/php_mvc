<?php
class NoteController extends BaseController
{
    public function list($id)
    {
        require_once __DIR__."/../views/note.php";

    }
    public function setval()
    {
        $data=$this->receiveData();
        
        foreach ($data as $value) {
            $result=$this->search("NOTES", ["eleve", "max_note","semestre"],[$value->eleve, $value->max_note, $value->semestre]);
            
            if(empty($result))
            {
                $this->insert("NOTES", [$value->eleve, $value->max_note, $value->semestre, $value->value, $value->etat],["eleve", "max_note","semestre","val_note","etat"]);
            }else{
                $this->update("NOTES", ["nameCol"=>"val_note","valCol"=>$value->value], ["nameCol"=>"id_note","valCol"=>$result[0]["id_note"]]);
                $this->update("NOTES", ["nameCol"=>"etat"   ,"valCol"=>$value->etat], ["nameCol"=>"id_note","valCol"=>$result[0]["id_note"]]);
            }
        }
        echo json_encode("Note(s) mise à jour avec succès");
    }
    public function val($params)
    {
       
        $split=explode("&",$params);
        $tab=[];
        foreach ($split as $value) {
            $sn=explode("=",$value);
            $tab[$sn[0]]=$sn[1];
        }
        
        $result=$this->search("MAX_NOTES",["discipline","type_note"],[$tab["discipline"],$tab["type_note"]]);
        
        if(!empty($result))
        {
            $id_max_note=$result[0]["id_max_note"];
            $notes=$this->search("NOTES", ["max_note","semestre"], [$id_max_note, $tab["semestre"]]);
            echo json_encode($notes);

        }
        // $this->search("")
       
    }
}