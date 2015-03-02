<?php

$Chave = "sessoes-solenes-e-homenagens";
include("../verifica.php");
include_once("../../library/config/database/tsessao.php");

$oSessao = new tsessao();
if($oSessao->LoadByPrimaryKey($_GET["id"]))
{
	$oSessao->RemoveFile("../.." . $oSessao->Imagem);
	$oSessao->RemoveFile("../.." . $oSessao->Arquivo);
	$oSessao->MarkAsDelete();
	$oSessao->Save();
	$oSessao->SetMessage("Vermelho");
}

header("Location: index.php?" . $_SERVER["QUERY_STRING"]);
exit();

?>