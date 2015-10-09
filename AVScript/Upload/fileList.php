<?php
include '../_logger.php';
include '../_paths.php';
error_reporting(0);
$rootFolder 	   = "";
$Return 		   = "";
$xmlTree		   = "";
$displaySample     = "";
$folderPrefix      = "";
$displayModuleName = "";
$supported_files   = "";
$animatedfolderprefix="";
$rootFolder 	=  $_POST['rootFolder'];
$empty_file_tag 	= "";
$displayModuleName = substr(strrchr($rootFolder, "/"), 1);
// $displayModuleName  = "My Documents";
$wampUploadContentRoot = "../../AVContent/Upload/Personal/";
$fmsUploadContentRoot = $fmsRootPath."/vod/media/VideoShare/";
if($server == "red5")
{
  $fmsUploadContentRoot = $fmsRootPath."/vod/streams/VideoShare/";
}
$uploadContentRoot = "";
if($displayModuleName == "My Videos")
{
	if(!is_dir($fmsRootPath."vod/"))
	{
		mkdir($fmsRootPath."vod/");

	}
	if($server == "red5")
	{
		if(!is_dir($fmsRootPath."vod/streams/"))
		{
			mkdir($fmsRootPath."vod/streams/");
		}	
		
	}
	else if(!is_dir($fmsRootPath."vod/media/"))
	{
		mkdir($fmsRootPath."vod/media/",0777,true);

	}

	if(!is_dir($fmsUploadContentRoot))
	{
		mkdir($fmsUploadContentRoot);
	}
	$supported_files 	=Array("flv", "mp4", "f4v", "MP4", "FLV", "F4V");
	$displayModuleName = "My Videos";
	$empty_file_tag 	= "-No Video Files-";
	$uploadContentRoot = $fmsUploadContentRoot;
}
else if($displayModuleName == "My Documents")
{
	logit("fileList.php","For listing documnets");
    $supported_files 	=  array("swf");
	$folderPrefix 	=  "_sfp__";
	$animatedfolderprefix 	= "_isp__";
	$unwantedFolder 	= "@@-Thumbnails-@@";
	$original_file_folder 	=  "@@-OriginalDocs-@@";	
	$empty_file_tag ="-No Documents-";
	$uploadContentRoot = $wampUploadContentRoot;
	logit("fileList.php","My Empty".$empty_file_tag);
}
else if($displayModuleName == "My 2D Models")
{
	$displayModuleName = "My 2D Models";
	$folderPrefix 	=  "_2d___";
	$supported_files 	=Array("swf");
	$uploadContentRoot = $wampUploadContentRoot;
	$displaySample = "Sample 2D Models";
	$empty_file_tag ="-No 2DObjects-";
	$rootFolderSample ="../../AVContent/Upload/Common/Sample 2D Models";
	if(!is_dir($rootFolderSample))
	{
		mkdir($rootFolderSample);
	}
	$Return_common 		= ListFolder($rootFolderSample,$folderPrefix,$animatedfolderprefix,$supported_files,$unwantedFolder,$original_file_folder,$displayModuleName,NULL,$empty_file_tag);
}
else if($displayModuleName=="My 3D Models")
{
	$displayModuleName = "My 3D Models";
	$folderPrefix 	=  "_3d___";
	$supported_files 	=Array("f3d", "dae");
	$uploadContentRoot = $wampUploadContentRoot;
	$displaySample = "Sample 3D Models";
	$empty_file_tag ="-No 3DObjects-";
	$rootFolderSample ="../../AVContent/Upload/Common/Sample 3D Models";
	if(!is_dir($rootFolderSample))
	{
		mkdir($rootFolderSample);
	}
	$Return_common 		= ListFolder($rootFolderSample,$folderPrefix,$animatedfolderprefix,$supported_files,$unwantedFolder,$original_fil_folder,$displayModuleName,NULL,$empty_file_tag);
}

else
{
	$displayModuleName = "My Content Area";	
	$supported_files 	=Array();
	$uploadContentRoot = $wampUploadContentRoot;
	$empty_file_tag ="-No Files-";	
	if(!is_dir($rootFolderSample))
	{
		mkdir($rootFolderSample);
	}
	$Return_common 		= ListFolder($rootFolderSample,$folderPrefix,$animatedfolderprefix,$supported_files,$unwantedFolder,$original_fil_folder,$displayModuleName,NULL,$empty_file_tag);
}

//Create directories
//Create the presenter directory
//PNCR: doing same function two times. So commented one.
/*
if(!is_dir($uploadContentRoot.$rootFolder))
{
	mkdir($uploadContentRoot.$rootFolder);
}
*/
$rootFolder = $uploadContentRoot.$rootFolder;
logit("fileList.php","Root folder last".$rootFolder);
//Create module directory
if(!is_dir($rootFolder))
{
    //PNCR: changed the recursive flag to true. Otherwise it will create only 1 level of folders.
	mkdir($rootFolder,0777,true);
}
logit("fileList.php","My Empty1111".$empty_file_tag);
$Return 		= ListFolder($rootFolder,$folderPrefix,$animatedfolderprefix,$supported_files,$unwantedFolder,$original_file_folder,$displayModuleName,NULL,$empty_file_tag);

function ListFolder($rootFolder,$folderPrefix,$animatedfolderprefix,$supported_files,$unwantedFolder,$original_file_folder,$displayModuleName,$ReturnAttr,$empty_file_tag)
{

	$fileModified 	=	"";
	$fileSize		=	"";
	$modified		=	"";

	if(!isset($xmlTreeFile))
	{
		$xmlTreeFile 	= '';
	}

	if(!isset($xmlTreeFolder))
	{
		$xmlTreeFolder 	= '';
	}
	if(!isset($Return))
	{
		$Return 	= '';
	}

	$dir_handle 	= @opendir($rootFolder) or die("Unable to open".$rooFolder);//Open the root directory
	$dirname 		= end(explode("/", $rootFolder));

	while (false !== ($file = readdir($dir_handle)))
	{
		//Read the root directory
		if($file!="." && $file!=".."&& $file!=$unwantedFolder && $file!=$original_file_folder)
		{
			if (is_dir($rootFolder."/".$file))
			{
				//Check whether the file is a directory or not
				$tempPath	=	$rootFolder."/".$file;
				if(file_exists($file))
				{
					$modified	=	date ("F d Y H:i:s.", filemtime($file));
					dirSize($file);
				}
				$checkFolder = substr($file,0,6);
				if($checkFolder == $folderPrefix ||$checkFolder==$animatedfolderprefix)
				{
                              $emptyFolderCheckFlag 	= is_empty_dir($rootFolder."/".$file,$displayModuleName);   
                              if($emptyFolderCheckFlag ){
                                  $ConversionStatus   = check_conversion_status($rootFolder."/Log".substr($file,6,strlen($file)).".txt");
                                 // $ConversionStatus  ='Test';
					              $xmlTreeFile.= "<files label='".substr($file,6,strlen($file))."' path='".$tempPath."' cDate='".$modified."' status='".$ConversionStatus."' fSize='".$fileSize."'></files>";
                               }
                              else
                              $xmlTreeFile.= "<files label='".substr($file,6,strlen($file))."' path='".$tempPath."' cDate='".$modified."' status='conversion is completed' fSize='".$fileSize."'></files>";

					//echo "<pre>".htmlentities($xmlTreeFile)."</pre>";
					    $emptyFolderCheckFlag = false;
					//return;
				}
				else
				{
					$xmlTreeFolder.= "<folder label='".$file."' path='".$tempPath."' status='conversion is complet'  cDate='".$modified."' fSize='".$fileSize."'>";
					$emptyFolderCheckFlag 	= is_empty_dir($rootFolder."/".$file,$displayModuleName);
					if($emptyFolderCheckFlag )
					{
						$xmlTreeFolder .= getEmptyFileTag($empty_file_tag);
						
					}					
					$xmlTreeFolder .= ListFolder($rootFolder."/".$file,$folderPrefix,$animatedfolderprefix,$supported_files,$unwantedFolder,$original_file_folder,$displayModuleName,$Return,$empty_file_tag);
					$xmlTreeFolder .= "</folder>";					
				}

			}
			else
			{
				$newFile	=	$file;
				$fPath		=	$rootFolder."/".$file;
				if(file_exists($newFile))
				{
					$fileModified 	=	date ("F d Y H:i:s.", filemtime($newFile));
					$fileSize 		=	filesize($newFile);
				}
				$path_info 		=	pathinfo($file);
				$fileExtension 	=	$path_info['extension']; // get file extension
				$file			=	substr($file,0,-4);
				for($i=0;$i<count($supported_files);$i++)
				{
					if($fileExtension == $supported_files[$i])
					{
						$xmlTreeFile 	.= "<files label='".$file."' path='".$fPath."' cDate='".$fileModified."' fSize='".$fileSize."'></files>";
					}
				}
			}

		}
	}
	$Return =	$xmlTreeFolder.$xmlTreeFile;
	closedir($dir_handle);
	return $Return;
}

function getEmptyFileTag($empty_file_tag)
{
	$xmlTreeFolder = "";	
	$xmlTreeFolder = "<files label='".$empty_file_tag."'></files>";	
	logit("fileList.php","null value".$empty_file_tag);	
	return $xmlTreeFolder;
}

if($Return == "")
{
	if($displayModuleName=="My 3D Models" || $displayModuleName=="My 2D Models")
	{
		if($Return_common == "")
		{
			$Return		=	"<dirs><root label='Personal Area'><folder label='".$displaySample."' path='".$rootFolderSample."'>".getEmptyFileTag($empty_file_tag)."</folder><folder label='".$displayModuleName."' path='".$rootFolder."'>".getEmptyFileTag($empty_file_tag)."</folder></root></dirs>";
		}
		else
		{
			$Return		=	"<dirs><root label='Personal Area'><folder label='".$displaySample."' path='".$rootFolderSample."'>".$Return_common."</folder><folder label='".$displayModuleName."' path='".$rootFolder."'>".getEmptyFileTag($empty_file_tag)."</folder></root></dirs>";
		}
	}
	else
	{
		$Return		=	"<dirs><root label='Personal Area'><folder label='".$displayModuleName."' path='".$rootFolder."'>".getEmptyFileTag($empty_file_tag)."</folder></root></dirs>";
	}
}
else
{
	if($displayModuleName=="My 3D Models" ||$displayModuleName=="My 2D Models")
	{
		if($Return_common == "")
		{
			$Return		=	"<dirs><root label='Personal Area'><folder label='".$displaySample."' path='".$rootFolderSample."'>".getEmptyFileTag($empty_file_tag)."</folder><folder label='".$displayModuleName."' path='".$rootFolder."'>".$Return."</folder></root></dirs>";
		}
		else
		{
			$Return		=	"<dirs><root label='Personal Area'><folder label='".$displaySample."' path='".$rootFolderSample."'>".$Return_common."</folder><folder label='".$displayModuleName."' path='".$rootFolder."'>".$Return."</folder></root></dirs>";
		}
	}
	else
	{
		$Return		=	"<dirs><root label='Personal Area'><folder label='".$displayModuleName."' status='conversion is completed'   path='".$rootFolder."'>".$Return." </folder></root></dirs>";
	}
}
echo htmlentities($Return);

function dirSize($file) {
$size	=	0;
foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($file)) as $newFile){
	$fileSize+=$newFile->getSize();
	}
return $fileSize;
}

function getSystemFolderCount($filesInside)
{
	$fileCount = count($filesInside);
	$systemFileCount = 0;

	for($i=0;$i<$fileCount;$i++)
	{
		if($filesInside[$i] == "@@-OriginalDocs-@@" || $filesInside[$i] == "@@-Thumbnails-@@")
		{
			$systemFileCount++;
		}
	}
	return $systemFileCount;
}
function check_conversion_status($file){
    if(file_exists($file)){
            return "Conversion Started";
      
    }
    else {
           return "Conversion not started";

    }

}
function is_empty_dir($file,$displayModuleName){
	$filesInside = @scandir($file);

	$fileCount = count($filesInside);

	if($displayModuleName == "My Documents")
	{
		if ($fileCount <=2+getSystemFolderCount($filesInside))
		{
			return true;
		}
	}
	else
	{
		if ($fileCount <=2)
		{
			return true;
		}
	}
	return false;
}
?>
