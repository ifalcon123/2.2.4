<?php
/**
*224 CSE HOUR 3
*Trevor Lutjen PHP wizard
*Basic php website
*
*Verison .01
**/

/* 
This block allows our program to access the MySQL database.
Elaborated on in 2.2.3.
 */
require_once 'login.php';
$db_server = mysql_connect($db_hostname, $db_username, $db_password);
if (!$db_server) die("Unable to connect to MySQL: " . mysql_error());
mysql_select_db($db_database)
	or die("Unable to select database: " . mysql_error());

if (isset(