<?php

$handle=opendir(".");
$projectContents='<filename>No files found</filename>';
while ($file = readdir($handle))
{
	if((strstr($file,'.swf')=='.swf'))
	{
		$projectContents .= '<filename>'.$file.'</filename>';
	}
}
closedir($handle);


echo '<file>'.$projectContents.'</file>';


?>