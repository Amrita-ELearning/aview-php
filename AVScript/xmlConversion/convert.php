<?php

include '../_logger.php';
$fileUrl = $_GET['var1'];
logit(" convert.php $fileUrl",$fileUrl);

//$sa = "http://192.168.0.170/AVContent/Whiteboard/1183//10//76//64638//page9.xml";
$result = exec("E:\HWR1.0\Executable\hwrMsInk.exe $fileUrl");
//logit(" convert.php Converted Data",$result);
logit(" convert.php $fileUrl",$result);
echo $result;

?>