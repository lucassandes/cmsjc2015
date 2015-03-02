<?php

$Chave = "vereadores";
include("../verifica.php");
include_once("../../library/config/database/tvereador.php");

$oVereador = new tvereador();
if($oVereador->LoadByPrimaryKey($_GET["id"]))
{
	$oVereador2 = new tvereador();
    $oVereador2->SQLOrder = "Ordem " . (($_GET["acao"] == "baixo") ? "DESC" : "ASC");
    $oVereador2->SQLWhere = "Ordem " . (($_GET["acao"] == "baixo") ? "<" : ">") . " '" . $oVereador->Ordem . "'";
    if ($oVereador2->LoadByPaginator(0, 1))
    {
    	$ordem2 = $oVereador2->Ordem;
    	$ordem = $oVereador->Ordem;
    	
        $oVereador->Ordem = $ordem2;
        $oVereador->Save();
        
		$oVereador2->Ordem = $ordem;
        $oVereador2->Save();
    }
}

header("Location: index.php?" . $_SERVER["QUERY_STRING"]);
exit();

?>