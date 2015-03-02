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
$passo = 4;
include("abas.php");
$oMasterPage->Close("PageTop");
$oMasterPage->Open("PageContent");

?>
<table width="650">
	<tr>
		<td>
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
		</td>
		<td align="right">
			<a href="javascript:void(0);" onclick="window.open('enviar.php?id=<?=$oEnvio->ID;?>', 'enviar', 'toolbar=0, location=0, directories=0, status=0, menubar=0, scrollbars=0, resizable=0, width=650, height=500, top=0, left=0');">
				<img src="../imgs/botoes/iniciar-envio.png" alt="Iniciar Envio" title="Iniciar Envio" />
			</a>
		</td>
	</tr>
</table>
<br />
<iframe src="<?=$oEnvio->WebURLMMKT . $oEnvio->Modelo . "/index.php";?>" frameborder="1" width="650" height="500"></iframe>
<div class="linha"></div>
<a href="teste-de-envio.php?<?=$_SERVER["QUERY_STRING"];?>"><img src="../imgs/botoes/anterior.png" alt="Anterior" title="Anterior" /></a>
<?php

$oMasterPage->Close("PageContent");
$oMasterPage->End();

?>