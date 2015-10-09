# aview-php

This is a server side component of the aview software. It manages files storage necessary for an aview classroom. It currently supports only the whiteboard, document sharing, 3d, 2d, recording and playback and video sharing modules of the aview software.


Installation
--------------
Supported platforms: Ubunut and Windows server
* Install nginx 
* Install php5
* copy code in this repo under /var/www/
* Set the following configuration in the php.ini file
<pre> 
max_execution_time = 300
max_input_time = 120
post_max_size = 100M
upload_max_filesize = 100M
</pre>


