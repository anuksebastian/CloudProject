<?php include "../inc/dbinfo.inc"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>UploadFile</title>
        <link href="style.css" rel="stylesheet" type="text/css">
    </head>

<body>
    	<?php
                        session_start();
                        $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
                        if (mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error(); //include the S3 class
                        $database = mysqli_select_db($connection, DB_DATABASE);
			if (!class_exists('S3'))require_once('S3.php');
			
			//AWS access info
			if (!defined('awsAccessKey')) define('awsAccessKey', '');
			if (!defined('awsSecretKey')) define('awsSecretKey', '/');
			
			//instantiate the class
			$s3 = new S3(awsAccessKey, awsSecretKey);
			
			//check whether a form was submitted
			if(isset($_POST['Submit'])){
			
				//retreive post variables
				$fileName = $_FILES['theFile']['name'];
				$fileTempName = $_FILES['theFile']['tmp_name'];
				
				//create a new bucket
				$s3->putBucket("thebookblogreview1", S3::ACL_PUBLIC_READ);
				
				//move the file
				if ($s3->putObjectFile($fileTempName, "thebookblogreview", $fileName, S3::ACL_PUBLIC_READ)) {
					echo "<strong>Thanks for contributing to our online collection.File uploaded Successfully :).</strong>";
				}else{
					echo "<strong>Apologies.Something went wrong while uploading your file.</strong>";
				}
			}
		?>
<h1>Upload a file</h1>
<p>Please select a file by clicking the 'Browse' button and press 'Upload' to start uploading your file.</p>
   	<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
      <input name="theFile" type="file" />
      <input name="Submit" type="submit" value="Upload">
      <input type=button onClick="location.href='ListFile2.php'" value='List Files'></br>
	</form>
<h1>Thank you.Please find below all Uploaded Files</h1>
<?php
	// Get the contents of our bucket
	$contents = $s3->getBucket("thebookblogreview");
	foreach ($contents as $file){
	
		$fname = $file['name'];
		$furl = "http://d3tw3ik94asbc7.cloudfront.net/".$fname;
		
                //output a link to the file
		
               
               echo "<a href=\"$furl\">$fname</a>"."\t".$_SESSION['first_name']."\t".$_SESSION['last_name'];
               //echo "<a href=\"$furl\">$fname</a>"."\t"."Anu"."\t"."Sebastian"; 
               //Insert into Table               //  $un = $_SESSION['user_name'];
                //$fn =$_SESSION['first_name'];
                //$ln =$_SESSION['last_name'];
                //$url = $furl;
                //$fd  = $file['size'];
                //$fu =  $file['time'];
                //$lm =  $file['time'];
                //$query = "INSERT INTO `File` (`Fname`, `Lname`,`Uname`,`Url`,`FileDesc`,`FileUpdate`,`LastModified`) VALUES ('$fn', '$ln','$un','$url' ,'$fd','$fu','$lm');";
               //if(!mysqli_query($connection, $query)) echo("<p>Error adding User data.</p>");               

	}
?>
</body>
</html>
