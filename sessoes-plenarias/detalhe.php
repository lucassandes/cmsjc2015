<?php

include_once("../library/master-page.php");
include_once("../library/config/database/tsessao.php");

$oSessao = new tsessao();
if (!$oSessao->LoadByPrimaryKey($_GET["id"])) {
    header("Location: " . $oSessao->WebURL);
    exit();
}

$oMasterPage = new MasterPage();
$oMasterPage->Init("../master.php", "Sessões Plenárias / " . utf8_encode($oSessao->TipoLista[$oSessao->Tipo]));
$oMasterPage->AddParameter("css", "sessoes-plenarias/detalhe");
$oMasterPage->AddParameter("pagina", "sessoes-plenarias");
$oMasterPage->AddParameter("titulo", "sessoes-plenarias/" . $oSessao->Tipo);
$oMasterPage->Open("PageContent");

?>

    <div class="cabecalho audiencias-publicas ">
        <h1>Resultado</h1>

        <p class="data"><?= $oSessao->DateFormat("d/m/Y", $oSessao->Data); ?><?= (($oSessao->Hora) ? " - " . $oSessao->Hora : ""); ?></p>

        <h3><?= utf8_encode($oSessao->Titulo); ?></h3>

        <?php

        if ($oSessao->Local || $oSessao->Vereador) {
            ?>
            <p class="info">
                <?php if ($oSessao->Local) { ?><strong>Local:</strong> <?= utf8_encode($oSessao->Local); ?>
                    <br/><?php } ?>
                <?php if ($oSessao->Vereador) { ?>
                    <strong>Vereador:</strong> <?= utf8_encode($oSessao->Vereador); ?><?php } ?>
            </p>
        <?php
        }

        ?>
    </div>
    <div class="homenagens">
        <?php if ($oSessao->Imagem) { ?><img class="imgDestaque" alt="<?= $oSessao->Titulo; ?>"
                                             title="<?= $oSessao->Titulo; ?>"
                                             src="<?= $oSessao->Thumbnail($oSessao->Imagem, 340, 283); ?>" align="left"
                                             class="img-responsive feat-image " /><?php } ?>
        <?php if (!$oSessao->IsClear($oSessao->Descricao)) { ?>
            <div class="fckEditor">
            <?php
            $string = $oSessao->HTMLDecode($oSessao->Descricao);
            echo utf8_encode($string);

            ?>
            </div><?php } ?>
        <div class="clear" style="height: 30px;"></div>
    </div>
<?php if ($oSessao->Arquivo) { ?>
    <a href="<?= $oSessao->DownloadURL($oSessao->Arquivo); ?>" class="botDownload">
        <button type="button" class="btn btn-default" aria-label="Left Align">
            <span class="glyphicon glyphicon-save" aria-hidden="true"></span> Download do Arquivo
        </button>
    </a>

<?php } ?>
<?php

$GaleriaID = $oSessao->GaleriaID; ?>
    <div class="clear" style="height: 30px;"></div>
    <div class="row">
        <?php include("../common/galeria-de-fotos.php"); ?>
    </div> <a href="javascript:history.back();" class="mid">Voltar</a>
<?php

$oMasterPage->Close("PageContent");
$oMasterPage->End();

?>