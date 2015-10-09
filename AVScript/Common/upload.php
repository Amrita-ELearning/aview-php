<?php

include '../_logger.php';

$tempFile = $_FILES['Filedata']['tmp_name'];
$fileName = $_FILES['Filedata']['name'];
$fileSize = $_FILES['Filedata']['size'];
$webRoot=$_SERVER['DOCUMENT_ROOT'];
$sip = $_SERVER['SERVER_NAME'];
$xmlPath = $_REQUEST["folderPath"];
$tempXmlPath = substr($xmlPath, 11, 10);
$urlPath = "http://".$sip.$xmlPath."/".$fileName;
if(substr($webRoot,strlen($webRoot)-1)!="/")
{
	$webRoot=$webRoot."/";
}
$folderPath=$webRoot.$_REQUEST["folderPath"];
logit("upload.php variables = ", "$xmlPath ".$xmlPath." $folderPath ".$folderPath." $tempXmlPath ".$tempXmlPath);
echo $folderPath."/". $fileName;
move_uploaded_file($tempFile, $folderPath."/". $fileName);
if($tempXmlPath == "Whiteboard")
{
	//file_get_contents("http://localhost/AVScript/xmlConversion/callConversionFile.php?var1=$sip&var2=$xmlPath&var3=$fileName");
}
logit("upload.php url path", $urlPath);

?>