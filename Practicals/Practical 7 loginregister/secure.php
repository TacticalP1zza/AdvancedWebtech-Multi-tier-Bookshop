<?php
require_once('authorise.php');

//The rest of this script will not execute if the session check in authorise.php fails and 
//the user will have been redirected to a different page
?>

<html>
 <head>
  <title>Secure page</title>
 </head>
 <body>
  <h2>Secure page after login</h2>
  
  <p>
  Welcome to the protected area, <?php echo($_SESSION['username']) ?>!
  </p>
  <p>
  Go to the <a href='secure-admin.php'>admin section</a>
  </p>
  <a href="logout.php">Logout</a>

 </body>
</html>
