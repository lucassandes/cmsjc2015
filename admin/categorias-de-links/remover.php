<?php

$Chave = "categorias-de-links";
include("../verifica.php");
include_once("../../library/config/database/tcategorialink.php");

$oCategoriaLink = new tcategorialink();
if($oCategoriaLink->LoadByPrimaryKey($_GET["id"]))
{
	$oCategoriaLink->MarkAsDelete();
	$oCategoriaLink->Save();
	$oCategoriaLink->SetMessage("Vermelho");
}

header("Location: index.php?" . $_SERVER["QUERY_STRING"]);
exit();

?>