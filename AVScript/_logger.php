<?php
function logit($caller,$str)
{
    date_default_timezone_set('Asia/Kolkata');
	$sip=$_SERVER['SERVER_NAME'];
	$ip=$_SERVER['REMOTE_ADDR'];
    $str = date_format(date_create(),'d-m-Y H:i:s u')."\t".$caller."\t---".$sip."\t---".$ip."\t---".$str;
	if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN')
	{
		file_put_contents ($_SERVER['DOCUMENT_ROOT'].'/AVScriptLog.txt', $str."\n", FILE_APPEND);
	} else {
		file_put_contents ('/var/www/AVScriptLog.txt', $str."\n", FILE_APPEND);
	}
}

?>
