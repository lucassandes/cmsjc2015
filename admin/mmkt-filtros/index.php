<?php

$Chave = "mmkt-filtros";
include("../verifica.php");
include_once("../../library/master-page.php");
include_once("../../library/paginator.php");
include_once("../../library/config/database/tmmktfiltro.php");

$oFiltro = new tmmktfiltro();
$oFiltro->SQLWhere = " (Chave = '' OR Chave IS NULL) ";

$palavra = $_GET["palavra"];
$ordenar = $_GET["ordenar"];
if($palavra)
{
	$oFiltro->SQLWhere .= " AND Titulo LIKE '%" . $palavra . "%' ";
}

$oPaginator = new Paginator($oFiltro->GetCount());
$oFiltro->SQLField = "*, FiltroTotalEmail(ID) AS TotalEmail";
switch($ordenar)
{
	case "tituloza": $oFiltro->SQLOrder = " Titulo DESC "; break;
	case "qtdemailmaior": $oFiltro->SQLOrder = " TotalEmail DESC "; break;
	case "qtdemailmenor": $oFiltro->SQLOrder = " TotalEmail ASC "; break;
	default: $oFiltro->SQLOrder = " Titulo ASC "; $ordenar = "tituloaz"; break;
}
$oFiltro->SQLOrder .= ", Titulo ASC ";
$oFiltro->LoadByPaginator($oPaginator->Limit, $oPaginator->Total);

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
					<input size="50" maxlength="150" type="text" id="palavra" name="palavra" value="<?=$palavra;?>" />
				</label>
			</li>
			<li class="left">
				<label>
					Ordenar por:
					<select id="ordenar" name="ordenar">
						<option value="tituloaz" <?php if($ordenar == "tituloaz") { ?> selected="selected" <?php } ?>>Título (A - Z)</option>
						<option value="tituloza" <?php if($ordenar == "tituloza") { ?> selected="selected" <?php } ?>>Título (Z - A)</option>
						<option value="qtdemailmaior" <?php if($ordenar == "qtdemailmaior") { ?> selected="selected" <?php } ?>>Qtd. de e-mails (maior - menor)</option>
						<option value="qtdemailmenor" <?php if($ordenar == "qtdemailmenor") { ?> selected="selected" <?php } ?>>Qtd. de e-mails (menor - maior)</option>
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
				<td>Título (Qtd. de e-mails)</td>
				<td width="220">Opções</td>
			</tr>
		</thead>
		<tbody>
			<?php
			for($c = 0; $c < $oFiltro->NumRows; $c++)
			{
				$Param = "?" . $oPaginator->ParameterWithPage . "&id=" . $oFiltro->ID;
				?>
				<tr>
					<td>
						<?=$oFiltro->Titulo;?>
						(<?php if($oFiltro->TotalEmail > 0) { ?><a href="../mmkt-emails/?filtros[]=<?=$oFiltro->ID;?>"><?php } ?><?=$oFiltro->TotalEmail;?><?php if($oFiltro->TotalEmail > 0) { ?></a><?php } ?>)
					</td>
					<td align="center">
						<a href="novo.php<?=$Param;?>"><img src="../imgs/botoes/editar.png" alt="Editar" title="Editar" /></a>
						<a href="remover.php<?=$Param;?>" onclick="return conf();"><img src="../imgs/botoes/remover.png" alt="Remover" title="Remover" /></a>
					</td>
				</tr>
				<?php
				$oFiltro->MoveNext();
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