<?php


// If the session check is unsuccessful the browser is redirected to the badauth page. 
//Otherwise this file does nothing (so the file that includes it will carry on as normal)

session_start();

if($_SESSION['id'] != session_id() || empty($_SESSION['username'])){
	// Either the session ID is incorrect or the username has not been set.
	header("Location: badauth.php");
	exit;
}else{
	session_regenerate_id(); //not strictly necessary, not same session ID provided by the server
	$_SESSION['id'] = session_id();
}

?>
