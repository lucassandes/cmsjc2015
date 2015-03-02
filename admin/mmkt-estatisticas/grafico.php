<?php

$Chave = "mmkt-estatisticas";
include("../verifica.php");
include_once("../../library/plugins/open-flash-chart/php-ofc-library/open-flash-chart.php");
include_once("../../library/config/database/tmmktenvio.php");

srand((double)microtime()*1000000);

$data = array();
$legenda = array();
$links = array();

$oEnvio = new tmmktenvio();
$oEnvio->SQLField = "*, EnvioTotalRetorno(ID) AS TotalRetorno";
$oEnvio->SQLWhere = "Enviado = 1";
$oEnvio->SQLOrder = "DataHoraEnviado DESC";
$oEnvio->SQLTotal = 20;
if($oEnvio->LoadSQLAssembled())
{
	for($c = 0; $c < $oEnvio->NumRows; $c++)
	{
		array_push($data, $oEnvio->TotalRetorno);
		array_push($legenda, $oEnvio->Assunto);
		array_push($links, "visualizar.php?id=" . $oEnvio->ID);
	
		$oEnvio->MoveNext();
	}
}

$bar = new bar(50, "#0e68be");
$bar->data = $data;
$bar->links = $links;

$g = new graph();
$g->title("Últimos 20 mmkts enviados", "{font-size: 18px; padding-bottom: 10px;}");
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