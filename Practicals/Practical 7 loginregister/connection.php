<?php

  // IMPORTANT: Change the connection parameters to reflect our MySQL setup...
  //            Server name: dalek.scam.keele.ac.uk
  //            Username: your username (eg. v0x00)
  //            Password: same as your username (NOT your usual login password)

  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "csc30025";

  // Create connection
  $conn = mysqli_connect($servername, $username, $password, $dbname);

  // Check connection
  if (!$conn) {
  	die("Connection failed: " . mysqli_connect_error());
  }
?>
