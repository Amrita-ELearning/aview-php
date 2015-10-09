<?php
 include '../_paths.php';
 include '../_logger.php';
 $folderPath=$videoRootPath.$_REQUEST["folderPath"];
 echo $folderPath;
 error_reporting(0);//To supress error messages. To enable error reporting for *ALL* error messages use:error_reporting(-1);
 logit("createVodFolders.php","Folder Structure:".$folderPath);
 if(!file_exists($folderPath))
 {
	if(!mkdir($folderPath,0777,true))
	{
		if(!file_exists($folderPath))
		{
			$status= '<status>false</status>';
			echo $status;
			logit("createVodFolders.php","Folder not created".$folderPath);
		}
		else
		{
			$status= '<status>exists</status>';
			echo $status;
			logit("createVodFolders.php","Folder exists");
		}
	}
	else
	{
		$status= '<status>true</status>';
		echo $status;
		logit("createVodFolders.php","Folder created");
	}
 }
else
{
	$status= '<status>exists</status>';
	echo $status;
	logit("createVodFolders.php","Folder exists");

}
?>