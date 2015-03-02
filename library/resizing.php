<?php

include_once(dirname(__FILE__) . "/resize.php");

try
{
	$oResize = new Resize($_GET["src"]);
	$oResize->NewWidth = $_GET["width"];
	$oResize->NewHeight = $_GET["height"];
	$oResize->IsCut = (($_GET["cut"]) ? true : false);
	$oResize->IsCenter = (($_GET["center"]) ? true : false);
	$oResize->IsCenterX = (($_GET["centerx"] || !isset($_GET["centerx"])) ? true : false);
	$oResize->IsCenterY = (($_GET["centery"] || !isset($_GET["centery"])) ? true : false);
	$oResize->Create();
}
catch(Exception $e)
{
	header("Content-type: image/jpeg");
	$im = imagecreate(300, 40);
	$background_color = imagecolorallocate($im, 0xE1, 0xE1, 0xE1);
	$text_color = imagecolorallocate($im, 0, 0, 0);
	imagestring($im, 4, 10, 10,  $e->getMessage(), $text_color);
	imagejpeg($im);
	imagedestroy($im);
}

?>