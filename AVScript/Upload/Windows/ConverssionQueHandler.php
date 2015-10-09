<?php
include '../../Common/_specialChars.php';
include '../../_logger.php';
function queHandling($fileName,$folderPath,$content_Serverip,$db_Serverip,$animated,$userid){
	logit("ConversionQueHandler","db is path...............".$db_Serverip);
	$content_serverid=getServerId($content_Serverip,$db_Serverip);
	
	logit("ConverssionQueHandler.php","This is folderpath is ".$folderPath );
	

	if($animated=='N')
	{
		logit("ConverssionQueHandler.php","File Path is".$file_path );
		if(is_dir($folderPath."/_sfp__".$fileName))
		{
			  rm_recursive($folderPath."/_sfp__".$fileName);
		}
		if(file_exists($folderPath."/Log".$fileName.".txt"))
		{
			  unlink($folderPath."/Log".$fileName.".txt");
		}
		if(is_dir($folderPath."/_sfp__".$fileName))
		{
			  rmdir($folderPath."/_sfp__".$fileName);    
		}
		mkdir($folderPath."/_sfp__".$fileName);	
	}
	
	else
	{
		if(is_dir($folderPath."/_isp__".$fileName))
		{
			  rm_recursive($folderPath."/_isp__".$fileName);
		}
	    mkdir($folderPath."/_isp__".$fileName);

		
	}
	queue_genararting($userid,$content_serverid,$folderPath,$fileName,$animated,$userid,$db_Serverip);
}
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
 
function queue_genararting($uid,$contentserverid,$docpath,$docname,$isanimated,$uid,$db_Serverip){
		logit("ConversionQueHandler","File path...............".$docpath);
		logit("ConversionQueHandler","uid...............".$uid);
		logit("ConversionQueHandler","is animated...............".$isanimated);
		logit("ConversionQueHandler","Database IP...............".$db_Serverip);
		$response = "";
		$docpath="../".$docpath;
		$url = 'http://'.$db_Serverip.'/aview/addConversionToQueue.html';
		$myData = array('userId' => $uid,'contentServerId' => $contentserverid,'documentPath' => $docpath,'documentName' => $docname,'createdByUserId' => $uid,'isAnimatedDocument' => $isanimated);
		$myData_json =  json_encode($myData);

		$ch = curl_init( $url );
		curl_setopt( $ch, CURLOPT_POST, 1);
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $myData_json);
		curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt( $ch, CURLOPT_HEADER, 0);
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
		$response = curl_exec( $ch );		
		logit("ConversionQueHandler","File path...............".$docpath);
		logit("ConversionQueHandler","uid...............".$uid);
		logit("ConversionQueHandler","is animated...............".$isanimated);
}
function getServerId($serverDomain,$db_Serverip)
{
	logit("ConversionQueHandler","db...............".$db_Serverip);
		
	$url = 'http://'.$db_Serverip.'/aview/getServerByDomain.html';
	logit("ConversionQueHandler","java url...............".$url);
	$myvars = 'domain=' . $serverDomain;
logit("ConversionQueHandler","getServerId2...............");
	$ch = curl_init( $url );
	curl_setopt( $ch, CURLOPT_POST, 1);
	curl_setopt( $ch, CURLOPT_POSTFIELDS, $myvars);
	curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt( $ch, CURLOPT_HEADER, 0);
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
	logit("ConversionQueHandler","getServerId3..............");
	$responseServer = curl_exec( $ch );
	$responseServer_json = json_decode($responseServer);	
	logit("ConversionQueHandler","getServerId4...............");
	return $responseServer_json->{'serverId'};

}

?>