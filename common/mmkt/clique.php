<?php

//vars
$envioid = $_GET["envioid"];
$email = $_GET["email"];
$campanha = urldecode($_GET["campanha"]);
$url = urldecode($_GET["url"]);

include_once("../../library/config/database/tmmktenvio.php");
include_once("../../library/config/database/tmmktretorno.php");

//verifica envio
$oEnvio = new tmmktenvio();
if($oEnvio->LoadByPrimaryKey($envioid))
{
	//verifica retorno
	$oRetorno = new tmmktretorno();
    if(!$oRetorno->LoadByEnvioIDAndEmailAndCampanha($oEnvio->ID, $email, $campanha))
    {
        $oRetorno->AddNew();
        $oRetorno->EnvioID = $oEnvio->ID;
        $oRetorno->Email = $email;
		$oRetorno->Campanha = $campanha;
    }

    $oRetorno->Quantidade = ($oRetorno->Quantidade + 1);
    $oRetorno->Save();
}

header("Location: " . (($url) ? $url : $oEnvio->WebURL));
exit();

?>