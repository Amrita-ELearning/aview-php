<?php
error_reporting(0);
$Return 		= "";
$directory		= $_GET['directory'];

$directory		= '../..'.$directory;


$Return 		= ListFolder($directory);

function ListFolder($teacherFolder){
$xmlTree		= "<files>";
$dir_handle 	= @opendir($teacherFolder) or die("Unable to open");//Open the teacher directory
while (false !== ($file = readdir($dir_handle))){//Read the teacher directory
	if($file!="." && $file!=".."){
			$fPath		=	$teacherFolder."/".$file;
		if (!is_dir($fPath)){ //Check whether the file is a directory or not
				$xmlTree		.= "<file>".$file."</file>";
			}
		}

	}
$xmlTree		.= "</files>";
closedir($dir_handle);
return $xmlTree;
}

echo $Return;
?>
