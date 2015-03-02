<?php

$Chave = "categorias-de-links";
include("../verifica.php");
include_once("../../library/config/database/tcategorialink.php");

$oCategoriaLink = new tcategorialink();
if($oCategoriaLink->LoadByPrimaryKey($_GET["id"]))
{
	$oCategoriaLink2 = new tcategorialink();
    $oCategoriaLink2->SQLOrder = "Ordem " . (($_GET["acao"] == "baixo") ? "DESC" : "ASC");
    $oCategoriaLink2->SQLWhere = "Ordem " . (($_GET["acao"] == "baixo") ? "<" : ">") . " '" . $oCategoriaLink->Ordem . "'";
    if ($oCategoriaLink2->LoadByPaginator(0, 1))
    {
    	$ordem2 = $oCategoriaLink2->Ordem;
    	$ordem = $oCategoriaLink->Ordem;
    	
        $oCategoriaLink->Ordem = $ordem2;
        $oCategoriaLink->Save();
        
		$oCategoriaLink2->Ordem = $ordem;
        $oCategoriaLink2->Save();
    }
}

header("Location: index.php?" . $_SERVER["QUERY_STRING"]);
exit();

?>