<?php

$Chave = "mmkt-enviar-mensagem";
include("../verifica.php");
include_once("../../library/master-page.php");
include_once("../../library/config/sendmail.php");
include_once("../../library/config/database/tparametro.php");
include_once("../../library/config/database/tmmktenvio.php");

//verifica envio
$oEnvio = new tmmktenvio();
if(!$oEnvio->LoadByPrimaryKey($_GET["id"]))
{
	header("Location: index.php?" . $_SERVER["QUERY_STRING"]);
	exit();
}

//post
if($_POST)
{
	//variáveis
	$txtEmail = $_POST["txtEmail"];
	
	//conteúdo
	ob_start();
	
	$_ID = null;
	$_Nome = "Teste de Envio";
	$_Email = $txtEmail;
	$_EnvioID = $oEnvio->ID;
	
	include($oEnvio->DirectoryMMKTPath . $oEnvio->Modelo . "/index.php");
	$Conteudo = ob_get_contents();
	ob_end_clean();
	
	//envia e-mail
	$oMail = new SendMail();
	$oMail->AddAddress($txtEmail, $_Nome);
	$oMail->SetFrom($oEnvio->Email, $oEnvio->Nome);
	$oMail->Sender = tparametro::Get("email-retorno");
	$oMail->Subject = $oEnvio->Assunto . " - " . $_Nome;
	$oMail->MsgHTML($Conteudo);
	if($oMail->Send())
	{
		$oEnvio->SetMessage("Verde", "Mensagem enviada para: <b>" . $txtEmail . "</b>");
	}
	else
	{
		$oEnvio->SetMessage("Vermelho", "Problemas ao enviar mensagem para: <b>" . $txtEmail . "</b>");
	}
}

$oMasterPage = new MasterPage();
$oMasterPage->Init("../master.php");
$oMasterPage->AddParameter("Chave", $Chave);
$oMasterPage->Open("PageTop");
$passo = 3;
include("abas.php");
$oMasterPage->Close("PageTop");
$oMasterPage->Open("PageContent");

?>
<form action="" method="post" class="formMensagem">
	<p>Para efetuar um teste de envio digite um e-mail válido abaixo e clique em enviar:</p>
	<input size="60" maxlength="150" type="text" id="txtEmail" name="txtEmail" value="<?=$txtEmail;?>" class="{focus:true, required:true, email:true}" title="Digite o e-mail para teste corretamente." />
	<br />
	<input type="image" src="../imgs/botoes/enviar.png" alt="Enviar" title="Enviar" />
</form>
<div class="linha"></div>
<table width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<td><a href="confirmacao-de-envio.php?<?=$_SERVER["QUERY_STRING"];?>"><img src="../imgs/botoes/anterior.png" alt="Anterior" title="Anterior" /></a></td>
		<td align="right"><a href="concluido.php?<?=$_SERVER["QUERY_STRING"];?>"><img src="../imgs/botoes/proximo.png" alt="Próximo" title="Próximo" /></a></td>
	</tr>
</table>
<?php

$oMasterPage->Close("PageContent");
$oMasterPage->End();

?>