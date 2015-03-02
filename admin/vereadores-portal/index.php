<?php

$Chave = "vereadores-portal";
include("../verifica.php");
include_once("../../library/master-page.php");
include_once("../../library/paginator.php");
include_once("../../library/config/database/tvereadorportal.php");

$oVereador = new tvereadorportal();
$oVereador->SQLWhere = " 1 = 1 ";

$palavra = $_GET["palavra"];  
if($palavra)
{
	$oVereador->SQLWhere .= " AND (Nome LIKE '%" . $palavra . "%' OR Partido LIKE '%" . $palavra . "%')";
}

$oPaginator = new Paginator($oVereador->GetCount());
$oVereador->SQLOrder = "Nome ASC";
$oVereador->LoadByPaginator($oPaginator->Limit, $oPaginator->Total);

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
				<td>Nome</td>
				<td width="50">Partido</td>
				<td width="100">Salário</td>
				<td width="220">Opções</td>
			</tr>
		</thead>
		<tbody>
			<?php
			for($c = 0; $c < $oVereador->NumRows; $c++)
			{
				$Param = "?" . $oPaginator->ParameterWithPage . "&id=" . $oVereador->ID;
				?>
				<tr>
					<td><?=$oVereador->Nome;?></td>
					<td align="center"><?=$oVereador->Partido;?></td>
					<td align="center">R$ <?=$oVereador->DecimalShow($oVereador->Salario);?></td>
					<td align="center">
						<a href="novo.php<?=$Param;?>"><img src="../imgs/botoes/editar.png" alt="Editar" title="Editar" /></a>
						<a href="remover.php<?=$Param;?>" onclick="return conf();"><img src="../imgs/botoes/remover.png" alt="Remover" title="Remover" /></a>
					</td>
				</tr>
				<?php
				$oVereador->MoveNext();
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