<?php

// HTML to display the form on this page.
echo '<br />Search the art database using the fields below.';
// Sets POST as method of data submission
echo '<form action="222indexA.php" method="post"><pre>'; 
echo 'First Name <input type="text" name="firstname" />';
echo '<br />Last Name <input type="text" name="lastname" />';
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
	
	if ($image_info_table)
	{
		// Iterate through all of the returned images, placing them in a table for easy viewing
		for ($count = 0; $count < mysql_num_rows($image_info_table); $count++)
		{
			// The following few lines store information from specific cells in the data about an image
			$image_row = mysql_fetch_row($image_info_table); // Advances a row each time it is called
			$image_name = $image_row[1];
			$thumb_name = $image_row[2];
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
			echo "<TD><img src='http://$domain/$key/$thumb_name' /></TD>";
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