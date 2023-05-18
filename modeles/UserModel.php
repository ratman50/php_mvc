<?php
class UserModel extends BaseModel
{
    public function connect($info)
    {
        // $query="SELECT * FROM USERS WHERE :identi=:mail AND password_user =:pass";
        $query="SELECT * FROM USERS";
        // return $this->requete($query, $info);
        return $this->requete($query);
    }

}