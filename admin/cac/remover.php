<?php

$Chave = "cac";
include("../verifica.php");
include_once("../../library/config/database/tcac.php");

$oCAC = new tcac();
if($oCAC->LoadByPrimaryKey($_GET["id"]))
{
	$oCAC->MarkAsDelete();
	$oCAC->Save();
	$oCAC->SetMessage("Vermelho");
}

header("Location: index.php?" . $_SERVER["QUERY_STRING"]);
exit();

?>