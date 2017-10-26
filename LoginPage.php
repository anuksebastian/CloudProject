<?php include "../inc/dbinfo.inc"; ?>
<html>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/D$
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Login</title>
        <link rel="stylesheet" href="registerstyle.css">
    </head>
<body
<?php
  session_start();
  /* Connect to MySQL and select the database. */
  $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);

  if (mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();

  $database = mysqli_select_db($connection, DB_DATABASE);

?>

<div id="container">
<h1> Login Page</h1>
<form>
</br><label for="username">Username:</label>
<input type="text" id="username" name="username"></br>
</br><label for="password">Password:</label>
<input type="password" id="password" name="password"></br>
<div id="lower">
</br><input type="checkbox"><label for="checkbox">Keep me logged in</label>
</br><input type="submit" value="Login">
</div><!--/ lower--></form>
</div>
</body>
</html>

<?php  
  $Uname = $_REQUEST['username'];
  $Password = $_REQUEST['password'];
if(isset($_POST['loggedin']))
{
    if (empty ($Uname)) //if username field is empty echo below statement
    {
        echo "you must enter your unique username <br />";
    }
    if (empty ($_REQUEST[$Password])) //if password 1 field is empty echo below statement
    {
        echo "you must enter your password <br />";
    }
}
$count = 0;
$result = mysqli_query($connection, "SELECT * FROM Users"); 
while($query_data = mysqli_fetch_row($result)) 
{
  if(($query_data[2]= $Uname) && ($query_data[4] = $Password)){
     $count =1;
     $_SESSION['user_name'] = $Uname;
     $_SESSION['first_name'] =$query_data[0];
     $_SESSION['last_name'] = $query_data[1];
   }
}
 if($count==1)
  {
    echo "</br>Login successfull!! You will be redirected to the Files Page";
    echo "</br>You will be redirected in 5 seconds...";
    echo "<meta http-equiv=Refresh content=5;url=http://www.thebookblogreview.com/ListFile2.php>";
   }
 

?>





