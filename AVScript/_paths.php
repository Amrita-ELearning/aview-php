<?php
	// get tasklist
	$task_list = array();
	// get tasks matching
	if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
		$task_pattern = '~(FMSMaster|wrapper|AMSMaster)\.exe~i';
		exec("tasklist 2>NUL", $task_list);
	}
	else{
		//echo "running on linux";
		$task_pattern = '~(fms|red5|ams)~i';
		//exec("service --status-all 2>NUL|grep -E -i -w 'red5|fms'", $task_list);
		exec("service --status-all 2>&1|grep -E -i -w 'red5|fms|ams'", $task_list);
	}

	$task_found = false;
	$server="";
	//echo "tasklist.length" .count($task_list) . "\n";
	foreach ($task_list AS $task_line)
	{
		//echo "$task_line:" . $task_line ."\n";
	  if (preg_match($task_pattern, $task_line, $out))
	  {
		$task_found = true;
		//echo "=> Detected: ".$out[1]."\n";
		if ($out[1] == "wrapper" || $out[1] == "red5")
		{
			//echo "red5 is running...";
			$server = "red5";
		}
		else if ($out[1]== "FMSMaster" || $out[1]== "fms")
		{
			//echo "fms is running...";
			$server = "fms";
		}
		else if ($out[1]== "AMSMaster" || $out[1]== "ams")
		{
		    $server="ams";
		}
		
		//exec("taskkill /F /IM ".$out[1].".exe 2>NUL");
	  }
	}
	if(!file_exists($_SERVER['DOCUMENT_ROOT']."/AVScript/paths.ini"))
	{
		// Append a new person to the file
		$current = "";
		if ($server == "fms")
		{
			//echo "setting fms related variables...";
			$current .= "fmsRootPathWIN = C:/Program Files/Adobe/Flash Media Server 4.5/applications/\n";
			$current .= "videoRootPathWIN = C:/Program Files/Adobe/Flash Media Server 4.5/applications/vod/media/\n";
			$current .= "fmsRootPathLINUX   = '/opt/adobe/fms/applications/'\n";
			$current .= "videoRootPathLINUX = '/opt/adobe/fms/applications/vod/media/'\n";
		}
		else if ($server == "red5")
		{
			//echo "setting red5 related variables...";
			$current .= "fmsRootPathWIN = C:/Red5/webapps/\n";
			$current .= "videoRootPathWIN = C:/Red5/webapps/vod/streams/\n";
			$current .= "fmsRootPathLINUX   = '/usr/share/red5-1.0.0-RC1/webapps/'\n";
			$current .= "videoRootPathLINUX = '/usr/share/red5-1.0.0-RC1/webapps/vod/streams/'\n";
		}
		else if($server == "ams")
		{
			$current .= "fmsRootPathWIN = C:/Program Files/Adobe/Adobe Media Server 5/applications/\n";
			$current .= "videoRootPathWIN = C:/Program Files/Adobe/Adobe Media Server 5/applications/vod/media/\n";
			$current .= "fmsRootPathLINUX   = '/opt/adobe/ams/applications/'\n";
			$current .= "videoRootPathLINUX = '/opt/adobe/ams/applications/vod/media/'\n";
		}
		$current .= "wampRootPathWIN = C:/wamp/www \n";
		$current .= "wampRootPathLINUX = '/var/www'\n";
		// Write the contents back to the file
		file_put_contents($_SERVER['DOCUMENT_ROOT']."/AVScript/paths.ini", $current);
	}
	$pathsArray = parse_ini_file($_SERVER['DOCUMENT_ROOT'].'/AVScript/paths.ini');
	if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
		//$fmsRootPath = 'C:/Program Files/Adobe/Flash Media Server/applications/';
		$fmsRootPath = $pathsArray['fmsRootPathWIN'];

		//$videoRootPath = '//172.17.7.101/applications/vod/media/';
		//$videoRootPath = 'C:/Program Files/Adobe/Flash Media Server/applications/vod/media/';
		$videoRootPath = $pathsArray['videoRootPathWIN'];

		//$wampRootPath = '//172.17.7.101/www';
		//$wampRootPath = 'C:/wamp/www';
		$wampRootPath = $pathsArray['wampRootPathWIN'];

	} else {
		$fmsRootPath = $pathsArray['fmsRootPathLINUX'];
		//$fmsRootPath = "/opt/adobe/fms/applications/";
		$videoRootPath = $pathsArray['videoRootPathLINUX'];
		//$videoRootPath='/opt/adobe/fms/applications/vod/media/';
		$wampRootPath = $pathsArray['wampRootPathLINUX'];
		//$wampRootPath = '/var/www';
	}
	$videoModuleName='/video_module/';
	$desktopSharingModuleName='/desktopsharing_module/';
	$docSourceRoot='/AVContent/Upload/';
	$docDestinationRoot='/AVContent/Record/';	
?>