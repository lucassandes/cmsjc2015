<?php

$Chave = "downloads";
include("../verifica.php");
include_once("../../library/master-page.php");
include_once("../../library/validator.php");
include_once("../../library/upload.php");
include_once("../../library/config/database/tdownload.php");
include_once("../../library/config/database/tcategoriadownload.php");

$oDownload = new tdownload();
$bEditar = $oDownload->LoadByPrimaryKey($_GET["id"]);

//post
$msg = "";
if($_POST)
{
	//variáveis
	$sCategoriaDownloadID = $oDownload->CategoriaDownloadID;
	$oDownload->Titulo = $_POST["txtTitulo"];
	$oDownload->CategoriaDownloadID = intval($_POST["ddlCategoria"]);
	
	//validação
	$oValidator = new Validator();
	$oValidator->Add("Titulo", $oDownload->Titulo, true, null, "Digite o título.");
	$oValidator->Add("Categoria", $oDownload->CategoriaDownloadID, true, null, "Selecione a categoria.");
	
	$oUpload = new Upload($_FILES["flArquivo"]);
	$oUpload->Validate(!$oDownload->Arquivo, array("pdf", "doc", "xls", "ppt", "docx", "xlsx", "pptx"));
	
	$oUploadImagem = new Upload($_FILES["flImagem"]);
	if(!$oUploadImagem->Validate(false, array("jpg", "jpeg", "gif")))
	{
		$oValidator->AddMessage("Imagem", $oUploadImagem->Message);
	}
	
	if($oValidator->Validate())
	{
		if(!$bEditar)
		{
			$oDownload->AddNew();
		}
		if(!$bEditar || $sCategoriaDownloadID != $oDownload->CategoriaDownloadID)
		{
			$oDownload->Ordem = $oDownload->GetOrdem("CategoriaDownloadID = '" . $oDownload->CategoriaDownloadID . "'");
		}
		$oDownload->Arquivo = $oUpload->Save($Chave, $oDownload->Arquivo);
		$oDownload->Imagem = $oUploadImagem->Save($Chave, $oDownload->Imagem);
		$oDownload->Save();
		
		//redireciona
		$oDownload->SetMessage((($bEditar) ? "Azul" : "Verde"));
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
				<input size="60" maxlength="150" type="text" id="txtTitulo" name="txtTitulo" value="<?=$oDownload->Titulo;?>" class="{required:true, focus:true}" title="Digite o título." />
			</label>
		</li>
		<li>
			<label>
				Categoria*:
				<select id="ddlCategoria" name="ddlCategoria" class="{required:true}" title="Selecione a categoria.">
					<option value="" selected="selected">Selecione</option>
					<?php tcategoriadownload::ddl($oDownload->CategoriaDownloadID); ?>
				</select>
			</label>
		</li>
		<li>
			<label>
				Arquivo (*.pdf, *.doc, *.xls, *.ppt, *.docx, *.xlsx, *.pptx)*:
				<input size="60" type="file" id="flArquivo" name="flArquivo" class="{<?php if(!$oDownload->Arquivo) { ?>required:false, <?php } ?>accept:'pdf|doc|xls|ppt|docx|xlsx|pptx'}" title="Selecione o arquivo corretamente." />
				<?php
				if($oDownload->Arquivo)
				{
					?>
					<br />
					<a href="<?=$oDownload->DownloadURL($oDownload->Arquivo);?>"><img src="../imgs/botoes/download.png" alt="Download" title="Download" /></a>
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
				if($oDownload->Imagem)
				{
					?>
					<br />
					<a title="<?=$oDownload->Titulo;?>" rel="lightbox" href="<?=$oDownload->Thumbnail($oDownload->Imagem, 770, 440);?>">
						<img alt="<?=$oDownload->Titulo;?>" title="<?=$oDownload->Titulo;?>" src="<?=$oDownload->Thumbnail($oDownload->Imagem, 150, 100);?>" />
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