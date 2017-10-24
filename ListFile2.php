
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>ListFile</title>
        <link href="style.css" rel="stylesheet" type="text/css">
    </head>

<body>
    	<?php
		        session_start();
                        echo  $_SESSION['user_name'];
                 	echo  $_SESSION['first_name'];
                        echo $_SESSION['last_name'];
                        //include the S3 class
			if (!class_exists('S3'))require_once('S3.php');
			
			//AWS access info
			if (!defined('awsAccessKey')) define('awsAccessKey', 'AKIAJZCNIW2MWITEAAJA');
			if (!defined('awsSecretKey')) define('awsSecretKey', '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');
			
			//instantiate the class
			$s3 = new S3(awsAccessKey, awsSecretKey);
			
			
		?>
<h1>List of uploaded Files,First Name,Last Name,File Last Modified Time</h1>
<input type=button onClick="location.href='UploadFile.php'" value='Click here to Upload Files'></br>
<input type=button onClick="location.href='DeleteFile.php'" value=' DeleteFiles'></br>
<?php
	// Get the contents of our bucket
	$contents = $s3->getBucket("thebookblogreview");
	foreach ($contents as $file){
	
		$fname = $file['name'];
                $first_time = $file['time'];
                
                $timestamp = date("F j, Y, g:i a",$first_time); 
		$furl = "http://thebookblogreview.s3.amazonaws.com/".$fname;
		
                //output a link to the file
		echo "<a href=\"$furl\">$fname</a>"."\t"."an"."\t"."user"."\t"."$timestamp"."<br/>";
     
	}
?>

</body>

</html>
