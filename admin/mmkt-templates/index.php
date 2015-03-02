<?php

$Chave = "mmkt-templates";
include("../verifica.php");
include_once("../../library/master-page.php");
include_once("../../library/paginator.php");
include_once("../../library/config/database/tmmkttemplate.php");

$oTemplate = new tmmkttemplate();
$oTemplate->SQLWhere = " 1 = 1 ";

$palavra = $_GET["palavra"];
if($palavra)
{
	$oTemplate->SQLWhere .= " AND (Titulo LIKE '%" . $palavra . "%' OR Descricao LIKE '%" . $palavra . "%') ";
}

$oPaginator = new Paginator($oTemplate->GetCount());
$oTemplate->SQLOrder = "ID DESC";
$oTemplate->LoadByPaginator($oPaginator->Limit, $oPaginator->Total);

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
				<td width="20">&nbsp;</td>
				<td>Título</td>
				<td width="110">Ativo</td>
				<td width="220">Opções</td>
			</tr>
		</thead>
		<tbody>
			<?php
			for($c = 0; $c < $oTemplate->NumRows; $c++)
			{
				$Param = "?" . $oPaginator->ParameterWithPage . "&id=" . $oTemplate->ID;
				?>
				<tr>
					<td align="center"><a href="<?=$oTemplate->GenerateURL();?>" target="_blank"><img src="../imgs/icones16x16/zoom_16x16.gif" alt="Visualizar" title="Visualizar" /></a></td>
					<td><?=$oTemplate->Titulo;?></td>
					<td align="center">
						<a href="ativar.php<?=$Param;?>"><img src="../imgs/botoes/<?=(($oTemplate->Ativo) ? "desativar" : "ativar");?>.png" alt="<?=(($oTemplate->Ativo) ? "Desativar" : "Ativar");?>" title="<?=(($oTemplate->Ativo) ? "Desativar" : "Ativar");?>" /></a>
					</td>
					<td align="center">
						<a href="novo.php<?=$Param;?>"><img src="../imgs/botoes/editar.png" alt="Editar" title="Editar" /></a>
						<a href="remover.php<?=$Param;?>" onclick="return conf();"><img src="../imgs/botoes/remover.png" alt="Remover" title="Remover" /></a>
					</td>
				</tr>
				<?php
				$oTemplate->MoveNext();
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