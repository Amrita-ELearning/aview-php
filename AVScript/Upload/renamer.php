<!--
//$source="text.xml";
//$destination="E:/dpk/text.xml";
-->

<?php
include '../_paths.php';


//$destination="Recordedfiles/".$_GET["filename"];
$source=$fmsRootPath."userlist/".$_GET["filename"];

//$destination="E:/dpk/Recordedfiles/".$_GET["filename"];

$teacher = $_GET["teachername"];


function findexts ($filename)
{
$filename = strtolower($filename) ;
$exts = split("[/\\.]", $filename) ;
$n = count($exts)-1;
$exts = $exts[$n];
return $exts;
}

$ext = findexts ($_GET["filename"]) ;

$ran = date("m.d.y") ;

$ran3 = time();

$ran = $ran."_".$ran3;

$ran2 = $ran.".";

$target = "Recordedfiles/";

$target = $target .$teacher. $ran2.$ext;


echo "\n\n\n\n\n";

echo $ext;

echo "\n\n\n\n\n";

echo $target;

echo "\n\n\n\n\n";

//echo $ext;

echo "\n\n\n\n\n";
//if(rename($_GET["filename"], $target))
//{
//echo "The file has been uploaded as ".$ran2.$ext;
//}
//else
//{
////echo "Sorry, there was a problem uploading your file.";
//}
$destination=$target;

echo "\t\t\t\t\t";
echo "\n\n";
echo $source;
echo "\n\n\n\n\n";
echo "\t\t";
echo "\t\t\n\n\n";
echo $destination;

if(rename($source,$destination))
{

echo "file moved \n";

}

else
{
echo "cant be moved try again";

}

?>

