<?php
//filename: yyyymmdd-hh-mm-ss-userID.xxx
date_default_timezone_set('Asia/Calcutta');
$timeStamp=date('Ymd-h-i-s-'); 

$folderPath= $_SERVER['DOCUMENT_ROOT']."/AVContent/AVCSnapshot/".$_REQUEST["classID"];
$path=$folderPath."/".$timeStamp.$_REQUEST["fileName"];


if(!file_exists($folderPath))
{
mkdir($folderPath,0777,true);
}
else
{
echo "Folder exist";
}

$fp = fopen($path, 'wb' );
fwrite( $fp, $GLOBALS[ 'HTTP_RAW_POST_DATA' ] );
fclose( $fp );

$filecontent = "ip=".$_REQUEST["fmsIP"]."\n".
				"port=".$_REQUEST["fmsPort"]."\n".
				"app=".$_REQUEST["fmsAppName"]."\n".
				"classname=".$_REQUEST["className"]."\n".
				"classid=".$_REQUEST["classID"]."\n".
				"classtype=".$_REQUEST["classType"]."\n".
				"user=".$_REQUEST["userName"]."\n".
				"so=attendanceSO"."\n".
				"lectureid=".$_REQUEST["lectureId"]."\n";
$filepath=str_replace("jpg","txt",$path);
$fp2=fopen($filepath,"w");
fwrite($fp2,$filecontent);
fclose( $fp2 );

?>