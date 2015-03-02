<?php

$Chave = "impostoderenda";
include("../verifica.php");
include_once("../../library/config/database/timpostoderenda.php");

$oImpostoRenda = new timpostoderenda();
if($oImpostoRenda->LoadByPrimaryKey($_GET["id"]))
{
	$oImpostoRenda->MarkAsDelete();
	$oImpostoRenda->Save();
	$oImpostoRenda->SetMessage("Vermelho");
}

header("Location: index.php?" . $_SERVER["QUERY_STRING"]);
exit();

?>