<?php
$filePath			= 	$_GET['filename'];
$path_info 			= 	pathinfo($filePath);
$fileExtension 		= 	strtolower($path_info['extension']);
if($fileExtension != "php") {
   	unlink($filePath);
	}
?>