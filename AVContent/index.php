<?php
$sip=$_SERVER['SERVER_NAME'];
$ip=$_SERVER['REMOTE_ADDR'];
echo "<html><title>Welcome to Aview!</title><body><h1>Welcome to Aview</h1><p>Version 3.0.256</p><b><p>Host IP: ---</p><p>Server IP: $sip.</p><p>Connecting from IP Address: $ip.</p></b>";
if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
	echo "<p>Server OS: Windows</p>";
} else {
	echo "<p>Server OS: Linux</p>";
}
echo "</body></html>";
?>