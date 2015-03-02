<?php

$Chave = "eventos";
include("../verifica.php");
include_once("../../library/config/database/tevento.php");

$oEvento = new tevento();
if($oEvento->LoadByPrimaryKey($_GET["id"]))
{
	$oEvento->MarkAsDelete();
	$oEvento->Save();
	$oEvento->SetMessage("Vermelho");
}

header("Location: index.php?" . $_SERVER["QUERY_STRING"]);
exit();

?>