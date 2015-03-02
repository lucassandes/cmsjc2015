<?php

include_once("../library/master-page.php");
include_once("../library/paginator.php");
include_once("../library/config/database/tlicitacao.php");
include_once("../library/config/database/tlicitacaoarquivo.php");

$status = $_GET["status"];

$oLicitacao = new tlicitacao();
if (!array_key_exists($status, $oLicitacao->StatusLista)) {
    header("Location: " . $oLicitacao->WebURL);
    exit();
}

$oLicitacao->SQLWhere = "Status = '" . $status . "'";
$oPaginator = new Paginator($oLicitacao->GetCount(), 10);
$oLicitacao->SQLOrder = "Ordem DESC";
$oLicitacao->LoadByPaginator($oPaginator->Limit, $oPaginator->Total);

$oMasterPage = new MasterPage();
$oMasterPage->Init("../master.php", "Licitações / " . utf8_encode($oLicitacao->StatusLista[$status]));
$oMasterPage->AddParameter("css", "licitacoes/lista");
$oMasterPage->AddParameter("pagina", "licitacoes");
$oMasterPage->AddParameter("titulo", "licitacoes/" . utf8_encode($status));
$oMasterPage->Open("PageContent");




?>
<?php


if ($oLicitacao->NumRows > 0) {
    ?>
    <h1><?= utf8_encode($oLicitacao->StatusLista[$status]); ?></h1>
    <!--<h2 class="zwo3Italic">Modalidade <span>N�mero / Processo</span></h2> -->
    <!--<ul class="licitacoes" id="paginator">-->
    <?php
    for ($c = 0; $c < $oLicitacao->NumRows; $c++) {
        switch (utf8_encode($oLicitacao->ModalidadeLista[$oLicitacao->Modalidade])) {
            case "Tomada de Preços":
                $cor = "bs-callout-dark-blue";
                break;
            case "Pregão":
                $cor = "bs-callout-red";
                break;
            case "Concorrência Pública":
                $cor = "bs-callout-green";
                break;
            default:
                $cor = "bs-callout-yellow";
        }
        ?>
        <div>

            <!--<h2><?= $oLicitacao->ModalidadeLista[$oLicitacao->Modalidade]; ?></h2> -->

            <div class="container-box item-licitacao <?php echo $cor; ?>">
                <h3><?= utf8_encode($oLicitacao->ModalidadeLista[$oLicitacao->Modalidade]); ?> -
                    Nº: <?= utf8_encode($oLicitacao->Numero); ?></h3>


                <?php if (!$oLicitacao->IsClear($oLicitacao->Objeto)) { ?>



                    <?php
                    $string = $oLicitacao->HTMLDecode($oLicitacao->Objeto);
                    echo utf8_encode($string);
                    ?><?php
                } ?>

                <div class="clear"></div>

                <?php
                if ($status == "licitacoes-em-aberto") {
                    $oLicitacaoArquivo = new tlicitacaoarquivo();
                    if ($oLicitacaoArquivo->LoadByLicitacaoID($oLicitacao->ID)) {
                        for ($i = 0; $i < $oLicitacaoArquivo->NumRows; $i++) {
                            if ($oLicitacaoArquivo->CheckSession()) {
                                ?>
                                <a href="<?= $oLicitacaoArquivo->DownloadURL($oLicitacaoArquivo->Arquivo); ?>"
                                   class="download">
                                    <button type="button" class="btn btn-default btn-lg">
                                        <span class="glyphicon glyphicon-save"
                                              aria-hidden="true"></span>  <?= utf8_encode($oLicitacaoArquivo->Titulo); ?>
                                    </button>
                                </a>



                            <?php
                            } else {
                                ?>
                                <a href="licitacoes/faca-o-download.php?id=<?= $oLicitacaoArquivo->ID; ?>"
                                   class="download">

                                    <button type="button" class="btn btn-default btn-lg">
                                        <span class="glyphicon glyphicon-save"
                                              aria-hidden="true"></span>  <?= utf8_encode($oLicitacaoArquivo->Titulo); ?>
                                    </button>
                                </a>
                            <?php
                            }
                            $oLicitacaoArquivo->MoveNext();
                        }
                    }
                }
                ?>
                <div class="clear"></div>


                <?php
                $bQuestionamento = !$oLicitacao->IsClear($oLicitacao->Questionamento) && $status == "licitacoes-em-aberto";
                $bComunicado = !$oLicitacao->IsClear($oLicitacao->Comunicado);
                $bAndamento = !$oLicitacao->IsClear($oLicitacao->Andamento);
                /*if (($bQuestionamento || $bComunicado || $bAndamento) && ($status == "licitacoes-em-aberto" || $status == "licitacoes-em-andamento")) {
                    ?>
                    <ul class="midLista">
                        <?php if ($bQuestionamento) { ?>
                            <li><a href="javascript:void(0);"
                                   onclick="$('.div-comunicado, .div-andamento, .div-questionamento').hide(); $('#divQuestionamento-<?= $c; ?>').slideToggle(500);">Questionamentos</a>
                            </li><?php } ?>
                        <?php if ($bComunicado) { ?>
                            <li><a href="javascript:void(0);"
                                   onclick="$('.div-comunicado, .div-andamento, .div-questionamento').hide(); $('#divComunicado-<?= $c; ?>').slideToggle(500);">Comunicados</a>
                            </li><?php } ?>
                        <?php if ($bAndamento) { ?>
                            <li><a href="javascript:void(0);"
                                   onclick="$('.div-comunicado, .div-andamento, .div-questionamento').hide(); $('#divAndamento-<?= $c; ?>').slideToggle(500);">Status</a>
                            </li><?php } ?>
                    </ul>
                    <div class="clear"></div>
                    <?php if ($bQuestionamento) { ?>
                        <div class="fckEditor div-questionamento" id="divQuestionamento-<?= $c; ?>"
                             style="display:none;"><?= $oLicitacao->HTMLDecode($oLicitacao->Questionamento); ?></div><?php } ?>
                    <?php if ($bComunicado) { ?>
                        <div class="fckEditor div-comunicado" id="divComunicado-<?= $c; ?>"
                             style="display:none;"><?= $oLicitacao->HTMLDecode($oLicitacao->Comunicado); ?></div><?php } ?>
                    <?php if ($bAndamento) { ?>
                        <div class="fckEditor div-andamento" id="divAndamento-<?= $c; ?>"
                             style="display:none;"><?= $oLicitacao->HTMLDecode($oLicitacao->Andamento); ?></div><?php } ?>
                <?php
                }*/
                ?>

                <!--<button type="button" class="btn btn-default btn-lg">
                    <span class="glyphicon glyphicon-save" aria-hidden="true"></span> PP 23/2014
                </button>-->


                <div class="panel-group" id="accordion-<?php echo $c; ?>" role="tablist" aria-multiselectable="true">
                    <?php if ($bQuestionamento && strlen($oLicitacao->HTMLDecode($oLicitacao->Questionamento)) > 10) { //echo strlen($bQuestionamento); ?>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingOne-<?php echo $c; ?>">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion-<?php echo $c; ?>"
                                       href="#collapseOne-<?php echo $c; ?>" aria-expanded="true"
                                       aria-controls="collapseOne-<?php echo $c; ?>">
                                        <span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span>
                                        Questionamentos
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseOne-<?php echo $c; ?>" class="panel-collapse collapse" role="tabpanel"
                                 aria-labelledby="headingOne-<?php echo $c; ?>">
                                <div class="panel-body">
                                    <?php
                                    $questionamentos = $oLicitacao->HTMLDecode($oLicitacao->Questionamento);
                                    echo utf8_encode($questionamentos);



                                    ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if ($bComunicado && strlen($oLicitacao->HTMLDecode($oLicitacao->Comunicado)) > 10) { //echo  strlen($oLicitacao->HTMLDecode($oLicitacao->Comunicado)); ?>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingTwo-<?php echo $c; ?>">
                                <h4 class="panel-title">
                                    <a class="collapsed" data-toggle="collapse"
                                       data-parent="#accordion-<?php echo $c; ?>"
                                       href="#collapseTwo-<?php echo $c; ?>" aria-expanded="false"
                                       aria-controls="collapseTwo-<?php echo $c; ?>">
                                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                        Comunicados
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseTwo-<?php echo $c; ?>" class="panel-collapse collapse" role="tabpanel"
                                 aria-labelledby="headingTwo-<?php echo $c; ?>">
                                <div class="panel-body">

                                    <?php

                                    $comunicados = $oLicitacao->HTMLDecode($oLicitacao->Comunicado);
                                    echo utf8_encode($comunicados);

                                    ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if ($bAndamento && strlen($oLicitacao->HTMLDecode($oLicitacao->Andamento)) > 10) { //echo strlen($bAndamento);  ?>

                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingThree-<?php echo $c; ?>">
                                <h4 class="panel-title">
                                    <a class="collapsed" data-toggle="collapse"
                                       data-parent="#accordion-<?php echo $c; ?>"
                                       href="#collapseThree-<?php echo $c; ?>" aria-expanded="false"
                                       aria-controls="collapseThree-<?php echo $c; ?>">
                                        <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
                                        Status
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseThree-<?php echo $c; ?>" class="panel-collapse collapse" role="tabpanel"
                                 aria-labelledby="headingThree-<?php echo $c; ?>">
                                <div class="panel-body">

                                    <?php

                                    $andamento = $oLicitacao->HTMLDecode($oLicitacao->Andamento);
                                    echo utf8_encode($andamento);

                                    ?>

                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <!--<li>
            <table cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td valign="top" bgcolor="eaebe6" width="80"><h3
                            class="zwo3Italic"><?= $oLicitacao->ModalidadeLista[$oLicitacao->Modalidade]; ?></h3>
                    </td>
                    <td>
                        <strong>N�: <?= $oLicitacao->Numero; ?></strong><br/><br/>
                        <?php if (!$oLicitacao->IsClear($oLicitacao->Objeto)) { ?>
                            <div
                                class="fckEditor"><?= $oLicitacao->HTMLDecode($oLicitacao->Objeto); ?></div><?php } ?>
                        <?php
        if ($status == "licitacoes-em-aberto") {
            $oLicitacaoArquivo = new tlicitacaoarquivo();
            if ($oLicitacaoArquivo->LoadByLicitacaoID($oLicitacao->ID)) {
                for ($i = 0; $i < $oLicitacaoArquivo->NumRows; $i++) {
                    if ($oLicitacaoArquivo->CheckSession()) {
                        ?>
                                        <a href="<?= $oLicitacaoArquivo->DownloadURL($oLicitacaoArquivo->Arquivo); ?>"
                                           class="download">
                                            <span></span>
                                            <?= $oLicitacaoArquivo->Titulo; ?>
                                        </a>
                                    <?php
                    } else {
                        ?>
                                        <a href="licitacoes/faca-o-download.php?id=<?= $oLicitacaoArquivo->ID; ?>"
                                           class="download">
                                            <span></span>
                                            <?= $oLicitacaoArquivo->Titulo; ?>
                                        </a>
                                    <?php
                    }
                    $oLicitacaoArquivo->MoveNext();
                }
            }
        }
        ?>
                        <div class="clear"></div>
                        <?php
        $bQuestionamento = !$oLicitacao->IsClear($oLicitacao->Questionamento) && $status == "licitacoes-em-aberto";
        $bComunicado = !$oLicitacao->IsClear($oLicitacao->Comunicado);
        $bAndamento = !$oLicitacao->IsClear($oLicitacao->Andamento);
        if (($bQuestionamento || $bComunicado || $bAndamento) && ($status == "licitacoes-em-aberto" || $status == "licitacoes-em-andamento")) {
            ?>
                            <ul class="midLista">
                                <?php if ($bQuestionamento) { ?>
                                    <li><a href="javascript:void(0);"
                                           onclick="$('.div-comunicado, .div-andamento, .div-questionamento').hide(); $('#divQuestionamento-<?= $c; ?>').slideToggle(500);">Questionamentos</a>
                                    </li><?php } ?>
                                <?php if ($bComunicado) { ?>
                                    <li><a href="javascript:void(0);"
                                           onclick="$('.div-comunicado, .div-andamento, .div-questionamento').hide(); $('#divComunicado-<?= $c; ?>').slideToggle(500);">Comunicados</a>
                                    </li><?php } ?>
                                <?php if ($bAndamento) { ?>
                                    <li><a href="javascript:void(0);"
                                           onclick="$('.div-comunicado, .div-andamento, .div-questionamento').hide(); $('#divAndamento-<?= $c; ?>').slideToggle(500);">Status</a>
                                    </li><?php } ?>
                            </ul>
                            <div class="clear"></div>
                            <?php if ($bQuestionamento) { ?>
                                <div class="fckEditor div-questionamento" id="divQuestionamento-<?= $c; ?>"
                                     style="display:none;"><?= $oLicitacao->HTMLDecode($oLicitacao->Questionamento); ?></div><?php } ?>
                            <?php if ($bComunicado) { ?>
                                <div class="fckEditor div-comunicado" id="divComunicado-<?= $c; ?>"
                                     style="display:none;"><?= $oLicitacao->HTMLDecode($oLicitacao->Comunicado); ?></div><?php } ?>
                            <?php if ($bAndamento) { ?>
                                <div class="fckEditor div-andamento" id="divAndamento-<?= $c; ?>"
                                     style="display:none;"><?= $oLicitacao->HTMLDecode($oLicitacao->Andamento); ?></div><?php } ?>
                        <?php
        }
        ?>
                    </td>
                </tr>
            </table>
        </li> -->
        <?php
        $oLicitacao->MoveNext();
    }
    ?>
    <!--</ul> -->
    <?php
    include("../common/paginacao.php");
} else {
    ?>
    <p>Nenhum registro encontrado.</p>
<?php
}

?>
    <a href="licitacoes/" class="voltar">Voltar</a>
<?php

$oMasterPage->Close("PageContent");
$oMasterPage->End();

?>