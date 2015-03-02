<?php

$Chave = "mmkt-templates";
include("../verifica.php");
include_once("../../library/master-page.php");
include_once("../../library/validator.php");
include_once("../../library/plugins/fckeditor/fckeditor.php");
include_once("../../library/config/database/tmmkttemplate.php");

$oTemplate = new tmmkttemplate();
$bEditar = $oTemplate->LoadByPrimaryKey($_GET["id"]);

//post
$msg = "";
if($_POST)
{
	//variáveis
	$oTemplate->Ativo = intval($_POST["cbAtivo"]);
	$oTemplate->Titulo = $_POST["txtTitulo"];
	$oTemplate->Descricao = $_POST["txtDescricao"];
		
	//validação
	$oValidator = new Validator();
	$oValidator->Add("Titulo", $oTemplate->Titulo, true, null, "Digite o título.");
	$oValidator->Add("Descricao", $oTemplate->Descricao, true, null, "Digite a descrição.");
	if($oValidator->Validate())
	{
		if(!$bEditar)
		{
			$oTemplate->AddNew();
		}
		$oTemplate->Save();
		
		//redireciona
		$oTemplate->SetMessage((($bEditar) ? "Azul" : "Verde"));
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
				<input type="checkbox" id="cbAtivo" name="cbAtivo" value="1" <?php if($oTemplate->Ativo) { ?> checked="checked" <?php } ?> />
				Ativo
			</label>
		</li>
    	<li>
			<label>
				Título*:
				<input size="60" maxlength="150" type="text" id="txtTitulo" name="txtTitulo" value="<?=$oTemplate->Titulo;?>" class="{required:true, focus:true}" title="Digite o título." />
			</label>
		</li>
		<li>
			<li>
				Descrição*:
				<?php
				$oEditor = new FCKeditor("txtDescricao");
				$oEditor->BasePath = "../../library/plugins/fckeditor/";
				$oEditor->Value = $oTemplate->HTMLDecode($oTemplate->Descricao);
				$oEditor->ToolbarSet = "Geral";
				$oEditor->Height = 300;
				$oEditor->Create();
				?>
			</li>
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