<?php
	$filePath=$_SERVER['DOCUMENT_ROOT'].$_REQUEST["source"]; 
	echo $filePath;
	if(file_exists($filePath))
	{
		echo "file exist";
		unlink($filePath);
		echo "file deleted";
	}
	else
	{
		echo "file not existing";
	}
	
 ?>