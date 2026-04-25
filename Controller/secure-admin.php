<?php
require_once('authorise.php');

if (empty($_SESSION['admin']) || $_SESSION['admin'] != 1) {
    header("Location: index.php?action=home");
    exit;
}
?>