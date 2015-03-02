<?php

$Chave = "categorias-de-downloads";
include("../verifica.php");
include_once("../../library/master-page.php");
include_once("../../library/validator.php");
include_once("../../library/config/database/tcategoriadownload.php");

$oCategoriaDownload = new tcategoriadownload();
$bEditar = $oCategoriaDownload->LoadByPrimaryKey($_GET["id"]);

//post
$msg = "";
if($_POST)
{
	//variáveis
	$oCategoriaDownload->Titulo = $_POST["txtTitulo"];
	
	//validação
	$oValidator = new Validator();
	$oValidator->Add("Titulo", $oCategoriaDownload->Titulo, true, null, "Digite o título.");
	if($oValidator->Validate())
	{
		if(!$bEditar)
		{
			$oCategoriaDownload->AddNew();
			$oCategoriaDownload->Ordem = $oCategoriaDownload->GetOrdem();
		}
		$oCategoriaDownload->Save();
		
		//redireciona
		$oCategoriaDownload->SetMessage((($bEditar) ? "Azul" : "Verde"));
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
<form action="" method="post" class="formMensagem">
	<ul>
		<li>
			<label>
				Título*:
				<input size="60" maxlength="150" type="text" id="txtTitulo" name="txtTitulo" value="<?=$oCategoriaDownload->Titulo;?>" class="{focus:true, required:true}" title="Digite o título." />
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