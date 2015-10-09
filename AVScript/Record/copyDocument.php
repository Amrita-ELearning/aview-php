<?php
	include '../_paths.php';
	 include '../_logger.php';
	$sourceFileName=$_REQUEST["sourceFileName"];
	$destinationFileName=$_REQUEST["destinationFileName"];
	$orginalFileName=$_REQUEST["orginalFileName"];
	$commonPath=$_REQUEST["commonPath"];
	$webRoot=$_SERVER['DOCUMENT_ROOT'];
	if(substr($webRoot,strlen($webRoot)-1)!="/")
	{
		$webRoot=$webRoot."/";
	}
	$sourceFolder=$webRoot.'/AVContent/'.$_REQUEST["commonPath"];
	logit('copyDocument.php','source folder is'.$sourceFolder.' sourceFileName '.$sourceFileName.' webRoot '.$webRoot.'$docSourceRoot '.$docSourceRoot.' commonPath'.$_REQUEST["commonPath"]);
	$destinationFolder=$webRoot.$docDestinationRoot.$_REQUEST["recordingFolder"].$_REQUEST["commonPath"];
	logit('copyDocument.php','destinataion folder is'.$destinationFolder.' destinationFileName '.$destinationFileName);
	logit('copyDocument.php','commonPath is'.$commonPath.' orginalFileName '.$orginalFileName);
	if(is_file($sourceFolder.$sourceFileName))
	{
		if(!file_exists($destinationFolder))
		{
			if(!mkdir($destinationFolder,0777,true))
			{
				die("Unable to create folder");
			}
		}
		copy($sourceFolder.$sourceFileName,$destinationFolder.$destinationFileName);
		copyThumbNails($sourceFolder,$destinationFolder,$orginalFileName."_files",$destinationFileName);
		$status = '<status>1</status>';
		$status = '<status>2</status>';
		echo $status;
	}
	else
	{
		if(!mkdir($destinationFolder.$destinationFileName,0777,true))
		{
			die("Unable to create folder");
		}
		$dir_handle = @opendir($sourceFolder.$sourceFileName) or die("Unable to open");
		while ($file = readdir($dir_handle))
		{
			if($file!="." && $file!=".." && !is_dir("$sourceFolder$sourceFileName/$file"))
			copy("$sourceFolder$sourceFileName/$file","$destinationFolder$destinationFileName/$file");
		}
		closedir($dir_handle);
		$status= '<status>1</status>';
		copyThumbNails($sourceFolder,$destinationFolder,$orginalFileName."_files",$destinationFileName);
		$status= '<status>2</status>';
		echo $status;

	}
	function copyThumbNails($source,$destination,$orginalFileName,$destinationFileName)
	{
		//echo "$source/@@-Thumbnails-@@/$orginalFileName";
		//echo "$destination/@@-Thumbnails-@@$destinationFileName";
		 if(!mkdir("$destination/@@-Thumbnails-@@/$orginalFileName$destinationFileName",0777,true))
		 {
			die("Unable to create folder");
		 }
		$dir_handle = @opendir("$source/@@-Thumbnails-@@/$orginalFileName") or die("Unable to open");
		 while ($file = readdir($dir_handle))
		 {

			if($file!="." && $file!=".." && !is_dir("$source/@@-Thumbnails-@@/$orginalFileName/$file"))
			{
				echo "$source/@@-Thumbnails-@@/$orginalFileName/$file";
				echo "$destination/@@-Thumbnails-@@/$orginalFileName$destinationFileName";
				copy("$source/@@-Thumbnails-@@/$orginalFileName/$file","$destination/@@-Thumbnails-@@/$orginalFileName$destinationFileName/$file");

			}
		 }
	}

 ?>
