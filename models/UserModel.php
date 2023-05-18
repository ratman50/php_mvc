<?php
require_once "../models/UserModel.php";
class UserModel extends BaseModel
{
    public function connect($info)
    {
        $key1=array_key_first($info);
        $key2=array_key_last($info);
        return $this->requete(
            "SELECT * FROM USER WHERE ".$key1."=".$info[$key1]." AND ".$key2."=".$info[$key2]
        );
    }

}
