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
			//include the S3 class
			if (!class_exists('S3'))require_once('S3.php');
			
			//AWS access info
			if (!defined('awsAccessKey')) define('awsAccessKey', '');
			if (!defined('awsSecretKey')) define('awsSecretKey', '/');
			
			//instantiate the class
			$s3 = new S3(awsAccessKey, awsSecretKey);
			
			
		?>
<h1>List of uploaded Files</h1>
<h1>All users of the website are allowed to download the files</h1>
<h1>To upload Files ,please Login or Register </h1>
<input type=button onClick="location.href='index.html'" value='Login/Register'></br>

<?php
	// Get the contents of our bucket
	$contents = $s3->getBucket("thebookblogreview");
	foreach ($contents as $file){
	
		$fname = $file['name'];
                $first_time = $file['time'];
                
                $timestamp = date("F j, Y, g:i a",$first_time); 
		$furl = "http://d3tw3ik94asbc7.cloudfront.net/".$fname;
		
		//output a link to the file
		echo "<a href=\"$furl\">$fname</a>"."\t".$_SESSION['first_name']."\t".$_SESSION['last_name']."\t"."$timestamp"."<br/>";
     
	}
?>
</body>
</html>
