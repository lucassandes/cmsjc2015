<?php

$Chave = "cac";
include("../verifica.php");
include_once("../../library/config/database/tcac.php");

$oCAC = new tcac();
if($oCAC->LoadByPrimaryKey($_GET["id"]))
{
	$oCAC2 = new tcac();
    $oCAC2->SQLOrder = "Ordem " . (($_GET["acao"] == "baixo") ? "DESC" : "ASC");
    $oCAC2->SQLWhere = "Ordem " . (($_GET["acao"] == "baixo") ? "<" : ">") . " '" . $oCAC->Ordem . "'";
    if ($oCAC2->LoadByPaginator(0, 1))
    {
    	$ordem2 = $oCAC2->Ordem;
    	$ordem = $oCAC->Ordem;
    	
        $oCAC->Ordem = $ordem2;
        $oCAC->Save();
        
		$oCAC2->Ordem = $ordem;
        $oCAC2->Save();
    }
}

header("Location: index.php?" . $_SERVER["QUERY_STRING"]);
exit();

?>