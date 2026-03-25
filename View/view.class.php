<?php

class View
{
    private $model;
    private $controller;

    public function __construct($controller, $model)
    {
        $this->controller = $controller;
        $this->model = $model;
    }

    public function output($page)
    {
        ob_start();
    
        require __DIR__."/layouts/header.php";
    
        require __DIR__."/".$page.".php";
    
        require __DIR__."/layouts/footer.php";

    
        return ob_get_clean();
    }
}