<?php
include '../_logger.php';
$webRoot=$_SERVER['DOCUMENT_ROOT'];
$recordingFolder=$webRoot."/".$_REQUEST["recordingFolderPath"];
echo $recordingFolder;
backUpFiles($recordingFolder,$recordingFolder."/@#Backup");	
function backUpFiles($sourseFolderPath,$destinationFolder)
{
	//echo "sourseFolderPath:::::::".$sourseFolderPath;
	//echo "destinationFolder::::::::".$destinationFolder;

	if(!mkdir($destinationFolder,0777,true))
	{
	
		die("Unable to create folder");
	}
	else
	{

		$dir_handle = @opendir($sourseFolderPath) or die("Unable to open");
		while ($file = readdir($dir_handle)) 
		{
			//echo "backUpFiles WHILE LOOP :::".$sourseFolderPath."/".$file;
			if($file!="." && $file!=".." && !is_dir("$sourseFolderPath/$file"))
			copy("$sourseFolderPath/$file","$destinationFolder/$file");
			else if($file!="@#Backup" && $file!="." && $file!=".." && is_dir("$sourseFolderPath/$file"))
			{
				backUpFiles("$sourseFolderPath/$file","$destinationFolder/$file");	
			}
		}
		closedir($dir_handle);
	}
}
?>