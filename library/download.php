<?php

include_once(dirname(__FILE__) . "/util.php");

try
{
	$filepath = $_GET["path"];
	$filepath = preg_replace("/\.+\/+/", "", $filepath);
	$filepath = preg_replace("/^\/*(arquivo\/)?/", "", $filepath);
	$filepath = dirname(dirname(__FILE__)) . "/arquivo/" . $filepath;
	$name = $_GET["name"];
	
	Util::ForceDownload($filepath, $name);
}
catch(Exception $e)
{
	if($_SERVER["HTTP_REFERER"])
	{
		Util::SetMessage("Vermelho", $e->getMessage(), "Erro");
		header("Location: " . $_SERVER["HTTP_REFERER"]);
		exit();
	}
	
	echo $e->getMessage();
}
			
?>