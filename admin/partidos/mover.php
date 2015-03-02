<?php

$Chave = "partidos";
include("../verifica.php");
include_once("../../library/config/database/tpartido.php");

$oPartido = new tpartido();
if($oPartido->LoadByPrimaryKey($_GET["id"]))
{
	$oPartido2 = new tpartido();
    $oPartido2->SQLOrder = "Ordem " . (($_GET["acao"] == "baixo") ? "DESC" : "ASC");
    $oPartido2->SQLWhere = "Ordem " . (($_GET["acao"] == "baixo") ? "<" : ">") . " '" . $oPartido->Ordem . "'";
    if ($oPartido2->LoadByPaginator(0, 1))
    {
    	$ordem2 = $oPartido2->Ordem;
    	$ordem = $oPartido->Ordem;
    	
        $oPartido->Ordem = $ordem2;
        $oPartido->Save();
        
		$oPartido2->Ordem = $ordem;
        $oPartido2->Save();
    }
}

header("Location: index.php?" . $_SERVER["QUERY_STRING"]);
exit();

?>