<?php

$Chave = "administradores";
include("../verifica.php");
include_once("../../library/config/database/tadministrador.php");

$oAdministrador = new tadministrador();
if($oAdministrador->LoadByPrimaryKey($_GET["id"]))
{
	$oAdministrador->MarkAsDelete();
	$oAdministrador->Save();
	$oAdministrador->SetMessage("Vermelho");
}

header("Location: index.php?" . $_SERVER["QUERY_STRING"]);
exit();

?>