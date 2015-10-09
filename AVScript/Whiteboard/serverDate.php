<?php
//echo(date("l, F j, Y, g:i a", time() - date("Z")))
if($_REQUEST["module"] == "main")
{
	$gmt_date=date('D M d Y H:i:s')." GMT+0530 (India Standard Time)";
}
else if($_REQUEST["module"] == "quiz")
{
	date_default_timezone_set("Asia/Kolkata");
	$gmt_date=date('d M Y-h:i:s A');
}
echo $gmt_date;
?>