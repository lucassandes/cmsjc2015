<?php

$Chave = "vereadores-externo";
include("../verifica.php");
include_once("../../library/config/database/tvereadorexterno.php");

$oVereadorExterno = new tvereadorexterno();
if($oVereadorExterno->LoadByPrimaryKey($_GET["id"]))
{
	$oVereadorExterno->MarkAsDelete();
	$oVereadorExterno->Save();
	$oVereadorExterno->SetMessage("Vermelho");
}

header("Location: index.php?" . $_SERVER["QUERY_STRING"]);
exit();

?>