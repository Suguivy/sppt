<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="css/main.css">
<style>
	body{
		padding: 20px;
	}

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

print "<a href=\"login.html\">Login (WIP)</a><br/><br/>\n\n";

# Only create the directory if it doesn't exist
/*if(!is_dir("db/".$date[year])){
	mkdir("db/".$date[year],0744);
	echo "Creada carpeta para el año " . $date[year] . "</br>\n";
}*/

/*
$list = array(
	array("1","2","3"), #Día
	array("0","9","4") #Intensidad
);
*/

if($_GET[y] and $_GET[m]){
	$date = getdate(mktime(0, 0, 0, $_GET[m], 1, $_GET[y]));
	$date[actual] = false;
}	
else{
	$date = getdate();
	$date[actual] = true;
}

$dburl = "db/" . $date[year] . "/" . $date[mon] . ".csv";
$days = cal_days_in_month(CAL_GREGORIAN, $date[mon], $date[year]);

foreach($list as $fields){
	fputcsv($csv, $fields);
}

if(file_exists($dburl)) $csv = fopen($dburl, "w");
else{
	print "That month doesn't have a matrix to it.<br/>\n";
}

print "<h1>Productivity Matrix " . $date[month] . " " . $date[year] . "</h1>";


fclose($csv);

$stats = file("stats", FILE_IGNORE_NEW_LINES);

print "\t<form>\n";
print "\t\t<input type=\"hidden\" name=\"year\" value=\"".$date[year]."\">";
print "\t<table>\n\t\t<tr>\n";
print "\t\t\t<th></th>\n";
for($i = 1; $i <= $days; $i++){
	if($i === $date[mday] and $date[actual]){
		$today = " style=\"color:red;\" ";
	}
	else{
		$today = "";
	}
	print "\t\t\t<th" . $today . ">" . $i . "</th>\n";
}
print "\t\t</tr>\n";
foreach ($stats as $line) {
	print "\t\t<tr>\n\t\t\t<td>" . $line . "</td>\n";
	for($i = 1; $i <= $days; $i++){
		print "\t\t\t<td><input name=\"day[".$i."][".$line."]\" type=\"text\" maxlength=\"1\"></td>\n";
	}
	print "\t\t</tr>\n";
}
print "\t</table>\n";
print "\t<p>File: " .  $dburl . "</p>";
print "\n<br/>\n";
print "<input type=\"submit\">";
print "</form>\n";
?>
</body>
