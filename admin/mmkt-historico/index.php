<?php

$Chave = "mmkt-historico";
include("../verifica.php");
include_once("../../library/master-page.php");
include_once("../../library/paginator.php");
include_once("../../library/config/database/tmmktenvio.php");

$oEnvio = new tmmktenvio();
$oPaginator = new Paginator($oEnvio->GetCount());
$oEnvio->SQLOrder = "DataHora DESC";
$oEnvio->LoadByPaginator($oPaginator->Limit, $oPaginator->Total);

$oMasterPage = new MasterPage();
$oMasterPage->Init("../master.php");
$oMasterPage->AddParameter("Chave", $Chave);
$oMasterPage->Open("PageContent");

?>
<?php
echo $oPaginator->Result;
if($oPaginator->TotalRecords > 0)
{
	?>
	<table class="lista">
		<thead>
			<tr>
				<td width="20">&nbsp;</td>
				<td>Assunto</td>
				<td width="60">Total</td>
				<td width="60">Sucesso</td>
				<td width="60">Erro</td>
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
					<td align="center"><?=$oEnvio->Total;?></td>
					<td align="center"><?=$oEnvio->TotalEnviado;?></td>
					<td align="center"><?=$oEnvio->TotalErro;?></td>
					<td align="center"><?=date("d/m/Y \à\s H:i", $oEnvio->DateShow($oEnvio->DataHora));?></td>
					<td align="center">
						<?php
						if(!$oEnvio->Enviado)
						{
							?>
							<a href="javascript:void(0);" onclick="window.open('../mmkt-enviar-mensagem/enviar.php?id=<?=$oEnvio->ID;?>', 'enviar', 'toolbar=0, location=0, directories=0, status=0, menubar=0, scrollbars=0, resizable=0, width=650, height=500, top=0, left=0');">
								<img src="../imgs/botoes/enviar.png" alt="Enviar" title="Enviar" />
							</a>
							<?php
						}
						?>
					</td>
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