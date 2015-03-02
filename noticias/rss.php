<?php

header("Content-Type: text/xml; charset=iso-8859-1", true);

include_once("../library/config/database/tnoticia.php");

$oNoticia = new tnoticia();
$oNoticia->SQLWhere = "(Hora != '' AND Hora != '00:00:00' AND Hora IS NOT NULL)";
$oNoticia->SQLOrder = "Data DESC, Hora DESC, Titulo ASC";
$oNoticia->SQLTotal = 10;
$oNoticia->LoadSQLAssembled();

echo '<?xml version="1.0" encoding="iso-8859-1"?>';
echo '<rss version="2.0">';
echo '<channel>';
echo '<title>' . $oNoticia->WebTitle . '</title>';
echo '<link>' . $oNoticia->WebURL . '</link>';
echo '<language>pt-BR</language>';

for($c = 0; $c < $oNoticia->NumRows; $c++)
{
	echo '<item>';
	echo '<pubDate>' . date("r", $oNoticia->DateShow($oNoticia->Data . " " . $oNoticia->Hora)) . '</pubDate>';
	echo '<title><![CDATA[' . $oNoticia->Titulo . ']]></title>';
	echo '<description><![CDATA[' . $oNoticia->Subtitulo . ']]></description>';
	echo '<link>' . $oNoticia->GenerateURL() . '</link>';
	echo '</item>';
	
	$oNoticia->MoveNext();
}

echo '</channel>';
echo '</rss>';

?>