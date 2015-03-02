<?php

$Chave = "mmkt-enviar-mensagem";
include("../verifica.php");
include_once("../../library/master-page.php");
include_once("../../library/config/database/tmmktenvio.php");

//verifica envio
$oEnvio = new tmmktenvio();
if(!$oEnvio->LoadByPrimaryKey($_GET["id"]))
{
	header("Location: index.php?" . $_SERVER["QUERY_STRING"]);
	exit();
}

$oMasterPage = new MasterPage();
$oMasterPage->Init("../master.php");
$oMasterPage->AddParameter("Chave", $Chave);
$oMasterPage->Open("PageTop");
$passo = 2;
include("abas.php");
$oMasterPage->Close("PageTop");
$oMasterPage->Open("PageContent");

?>
Nome do remetente:
<p><?=$oEnvio->Nome;?></p>
<br />
E-mail do remetente:
<p><?=$oEnvio->Email;?></p>
<br />
Assunto da mensagem:
<p><?=$oEnvio->Assunto;?></p>
<br />
Quantidade de e-mails:
<p><?=$oEnvio->Total;?></p>
<br />
<iframe src="<?=$oEnvio->WebURLMMKT . $oEnvio->Modelo . "/index.php";?>" frameborder="1" width="650" height="500"></iframe>
<div class="linha"></div>
<table width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<td><a href="index.php?<?=$_SERVER["QUERY_STRING"];?>"><img src="../imgs/botoes/anterior.png" alt="Anterior" title="Anterior" /></a></td>
		<td align="right"><a href="teste-de-envio.php?<?=$_SERVER["QUERY_STRING"];?>"><img src="../imgs/botoes/proximo.png" alt="Próximo" title="Próximo" /></a></td>
	</tr>
</table>
<?php

$oMasterPage->Close("PageContent");
$oMasterPage->End();

?>