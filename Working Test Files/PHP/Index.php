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

echo "<script type='text/javascript' src='popouts.js'></script>";
echo <<<_END
	<style = "text/css">
		#popout {
			z-index: 5;
			position: absolute;
			width: 550px;
			height: 300px;
			top: 50px;
			border: 1px dashed #000099;
			background-color: #ddddff;
		}	
	</style>
_END;

if (isset($_POST['player_name']) &&
	$_POST['player_name'] !='')
{	
	$query = "SELECT * FROM players NATURAL JOIN images WHERE player_name='" .
		$_POST['player_name'] . "'";
	$player_info = mysql_query($query);
	echo "<TABLE><CAPTION>Your Results:</CAPTION>";
	$query = "SELECT thumbname FROM images NATURAL JOIN players WHERE player_name='" .
		$_POST['player_name'] . "'";
	$thumbname = mysql_query($query);
	$thumb = $row[0];
	$id_name - $image_path['filename'];
	$domain = $_SERVER['SERVER_NAME'];
	$div_id= $id_name . "popin";
	echo "<TR>";
	echo "<TD><img src='http://$domain/students/cle3a7x/images/$thumbname'/>";
	echo "</TR>";
	echo "</TABLE>";

}
else if (isset($_POST['player_name']) &&
	$_POST['player_name'] =='')
{
}
	
// a lil bit of HTML to create the form.
echo '<br />Search for a Florida Basketball player.';
//Sets post as method of data submission
echo '<form action="index.php" method="post"><pre>';
echo 'Player Name <input type="text" name="player_name" />';
echo '<br /><input type="submit" value="SEARCH" />'; 
echo '</pre></form>';
?>