<?php
class RouteConnect
{
    private $useCases;

    public function __construct()
    {
        $this->useCases=[
            "logout",
            "login"
        ];
    }
    public function route()
    {
        $route = isset($_GET['route']) ? $_GET['route'] : '';
        $control=null;
        if (in_array($route, $this->useCases)) {
            $control= new AuthController();
            $control->{$route}();
            exit();
        }
        $control=new HomeController();
        $control->index();


    }

}