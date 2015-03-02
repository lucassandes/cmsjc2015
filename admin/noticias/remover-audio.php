<?php

$Chave = "noticias";
include("../verifica.php");
include_once("../../library/config/database/tnoticia.php");

$oNoticia = new tnoticia();
if($oNoticia->LoadByPrimaryKey($_GET["id"]))
{
	$oNoticia->RemoveFile("../.." . $oNoticia->Audio);
	$oNoticia->Audio = null;
	$oNoticia->Save();
}

header("Location: novo.php?" . $_SERVER["QUERY_STRING"]);
exit();

?>