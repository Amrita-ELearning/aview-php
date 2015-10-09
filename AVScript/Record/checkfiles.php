<?php
$files = $_REQUEST["filename"];
if (file_exists($files)) 
{
    	//echo "$files exists";
	$node = '<files>yes</files>';
}
else 
{
      //echo "$files does not exist";
	$node = '<files>no</files>';
}
$result = '<root>'.$node.'</root>';
//return $result;
echo "$result"
?>