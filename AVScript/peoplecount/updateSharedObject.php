<?php

require "php-rtmp-client-master/RtmpClient.class.php";
Class Attendance
{
 public $peopleCount;
 public $lastUpdated;
}
Class Data
{
   public $fmsServerIP = "";
   public $fmsServerPort= "";
   public $fmsAppName = "";
   public $collabClassName = "";
   public $collabClassID ="";
   public $userName =""; // actually the id that is passed to FMS (for users_so1)
   public $soName = "";
   public $lectureID="";
   public $classType="";

}
//commandline arguments
$arguments=array_splice($argv,1);
$options;
foreach($arguments as $argument)
{
    $opt=explode("=",$argument);
	$options[$opt[0]]=$opt[1];
}

//=========================================================
$data=new Data();
$data->fmsServerIP=$options["ip"];
$data->fmsAppName=$options["app"];
$data->fmsServerPort=$options["port"];
$data->collabClassName=$options["classname"];
$data->collabClassID=$options["classid"];
$data->userName=$options["user"];
$data->soName=$options["so"];
$data->lectureID=$options["lectureid"];
$data->classType=$options["classtype"];
//=========================================================
$peoplecount=$options["peoplecount"];
$attendance=new Attendance();
$attendance->peopleCount= $peoplecount;
$attendance->lastUpdated=time();
//Create RtmpClient Object
$client = new RtmpClient();
try
{
	 $fmsInstance="";
     if($data->classType=="Meeting")
	 {
	     $fmsInstance=$data->fmsAppName."/".$data->collabClassName."_".$data->lectureID;
	 }
	 else
	 {
		 $fmsInstance=$data->fmsAppName."/".$data->collabClassName."_".$data->collabClassID;
	 }
	//Connect to server
	$client->connect($data->fmsServerIP,$fmsInstance,$data->fmsServerPort,array("peoplecount"));
	$client->setValue($data->soName,$data->userName,$attendance); 
	//$client->call("disconnectConnection");
}
catch(Exception $exp)
{
   echo  $exp->getMessage();
  
}	
//Closing connection
$client->close();
//=========================================================
?>