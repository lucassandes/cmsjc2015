<?php

$Chave = "vereadores-portal";
include("../verifica.php");
include_once("../../library/master-page.php");
include_once("../../library/validator.php");
include_once("../../library/upload.php");
include_once("../../library/config/database/tvereadorportal.php");

$oVereador = new tvereadorportal();
$bEditar = $oVereador->LoadByPrimaryKey($_GET["id"]);

//post
$msg = "";
if($_POST)
{
	//variáveis
	$oVereador->Nome = $_POST["txtNome"];
	$oVereador->Partido = $_POST["txtPartido"];
	$oVereador->Salario = $oVereador->DecimalConvert($_POST["txtSalario"]);
	
	//validação
	$oValidator = new Validator();   
	$oValidator->Add("Nome", $oVereador->Nome, true, null, "Digite o nome.");
	$oValidator->Add("Partido", $oVereador->Partido, true, null, "Digite o partido.");
	$oValidator->Add("Salario", ($oVereador->Salario != 0.00), true, null, "Digite o salário corretamente.");
	if($oValidator->Validate())
	{
		if(!$bEditar)
		{
			$oVereador->AddNew();
		}             		
         
		$oVereador->Save();
		
		//redireciona
		$oVereador->SetMessage((($bEditar) ? "Azul" : "Verde"));
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
    	<li class="left">
			<label>
				Nome*:
				<input size="47" maxlength="150" type="text" id="txtNome" name="txtNome" value="<?=$oVereador->Nome;?>" class="{required:true, focus:true}" title="Digite o nome." />
			</label>
		</li>    
    	<li>
			<label>
				Partido*:
				<input size="5" maxlength="5" type="text" id="txtPartido" name="txtPartido" value="<?=$oVereador->Partido;?>" class="{required:true}" title="Digite o partido." />
			</label>
		</li>     
    	<li>
			<label>
				Salário*:
				<input size="60" maxlength="150" type="text" id="txtSalario" name="txtSalario" value="<?=$oVereador->DecimalShow($oVereador->Salario);?>" class="{required:true, price:true}" title="Digite o salário corretamente." />
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