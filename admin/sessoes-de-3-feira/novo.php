<?php

$Chave = "sessoes-de-3-feira";
include("../verifica.php");
include_once("../../library/master-page.php");
include_once("../../library/validator.php");
include_once("../../library/upload.php");
include_once("../../library/plugins/fckeditor/fckeditor.php");
include_once("../../library/config/database/tgaleria.php");
include_once("../../library/config/database/tsessao.php");

$oSessao = new tsessao();
$bEditar = $oSessao->LoadByPrimaryKey($_GET["id"]);

//post
$msg = "";
if($_POST)
{
	//variáveis
	$oSessao->Tipo = $_POST["ddlTipo"];
	$oSessao->Titulo = $_POST["txtTitulo"];
	$oSessao->Data = $_POST["txtData"];
	$oSessao->Hora = $_POST["txtHora"];
	$oSessao->Local = $_POST["txtLocal"];
	$oSessao->Vereador = $_POST["txtVereador"];
	$oSessao->GaleriaID = ((intval($_POST["ddlGaleria"])) ? intval($_POST["ddlGaleria"]) : null);
	$oSessao->Descricao = $_POST["txtDescricao"];
	
	//validação
	$oValidator = new Validator();
	$oValidator->Add("Tipo", $oSessao->Tipo, true, null, "Selecione o tipo.");
	$oValidator->Add("Titulo", $oSessao->Titulo, true, null, "Digite o título.");
	$oValidator->Add("Data", $oSessao->Data, true, "date", "Digite a data corretamente.");
	
	$oUpload = new Upload($_FILES["flImagem"]);
	if(!$oUpload->Validate(false, array("jpg", "jpeg", "gif")))
	{
		$oValidator->AddMessage("Imagem", $oUpload->Message);
	}
	
	$oUploadArquivo = new Upload($_FILES["flArquivo"]);
	if(!$oUploadArquivo->Validate(false, array("pdf", "doc", "xls", "ppt", "docx", "xlsx", "pptx")))
	{
		$oValidator->AddMessage("Arquivo", $oUploadArquivo->Message);
	}
	
	if($oValidator->Validate())
	{
		if(!$bEditar)
		{
			$oSessao->AddNew();
		}
		$oSessao->Data = $oSessao->DateConvert($oSessao->Data);
		$oSessao->Imagem = $oUpload->Save($Chave, $oSessao->Imagem);
		$oSessao->Arquivo = $oUploadArquivo->Save($Chave, $oSessao->Arquivo);
		$oSessao->Save();
		
		//redireciona
		$oSessao->SetMessage((($bEditar) ? "Azul" : "Verde"));
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
	<ul>
		<li>
			<label>
				Tipo*:
				<select id="ddlTipo" name="ddlTipo" class="{required:true, focus:true}" title="Selecione o tipo.">
					<option value="" selected="selected">Selecione</option>
					<?php
					foreach($oSessao->Tipo2Lista[$Chave] as $c => $v)
					{
						?>
						<option value="<?=$c;?>" <?php if($c == $oSessao->Tipo) { ?> selected="selected" <?php } ?>><?=$v;?></option>
						<?php
					}
					?>
				</select>
			</label>
		</li>
		<li>
			<label>
				Título*:
				<input size="60" maxlength="150" type="text" id="txtTitulo" name="txtTitulo" value="<?=$oSessao->Titulo;?>" class="{required:true}" title="Digite o título." />
			</label>
		</li>
		<li>
			<label>
				Data*:
				<br /><input style="display:inline;" size="12" maxlength="10" type="text" id="txtData" name="txtData" value="<?=(($oSessao->Data != "" && $oSessao->Data != "0000-00-00") ? (($_POST) ? $oSessao->Data : date("d/m/Y", $oSessao->DateShow($oSessao->Data))) : date("d/m/Y"));?>" class="{required:true, dateBR:true, mask:'99/99/9999'}" title="Digite a data corretamente." />
				<a href="javascript:void(0);" class="datePicker {target:'#txtData'}"></a><br />
				<sub>(Ex.: dd/mm/yyyy)</sub>
			</label>
		</li>
		<li>
			<label>
				Hora:
				<input size="50" maxlength="50" type="text" id="txtHora" name="txtHora" value="<?=$oSessao->Hora;?>" />
			</label>
		</li>
		<li>
			<label>
				Local:
				<input size="50" maxlength="50" type="text" id="txtLocal" name="txtLocal" value="<?=$oSessao->Local;?>" />
			</label>
		</li>
		<li>
			<label>
				Vereador:
				<input size="50" maxlength="150" type="text" id="txtVereador" name="txtVereador" value="<?=$oSessao->Vereador;?>" />
			</label>
		</li>
		<li>
			<label>
				Arquivo (*.pdf, *.doc, *.xls, *.ppt, *.docx, *.xlsx, *.pptx):
				<input size="60" type="file" id="flArquivo" name="flArquivo" class="{accept:'pdf|doc|xls|ppt|docx|xlsx|pptx'}" title="Selecione o arquivo corretamente." />
				<?php
				if($oSessao->Arquivo)
				{
					?>
					<br />
					<a href="<?=$oSessao->DownloadURL($oSessao->Arquivo);?>"><img src="../imgs/botoes/download.png" alt="Download" title="Download" /></a>
					<a href="remover-arquivo.php?<?=$_SERVER["QUERY_STRING"];?>" onclick="return conf()"><img src="../imgs/botoes/remover.png" alt="Remover" title="Remover" /></a>
					<br />
					<?php
				}
				?>
			</label>
		</li>
		<li>
			<label>
				Imagem (*.jpg, *.jpeg, *.gif):
				<input size="60" type="file" id="flImagem" name="flImagem" class="{accept:'jpg|jpeg|gif'}" title="Selecione a imagem corretamente." />
				<?php
				if($oSessao->Imagem)
				{
					?>
					<br />
					<a title="<?=$oSessao->Titulo;?>" rel="lightbox" href="<?=$oSessao->Thumbnail($oSessao->Imagem, 770, 440);?>">
						<img alt="<?=$oSessao->Titulo;?>" title="<?=$oSessao->Titulo;?>" src="<?=$oSessao->Thumbnail($oSessao->Imagem, 150, 100);?>" />
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
					<?php tgaleria::ddl($oSessao->GaleriaID); ?>
				</select>
			</label>
		</li>
		<li>
			<label>
				Descrição:
				<?php
				$oEditor = new FCKeditor("txtDescricao");
				$oEditor->BasePath = "../../library/plugins/fckeditor/";
				$oEditor->Value = $oSessao->HTMLDecode($oSessao->Descricao);
				$oEditor->ToolbarSet = "Geral";
				$oEditor->Height = "300";
				$oEditor->Create();
				?>
			</label>
		</li>
	</ul>
    <input type="hidden" id="hFA" name="hFA" />
	<input onclick="$('#hFA').val('outro')" type="image" src="../imgs/botoes/enviar-e-cadastrar-outro.png" alt="Enviar e Cadastrar outro" title="Enviar e Cadastrar outro" />
    <input onclick="$('#hFA').val('enviar')" type="image" src="../imgs/botoes/enviar.png" alt="Enviar" title="Enviar" />
    <a href="index.php?<?=$_SERVER["QUERY_STRING"];?>"><img src="../imgs/botoes/voltar.png" alt="Voltar" title="Voltar" /></a>
</form>
<?php

$oMasterPage->Close("PageContent");
$oMasterPage->End();

?>