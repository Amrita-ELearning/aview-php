<?php
$filePath = "";
if(isset($_GET["filePath"])){
	$filePath = $_GET["filePath"];
	if(file_exists($filePath))
	{
		echo "Error: File already exists";
	}
	else
	{
		echo "Success: File does not exist";
	}
}
else
{
	echo "Error:Please specify a File with Path";
}
?>
