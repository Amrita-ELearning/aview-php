<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<body>
<?php

$fileName="C:/wamp/www/Sample/3 MB.doc";
//$fileName="C:/wamp/www/Sample/2.pdf";
echo("Starting conversion");
 $p2f = new COM("Print2Flash3.Server2");
  if ($p2f){		
  //$p2f->DefaultBatchProcessingOptions->UseAutomation=8;
  $p2f->ConvertFile($fileName,"C:/wamp/www/Sample/ConvertedDoc.swf");
  }

?>

</body>
</html>