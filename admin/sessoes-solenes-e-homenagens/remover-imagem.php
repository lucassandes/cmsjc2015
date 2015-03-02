<?php

$Chave = "sessoes-solenes-e-homenagens";
include("../verifica.php");
include_once("../../library/config/database/tsessao.php");

$oSessao = new tsessao();
if($oSessao->LoadByPrimaryKey($_GET["id"]))
{
	$oSessao->RemoveFile("../.." . $oSessao->Imagem);
	$oSessao->Imagem = "";
	$oSessao->Save();
}

header("Location: novo.php?" . $_SERVER["QUERY_STRING"]);
exit();

?>