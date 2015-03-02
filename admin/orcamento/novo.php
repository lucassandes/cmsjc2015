<?php

$Chave = "orcamento";
include("../verifica.php");
include_once("../../library/master-page.php");
include_once("../../library/validator.php");
include_once("../../library/upload.php");
include_once("../../library/config/database/torcamento.php");

$oOrcamento = new torcamento();
$bEditar = $oOrcamento->LoadByPrimaryKey($_GET["id"]);

//post
$msg = "";
if($_POST)
{
	//variáveis
	$sTipo = $oOrcamento->Tipo;
	$oOrcamento->Titulo = $_POST["txtTitulo"];
	$oOrcamento->Tipo = $_POST["ddlTipo"];
	
	//validação
	$oValidator = new Validator();
	$oValidator->Add("Titulo", $oOrcamento->Titulo, true, null, "Digite o título.");
	$oValidator->Add("Tipo", $oOrcamento->Tipo, true, null, "Selecione o tipo.");
	
	$oUpload = new Upload($_FILES["flArquivo"]);
	if(!$oUpload->Validate(!$oOrcamento->Arquivo, array("pdf", "doc", "xls", "ppt", "docx", "xlsx", "pptx")))
	{
		$oValidator->AddMessage("Arquivo", $oUpload->Message);
	}
	
	if($oValidator->Validate())
	{
		if(!$bEditar)
		{
			$oOrcamento->AddNew();
		}
		if(!$bEditar || $sTipo != $oOrcamento->Tipo)
		{
			$oOrcamento->Ordem = $oOrcamento->GetOrdem("Tipo = '" . $oOrcamento->Tipo . "'");
		}
		$oOrcamento->Arquivo = $oUpload->Save($Chave, $oOrcamento->Arquivo);
		$oOrcamento->Save();
		
		//redireciona
		$oOrcamento->SetMessage((($bEditar) ? "Azul" : "Verde"));
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
				<input size="60" maxlength="150" type="text" id="txtTitulo" name="txtTitulo" value="<?=$oOrcamento->Titulo;?>" class="{required:true, focus:true}" title="Digite o título." />
			</label>
		</li>
		<li>
			<label>
				Tipo*:
				<select id="ddlTipo" name="ddlTipo" class="{required:true}" title="Selecione o tipo.">
					<option value="" selected="selected">Selecione</option>
					<?php
					foreach($oOrcamento->TipoLista as $c => $v)
					{
						?>
						<option value="<?=$c;?>" <?php if($c == $oOrcamento->Tipo) { ?> selected="selected" <?php } ?>><?=$v;?></option>
						<?php
					}
					?>
				</select>
			</label>
		</li>
		<li>
			<label>
				Arquivo (*.pdf, *.doc, *.xls, *.ppt, *.docx, *.xlsx, *.pptx)*:
				<input size="60" type="file" id="flArquivo" name="flArquivo" class="{<?php if(!$oOrcamento->Arquivo) { ?>required:true, <?php } ?>accept:'pdf|doc|xls|ppt|docx|xlsx|pptx'}" title="Selecione o arquivo corretamente." />
				<?php
				if($oOrcamento->Arquivo)
				{
					?>
					<br />
					<a href="<?=$oOrcamento->DownloadURL($oOrcamento->Arquivo);?>"><img src="../imgs/botoes/download.png" alt="Download" title="Download" /></a>
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