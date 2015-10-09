<?php
function replaceSpecialChars($file_name)
{
	$spclChars = array(" ","~", "!", "@", "#", "$", "%", "^","&",",", "*", "(",")","'","+");
	$return_file_name = str_replace($spclChars, "_", $file_name);
	return $return_file_name;
}
?>
