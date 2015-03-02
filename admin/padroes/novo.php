<?php

$Chave = "padroes";
include("../verifica.php");
include_once("../../library/master-page.php");
include_once("../../library/validator.php");
include_once("../../library/upload.php");
include_once("../../library/config/database/tpadrao.php");

$oPadrao = new tpadrao();
$bEditar = $oPadrao->LoadByPrimaryKey($_GET["id"]);

//post
$msg = "";
if($_POST)
{
	//variáveis
	$oPadrao->Titulo = $_POST["txtTitulo"];
	$oPadrao->Salario = $oPadrao->DecimalConvert($_POST["txtSalario"]);
	
	//validação
	$oValidator = new Validator();   
	$oValidator->Add("Titulo", $oPadrao->Titulo, true, null, "Digite o título.");
	$oValidator->Add("Salario", ($oPadrao->Salario != 0.00), true, null, "Digite o salário corretamente.");
	if($oValidator->Validate())
	{
		if(!$bEditar)
		{
			$oPadrao->AddNew();
		}             		
         
		$oPadrao->Save();
		
		//redireciona
		$oPadrao->SetMessage((($bEditar) ? "Azul" : "Verde"));
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
				<input size="60" maxlength="150" type="text" id="txtTitulo" name="txtTitulo" value="<?=$oPadrao->Titulo;?>" class="{required:true, focus:true}" title="Digite o título." />
			</label>
		</li>     
    	<li>
			<label>
				Salário*:
				<input size="60" maxlength="150" type="text" id="txtSalario" name="txtSalario" value="<?=$oPadrao->DecimalShow($oPadrao->Salario);?>" class="{required:true, price:true}" title="Digite o salário corretamente." />
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