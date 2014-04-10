<?php
/**
*Test Webpage for CS
*Trevor Lutjen
*Copyright Trevor Lutjen 2014
**/

require_once 'login.php';
$db_server = mysql_connect($db_hostname, $db_username, $db_password);
if (!$db_server) die("Unable to connect to MySQL: " . mysql_error());
mysql_select_db($db_database)
	or die("Unable to select database: " . mysql_error());

// HTML to display the form on this page.
echo '<br />Search the Flordia Basketball database using the field below.';
// Sets POST as method of data submission
echo '<form action="test.php" method="post"><pre>'; 
echo 'Player Name <input type="text" name="player_name" />';
// Creates the SEARCH button which calls the POST method with the data entered
echo '<br /><input type="submit" value="SEARCH" />'; 
echo '</pre></form>';

if (isset($_POST['player_name']) &&
	$_POST['player_name'] != '')
{
	$query = "SELECT thumbname FROM players NATURAL JOIN images WHERE player_name='" . $_POST['player_name'] . "'";
	$result_thumb = mysql_query($query);
	$row = mysql_fetch_row($result_thumb);
	$image = $row[0];
	echo "<TABLE><CAPTION>Your Results:</CAPTION>";
	echo "<TR>";
	echo "<TD><img src='http://www.bluesprings.pltwcs.org/students/cle3a7x/images/$image' />";
	echo "</TR>";
	echo "</TABLE>";
}
?>