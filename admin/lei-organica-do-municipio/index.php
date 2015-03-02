<?php

$Chave = "lei-organica-do-municipio";
include("../verifica.php");
include_once("../../library/master-page.php");
include_once("../../library/validator.php");
include_once("../../library/upload.php");
include_once("../../library/config/database/tparametro.php");

$oParametro = new tparametro();
$arquivo = $oParametro->Get($Chave);

//post
if($_POST)
{
	//validação
	$oValidator = new Validator();
	
	$oUpload = new Upload($_FILES["flArquivo"]);
	if(!$oUpload->Validate(!$arquivo, array("pdf")))
	{
		$oValidator->AddMessage("Arquivo", $oUpload->Message);
	}
	
	if($oValidator->Validate())
	{
		$oParametro->Set($Chave, $oUpload->Save($Chave, $arquivo));
		
		//redireciona
		$oParametro->SetMessage((($arquivo) ? "Azul" : "Verde"));		
		header("Location: index.php");
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
<p>Preencha corretamente os campos abaixo:</p> (Os campos com * são obrigatórios)
<form action="" method="post" class="formMensagem" enctype="multipart/form-data">
	<ul>
		<li>
			<label>
				Arquivo (*.pdf)*:
				<input size="60" type="file" id="flArquivo" name="flArquivo" class="{<?php if(!$arquivo) { ?>required:true, <?php } ?>accept:'pdf'}" title="Selecione o arquivo corretamente." />
				<?php
				if($arquivo)
				{
					?>
					<br />
					<a href="<?=$oParametro->DownloadURL($arquivo);?>"><img src="../imgs/botoes/download.png" alt="Download" title="Download" /></a>
					<br />
					<?php
				}
				?>
			</label>
		</li>
	</ul>
    <input type="image" src="../imgs/botoes/enviar.png" alt="Enviar" title="Enviar" />
    <a href="../"><img src="../imgs/botoes/voltar.png" alt="Voltar" title="Voltar" /></a>
</form>
<?php

$oMasterPage->Close("PageContent");
$oMasterPage->End();

?>