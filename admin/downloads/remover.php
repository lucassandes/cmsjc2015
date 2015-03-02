<?php

$Chave = "downloads";
include("../verifica.php");
include_once("../../library/config/database/tdownload.php");

$oDownload = new tdownload();
if($oDownload->LoadByPrimaryKey($_GET["id"]))
{
	$oDownload->RemoveFile("../.." . $oDownload->Arquivo);
	$oDownload->RemoveFile("../.." . $oDownload->Imagem);
	$oDownload->MarkAsDelete();
	$oDownload->Save();
	$oDownload->SetMessage("Vermelho");
}

header("Location: index.php?" . $_SERVER["QUERY_STRING"]);
exit();

?>