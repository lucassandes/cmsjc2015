<?php

$Chave = "noticias";
include("../verifica.php");
include_once("../../library/config/database/tnoticia.php");

$oNoticia = new tnoticia();
if($oNoticia->LoadByPrimaryKey($_GET["id"]))
{
	$oNoticia->RemoveFile("../.." . $oNoticia->ImagemDestaque2);
	$oNoticia->ImagemDestaque2 = null;
	$oNoticia->Save();
}

header("Location: novo.php?" . $_SERVER["QUERY_STRING"]);
exit();

?>