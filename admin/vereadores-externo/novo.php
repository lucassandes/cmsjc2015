<?php

$Chave = "vereadores-externo";
include("../verifica.php");
include_once("../../library/master-page.php");
include_once("../../library/validator.php");
include_once("../../library/plugins/fckeditor/fckeditor.php");
include_once("../../library/config/database/tvereadorexterno.php");

$oVereadorExterno = new tvereadorexterno();
$bEditar = $oVereadorExterno->LoadByPrimaryKey($_GET["id"]);

//post
$msg = "";
if($_POST)
{
	//vari�veis
	$oVereadorExterno->Titulo = $_POST["txtTitulo"];
	$oVereadorExterno->Descricao = $_POST["txtDescricao"];
	
	//valida��o
	$oValidator = new Validator();
	$oValidator->Add("Titulo", $oVereadorExterno->Titulo, true, null, "Digite o t�tulo.");
	if($oValidator->Validate())
	{
		if(!$bEditar)
		{
			$oVereadorExterno->AddNew();
			$oVereadorExterno->Ordem = $oVereadorExterno->GetOrdem();
		}
		$oVereadorExterno->Save();
		
		//redireciona
		$oVereadorExterno->SetMessage((($bEditar) ? "Azul" : "Verde"));
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
<p>Preencha corretamente os campos abaixo:</p> (Os campos com * s�o obrigat�rios)
<form action="" method="post" class="formMensagem">
	<ul>
		<li>
			<label>
				T�tulo*:
				<input size="60" maxlength="150" type="text" id="txtTitulo" name="txtTitulo" value="<?=$oVereadorExterno->Titulo;?>" class="{required:true, focus:true}" title="Digite o t�tulo." />
			</label>
		</li>
		<li>
			<label>
				Descri��o:
				<?php
				$oEditor = new FCKeditor("txtDescricao");
				$oEditor->BasePath = "../../library/plugins/fckeditor/";
				$oEditor->Value = $oVereadorExterno->HTMLDecode($oVereadorExterno->Descricao);
				$oEditor->ToolbarSet = "Texto";
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