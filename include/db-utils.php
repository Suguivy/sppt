<?php

function date_to_path($year, $month){
	return "db/" . $year . "/" . strtolower($month) . ".db";
}



?>
