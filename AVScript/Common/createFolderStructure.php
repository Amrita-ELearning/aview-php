<?php
	$folderPath=$_SERVER['DOCUMENT_ROOT'].$_REQUEST["folderPath"]; 
	if(!file_exists($folderPath))
	{
		if(!mkdir($folderPath,0777,true))
		{
			$status= '<status>false</status>';
			echo $status;
			die("Unable to create folder");
		}
		else
		{
			$status= '<status>true</status>';
			echo $status;
		}

	}
	else
	{
		$status= '<status>exist</status>';
		echo $status;
	}
	
 ?>