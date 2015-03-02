<?php

$Chave = "orcamento";
include("../verifica.php");
include_once("../../library/config/database/torcamento.php");

$oOrcamento = new torcamento();
if($oOrcamento->LoadByPrimaryKey($_GET["id"]))
{
	$oOrcamento->RemoveFile("../.." . $oOrcamento->Arquivo);
	$oOrcamento->MarkAsDelete();
	$oOrcamento->Save();
	$oOrcamento->SetMessage("Vermelho");
}

header("Location: index.php?" . $_SERVER["QUERY_STRING"]);
exit();

?>