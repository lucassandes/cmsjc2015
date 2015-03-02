<?php

$Chave = "downloads";
include("../verifica.php");
include_once("../../library/config/database/tdownload.php");

$oDownload = new tdownload();
if($oDownload->LoadByPrimaryKey($_GET["id"]))
{
	$oDownload2 = new tdownload();
    $oDownload2->SQLOrder = "Ordem " . (($_GET["acao"] == "baixo") ? "DESC" : "ASC");
    $oDownload2->SQLWhere = "Ordem " . (($_GET["acao"] == "baixo") ? "<" : ">") . " '" . $oDownload->Ordem . "' AND CategoriaDownloadID = '" . $oDownload->CategoriaDownloadID . "'";
    if ($oDownload2->LoadByPaginator(0, 1))
    {
    	$ordem2 = $oDownload2->Ordem;
    	$ordem = $oDownload->Ordem;
    	
        $oDownload->Ordem = $ordem2;
        $oDownload->Save();
        
		$oDownload2->Ordem = $ordem;
        $oDownload2->Save();
    }
}

header("Location: index.php?" . $_SERVER["QUERY_STRING"]);
exit();

?>