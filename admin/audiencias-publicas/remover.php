<?php

$Chave = "audiencias-publicas";
include("../verifica.php");
include_once("../../library/config/database/taudienciapublica.php");

$oAudienciaPublica = new taudienciapublica();
if($oAudienciaPublica->LoadByPrimaryKey($_GET["id"]))
{
	$oAudienciaPublica->RemoveFile("../.." . $oAudienciaPublica->Imagem);
	$oAudienciaPublica->RemoveFile("../.." . $oAudienciaPublica->Arquivo);
	$oAudienciaPublica->MarkAsDelete();
	$oAudienciaPublica->Save();
	$oAudienciaPublica->SetMessage("Vermelho");
}

header("Location: index.php?" . $_SERVER["QUERY_STRING"]);
exit();

?>