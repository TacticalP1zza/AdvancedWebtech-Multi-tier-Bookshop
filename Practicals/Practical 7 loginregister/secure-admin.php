<?php

require_once('authorise.php');

//The rest of this script will not execute if the session check in authorise.php fails 
//and the user will have been redirected to a different page
?>

<html>
 <head>
  <title>Secure admin page</title>
 </head>
 <body>
  <h2>Secure admin page after login</h2>
 
	<?php
	if($_SESSION['admin']==true){
		echo "<p>Welcome to the admin area ".$_SESSION['username']."</p>";
		
	}else{
		echo "<p>You are not permitted to view this page</p>\n";
		header("Location: secure.php");
		exit;
	}
	?>
  <a href="logout.php">Logout</a>

 </body>
</html>
