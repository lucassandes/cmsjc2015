<?php

$Chave = "exploracao-mineraria";
include("../verifica.php");
include_once("../../library/config/database/texploracaomineraria.php");
include_once("../../library/config/database/texploracaominerariaarquivo.php");

$oExploracaoMineraria = new texploracaomineraria();
if($oExploracaoMineraria->LoadByPrimaryKey($_GET["id"]))
{
	$oExploracaoMinerariaArquivo = new texploracaominerariaarquivo();
	$oExploracaoMinerariaArquivo->RemoveFileByExploracaoMinerariaID($oExploracaoMineraria->ID);
	
	$oExploracaoMineraria->MarkAsDelete();
	$oExploracaoMineraria->Save();
	$oExploracaoMineraria->SetMessage("Vermelho");
}

header("Location: index.php?" . $_SERVER["QUERY_STRING"]);
exit();

?>