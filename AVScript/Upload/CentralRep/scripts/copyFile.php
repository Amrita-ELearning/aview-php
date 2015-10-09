<?php
error_reporting(0);
include("./common.php");
include ("../../../_logger.php");

$sourceURL 	=	"";
$destURL 	=	"";
$message 	=	"";
$xmlReturn 	= 	"";
$fileType    =  "";
$originalfile_copied  = 0;//will be assaigned ' 1 ' if succesfull original file copy happens Acts as a status flag .
$thumbnailfolder_copied=0;//will be assaigned ' 1 ' if succesfull thumbnail folder copy happens Acts as a status flag .
$convertedfile_copied=0;//will be assaigned ' 1 ' if succesfull converted file copy happens Acts as a status flag .
$status		= 	0; //will be assigned '1' if fully  succesful copy happens. Acts as a status flag.

$sourceURL 	=  isset($_POST['sourceURL']) ? trim($_POST['sourceURL']) : "";
$destURL 	=  isset($_POST['destURL']) ? getDestUrl($_POST['destURL']): "";
if(preg_match('"/_sfp_"',$sourceURL,$matches))
{
	  $file_info=preg_split('"/_sfp__"',$sourceURL, -1); 
	 $fileType="NonAnimated";
}
else if(preg_match('"/_isp__"',$sourceURL,$matches))
{
	   $file_info=preg_split('"/_isp__"', $sourceURL, -1);  
	   $fileType="Animated";    
}
$fileName 	=  $file_info[1];
$sourceURL =$file_info[0];
logit("copyFile.php","The file name is".$fileName);
$tempdestSource=$destURL ;
logit("copyFile.php","The sourcePath is".$sourceURL ."..The Destinataion path is: ".$destURL);
if($fileName != ""){
	 if($sourceURL != "" && $destURL != ""){
		$oringinal_source=$sourceURL.'/@@-OriginalDocs-@@/'.$fileName;
		if($originalfile_copied  == 0){			
			if(!dir($tempdestSource.'/@@-OriginalDocs-@@'))
			{
				 mkdir($tempdestSource.'/@@-OriginalDocs-@@');
			}
 			$destURL=$tempdestSource.'/@@-OriginalDocs-@@/'.$fileName;
			if(copy($oringinal_source, $destURL)){
				    $originalfile_copied  = 1;
					logit("copyFile.php","Original file Copied");
				}		
		}
		if($thumbnailfolder_copied  == 0){
			$thumb_sourceURL=$sourceURL.'/@@-Thumbnails-@@/'.$fileName.'_files/';
			$destURL=$tempdestSource.'/@@-Thumbnails-@@/'.$fileName.'_files/';			
			if(!dir($destURL))
			{
				mkdir($destURL,0777,true);
			}
			
			full_copy($thumb_sourceURL,$destURL);
			$thumbnailfolder_copied  =1;
			logit("copyFile.php","thumbnail file Copied");
		}
		if($convertedfile_copied  == 0){
			if($fileType=='Animated')
			{
				$sourceURL=$sourceURL.'/'.$fileName.'.swf';
				$destURL=$tempdestSource.'/'.$fileName.'.swf';
				if(copy($sourceURL, $destURL)){
				    $convertedfile_copied = 1;
				}				
			}
			else if($fileType=='NonAnimated')
			{
				$sourceURL=$sourceURL.'/_sfp__'.$fileName.'/';
				$destURL=$tempdestSource.'/_sfp__'.$fileName.'/';
				full_copy($sourceURL, $destURL);
				$convertedfile_copied =	1;		
			}
			logit("copyFile.php","coverted file Copied");
				
		}
		if($convertedfile_copied  == 1 && $thumbnailfolder_copied  == 1 && $originalfile_copied==1){
		        $status=1;
				$message		=	"Successfully Copied";
		}
		else
		{
				$message		=	$fileType."Some error Ocuured in Process";
		}
		} else {
		$message		=	"Sorry! We are unable to process your request now.";		
		}
	} else {
	$message	=	"Sorry! We are unable to process your request now.";				
	}
function full_copy( $source, $target ) {
    if ( is_dir( $source ) ) {
        @mkdir( $target );
        $d = dir( $source );
        while ( FALSE !== ( $entry = $d->read() ) ) {
            if ( $entry == '.' || $entry == '..' ) {
                continue;
            }
            $Entry = $source . '/' . $entry; 
            if ( is_dir( $Entry ) ) {
                full_copy( $Entry, $target . '/' . $entry );
                continue;
            }
            copy( $Entry, $target . '/' . $entry );
			chmod($target, 0777);
        }

        $d->close();
    }else {
        copy( $source, $target );
		chmod($target, 0777);
    }
}
$xmlReturn	=	"<resXML><root status='".$status."' message='".$message."' /></resXML>";

echo $xmlReturn;	
?>