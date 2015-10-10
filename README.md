# aview-content

This is a server side component of the aview software. It manages files storage necessary for an aview classroom. It currently supports only the whiteboard, document sharing, 3d, 2d, recording and playback and video sharing modules of the aview software.

# License
----------------
The code in this repository is licensed under CC-BY-SA unless otherwise noted. Please follow the link for more details.
https://creativecommons.org/licenses/by-sa/4.0/legalcode

Functionality
-------------
* Creates files and folders for storing the content from modules.
* Deletes files and folders.
* Upload files - Files with different formats are uploaded from modules are stored in server.
* Copy file - Files are being copied from one location to another based on the user interaction from client.
* Check file existence
* Convert files - Files are intitated for conversion using different mechanism for staging in AVIEW.
* Uploads photo - Photos taken from aview nodes are uploaded from nodes and stored in server for data analysis.
* Logging - Monitors the server activity and creates logs file based on that.

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


