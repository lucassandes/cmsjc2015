<?php

$Chave = "licitacoes";
include("../verifica.php");
include_once("../../library/config/database/tlicitacao.php");

$oLicitacao = new tlicitacao();
if($oLicitacao->LoadByPrimaryKey($_GET["id"]))
{
	$oLicitacao2 = new tlicitacao();
    $oLicitacao2->SQLOrder = "Ordem " . (($_GET["acao"] == "baixo") ? "DESC" : "ASC");
    $oLicitacao2->SQLWhere = "Ordem " . (($_GET["acao"] == "baixo") ? "<" : ">") . " '" . $oLicitacao->Ordem . "' AND Status = '" . $oLicitacao->Status . "'";
    if($oLicitacao2->LoadByPaginator(0, 1))
    {
    	$ordem2 = $oLicitacao2->Ordem;
    	$ordem = $oLicitacao->Ordem;
    	
        $oLicitacao->Ordem = $ordem2;
        $oLicitacao->Save();
        
		$oLicitacao2->Ordem = $ordem;
        $oLicitacao2->Save();
    }
}

header("Location: index.php?" . $_SERVER["QUERY_STRING"]);
exit();

?>