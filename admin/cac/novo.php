<?php

$Chave = "cac";
include("../verifica.php");
include_once("../../library/master-page.php");
include_once("../../library/validator.php");
include_once("../../library/config/database/tcac.php");

$oCAC = new tcac();
$bEditar = $oCAC->LoadByPrimaryKey($_GET["id"]);

//post
$msg = "";
if($_POST)
{
	//variáveis
	$oCAC->Titulo = $_POST["txtTitulo"];
	$oCAC->Descricao = $_POST["txtDescricao"];
	
	//validação
	$oValidator = new Validator();
	$oValidator->Add("Titulo", $oCAC->Titulo, true, null, "Digite o título.");
	$oValidator->Add("Descricao", $oCAC->Descricao, true, null, "Digite a descrição.");
	if($oValidator->Validate())
	{
		if(!$bEditar)
		{
			$oCAC->AddNew();
			$oCAC->Ordem = $oCAC->GetOrdem();
		}
		$oCAC->Save();
		
		//redireciona
		$oCAC->SetMessage((($bEditar) ? "Azul" : "Verde"));
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
				<input size="60" maxlength="150" type="text" id="txtTitulo" name="txtTitulo" value="<?=$oCAC->Titulo;?>" class="{required:true, focus:true}" title="Digite o título." />
			</label>
		</li>
		<li>
			<label>
				Descrição*:
				<textarea cols="80" rows="5" id="txtDescricao" name="txtDescricao" class="{required:true}" title="Digite a descrição."><?=$oCAC->Descricao;?></textarea>
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