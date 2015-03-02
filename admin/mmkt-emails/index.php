<?php

$Chave = "mmkt-emails";
include("../verifica.php");
include_once("../../library/master-page.php");
include_once("../../library/paginator.php");
include_once("../../library/config/database/tmmktemail.php");
include_once("../../library/config/database/tmmktfiltro.php");


/**
 * REMOVER SELECIONADOS
**/
if($_POST)
{
	$cbItem = ((is_array($_POST["cbItem"])) ? $_POST["cbItem"] : array());
	if(count($cbItem) > 0)
	{
		$oEmailDel = new tmmktemail();
		foreach($cbItem as $v)
		{
			if($oEmailDel->LoadByPrimaryKey($v))
			{
				$oEmailDel->MarkAsDelete();
				$oEmailDel->Save();
			}
		}
		$oEmailDel->SetMessage("Vermelho", "Os itens selecionados foram removidos com sucesso.");
	}
}


/**
 * LISTA
***/
$oEmail = new tmmktemail();
$oEmail->SQLField = " DISTINCT(tmmktemail.ID) ";
$oEmail->SQLWhere = " 1 = 1 ";

$palavra = $_GET["palavra"];
$ativo = $_GET["ativo"];
$ordenar = $_GET["ordenar"];
$filtros = ((is_array($_GET["filtros"])) ? $_GET["filtros"] : array());
if($palavra)
{
	$oEmail->SQLWhere .= " AND (Nome LIKE '%" . $palavra . "%' OR Email LIKE '%" . $palavra . "%') ";
}
if($ativo)
{
	$oEmail->SQLWhere .= " AND Ativo = '" . (($ativo == "s") ? 1 : 0) . "' ";
}
if(count($filtros) > 0)
{
	$oEmail->SQLJoin .= " INNER JOIN tmmktemailfiltro ON tmmktemailfiltro.EmailID = tmmktemail.ID ";
	$oEmail->SQLWhere .= " AND (FiltroID = '" . implode("' OR FiltroID = '", $filtros) . "') ";
}

$oPaginator = new Paginator($oEmail->GetCount());
switch($ordenar)
{
	case "nomeza": $oEmail->SQLOrder = " Nome DESC "; break;
	case "maisnovos": $oEmail->SQLOrder = " DataHora DESC "; break;
	case "maisantigos": $oEmail->SQLOrder = " DataHora ASC "; break;
	default: $oEmail->SQLOrder = " Nome ASC "; $ordenar = "nomeaz"; break;
}
$oEmail->SQLGroup = " tmmktemail.ID ";
$oEmail->SQLOrder .= ", Nome ASC ";
$oEmail->LoadByPaginator($oPaginator->Limit, $oPaginator->Total);

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
					Ativo:
					<select id="ativo" name="ativo">
						<option value="" selected="selected">Todos</option>
						<option value="s" <?php if($ativo == "s") { ?> selected="selected" <?php } ?>>Sim</option>
						<option value="n" <?php if($ativo == "n") { ?> selected="selected" <?php } ?>>Não</option>
					</select>
				</label>
			</li>
			<li>
				<label>
					Ordenar por:
					<select id="ordenar" name="ordenar">
						<option value="nomeaz" <?php if($ordenar == "nomeaz") { ?> selected="selected" <?php } ?>>Nome (A - Z)</option>
						<option value="nomeza" <?php if($ordenar == "nomeza") { ?> selected="selected" <?php } ?>>Nome (Z - A)</option>
						<option value="maisnovos" <?php if($ordenar == "maisnovos") { ?> selected="selected" <?php } ?>>Mais novos</option>
						<option value="maisantigos" <?php if($ordenar == "maisantigos") { ?> selected="selected" <?php } ?>>Mais antigos</option>
					</select>
				</label>
			</li>
			<?php
			$oFiltro = new tmmktfiltro();
			$oFiltro->SQLOrder = "Titulo ASC";
			if($oFiltro->LoadSQLAssembled())
			{
			?>
				<li>
					Filtros:
					<table cellspacing="5">
						<tr>
							<?php
							for($c = 0; $c < $oFiltro->NumRows; $c++)
							{
								?>
								<td>
									<label>
										<input type="checkbox" name="filtros[]" value="<?=$oFiltro->ID;?>" <?php if(in_array($oFiltro->ID, $filtros)) { ?> checked="checked" <?php } ?> />
										<?=$oFiltro->Titulo;?>
									</label>
								</td>
								<?php
								if(($c + 1) % 3 == 0)
								{
									?>
									</tr>
									<tr>
									<?php
								}
								else
								{
									?>
									<td width="20">&nbsp;</td>
									<?php
								}
								$oFiltro->MoveNext();
							}
							?>
						</tr>
					</table>
				</li>
				<?php
			}
			?>
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
	<form action="" method="post">
		<input onclick="return conf();" type="image" src="../imgs/botoes/remover-selecionados.png" alt="Remover selecionados" title="Remover selecionados" />
		<br /><br />
		<table class="lista">
			<thead>
				<tr>
					<td width="20" align="center"><input type="checkbox" onclick="checkAll(this)" /></td>
					<td>E-mail</td>
					<td width="110">Ativo</td>
					<td width="220">Opções</td>
				</tr>
			</thead>
			<tbody>
				<?php
				for($c = 0; $c < $oEmail->NumRows; $c++)
				{
					$Param = "?" . $oPaginator->ParameterWithPage . "&id=" . $oEmail->ID;
					?>
					<tr>
						<td align="center"><input type="checkbox" name="cbItem[]" value="<?=$oEmail->ID;?>" class="cbItem" /></td>
						<td><?=$oEmail->Email;?></td>
						<td align="center">
							<a href="ativar.php<?=$Param;?>"><img src="../imgs/botoes/<?=(($oEmail->Ativo) ? "desativar" : "ativar");?>.png" alt="<?=(($oEmail->Ativo) ? "Desativar" : "Ativar");?>" title="<?=(($oEmail->Ativo) ? "Desativar" : "Ativar");?>" /></a>
						</td>
						<td align="center">
							<a href="novo.php<?=$Param;?>"><img src="../imgs/botoes/editar.png" alt="Editar" title="Editar" /></a>
							<a href="remover.php<?=$Param;?>" onclick="return conf();"><img src="../imgs/botoes/remover.png" alt="Remover" title="Remover" /></a>
						</td>
					</tr>
					<?php
					$oEmail->MoveNext();
				}
				?>
			</tbody>
		</table>
	</form>
	<?php
	echo $oPaginator->Result;
}
?>
<?php

$oMasterPage->Close("PageContent");
$oMasterPage->End();

?>