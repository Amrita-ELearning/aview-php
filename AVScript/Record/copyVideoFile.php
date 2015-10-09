<?php
 include '../_paths.php';
 include '../_logger.php';
 $destinationFolderPath=$videoRootPath.$_REQUEST["folderPath"];
 $souceFolderPath=$fmsRootPath.$videoModuleName.'streams/'.$_GET['classname'];
 echo $destinationFolderPath;
 echo $souceFolderPath;
 error_reporting(0);//To supress error messages. To enable error reporting for *ALL* error messages use:error_reporting(-1);
 logit("copyVideoFile.php",	"Source File is :".$souceFolderPath.'/'.$_REQUEST["sourceFile"]);
 logit("copyVideoFile.php",	"Destination File is:".$destinationFolderPath.'/'.$_REQUEST["destinationFile"]);
 
 if(copy($souceFolderPath.'/'.$_REQUEST["destinationFile"], $destinationFolderPath.'/'.$_REQUEST["destinationFile"]))
 {
	$size = filesize($souceFolderPath.'/'.$_REQUEST["destinationFile"]);
	echo "<results><sourseName>".$_REQUEST["sourceFile"]."</sourseName><destinationName>".$_REQUEST["destinationFile"]."</destinationName><size>".$size."</size><status>true</status></results>";
	logit("copyVideoFile.php","In Copy Condition 1: The File :".$souceFolderPath.'/'.$_REQUEST["destinationFile"].": suceesfully rename to  :".$destinationFolderPath.'/'.$_REQUEST["destinationFile"]."The size of the file:".$size);
	unlink($souceFolderPath.'/'.$_REQUEST["destinationFile"]);
 }
 else if(copy($souceFolderPath.'/'.$_REQUEST["sourceFile"], $destinationFolderPath.'/'.$_REQUEST["destinationFile"]))
 {
	$size = filesize($souceFolderPath.'/'.$_REQUEST["sourceFile"]);
	echo "<results><sourseName>".$_REQUEST["sourceFile"]."</sourseName><destinationName>".$_REQUEST["destinationFile"]."</destinationName><size>".$size."</size><status>true</status></results>";
	logit("copyVideoFile.php","The File :".$souceFolderPath.'/'.$_REQUEST["sourceFile"].": suceesfully rename to  :".$destinationFolderPath.'/'.$_REQUEST["destinationFile"]."The size of the file:".$size);
 }
  else 
 {
	echo "<results><sourseName>".$_REQUEST["sourceFile"]."</sourseName><destinationName>".$_REQUEST["destinationFile"]."</destinationName><status>false</status><statusMessage>Copying Failes At Server</statusMessage></results>";
	logit("copyVideoFile.php","Failed to rename the file:".$souceFolderPath.'/'.$_REQUEST["sourceFile"].": to  :".$destinationFolderPath.'/'.$_REQUEST["destinationFile"]);
 }
 
 //if the recording streaming server is red5, a third-party tool, flvtool2, is used to inject metadata into the recorded file.
 //red5 does not inject metadata automatically.
 
 $filename = $destinationFolderPath.'/'.$_REQUEST["destinationFile"];
 
 logit("copyVideoFile.php",	"stripos:".stripos($filename, "/Red5"));
 logit("copyVideoFile.php",	"The destination File is:".$filename . " exists: " . file_exists($filename));

 if (file_exists($filename) && stripos($filename, "/Red5") != FALSE)
 {
	//inject metadata
	logit("copyVideoFile.php",	"Inject metadata.");
	$cmd =  "flvtool2 -U ".$filename;
	logit("copyVideoFile.php", "cmd: ".$cmd);
	$msg = shell_exec($cmd);
	logit("copyVideoFile.php", "msg: ".$msg);
 }
 else
 {
	logit("copyVideoFile.php",	"Failed to inject metadata, either the destination file does not exists or it is not red5 server.");
 }
 
?>