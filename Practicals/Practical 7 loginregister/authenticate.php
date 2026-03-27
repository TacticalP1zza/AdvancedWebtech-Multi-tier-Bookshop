<?php

include("connection.php");

$username = $_POST['username'];
$password = $_POST['password'];

$loggedin = false;

$query = "SELECT username, password, admin FROM csc30025login WHERE username = ? LIMIT 1";
if($stmt = $conn->prepare($query)){
	$stmt->bind_param("s", $username);
	$stmt->execute();
	$stmt->bind_result($dbusername, $dbpassword, $dbadmin);
	while($stmt->fetch()){
		
		if(password_verify($password, $dbpassword)){
			$loggedin = true;
			// SUCCESS
			session_start();
			session_regenerate_id(); 
			$_SESSION['id'] = session_id();
			$_SESSION['username'] = $username;
			$_SESSION['admin'] = $dbadmin;
		}
	}
	$stmt->close();
}else{
	echo $conn->error;
	exit;
}

if($loggedin){
	$location = 'secure.php';
}else{
	// FAILURE
	$location = 'badauth.php';
}

header("Location: $location");
exit;
?>
