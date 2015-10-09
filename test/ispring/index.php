
<?php
	set_time_limit(0);

	$PPT_FILE = "/1.ppt";
	$SWF_FOLDER = "";
	$SWF_FILE = "quicktour.swf";

	$fs = new COM("iSpring.PresentationConverter");

	echo "Opening presentation\n";
	$fs->OpenPresentation($PPT_FILE);

	echo "Generating flash...\n";
	$fs->GenerateFlash($SWF_FOLDER, $SWF_FILE, 0, "Standard");

	echo "Done\n";


	// Warning! When you don't need iSpring object it is necessary to set it to null
	// otherwise error will occur when PHP script finishes.
	$fs = null;

?>