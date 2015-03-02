<?php

include_once(dirname(dirname(dirname(__FILE__))) . "/library/config/database/tmmkttemplate.php");
include_once(dirname(dirname(dirname(__FILE__))) . "/library/config/database/tmmktretorno.php");

//template
$oTemplate = new tmmkttemplate();
if(!$oTemplate->LoadByPrimaryKey($_GET["template"]))
{
	$oTemplate->SQLWhere = "Ativo = 1";
	$oTemplate->LoadSQLAssembled();
}
$_Template_ID = $oTemplate->ID;
$_Template_Titulo = $oTemplate->Titulo;
$_Template_Descricao = $oTemplate->HTMLDecode($oTemplate->Descricao);

//url
$_TITULO = $oTemplate->WebTitle;
$_URL = $oTemplate->WebURL;
$_Arquivo = $oTemplate->WebURLMMKT . $_Modelo . "/";

//variáveis
$_ID = (($_ID) ? $_ID : $_GET["id"]);
$_Nome = (($_Nome) ? $_Nome : $_GET["nome"]);
$_Email = (($_Email) ? $_Email : $_GET["email"]);
$_EnvioID = (($_EnvioID) ? $_EnvioID : $_GET["envioid"]);


//gera link
if(!function_exists("GeraLink"))
{
	function GeraLink($Campanha, $URL)
	{
		global $_EnvioID, $_Email;
		$oRetorno = new tmmktretorno();
		return $oRetorno->GenerateURL($_EnvioID, $_Email, $Campanha, $URL);
	}
}

//links
$parans = "?id=" . $_ID . "&nome=" . $_Nome . "&email=" . $_Email . "&envioid=" . $_EnvioID . "&template=" . $_Template_ID;
$_Link_Descadastrar = GeraLink("Descadastrar", $oTemplate->WebURLMMKT . "descadastrar.php" . $parans);
$_Link_Amigo = GeraLink("Enviar para um Amigo", $oTemplate->WebURLMMKT . "enviar-para-um-amigo.php" . $parans);
$_Link_Problema = GeraLink("Problemas para visualizar", $_Arquivo . $parans);
$_Link_Site = GeraLink("Link do Site", $_URL);

?>