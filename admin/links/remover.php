<?php

$Chave = "links";
include("../verifica.php");
include_once("../../library/config/database/tlink.php");

$oLink = new tlink();
if($oLink->LoadByPrimaryKey($_GET["id"]))
{
	$oLink->MarkAsDelete();
	$oLink->Save();
	$oLink->SetMessage("Vermelho");
}

header("Location: index.php?" . $_SERVER["QUERY_STRING"]);
exit();

?>