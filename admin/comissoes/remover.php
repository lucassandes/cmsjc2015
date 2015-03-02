<?php

$Chave = "comissoes";
include("../verifica.php");
include_once("../../library/config/database/tcomissao.php");

$oComissao = new tcomissao();
if($oComissao->LoadByPrimaryKey($_GET["id"]))
{
	$oComissao->MarkAsDelete();
	$oComissao->Save();
	$oComissao->SetMessage("Vermelho");
}

header("Location: index.php?" . $_SERVER["QUERY_STRING"]);
exit();

?>