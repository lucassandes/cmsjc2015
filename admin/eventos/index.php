<?php

$Chave = "eventos";
include("../verifica.php");
include_once("../../library/master-page.php");
include_once("../../library/paginator.php");
include_once("../../library/config/database/tevento.php");

$oEvento = new tevento();
$oEvento->SQLWhere = " 1 = 1 ";

$palavra = $_GET["palavra"];
if($palavra)
{
	$oEvento->SQLWhere .= " AND (Titulo LIKE '%" . $palavra . "%' OR Local LIKE '%" . $palavra . "%' OR Descricao LIKE '%" . $palavra . "%') ";
}

$oPaginator = new Paginator($oEvento->GetCount());
$oEvento->SQLOrder = "Data DESC";
$oEvento->LoadByPaginator($oPaginator->Limit, $oPaginator->Total);

$oMasterPage = new MasterPage();
$oMasterPage->Init("../master.php");
$oMasterPage->AddParameter("Chave", $Chave);
$oMasterPage->Open("PageContent");

?>
<a href="novo.php"><img alt="Cadastrar" title="Cadastrar" src="../imgs/botoes/cadastrar.png" /></a>
<div class="area">
	<p>Procurar registro cadastrado:</p>
	<form method="get" action="">
		<input size="60" maxlength="150" type="text" id="palavra" name="palavra" value="<?=$palavra;?>" />
		<input type="image" src="../imgs/botoes/procurar.png" alt="Procurar" title="Procurar" />
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
				<td width="80">Data</td>
				<td>Título</td>
				<td width="220">Opções</td>
			</tr>
		</thead>
		<tbody>
			<?php
			for($c = 0; $c < $oEvento->NumRows; $c++)
			{
				$Param = "?" . $oPaginator->ParameterWithPage . "&id=" . $oEvento->ID;
				?>
				<tr>
					<td align="center"><?=date("d/m/Y", $oEvento->DateShow($oEvento->Data));?></td>
					<td><?=$oEvento->Titulo;?></td>
					<td align="center">
						<a href="novo.php<?=$Param;?>"><img src="../imgs/botoes/editar.png" alt="Editar" title="Editar" /></a>
						<a href="remover.php<?=$Param;?>" onclick="return conf();"><img src="../imgs/botoes/remover.png" alt="Remover" title="Remover" /></a>
					</td>
				</tr>
				<?php
				$oEvento->MoveNext();
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