<?php

$Chave = "licitacoes";
include("../verifica.php");
include_once("../../library/master-page.php");
include_once("../../library/validator.php");
include_once("../../library/upload.php");
include_once("../../library/plugins/fckeditor/fckeditor.php");
include_once("../../library/config/database/tlicitacao.php");
include_once("../../library/config/database/tlicitacaoarquivo.php");

$oLicitacao = new tlicitacao();
$bEditar = $oLicitacao->LoadByPrimaryKey($_GET["id"]);

//post
$msg = "";
if($_POST)
{
	//variáveis
	$sStatus = $oLicitacao->Status;
	$oLicitacao->Status = $_POST["ddlStatus"];
	$oLicitacao->Modalidade = $_POST["ddlModalidade"];
	$oLicitacao->Numero = $_POST["txtNumero"];
	$oLicitacao->Objeto = $_POST["txtObjeto"];
	$oLicitacao->Questionamento = $_POST["txtQuestionamento"];
	$oLicitacao->Comunicado = $_POST["txtComunicado"];
	$oLicitacao->Andamento = $_POST["txtAndamento"];
	$txtArquivo = ((is_array($_POST["txtArquivo"])) ? $_POST["txtArquivo"] : array());
	$flArquivo = ((is_array($_FILES["flArquivo"])) ? $_FILES["flArquivo"] : array());
	$hidArquivo = ((is_array($_POST["hidArquivo"])) ? $_POST["hidArquivo"] : array());
	
	//validação
	$oValidator = new Validator();
	$oValidator->Add("Status", $oLicitacao->Status, true, null, "Selecione o status.");
	$oValidator->Add("Modalidade", $oLicitacao->Modalidade, true, null, "Selecione a modalidade.");
	$oValidator->Add("Numero", $oLicitacao->Numero, true, null, "Digite o número.");
	if($oValidator->Validate())
	{
		if(!$bEditar)
		{
			$oLicitacao->AddNew();
		}
		if(!$bEditar || $sStatus != $oLicitacao->Status)
		{
			$oLicitacao->Ordem = $oLicitacao->GetOrdem("Status = '" . $oLicitacao->Status . "'");
		}
		$oLicitacao->Save();
		
		//Remove
		$oLicitacaoArquivoDel = new tlicitacaoarquivo();
		if($oLicitacaoArquivoDel->LoadByLicitacaoID($oLicitacao->ID))
		{
			for($c = 0; $c < $oLicitacaoArquivoDel->NumRows; $c++)
			{
				if(!in_array($oLicitacaoArquivoDel->ID, $hidArquivo))
				{
					$oLicitacaoArquivoDel->RemoveFile("../.." . $oLicitacaoArquivoDel->Arquivo);
					$oLicitacaoArquivoDel->MarkAsDelete();
					$oLicitacaoArquivoDel->Save();
				}
				$oLicitacaoArquivoDel->MoveNext();
			}
		}
		
		//Add
		foreach($hidArquivo as $key => $value)
		{
			$oUpload = new Upload($flArquivo, $key);
			$bUpload = $oUpload->Validate(true, array("pdf", "doc", "xls", "ppt", "docx", "xlsx", "pptx"));
			
			$oLicitacaoArquivoAdd = new tlicitacaoarquivo();
			if(!$oLicitacaoArquivoAdd->LoadByPrimaryKey($value))
			{
				if($bUpload)
				{
					$oLicitacaoArquivoAdd->AddNew();
					$oLicitacaoArquivoAdd->LicitacaoID = $oLicitacao->ID;
					$oLicitacaoArquivoAdd->Titulo = $txtArquivo[$key];
					$oLicitacaoArquivoAdd->Arquivo = $oUpload->Save($Chave, $oLicitacaoArquivoAdd->Arquivo);
					$oLicitacaoArquivoAdd->Save();
				}
			}
			else
			{
				$oLicitacaoArquivoAdd->Titulo = $txtArquivo[$key];
				$oLicitacaoArquivoAdd->Arquivo = $oUpload->Save($Chave, $oLicitacaoArquivoAdd->Arquivo);
				$oLicitacaoArquivoAdd->Save();
			}
		}
		
		//redireciona
		$oLicitacao->SetMessage((($bEditar) ? "Azul" : "Verde"));
		header("Location: " . (($_POST["hFA"] == "outro") ? "novo.php" : "index.php?" . $_SERVER["QUERY_STRING"]));
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
<?=$msg;?>
<p>Preencha corretamente os campos abaixo:</p> (Os campos com * são obrigatórios)
<form action="" method="post" class="formMensagem" enctype="multipart/form-data">
	<fieldset>
		<legend>Informações</legend>
		<div class="margem">
			<ul>
				<li>
					<label>
						Status*:
						<select id="ddlStatus" name="ddlStatus" class="{required:true, focus:true}" title="Selecione o status.">
							<option value="" selected="selected">Selecione</option>
							<?php
							foreach($oLicitacao->StatusLista as $c => $v)
							{
								?>
								<option value="<?=$c;?>" <?php if($c == $oLicitacao->Status) { ?> selected="selected" <?php } ?>><?=$v;?></option>
								<?php
							}
							?>
						</select>
					</label>
				</li>
		    	<li>
					<label>
						Modalidade*:
						<select id="ddlModalidade" name="ddlModalidade" class="{required:true}" title="Selecione a modalidade.">
							<option value="" selected="selected">Selecione</option>
							<?php
							foreach($oLicitacao->ModalidadeLista as $c => $v)
							{
								?>
								<option value="<?=$c;?>" <?php if($c == $oLicitacao->Modalidade) { ?> selected="selected" <?php } ?>><?=$v;?></option>
								<?php
							}
							?>
						</select>
					</label>
				</li>
				<li>
					<label>
						Número*:
						<input size="50" maxlength="50" type="text" id="txtNumero" name="txtNumero" value="<?=$oLicitacao->Numero;?>" class="{required:true}" title="Digite o número." />
					</label>
				</li>
				<li>
					<label>
						Objeto:
						<?php
						$oEditor = new FCKeditor("txtObjeto");
						$oEditor->BasePath = "../../library/plugins/fckeditor/";
						$oEditor->Value = $oLicitacao->HTMLDecode($oLicitacao->Objeto);
						$oEditor->ToolbarSet = "Basico";
						$oEditor->Height = "250";
						$oEditor->Create();
						?>
					</label>
				</li>
				<li>
					<label>
						Questionamento:
						<?php
						$oEditor = new FCKeditor("txtQuestionamento");
						$oEditor->BasePath = "../../library/plugins/fckeditor/";
						$oEditor->Value = $oLicitacao->HTMLDecode($oLicitacao->Questionamento);
						$oEditor->ToolbarSet = "Basico";
						$oEditor->Height = "250";
						$oEditor->Create();
						?>
					</label>
				</li>
				<li>
					<label>
						Comunicado:
						<?php
						$oEditor = new FCKeditor("txtComunicado");
						$oEditor->BasePath = "../../library/plugins/fckeditor/";
						$oEditor->Value = $oLicitacao->HTMLDecode($oLicitacao->Comunicado);
						$oEditor->ToolbarSet = "Basico";
						$oEditor->Height = "250";
						$oEditor->Create();
						?>
					</label>
				</li>
				<li>
					<label>
						Status:
						<?php
						$oEditor = new FCKeditor("txtAndamento");
						$oEditor->BasePath = "../../library/plugins/fckeditor/";
						$oEditor->Value = $oLicitacao->HTMLDecode($oLicitacao->Andamento);
						$oEditor->ToolbarSet = "Basico";
						$oEditor->Height = "250";
						$oEditor->Create();
						?>
					</label>
				</li>
		    </ul>
	    </div>
	</fieldset>
    <fieldset>
		<legend>Arquivos</legend>
		<div class="margem">
			<ul>
				<li>
					<table class="lista" style="width:auto;">
						<thead>
							<tr>
								<td>Título</td>
								<td>Arquivo</td>
								<td>Opções</td>
							</tr>
						</thead>
						<tbody>
							<?php
							$oLicitacaoArquivo = new tlicitacaoarquivo();
							$oLicitacaoArquivo->LoadByLicitacaoID($oLicitacao->ID);
							$TotalArquivo = (($oLicitacaoArquivo->NumRows > 0) ? $oLicitacaoArquivo->NumRows : 1);
							for($c = 0; $c < $TotalArquivo; $c++)
							{
								?>
								<tr>
									<td><input size="30" maxlength="50" type="text" name="txtArquivo[]" value="<?=$oLicitacaoArquivo->Titulo;?>" /></td>
									<td><input size="30" type="file" name="flArquivo[]" /></td>
									<td align="center">
										<?php if($oLicitacaoArquivo->Arquivo) { ?><a href="<?=$oLicitacaoArquivo->DownloadURL($oLicitacaoArquivo->Arquivo);?>" class="remove"><img src="../imgs/icones16x16/down_16x16.gif" alt="Download" title="Download" /></a> <?php } ?>
										<a href="javascript:void(0);" onclick="addDefault($(this).parent().parent())" class="add" <?php if(($c + 1) < $TotalArquivo) { ?> style="display:none;" <?php } ?>><img src="../imgs/icones16x16/add_16x16.gif" alt="Adicionar" title="Adicionar" /></a>
										<a href="javascript:void(0);" onclick="delDefault($(this).parent().parent())" class="del" <?php if(($c + 1) >= $TotalArquivo) { ?> style="display:none;" <?php } ?>><img src="../imgs/icones16x16/delete_16x16.gif" alt="Remover" title="Remover" /></a>
										<input type="hidden" name="hidArquivo[]" value="<?=$oLicitacaoArquivo->ID;?>" />
									</td>
								</tr>
								<?php
								$oLicitacaoArquivo->MoveNext();
							}
							?>
						</tbody>
					</table>
				</li>
			</ul>
		</div>
	</fieldset>
    <input type="hidden" id="hFA" name="hFA" />
	<input onclick="$('#hFA').val('outro')" type="image" src="../imgs/botoes/enviar-e-cadastrar-outro.png" alt="Enviar e Cadastrar outro" title="Enviar e Cadastrar outro" />
    <input onclick="$('#hFA').val('enviar')" type="image" src="../imgs/botoes/enviar.png" alt="Enviar" title="Enviar" />
    <a href="index.php?<?=$_SERVER["QUERY_STRING"];?>"><img src="../imgs/botoes/voltar.png" alt="Voltar" title="Voltar" /></a>
</form>
<?php

$oMasterPage->Close("PageContent");
$oMasterPage->End();

?>