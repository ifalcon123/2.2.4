<?php
/**
*Test file by Trevor Lutjen
*This File is the main code that runs the site. Near the bottom of the page you will find HTML and some CSS.
*Recreation of the PHP found in this same directory "index.php"
*Copyright Trevor Lutjen 2014
*For CSE Hour 3 Clevenger's class
*Version 0.01
**/

// access the login.php file which allows the program to log-in to the Database that contains the 
require_once 'login.php'
$db_server = mysql_connect($db_hostname, $db_username, $db_password);
if (!$db_server) die("Unable to connect to MySQL: " mysql_error()); // If cannot connect display the message in quotations.
mysql_select_db($db_database) // direct towards database
	or die("unable to connect to database: " . mysql_error()); //  or kill the attempt to connect.


echo "<script type='text/javascript' src='222popouts.js'></script>";
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
if (isset($_POST['player_input']) &&
	isset($_POST['team_input']) &&
	$_POST['player_input'] != '' &&
	$_POST['team_input'] != '')
{
	// Gathers the information provided in the form with the POST protocol
	// creates and submits MySQL queries using it, explained in 2.2.3
	$query = "SELECT * FROM players WHERE player_input='" . 
		$_POST['player_input'] . "' AND team_input='" . $_POST['team_input'] . "'";
	$result = mysql_query($query);
	$row = mysql_fetch_row($result);
	$resultID = $row[0];
	$query = "SELECT * FROM images WHERE player_input='" . $artistID . "'";
	$result_image = mysql_query($query);
	// Call a function defined later in this file, with two arguments
	display_table($resultID, $result_image);
}

// When the POST protocol is invoked, checks case 2 for the data entered in the form.
// The statements executed by this conditional mimic the ones in the previous conditional block	
else if (isset($_POST['player_input']) &&
	isset($_POST['team_input']) &&
	$_POST['player_input'] != '' &&
	$_POST['team_input'] == '')
{
	$query = "SELECT * FROM players WHERE player_input='" . $_POST['player_input'] . "'";
	$result = mysql_query($query);
	$row = mysql_fetch_row($result);
	$resultID = $row[0];
	$query = "SELECT * FROM images WHERE player_input='" . $artistID . "'";
	$result_image = mysql_query($query);
	display_table($resultID, $result_image);
}

// When the POST protocol is invoked, checks case 3 for the data entered in the form.
// The statements executed by this conditional mimic the ones in the previous conditional block	
else if (isset($_POST['player_input']) &&
	isset($_POST['team_input']) &&
	$_POST['player_input'] == '' &&
	$_POST['team_input'] != '')
{
	$query = "SELECT * FROM players WHERE player_input='" . $_POST['team_input'] . "'";
	$result = mysql_query($query);
	$row = mysql_fetch_row($result);
	$resultID = $row[0];
	$query = "SELECT * FROM images WHERE player_input='" . $resultID . "'";
	$result_image = mysql_query($query);
	display_table($resultID, $result_image);
}

// HTML to display the form on this page.
echo '<br />Search the NCAA database using the fields below.';
// Sets POST as method of data submission
echo '<form action="index_recreate.php" method="post"><pre>'; 
echo 'player name <input type="text" name="player_input" />';
echo '<br />Team name <input type="text" name="team_input" />';
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
			$firstname = $row[2];
			$lastname = $row[3];
			// Remember the mod operator, this one gives us the remainder when $count is divided by 6
			if ($count % 6 == 0)
			{
				echo "<TR>";
				$closed_tr = 0;
			}
			$domain = $_SERVER['SERVER_NAME'];
			echo "<TD><img id='$id_name' src='http://$domain/$key/$thumb_name' onmouseover=" . '"' . "showDetailedView('$div_id', '$id_name', '$player_input')" . '" />';
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