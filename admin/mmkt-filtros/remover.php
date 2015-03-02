<?php

$Chave = "mmkt-filtros";
include("../verifica.php");
include_once("../../library/config/database/tmmktfiltro.php");

$oFiltro = new tmmktfiltro();
if($oFiltro->LoadByPrimaryKey($_GET["id"]))
{
	$oFiltro->MarkAsDelete();
	$oFiltro->Save();
	$oFiltro->SetMessage("Vermelho");
}

header("Location: index.php?" . $_SERVER["QUERY_STRING"]);
exit();

?>