<?php

include_once(dirname(dirname(__FILE__)) . "/library/config/database/tadministrador.php");
include_once(dirname(dirname(__FILE__)) . "/library/config/database/tpermissao.php");

//Verifica autenticaчуo do administrador
$oAdministradorLogado = new tadministrador();
//if(!$oAdministradorLogado->CheckAuthentication() || ($_SERVER["REMOTE_ADDR"] != "200.174.132.56" && strtolower($oAdministradorLogado->Login) != "clicknow"))
if(!$oAdministradorLogado->CheckAuthentication() || ($_SERVER["REMOTE_ADDR"] != "200.174.132.56" && $_SERVER["REMOTE_ADDR"] != "200.136.177.120"&& $_SERVER["REMOTE_ADDR"] != "189.110.15.29"))
{
	header("Location: " . $oAdministradorLogado->WebURLAdmin . "login.php?u=" . urlencode($_SERVER["REQUEST_URI"]));
	exit();
}

//Verifica permissуo do administrador
$oPermissaoVerifica = new tpermissao();
if($Chave && !$oPermissaoVerifica->LoadByAdministradorIDAndChave($oAdministradorLogado->ID, $Chave))
{
	$oPermissaoVerifica->SetMessage("Amarelo", "Vocъ nуo tem permissуo para acessar essa ferramenta.");
	header("Location: " . $oPermissaoVerifica->WebURLAdmin);
	exit();
}

?>