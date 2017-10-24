<?php include "../inc/dbinfo.inc"; ?> <html>
<head>
 <link rel="STYLESHEET"  href="registerstyle.css" />
  <title>RegistrationPage</title>
</head>

 <body> </br><h1>Welcome to the Registration Page !!</h1> <?php
  /* Connect to MySQL and select the database. */
  $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
  if (mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();
  $database = mysqli_select_db($connection, DB_DATABASE);
  /* Ensure that the Users table exists. */
  VerifyUsersTable($connection, DB_DATABASE);
  /* If input fields are populated, add a row to the Employees table. */
  $first_name = htmlentities($_POST['FirstName']);
  $last_name = htmlentities($_POST['LastName']);
  $user_name = htmlentities($_POST['UserName']);
  $email = htmlentities($_POST['Email']);
  $password = htmlentities($_POST['Password']);
  if (strlen($first_name) || strlen($last_name)|| strlen($user_name)|| strlen($email) || strlen($password)) {
    AddUser($connection, $first_name, $last_name,$user_name ,$email ,$password);
  }
?>

 <!-- Input form --> <form action="<?PHP echo $_SERVER['SCRIPT_NAME'] ?>" method="POST">
        <label> First Name*</label></t>
        <input type="text" name="FirstName" maxlength="20" size="10" /></br>
       </br> <label> Last Name* </label></t> 
        <input type="text" name="LastName" maxlength="20" size="10" /></br>
        </br><label> User Name* </label></t>
        <input type="text" name="UserName" maxlength="20" size="10" /></br>
        </br><label> Email* </label></t>
        <input type="email" name="Email" maxlength="20" size="10" /></br>
        </br><label> Password* </label></t>
        <input type="password" name="Password" maxlength="20" size="10" /></br>
        </br> <input type="submit" value="Register" />
        <input type=button onClick="location.href='LoginPage.php'" value='Login'>
         
        </form> <!-- Display table data. --> <table border="1" cellpadding="2" cellspacing="2">

 <!-- Clean up. --> <?php
  mysqli_free_result($result);
  mysqli_close($connection); ?> 
 </body> </html> <?php /* Add an employee to the table. */ function AddUser($connection, $first_name, 
$last_name ,$user_name, $email,$password) {
   $fn = mysqli_real_escape_string($connection, $first_name);
   $ln = mysqli_real_escape_string($connection, $last_name);
   $un = mysqli_real_escape_string($connection, $user_name);
   $em = mysqli_real_escape_string($connection, $email);
   $pd = mysqli_real_escape_string($connection, $password);
   $query = "INSERT INTO `Users` (`Fname`, `Lname`,`Uname`,`Email`,`Password`) VALUES ('$fn', '$ln','$un','$em' ,'$pd');";
   if(!mysqli_query($connection, $query))
       echo("<p>Error adding User data.</p>");
   else
       echo("<p> Registration Successful.Please proceed to Login.</p>");

} 
/* Check whether the table exists and, if not, create it. */ function VerifyUsersTable($connection, $dbName) {
  if(!TableExists("Users", $connection, $dbName))
  {
     $query = "CREATE TABLE `Users` (
         `Fname` varchar(45) DEFAULT NULL,
         `Lname` varchar(45) DEFAULT NULL,
         `Uname` varchar(45) DEFAULT NULL,
         `Email` varchar(45) DEFAULT NULL,
         `Password` varchar(45) DEFAULT NULL,
         PRIMARY KEY (`Uname`)
       ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1";
     if(!mysqli_query($connection, $query)) echo("<p>Error creating table.</p>");
  }
}
/* Check for the existence of a table. */ function TableExists($tableName, $connection, $dbName) {
  $t = mysqli_real_escape_string($connection, $tableName);
  $d = mysqli_real_escape_string($connection, $dbName);
  $checktable = mysqli_query($connection,
      "SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_NAME = '$t' AND TABLE_SCHEMA = '$d'");
  if(mysqli_num_rows($checktable) > 0) return true;
  return false;
}

?>
