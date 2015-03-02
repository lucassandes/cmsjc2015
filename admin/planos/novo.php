<?php

$Chave = "planos";
include("../verifica.php");
include_once("../../library/master-page.php");
include_once("../../library/validator.php");
include_once("../../library/upload.php");
include_once("../../library/config/database/tplano.php");

$oPlano = new tplano();
$bEditar = $oPlano->LoadByPrimaryKey($_GET["id"]);

//post
$msg = "";
if($_POST)
{
	//variáveis
	$oPlano->PeriodoInicial = $_POST["txtPeriodoInicial"];
	$oPlano->PeriodoFinal = $_POST["txtPeriodoFinal"];  
	$oPlano->Percentual = $oPlano->DecimalConvert($_POST["txtPercentual"]) / 100;
	
	//validação
	$oValidator = new Validator();   
	$oValidator->Add("PeriodoInicial", $oPlano->PeriodoInicial, true, null, "Digite o período inicial.");
	$oValidator->Add("PeriodoFinal", $oPlano->PeriodoFinal, true, null, "Digite o período final.");
	$oValidator->Add("Percentual", $oPlano->Percentual, true, null, "Digite o percentual.");
	if($oValidator->Validate())
	{
		if(!$bEditar)
		{
			$oPlano->AddNew();
		}             		
         
		$oPlano->Save();
		
		//redireciona
		$oPlano->SetMessage((($bEditar) ? "Azul" : "Verde"));
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

$NoticiaData = explode('-',$oPlano->Data);
$oPlano->Data =  $NoticiaData[2] . '/' . $NoticiaData[1] . '/' . $NoticiaData[0];

?>
<?=$msg;?>
<p>Preencha corretamente os campos abaixo:</p> (Os campos com * são obrigatórios)
<form action="" method="post" class="formMensagem" enctype="multipart/form-data">
	<ul>    
    	<li>
			<label>
				Período Inicial*:
				<input size="60" maxlength="2" type="text" id="txtPeriodoInicial" name="txtPeriodoInicial" value="<?=$oPlano->PeriodoInicial;?>" class="{required:true}" title="Digite o período inicial." />
			</label>
		</li> 
    	<li>
			<label>
				Período Final*:
				<input size="60" maxlength="2" type="text" id="txtPeriodoFinal" name="txtPeriodoFinal" value="<?=$oPlano->PeriodoFinal;?>" class="{required:true}" title="Digite o período final." />
			</label>
		</li>     
    	<li>
			<label>
				Percentual*: (Formato: 00,000000)  
				<input size="60" type="text" id="txtPercentual" name="txtPercentual" value="<?=($oPlano->Percentual) ? number_format(($oPlano->Percentual * 100), 6, ",", "") : "00,000000";?>" class="{required:true, mask:'99,999999'}" title="Digite o percentual." />
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