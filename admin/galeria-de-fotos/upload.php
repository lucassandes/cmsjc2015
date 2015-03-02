<?php

$Chave = "galeria-de-fotos";
//include("../verifica.php");
include_once("../../library/upload.php");
include_once("../../library/config/database/tgaleria.php");
include_once("../../library/config/database/tgaleriafoto.php");

$oGaleria = new tgaleria();
if($oGaleria->LoadByPrimaryKey($_POST["id"]))
{
	$oUpload = new Upload($_FILES["Filedata"]);
	if($oUpload->Validate(true, array("jpg", "jpeg", "gif")))
	{
		$oGaleriaFoto = new tgaleriafoto();
		$oGaleriaFoto->AddNew();
		$oGaleriaFoto->GaleriaID = $oGaleria->ID;
		$oGaleriaFoto->Imagem = $oUpload->Save($Chave);
		$oGaleriaFoto->Legenda = "";
		$oGaleriaFoto->Ordem = 0;
		$oGaleriaFoto->Save();
		
		echo '{"id":"' . $oGaleriaFoto->ID . '","img":"' . $oGaleriaFoto->Thumbnail($oGaleriaFoto->Imagem, 80, 80) . '"}';
	}
}

?>