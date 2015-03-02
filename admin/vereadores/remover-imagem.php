<?php

$Chave = "vereadores";
include("../verifica.php");
include_once("../../library/config/database/tvereador.php");

$oVereador = new tvereador();
if($oVereador->LoadByPrimaryKey($_GET["id"]))
{
	$oVereador->RemoveFile("../.." . $oVereador->Imagem);
	$oVereador->Imagem = "";
	$oVereador->Save();
}

header("Location: novo.php?" . $_SERVER["QUERY_STRING"]);
exit();

?>