@echo off
:TOP
cd\
cd "C:\wamp\www\AVScript\Upload\Windows\BatchQueDoc"
php polldocument.php
ping 127.0.0.1 -n 15 >>c:\1.txt
goto :TOP
