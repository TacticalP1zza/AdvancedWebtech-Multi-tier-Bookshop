<?php 
function getConnection() {

    $username = "x7x92";
    $password = "Mudkip";

    $connection = oci_connect($username, $password);

    if (!$connection) {
        $e = oci_error();
        die("Connection failed: " . $e['message']);
    }

    return $connection;
}
 ?>