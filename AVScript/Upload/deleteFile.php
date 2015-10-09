<?php
include '../_logger.php';
include '../_paths.php';
error_reporting(0);
$directory	=	$_GET["filePath"];
logit("deleteFile.php","Directory is".$directory);
$file_name =$_GET["remoteFileName"];
//$file_name=strstr($directory,"_sfp__");
//$file_name=basename($directory);
//logit("deleteFile.php","File Name is".$file_name);
//$file_name=ltrim($file_name,"_sfp__");
//$file_name=substr($file_name,6,strlen($file_name));
//logit("deleteFile.php","File Name is".$file_name);
$del_directory_count=$_GET["directoryCount"];
$usingmodule=$_GET["usingModule"];
//$usingmodule=strstr($directory,"_sfp__");
//$usingmodule=trim($directory,$file_name);
logit("deleteFile.php","File Path is".$directory);
logit("deleteFile.php","File Name is".$file_name);
logit("deleteFile.php","Using Module is ".$usingmodule);

//if(strpos($directory,'_sfp__')!==false || strpos($directory,'.swf')!==false)
if($usingmodule=='documentsharing')
{

	logit("deleteFile.php","Welcome to FileDelete");
	
	$original_folder=substr($directory,0,strrpos($directory,"/"))."/@@-OriginalDocs-@@/".$file_name;
	logit("deleteFile.php","Orginal Path is".$original_folder);
	$thumbnail_folder=substr($directory,0,strrpos($directory,"/"))."/@@-Thumbnails-@@/".$file_name."_files";	
	logit("deleteFile.php","Thumbnail folder is".$thumbnail_folder);
	$logFile=substr($directory,0,strrpos($directory,"/"))."/Log".$file_name.".txt";
	logit("deleteFile.php","Log file is".$logFile);
	if(unlink($original_folder));
	{
		$orginal_deleted=true;
		$filesInside = @scandir(substr($directory,0,strrpos($directory,"/"))."/@@-OriginalDocs-@@/");
		logit("deleteFile.php","file inside is".$filesInside);
		if(count($filesInside) <= 2){
			rm_recursive(substr($directory,0,strrpos($directory,"/"))."/@@-OriginalDocs-@@/");
		}
	}	
	if(rm_recursive($thumbnail_folder))
	{
		$thumnail_deleted=true;
		$filesInside = @scandir(substr($directory,0,strrpos($directory,"/"))."/@@-Thumbnails-@@/");		
		if(count($filesInside) <= 2){
			rm_recursive(substr($directory,0,strrpos($directory,"/"))."/@@-Thumbnails-@@/");
		}
	}
	//Remove Log File
	if(rm_recursive($logFile))
	{
		$logFile_deleted=true;
		$filesInside = @scandir(substr($directory,0,strrpos($directory,"/"))."/Log");		
		if(count($filesInside) <= 2){
			rm_recursive(substr($directory,0,strrpos($directory,"/"))."/Log".$file_name.".txt");
		}
	}
	if ($orginal_deleted && rm_recursive($directory)) {
      echo "{$directory} has been deleted";
	} else {
      echo "{$directory} could not be deleted";
  	}
	
}
else
{	
	if (rm_recursive($directory)) {
      echo "{$directory} has been deleted";
	} else {
      echo "{$directory} could not be deleted";
  	}
}

   function rm_recursive($filepath) {
      if (is_dir($filepath) && !is_link($filepath)) {
           if ($dh = opendir($filepath)) {
              while (($sf = readdir($dh)) !== false) {
                  if ($sf == '.' || $sf == '..' ) {
                      continue;
                 }
                if (!rm_recursive($filepath.'/'.$sf)) {
                     throw new Exception($filepath.'/'.$sf.' could not be deleted.');
                }
             }
             closedir($dh);
         }
       return rmdir($filepath);
     }
    return unlink($filepath);
 } 

 // Path to directory you want to delete


// Delete it
   
  ?>