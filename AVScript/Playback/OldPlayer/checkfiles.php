<?php
include '../../_logger.php';

$caller = "checkFiles.php";

$files = getFilePath($_REQUEST["filename"],$caller);
if (file_exists($files)) 
{
    	//echo "$files exists";
	$node = '<files>yes</files>';
}
else 
{
      //echo "$files does not exist";
	$node = '<files>no</files>';
}
$result = '<root>'.$node.'</root>';
//return $result;
echo "$result";

function getFilePath($rawFilePath,$caller)
{
	include '../../_paths.php';
	logit($caller,"getFilePath:".$rawFilePath);

	if($rawFilePath == "''"  || $rawFilePath == "")
	{
		return $rawFilePath;
	}

	$path_info 		=	pathinfo($rawFilePath);
	$fileExtension 	=	$path_info['extension']; // get file extension
	logit($caller,"File Extension:".$fileExtension);

	if($fileExtension == "flv" ||$fileExtension == "f4v")
	{
		$rawFilePath = $videoRootPath.$rawFilePath;
		logit($caller,"Regular Video file extension:".$fileExtension.". Returning path:".$rawFilePath);
	}
	else
	{
		logit($caller,"Non video file extension:".$fileExtension.". Returning same path");
	}
	return $rawFilePath;
}

?>