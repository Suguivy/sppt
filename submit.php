<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="css/main.css">
</head>
<body>

<?php

include("include/db-utils.php");

if(!$_POST["date"]){
	echo "Date not specified.";
	return;
}

$date = getdate($_POST["date"]);
$db_path = date_to_path($date["year"], $date["month"]);

	/* Title */

echo "<div id='title'>";
echo "<h1>Submitting petition for " . $date["month"] . " " . $date["year"] . "</h1>\n";
echo "<p>File: " . $db_path .  "<p>";
echo "</div>";

	/* Logic */

$empty_petition = true;
$init_db = false;

// Foreach with a $i counter instead of a for with $i because it
// looks far cleaner
foreach($_POST[day] as $category){
	$empty_row = true;
	$i = 0;
	foreach($category as $value){
		if($value){ // Test if it is empty
			echo $i . " - " . $value . " | ";

			// This will run only the first
			// time. The value isn't empty
			// but the empty flag is not set.
			if($empty_petition){
				$init_db = !file_exists($db_path);
			}
			$empty_petition = false;
			$empty_row = false;
		}
		$i++;
	}
	if(!$empty_row){
		echo "\n<br/>";
	}
}

if($empty_petition) echo "No changes were made";
if($init_db) echo "Database didn't, exist. It has been created now.";

?>

</body>
</html>
