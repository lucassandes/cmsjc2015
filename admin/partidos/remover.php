<?php

$Chave = "partidos";
include("../verifica.php");
include_once("../../library/config/database/tpartido.php");

$oPartido = new tpartido();
if($oPartido->LoadByPrimaryKey($_GET["id"]))
{
	$oPartido->MarkAsDelete();
	$oPartido->Save();
	$oPartido->SetMessage("Vermelho");
}

header("Location: index.php?" . $_SERVER["QUERY_STRING"]);
exit();

?>