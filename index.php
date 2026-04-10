<?php
session_start();

require_once "Model/model.class.php";
require_once "Controller/controller.class.php";
require_once "View/view.class.php";

$model = new Model();
$controller = new Controller($model);
$view = new View($controller, $model);

$page = "Pages/home";   // default page

if (isset($_GET['action']) && !empty($_GET['action'])) {
    $action = $_GET['action'];

    if (method_exists($controller, $action)) {
        $page = $controller->$action();
    }
}

echo $view->output($page);

?>