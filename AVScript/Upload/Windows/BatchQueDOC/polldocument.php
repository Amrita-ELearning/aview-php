<html>
<head></head>
<body>

<?php
include '../../../_logger.php'; // logger is geting included in p2fHandler.php
include '../../../_paths.php';
include 'p2fHandler.php';
include 'iSPringHandler.php';
$docId = "";
$response = "";
$response_json;
$host= gethostname();
$ip = gethostbyname($host);
 $contentDomain=$ip;
 
 $url = 'http://'.$centeralDbServer.'/aview/getNextDocumentForConversion.html';
	$myvars = 'contentServerDomain='.$contentDomain;
	$ch = curl_init( $url );
	curl_setopt( $ch, CURLOPT_POST, 1);
	curl_setopt( $ch, CURLOPT_POSTFIELDS, $myvars);
	curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt( $ch, CURLOPT_HEADER, 0);
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

	$response = curl_exec( $ch );
	$response_json = json_decode($response);
	if ($response_json ){
		    var_dump($response_json);	
			$file_name=$response_json->{'documentName'};
			$file_path=$response_json->{'documentPath'}; 
			$isanimate=$response_json->{'isAnimatedDocument'};
			$conversionId=$response_json->{'documentConversionId'}; 
			echo "response_json.documentName".$response_json->{'documentName'};
			echo "response_json.documentPath".$response_json->{'documentPath'}; 
			echo "response_json.documentConversionId".$conversionId; 
			echo "response_json.documentPath".$file_path;
			echo "response_json.documentType".$isanimate;
			$temp_file_path=str_replace(".././","",$file_path);	
			echo "this new path".$temp_file_path;
			if($file_path!="")
			{	
				$thum_folder =".././".$temp_file_path."/@@-Thumbnails-@@/";
				echo "............This is thumb path.......".$thum_folder;
				if(!is_dir($thum_folder))
				{
				   echo "............This is thumb path.......".$thum_folder;
					mkdir($thum_folder);
				}	
			    if($isanimate=="N"){
					p2fconversion_handler($temp_file_path,$file_name,$thum_folder);
		        }	
		        else
				{
				    ispringconversion_handler($temp_file_path,$file_name,$thum_folder);
				}		
				$url = 'http://'.$centeralDbServer.'/aview/setSuccessfulConversion.html';
				$myvars = 'conversionId='.$conversionId;
				$ch = curl_init( $url );
				curl_setopt( $ch, CURLOPT_POST, 1);
				curl_setopt( $ch, CURLOPT_POSTFIELDS, $myvars);
				curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
				curl_setopt( $ch, CURLOPT_HEADER, 0);
				curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
				$response = curl_exec( $ch );
				$response_json = json_decode($response);
			}
			else
			{
			     echo "Continue";
			}

	}


?>
</body>
</html>
