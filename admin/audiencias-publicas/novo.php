<?php

$Chave = "audiencias-publicas";
include("../verifica.php");
include_once("../../library/master-page.php");
include_once("../../library/validator.php");
include_once("../../library/upload.php");
include_once("../../library/plugins/fckeditor/fckeditor.php");
include_once("../../library/config/database/tgaleria.php");
include_once("../../library/config/database/taudienciapublica.php");

$oAudienciaPublica = new taudienciapublica();
$bEditar = $oAudienciaPublica->LoadByPrimaryKey($_GET["id"]);

//post
$msg = "";
if($_POST)
{
	//variáveis
	$oAudienciaPublica->Titulo = $_POST["txtTitulo"];
	$oAudienciaPublica->Data = $_POST["txtData"];
	$oAudienciaPublica->GaleriaID = ((intval($_POST["ddlGaleria"])) ? intval($_POST["ddlGaleria"]) : null);
	$oAudienciaPublica->Descricao = $_POST["txtDescricao"];
	
	//validação
	$oValidator = new Validator();
	$oValidator->Add("Titulo", $oAudienciaPublica->Titulo, true, null, "Digite o título.");
	$oValidator->Add("Data", $oAudienciaPublica->Data, true, "date", "Digite a data corretamente.");
	
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
			$oAudienciaPublica->AddNew();
		}
		$oAudienciaPublica->Data = $oAudienciaPublica->DateConvert($oAudienciaPublica->Data);
		$oAudienciaPublica->Imagem = $oUpload->Save($Chave, $oAudienciaPublica->Imagem);
		$oAudienciaPublica->Arquivo = $oUploadArquivo->Save($Chave, $oAudienciaPublica->Arquivo);
		$oAudienciaPublica->Save();
		
		//redireciona
		$oAudienciaPublica->SetMessage((($bEditar) ? "Azul" : "Verde"));
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
				Título*:
				<input size="60" maxlength="150" type="text" id="txtTitulo" name="txtTitulo" value="<?=$oAudienciaPublica->Titulo;?>" class="{required:true, focus:true}" title="Digite o título." />
			</label>
		</li>
		<li>
			<label>
				Data*:
				<br /><input style="display:inline;" size="12" maxlength="10" type="text" id="txtData" name="txtData" value="<?=(($oAudienciaPublica->Data != "" && $oAudienciaPublica->Data != "0000-00-00") ? (($_POST) ? $oAudienciaPublica->Data : date("d/m/Y", $oAudienciaPublica->DateShow($oAudienciaPublica->Data))) : date("d/m/Y"));?>" class="{required:true, dateBR:true, mask:'99/99/9999'}" title="Digite a data corretamente." />
				<a href="javascript:void(0);" class="datePicker {target:'#txtData'}"></a><br />
				<sub>(Ex.: dd/mm/yyyy)</sub>
			</label>
		</li>
		<li>
			<label>
				Imagem (*.jpg, *.jpeg, *.gif):
				<input size="60" type="file" id="flImagem" name="flImagem" class="{accept:'jpg|jpeg|gif'}" title="Selecione a imagem corretamente." />
				<?php
				if($oAudienciaPublica->Imagem)
				{
					?>
					<br />
					<a title="<?=$oAudienciaPublica->Titulo;?>" rel="lightbox" href="<?=$oAudienciaPublica->Thumbnail($oAudienciaPublica->Imagem, 770, 440);?>">
						<img alt="<?=$oAudienciaPublica->Titulo;?>" title="<?=$oAudienciaPublica->Titulo;?>" src="<?=$oAudienciaPublica->Thumbnail($oAudienciaPublica->Imagem, 150, 100);?>" />
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
				Arquivo (*.pdf, *.doc, *.xls, *.ppt, *.docx, *.xlsx, *.pptx):
				<input size="60" type="file" id="flArquivo" name="flArquivo" class="{accept:'pdf|doc|xls|ppt|docx|xlsx|pptx'}" title="Selecione o arquivo corretamente." />
				<?php
				if($oAudienciaPublica->Arquivo)
				{
					?>
					<br />
					<a href="<?=$oAudienciaPublica->DownloadURL($oAudienciaPublica->Arquivo);?>"><img src="../imgs/botoes/download.png" alt="Download" title="Download" /></a>
					<a href="remover-arquivo.php?<?=$_SERVER["QUERY_STRING"];?>" onclick="return conf()"><img src="../imgs/botoes/remover.png" alt="Remover" title="Remover" /></a>
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
					<?php tgaleria::ddl($oAudienciaPublica->GaleriaID); ?>
				</select>
			</label>
		</li>
		<li>
			<label>
				Descrição:
				<?php
				$oEditor = new FCKeditor("txtDescricao");
				$oEditor->BasePath = "../../library/plugins/fckeditor/";
				$oEditor->Value = $oAudienciaPublica->HTMLDecode($oAudienciaPublica->Descricao);
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