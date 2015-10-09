
<?php
 include '../_logger.php';
 include '../Common/_specialChars.php';

error_reporting(0);
logit("ispring.php","3.0 This is the swf file path :::".realpath($file_path));
print_r($_POST);

$upload_dir = $_SERVER['DOCUMENT_ROOT'] .  dirname($_SERVER['PHP_SELF']) . '/';
$upload_url = "http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']) . '/';

$temp_name = $_FILES['Filedata']['tmp_name'];
$file_name = $_FILES['Filedata']['name'];

$file_name = replaceSpecialChars($file_name);
logit("ispring.php","1.0 File Name after removing special chars::".$file_name );

$org_file_path=$_POST['folderPath'];
logit("ispring.php","1.1 This is doc URL::".$org_file_path );
if(!is_dir($org_file_path))
{
	mkdir($org_file_path,0777,true);
}
$file_path = $org_file_path."/".$file_name;
if(is_dir($org_file_path."/_sfp__".$file_name))
{
           rm_recursive($org_file_path."/_sfp__".$file_name);
}

logit("ispring.php","2.0 Moving uploaded file from ".$temp_name." to ".$file_path);

$result  =  move_uploaded_file($temp_name, $file_path);
logit("ispring.php","Upload Successful");
//$file_path=realpath($file_path);
if ($result)
{
        $message =  "<result><status>2.1 OK</status><message>$file_name uploaded successfully.</message></result>";
}
else
{
        $message = "<result><status>9.0 Error</status><message>Somthing is wrong with uploading a file.</message></result>";
}
$rand1=rand(1,5); 
$sample_path =realpath($file_path);
logit("ispring.php","Real file_path is ".$sample_path);
$org_file_path=str_replace("/@@-OriginalDocs-@@","",$org_file_path);
author_change(realpath($file_path),"Aview_Author".$rand1);
logit("ispring.php",$message);
        $thum_folder =realpath($org_file_path )."/@@-Thumbnails-@@/";
        if(!is_dir($thum_folder))
		{
			mkdir($thum_folder);
		}

	$swffile_folder = realpath( $org_file_path );

	logit("ispring.php","3.0 This is the swf file path :::".realpath($file_path));

	$swf_file = $file_name.'.swf';
	logit("ispring.php","3.1 This is the swf file folder path ".$swf_file);
	try {
	$isprComobj = new COM("iSpring.PresentationConverter");
	}
	catch(Exception $e)
	{
		$message = "<result><status>9.1 Error</status><message>".$e->getMessage()."</message></result>";
		logit("ispring.php",$message);
		return $e;
	}

	logit("ispring.php","4. com object created");
	//echo "Opening presentation\n";
        $isprComobj->Settings->Playback->Player->CorePlugins->AddBuiltInPlugin(1);
        $isprComobj->Settings->Navigation->KeyboardEnabled = false;
        $isprComobj->Settings->Navigation->AdvanceOnMouseClick = false;
	logit("ispring.php","5. opening presentation");

	try {
	$isprComobj->OpenPresentation(realpath($file_path));
	}
	catch(Exception $e)
	{
		$message = "<result><status>9.1 Error</status><message>".$e->getMessage()."</message></result>";
		logit("ispring.php",$message);
		return $e;
	}

logit("ispring.php","6. Saving Thumbnails");
	try {
	$isprComobj->Presentation->Slides->SaveThumbnails($thum_folder ."/".$file_name.'_files',"thumbnail_",2,140,140,90);
	}
	catch(Exception $e)
	{
		$message = "<result><status>9.3 Error</status><message>".$e->getMessage()."</message></result>";
		logit("ispring.php",$message);
		return $e;
	}
	logit("ispring.php","6. Generating flash");
	try {
	$isprComobj->GenerateFlash($swffile_folder,$swf_file,0,"");
	}
	catch(Exception $e)
	{
		$message = "<result><status>9.2 Error</status><message>".$e->getMessage()."</message></result>";
		logit("ispring.php",$message);
		return $e;
	}


	


	$isprComobj = null;
	logit("ispring.php","7. Finished converting ");

	$thumbname = str_replace(".","_",$fileName);
	logit("ispring.php","8. After converting the Thumbname".$thumbname);
	//echo "Done\n";
	// Warning! When you don't need iSpring object it is necessary to set it to null
	// otherwise error will occur when PHP script finishes.
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
function author_change($file_path,$author_Name){        
        $oExplorer = new COM("powerpoint.application");
	    $oExplorer->Visible = true;
	    $oExplorer->Presentations->Open2007($file_path) ;	 
	    $oExplorer->ActivePresentation->BuiltInDocumentProperties[3]=$author_Name;     
	    $oExplorer->ActivePresentation->save();
	    $oExplorer->Quit();
        $oExplorer = null;
        unset( $oExplorer);	
	}
?>
