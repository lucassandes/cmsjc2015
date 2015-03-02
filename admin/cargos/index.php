<?php

$Chave = "cargos";
include("../verifica.php");
include_once("../../library/master-page.php");
include_once("../../library/paginator.php");
include_once("../../library/config/database/tcargo.php");

$oCargo = new tcargo();
$oCargo->SQLWhere = " 1 = 1 ";

$palavra = $_GET["palavra"];  
if($palavra)
{
	$oCargo->SQLWhere .= " AND Titulo LIKE '%" . $palavra . "%'";
}

$oPaginator = new Paginator($oCargo->GetCount());
$oCargo->SQLOrder = "Titulo ASC";
$oCargo->LoadByPaginator($oPaginator->Limit, $oPaginator->Total);

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
				<td>Título</td>
				<td width="220">Opções</td>
			</tr>
		</thead>
		<tbody>
			<?php
			for($c = 0; $c < $oCargo->NumRows; $c++)
			{
				$Param = "?" . $oPaginator->ParameterWithPage . "&id=" . $oCargo->ID;
				?>
				<tr>
					<td><?=$oCargo->Titulo;?></td>
					<td align="center">
						<a href="novo.php<?=$Param;?>"><img src="../imgs/botoes/editar.png" alt="Editar" title="Editar" /></a>
						<a href="remover.php<?=$Param;?>" onclick="return conf();"><img src="../imgs/botoes/remover.png" alt="Remover" title="Remover" /></a>
					</td>
				</tr>
				<?php
				$oCargo->MoveNext();
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