<?php

$Chave = "mmkt-estatisticas";
include("../verifica.php");
include_once("../../library/config/database/tmmktretorno.php");

$oRetorno = new tmmktretorno();
$oRetorno->SQLGroup = "Email";
$oRetorno->LoadByEnvioIDAndCampanha($_GET["id"], $_GET["campanha"]);

//post
if($_POST)
{
	$conteudo = "";
	for($c =0 ; $c < $oRetorno->NumRows; $c++)
	{
		$conteudo .= $oRetorno->Email . "\r\n";
		$oRetorno->MoveNext();
	}
	$oRetorno->ForceDownload($conteudo, "exportar.csv", false);
	$oRetorno->Rewind();
	exit();
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<title>E-mails</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<link type="text/css" rel="stylesheet" href="../css/geral.css" />
	<link type="text/css" rel="stylesheet" href="../css/master.css" />
</head>
<body>
	<div class="margem">
		<?php
		if($oRetorno->NumRows > 0)
		{
			?>
			<form action="" method="post">
				<input type="image" src="../imgs/botoes/exportar.png" alt="Exportar" title="Exportar" />
			</form>
			<br />
			<table class="lista">
				<thead>
					<tr>
						<td>E-mail</td>
					</tr>
				</thead>
				<tbody>
					<?php
					for($c =0 ; $c < $oRetorno->NumRows; $c++)
					{
						?>
						<tr>
							<td><?=$oRetorno->Email;?></td>
						</tr>
						<?php
						$oRetorno->MoveNext();
					}
					?>
				</tbody>
			</table>
			<?php
		}
		else
		{
			?>
			Nenhum registro encontrado.
			<?php
		}
		?>
	</div>
</body>
</html>