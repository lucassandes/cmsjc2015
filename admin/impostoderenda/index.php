<?php

$Chave = "impostoderenda";
include("../verifica.php");
include_once("../../library/master-page.php");
include_once("../../library/paginator.php");
include_once("../../library/config/database/timpostoderenda.php");

$oImpostoRenda = new timpostoderenda();
$oImpostoRenda->SQLWhere = " 1 = 1 ";

$palavra = $_GET["palavra"]; 
$palavra = str_replace(".", "", $palavra); 
$palavra = str_replace(",", ".", $palavra);  
if($palavra)
{
	$oImpostoRenda->SQLWhere .= " AND (SalarioInicial = '" . $palavra . "' OR SalarioFinal = '" . $palavra . "' OR Percentual = '" . $palavra . "')";
}

$oPaginator = new Paginator($oImpostoRenda->GetCount());
$oImpostoRenda->SQLOrder = "SalarioInicial ASC";
$oImpostoRenda->LoadByPaginator($oPaginator->Limit, $oPaginator->Total);

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
				Palavra-chave:
				<input size="60" maxlength="150" type="text" id="palavra" name="palavra" value="<?=$palavra;?>" />   
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
				<td width="120">Percentual</td>
				<td width="220">Opções</td>
			</tr>
		</thead>
		<tbody>
			<?php
			for($c = 0; $c < $oImpostoRenda->NumRows; $c++)
			{
				$Param = "?" . $oPaginator->ParameterWithPage . "&id=" . $oImpostoRenda->ID;
				?>
				<tr>
					<td><b>R$ <?=number_format($oImpostoRenda->SalarioInicial, 2, ",", ".");?></b> a <b>R$ <?=number_format($oImpostoRenda->SalarioFinal, 2, ",", ".");?></b></td>
					<td align="center"><?=number_format(($oImpostoRenda->Percentual * 100), 2, ",", "");?>%</td>
					<td align="center">
						<a href="novo.php<?=$Param;?>"><img src="../imgs/botoes/editar.png" alt="Editar" title="Editar" /></a>
						<a href="remover.php<?=$Param;?>" onclick="return conf();"><img src="../imgs/botoes/remover.png" alt="Remover" title="Remover" /></a>
					</td>
				</tr>
				<?php
				$oImpostoRenda->MoveNext();
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