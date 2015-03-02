<?php

$Chave = "categorias-de-downloads";
include("../verifica.php");
include_once("../../library/config/database/tcategoriadownload.php");

$oCategoriaDownload = new tcategoriadownload();
if($oCategoriaDownload->LoadByPrimaryKey($_GET["id"]))
{
	$oCategoriaDownload->MarkAsDelete();
	$oCategoriaDownload->Save();
	$oCategoriaDownload->SetMessage("Vermelho");
}

header("Location: index.php?" . $_SERVER["QUERY_STRING"]);
exit();

?>