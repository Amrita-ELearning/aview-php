
<?php
 include '../_logger.php';
// The string you are searching for
logit("read.php","Read File");

$filePath = "";
if(isset($_GET["filePath"]))
{
	$filePath = $_GET["filePath"];
	if(!file_exists($filePath))
	{
		echo "Error: File does not exist";
		return;
	}
}
else
{
	echo "Error:Please specify a File with Path";
	return;
}

$package = '1 files converted';
// Get the file into an array
$data = file($filePath);
//print_r($data);
// Loop the data
for ($i = 0, $found = FALSE; isset($data[$i]); $i++) {
//echo ($data[$i])."<br/>";
//logit("read.php","Read File".($data[$i])."<br/>");
//echo "condition:".strpos($data[$i],$package)."<br/>";
  if (strpos($data[$i],$package)!=false) {
	//echo trim($data[$i]);
	//logit("read.php","Read File".trim($data[$i]));
    $found = TRUE;
    break; // Stop looping
  }
}

if ($found)
{
  //echo "<br />\nI found the URL on line $i";
  echo "Success";
  //logit("read.php","<br />\nI found the URL on line $i");
} else
{
  echo "Error: Found";
   //logit("read.php","<br />\nI didn't find it!");
}

?>