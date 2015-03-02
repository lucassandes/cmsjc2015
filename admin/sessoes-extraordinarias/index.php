<?php

$Chave = "sessoes-extraordinarias";
include("../verifica.php");
include_once("../../library/master-page.php");
include_once("../../library/paginator.php");
include_once("../../library/config/database/tsessao.php");

$oSessao = new tsessao();
$oSessao->SQLWhere = "(Tipo = '" . implode("' OR Tipo = '", array_keys($oSessao->Tipo2Lista[$Chave])) . "')";

$palavra = $_GET["palavra"];
$tipo = $_GET["tipo"];
if($palavra)
{
	$oSessao->SQLWhere .= " AND (Titulo LIKE '%" . $palavra . "%' OR Descricao LIKE '%" . $palavra . "%') ";
}
if($tipo)
{
	$oSessao->SQLWhere .= " AND Tipo = '" . $tipo . "' ";
}

$oPaginator = new Paginator($oSessao->GetCount());
$oSessao->SQLOrder = "Data DESC";
$oSessao->LoadByPaginator($oPaginator->Limit, $oPaginator->Total);

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
					Tipo:
					<select id="tipo" name="tipo">
						<option value="" selected="selected">Todos</option>
						<?php
						foreach($oSessao->Tipo2Lista[$Chave] as $c => $v)
						{
							?>
							<option value="<?=$c;?>" <?php if($c == $tipo) { ?> selected="selected" <?php } ?>><?=$v;?></option>
							<?php
						}
						?>
					</select>
				</label>
			</li>
			<li>
				<br /><input type="image" src="../imgs/botoes/procurar.png" alt="Procurar" title="Procurar" />
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
				<td width="80">Data</td>
				<td>Título</td>
				<td width="220">Opções</td>
			</tr>
		</thead>
		<tbody>
			<?php
			for($c = 0; $c < $oSessao->NumRows; $c++)
			{
				$Param = "?" . $oPaginator->ParameterWithPage . "&id=" . $oSessao->ID;
				?>
				<tr>
					<td align="center"><?=date("d/m/Y", $oSessao->DateShow($oSessao->Data));?></td>
					<td><?=$oSessao->Titulo;?></td>
					<td align="center">
						<a href="novo.php<?=$Param;?>"><img src="../imgs/botoes/editar.png" alt="Editar" title="Editar" /></a>
						<a href="remover.php<?=$Param;?>" onclick="return conf();"><img src="../imgs/botoes/remover.png" alt="Remover" title="Remover" /></a>
					</td>
				</tr>
				<?php
				$oSessao->MoveNext();
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