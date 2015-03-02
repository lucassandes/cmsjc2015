<?php

$Chave = "comissoes";
include("../verifica.php");
include_once("../../library/config/database/tcomissao.php");

$oComissao = new tcomissao();
if($oComissao->LoadByPrimaryKey($_GET["id"]))
{
	$oComissao2 = new tcomissao();
    $oComissao2->SQLOrder = "Ordem " . (($_GET["acao"] == "baixo") ? "DESC" : "ASC");
    $oComissao2->SQLWhere = "Ordem " . (($_GET["acao"] == "baixo") ? "<" : ">") . " '" . $oComissao->Ordem . "' AND Tipo = '" . $oComissao->Tipo . "'";
    if ($oComissao2->LoadByPaginator(0, 1))
    {
    	$ordem2 = $oComissao2->Ordem;
    	$ordem = $oComissao->Ordem;
    	
        $oComissao->Ordem = $ordem2;
        $oComissao->Save();
        
		$oComissao2->Ordem = $ordem;
        $oComissao2->Save();
    }
}

header("Location: index.php?" . $_SERVER["QUERY_STRING"]);
exit();

?>