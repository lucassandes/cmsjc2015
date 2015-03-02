<?php

$Chave = "padroes";
include("../verifica.php");
include_once("../../library/config/database/tpadrao.php");

$oPadrao = new tpadrao();
if($oPadrao->LoadByPrimaryKey($_GET["id"]))
{
	$oPadrao->MarkAsDelete();
	$oPadrao->Save();
	$oPadrao->SetMessage("Vermelho");
}

header("Location: index.php?" . $_SERVER["QUERY_STRING"]);
exit();

?>