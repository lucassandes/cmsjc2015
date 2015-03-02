<?php

$Chave = "downloads";
include("../verifica.php");
include_once("../../library/config/database/tdownload.php");

$oDownload = new tdownload();
if($oDownload->LoadByPrimaryKey($_GET["id"]))
{
	$oDownload->RemoveFile("../.." . $oDownload->Imagem);
	$oDownload->Imagem = "";
	$oDownload->Save();
}

header("Location: novo.php?" . $_SERVER["QUERY_STRING"]);
exit();

?>