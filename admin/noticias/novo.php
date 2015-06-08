<?php

$Chave = "noticias";
include("../verifica.php");
include_once("../../library/master-page.php");
include_once("../../library/validator.php");
include_once("../../library/upload.php");
include_once("../../library/plugins/fckeditor/fckeditor.php");
include_once("../../library/config/database/tgaleria.php");
include_once("../../library/config/database/tnoticia.php");
include_once("../../library/config/database/tnoticiaarquivo.php");

$oNoticia = new tnoticia();
$bEditar = $oNoticia->LoadByPrimaryKey($_GET["id"]);

//post
$msg = "";
if($_POST)
{
	//variáveis
	$oNoticia->Data = $_POST["txtData"];
	$oNoticia->Hora = $_POST["txtHora"];
	$oNoticia->Titulo = $_POST["txtTitulo"];
	$oNoticia->Subtitulo = $_POST["txtSubtitulo"];
	$oNoticia->GaleriaID = ((intval($_POST["ddlGaleria"])) ? intval($_POST["ddlGaleria"]) : null);
	$oNoticia->Video = $_POST["txtVideo"];
	$oNoticia->Descricao = $_POST["txtDescricao"];
	$oNoticia->Destaque = ((intval($_POST["cbDestaque"])) ? 1 : null);
	$oNoticia->Destaque2 = ((intval($_POST["cbDestaque2"])) ? 1 : null);
	$txtArquivo = ((is_array($_POST["txtArquivo"])) ? $_POST["txtArquivo"] : array());
	$flArquivo = ((is_array($_FILES["flArquivo"])) ? $_FILES["flArquivo"] : array());
	$hidArquivo = ((is_array($_POST["hidArquivo"])) ? $_POST["hidArquivo"] : array());
	
	//validação
	$oValidator = new Validator();
	$oValidator->Add("Data", $oNoticia->Data, true, "date", "Digite a data corretamente.");
	$oValidator->Add("Hora", $oNoticia->Hora, false, "time", "Digite a hora corretamente.");
	$oValidator->Add("Titulo", $oNoticia->Titulo, true, null, "Digite o título.");
	
	$oUploadImagem = new Upload($_FILES["flImagem"]);
	if(!$oUploadImagem->Validate(false, array("jpg", "jpeg", "gif")))
	{
		$oValidator->AddMessage("Imagem", $oUploadImagem->Message);
	}
	
	$oUploadAudio = new Upload($_FILES["flAudio"]);
	if(!$oUploadAudio->Validate(false, array("mp3")))
	{
		$oValidator->AddMessage("Audio", $oUploadAudio->Message);
	}
	
	$oUploadImagemDestaque = new Upload($_FILES["flImagemDestaque"]);
	if(!$oUploadImagemDestaque->Validate($oNoticia->Destaque && !$oNoticia->ImagemDestaque, array("jpg", "jpeg", "gif")))
	{
		$oValidator->AddMessage("ImagemDestaque", $oUploadImagemDestaque->Message);
	}
	
	$oUploadImagemDestaque2 = new Upload($_FILES["flImagemDestaque2"]);
	if(!$oUploadImagemDestaque2->Validate($oNoticia->Destaque2 && !$oNoticia->ImagemDestaque2, array("jpg", "jpeg", "gif")))
	{
		$oValidator->AddMessage("ImagemDestaque2", $oUploadImagemDestaque2->Message);
	}
	
	if($oValidator->Validate())
	{
		if(!$bEditar)
		{
			$oNoticia->AddNew();
		}
		$oNoticia->Data = $oNoticia->DateConvert($oNoticia->Data);
		$oNoticia->Imagem = $oUploadImagem->Save($Chave, $oNoticia->Imagem);
		$oNoticia->Audio = $oUploadAudio->Save($Chave, $oNoticia->Audio);
		$oNoticia->ImagemDestaque = $oUploadImagemDestaque->Save($Chave, $oNoticia->ImagemDestaque);
		$oNoticia->ImagemDestaque2 = $oUploadImagemDestaque2->Save($Chave, $oNoticia->ImagemDestaque2);
		$oNoticia->Save();
		
		//Remove
		$oNoticiaArquivoDel = new tnoticiaarquivo();
		if($oNoticiaArquivoDel->LoadByNoticiaID($oNoticia->ID))
		{
			for($c = 0; $c < $oNoticiaArquivoDel->NumRows; $c++)
			{
				if(!in_array($oNoticiaArquivoDel->ID, $hidArquivo))
				{
					$oNoticiaArquivoDel->RemoveFile("../.." . $oNoticiaArquivoDel->Arquivo);
					$oNoticiaArquivoDel->MarkAsDelete();
					$oNoticiaArquivoDel->Save();
				}
				$oNoticiaArquivoDel->MoveNext();
			}
		}
		
		//Add
		foreach($hidArquivo as $key => $value)
		{
			$oUpload = new Upload($flArquivo, $key);
			$bUpload = $oUpload->Validate(true, array("pdf", "doc", "xls", "ppt", "docx", "xlsx", "pptx"));
			
			$oNoticiaArquivoAdd = new tnoticiaarquivo();
			if(!$oNoticiaArquivoAdd->LoadByPrimaryKey($value))
			{
				if($bUpload)
				{
					$oNoticiaArquivoAdd->AddNew();
					$oNoticiaArquivoAdd->NoticiaID = $oNoticia->ID;
					$oNoticiaArquivoAdd->Titulo = $txtArquivo[$key];
					$oNoticiaArquivoAdd->Arquivo = $oUpload->Save($Chave, $oNoticiaArquivoAdd->Arquivo);
					$oNoticiaArquivoAdd->Save();
				}
			}
			else
			{
				$oNoticiaArquivoAdd->Titulo = $txtArquivo[$key];
				$oNoticiaArquivoAdd->Arquivo = $oUpload->Save($Chave, $oNoticiaArquivoAdd->Arquivo);
				$oNoticiaArquivoAdd->Save();
			}
		}
		
		//redireciona
		$oNoticia->SetMessage((($bEditar) ? "Azul" : "Verde"));
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
				<li class="left">
					<label>
						Data*:
						<br /><input style="display:inline;" size="12" maxlength="10" type="text" id="txtData" name="txtData" value="<?=(($oNoticia->Data != "" && $oNoticia->Data != "0000-00-00") ? (($_POST) ? $oNoticia->Data : date("d/m/Y", $oNoticia->DateShow($oNoticia->Data))) : date("d/m/Y"));?>" class="{required:true, dateBR:true, mask:'99/99/9999'}" title="Digite a data corretamente." />
						<a href="javascript:void(0);" class="datePicker {target:'#txtData'}"></a><br />
						<sub>(Ex.: dd/mm/yyyy)</sub>
					</label>
				</li>
				<li>
					<label>
						Hora*:
						<input size="5" maxlength="5" type="text" id="txtHora" name="txtHora" value="<?=(($oNoticia->Hora != "" && $oNoticia->Hora != "00:00:00") ? (($_POST) ? $oNoticia->Hora : substr($oNoticia->Hora, 0, 5)) : (($bEditar) ? "" : date("H:i")));?>" class="{time:true, mask:'99:99'}" title="Digite a hora corretamente." />
						<sub>(Ex.: 99:99)</sub>
					</label>
				</li>
				<li class="clear"></li>
		    	<li>
					<label>
						Título*:
						<input size="60" maxlength="150" type="text" id="txtTitulo" name="txtTitulo" value="<?=$oNoticia->Titulo;?>" class="{required:true}" title="Digite o título." />
					</label>
				</li>
				<li>
					<label>
						Subtítulo:
						<input size="60" maxlength="150" type="text" id="txtSubtitulo" name="txtSubtitulo" value="<?=$oNoticia->Subtitulo;?>" />
					</label>
				</li>
				<li>
					<label>
						Imagem (*.jpg, *.jpeg, *.gif):
						<input size="60" type="file" id="flImagem" name="flImagem" class="{accept:'jpg|jpeg|gif'}" title="Selecione a imagem corretamente." />
						<?php
						if($oNoticia->Imagem)
						{
							?>
							<br />
							<a title="<?=$oNoticia->Titulo;?>" rel="lightbox" href="<?=$oNoticia->Thumbnail($oNoticia->Imagem, 770, 440);?>">
								<img alt="<?=$oNoticia->Titulo;?>" title="<?=$oNoticia->Titulo;?>" src="<?=$oNoticia->Thumbnail($oNoticia->Imagem, 150, 100);?>" />
							</a>
							<br />
							<br />
							<a href="remover-imagem.php?<?=$_SERVER["QUERY_STRING"];?>" onclick="return conf()">
								<img src="../imgs/botoes/remover-imagem.png" alt="Remover imagem" title="Remover imagem" />
							</a>
							<br />
							<?php
						}
						?>			
					</label>
				</li>
				<li>
					<label>
						Galeria de Fotos:
						<select id="ddlGaleria" name="ddlGaleria">
							<option value="" selected="selected">Nenhuma</option>
							<?php tgaleria::ddl($oNoticia->GaleriaID); ?>
						</select>
					</label>
				</li>
				<li>
					<label>
						Vídeo(YouTube):
						<input size="60" maxlength="150" type="text" id="txtVideo" name="txtVideo" value="<?=$oNoticia->Video;?>" class="{youtube:true}" title="Digite o link do vídeo (YouTube) corretamente." />
					</label>
				</li>
				<li>
					<label>
						Áudio (*.mp3):
						<input size="60" type="file" id="flAudio" name="flAudio" class="{accept:'mp3'}" title="Selecione o áudio corretamente." />
						<?php
						if($oNoticia->Audio)
						{
							?>
							<br />
							<a href="<?=$oNoticia->DownloadURL($oNoticia->Audio);?>">
								<img src="../imgs/botoes/download.png" alt="Download" title="Download" />
							</a>
							<a href="remover-audio.php?<?=$_SERVER["QUERY_STRING"];?>" onclick="return conf()">
								<img src="../imgs/botoes/remover.png" alt="Remover" title="Remover" />
							</a>
							<br />
							<?php
						}
						?>			
					</label>
				</li>
				<li>
					<table class="lista" style="width:auto;">
						<thead>
							<tr>
								<td>Título</td>
								<td>Arquivo (*.doc, *.docx, *.xls, *.xlsx, *.pdf, *.ppt, *.pptx)</td>
								<td>Opções</td>
							</tr>
						</thead>
						<tbody>
							<?php
							$oNoticiaArquivo = new tnoticiaarquivo();
							$oNoticiaArquivo->LoadByNoticiaID($oNoticia->ID);
							$TotalArquivo = (($oNoticiaArquivo->NumRows > 0) ? $oNoticiaArquivo->NumRows : 1);
							for($c = 0; $c < $TotalArquivo; $c++)
							{
								?>
								<tr>
									<td><input size="30" maxlength="50" type="text" name="txtArquivo[]" value="<?=$oNoticiaArquivo->Titulo;?>" /></td>
									<td><input size="30" type="file" name="flArquivo[]" /></td>
									<td align="center">
										<?php if($oNoticiaArquivo->Arquivo) { ?><a href="<?=$oNoticiaArquivo->DownloadURL($oNoticiaArquivo->Arquivo);?>" class="remove"><img src="../imgs/icones16x16/down_16x16.gif" alt="Download" title="Download" /></a> <?php } ?>
										<a href="javascript:void(0);" onclick="addDefault($(this).parent().parent())" class="add" <?php if(($c + 1) < $TotalArquivo) { ?> style="display:none;" <?php } ?>><img src="../imgs/icones16x16/add_16x16.gif" alt="Adicionar" title="Adicionar" /></a>
										<a href="javascript:void(0);" onclick="delDefault($(this).parent().parent())" class="del" <?php if(($c + 1) >= $TotalArquivo) { ?> style="display:none;" <?php } ?>><img src="../imgs/icones16x16/delete_16x16.gif" alt="Remover" title="Remover" /></a>
										<input type="hidden" name="hidArquivo[]" value="<?=$oNoticiaArquivo->ID;?>" />
									</td>
								</tr>
								<?php
								$oNoticiaArquivo->MoveNext();
							}
							?>
						</tbody>
					</table>
				</li>
				<li>
					<label>
						Descrição:
						<?php
						$oEditor = new FCKeditor("txtDescricao");
						$oEditor->BasePath = "../../library/plugins/fckeditor/";
						$oEditor->Value = $oNoticia->HTMLDecode($oNoticia->Descricao);
						$oEditor->ToolbarSet = "Geral";
						$oEditor->Height = "300";
						$oEditor->Create();
						?>
					</label>
				</li>
			</ul>
		</div>
	</fieldset>
	<fieldset>
		<legend>Destaque</legend>
		<div class="margem">
			<ul>
				<li>
					<label>
						<input type="checkbox" id="cbDestaque" name="cbDestaque" value="1" <?php if($oNoticia->Destaque) { ?> checked="checked" <?php } ?> />
						Sim
					</label>
				</li>
				<li>
					<label>
						Imagem (*.jpg, *.jpeg, *.gif):
						<input size="60" type="file" id="flImagemDestaque" name="flImagemDestaque" class="{accept:'jpg|jpeg|gif'}" title="Selecione a imagem destaque corretamente." />
						<sub>(740x315)</sub>
						<?php
						if($oNoticia->ImagemDestaque)
						{
							?>
							<br />
							<a title="<?=$oNoticia->Titulo;?>" rel="lightbox" href="<?=$oNoticia->Thumbnail($oNoticia->ImagemDestaque, 770, 440);?>">
								<img alt="<?=$oNoticia->Titulo;?>" title="<?=$oNoticia->Titulo;?>" src="<?=$oNoticia->Thumbnail($oNoticia->ImagemDestaque, 150, 100);?>" />
							</a>
							<br />
							<br />
							<a href="remover-imagem-destaque.php?<?=$_SERVER["QUERY_STRING"];?>" onclick="return conf()">
								<img src="../imgs/botoes/remover-imagem.png" alt="Remover imagem" title="Remover imagem" />
							</a>
							<br />
							<?php
						}
						?>
					</label>
				</li>
			</ul>
		</div>
	</fieldset>
	<fieldset>
		<legend>Infográfico (Resultado da Voltação)</legend>
		<div class="margem">
			<ul>
				<li>
					<label>
						<input type="checkbox" id="cbDestaque2" name="cbDestaque2" value="1" <?php if($oNoticia->Destaque2) { ?> checked="checked" <?php } ?> />
						Sim
					</label>
				</li>
				<li>
					<label>
						Imagem (*.jpg, *.jpeg, *.gif):
						<input size="60" type="file" id="flImagemDestaque2" name="flImagemDestaque2" class="{accept:'jpg|jpeg|gif'}" title="Selecione a imagem destaque menor corretamente." />
						<sub>(350x158)</sub>
						<?php
						if($oNoticia->ImagemDestaque2)
						{
							?>
							<br />
							<a title="<?=$oNoticia->Titulo;?>" rel="lightbox" href="<?=$oNoticia->Thumbnail($oNoticia->ImagemDestaque2, 770, 440);?>">
								<img alt="<?=$oNoticia->Titulo;?>" title="<?=$oNoticia->Titulo;?>" src="<?=$oNoticia->Thumbnail($oNoticia->ImagemDestaque2, 150, 100);?>" />
							</a>
							<br />
							<br />
							<a href="remover-imagem-destaque2.php?<?=$_SERVER["QUERY_STRING"];?>" onclick="return conf()">
								<img src="../imgs/botoes/remover-imagem.png" alt="Remover imagem" title="Remover imagem" />
							</a>
							<br />
							<?php
						}
						?>			
					</label>
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