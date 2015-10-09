<?php
include '../_paths.php';
include '../_logger.php';
include 'convertF4V.php';
$fileName="";
$location="";
$fileName=$_GET['video'];
$location=$_GET['location'];

convertSingleF4vFile($fileName);
convertF4vFilesByFolder($location);


?>