
<?php
 include '../../_logger.php';
 include '../../_paths.php';
 include '../../Common/_specialChars.php';
error_reporting(0);//To supress error messages. To enable error reporting for *ALL* error messages use:error_reporting(-1);

$upload_dir = $_SERVER['DOCUMENT_ROOT'] .  dirname($_SERVER['PHP_SELF']) ;
$upload_url = "http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']) . '/';
$content_Ip=$_SERVER['SERVER_ADDR'];
$temp_name = $_FILES['Filedata']['tmp_name'];
$file_name = $_FILES['Filedata']['name'];

$file_name = replaceSpecialChars($file_name);
$folderPath=$_POST['folderPath'];
/* if(!is_dir($folderPath))
{
	mkdir($folderPath);
} */
if(!is_dir($folderPath))
{
	mkdir($folderPath,0777,true);
}
$file_path =$folderPath."/".$file_name;

logit("print2flash.php","Moving uploaded file from ".$temp_name." to ".$file_path);
$result  =  move_uploaded_file($temp_name, $file_path);
$p2f = new COM("Print2Flash3.Server2");
if ($result)
{
		$file_path = str_replace("/@@-OriginalDocs-@@","",$folderPath);
        $message =  "<result><status>0. Upload OK</status><message>$file_name uploaded successfully.</message></result>";
		logit("print2flash.php",$message);
			$message = "<result><status>1. Starting settings</status><message></message></result>";
			logit("print2flash.php",$message);
			$file_path=str_replace('../../../',"",$file_path);	
			$logFileName=realpath("../../../".$file_path)."/Log".$file_name.".txt";
			$absPath=realpath("../../../".$file_path.'/@@-OriginalDocs-@@/'.$file_name);
			$pagepath="../../_sfp__".$file_name;
		
		if ($p2f)
        {
				$p2f->DefaultProfile->OutputFormat = 2;
				
				if(!is_dir($file_path."/@@-Thumbnails-@@/"))
				{
					mkdir($file_path."/@@-Thumbnails-@@/");
				}
                $p2f->DefaultProfile->ThumbnailPageRange="All";
                $p2f->DefaultProfile->ThumbnailImageWidth=140;
                $p2f->DefaultProfile->ThumbnailJpegQuality=80;
                $p2f->DefaultProfile->ThumbnailImageHeight=140;
                $p2f->DefaultProfile->ThumbnailFormat=1;	
                $p2f->DefaultProfile->ThumbnailFileName=realpath("../../../".$file_path).'/@@-Thumbnails-@@/'.$file_name.'_files\thumbnail_%page%.%ext%';
				$p2f->DefaultProfile->PageFileName = realpath( "../../../".$file_path ).'/_sfp__'.$file_name.'/page_%page%.swf';
				$p2f->DefaultBatchProcessingOptions->UseAutomation=8;
                try
				{
					$p2fBPO->LoggingLevel=1;	
					$p2fBPO = $p2f->DefaultBatchProcessingOptions;					
	                $p2fBPO->BeforePrintingTimeout = 900000;
					$p2fBPO->ActivityTimeout=900000;
					$p2fBPO->CreateLogFile = true;
					$p2fBPO->LogFileName= realpath("../../../".$file_path)."/Log".$file_name.".txt";
					$message = "<result><status>2. Starting conversion</status><message></message></result>";
					logit("print2flashforApi.php",$message);
					$p2f->ConvertFile($absPath);
					logit("print2flashforApi.php","3. Finished converting ".$file_path." to ".$swffile_fs);
					$message =  "<result><status>OK</status><message>$swffile_fs</message></result>";
					echo"Finished Converting";
				}
				catch(Exception $e)
				{
					$message = "<result><status>4. Error</status><message>".$e->getMessage()."</message></result>";
					logit("print2flash.php",$message);
					return $e;

				}
		}
}
else
{
        $message = "<result><status>4. Error</status><message>Something is wrong with uploading a file.</message></result>";
		echo"Something is wrong with uploading a file";
}
			


?>
