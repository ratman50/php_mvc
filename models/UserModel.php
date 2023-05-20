<?php
// require_once "../models/BaseModel.php";
// require_once "../inc/config.php";

class UserModel extends BaseModel
{
    public function connect($info)
    {
        // $query="SELECT * FROM USERS WHERE :identi=:mail AND password_user =:pass";
        // return $this->requete($query, $info);
        $query="SELECT * FROM USERS WHERE num_user = :num AND  password_user= :pass";
        return $this->requete($query, $info);
    }

}
// $info=[
//     ":valIdenti"=>"USER",
//     ":pass"=>"12345"
// ];
// echo $info[":identi"],"\n";
// $us=new UserModel();
// var_dump($us->connect($info,"login_user"));