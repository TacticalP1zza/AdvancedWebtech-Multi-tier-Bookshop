<?php

function getConnection() {
    //put variables in git ignore file and seperate file
    $servername = "localhost";
    $username = "x7x92";
    $password = "x7x92x7x92";
    $dbname = "x7x92";

    $connection = mysqli_connect($servername, $username, $password, $dbname);

    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }

    return $connection;
}

?>