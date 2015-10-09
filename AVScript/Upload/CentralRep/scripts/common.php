<?php

define("REPOSITORY_TITLE", "Common Library");
/*
This function will take directory path as string and check if it exists on the server or not. If not it will be created
Returns FALSE only if the directory cannot be created ELSE returns TRUE. 
*/
function checkAndCreateDir($dirPath) {
	$dirStatus = is_dir($dirPath) ? true : mkdir($dirPath, 0777);
	return $dirStatus;
	}

/*
This is a RECURSIVE function used to get the size of a folder with path string is given. (in Bytes or KB)
NB: The path string should be relative to the php file where the function is called from.
*/
function getFileSize($pathString){
	if(!file_exists($pathString)) {
		$fileSize = 0;
		} 
	else if(is_file($pathString)) {
		$fileSize = filesize($pathString);
		}
	else{  		
		$fileSize = 0;
		foreach(glob($pathString."/*") as $fn)
		$fileSize += getFileSize($fn);
		}
	return $fileSize;
	}
	
function convertSize($fileSize){
	if($fileSize > 1024){
		$fileSize = round(($fileSize / 1024), 2). " KB";	
		} else {
		$fileSize = $fileSize. " B";	
		}	
	return $fileSize;
	}	
	
	
	function is_empty_dir($file){
	if (($filesInside = @scandir($file)) && count($filesInside) <= 2) {
		return true;
		}
	return false;
	}

/*
This function will output a XML with the string given(Can be used for showing custom errors in the Flex)
*/

function returnXML($str){
	$Return		= "<files label=\"".$str."\"></files>";	
	$Return		=	"<dirs><root label='".REPOSITORY_TITLE."'>".$Return."</root></dirs>";
	echo htmlentities($Return);
	}


function getDestUrl($str){
	if(!is_dir($str)){
		$pathArr = explode("/", $str);
		array_pop($pathArr);
		$str = implode("/", $pathArr);
		}
	return $str;
	}



?>