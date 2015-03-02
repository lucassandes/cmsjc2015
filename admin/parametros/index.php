<?php

$Chave = "parametros";
include("../verifica.php");
include_once("../../library/master-page.php");
include_once("../../library/config/database/tparametro.php");

$oParametro = new tparametro();
$arParam = $oParametro->Load();

//post
if($_POST)
{
	//E-mails
	$oParametro->Set("email-retorno", $_POST["txt-email-retorno"]);
	$oParametro->Set("email-sistema", $_POST["txt-email-sistema"]);
	$oParametro->Set("email-fale-conosco", $_POST["txt-email-fale-conosco"]);
	$oParametro->Set("email-comunicar-erros", $_POST["txt-email-comunicar-erros"]);
	
	//Google Analytics
	$oParametro->Set("google-analytics-profile", $_POST["txt-google-analytics-profile"]);
	$oParametro->Set("google-analytics-email", $_POST["txt-google-analytics-email"]);
	$oParametro->Set("google-analytics-senha", $_POST["txt-google-analytics-senha"]);
	
	//Geren. de MMKT
	$oParametro->Set("mmkt-envio", $_POST["txt-mmkt-envio"]);
	$oParametro->Set("mmkt-segundo", $_POST["txt-mmkt-segundo"]);
	
	//redireciona
	$oParametro->SetMessage("Azul");
	header("Location: ../");
	exit();
}

$oMasterPage = new MasterPage();
$oMasterPage->Init("../master.php");
$oMasterPage->AddParameter("Chave", $Chave);
$oMasterPage->Open("PageContent");

?>
<?=$msg;?>
<p>Preencha corretamente os campos abaixo:</p> (Os campos com * são obrigatórios)
<form action="" method="post" class="formMensagem">
	<fieldset>
		<legend><a href="javascript:void(0);" onclick="slideArea(this)">E-mails</a></legend>
		<div class="margem" style="display:none;">
			<ul>
		    	<li>
					<label>
						Retorno*:
						<input size="60" maxlength="150" type="text" id="txt-email-retorno" name="txt-email-retorno" value="<?=$arParam["email-retorno"];?>" class="{required:true, email:true}" title="Digite o e-mail do retorno corretamente." />
						<sub>(Necessário digitar um e-mail válido referente ao domínio)</sub>
					</label>
				</li>
				<li>
					<label>
						Sistema*:
						<input size="60" maxlength="150" type="text" id="txt-email-sistema" name="txt-email-sistema" value="<?=$arParam["email-sistema"];?>" class="{required:true, email:true}" title="Digite o e-mail do sistema corretamente." />
						<sub>(Necessário digitar um e-mail válido referente ao domínio)</sub>
					</label>
				</li>
				<li>
					<label>
						Fale Conosco*:
						<input size="60" maxlength="150" type="text" id="txt-email-fale-conosco" name="txt-email-fale-conosco" value="<?=$arParam["email-fale-conosco"];?>" class="{required:true, email:true}" title="Digite o e-mail corretamente." />
					</label>
				</li>
				<li>
					<label>
						Comunicar Erros*:
						<input size="60" maxlength="150" type="text" id="txt-email-comunicar-erros" name="txt-email-comunicar-erros" value="<?=$arParam["email-comunicar-erros"];?>" class="{required:true, email:true}" title="Digite o e-mail corretamente." />
					</label>
				</li>
				
			</ul>
		</div>
	</fieldset>
	<fieldset>
		<legend><a href="javascript:void(0);" onclick="slideArea(this)">Google Analytics</a></legend>
		<div class="margem" style="display:none;">
			<ul>
		    	<li>
					<label>
						Profile:
						<input size="15" maxlength="10" type="text" id="txt-google-analytics-profile" name="txt-google-analytics-profile" value="<?=$arParam["google-analytics-profile"];?>" />
					</label>
				</li>
				<li>
					<label>
						E-mail:
						<input size="60" maxlength="150" type="text" id="txt-google-analytics-email" name="txt-google-analytics-email" value="<?=$arParam["google-analytics-email"];?>" class="{email:true}" title="Digite o e-mail do google analytics corretamente." />
					</label>
				</li>
				<li>
					<label>
						Senha:
						<input size="30" maxlength="20" type="text" id="txt-google-analytics-senha" name="txt-google-analytics-senha" value="<?=$arParam["google-analytics-senha"];?>" />
					</label>
				</li>
			</ul>
		</div>
	</fieldset>
	<fieldset>
		<legend><a href="javascript:void(0);" onclick="slideArea(this)">Geren. de MMKT</a></legend>
		<div class="margem" style="display:none;">
			<ul>
		    	<li>
					<label>
						Quantidade de e-mails por lote*:
						<input size="5" maxlength="3" type="text" id="txt-mmkt-envio" name="txt-mmkt-envio" value="<?=$arParam["mmkt-envio"];?>" class="{required:true, numeric:true, number:true}" title="Digite a quantidade de e-mails por segundo corretamente." />
					</label>
				</li>
				<li>
					<label>
						Quantidade de segundos por lote*:
						<input size="5" maxlength="3" type="text" id="txt-mmkt-segundo" name="txt-mmkt-segundo" value="<?=$arParam["mmkt-segundo"];?>" class="{required:true, numeric:true, number:true}" title="Digite a quantidade de segundos corretamente." />
					</label>
				</li>
			</ul>
		</div>
	</fieldset>
	<input type="image" src="../imgs/botoes/enviar.png" alt="Enviar" title="Enviar" />
    <a href="../"><img src="../imgs/botoes/voltar.png" alt="Voltar" title="Voltar" /></a>
</form>
<?php

$oMasterPage->Close("PageContent");
$oMasterPage->End();

?>