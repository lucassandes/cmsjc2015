<?php

include_once("../library/config/sendmail.php");
include_once("../library/config/database/tadministrador.php");
include_once("../library/config/database/tparametro.php");

if($_POST)
{
	$oAdministrador = new tadministrador();
	$bAdministrador = $oAdministrador->LoadByLoginAndAtivo($_POST["txtLogin"]);
	if($bAdministrador)
	{
		$sSenha = $oAdministrador->GenerateName(6);
		$oAdministrador->Senha = md5($sSenha);
		$oAdministrador->Save();
		
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
		$bSend = $oMail->Send();
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt" lang="pt" dir="ltr">
<head>
	<title>Painel Administrativo</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<link type="text/css" rel="stylesheet" href="css/geral.css" />
	<link type="text/css" rel="stylesheet" href="css/login.css" />
	<script language="javascript" type="text/javascript" src="http://www.clicknow.com.br/crossbrowser/fonte.js"></script>
	<script language="javascript" type="text/javascript">
		window.onload = function(){
			document.getElementById("txtLogin").focus();
		}
	</script>
</head>
<body>
	<div class="geral">
		<div class="conteudo">
			<h1 title="Painel administrativo"><img src="imgs/logo.jpg" alt="Painel administrativo" /></h1>
			<p>Digite seu login abaixo:</p>
			<?php
			if($_POST)
			{
				if($bAdministrador)
				{
					if($bSend)
					{
						?>
						<div class="sucesso">
							Sua nova senha foi enviada para seu e-mail com sucesso!
						</div>
						<?php
					}
					else
					{
						?>
						<div class="erro">
							Problemas ao enviar sua nova senha, tente novamente mais tarde!
						</div>
						<?php
					}
				}
				else
				{
					?>
					<div class="erro">
						Login não encontrado ou inativo!
					</div>
					<?php
				}
			}
			?>
			<form action="" method="post">
				<ul>
					<li>
						<label>
							Login:
							<input type="text" name="txtLogin" id="txtLogin" maxlength="20" size="50" />
						</label>
					</li>
					<li>
						<input type="image" alt="Entrar" title="Entrar" src="imgs/botoes/entrar.png" />
						<a href="login.php"><img alt="Voltar" title="Voltar" src="imgs/botoes/voltar.png" /></a>
					</li>
				</ul>
			</form>
		</div>
		<div class="rodape">
			<a href="http://www.clicknow.com.br" target="_blank">Desenvolvimento Web: <strong>ClickNow</strong>®</a>
		</div>
	</div>
</body>
</html>