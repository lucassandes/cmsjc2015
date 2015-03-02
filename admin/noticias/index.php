<?php

$Chave = "noticias";
include("../verifica.php");
include_once("../../library/master-page.php");
include_once("../../library/paginator.php");
include_once("../../library/config/database/tnoticia.php");

$oNoticia = new tnoticia();
$oNoticia->SQLWhere = " 1 = 1 ";

$palavra = $_GET["palavra"];
if($palavra)
{
	$oNoticia->SQLWhere .= " AND (Titulo LIKE '%" . $palavra . "%' OR Subtitulo LIKE '%" . $palavra . "%' OR Descricao LIKE '%" . $palavra . "%') ";
}

$oPaginator = new Paginator($oNoticia->GetCount());
$oNoticia->SQLOrder = "Data DESC, Hora DESC, Titulo ASC";
$oNoticia->LoadByPaginator($oPaginator->Limit, $oPaginator->Total);

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
			for($c = 0; $c < $oNoticia->NumRows; $c++)
			{
				$Param = "?" . $oPaginator->ParameterWithPage . "&id=" . $oNoticia->ID;
				?>
				<tr>
					<td align="center"><?=date("d/m/Y", $oNoticia->DateShow($oNoticia->Data));?></td>
					<td><?=$oNoticia->Titulo;?></td>
					<td align="center">
						<a href="novo.php<?=$Param;?>"><img src="../imgs/botoes/editar.png" alt="Editar" title="Editar" /></a>
						<a href="remover.php<?=$Param;?>" onclick="return conf();"><img src="../imgs/botoes/remover.png" alt="Remover" title="Remover" /></a>
					</td>
				</tr>
				<?php
				$oNoticia->MoveNext();
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