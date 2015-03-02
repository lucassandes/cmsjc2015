<?php

$Chave = "downloads";
include("../verifica.php");
include_once("../../library/master-page.php");
include_once("../../library/paginator.php");
include_once("../../library/config/database/tdownload.php");
include_once("../../library/config/database/tcategoriadownload.php");

$oDownload = new tdownload();
$oDownload->SQLWhere = " 1 = 1 ";

$palavra = $_GET["palavra"];
$categoria = $_GET["categoria"];
if($palavra)
{
	$oDownload->SQLWhere .= " AND Titulo LIKE '%" . $palavra . "%' ";
}
if($categoria)
{
	$oDownload->SQLWhere .= " AND CategoriaDownloadID = '" . $categoria . "' ";
}

$oPaginator = new Paginator($oDownload->GetCount());
$oDownload->SQLOrder = "Ordem DESC";
$oDownload->LoadByPaginator($oPaginator->Limit, $oPaginator->Total);

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
					Categoria:
					<select id="categoria" name="categoria">
						<option value="" selected="selected">Todas</option>
						<?php tcategoriadownload::ddl($categoria); ?>
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
				<td width="<?=(($categoria) ? 300 : 220);?>">Opções</td>
			</tr>
		</thead>
		<tbody>
			<?php
			for($c = 0; $c < $oDownload->NumRows; $c++)
			{
				$Param = "?" . $oPaginator->ParameterWithPage . "&id=" . $oDownload->ID;
				?>
				<tr>
					<td><?=$oDownload->Titulo;?></td>
					<td align="center">
						<a href="novo.php<?=$Param;?>"><img src="../imgs/botoes/editar.png" alt="Editar" title="Editar" /></a>
						<a href="remover.php<?=$Param;?>" onclick="return conf();"><img src="../imgs/botoes/remover.png" alt="Remover" title="Remover" /></a>
						<?php
						if($categoria)
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
				$oDownload->MoveNext();
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