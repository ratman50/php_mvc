<?php
class Route
{
    private $controller;
    private $useCase;

    public function __construct($nameController, $useCases)
    {
        $this->controller=$nameController;
        $this->useCase=$useCases;
    }
    public function route()
    {
        $control= new $this->controller;
        $control->{$this->useCase}();

    }

}