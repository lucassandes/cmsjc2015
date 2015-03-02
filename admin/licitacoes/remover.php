<?php

$Chave = "licitacoes";
include("../verifica.php");
include_once("../../library/config/database/tlicitacao.php");
include_once("../../library/config/database/tlicitacaoarquivo.php");

$oLicitacao = new tlicitacao();
if($oLicitacao->LoadByPrimaryKey($_GET["id"]))
{
	$oLicitacaoArquivo = new tlicitacaoarquivo();
	$oLicitacaoArquivo->RemoveFileByLicitacaoID($oLicitacao->ID);
	
	$oLicitacao->MarkAsDelete();
	$oLicitacao->Save();
	$oLicitacao->SetMessage("Vermelho");
}

header("Location: index.php?" . $_SERVER["QUERY_STRING"]);
exit();

?>