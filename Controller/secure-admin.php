<?php
require_once('authorise.php');

if($_SESSION[''] === False){
    header("Location: index.php?action=home");
    exit;
}

?>