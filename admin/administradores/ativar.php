<?php

$Chave = "administradores";
include("../verifica.php");
include_once("../../library/config/database/tadministrador.php");

$oAdministrador = new tadministrador();
if($oAdministrador->LoadByPrimaryKey($_GET["id"]))
{
	$oAdministrador->Ativo = intval(!$oAdministrador->Ativo);
	$oAdministrador->Save();
}

header("Location: index.php?" . $_SERVER["QUERY_STRING"]);
exit();

?>