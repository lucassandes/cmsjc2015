<?php

$Chave = "mmkt-estatisticas";
include("../verifica.php");
include_once("../../library/plugins/open-flash-chart/php-ofc-library/open-flash-chart.php");
include_once("../../library/config/database/tmmktenvio.php");
include_once("../../library/config/database/tmmktretorno.php");

srand((double)microtime()*1000000);

$data = array();
$legenda = array();

$oEnvio = new tmmktenvio();
if($oEnvio->LoadByPrimaryKey($_GET["id"]))
{
	$oRetorno = new tmmktretorno();
	$oRetorno->SQLField = "*, SUM(Quantidade) AS Quantidade";
	$oRetorno->SQLGroup = "Campanha";
	if($oRetorno->LoadByEnvioID($oEnvio->ID))
	{
		for($c = 0; $c < $oRetorno->NumRows; $c++)
		{
			array_push($data, $oRetorno->Quantidade);
			array_push($legenda, $oRetorno->Campanha);
			
			$oRetorno->MoveNext();
		}
	}
}

$bar = new bar(50, "#0e68be");
$bar->data = $data;

$g = new graph();
$g->title($oEnvio->Assunto, "{font-size: 18px; padding-bottom: 10px;}");
$g->set_tool_tip("#x_label#<br>#val# cliques");
$g->bg_colour = "#FFFFFF";
$g->data_sets[] = $bar;
$g->set_x_labels($legenda);
$g->set_x_label_style(11, "#5b5b5b", 1);
$g->x_axis_colour("#eeeeee", "#eeeeee");
$g->set_y_max(max($data));
$g->y_axis_colour("#eeeeee", "#eeeeee");
$g->y_label_steps(5);
$g->set_num_decimals(0); 
echo $g->render();

?>