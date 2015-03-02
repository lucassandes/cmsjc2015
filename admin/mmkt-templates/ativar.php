<?php

$Chave = "mmkt-templates";
include("../verifica.php");
include_once("../../library/config/database/tmmkttemplate.php");

$oTemplate = new tmmkttemplate();
if($oTemplate->LoadByPrimaryKey($_GET["id"]))
{
	$oTemplate->Ativo = intval(!$oTemplate->Ativo);
	$oTemplate->Save();
}

header("Location: index.php?" . $_SERVER["QUERY_STRING"]);
exit();

?>