<!DOCTYPE html>
<?php
	include("connection.php");
	
	$username = $_POST['username'];
	$password = $_POST['password'];
	$admin = $_POST['admin'];
	if($admin=='on'){
		$dbadmin = 1;
	}else{
		$dbadmin = 0;
	}

	$query = "INSERT INTO csc30025login(username,password,admin) VALUES(?, ?, ?)";
	
	$hashed_password = password_hash($password, PASSWORD_DEFAULT);
	if($stmt = $conn->prepare($query)){
		$stmt->bind_param("ssi", $username, $hashed_password, $dbadmin);
		$stmt->execute();
		$stmt->close();
	}

?>
<html lang="en">
  <head>
    <title>Database Connection Example - Simple Address Book - PHP Output (UPDATE)</title>
  </head>
  <body>
    <h2>Registered user <?= $username; ?></h2>

    <p><a href="login.php">Return to login page</a></p>

  </body>
</html>
