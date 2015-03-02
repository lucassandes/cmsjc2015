<?php

$Chave = "noticias";
include("../verifica.php");
include_once("../../library/config/database/tnoticia.php");
include_once("../../library/config/database/tnoticiaarquivo.php");

$oNoticia = new tnoticia();
if($oNoticia->LoadByPrimaryKey($_GET["id"]))
{
	$oNoticiaArquivo = new tnoticiaarquivo();
	$oNoticiaArquivo->RemoveFileByNoticiaID($oNoticia->ID);
	
	$oNoticia->RemoveFile("../.." . $oNoticia->Imagem);
	$oNoticia->RemoveFile("../.." . $oNoticia->ImagemDestaque);
	$oNoticia->RemoveFile("../.." . $oNoticia->ImagemDestaque2);
	$oNoticia->RemoveFile("../.." . $oNoticia->Audio);
	$oNoticia->MarkAsDelete();
	$oNoticia->Save();
	$oNoticia->SetMessage("Vermelho");
}

header("Location: index.php?" . $_SERVER["QUERY_STRING"]);
exit();

?>