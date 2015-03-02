<?php

$Chave = "mmkt-filtros";
include("../verifica.php");
include_once("../../library/master-page.php");
include_once("../../library/validator.php");
include_once("../../library/config/database/tmmktfiltro.php");

$oFiltro = new tmmktfiltro();
$bEditar = $oFiltro->LoadByPrimaryKey($_GET["id"]);

//post
$msg = "";
if($_POST)
{
	//vari�veis
	$oFiltro->Titulo = $_POST["txtTitulo"];
		
	//valida��o
	$oValidator = new Validator();
	$oValidator->Add("Titulo", $oFiltro->Titulo, true, null, "Digite o t�tulo.");
	if($oValidator->Validate())
	{
		if(!$bEditar)
		{
			$oFiltro->AddNew();
		}
		$oFiltro->Save();
		
		//redireciona
		$oFiltro->SetMessage((($bEditar) ? "Azul" : "Verde"));
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
				<input size="60" maxlength="150" type="text" id="txtTitulo" name="txtTitulo" value="<?=$oFiltro->Titulo;?>" class="{required:true, focus:true}" title="Digite o t�tulo." />
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