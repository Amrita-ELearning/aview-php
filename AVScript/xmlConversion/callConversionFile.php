<?php

include '../_logger.php';
$sip = $_GET['var1'];
$xmlPath = $_GET["var2"];
$fileName = $_GET["var3"];
$fileUrlPath = "http://".$sip.$xmlPath."/".$fileName;
$txtFileName = substr($fileName,0,-4);
logit("callconversionfile.php ",$fileUrlPath);
try
{
  	$url = "http://192.168.173.59/AVScript/xmlConversion/convert.php?var1=$fileUrlPath";
    $timeout = array('http' => array('timeout' => 4));
    $context = stream_context_create($timeout);
    $response = file_get_contents($url,false,$context);
    logit("callconversionfile.php Converted Data", $response);
    if(!is_dir("/var/www//".$xmlPath."/convertedXmlData"))
	{
		logit("callconversionfile.php ", "folder not exist");
		mkdir("/var/www//".$xmlPath."/convertedXmlData");
	}
	else
	{
		logit("callconversionfile.php ", "folder exist");
	}
	$file="/var/www//".$xmlPath."/convertedXmlData/".$txtFileName.".txt";
	$ourFileHandle = fopen($file, 'a') or die("can't open file");
	file_put_contents($file, $response."\n", FILE_APPEND);
    fclose($ourFileHandle);

}
catch(Exception $e)
{
	logit("callconversionfile Error", $e);
}

?>