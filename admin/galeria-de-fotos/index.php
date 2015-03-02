<?php

$Chave = "galeria-de-fotos";
include("../verifica.php");
include_once("../../library/master-page.php");
include_once("../../library/paginator.php");
include_once("../../library/config/database/tgaleria.php");

$oGaleria = new tgaleria();
$oGaleria->SQLWhere = " 1 = 1 ";

$cbChave = each($oGaleria->ChaveLista);

$palavra = $_GET["palavra"];
$chave = $_GET["chave"];
if($palavra)
{
	$oGaleria->SQLWhere .= " AND Titulo LIKE '%" . $palavra . "%' ";
}
if($chave)
{
	$oGaleria->SQLWhere .= " AND Chave = '" . $chave . "'";
}

$oPaginator = new Paginator($oGaleria->GetCount());
$oGaleria->SQLOrder = "ID DESC";
$oGaleria->LoadByPaginator($oPaginator->Limit, $oPaginator->Total);

$oMasterPage = new MasterPage();
$oMasterPage->Init("../master.php");
$oMasterPage->AddParameter("Chave", $Chave);
$oMasterPage->Open("PageContent");

?>
<a href="passo1.php"><img alt="Cadastrar" title="Cadastrar" src="../imgs/botoes/cadastrar.png" /></a>
<div class="area">
	<p>Procurar registro cadastrado:</p>
	<form method="get" action="">
		<ul>
			<li>
				<label>
					Palavra-chave:
					<input size="60" maxlength="150" type="text" id="palavra" name="palavra" value="<?=$palavra;?>" />
				</label>
			</li>
			<li>
				<label>
					<input type="checkbox" name="chave" value="<?=$cbChave["key"]?>" <?php if($chave == $cbChave["key"]) { ?>checked="checked"<?php } ?> /> <?=$cbChave["value"];?>
				</label>
			</li>
			<li>
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
				<td>Título</td>
				<td width="220">Opções</td>
			</tr>
		</thead>
		<tbody>
			<?php
			for($c = 0; $c < $oGaleria->NumRows; $c++)
			{
				$Param = "?" . $oPaginator->ParameterWithPage . "&id=" . $oGaleria->ID;
				?>
				<tr>
					<td><?=$oGaleria->Titulo;?></td>
					<td align="center">
						<a href="passo1.php<?=$Param;?>"><img src="../imgs/botoes/editar.png" alt="Editar" title="Editar" /></a>
						<?php if(!$oGaleria->Chave || $oGaleria->Chave == $cbChave["key"]) { ?><a href="remover.php<?=$Param;?>" onclick="return conf();"><img src="../imgs/botoes/remover.png" alt="Remover" title="Remover" /></a><?php } ?>
					</td>
				</tr>
				<?php
				$oGaleria->MoveNext();
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