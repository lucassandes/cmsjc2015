<?php 

include_once("../library/config/database/tadministrador.php");

$oAdministrador = new tadministrador();
  
if($_POST)
{          
	if($oAdministrador->Authentication($_POST["txtLogin"], $_POST["txtSenha"]))
	{           
		header("Location: " . (($_GET["u"]) ? urldecode($_GET["u"]) : $oAdministrador->WebURLAdmin));
    	exit();
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
			<h1 title="<?=$oAdministrador->WebTitle;?>"><img src="imgs/logo.jpg" alt="<?=$oAdministrador->WebTitle;?>" title="<?=$oAdministrador->WebTitle;?>" /></h1>
			<p>Para acessar o painel administrativo digite seu login e senha abaixo:</p>
			<?php
			if($_POST)
			{
				?>
				<div class="erro">
					Login e/ou senha inválidos!
				</div>
				<?php
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
						<label>
							Senha:
							<input type="password" name="txtSenha" id="txtSenha" maxlength="20" size="28" />
							<input type="image" alt="Entrar" title="Entrar" src="imgs/botoes/entrar.png" class="entrar" />
						</label>
					</li>
					<li>
						<a href="esqueci-minha-senha.php" class="esqueci-minha-senha">Esqueci minha senha</a>
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