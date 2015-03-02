<?php

$Chave = "links";
include("../verifica.php");
include_once("../../library/config/database/tlink.php");

$oLink = new tlink();
if($oLink->LoadByPrimaryKey($_GET["id"]))
{
	$oLink2 = new tlink();
    $oLink2->SQLOrder = "Ordem " . (($_GET["acao"] == "baixo") ? "DESC" : "ASC");
    $oLink2->SQLWhere = "Ordem " . (($_GET["acao"] == "baixo") ? "<" : ">") . " '" . $oLink->Ordem . "' AND CategoriaLinkID = '" . $oLink->CategoriaLinkID . "'";
    if ($oLink2->LoadByPaginator(0, 1))
    {
    	$ordem2 = $oLink2->Ordem;
    	$ordem = $oLink->Ordem;
    	
        $oLink->Ordem = $ordem2;
        $oLink->Save();
        
		$oLink2->Ordem = $ordem;
        $oLink2->Save();
    }
}

header("Location: index.php?" . $_SERVER["QUERY_STRING"]);
exit();

?>