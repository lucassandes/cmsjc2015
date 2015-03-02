<?php

$Chave = "mmkt-importar";
include("../verifica.php");
include_once("../../library/master-page.php");
include_once("../../library/paginator.php");
include_once("../../library/validator.php");
include_once("../../library/upload.php");
include_once("../../library/config/database/tmmktemail.php");
include_once("../../library/config/database/tmmktimportar.php");
include_once("../../library/config/database/tmmktimportarfiltro.php");
include_once("../../library/config/database/tmmktfiltro.php");

//post
$msg = "";
if($_POST)
{
	//variáveis
	$ddlDelimitadorCampo = $_POST["ddlDelimitadorCampo"];
	$ddlDelimitadorTexto = $_POST["ddlDelimitadorTexto"];
	$txtColunaEmail = intval($_POST["txtColunaEmail"]);
	$txtColunaNome = intval($_POST["txtColunaNome"]);
	$txtColunaDia = intval($_POST["txtColunaDia"]);
	$txtColunaMes = intval($_POST["txtColunaMes"]);
	$cbFiltro = ((is_array($_POST["cbFiltro"])) ? $_POST["cbFiltro"] : array());
	
	//validação
	$oValidator = new Validator();
	
	$oUpload = new Upload($_FILES["flArquivo"]);
	if(!$oUpload->Validate(true, array("csv")))
	{
		$oValidator->AddMessage("Arquivo", $oUpload->Message);
	}
	
	$oValidator->Add("ColunaEmail", $txtColunaEmail, true, "number", "Digite o nº da coluna e-mail corretamente.");
	$oValidator->Add("ColunaNome", $txtColunaNome, false, "number", "Digite o nº da coluna nome corretamente.");
	$oValidator->Add("ColunaDia", $txtColunaDia, false, "number", "Digite o nº da coluna dia corretamente.");
	$oValidator->Add("ColunaMes", $txtColunaMes, false, "number", "Digite o nº da coluna mês corretamente.");
	$oValidator->Add("Filtro", (count($cbFiltro) > 0), true, null, "Selecione pelo menos um filtro.");
	if($oValidator->Validate())
	{
		$oImportar = new tmmktimportar();
		$oImportar->AddNew();
	    $oImportar->Arquivo = $oUpload->Save($Chave);
		$oImportar->Total = 0;
		$oImportar->TotalInvalido = 0;
		$oImportar->TotalJaCadastrado = 0;
		$oImportar->TotalImportado = 0;
		$oImportar->DataHora = date("Y-m-d H:i:s");
		
		//processa
		if(($handle = fopen("../.." . $oImportar->Arquivo, "r")) !== false)
		{
			$delimiter = (($ddlDelimitadorCampo == "virgula") ? "," : ";");
			$enclosure = (($ddlDelimitadorTexto == "aspas-simples") ? "'" : '"');
			
			//conteúdo do csv para estatísticas
			$importado = "";
			$jacadastrado = "";
			$invalido = "";
			
			//linhas
		    while (($data = fgetcsv($handle, 0, $delimiter, $enclosure)) !== false)
			{
				//campos
				$Email = trim($data[$txtColunaEmail - 1]);
				$Nome = trim($data[$txtColunaNome - 1]);
				$Dia = intval($data[$txtColunaDia - 1]);
				$Mes = intval($data[$txtColunaMes - 1]);
				
				//total
				$oImportar->Total++;
				
				//insere e-mail para cada filtro
				foreach($cbFiltro as $v)
				{
					$conteudo = implode(";", array($Email, $Nome, $Dia, $Mes)) . "\r\n";
					
					//cria e-mail
					switch(tmmktemail::Create($Email, $Nome, null, $v, $Dia, $Mes))
					{
						case tmmktemail::CREATE_SUCCESS:
							 $oImportar->TotalImportado++;
							 $importado .= $conteudo;
							 break;
						case tmmktemail::CREATE_ERROR:
							 $oImportar->TotalJaCadastrado++;
							 $jacadastrado .= $conteudo;
							 break;
						case tmmktemail::CREATE_INVALID:
							 $oImportar->TotalInvalido++;
							 $invalido .= $conteudo;
							 break;
					}
				}
		    }
		    fclose($handle);
		    
			//importação
		    $oImportar->Save();
		    
		    //cria csv para estatísticas
		    $fp = fopen($oImportar->GenerateFilePath($Chave . "/importado", $oImportar->ID, "csv"), "w+");
		    fwrite($fp, $importado);
        	fclose($fp);
        	
        	$fp = fopen($oImportar->GenerateFilePath($Chave . "/jacadastrado", $oImportar->ID, "csv"), "w+");
		    fwrite($fp, $jacadastrado);
        	fclose($fp);
        	
        	$fp = fopen($oImportar->GenerateFilePath($Chave . "/invalido", $oImportar->ID, "csv"), "w+");
		    fwrite($fp, $invalido);
        	fclose($fp);
        	
		    //filtros da importação
			foreach($cbFiltro as $c => $v)
			{
				$oImportarFiltro = new tmmktimportarfiltro();
				$oImportarFiltro->AddNew();
				$oImportarFiltro->ImportarID = $oImportar->ID;
				$oImportarFiltro->FiltroID = $v;
				$oImportarFiltro->Save();
			}
			
			//redireciona
			$oImportar->SetMessage("Verde");
			header("Location: index.php?historico=1");
			exit();
		}
		else
		{
			//mensagem de erro
			$msg = $oImportar->CreateMessage("Amarelo", "Problemas com o arquivo csv.");
		}	
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

<!-- Histórico de Importações -->
<fieldset>
	<legend><a href="javascript:void(0);" onclick="slideArea(this)" <?php if($_GET["historico"] == "1") { ?> class="menos" <?php } ?>>Histórico de Importações</a></legend>
	<div class="margem" style="display:<?=(($_GET["historico"] == "1") ? "block" : "none");?>;">
		<?php
		$oImportar = new tmmktimportar();
		$oPaginator = new Paginator($oImportar->GetCount());
		$oImportar->SQLOrder = "DataHora DESC";
		echo $oPaginator->Result;
		if($oImportar->LoadByPaginator($oPaginator->Limit, $oPaginator->Total))
		{
			?>
			<table class="lista">
				<thead>
					<tr>
						<td width="120">Data</td>
						<td width="100">Total de E-mails</td>
						<td width="80">Inválidos</td>
						<td width="80">Já cadastrados</td>
						<td width="80">Importado</td>
						<td>Filtros</td>
					</tr>
				</thead>
				<tbody>
					<?php
					for($c = 0; $c < $oImportar->NumRows; $c++)
					{
						?>
						<tr>
							<td align="center"><?=date("d/m/Y \à\s H:i", $oImportar->DateShow($oImportar->DataHora));?></td>
							<td align="center"><?=$oImportar->Total;?></td>
							<td align="center"><a href="javascript:void(0);" onclick="window.open('e-mails.php?id=<?=$oImportar->ID;?>&tipo=invalido', 'importar', 'toolbar=0, location=0, directories=0, status=0, menubar=0, scrollbars=1, resizable=0, width=770, height=440, top=0, left=0');"><?=$oImportar->TotalInvalido;?></a></td>
							<td align="center"><a href="javascript:void(0);" onclick="window.open('e-mails.php?id=<?=$oImportar->ID;?>&tipo=jacadastrado', 'importar', 'toolbar=0, location=0, directories=0, status=0, menubar=0, scrollbars=1, resizable=0, width=770, height=440, top=0, left=0');"><?=$oImportar->TotalJaCadastrado;?></a></td>
							<td align="center"><a href="javascript:void(0);" onclick="window.open('e-mails.php?id=<?=$oImportar->ID;?>&tipo=importado', 'importar', 'toolbar=0, location=0, directories=0, status=0, menubar=0, scrollbars=1, resizable=0, width=770, height=440, top=0, left=0');"><?=$oImportar->TotalImportado;?></a></td>
							<td>
								<?php
								$oImportarFiltro = new tmmktimportarfiltro();
								if($oImportarFiltro->LoadWithFiltroByImportarID($oImportar->ID))
								{
									for($a = 0; $a < $oImportarFiltro->NumRows; $a++)
									{
										echo $oImportarFiltro->Filtro . ((($a + 1) < $oImportarFiltro->NumRows) ? ", " : "");
										$oImportarFiltro->MoveNext();
									}
								}
								?>
							</td>
						</tr>
						<?php
						$oImportar->MoveNext();
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


<!-- Nova Importação -->
<fieldset>
	<legend>Nova Importação</legend>
	<div class="margem">
		<?=$msg;?>
		<p>Preencha corretamente os campos abaixo:</p> (Os campos com * são obrigatórios)
		<div class="mensagem">
			<div class="amarelo">
				<span>Atenção!</span>
				Selecione um arquivo csv seguindo o exemplo abaixo:<br /><br />
				<img src="exemplo.png" alt="" title="" />
				<br /><br />
				OBS: Apenas a coluna e-mail é obrigatória
			</div>
		</div>
		<form action="" method="post" class="formMensagem" enctype="multipart/form-data">
			<ul>
		    	<li>
					<label>
						Arquivo* (*.csv):
						<input size="60" type="file" id="flArquivo" name="flArquivo" class="{focus:true, required:true, accept:'csv'}" title="Selecione o arquivo corretamente." />
					</label>
				</li>
				<li class="left">
					<label>
						Delimitador de campo*:
						<select id="ddlDelimitadorCampo" name="ddlDelimitadorCampo">
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
					Digite abaixo as posições das colunas no seu arquivo csv:
					<br /><br />
					<table class="lista" style="width:200px;">
						<thead>
							<tr>
								<td width="50"><label for="txtColunaEmail">E-mail*</label></td>
								<td width="50"><label for="txtColunaNome">Nome</label></td>
								<td width="50"><label for="txtColunaDia">Dia</label></td>
								<td width="50"><label for="txtColunaMes">Mês</label></td>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td align="center"><input size="2" maxlength="2" type="text" id="txtColunaEmail" name="txtColunaEmail" value="<?=((intval($txtColunaEmail) < 1) ? 1 : $txtColunaEmail);?>" class="{required:true, numeric:true, number:true}" title="Digite o nº da coluna e-mail corretamente." /></td>
								<td align="center"><input size="2" maxlength="2" type="text" id="txtColunaNome" name="txtColunaNome" value="<?=$txtColunaNome;?>" class="{numeric:true, number:true}" title="Digite o nº da coluna nome corretamente." /></td>
								<td align="center"><input size="2" maxlength="2" type="text" id="txtColunaDia" name="txtColunaDia" value="<?=$txtColunaDia;?>" class="{numeric:true, number:true}" title="Digite o nº da coluna dia corretamente." /></td>
								<td align="center"><input size="2" maxlength="2" type="text" id="txtColunaMes" name="txtColunaMes" value="<?=$txtColunaMes;?>" class="{numeric:true, number:true}" title="Digite o nº da coluna mês corretamente." /></td>
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
							<legend>Filtros*</legend>
							<div class="margem">
								<table cellspacing="5">
									<tr>
										<?php
										for($c = 0; $c < $oFiltro->NumRows; $c++)
										{
											?>
											<td>
												<label>
													<input type="checkbox" name="cbFiltro[]" value="<?=$oFiltro->ID;?>" <?php if(in_array($oFiltro->ID, ((is_array($cbFiltro)) ? $cbFiltro : array()))) { ?> checked="checked" <?php } ?> class="{required:true}" title="Selecione pelo menos um filtro." />
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
		    <input type="image" src="../imgs/botoes/importar.png" alt="Importar" title="Importar" />
		</form>
	</div>
</fieldset>
<?php

$oMasterPage->Close("PageContent");
$oMasterPage->End();

?>