<?php

$Chave = "planos";
include("../verifica.php");
include_once("../../library/master-page.php");
include_once("../../library/paginator.php");
include_once("../../library/config/database/tplano.php");

$oPlano = new tplano();
$oPlano->SQLWhere = " 1 = 1 ";

$palavra = $_GET["palavra"];  
if($palavra)
{
	$oPlano->SQLWhere .= " AND PeriodoInicial <= '" . $palavra . "' && PeriodoFinal > '" . $palavra . "'";
}

$oPaginator = new Paginator($oPlano->GetCount());
$oPlano->SQLOrder = "PeriodoInicial ASC";
$oPlano->LoadByPaginator($oPaginator->Limit, $oPaginator->Total);

$oMasterPage = new MasterPage();
$oMasterPage->Init("../master.php");
$oMasterPage->AddParameter("Chave", $Chave);
$oMasterPage->Open("PageContent");

?>
<a href="novo.php"><img alt="Cadastrar" title="Cadastrar" src="../imgs/botoes/cadastrar.png" /></a>
<div class="area">
	<p>Procurar registro cadastrado:</p>
	<form method="get" action="">   
	<ul>
		<li class="left">
			<label>
				Tempo:
				<input size="10" maxlength="2" type="text" id="palavra" name="palavra" value="<?=$palavra;?>" />   
			</label>
		</li>
		<li>
			<label>
				<br />
				<input type="image" src="../imgs/botoes/procurar.png" alt="Procurar" title="Procurar" />  
			</label>
		</li>
	</ul>
	</form>
	<div class="clear"></div>
</div>
<?php
echo $oPaginator->Result;
if($oPaginator->TotalRecords > 0)
{
	?>
	<table class="lista">
		<thead>
			<tr>
				<td>Intervalo</td>
				<td width="220">Opções</td>
			</tr>
		</thead>
		<tbody>
			<?php
			for($c = 0; $c < $oPlano->NumRows; $c++)
			{
				$Param = "?" . $oPaginator->ParameterWithPage . "&id=" . $oPlano->ID;
				?>
				<tr>
					<td>De <?=$oPlano->PeriodoInicial;?> a <?=$oPlano->PeriodoFinal;?> anos</td>
					<td align="center">
						<a href="novo.php<?=$Param;?>"><img src="../imgs/botoes/editar.png" alt="Editar" title="Editar" /></a>
						<a href="remover.php<?=$Param;?>" onclick="return conf();"><img src="../imgs/botoes/remover.png" alt="Remover" title="Remover" /></a>
					</td>
				</tr>
				<?php
				$oPlano->MoveNext();
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