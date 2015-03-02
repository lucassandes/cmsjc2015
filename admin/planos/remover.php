<?php

$Chave = "planos";
include("../verifica.php");
include_once("../../library/config/database/tplano.php");

$oPlano = new tplano();
if($oPlano->LoadByPrimaryKey($_GET["id"]))
{
	$oPlano->MarkAsDelete();
	$oPlano->Save();
	$oPlano->SetMessage("Vermelho");
}

header("Location: index.php?" . $_SERVER["QUERY_STRING"]);
exit();

?>