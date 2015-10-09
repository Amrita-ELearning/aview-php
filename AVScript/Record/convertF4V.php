<?php
function convertSingleF4vFile($fileName)
{
$OS=strtoupper(substr(PHP_OS, 0, 3)) ;
if($fileName!="" )
{
	$fullFilePath=$videoRootPath.$fileName;
	$newname=substr($fileName,0,strlen($fileName)-4);
	$convertedFile=$videoRootPath.$newname."_converted.f4v";
	$backupfile=$videoRootPath.$newname."_backup.f4v";
	if($OS=="WIN")
	{
	    logit("f4vconverter.php",$fullFilePath ." to ".$convertedFile);	
		exec("f4vpp.exe -i \"".$fullFilePath."\" -o \"".$convertedFile."\"",$output);
		logit("f4vconverter.php",implode(",",$output));
	}
	else 
	{
	   logit("f4vconverter.php",$fullFilePath ." to ".$convertedFile);	
	   exec("./f4vpp -i \"".$fullFilePath."\" -o \"".$convertedFile."\"",$output);
	   logit("f4vconverter.php",implode(",",$output));
	}
	rename($fullFilePath,$backupfile);
	rename($convertedFile,$fullFilePath);
}

}
function convertF4vFilesByFolder($location)
{
$OS=strtoupper(substr(PHP_OS, 0, 3)) ;
if($location!="")
{
    $videos=glob($location."/*.f4v");
	$count=1;
	foreach($videos as $video)
	{   
		$newname=substr($video,0,strlen($video)-4);
		echo substr($newname,-7);
		
		if(substr($newname,-7)=="_backup")
		{
			
			continue;
		}
		else
		{
			$convertedFile=$newname."_converted.f4v";
			$backupfile=$newname."_backup.f4v";
			if($OS=="WIN")
			{	    
				$inputfile= "\"".$video."\"";
				$outputfile="\"".$convertedFile."\"";
				exec("f4vpp.exe -i ".$inputfile." -o ".$outputfile ,$output);		 	 
			}
			else 
			{
				$inputfile= "\"".$video."\"";
				$outputfile="\"".$convertedFile."\"";  
				exec("./f4vpp -i ".$inputfile." -o ".$outputfile);
			}
			if(is_file($convertedFile))
			{
				rename($video,$backupfile);
				rename($convertedFile,$video);
			}
			$count++;
		}
	}
	
}
}
?>