<?php

include_once("../library/config/database/tnoticia.php");

$oNoticia = new tnoticia();
if(!$oNoticia->LoadByPrimaryKey($_GET["id"]))
{
	echo '<script language="javascript" type="text/javascript">window.onload = window.close;</script>';
	exit();
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title><?=$oNoticia->WebTitle;?></title>
    <base href="<?=$oNoticia->WebURL;?>" />
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <meta http-equiv="Content-Language" content="pt-br" />
    <link rel="stylesheet" type="text/css" href="css/geral.css" />
	<link rel="stylesheet" type="text/css" href="css/noticias/imprimir.css" />
    <link rel="shortcut icon" type="image/png" href="favicon.ico" />
    <script language="javascript" type="text/javascript">window.onload = window.print;</script>
</head>
<body>
	<div class="area">
    	<h1 title="Câmara Municipal de São José dos Campos"><img src="imgs/noticias/imprimir/logo.png" alt="Câmara Municipal de São José dos Campos" title="Câmara Municipal de São José dos Campos" /></h1>
        <p class="data">
			<?=date("d/m/Y", $oNoticia->DateShow($oNoticia->Data));?>
			<?=(($oNoticia->Hora != "" && $oNoticia->Hora != "00:00:00") ? " - " . substr($oNoticia->Hora, 0, 5) : "");?>
		</p>
        <h2 class="titulo"><?=$oNoticia->Titulo;?></h2>
        <?php

		if($oNoticia->Subtitulo)
		{
			?>
			<h3><?=$oNoticia->Subtitulo;?></h3>
			<?php
		}
		
		if($oNoticia->Imagem)
		{
			?>
			<img class="img" alt="<?=$oNoticia->Titulo;?>" title="<?=$oNoticia->Titulo;?>" src="<?=$oNoticia->Thumbnail($oNoticia->Imagem, 340, 280);?>" />
			<?php
		}
		
		if(!$oNoticia->IsClear($oNoticia->Descricao))
		{
			?>
			<div class="editor"><?=$oNoticia->HTMLDecode($oNoticia->Descricao);?></div>
			<?php
		}
		
		?>
    </div>
</body>
</html>