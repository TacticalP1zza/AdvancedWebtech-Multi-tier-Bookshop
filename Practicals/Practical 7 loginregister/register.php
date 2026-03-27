<html>
 <head>
  <title>Register</title>
 </head>
 <body>
  <h2>Register</h2>

  Please enter your username and password below to register:

  <form action="createreg.php" method="POST">
   Enter your username:<br />
   <input type="text" name="username" />
   <br />
   Enter your password:<br />
   <input type="password" name="password" />
   <br />
   Is the user an admin user?<br>
   <input type="checkbox" name="admin" />
   <br />
   <input type="submit" value="Register" />
  </form>

 </body>
</html>
