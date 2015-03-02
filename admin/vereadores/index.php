<?php

$Chave = "vereadores";
include("../verifica.php");
include_once("../../library/master-page.php");
include_once("../../library/paginator.php");
include_once("../../library/config/database/tvereador.php");
include_once("../../library/config/database/tpartido.php");

$oVereador = new tvereador();
$oVereador->SQLWhere = " 1 = 1 ";

$palavra = $_GET["palavra"];
$partido = $_GET["partido"];
if($palavra)
{
	$oVereador->SQLWhere .= " AND (Nome LIKE '%" . $palavra . "%' OR Informacao LIKE '%" . $palavra . "%' OR Email LIKE '%" . $palavra . "%' OR Descricao LIKE '%" . $palavra . "%') ";
}
if($partido)
{
	$oVereador->SQLWhere .= " AND PartidoID = '" . $partido . "' ";
}

$oPaginator = new Paginator($oVereador->GetCount());
$oVereador->SQLOrder = "Ordem DESC";
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
			<li class="left">
				<label>
					Partido: 
					<select id="partido" name="partido">
						<option value="" selected="selected">Todos</option>
						<?php tpartido::ddl($partido); ?>
					</select>
				</label>
			</li>
			<li>
				<br />
				<input type="image" src="../imgs/botoes/procurar.png" alt="Procurar" title="Procurar" />
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
				<td width="300">Opções</td>
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
					<td align="center">
						<a href="novo.php<?=$Param;?>"><img src="../imgs/botoes/editar.png" alt="Editar" title="Editar" /></a>
						<a href="remover.php<?=$Param;?>" onclick="return conf();"><img src="../imgs/botoes/remover.png" alt="Remover" title="Remover" /></a>
						<a href="mover.php<?=$Param;?>&acao=cima"><img src="../imgs/botoes/mover-para-cima.png" alt="Mover para cima" title="Mover para cima" /></a>
						<a href="mover.php<?=$Param;?>&acao=baixo"><img src="../imgs/botoes/mover-para-baixo.png" alt="Mover para baixo" title="Mover para baixo" /></a>
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