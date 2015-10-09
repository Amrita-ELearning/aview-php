
<?php
 include '../_logger.php';
 include '../Common/_specialChars.php';
error_reporting(0);//To supress error messages. To enable error reporting for *ALL* error messages use:error_reporting(-1);

//Please uncomment ONLY ONE of the following depending upon
//the Print2Flash version installed at the server
//define("PRINT2FLASH_VERSION_REQUIRED", "2.7.3");
//define("PRINT2FLASH_VERSION_REQUIRED", "3.0");
//define("PRINT2FLASH_VERSION_REQUIRED", "3.1");
define("PRINT2FLASH_VERSION_REQUIRED", "3.2");
//define("PRINT2FLASH_VERSION_REQUIRED", "3.4");
$upload_dir = $_SERVER['DOCUMENT_ROOT'] .  dirname($_SERVER['PHP_SELF']) . '/';
$upload_url = "http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']) . '/';
logit("print2flash.php","upload_dir-----".$upload_dir);
logit("print2flash.php","upload_url-----".$upload_url);
$temp_name = $_FILES['Filedata']['tmp_name'];
$file_name = $_FILES['Filedata']['name'];
logit("print2flash.php","temp_name-----".$temp_name);
logit("print2flash.php","file_name Before replace-----".$file_name);

$file_name = replaceSpecialChars($file_name);
logit("print2flash.php","file_name After replace-----".$file_name);

$org_file_path=$_POST['folderPath'];
$sample_folder=$org_file_path;
$selectArea=$_POST['areaSelect'];
logit("print2flash.php","org_file_path----  ".$org_file_path);
logit("print2flash.php","sample_folder----   ".$org_file_path);
logit("print2flash.php","selectArea is----   ".$selectArea);
if(!is_dir($org_file_path))
{
	mkdir($org_file_path,0777,true);
}
//$file_path =realpath($org_file_path)."/".$file_name;
$file_path = $org_file_path."/".$file_name;
//$org_file_path=$org_file_path."/".$file_name;
if(is_file($org_file_path."/".$file_name.".swf"))
{
           unlink($org_file_path."/".$file_name.".swf");
}

logit("print2flash.php","Moving uploaded file from ".$temp_name." to ".$file_path);
$result  =  move_uploaded_file($temp_name, $file_path);
$file_path=realpath($file_path);
logit("print2flash.php","Moving File Path---- ".$file_path);

if ($result)
{
        $message =  "<result><status>0. Upload OK</status><message>$file_name uploaded successfully.</message></result>";
}
else
{
        $message = "<result><status>4. Error</status><message>Somthing is wrong with uploading a file.</message></result>";
}
logit("print2flash.php",$message);

//Try creating instance of print2flash COM object
//based on the setting PRINT2FLASH_VERSION_REQUIRED
//defined at the top of this php script

switch (PRINT2FLASH_VERSION_REQUIRED) {
    case "2.7.3":
        $p2f = new COM("P2F.Server2");
        break;
    case "3.0":
        $p2f = new COM("Print2Flash3.Server2");
		break;
    case "3.1":
        $p2f = new COM("Print2Flash3.Server2");
        break;
	case "3.2":
        $p2f = new COM("Print2Flash3.Server2");
		break;
	case "3.4":
        $p2f = new COM("Print2Flash3.Server2");
		break;
}

/**************************************************************
Start 	- Setting up Print Orientation for IMAGES(Default is ORIENT_PORTRAIT)
Coder(s)- Vimal Maheedharan
Date 	- 16/Nov/2010
Updated - 16/Nov/2010
**************************************************************/

// Constants for enum PAPER_ORIENTATION
define("ORIENT_PORTRAIT", 0x00000001);
define("ORIENT_LANDSCAPE", 0x00000002);
$path_info = pathinfo($file_path);
	logit("print2flash.php","path_info----  ".$path_info);


$fileExtension = strtolower($path_info['extension']); //get the extension and convert o lowercase. For eg 'Jpg' -> 'jpg' /  'BMP' -> 'bmp'
if (($fileExtension== 'jpg') || ($fileExtension== 'bmp') || ($fileExtension== 'gif')){ // check if the uploaded file is image, ie jpg, bmp or gif
	list($width, $height, $type, $attr) = getimagesize($file_path);// get height, width of image and move to $width and $height variables
	if($width/$height >= 1){ //setting the page orientation to Landscape if WIDTH is greater than or equal to HEIGHT
		try {
			$p2f->DefaultPrintingPreferences->Orientation = ORIENT_LANDSCAPE;
			}
		catch(Exception $e)
			{
			$message = "<result><status>4. Error</status><message>".$e->getMessage()."</message></result>";
			logit("print2flash.php",$message);
			exit;
			}
		}
	}
/**************************************************************
End 	- Setting up Print Orientation for images
**************************************************************/
			$message = "<result><status>1. Starting settings</status><message></message></result>";
			logit("print2flash.php",$message);
    if ($p2f)
        {




				$p2f->DefaultProfile->OutputFormat = 2;
				$org_file_path=str_replace("/@@-OriginalDocs-@@","",$sample_folder);
				logit("print2flash.php","org_file_path new----  ".$org_file_path);
				if(!is_dir($org_file_path."/@@-Thumbnails-@@/"))
				{
					mkdir($org_file_path."/@@-Thumbnails-@@/");
				}
				
				
                $p2f->DefaultProfile->ThumbnailPageRange="All";
                $p2f->DefaultProfile->ThumbnailImageWidth=140;
                $p2f->DefaultProfile->ThumbnailJpegQuality=80;
                $p2f->DefaultProfile->ThumbnailImageHeight=140;
                $p2f->DefaultProfile->ThumbnailFormat=1;
                $p2f->DefaultProfile->ThumbnailFileName=realpath($org_file_path).'/@@-Thumbnails-@@/'.$file_name.'_files\thumbnail_%page%.%ext%';

				//$p2f->DefaultProfile->PageFileName = realpath( $org_file_path ).'/_sfp__'.$file_name.'/page_%page%.swf';
                $p2f->DefaultProfile->PageFileName = realpath( $org_file_path ).'\\_sfp__'.$file_name.'\\page_%page%.swf';
				try
				{
					$p2fBPO = $p2f->DefaultBatchProcessingOptions;					
	                $p2fBPO->BeforePrintingTimeout = 300000;
					$p2fBPO->ActivityTimeout=300000;
					$p2fBPO->UseAutomation=8;
					if($selectArea=="PersonalArea"){
					logit("print2flash.php","Personal area");
					$p2fBPO->CreateLogFile=true;
					$p2fBPO->LogFileName= realpath($org_file_path)."/Log".$file_name.".txt";
					$logfilename=realpath($org_file_path)."/Log".$file_name.".txt";
						}
					$message = "<result><status>2. Starting conversion</status><message></message></result>";
					logit("print2flash.php",$message);
					$p2f->ConvertFile($file_path);
					//$p2f->ConvertFile("C:\wamp\www\AVContent\Upload\Personal\hari\My Documents");

					/*
					//ANOTHER WAY OF EXEVCUTING P2F to run in the background, however, still failing with big files
					$p2fServerEXE = "C:\\Program Files (x86)\\Print2Flash3\\p2fServer.exe";
					$MyDocsDIR = str_replace("/", "\\", realpath($org_file_path));
					logit("print2flash.php","exec("."\"".$p2fServerEXE."\" \"".$MyDocsDIR."\\@@-OriginalDocs-@@\\".$file_name."\" \"".$MyDocsDIR."\\_sfp__".$file_name."\" /ThumbnailPageRange:All /ThumbnailImageWidth:140 /ThumbnailJpegQuality:80 /ThumbnailImageHeight:140 /ThumbnailFormat:1 /ThumbnailFileName:\"".$MyDocsDIR."\\@@-Thumbnails-@@\\".$file_name."_files\\thumbnail_%page%.%ext%\" /OutputFormat:2 /PageFileName:\"".$MyDocsDIR."\\_sfp__".$file_name."\\page_%page%.swf\"".")");
					exec("\"".$p2fServerEXE."\" \"".$MyDocsDIR."\\@@-OriginalDocs-@@\\".$file_name."\" \"".$MyDocsDIR."\\_sfp__".$file_name."\" /ThumbnailPageRange:All /ThumbnailImageWidth:140 /ThumbnailJpegQuality:80 /ThumbnailImageHeight:140 /ThumbnailFormat:1 /ThumbnailFileName:\"".$MyDocsDIR."\\@@-Thumbnails-@@\\".$file_name."_files\\thumbnail_%page%.%ext%\" /OutputFormat:2 /PageFileName:\"".$MyDocsDIR."\\_sfp__".$file_name."\\page_%page%.swf\"");
					*/


					logit("print2flash.php","3. Finished converting ".$file_path." to ".$swffile_fs);
					$message =  "<result><status>OK</status><message>$swffile_fs</message></result>";
				}
				catch(Exception $e)
				{
					$message = "<result><status>4. Error</status><message>".$e->getMessage()."</message></result>";
					logit("print2flash.php",$message);
					return $e;

				}



        }


fclose ($logHandle);

?>
