<?php

$Chave = "mmkt-estatisticas";
include("../verifica.php");
include_once("../../library/master-page.php");
include_once("../../library/plugins/open-flash-chart/php-ofc-library/open_flash_chart_object.php");
include_once("../../library/config/database/tmmktenvio.php");
include_once("../../library/config/database/tmmktretorno.php");

$oEnvio = new tmmktenvio();
if(!$oEnvio->LoadByPrimaryKey($_GET["id"]))
{
	header("Location: index.php?" . $_SERVER["QUERY_STRING"]);
	exit();
}

$oMasterPage = new MasterPage();
$oMasterPage->Init("../master.php");
$oMasterPage->AddParameter("Chave", $Chave);
$oMasterPage->Open("PageContent");

?>
<?php

$oRetorno = new tmmktretorno();
$oRetorno->SQLField = "*, SUM(Quantidade) AS Quantidade";
$oRetorno->SQLGroup = "Campanha";
if($oRetorno->LoadByEnvioID($oEnvio->ID))
{
	
	?>
	<a href="index.php"><img src="../imgs/botoes/voltar.png" alt="Voltar" title="Voltar" /></a>
	<br /><br />
	<?php open_flash_chart_object(500, 500, "visualizar-grafico.php?" . $_SERVER["QUERY_STRING"], false, "../../library/plugins/open-flash-chart/");?>
	<br /><br />
	<table class="lista">
		<thead>
			<tr>
				<td width="20">&nbsp;</td>
				<td>Campanha</td>
				<td width="60">Enviados</td>
				<td width="60">Cliques</td>
				<td width="60">Retorno</td>
			</tr>
		</thead>
		<tbody>
			<?php
			for($c = 0; $c < $oRetorno->NumRows; $c++)
			{
				?>
				<tr>
					<td align="center">
						<?php
						if($oRetorno->Quantidade > 0)
						{
							?>
							<a href="javascript:void(0);" onclick="window.open('e-mails.php?id=<?=$oEnvio->ID?>&campanha=<?=$oRetorno->Campanha;?>', 'email', 'toolbar=0, location=0, directories=0, status=0, menubar=0, scrollbars=1, resizable=0, width=400, height=500, top=0, left=0');">
								<img src="../imgs/icones16x16/zoom_16x16.gif" alt="Visualizar" title="Visualizar" />
							</a>
							<?php
						}
						?>
					</td>
					<td><?=$oRetorno->Campanha;?></td>
					<td align="center"><?=$oEnvio->TotalEnviado;?></td>
					<td align="center"><?=$oRetorno->Quantidade;?></td>
					<td align="center"><?=(($oEnvio->TotalEnviado) ? $oRetorno->DecimalShow(($oRetorno->Quantidade * 100) / $oEnvio->TotalEnviado) : $oEnvio->TotalEnviado);?> %</td>
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
	<div><b>Nenhum registro encontrado.</b></div>
	<br />
	<a href="index.php"><img src="../imgs/botoes/voltar.png" alt="Voltar" title="Voltar" /></a>
	<?php
}
?>
<?php

$oMasterPage->Close("PageContent");
$oMasterPage->End();

?>