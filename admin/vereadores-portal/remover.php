<?php

$Chave = "vereadores-portal";
include("../verifica.php");
include_once("../../library/config/database/tvereadorportal.php");

$oVereador = new tvereadorportal();
if($oVereador->LoadByPrimaryKey($_GET["id"]))
{
	$oVereador->MarkAsDelete();
	$oVereador->Save();
	$oVereador->SetMessage("Vermelho");
}

header("Location: index.php?" . $_SERVER["QUERY_STRING"]);
exit();

?>