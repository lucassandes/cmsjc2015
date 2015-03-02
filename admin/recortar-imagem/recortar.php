<?php

include("../verifica.php");

$oUtil = new Util();

try
{
	$Image = $_POST["image"];
	$ImageSource = $_POST["imageSource"];
	$Width = intval($_POST["width"]);
	$Height = intval($_POST["height"]);
	$NewWidth = intval($_POST["newWidth"]);
	$NewHeight = intval($_POST["newHeight"]);
	$x1 = intval($_POST["x1"]);
	$y1 = intval($_POST["y1"]);
	$x2 = intval($_POST["x2"]);
	$y2 = intval($_POST["y2"]);
	
	if(!is_file($ImageSource))
	{
		throw new Exception("0");
	}
	
	$PathInfo = pathinfo($Image);
	$Directory = $oUtil->ParseDirectory("recortar-imagem", $Image, true);
	$ImageDestination = $Directory . $PathInfo["filename"] . "_" . $Width . "x" . $Height . "_" . $x1 . "_" . $y1 . "_" . $x2 . "_" . $y2 . "." . $PathInfo["extension"];
	
	$arGlob = glob($Directory . $PathInfo["filename"] . "_" . $Width . "x" . $Height . "_*");
	if(is_array($arGlob))
	{
		foreach($arGlob as $File)
		{
			$oUtil->RemoveFile($File);
		}
	}
	
	$ImageSize = getimagesize($ImageSource);
	$ImageNew = imagecreatetruecolor($NewWidth, $NewHeight);
	$ImageExt = Util::GetExtension($ImageSource);
	
	switch($ImageExt)
	{
	    case "jpg": $ImageOld = imagecreatefromjpeg($ImageSource); break;
	    case "jpeg": $ImageOld = imagecreatefromjpeg($ImageSource); break;
	    case "gif": $ImageOld = imagecreatefromgif($ImageSource); break;
	    case "png": $ImageOld = imagecreatefrompng($ImageSource); break;
	}
	
	imagecopyresampled($ImageNew, $ImageOld, 0, 0, $x1, $y1, $ImageSize[0], $ImageSize[1], $ImageSize[0], $ImageSize[1]);
	
	switch($ImageExt)
	{
	    case "jpg": imagejpeg($ImageNew, $ImageDestination, 100); break;
	    case "jpeg": imagejpeg($ImageNew, $ImageDestination, 100); break;
	    case "gif": imagegif($ImageNew, $ImageDestination); break;
		case "png": imagepng($ImageNew, $ImageDestination, 9); break;
	}
	
	imagedestroy($ImageNew);
	imagedestroy($ImageOld);
	
	echo "1";
}
catch(Exception $ex)
{
	echo "0";
}

?>