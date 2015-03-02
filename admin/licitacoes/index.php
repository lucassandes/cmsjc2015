<?php

$Chave = "licitacoes";
include("../verifica.php");
include_once("../../library/master-page.php");
include_once("../../library/paginator.php");
include_once("../../library/config/database/tlicitacao.php");

$oLicitacao = new tlicitacao();
$oLicitacao->SQLWhere = " 1 = 1 ";

$palavra = $_GET["palavra"];
$status = $_GET["status"];
$modalidade = $_GET["modalidade"];
if($palavra)
{
	$oLicitacao->SQLWhere .= " AND (Numero LIKE '%" . $palavra . "%' OR Objeto LIKE '%" . $palavra . "%') ";
}
if($status)
{
	$oLicitacao->SQLWhere .= " AND Status = '" . $status . "' ";
}
if($modalidade)
{
	$oLicitacao->SQLWhere .= " AND Modalidade = '" . $modalidade . "' ";
}

$oPaginator = new Paginator($oLicitacao->GetCount());
$oLicitacao->SQLOrder = (($status) ? "Ordem DESC" : "Numero DESC");
$oLicitacao->LoadByPaginator($oPaginator->Limit, $oPaginator->Total);

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
					<input size="40" maxlength="150" type="text" id="palavra" name="palavra" value="<?=$palavra;?>" />
				</label>
			</li>
			<li class="left">
				<label>
					Status:
					<select id="status" name="status">
						<option value="" selected="selected">Todos</option>
						<?php
						foreach($oLicitacao->StatusLista as $c => $v)
						{
							?>
							<option value="<?=$c;?>" <?php if($c == $status) { ?> selected="selected" <?php } ?>><?=$v;?></option>
							<?php
						}
						?>
					</select>
				</label>
			</li>
			<li class="left">
				<label>
					Modalidade:
					<select id="modalidade" name="modalidade">
						<option value="" selected="selected">Todas</option>
						<?php
						foreach($oLicitacao->ModalidadeLista as $c => $v)
						{
							?>
							<option value="<?=$c;?>" <?php if($c == $modalidade) { ?> selected="selected" <?php } ?>><?=$v;?></option>
							<?php
						}
						?>
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
				<td>Número</td>
				<td width="<?=(($status) ? 400 : 330);?>">Opções</td>
			</tr>
		</thead>
		<tbody>
			<?php
			for($c = 0; $c < $oLicitacao->NumRows; $c++)
			{
				$Param = "?" . $oPaginator->ParameterWithPage . "&id=" . $oLicitacao->ID;
				?>
				<tr>
					<td><?=$oLicitacao->Numero;?></td>
					<td align="center">
						<a href="visualizar.php<?=$Param;?>"><img src="../imgs/botoes/visualizar.png" alt="Visualizar" title="Visualizar" /></a>
						<a href="novo.php<?=$Param;?>"><img src="../imgs/botoes/editar.png" alt="Editar" title="Editar" /></a>
						<a href="remover.php<?=$Param;?>" onclick="return conf();"><img src="../imgs/botoes/remover.png" alt="Remover" title="Remover" /></a>
						<?php
						if($status)
						{
							?>
							<a href="mover.php<?=$Param;?>&acao=cima"><img src="../imgs/botoes/mover-para-cima.png" alt="Mover para cima" title="Mover para cima" /></a>
							<a href="mover.php<?=$Param;?>&acao=baixo"><img src="../imgs/botoes/mover-para-baixo.png" alt="Mover para baixo" title="Mover para baixo" /></a>
							<?php
						}
						?>
					</td>
				</tr>
				<?php
				$oLicitacao->MoveNext();
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