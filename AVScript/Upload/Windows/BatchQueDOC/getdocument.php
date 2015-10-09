<html>
<head></head>
<body>

<?php

	$docId = "";
	$response = "";
	$response_json;
	if(isset($_GET["documentId"])){
		$docId = $_GET["documentId"];

		$url = 'http://localhost:8080/aview/getDocumentConversion.html';
		$myvars = 'conversionId=' . $docId;
	//	$myvars = 'conversionId=' . $docId."&secondvar=".secVar;

		$ch = curl_init( $url );
		curl_setopt( $ch, CURLOPT_POST, 1);
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $myvars);
		curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt( $ch, CURLOPT_HEADER, 0);
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

		$response = curl_exec( $ch );
		$response_json = json_decode($response);
		echo "response_json.documentName".$response_json->{'documentPath'};
		$file_name=$response_json->{'documentName'};
		$file_path=$response_json->{'documentPath'};
		echo "response_json.documentName".$response_json->{'documentName'};
		echo "response_json.documentPath".$file_path;
		$temp_file_path=str_replace("../../../","",$file_path);
		var_dump($response_json);
		echo "this new path".$temp_file_path;		
	}
	else
	{
		echo "Error:Please specify a File with Path";
	}


function p2fconverssion_handler($file_path,$file_name){
  $p2f = new COM("Print2Flash3.Server");
  if ($p2f){
  $p2f->DefaultProfile->PageFileName = "../_sfp__".$file_name."/page_%page%.swf";
  $p2f->DefaultProfile->OutputFormat = 2;
  //$p2f->DefaultBatchProcessingOptions->UseAutomation=8;
  $p2fBPO = $p2f->DefaultBatchProcessingOptions;
  $p2fBPO->BeforePrintingTimeout = 900000;
  $p2fBPO->ActivityTimeout=900000;
  $p2f->ConvertFile(realpath("../".$file_path."/@@-OriginalDocs-@@/".$file_name));
   echo "Conversion is done"; }
}
?>
</body>
</html>