<?php
class BaseController
{
    protected $message;
    protected $data;
    protected $status;
    protected $model;
    protected $notification;
    public function __construct()
    {
        $this->message="METHOD NOT SUPPORTED";
        $this->notification="";
        $this->data=[];
        $this->status=405;
        $this->model=new BaseModel();
        $this->notification="";

    }
    protected function rechercher($query,$params)
    {
        $this->model->requete($query, $params);
        return $this->model->getResultat();
    }
    protected function getUriSegments()
    {
        $uri=parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
        $uri= explode('/', $uri);
        return $uri;
    }

    protected function getQueryStringParams()
    {
        $query=[];
        parse_str($_SERVER['QUERY_STRING'], $query);
        return $query;
    }
    protected function receiveData()
    {
        $jsonData=file_get_contents('php://input');
        // echo $jsonData;
        return json_decode($jsonData);

    }
    protected function lastInsert($nameTable, $nameId)
    {
        $query="SELECT * FROM ".$nameTable." WHERE ".$nameId." = LAST_INSERT_ID()";
        $this->model->requete($query);
        return $this->model->getResultat()[0][$nameId];
    }
    protected function search($nameTable, $cols=[], $valCol=[], $param=1)
    {
        $op=$param ? "=": "LIKE";
        $query="SELECT * FROM ".$nameTable;
        
        if (isset($cols[0]) && isset($valCol[0])) {
            $query=$query." WHERE ";
        }
        $i=0;
        while (isset($cols[$i]) && isset($valCol[$i]))
        {
            $query=$query.$cols[$i]." $op :val$i AND ";
            $params[":val$i"]=$valCol[$i];
            ++$i;
        } 
        $query=$i>0?substr($query,0,-5):$query;
        $this->model->requete($query, $params);
        return $this->model->getResultat();
    }
    protected function generateCode($disc)
    {
        $split=explode(" ",$disc);
        $code="";
        $pos=3;
        $j=1;
        $tmp="";
        do {
            
            $code=substr($split[0],0,$pos++);
            $i=0;
            $tmp=substr($split[0],0,$j++);
            while(isset($split[++$i]))
                $tmp=$tmp.$split[$i][0];
            if($i>1)
                $code=$tmp;
            $code=mb_strtoupper($code);
        } while ($this->search("DISCIPLINES",["code_discipline"],[$code]));
        return $code;
    }
    protected function insert($nameTable, $values, $cols=[])
    {
        $query="INSERT INTO ".$nameTable;
        $params=[];
        if (!empty($cols)) {
            $query=$query." (";
            $i=0;
            while (isset($cols[$i])) {
                $query=$query.$cols[$i].",";
                $i++;
            }
            $query=substr($query, 0, -1).")";

        }
        $query=$query." VALUES (";
        $pos=0;
        while (isset($values[$pos])) {
            $params[":val$pos"]=$values[$pos];
            $query=$query.":val$pos,";
            $pos++;
        }
        $query=substr($query, 0, -1).")";
        $this->model->requete($query, $params);
        return $this->model->getRowsAffected();
    }
    protected function update($nameTable, $update, $conditions)
    {
        $query="UPDATE  ".$nameTable." SET ".$update["nameCol"]." = ".$update["valCol"]." WHERE ".$conditions["nameCol"]."= ".$conditions["valCol"];
        
        $this->model->requete($query);
    
        // UPDATE `INFO_GROUPE` SET `etat` = '1' WHERE `INFO_GROUPE`.`id_info` = 6;

    }

    
}
