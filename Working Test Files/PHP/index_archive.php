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

// When the POST protocol is invoked, checks case 1 for the data entered in the form.	
if (isset($_POST['player_name']) &&
	$_POST['player_name'] != ''
{
	// Gathers the information provided in the form with the POST protocol
	// creates and submits MySQL queries using it, explained in 2.2.3
	$query = "SELECT * FROM players NATURAL JOIN images WHERE player_name='" . 
		$_POST['player_name'] . "' AND team='" . $_POST['team'] . "'"; //Formulates the actual query.
	$result = mysql_query($query); //Preforms the actual query.
	$row = mysql_fetch_row($result);
	$artistID = $row[0];
	$query = "SELECT * FROM players NATURAL JOIN images WHERE team='" . $artistID . "'";
	$result_image = mysql_query($query);
	// Call a function defined later in this file, with two arguments
	display_table($artistID, $result_image);
}

// When the POST protocol is invoked, checks case 2 for the data entered in the form.
// The statements executed by this conditional mimic the ones in the previous conditional block	
else if (isset($_POST['player_name']) &&
	isset($_POST['team']) &&
	$_POST['player_name'] != '' &&
	$_POST['team'] == '')
{
	$query = "SELECT * FROM players NATURAL JOIN images WHERE player_name='" . $_POST['player_name'] . "'";
	$result = mysql_query($query);
	$row = mysql_fetch_row($result);
	$artistID = $row[0];
	$query = "SELECT * FROM players NATURAL JOIN images WHERE team='" . $artistID . "'";
	$result_image = mysql_query($query);
	
	display_table($artistID, $result_image);
}

// When the POST protocol is invoked, checks case 3 for the data entered in the form.
// The statements executed by this conditional mimic the ones in the previous conditional block	
else if (isset($_POST['player_name']) &&
	isset($_POST['team']) &&
	$_POST['player_name'] == '' &&
	$_POST['team'] != '')
{
	$query = "SELECT * FROM players NATURAL JOIN images WHERE team='" . $_POST['team'] . "'";
	$result = mysql_query($query);
	$row = mysql_fetch_row($result);
	$artistID = $row[0];
	$query = "SELECT * FROM players NATURAL JOIN images WHERE team='" . $artistID . "'";
	$result_image = mysql_query($query);
	
	display_table($artistID, $result_image);
}

// HTML to display the form on this page.
echo '<br />Search the NCAA database using the fields below.';
// Sets POST as method of data submission
echo '<form action="index.php" method="post"><pre>'; 
echo 'Player Name <input type="text" name="player_name" />';
echo '<br />Team <input type="text" name="team" />';
// Creates the SEARCH button which calls the POST method with the data entered
echo '<br /><input type="submit" value="SEARCH" />'; 
echo '</pre></form>';

/** 
 * Generates HTML to render table of images returned by user query
 * 
 * An example of code reuse. This code is needed for each of our form submission cases.
 * @param string $key the name of the artist's folder
 * @param array $image_info_table a 2D array containing the data about each relevant image.
 * @return null
 */
function display_table($key, $image_info_table)
{
	echo "<TABLE><CAPTION>Your Results:</CAPTION>";
	$closed_tr = 0; // flag, used to determine if we are at the end of a row when the loop terminates
	$num_images = mysql_num_rows($image_info_table);
	
	if ($image_info_table)
	{
		// Iterate through all of the returned images, placing them in a table for easy viewing
		for ($count = 0; $count < $num_images; $count++)
		{
			// The following few lines store information from specific cells in the data about an image
			$image_row = mysql_fetch_row($image_info_table); // Advances a row each time it is called
			$image_name = $image_row[1];
			$thumb_name = $image_row[2];
			$image_path = pathinfo($image_name);
			$id_name = $image_path['filename'];
			$div_id = $id_name . "popin";

			// Accesses the information about the artist associated with the image stored previously
			$player_name = $row[0];
			$team = $row[2];
			$position = $row[4];
			
			// Remember the mod operator, this one gives us the remainder when $count is divided by 6
			if ($count % 6 == 0)
			{
				echo "<TR>";
				$closed_tr = 0;
			}
			$domain = $_SERVER['SERVER_NAME'];
			echo "<TD><img id='$id_name' src='http://$domain/students/cleurq4/images/$thumb_name' onmouseover=" . '"' . "showDetailedView('$div_id', '$id_name', '$player_name')" . '" />';
			echo "<div id = '$div_id'></div></TD>";
			if ($count % 6 == 5)
			{
				echo "</TR>";
				$closed_tr = 1;
			}
		}
	}
	if ($closed_tr == 0) echo "</TR>"; // Appends a close tag for the TR element if the loop did not terminate at a row end.
	echo "</TABLE>";
}
?>