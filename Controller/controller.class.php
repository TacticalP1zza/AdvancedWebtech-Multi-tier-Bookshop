<?php
#does not return .PHP
class Controller
{
    private $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function home()
    {
        return "Pages/home";
    }

    public function login()
    {
        return "auth/login";
    }
    
    public function register()
    {
        return "auth/register";
    }

}