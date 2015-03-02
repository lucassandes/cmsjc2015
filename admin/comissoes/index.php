<?php

$Chave = "comissoes";
include("../verifica.php");
include_once("../../library/master-page.php");
include_once("../../library/paginator.php");
include_once("../../library/config/database/tcomissao.php");

$oComissao = new tcomissao();
$oComissao->SQLWhere = " 1 = 1 ";

$palavra = $_GET["palavra"];
$tipo = $_GET["tipo"];
if($palavra)
{
	$oComissao->SQLWhere .= " AND Titulo LIKE '%" . $palavra . "%' ";
}
if($tipo)
{
	$oComissao->SQLWhere .= " AND Tipo = '" . $tipo . "' ";
}

$oPaginator = new Paginator($oComissao->GetCount());
$oComissao->SQLOrder = "Ordem DESC";
$oComissao->LoadByPaginator($oPaginator->Limit, $oPaginator->Total);

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
						foreach($oComissao->TipoLista as $c => $v)
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
				<td>Título</td>
				<td width="<?=(($tipo) ? 300 : 220);?>">Opções</td>
			</tr>
		</thead>
		<tbody>
			<?php
			for($c = 0; $c < $oComissao->NumRows; $c++)
			{
				$Param = "?" . $oPaginator->ParameterWithPage . "&id=" . $oComissao->ID;
				?>
				<tr>
					<td><?=$oComissao->Titulo;?></td>
					<td align="center">
						<a href="novo.php<?=$Param;?>"><img src="../imgs/botoes/editar.png" alt="Editar" title="Editar" /></a>
						<a href="remover.php<?=$Param;?>" onclick="return conf();"><img src="../imgs/botoes/remover.png" alt="Remover" title="Remover" /></a>
						<?php
						if($tipo)
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
				$oComissao->MoveNext();
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