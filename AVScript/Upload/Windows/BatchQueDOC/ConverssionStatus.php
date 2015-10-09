<html>
<head></head>
<body>

<?php
conversion_progress('C:/wamp/www/SampleQueDOC/Log.txt');

function conversion_progress($filepath)
{
	$line='';
	$f = fopen($filepath, 'r');
	$cursor = -1;

	fseek($f, $cursor, SEEK_END);
	$char = fgetc($f);

	/**
	 * Trim trailing newline chars of the file
	 */
	while ($char === " ") {
		
		fseek($f, $cursor--, SEEK_END);
		$char = fgetc($f);
	}

	/**
	 * Read until the start of file or first newline char
	 */
	while ($char !== false && $char !== " ") {
		/**
		 * Prepend the new char
		 */
		$line = $char . $line;
		fseek($f, $cursor--, SEEK_END);
		$char = fgetc($f);
	}

	echo $line;
	preg_match_all('!\d+!', $line, $matches);
    var_dump($matches);
}

?>
</body>
</html>
