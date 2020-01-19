<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="css/main.css">
<style>
	table{
		border-collapse: collapse;
	}
	table td, table th{
		border: 1px solid grey;
		width: 2em;
		height: 2em;
	}
	table td{
	} 
	table input{
		border: none;
		width: 100%;
		height: 100%;
		text-align: center;
		font-size: 1em;
		background-color: red;
	}
</style>
</head>
<body>
<?php

// TODO - Fix the login system to enable admin stuff
//print "<a href=\"login.html\">Login (WIP)</a><br/><br/>\n\n";

// The date is used often, so I have set this variable to not call the
// function everytime
$now = getdate();

if(
	// If date is passed in the URL, select that
	$_GET[y] and $_GET[m] and 
	// Prefer the else clause if the selected date is the same as
	// the actual date
	($_GET[y] != $now[year] or $_GET[m] != $now[mon]))
{
	$date = getdate(mktime(0, 0, 0, $_GET[m], 1, $_GET[y]));
	$date[actual] = false;
}	
else{
	$date = $now;
	$date[actual] = true;
}

$dburl = "db/" . $date[year] . "/" . $date[mon] . ".db";
$days = cal_days_in_month(CAL_GREGORIAN, $date[mon], $date[year]);

foreach($list as $fields){
	fputcsv($csv, $fields);
}

	/* Title */

print "<h1 id='title'>Productivity Matrix " . $date[month] . " " . $date[year] . "</h1>\n";

// Read the subjects file

// TODO - This is gonna be inserted in the SQLite3 DB, but for
// early development sake I'll let it be here
$stats = file("stats", FILE_IGNORE_NEW_LINES);

if(file_exists($dburl));
else{
	print "That month doesn't have a matrix to it.<br/>\n<br/>\n";
}

	/* Form */

print "\t<form method=\"post\" action=\"submit.php\" >\n";

// Hidden value to tell submit.php the month we're talking about
print "\t\t<input type=\"hidden\" name=\"date\" value=\"".$date[0]."\">";

	/* Table generation */

print "\t<table>\n\t\t<tr>\n";
print "\t\t\t<th></th>\n";

// Header
for($i = 1; $i <= $days; $i++){
	// Stay the day we're in if it is the actual month
	if($i === $date[mday] and $date[actual]){
		$today = " style=\"color:red;\" ";
	}
	else{
		$today = "";
	}
	print "\t\t\t<th" . $today . ">" . $i . "</th>\n";
}
print "\t\t</tr>\n";

// Body
foreach ($stats as $line) {
	
	// Subject
	print "\t\t<tr>\n\t\t\t<td>" . $line . "</td>\n";

	// Day Values per subject
	for($i = 1; $i <= $days; $i++){
		print "\t\t\t<td><input name=\"day[".$line."][".$i."]\" type=\"text\" maxlength=\"1\"></td>\n";
	}
	print "\t\t</tr>\n";
}
print "\t</table>\n<br/>\n";

print "<input type=\"submit\" class=\"button\">";
print "</form>\n";
?>
</body>
</html>
