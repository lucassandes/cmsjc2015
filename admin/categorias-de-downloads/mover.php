<?php

$Chave = "categorias-de-downloads";
include("../verifica.php");
include_once("../../library/config/database/tcategoriadownload.php");

$oCategoriaDownload = new tcategoriadownload();
if($oCategoriaDownload->LoadByPrimaryKey($_GET["id"]))
{
	$oCategoriaDownload2 = new tcategoriadownload();
    $oCategoriaDownload2->SQLOrder = "Ordem " . (($_GET["acao"] == "baixo") ? "DESC" : "ASC");
    $oCategoriaDownload2->SQLWhere = "Ordem " . (($_GET["acao"] == "baixo") ? "<" : ">") . " '" . $oCategoriaDownload->Ordem . "'";
    if ($oCategoriaDownload2->LoadByPaginator(0, 1))
    {
    	$ordem2 = $oCategoriaDownload2->Ordem;
    	$ordem = $oCategoriaDownload->Ordem;
    	
        $oCategoriaDownload->Ordem = $ordem2;
        $oCategoriaDownload->Save();
        
		$oCategoriaDownload2->Ordem = $ordem;
        $oCategoriaDownload2->Save();
    }
}

header("Location: index.php?" . $_SERVER["QUERY_STRING"]);
exit();

?>