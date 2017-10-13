<?php
//sqlite DB
define('DB_PATH', $_SERVER['DOCUMENT_ROOT'].'/system/data/database.sqlite');
$dsn = "sqlite:".DB_PATH;

//postgres DB
//$dbhost = "";
//$dbname = "";
//$dbuser = "";
//$dbpassword = "";
//$dbport = "";
//$dsn = "pgsql:host=".$dbhost.";port=".$dbport.";dbname=".$dbname.";user=".$dbuser.";password=".$dbpassword;

?>