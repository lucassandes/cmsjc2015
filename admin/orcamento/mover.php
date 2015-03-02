<?php

$Chave = "orcamento";
include("../verifica.php");
include_once("../../library/config/database/torcamento.php");

$oOrcamento = new torcamento();
if($oOrcamento->LoadByPrimaryKey($_GET["id"]))
{
	$oOrcamento2 = new torcamento();
    $oOrcamento2->SQLOrder = "Ordem " . (($_GET["acao"] == "baixo") ? "DESC" : "ASC");
    $oOrcamento2->SQLWhere = "Ordem " . (($_GET["acao"] == "baixo") ? "<" : ">") . " '" . $oOrcamento->Ordem . "' AND Tipo = '" . $oOrcamento->Tipo . "'";
    if ($oOrcamento2->LoadByPaginator(0, 1))
    {
    	$ordem2 = $oOrcamento2->Ordem;
    	$ordem = $oOrcamento->Ordem;
    	
        $oOrcamento->Ordem = $ordem2;
        $oOrcamento->Save();
        
		$oOrcamento2->Ordem = $ordem;
        $oOrcamento2->Save();
    }
}

header("Location: index.php?" . $_SERVER["QUERY_STRING"]);
exit();

?>