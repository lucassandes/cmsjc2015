<?php

include_once("../../library/config/sendmail.php");
include_once("../../library/config/database/tmmktenvio.php");
include_once("../../library/config/database/tmmktemail.php");
include_once("../../library/config/database/tparametro.php");

$oEnvio = new tmmktenvio();

//post
$msg = "";
if($oEnvio->CheckKeyForm($_POST))
{
	//vars
	$txtNome = $_POST["txtNome"];
	$txtEmail = $_POST["txtEmail"];
	
	//cadastra e-mail
	switch(tmmktemail::Create($txtEmail, $txtNome, "amigo"))
	{
		case tmmktemail::CREATE_INVALID: $msg = "E-mail inválido."; break;
		case tmmktemail::CREATE_SUCCESS: $msg = "E-mail cadastrado com sucesso."; break;
		case tmmktemail::CREATE_ERROR: $msg = "E-mail já cadastrado."; break;
	}
	
	//verifica envio
	if($oEnvio->LoadByPrimaryKey($_GET["envioid"]))
	{
		ob_start();
		
		$_ID = null;
		$_Nome = $txtNome;
		$_Email = $txtEmail;
		$_EnvioID = $oEnvio->ID;
		
		include($oEnvio->DirectoryMMKTPath . $oEnvio->Modelo . "/index.php");
		$Conteudo = ob_get_contents();
		ob_end_clean();
		
		//envia e-mail
		$oMail = new SendMail();
		$oMail->AddAddress($txtEmail, $txtNome);
		$oMail->SetFrom($oEnvio->Email, $oEnvio->Nome);
		$oMail->Sender = tparametro::Get("email-retorno");
		$oMail->Subject = $oEnvio->Assunto;
		$oMail->MsgHTML($Conteudo);
		if($oMail->Send())
		{
			$msg = "Mensagem enviada com sucesso.";
		}
		else
		{
			$msg = "Problemas ao enviar a mensagem, tente novamente mais tarde.";
		}
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Enviar para um amigo</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<link type="text/css" rel="stylesheet" href="../../admin/css/geral.css" />
	<link type="text/css" rel="stylesheet" href="../../admin/css/master.css" />
	<script language="javascript" type="text/javascript" src="../../library/plugins/jquery/jquery.js"></script>
	<script language="javascript" type="text/javascript" src="../../library/plugins/jquery/jquery.metadata.js"></script>
	<script language="javascript" type="text/javascript" src="../../library/plugins/jquery/jquery.validate.js"></script>
	<script language="javascript" type="text/javascript" src="../../library/plugins/jquery/jquery.function.js"></script>
	<script language="javascript" type="text/javascript">$(init);</script>
	<?php
	if($msg)
	{
		?>
		<script language="javascript" type="text/javascript">
			$(function(){
				alert("<?=$msg;?>");
			});
		</script>
		<?php
	}
	?>
</head>
<body>
	<div class="margem">
		<img src="../../admin/imgs/logo.jpg" alt="<?=$oEnvio->WebTitle;?>" title="<?=$oEnvio->WebTitle;?>" />
		<form action="" method="post" class="formAlert">
			<?=$oEnvio->GenerateKeyForm();?>
			<ul>
		    	<li>
					<label>
						Nome*:
						<input size="60" maxlength="150" type="text" id="txtNome" name="txtNome" class="{required:true, focus:true}" title="Digite o nome." />
					</label>
				</li>
				<li>
					<label>
						E-mail*:
						<input size="60" maxlength="150" type="text" id="txtEmail" name="txtEmail" class="{required:true, email:true}" title="Digite o e-mail corretamente." />
					</label>
				</li>
		    </ul>
		    <input type="image" src="../../admin/imgs/botoes/enviar.png" alt="Enviar" title="Enviar" />
		</form>
	</div>
</body>
</html>