<?php

include("verifica.php");
include_once("../library/master-page.php");
include_once("../library/validator.php");

//post
$msg = "";
if($_POST)
{
	//variáveis
	$txtSenhaAntiga = $_POST["txtSenhaAntiga"];
	$txtNovaSenha = $_POST["txtNovaSenha"];
	$txtConfirmacaoSenha = $_POST["txtConfirmacaoSenha"];
	
	//validação
	$oValidator = new Validator();
	$oValidator->Add("SenhaAntiga", md5($txtSenhaAntiga), true, "compare", "Digite a senha antiga corretamente.", $oAdministradorLogado->Senha);
	$oValidator->Add("NovaSenha", $txtNovaSenha, true, "minlength", "Digite a nova senha corretamente (No mínimo 6 caracteres e no máximo 20 caracteres).", 6);
	$oValidator->Add("NovaSenha", $txtNovaSenha, true, "maxlength", "Digite a nova senha corretamente (No mínimo 6 caracteres e no máximo 20 caracteres).", 20);
	$oValidator->Add("ConfirmacaoSenha", $txtConfirmacaoSenha, true, "compare", "Digite a confirmação de senha corretamente.", $txtNovaSenha);
	if($oValidator->Validate())
	{
		$oAdministradorLogado->Senha = md5($txtNovaSenha);
		$oAdministradorLogado->Save();
		
		//redireciona
		$oAdministradorLogado->SetMessage("Verde", "Senha alterada com sucesso.");
		header("Location: index.php");
		exit();
	}
	else
	{
		$msg = $oValidator->Create();
	}	
}

$oMasterPage = new MasterPage();
$oMasterPage->Init(dirname(__FILE__) . "/master.php", "Alterar senha");
$oMasterPage->Open("PageContent");

?>
<?=$msg;?>
<p>Preencha corretamente os campos abaixo:</p>
<form action="" method="post" class="formMensagem">
	<ul>
		<li>
			<label>
				Senha antiga:
				<input size="30" maxlength="20" type="password" id="txtSenhaAntiga" name="txtSenhaAntiga" class="{required:true, focus:true}" title="Digite a senha antiga corretamente." />
			</label>
		</li>
		<li>
			<label>
				Nova senha:
				<input size="30" maxlength="20" type="password" id="txtNovaSenha" name="txtNovaSenha" class="{required:true, minlength:6, maxlength:20}" title="Digite a nova senha corretamente (No mínimo 6 caracteres e no máximo 20 caracteres)." />
				<sub>(No mínimo 6 caracteres e no máximo 20 caracteres)</sub>
			</label>
		</li>
		<li>
			<label>
				Confirmação de senha*:
				<input size="30" maxlength="20" type="password" id="txtConfirmacaoSenha" name="txtConfirmacaoSenha" class="{required:true, equalTo:'#txtNovaSenha'}" title="Digite a confirmação de senha corretamente." />
			</label>
		</li>
	</ul>
    <input type="image" src="imgs/botoes/enviar.png" alt="Enviar" title="Enviar" />
    <a href="index.php"><img src="imgs/botoes/voltar.png" alt="Voltar" title="Voltar" /></a>
</form>
<?php

$oMasterPage->Close("PageContent");
$oMasterPage->End();

?>