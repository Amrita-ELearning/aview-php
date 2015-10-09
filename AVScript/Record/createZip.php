<?php 
include_once('pclzip.lib.php');
include 'convertF4V.php';
include '../_paths.php';
include '../_logger.php';
$fileType=$_REQUEST["fileType"];

$source=$_REQUEST["source"];
if($fileType=="video")
{
  $source=$videoRootPath.$source;
}
else
{
	$source=$wampRootPath."/".$source;
}
$destination=dirname($source)."/".$_REQUEST['zipNmae'];
logit("createZip.php", "compress ".$source. " to ".$destination);
if(is_file($source."/".$_REQUEST['zipNmae']))
{
  logit("createZip.php","zipfile Exists") ;
  return;
}
else
{
	if($fileType=="video")
		convertF4vFilesByFolder($source);
	logit("createZip.php","compression  started") ; 
	$zipfile = new PclZip($destination);
	$v_list = $zipfile->create($source,PCLZIP_OPT_REMOVE_PATH, $source);
	rename($destination,$source."/".$_REQUEST['zipNmae']);
	logit("createZip.php","compression  ended") ; 
}
?>