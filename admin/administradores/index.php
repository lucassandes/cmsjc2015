<?php

$Chave = "administradores";
include("../verifica.php");
include_once("../../library/master-page.php");
include_once("../../library/paginator.php");
include_once("../../library/config/database/tadministrador.php");

$oAdministrador = new tadministrador();
$oAdministrador->SQLWhere = " Login != 'clicknow' ";

$palavra = $_GET["palavra"];
if($palavra)
{
	$oAdministrador->SQLWhere .= " AND (Nome LIKE '%" . $palavra . "%' OR Login LIKE '%" . $palavra . "%' OR Email LIKE '%" . $palavra . "%') ";
}

$oPaginator = new Paginator($oAdministrador->GetCount());
$oAdministrador->SQLOrder = "Nome ASC";
$oAdministrador->LoadByPaginator($oPaginator->Limit, $oPaginator->Total);

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
				<td>Nome</td>
				<td width="110">Ativo</td>
				<td width="220">Opções</td>
			</tr>
		</thead>
		<tbody>
			<?php
			for($c = 0; $c < $oAdministrador->NumRows; $c++)
			{
				$Param = "?" . $oPaginator->ParameterWithPage . "&id=" . $oAdministrador->ID;
				?>
				<tr>
					<td><?=$oAdministrador->Nome;?></td>
					<td align="center">
						<a href="ativar.php<?=$Param;?>"><img src="../imgs/botoes/<?=(($oAdministrador->Ativo) ? "desativar" : "ativar");?>.png" alt="<?=(($oAdministrador->Ativo) ? "Desativar" : "Ativar");?>" title="<?=(($oAdministrador->Ativo) ? "Desativar" : "Ativar");?>" /></a>
					</td>
					<td align="center">
						<a href="novo.php<?=$Param;?>"><img src="../imgs/botoes/editar.png" alt="Editar" title="Editar" /></a>
						<a href="remover.php<?=$Param;?>" onclick="return conf();"><img src="../imgs/botoes/remover.png" alt="Remover" title="Remover" /></a>
					</td>
				</tr>
				<?php
				$oAdministrador->MoveNext();
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