<?php
if(session_status() === PHP_SESSION_NONE){
    session_start();
}

if(!isset($_SESSION['id']) || !isset($_SESSION['username'])){
    header("Location: index.php?action=login");
    exit;
}

if($_SESSION['id'] != session_id() || empty($_SESSION['Username'])){
    header("Location: index.php?action=login");
    exit;
} else{
    session_regenerate_id(true);
    $_SESSION['id'] = session_id();
}
?>