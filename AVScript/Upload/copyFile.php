<?php
 $fileName=str_replace("/","~@~",$_REQUEST["filename"]); 
  echo "$fileName";
  copy($_REQUEST["filename"],'../RecordFilesAview/Slides/'.$fileName);
  //echo "$file does not exist";
?>