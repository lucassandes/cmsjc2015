<?php

$Chave = "galeria-de-fotos";
include("../verifica.php");
include_once("../../library/config/database/tgaleria.php");
include_once("../../library/config/database/tgaleriafoto.php");

$oGaleria = new tgaleria();
if($oGaleria->LoadByPrimaryKey($_GET["id"]))
{
	$oGaleriaFoto = new tgaleriafoto();
	$oGaleriaFoto->RemoveFileByGaleriaID($oGaleria->ID);
	
	$oGaleria->MarkAsDelete();
	$oGaleria->Save();
	$oGaleria->SetMessage("Vermelho");
}

header("Location: index.php?" . $_SERVER["QUERY_STRING"]);
exit();

?>