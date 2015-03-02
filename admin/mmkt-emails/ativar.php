<?php

$Chave = "mmkt-emails";
include("../verifica.php");
include_once("../../library/config/database/tmmktemail.php");

$oEmail = new tmmktemail();
if($oEmail->LoadByPrimaryKey($_GET["id"]))
{
	$oEmail->Ativo = intval(!$oEmail->Ativo);
	$oEmail->Save();
}

header("Location: index.php?" . $_SERVER["QUERY_STRING"]);
exit();

?>