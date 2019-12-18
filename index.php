<!DOCTYPE html>
<html>
<head>
<style>
	*{
		margin: 0px;
		padding: 0px;
		font-family: roboto;
	}
	body{
		padding: 20px;
	}

	table{
		border-collapse: collapse;
	}
	table td, table th{
		border: 1px solid black;
		width: 2em;
		height: 2em;
	}
	table td{
	}

	input{
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

$now = getdate();

print "<h1>Productivity Matrix " . $now[month] . " " . $now[year] . "</h1>";

# Only create the directory if it doesn't exist
if(!is_dir("db/".$now[year])){
	mkdir("db/".$now[year],0744);
	echo "Creada carpeta para el año " . $now[year] . "</br>\n";
}

$list = array(
	array("1","2","3"), #Día
	array("0","9","4") #Intensidad
);
ini_set('auto_detect_line_endings',true);

$csv = fopen("test.csv", "w");
$stats = fopen("stats", "r");

foreach($list as $fields){
	fputcsv($csv, $fields);
}

fclose($csv);

$days = cal_days_in_month(CAL_GREGORIAN, $now[mon], $now[year]);

print "<form>";
print "\t<table>\n\t\t<tr>\n";
print "\t\t\t<th></th>\n";
for($i = 1; $i <= $days; $i++){
	if($i === $now[mday]){
		$today = " style=\"color:red;\" ";
	}
	else{
		$today = "";
	}
	print "\t\t\t<th" . $today . ">" . $i . "</th>\n";
}
print "\t\t</tr>\n";
while(($line = fgets($stats)) !== false){
	print "\t\t<tr>\n\t\t\t<td>" . $line . "</td>\n";
	for($i = 1; $i <= $days; $i++){
		print "\t\t\t<td><input name=\"" . $line . "-" . $i . "-" . $now[mon] . "-" . $now[year] . "\" type=\"text\" maxlength=\"1\"></td>\n";
	}
	print "\t\t</tr>\n";
}
print "\t</table>\n";
print "</form>";
?>
</body>
