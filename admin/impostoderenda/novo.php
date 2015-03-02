<?php

$Chave = "impostoderenda";
include("../verifica.php");
include_once("../../library/master-page.php");
include_once("../../library/validator.php");
include_once("../../library/upload.php");
include_once("../../library/config/database/timpostoderenda.php");

$oImpostoRenda = new timpostoderenda();
$bEditar = $oImpostoRenda->LoadByPrimaryKey($_GET["id"]);

//post
$msg = "";
if($_POST)
{
	//variáveis
	$oImpostoRenda->Titulo = $_POST["txtTitulo"];     
	$oImpostoRenda->SalarioInicial = $oImpostoRenda->DecimalConvert($_POST["txtSalarioInicial"]);	 
	$oImpostoRenda->SalarioFinal = $oImpostoRenda->DecimalConvert($_POST["txtSalarioFinal"]); 
	$oImpostoRenda->Percentual = $oImpostoRenda->DecimalConvert($_POST["txtPercentual"]);
	$oImpostoRenda->Percentual = $oImpostoRenda->Percentual / 100;
	
	//validação
	$oValidator = new Validator();   
	$oValidator->Add("SalarioInicial", ($oImpostoRenda->SalarioInicial != 0.00), true, null, "Digite o salário inicial.");
	$oValidator->Add("SalarioFinal", ($oImpostoRenda->SalarioFinal != 0.00), true, null, "Digite o salário final.");
	$oValidator->Add("Percentual", ($oImpostoRenda->Percentual != 0.00), true, null, "Digite o percentual.");
	if($oValidator->Validate())
	{
		if(!$bEditar)
		{
			$oImpostoRenda->AddNew();
		}             		
         
		$oImpostoRenda->Save();
		
		//redireciona
		$oImpostoRenda->SetMessage((($bEditar) ? "Azul" : "Verde"));
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

$NoticiaData = explode('-',$oImpostoRenda->Data);
$oImpostoRenda->Data =  $NoticiaData[2] . '/' . $NoticiaData[1] . '/' . $NoticiaData[0];

?>
<?=$msg;?>
<p>Preencha corretamente os campos abaixo:</p> (Os campos com * são obrigatórios)
<form action="" method="post" class="formMensagem" enctype="multipart/form-data">
	<ul>     
    	<li>
			<label>
				Salário Inicial*:
				<input size="60" type="text" id="txtSalarioInicial" name="txtSalarioInicial" value="<?=number_format($oImpostoRenda->SalarioInicial, 2, ",", ".");?>" class="{required:true, focus:true, price:true}" title="Digite o salário inicial." />
			</label>
		</li> 
    	<li>
			<label>
				Salário Final*:
				<input size="60" type="text" id="txtSalarioFinal" name="txtSalarioFinal" value="<?=number_format($oImpostoRenda->SalarioFinal, 2, ",", ".");?>" class="{required:true, price:true}" title="Digite o salário final." />
			</label>
		</li>     
    	<li>
			<label>
				Percentual*:  
				<input size="60" maxlength="5" type="text" id="txtPercentual" name="txtPercentual" value="<?=number_format(($oImpostoRenda->Percentual * 100), 2, ",", "");?>" class="{required:true, price:true}" title="Digite o percentual." />
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