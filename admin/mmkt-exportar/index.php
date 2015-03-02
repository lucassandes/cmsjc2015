<?php

$Chave = "mmkt-exportar";
include("../verifica.php");
include_once("../../library/master-page.php");
include_once("../../library/paginator.php");
include_once("../../library/validator.php");
include_once("../../library/config/database/tmmktemail.php");
include_once("../../library/config/database/tmmktexportar.php");
include_once("../../library/config/database/tmmktexportarfiltro.php");
include_once("../../library/config/database/tmmktfiltro.php");

$oExportarDownload = new tmmktexportar();
if($oExportarDownload->LoadByPrimaryKey($_GET["id"]))
{
	header("Location: " . $oExportarDownload->DownloadURL($oExportarDownload->Arquivo));
	exit();
}

//post
$msg = "";
if($_POST)
{
	//variáveis
	$ddlDelimitadorCampo = $_POST["ddlDelimitadorCampo"];
	$ddlDelimitadorTexto = $_POST["ddlDelimitadorTexto"];
	$cbColunaEmail = intval($_POST["cbColunaEmail"]);
	$cbColunaNome = intval($_POST["cbColunaNome"]);
	$cbColunaDia = intval($_POST["cbColunaDia"]);
	$cbColunaMes = intval($_POST["cbColunaMes"]);
	$cbFiltro = ((is_array($_POST["cbFiltro"])) ? $_POST["cbFiltro"] : array());
	
	//validação
	$oValidator = new Validator();
	//$oValidator->Add("Filtro", (count($cbFiltro) > 0), true, null, "Selecione pelo menos um filtro.");
	if($oValidator->Validate())
	{
		$conteudo = "";
		$delimiter = (($ddlDelimitadorCampo == "virgula") ? "," : ";");
		$enclosure = (($ddlDelimitadorTexto == "aspas-simples") ? "'" : '"');
		
		//e-mails
		$oEmail = new tmmktemail();
		if(count($cbFiltro) > 0)
		{
			$oEmail->SQLJoin = "INNER JOIN tmmktemailfiltro ON tmmktemailfiltro.EmailID = tmmktemail.ID";
			$oEmail->SQLWhere = "(FiltroID = '" . implode("' OR FiltroID = '", $cbFiltro) . "') AND tmmktemail.Ativo = 1";
		}
		else
		{
			$oEmail->SQLJoin = "LEFT JOIN tmmktemailfiltro ON tmmktemailfiltro.EmailID = tmmktemail.ID";
			$oEmail->SQLWhere = "FiltroID IS NULL AND tmmktemail.Ativo = 1";
		}
		$oEmail->SQLGroup = "tmmktemail.Email";
		$oEmail->SQLOrder = "Nome ASC";
		$oEmail->LoadSQLAssembled();
		for($c = 0; $c < $oEmail->NumRows; $c++)
		{
			$ar = array();
			if($cbColunaEmail) array_push($ar, $oEmail->Email);
			if($cbColunaNome) array_push($ar, $oEmail->Nome);
			if($cbColunaDia) array_push($ar, $oEmail->Dia);
			if($cbColunaMes) array_push($ar, $oEmail->Mes);
			$conteudo .= $enclosure . implode($enclosure . $delimiter . $enclosure, $ar) . $enclosure . "\r\n";
			$oEmail->MoveNext();
		}
		
		//cria arquivo csv
		$arquivo = $oEmail->GenerateFilePath($Chave, null, "csv");
		$fp = fopen($arquivo, "w+");
		fwrite($fp, $conteudo);
        fclose($fp);
		
		//exportação
		$oExportar = new tmmktexportar();
		$oExportar->AddNew();
	    $oExportar->Arquivo = $oExportar->ParseFilePath($arquivo);
		$oExportar->Total = $oEmail->NumRows;
		$oExportar->DataHora = date("Y-m-d H:i:s");
		$oExportar->Save();
        	
	    //filtros
	    if(count($cbFiltro) > 0)
	    {
			foreach($cbFiltro as $c => $v)
			{
				$oExportarFiltro = new tmmktexportarfiltro();
				$oExportarFiltro->AddNew();
				$oExportarFiltro->ExportarID = $oExportar->ID;
				$oExportarFiltro->FiltroID = $v;
				$oExportarFiltro->Save();
			}
		}
		
		//redireciona
		$oExportar->SetMessage("Verde");
		header("Location: index.php?id=" . $oExportar->ID);
		exit();
	}
	else
	{
		$msg = $oValidator->Create();
	}
}

$oMasterPage = new MasterPage();
$oMasterPage->Init("../master.php");
$oMasterPage->AddParameter("Chave", $Chave);
$oMasterPage->Open("PageContent");

?>

<!-- Histórico de Exportações -->
<fieldset>
	<legend><a href="javascript:void(0);" onclick="slideArea(this)" <?php if($oExportarDownload->NumRows > 0) { ?> class="menos" <?php } ?>>Histórico de Exportações</a></legend>
	<div class="margem" style="display:<?=(($oExportarDownload->NumRows > 0) ? "block" : "none");?>;">
		<?php
		$oExportar = new tmmktexportar();
		$oPaginator = new Paginator($oExportar->GetCount());
		$oExportar->SQLOrder = "DataHora DESC";
		echo $oPaginator->Result;
		if($oExportar->LoadByPaginator($oPaginator->Limit, $oPaginator->Total))
		{
			?>
			<table class="lista">
				<thead>
					<tr>
						<td width="120">Data</td>
						<td width="100">Total de E-mails</td>
						<td>Filtros</td>
						<td width="80">Opções</td>
					</tr>
				</thead>
				<tbody>
					<?php
					for($c = 0; $c < $oExportar->NumRows; $c++)
					{
						?>
						<tr>
							<td align="center"><?=date("d/m/Y \à\s H:i", $oExportar->DateShow($oExportar->DataHora));?></td>
							<td align="center"><?=$oExportar->Total;?></td>
							<td>
								<?php
								$oExportarFiltro = new tmmktexportarfiltro();
								if($oExportarFiltro->LoadWithFiltroByExportarID($oExportar->ID))
								{
									for($a = 0; $a < $oExportarFiltro->NumRows; $a++)
									{
										echo $oExportarFiltro->Filtro . ((($a + 1) < $oExportarFiltro->NumRows) ? ", " : "");
										$oExportarFiltro->MoveNext();
									}
								}
								else
								{
									?>
									Nenhum
									<?php
								}
								?>
							</td>
							<td align="center"><a href="?id=<?=$oExportar->ID;?>"><img src="../imgs/botoes/download.png" alt="Download" title="Download" /></a></td>
						</tr>
						<?php
						$oExportar->MoveNext();
					}
					?>
				</tbody>
			</table>
			<?php
			echo $oPaginator->Result;
		}
		?>
	</div>
</fieldset>


<!-- Nova Exportação -->
<fieldset>
	<legend>Nova Exportação</legend>
	<div class="margem">
		<?=$msg;?>
		<p>Preencha corretamente os campos abaixo:</p> (Os campos com * são obrigatórios)
		<br clear="all" />
		<br clear="all" /> 
		<form action="" method="post" class="formMensagem">
			<ul>
				<li class="left">
					<label>
						Delimitador de campo*:
						<select id="ddlDelimitadorCampo" name="ddlDelimitadorCampo" class="{focus:true}">
							<option <?php if($ddlDelimitadorCampo == "virgula") { ?> selected="selected" <?php } ?> value="virgula">Vírgula (,)</option>
							<option <?php if($ddlDelimitadorCampo == "ponto-e-virgula") { ?> selected="selected" <?php } ?> value="ponto-e-virgula">Ponto e Vírgula (;)</option>
						</select>
					</label>
				</li>
				<li>
					<label>
						Delimitador de texto*:
						<select id="ddlDelimitadorTexto" name="ddlDelimitadorTexto">
							<option <?php if($ddlDelimitadorTexto == "aspas-simples") { ?> selected="selected" <?php } ?> value="aspas-simples">Aspas simples (')</option>
							<option <?php if($ddlDelimitadorTexto == "aspas-duplas") { ?> selected="selected" <?php } ?> value="aspas-duplas">Aspas duplas (")</option>
						</select>
					</label>
				</li>
				<li>
					Marque abaixo as colunas desejadas para exportação:
					<br /><br />
					<table class="lista" style="width:200px;">
						<thead>
							<tr>
								<td width="50"><label for="cbColunaEmail">E-mail</label></td>
								<td width="50"><label for="cbColunaNome">Nome</label></td>
								<td width="50"><label for="cbColunaDia">Dia</label></td>
								<td width="50"><label for="cbColunaMes">Mês</label></td>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td align="center"><input type="checkbox" id="cbColunaEmail" name="cbColunaEmail" value="1" <?php if($cbColunaEmail) { ?> checked="checked" <?php } ?> /></td>
								<td align="center"><input type="checkbox" id="cbColunaNome" name="cbColunaNome" value="1" <?php if($cbColunaNome) { ?> checked="checked" <?php } ?> /></td>
								<td align="center"><input type="checkbox" id="cbColunaDia" name="cbColunaDia" value="1" <?php if($cbColunaDia) { ?> checked="checked" <?php } ?> /></td>
								<td align="center"><input type="checkbox" id="cbColunaMes" name="cbColunaMes" value="1" <?php if($cbColunaMes) { ?> checked="checked" <?php } ?> /></td>
							</tr>
						</tbody>
					</table>
				</li>
				<?php
				$oFiltro = new tmmktfiltro();
				$oFiltro->SQLField = "*, FiltroTotalEmail(ID) AS TotalEmail";
				$oFiltro->SQLOrder = "Titulo ASC";
				if($oFiltro->LoadSQLAssembled())
				{
					?>
					<li>
						<fieldset>
							<legend>Filtros</legend>
							<div class="margem">
								<table cellspacing="5">
									<tr>
										<?php
										for($c = 0; $c < $oFiltro->NumRows; $c++)
										{
											?>
											<td>
												<label>
													<input type="checkbox" name="cbFiltro[]" value="<?=$oFiltro->ID;?>" <?php if(in_array($oFiltro->ID, ((is_array($cbFiltro)) ? $cbFiltro : array()))) { ?> checked="checked" <?php } ?> class="{required:false}" title="Selecione pelo menos um filtro." />
													<?=$oFiltro->Titulo;?> (<?=$oFiltro->TotalEmail;?>)
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
							</div>
						</fieldset>
					</li>
					<?php
				}
				?>
			</ul>
		    <input type="image" src="../imgs/botoes/exportar.png" alt="Exportar" title="Exportar" />
		</form>
	</div>
</fieldset>
<?php

$oMasterPage->Close("PageContent");
$oMasterPage->End();

?>