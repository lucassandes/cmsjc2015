<?php

$Chave = "cargos";
include("../verifica.php");
include_once("../../library/config/database/tcargo.php");

$oCargo = new tcargo();
if($oCargo->LoadByPrimaryKey($_GET["id"]))
{
	$oCargo->MarkAsDelete();
	$oCargo->Save();
	$oCargo->SetMessage("Vermelho");
}

header("Location: index.php?" . $_SERVER["QUERY_STRING"]);
exit();

?>