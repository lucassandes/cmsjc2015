<?php

include("verifica.php");
include_once("../../library/plugins/open-flash-chart/php-ofc-library/open-flash-chart.php");

$reportGrafico = $oGoogleAnalytics->Report(
	array
	(
		"dimensions" => "ga:date",
		"metrics" => "ga:visits",
		"sort" => "ga:date"
	)
);

$data = array();
$legenda = array();
if($reportGrafico)
{
	foreach($reportGrafico as $c => $v)
	{
		array_push($data, $v["ga:visits"]);
		array_push($legenda, date("d/m/Y", strtotime($c)));
	}
}

srand((double)microtime()*1000000);

$g = new graph();
$g->title("Visitas", "{padding-bottom:5px; font-size:18px}");
$g->bg_colour = "#FFFFFF";
$g->set_data($data);
$g->area_hollow(2, 5, 25, "#0e68be");
$g->set_tool_tip("Visitas: #val#<br>Data: #x_label#");
$g->set_x_labels($legenda);
$g->set_x_label_style(10, "#5b5b5b", 0, ceil(count($data) / 5));
$g->x_axis_colour("#eeeeee", "#eeeeee");
$g->set_y_max(max($data));
$g->y_axis_colour("#eeeeee", "#eeeeee");
$g->y_label_steps(5);
$g->set_num_decimals(0);  
echo $g->render();

?>