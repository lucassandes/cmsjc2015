<?php

$Chave = "vereadores";
include("../verifica.php");
include_once("../../library/config/database/tvereador.php");

$oVereador = new tvereador();
if($oVereador->LoadByPrimaryKey($_GET["id"]))
{
	$oVereador->RemoveFile("../.." . $oVereador->Imagem);
	$oVereador->MarkAsDelete();
	$oVereador->Save();
	$oVereador->SetMessage("Vermelho");
}

header("Location: index.php?" . $_SERVER["QUERY_STRING"]);
exit();

?>