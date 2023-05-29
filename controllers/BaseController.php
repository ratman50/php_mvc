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
        return json_decode($jsonData);

    }
   

    
}
