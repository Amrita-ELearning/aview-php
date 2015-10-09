<html>
<head></head>
<body>

<?php
 queue_genararting(115,12,'testDoc','ppt','N');
function queue_genararting($uid,$contentserverid,$docpath,$docname,$isanimated){
		$response = "";

		$url = 'http://localhost:8080/aview/addConversionToQueue.html';
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
		
		echo "Request_message".$myData_json;
		echo "Response_Message".$response;
}
?>
</body>
</html>
