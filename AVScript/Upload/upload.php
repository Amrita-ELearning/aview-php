<?php
 include '../_logger.php';
 include '../_paths.php';
 include '../Common/_specialChars.php';
include '/Windows/ConverssionQueHandler.php';
include '/Windows/BatchQueDOC/iSPringHandler.php';
include '/Windows/BatchQueDOC/p2fHandler.php';
error_reporting(0);//To supress error messages. To enable error reporting for *ALL* error messages use:error_reporting(-1);
$upload_dir = $_SERVER['DOCUMENT_ROOT'] .  dirname($_SERVER['PHP_SELF']) ;
$upload_url = "http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']) . '/';
logit("upload.php","Host Adress.........".$_SERVER['SERVER_ADDR'] );
$content_Ip=$_SERVER['SERVER_ADDR'];
$temp_name = $_FILES['Filedata']['tmp_name'];
$file_name = $_FILES['Filedata']['name'];

$file_name = replaceSpecialChars($file_name);
logit("upload.php","File Name after removing special chars::".$file_name );

$folderPath=$_POST['folderPath'];

$userId=$_POST['userId'];
$databaseIP=$_POST['databaseIP'];
$isAnimatedFile=$_POST['isAnimatedFile'];
logit("upload.php","Aniamte File is  ".$isAnimatedFile );
if(!is_dir($folderPath))
{
	mkdir($folderPath,0777,true);
}

$file_path = $folderPath."/".$file_name;

logit("upload.php","This is db ip.........".$databaseIP );

logit("upload.php","This is filepath ".$file_path );
logit("upload.php","Moving uploaded file from ".$temp_name."to".$file_path);

$result  =  move_uploaded_file($temp_name, $file_path);
if ($result)
{
        $message =  "<result><status>OK</status><message>$file_name uploaded successfully.</message></result>";
		$pattern = '@@-OriginalDocs-@@';
		$pos = strpos($file_path, $pattern);
		$file_path=str_replace("/@@-OriginalDocs-@@","",$folderPath);
		logit("upload.php","This is new file path filepath.........".$file_path );
}
else
{
        $message = "<result><status>Error</status><message>Somthing is wrong with uploading a file: $temp_name to: $file_path</message></result>";
}
logit("upload.php",$message);
?>