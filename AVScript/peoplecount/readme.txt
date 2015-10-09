The updateSharedObject.php can be invoked from commandline with the php command
1. Change directory to php folder of wamp.
     eg: C:\wamp\bin\php\php5.3.8
2. Use php command with -d option to enable the php_sockets extension
    eg:php -dextension php_sockets.dll path/to/peoplecount folder/updateSharedObject.php
3. Parameters
    	ip (required) 		:The collaboration server ip address/name.
	port (required)		:The fms port number
	app (required)		:The fms application name for collaboration.
	classname (required)	:The class name for live session in which the peoplecount needs to be updated.
	classid (required)	:The classid for live session in which the peoplecount needs to be updated.
	user (required)		: username of the node whose peoplecount is available.This is the propertyname in shared object
	so (required)			:Shared object name which needs to be updated.
	lectureid(required)   :The lecture id for live session in which peoplecount needs to be updated.
	classtype(required)   :The type of live session (Classroom ,'Meeting' or 'Webinar')
	peoplecount(required)	: count of the users present in the current node.
	
4.php -dextension=php_sockets.dll C:\wamp\www\peoplecount\updateSharedObject.php ip="aerlsd140" port="1935" app="collaboration_module" classname="course163_class3" classid="985" user="moderator163" so="attendanceSO" lectureid="10" classtype="Classroom" peoplecount="8"