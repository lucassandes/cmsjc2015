<?php

$Chave = "administradores";
include("../verifica.php");
include_once("../../library/master-page.php");
include_once("../../library/validator.php");
include_once("../../library/config/sendmail.php");
include_once("../../library/config/database/tadministrador.php");
include_once("../../library/config/database/tadministradorpermissao.php");
include_once("../../library/config/database/tparametro.php");
include_once("../../library/config/database/tpermissao.php");
include_once("../../library/config/database/tpermissaotitulo.php");

$oAdministrador = new tadministrador();
$bEditar = $oAdministrador->LoadByPrimaryKey($_GET["id"]);

//post
$msg = "";
if($_POST)
{
	//variáveis
	$sLogin = $oAdministrador->Login;
	$sSenha = $_POST["txtSenha"];
	$oAdministrador->Ativo = intval($_POST["cbAtivo"]);
	$oAdministrador->Nome = $_POST["txtNome"];
	$oAdministrador->Login = $_POST["txtLogin"];
	$oAdministrador->Email = $_POST["txtEmail"];
	$cbPermissao = ((is_array($_POST["cbPermissao"])) ? $_POST["cbPermissao"] : array());
		
	//verifica login
	function Verifica($v)
	{
		global $sLogin;
		$oAdministradorLoad = new tadministrador();
		return !($sLogin != $v && $oAdministradorLoad->LoadByLogin($v));
	}
	
	//validação
	$oValidator = new Validator();
	$oValidator->Add("Nome", $oAdministrador->Nome, true, null, "Digite o nome.");
	$oValidator->Add("Login", $oAdministrador->Login, true, null, "Digite o login.");
	$oValidator->Add("Login", $oAdministrador->Login, false, "function", "Login já cadastrado.", Verifica);
	if(!$bEditar)
	{
		$oValidator->Add("Senha", $sSenha, true, "minlength", "Digite a senha corretamente (No mínimo 6 caracteres e no máximo 20 caracteres).", 6);
		$oValidator->Add("Senha", $sSenha, true, "maxlength", "Digite a senha corretamente (No mínimo 6 caracteres e no máximo 20 caracteres).", 20);
		$oValidator->Add("ConfirmacaoSenha", $_POST["txtConfirmacaoSenha"], true, "compare", "Digite a confirmação de senha corretamente.", $sSenha);
	}
	$oValidator->Add("Email", $oAdministrador->Email, true, "email", "Digite o e-mail corretamente.");
	if($oValidator->Validate())
	{
		if(!$bEditar)
		{
			$oAdministrador->AddNew();
			$oAdministrador->Senha = md5($sSenha);
			
			//mensagem
			$Mensagem = "<h1>Olá " . $oAdministrador->Nome . ",</h1><br />";
			$Mensagem .= "<p>Segue abaixo seus dados para acesso:</p>";
			$Mensagem .= "<ul>";
			$Mensagem .= "<li>Login: <b>" . $oAdministrador->Login . "</b></li>";
			$Mensagem .= "<li>Senha: <b>" . $sSenha . "</b></li>";
			$Mensagem .= "</ul>";
			$Mensagem .= "<p><a href='" . $oAdministrador->WebURLAdmin . "'>" . $oAdministrador->WebURLAdmin . "</a></p>";
			
			//envia e-mail
			$oMail = new SendMail();
			$oMail->AddAddress($oAdministrador->Email, $oAdministrador->Nome);
			$oMail->SetFrom(tparametro::Get("email-sistema"), $oAdministrador->WebTitle);
			$oMail->Sender = tparametro::Get("email-retorno");
			$oMail->Subject = $oAdministrador->WebTitle;
			$oMail->MsgHTML($oAdministrador->TemplateEmail($Mensagem));
			$oMail->Send();
		}
		$oAdministrador->Save();
		
		//remove as permissões
		$oAdministradorPermissaoDel = new tadministradorpermissao();
		$oAdministradorPermissaoDel->DeleteByAdministradorID($oAdministrador->ID);
		
		//cadastra as permissões
		foreach($cbPermissao as $c => $v)
		{
			$oAdministradorPermissaoAdd = new tadministradorpermissao();
			$oAdministradorPermissaoAdd->AddNew();
			$oAdministradorPermissaoAdd->AdministradorID = $oAdministrador->ID;
			$oAdministradorPermissaoAdd->PermissaoID = intval($v);
			$oAdministradorPermissaoAdd->Save();
		}
		
		//redireciona
		$oAdministrador->SetMessage((($bEditar) ? "Azul" : "Verde"));
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
				<input type="checkbox" id="cbAtivo" name="cbAtivo" value="1" <?php if($oAdministrador->Ativo) { ?> checked="checked" <?php } ?> />
				Ativo
			</label>
		</li>
    	<li>
			<label>
				Nome*:
				<input size="60" maxlength="150" type="text" id="txtNome" name="txtNome" value="<?=$oAdministrador->Nome;?>" class="{required:true, focus:true}" title="Digite o nome." />
			</label>
		</li>
		<li>
			<label>
				Login*:
				<input size="30" maxlength="20" type="text" id="txtLogin" name="txtLogin" value="<?=$oAdministrador->Login;?>" class="{required:true}" title="Digite o login." />
			</label>
		</li>
		<?php
		if(!$bEditar)
		{
			?>
			<li>
				<label>
					Senha*:
					<input size="30" maxlength="20" type="password" id="txtSenha" name="txtSenha" class="{required:true, minlength:6, maxlength:20}" title="Digite a senha corretamente (No mínimo 6 caracteres e no máximo 20 caracteres)." />
					<sub>(No mínimo 6 caracteres e no máximo 20 caracteres)</sub>
				</label>
			</li>
			<li>
				<label>
					Confirmação de senha*:
					<input size="30" maxlength="20" type="password" id="txtConfirmacaoSenha" name="txtConfirmacaoSenha" class="{required:true, equalTo:'#txtSenha'}" title="Digite a confirmação de senha corretamente." />
				</label>
			</li>
			<?php
		}
		?>
		<li>
			<label>
				E-mail*:
				<input size="60" maxlength="150" type="text" id="txtEmail" name="txtEmail" value="<?=$oAdministrador->Email;?>" class="{required:true, email:true}" title="Digite o e-mail corretamente." />
			</label>
		</li>
    </ul>
    <?php
    $oPermissaoTitulo = new tpermissaotitulo();
    $oPermissaoTitulo->SQLOrder = "Ordem ASC";
    if($oPermissaoTitulo->LoadSQLAssembled())
    {
	    ?>
	    <fieldset id="permissoes">
			<legend>Permissões</legend>
			<div class="margem">
				<a href="javascript:void(0);" onclick="$('input[type=checkbox]', $('#permissoes')).attr('checked', 'checked');"><img src="../imgs/botoes/marcar-todos.png" title="Marcar todos" alt="Marcar todos" /></a>
				<a href="javascript:void(0);" onclick="$('input[type=checkbox]', $('#permissoes')).removeAttr('checked');"><img src="../imgs/botoes/desmarcar-todos.png" title="Desmarcar todos" alt="Desmarcar todos" /></a>
				<?php
				for($c = 0; $c < $oPermissaoTitulo->NumRows; $c++)
				{
					$oPermissao = new tpermissao();
			    	if($oPermissao->LoadByPermissaoTituloIDAndListar($oPermissaoTitulo->ID))
			    	{
						?>
						<h4><?=$oPermissaoTitulo->Titulo;?></h4>
						<table>
							<tr>
								<?php
								for($a = 0; $a < $oPermissao->NumRows; $a++)
								{
									$bChecked = false;
									if($_POST)
									{
										$bChecked = in_array($oPermissao->ID, $cbPermissao);
									}
									else
									{
										$oAdministradorPermissao = new tadministradorpermissao();
										$bChecked = $oAdministradorPermissao->LoadByAdministradorIDAndPermissaoID($oAdministrador->ID, $oPermissao->ID);
									}
									?>
									<td width="170" height="20">
										<label>
											<input type="checkbox" name="cbPermissao[]" value="<?=$oPermissao->ID;?>" <?php if($bChecked) { ?> checked="checked" <?php } ?> />
											<?=$oPermissao->Titulo;?>
										</label>
									</td>
									<?php
									if(($a + 1) % 4 == 0)
									{
										?>
										</tr><tr>
										<?php
									}
									$oPermissao->MoveNext();
								}
								?>
							</tr>
						</table>
						<?php
					}
					$oPermissaoTitulo->MoveNext();
				}
				?>
			</div>
		</fieldset>
		<?php
	}
	?>
	<input type="hidden" id="hFA" name="hFA" />
	<input onclick="$('#hFA').val('outro')" type="image" src="../imgs/botoes/enviar-e-cadastrar-outro.png" alt="Enviar e Cadastrar outro" title="Enviar e Cadastrar outro" />
    <input onclick="$('#hFA').val('enviar')" type="image" src="../imgs/botoes/enviar.png" alt="Enviar" title="Enviar" />
    <a href="index.php?<?=$_SERVER["QUERY_STRING"];?>"><img src="../imgs/botoes/voltar.png" alt="Voltar" title="Voltar" /></a>
</form>
<?php

$oMasterPage->Close("PageContent");
$oMasterPage->End();

?>