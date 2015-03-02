<?php

$Chave = "sessoes-de-3-feira";
include("../verifica.php");
include_once("../../library/config/database/tsessao.php");

$oSessao = new tsessao();
if($oSessao->LoadByPrimaryKey($_GET["id"]))
{
	$oSessao->RemoveFile("../.." . $oSessao->Arquivo);
	$oSessao->Arquivo = "";
	$oSessao->Save();
}

header("Location: novo.php?" . $_SERVER["QUERY_STRING"]);
exit();

?>