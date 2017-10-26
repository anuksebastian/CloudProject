<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>DeleteFile</title>
        <link href="style.css" rel="stylesheet" type="text/css">
    </head>
<form>
<h1>Delete Files </h1>
<h1> Enter File Name </h>
 <input type="text" name="FileName" id = "FileName"  maxlength="40" /><br/>
 </br> <input type="submit" value="Delete" />
</br> <input type=button onClick="location.href='ListFile2.php'" value='List Files'></br> 
</form>
<body>
    	<?php
		      
                        //include the S3 class
			if (!class_exists('S3'))require_once('S3.php');
			
			//AWS access info
			if (!defined('awsAccessKey')) define('awsAccessKey', '');
			if (!defined('awsSecretKey')) define('awsSecretKey', '');
			
			//instantiate the class
			$s3 = new S3(awsAccessKey, awsSecretKey);
			
		        // $file_name = htmlentities($_POST['FileName']);
?>
<?php
         $FileName = $_REQUEST['FileName'];      
	  //echo "$FileName";
        // Get the contents of our bucket
	      $contents = $s3->getBucket("thebookblogreview");
              foreach ($contents as $file){

                $fname = $file['name'];
                if("$fname" == "$FileName"){

                $first_time = $file['time'];

                $timestamp = date("F j, Y, g:i a",$first_time);
                $furl = "http://d3tw3ik94asbc7.cloudfront.net/".$fname;

                //output a link to the file
                echo "<a href=\"$furl\">$fname</a>"."\t".$_SESSION['first_name']."\t".$_SESSION['last_name']."\t".$timestamp."</br>";
                $s3->deleteObject("thebookblogreview",$fname);
                echo"File Deleted Successfully ,check List Files";
}
        }
?>
</body>
</html>
