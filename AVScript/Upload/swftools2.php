
<?php
include '../../_logger.php';
include '../../Common/_specialChars.php';
error_reporting(0);//To supress error messages. To enable error reporting for *ALL* error messages use:error_reporting(-1);

//Please uncomment ONLY ONE of the following depending upon
//the Print2Flash version installed at the server
//define("PRINT2FLASH_VERSION_REQUIRED", "2.7.3");
//define("PRINT2FLASH_VERSION_REQUIRED", "3.0");
//define("PRINT2FLASH_VERSION_REQUIRED", "3.1");
define("PRINT2FLASH_VERSION_REQUIRED", "3.2");
//define("PRINT2FLASH_VERSION_REQUIRED", "3.4");
$file_name = $_GET['fileName'];
$file_name = replaceSpecialChars($file_name);
$org_file_path='../'.$_GET['folderPath'];
$file_path =realpath($org_file_path)."/@@-OriginalDocs-@@/".$file_name;

if(is_file($org_file_path."/".$file_name.".swf"))
{
    unlink($org_file_path."/".$file_name.".swf");
}

$path_info = pathinfo($file_path);

$fileExtension = strtolower($path_info['extension']); //get the extension and convert to lowercase. For eg 'Jpg' -> 'jpg' /  'BMP' -> 'bmp'

logit("print2flash.php", "fileExtension: ".$fileExtension);
$input = "\"".$file_path."\"";
$output = realpath( $org_file_path ).'/_sfp__'.$file_name.'/page_1.swf';

try
{
	$message = "<result><status>01. Starting conversion</status><message></message></result>";					
	logit("print2flash.php",$message);
	if ($fileExtension == "pdf")
	{
		$output = realpath( $org_file_path ).'/_sfp__'.$file_name.'/page_%.swf';
		$cmd = "pdf2swf ";
		//$msg = shell_exec("pdf2swf $input -o $output");
	}
	else if ($fileExtension == "jpg" || $fileExtension == "jpeg")
	{
		$cmd = "jpeg2swf ";
	}
	else if ($fileExtension == "png")
	{
		$cmd = "png2swf ";
	}
	else if ($fileExtension == "png")
	{
		$cmd = "gif2swf ";
	}
	$output = "\"".$output."\"";
	$cmd = $cmd.$input." -o ".$output;
	logit("print2flash.php", "cmd: ".$cmd);
	$msg = shell_exec($cmd);
	//shell_exec("pdf2swf $input -o $output");
	logit("print2flash.php","02. Finished converting ".$input." to ".$output);		
	return $message;
}
catch(Exception $e)
{
	$message = "<result><status>03. Error</status><message>".$e->getMessage()."</message></result>";
	logit("print2flash.php",$message);
	return $message;
}

fclose ($logHandle);

?>
