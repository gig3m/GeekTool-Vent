<?php
//geektool-vent.php
//version 1.0
//created by kyletxag and benphelps
//download at pixelsoak.com
//uses geektool to monitor vent status using ventrilostatus.net

//edit these details
//$url = "http://ventrilostatus.net/xml/server:port/";
$url = "http://ventrilostatus.net/xml/nitrogen.typefrag.com:11101/";
$show_ping_times = false;
$invert_color = true;
$space = "    ";

//don't edit below this line
$xml = file_get_contents($url);
$base = simplexml_load_string($xml);

$colors = array(
	"bold" => "\033[0;1m",
	"red" => "\033[0;31m",
	"green" => "\033[0;32m",
	"yellow" => "\033[0;33m",
	"blue" => "\033[0;34m",
	"purple" => "\033[0;35m",
	"cyan" => "\033[0;36m",
	"white" => "\033[2;97m",
	"reset" => "\033[0m"
);



//print_r($base);

function printChild($array, $depth = 0) {
	global $show_ping_times, $invert_color, $colors, $space;
	
	if ($invert_color == true){
		$base_color = $colors['white'];
		$base_reset = $colors['reset'];
	}else{
		$base_color = "";
	}
	
	foreach($array->children() as $child) {
		if ($child->getName() == "channel") {
			if ($child['prot'] == "1"){
				$protected = $colors["red"]."+ ".$colors["reset"];
			}
			else {
				$protected = $colors["blue"].'+ '.$colors["reset"];
			}
		print(str_repeat($space, $depth).$protected.$base_color.$child['name'].$base_reset." "."\n");
		}
		elseif ($child->getName() == "client") {
			if ($show_ping_times == true){
				$ping = $colors["green"]." [".$child['ping']."ms".$child['reset']."]";
			}
			else{
				$ping = '';
			}
		print(str_repeat($space, $depth).$colors["bold"]." ".$base_color.$child['name'].$base_reset.$ping."\n".$colors["reset"]);
		}
				
		printChild($child, $depth+1);

	}
	
}

printChild($base);

?>