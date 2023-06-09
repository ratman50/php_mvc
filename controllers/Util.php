<?php
 class Util
 {
    public static function isFieldEmpty($tab)
    {
        foreach ($tab as $value) {
            if (empty($value)) {
                return false;
            }
        }
        return true;
    }
    public static function orderClasse(&$data)
    {
        foreach ($data as $ke=>  $value) {
            $classes=[];
            $split=explode(",",$value["CLASSES"]);
            foreach ($split as  $val) {
                $split2=explode("@",$val);
                $classe=[
                    substr($split2[0],strlen($split2[0])-1)=>$split2[1],
                ];
                $cle=substr($split2[0],0, strlen($split2[0])-1);
                if (array_key_exists($cle,$classes)) {
                    $classes[$cle][substr($split2[0],strlen($split2[0])-1)]=$split2[1];
                }else
                    $classes[$cle]=$classe;

               
            }
            $data[$ke]["CLASSES"]=$classes;
            // $value["CLASSES"]=$classes;
        }
    }  

    public static function controlGroupe($data, $model)
    {
        if (strlen($data->groupe)<=3) {
            http_response_code(400);
            echo json_encode(
                [
                    "data"=>[],
                    "message"=>"nom groupe trop court",
                    "status"=>"400",
                ]
            );
            return false;
        }
        $query="
            SELECT * FROM `GROUPE_DISCIPLINES` WHERE nom_groupe LIKE :groupe

        ";
        $params=[":groupe"=>strtolower($data->groupe)];
        $model->requete($query, $params);
        $res=$model->getResultat();
        if(!empty($res)){
            http_response_code(400);
            echo json_encode(
                [
                    "data"=>[],
                    "message"=>"nom groupe existe déja",
                    "status"=>"400",
                ]
            );
            return false;
        }
        return true;
    }
    public static function isFielSet($source, $keys)
    {
        foreach ($keys as $value) {
            if(!isset($source[$value]))
                return false;
        }
        return true;
    }
    public static function isLoggedIn()
    {
        return isset($_SESSION["telephone"])  ;
    }
    public static function checkEmpty($val)
    {
        return !empty($val);
    }
    public static function checkAnnee($annee) {
        if (!preg_match('/^\d{4}-\d{4}$/', $annee)) {
            return 0;
        }
        $annees = explode('-', $annee);
    
       
        if ($annees[1] - $annees[0] !== 1) {
            return 1;
        }
        return 2;
    }


 }