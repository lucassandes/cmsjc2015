<?php

$Chave = "vereadores-externo";
include("../verifica.php");
include_once("../../library/config/database/tvereadorexterno.php");

$oVereadorExterno = new tvereadorexterno();
if($oVereadorExterno->LoadByPrimaryKey($_GET["id"]))
{
	$oVereadorExterno2 = new tvereadorexterno();
    $oVereadorExterno2->SQLOrder = "Ordem " . (($_GET["acao"] == "baixo") ? "DESC" : "ASC");
    $oVereadorExterno2->SQLWhere = "Ordem " . (($_GET["acao"] == "baixo") ? "<" : ">") . " '" . $oVereadorExterno->Ordem . "'";
    if ($oVereadorExterno2->LoadByPaginator(0, 1))
    {
    	$ordem2 = $oVereadorExterno2->Ordem;
    	$ordem = $oVereadorExterno->Ordem;
    	
        $oVereadorExterno->Ordem = $ordem2;
        $oVereadorExterno->Save();
        
		$oVereadorExterno2->Ordem = $ordem;
        $oVereadorExterno2->Save();
    }
}

header("Location: index.php?" . $_SERVER["QUERY_STRING"]);
exit();

?>