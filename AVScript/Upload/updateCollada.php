<?php
$fileName=$_GET["fileName"]; 
$content=$_GET["content"]; 
$i=0;
if ($content!="nil")
{ 
	$arrayValues=explode(",", $content);
	$info = simplexml_load_file($fileName);
	foreach($arrayValues as $value)
	{
		$info->library_images->image[$i]->init_from=$value;
		$i++;
	}
	$info->asXML($fileName);
} 
else
{
	$info = simplexml_load_file($fileName);
	foreach($info->library_images as $image)
	{
		$dom=dom_import_simplexml($image);
        $dom->parentNode->removeChild($dom);
	}
	$info->asXML($fileName);
}
?>