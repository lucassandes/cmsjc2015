<?php

$Chave = "timeline";
include("../verifica.php");
include_once("../../library/config/database/ttimeline.php");
include_once("../../library/config/database/ttimelinepresidente.php");

$oTimeline = new ttimeline();
if($oTimeline->LoadByPrimaryKey($_GET["id"]))
{
	$oTimelineArquivo = new ttimelinepresidente();
	$oTimelineArquivo->RemoveFileByTimelineID($oTimeline->ID);
	
	$oTimeline->RemoveFile("../.." . $oTimeline->Imagem);
	$oTimeline->MarkAsDelete();
	$oTimeline->Save();
	$oTimeline->SetMessage("Vermelho");
}

header("Location: index.php?" . $_SERVER["QUERY_STRING"]);
exit();

?>