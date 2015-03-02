<?php

$Chave = "mmkt-estatisticas";
include("../verifica.php");
include_once("../../library/master-page.php");
include_once("../../library/paginator.php");
include_once("../../library/plugins/open-flash-chart/php-ofc-library/open_flash_chart_object.php");
include_once("../../library/config/database/tmmktenvio.php");

$oEnvio = new tmmktenvio();
$oPaginator = new Paginator($oEnvio->GetCount());
$oEnvio->SQLField = "*, EnvioTotalRetorno(ID) AS TotalRetorno";
$oEnvio->SQLWhere = "Enviado = 1";
$oEnvio->SQLOrder = "DataHoraEnviado DESC";
$oEnvio->LoadByPaginator($oPaginator->Limit, $oPaginator->Total);

$oMasterPage = new MasterPage();
$oMasterPage->Init("../master.php");
$oMasterPage->AddParameter("Chave", $Chave);
$oMasterPage->Open("PageContent");

?>
<?php

if($oPaginator->TotalRecords > 0)
{
	open_flash_chart_object(650, 650, "grafico.php", false, "../../library/plugins/open-flash-chart/");
}

echo $oPaginator->Result;
if($oPaginator->TotalRecords > 0)
{
	?>
	<table class="lista">
		<thead>
			<tr>
				<td width="20">&nbsp;</td>
				<td>Assunto</td>
				<td width="60">Enviados</td>
				<td width="60">Cliques</td>
				<td width="60">Retorno</td>
				<td width="110">Data do envio</td>
				<td width="110">Opções</td>
			</tr>
		</thead>
		<tbody>
			<?php
			for($c = 0; $c < $oEnvio->NumRows; $c++)
			{
				?>
				<tr>
					<td align="center"><a href="<?=$oEnvio->WebURLMMKT;?><?=$oEnvio->Modelo;?>/index.php" target="_blank"><img src="../imgs/icones16x16/zoom_16x16.gif" alt="Visualizar" title="Visualizar" /></a></td>
					<td><?=$oEnvio->Assunto;?></td>
					<td align="center"><?=$oEnvio->TotalEnviado;?></td>
					<td align="center"><?=$oEnvio->TotalRetorno;?></td>
					<td align="center"><?=(($oEnvio->TotalEnviado) ? $oEnvio->DecimalShow(($oEnvio->TotalRetorno * 100) / $oEnvio->TotalEnviado) : $oEnvio->TotalEnviado);?> %</td>
					<td align="center"><?=date("d/m/Y \à\s H:i", $oEnvio->DateShow($oEnvio->DataHora));?></td>
					<td align="center"><a href="visualizar.php?id=<?=$oEnvio->ID;?>"><img src="../imgs/botoes/visualizar.png" alt="Visualizar" title="Visualizar" /></a></td>
				</tr>
				<?php
				$oEnvio->MoveNext();
			}
			?>
		</tbody>
	</table>
	<?php
	echo $oPaginator->Result;
}
?>
<?php

$oMasterPage->Close("PageContent");
$oMasterPage->End();

?>