<?php

$fileName =$_GET['fileName'];
$folderPath=$_GET['folderPath'];

$webRoot=$_SERVER['DOCUMENT_ROOT'];
if(substr($webRoot,strlen($webRoot)-1)!="/")
{
	$webRoot=$webRoot."/";
}
$destination=$webRoot.$folderPath.'/';
//Opens a file."wb"-Open for reading and writing; place the file pointer at the beginning of the file and truncate the file to zero length.
//If the file does not exist, attempt to create it.
$fp = fopen( $destination.$fileName, 'wb');
//Writes to an open file.HTTP_RAW_POST_DATA is used for getting the data from client side
fwrite($fp, $GLOBALS[ 'HTTP_RAW_POST_DATA' ]);

?>