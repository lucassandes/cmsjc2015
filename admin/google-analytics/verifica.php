<?php

$Chave = "google-analytics";
include("../verifica.php");
include_once("../../library/api/google-analytics.php");
include_once("../../library/validator.php");
include_once("../../library/config/database/tparametro.php");

try
{
	$arParam = tparametro::Load();
	
	$oGoogleAnalytics = new GoogleAnalytics($arParam["google-analytics-email"], $arParam["google-analytics-senha"]);
	$oGoogleAnalytics->SetProfile("ga:" . $arParam["google-analytics-profile"]);
	
	//período
	$datainicio = $_GET["datainicio"];
	$datatermino = $_GET["datatermino"];
	if($datainicio && $datatermino)
	{
		$oValidator = new Validator();
		$oValidator->Add("datainicio", $datainicio, true, "date");
		$oValidator->Add("datatermino", $datatermino, true, "date");
		$oValidator->Add("datatermino", $datatermino, false, "dategreaterthan", null, $datainicio);
		if($oValidator->Validate())
		{
			$arDataInicio = explode("/", $datainicio);
			$arDataTermino = explode("/", $datatermino);
			$oGoogleAnalytics->SetRange($arDataInicio[2] . "-" . $arDataInicio[1] . "-" . $arDataInicio[0],
										$arDataTermino[2] . "-" . $arDataTermino[1] . "-" . $arDataTermino[0]);
		}
	}
	
	//quantidade
	$arQuantidade = array(5, 10, 20, 30, 40, 50, 100);
	$quantidade = ((in_array($_GET["quantidade"], $arQuantidade)) ? $_GET["quantidade"] : 5);
	
	//relatório geral
	$report = $oGoogleAnalytics->Report(array("metrics" => "ga:visits,ga:pageviews,ga:bounces,ga:entrances,ga:timeOnSite,ga:newVisits"));
}
catch(Exception $e)
{
	if($init)
	{
		Util::SetMessage("Vermelho", $e->getMessage(), "Erro");
		header("Location: ../");
		exit();
	}
	else
	{
		echo Util::CreateMessage("Vermelho", $e->getMessage(), "Erro");
	}
}

?>