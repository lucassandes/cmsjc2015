<?php

$Chave = "setores-da-camara";
include("../verifica.php");
include_once("../../library/config/database/tsetor.php");

$oSetor = new tsetor();
if($oSetor->LoadByPrimaryKey($_GET["id"]))
{
	$oSetor->MarkAsDelete();
	$oSetor->Save();
	$oSetor->SetMessage("Vermelho");
}

header("Location: index.php?" . $_SERVER["QUERY_STRING"]);
exit();

?>