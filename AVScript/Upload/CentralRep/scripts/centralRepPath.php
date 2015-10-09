<?php
error_reporting(0); // for suppressing the warnings which can change/alter the format/content of XML returned to Flex
include("./common.php");

//intializing variables
$libraryXML 	= "";
$fileLabel 		= "";
$Return 		= "";
$xmlTreeFile		= "";
$xmlTreeFolder		= "";
$xmlContent 	= "";



$libraryXML			=	isset($_POST['libraryXML']) ? $_POST['libraryXML'] : $libraryXML;
$instituteFolder	=	isset($_POST['rootFolder']) ? $_POST['rootFolder'] : $rootFolder;
$instituteFolder=$instituteFolder."/institutes";
$supportedFiles=array();
$instituteIDArray 	= array();
$instituteNameArray = array();
$instituteArray		= array();
$courseIDArray		= array();
$courseNameArray	= array();
$courseArray		= array();
$classIDArray		= array();
$classNameArray		= array();
$classArray			= array();
$isModeratorArray	= array();

if($libraryXML){
	$processXML	=	simplexml_load_string($libraryXML);
	foreach($processXML->institute as $institute){
		if(checkAndCreateDir($instituteFolder."/".$institute['id'])){ // creating institute folders by institute_id as folder name
			array_push($instituteIDArray, $institute['id']);
			array_push($instituteNameArray, $institute['name']);
			if(checkAndCreateDir($instituteFolder."/".$institute['id']."/courses")){ // creating 'courses' folder inside institute
				foreach($institute->courses->course as $course) {
					if(checkAndCreateDir($instituteFolder."/".$institute['id']."/courses/".$course['id'])){ // creating course folders by course_id
						array_push($courseIDArray, $course['id']);
						array_push($courseNameArray, $course['name']);
						if(checkAndCreateDir($instituteFolder."/".$institute['id']."/courses/".$course['id']."/classes")){ // creating 'classes' folder
							foreach($course->classes->class as $class){
								if(checkAndCreateDir($instituteFolder."/".$institute['id']."/courses/".$course['id']."/classes/".$class['id'])){ // creating class folder
									array_push($classIDArray, $class['id']);
									array_push($classNameArray, $class['name']);
									array_push($isModeratorArray, $class['is_moderator']);
									}
								}
							}
						}
					}
				}
			}
		}

	$instituteArr 	= array_combine($instituteIDArray, $instituteNameArray);
	$courseArr		= array_combine($courseIDArray, $courseNameArray);
	$classArr		= array_combine($classIDArray, $classNameArray);
	$moderatorArr	= array_combine($classIDArray, $isModeratorArray);

	$Return			= ListFolder($instituteFolder, NULL, $instituteArr, $courseArr, $classArr, $moderatorArr);
	} else {
	$Return			= "<emptyFolder label=\" - No documents - \"></emptyFolder>";
	}

/*
Recursive function to get the files and folders when a root folder of server is given.
*/
function ListFolder($rootFolder, $ReturnAttr, $instituteArr, $courseArr, $classArr, $moderatorArr){

	$folderArr		= "";
	$folderArrCnt	= "";
	$dir_handle		= "";
	$dirname		= "";
	$parentFolder	= "";
	$fPath			= "";
	$Return			= "";

	$xmlTreeFile = (isset($xmlTreeFile))  ? $xmlTreeFile : '';
	$xmlTreeFolder = (isset($xmlTreeFolder))  ? $xmlTreeFolder : '';

	//echo $rootFolder; exit;

	$dir_handle 	= @opendir($rootFolder) or die(returnXML("Unable to open the directory"));//Open the root directory
	$dirname 		= end(explode("/", $rootFolder));
	while (false !== ($file = readdir($dir_handle))){//Read the root directory
		$fileLabel		= "";
		$fileSize       = "";
		$modified		= "";
		$isModerator	= "N"; // default value set for is_moderator to N (means not a moderator)
		$showFolder		= true;
		$icon 			= "";
		$unfold         =0;

		$tempPath		= $rootFolder."/".$file;
		$folderArr 		= explode("/", $tempPath);
		$folderArrCnt 	= count($folderArr);
		$parentFolder 	= trim($folderArr[$folderArrCnt - 2]);

		if($parentFolder == "institutes"){
			$fileLabel = isset($instituteArr[$file]) ? $instituteArr[$file] : "Doc $file";
			if(!array_key_exists($file, $instituteArr)){
				$showFolder = false;
				}
			}
		else if($parentFolder == "courses"){
			$fileLabel = isset($courseArr[$file]) ? $courseArr[$file] : "Course $file";
			if(!array_key_exists($file, $courseArr)){
				$showFolder = false;
				}
			}
		else if($parentFolder == "classes"){
			$fileLabel = isset($classArr[$file]) ? $classArr[$file] : "Class $file";
			if(!array_key_exists($file, $classArr)){
				$showFolder = false;
				}
			}
			else{
				$fileLabel =$file;
			}


		    if($file!="." && $file!=".." && $showFolder && $file!='@@-Thumbnails-@@' && $file!='@@-OriginalDocs-@@') {

			if (is_dir($rootFolder."/".$file )){ //Check whether the file is a directory or not
			 $checkFolder = substr($file,0,6);

				$modified		=	date ("F d Y H:i:s.", @filemtime($tempPath));
				//$fileSize 		= convertSize(getFileSize($tempPath)); // get file size in KB or B
				$isModerator	= isset($moderatorArr[$file]) ? $moderatorArr[$file] : $isModerator;


				if(($file != "courses") && ($file != "classes")){
				if($checkFolder == '_sfp__' )
				{
                 $xmlTreeFile	.=  "<files id='".$file."'label='".substr($file,6,strlen($file))."' path='".$tempPath."' cDate='".$modified."' fSize='".$fileSize."' type='file'></files>"	;
				$emptyFolderCheckFlag = false;
			    }
				else
				{
					$xmlTreeFolder				.= "<folder id='".$file."' label='".$fileLabel."' path='".$tempPath."' cDate='".$modified."' fSize='".$fileSize."' is_moderator='".$isModerator."' type='".$parentFolder."'>";
					$emptyFolderCheckFlag 	= is_empty_dir($tempPath);
				}
				}

				if($emptyFolderCheckFlag ){
					$xmlTreeFolder .= "<emptyFolder label=\" - No documents - \" path='".$tempPath."' type='No Documents'></emptyFolder>";
					}else if($checkFolder != '_sfp__' ) {

						$rootFolder = (substr($rootFolder, -1, 1) == "/") ? substr($rootFolder, 0, -1) : $rootFolder; //exit;
						$xmlTreeFolder .= ListFolder($rootFolder."/".$file, $Return, $instituteArr, $courseArr, $classArr, $moderatorArr);

					}

				if(($file != "courses") && ($file != "classes") && $checkFolder != '_sfp__'){
					$xmlTreeFolder .= "</folder>";
					}
				} else {
				//$fileSize 	=   convertSize(getFileSize($tempPath)); // get file size in KB or B
				$file 		= 	str_replace('.swf','',$file);
				$modified	=	date ("F d Y H:i:s.", @filemtime($tempPath));
				$xmlTreeFile	.=  "<files label='".$file."' path='".$tempPath."' cDate='".$modified."' fSize='".$fileSize."' type='file'></files>";
				}
			}
		}
	$Return =	$xmlTreeFolder.$xmlTreeFile;
	closedir($dir_handle);
	return $Return;

}

$Return		=	"<dirs><root label='".REPOSITORY_TITLE."'>".$Return."</root></dirs>";

echo htmlentities($Return);

clearstatcache();

?>
