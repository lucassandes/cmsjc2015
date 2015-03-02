<?php

$Chave = "audiencias-publicas";
include("../verifica.php");
include_once("../../library/config/database/taudienciapublica.php");

$oAudienciaPublica = new taudienciapublica();
if($oAudienciaPublica->LoadByPrimaryKey($_GET["id"]))
{
	$oAudienciaPublica->RemoveFile("../.." . $oAudienciaPublica->Arquivo);
	$oAudienciaPublica->Arquivo = "";
	$oAudienciaPublica->Save();
}

header("Location: novo.php?" . $_SERVER["QUERY_STRING"]);
exit();

?>