<?php
$folderPath = "";
if(isset($_GET["folderPath"])){
	$folderName = $_GET["folderPath"];
	if(file_exists($folderPath))
	{
		echo "Error: Folder already exists";
	}
	else
	{
		@mkdir( $_GET["folderPath"],0777,true) or die("Cannot create folder");
		echo "Success";
	}
}
else
{
	echo "Error:Please specify a FolderName/Path";
}
?>
