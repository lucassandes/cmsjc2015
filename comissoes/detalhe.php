<?php

include_once("../library/master-page.php");
include_once("../library/config/database/tcomissao.php");

$tipo = $_GET["tipo"];

$oComissao = new tcomissao();
if (!array_key_exists($tipo, $oComissao->TipoLista)) {
    header("Location: " . $oComissao->WebURL);
    exit();
}

$oMasterPage = new MasterPage();
$oMasterPage->Init("../master.php", utf8_encode("Comissões / " ). utf8_encode($oComissao->TipoLista[$tipo]));
$oMasterPage->AddParameter("css", "comissoes/detalhe");
$oMasterPage->AddParameter("titulo", "comissoes/" . $tipo);
$oMasterPage->AddParameter("pagina", "comissoes");
$oMasterPage->Open("PageContent");

?>
<?php
$oComissao->SQLField =
    "
	tcomissao.*,
	t1.Nome as Presidente,
	t2.Nome as PresidenteSuplente,
	t3.Nome as Revisor,
	t4.Nome as RevisorSuplente,
	t5.Nome as Relator1,
	t6.Nome as Relator1Suplente,
	t7.Nome as Relator2,
	t8.Nome as Relator2Suplente,
	t9.Nome as Relator3,
	t10.Nome as Relator3Suplente
";
$oComissao->SQLJoin =
    "
	INNER JOIN tvereador t1 ON t1.ID = tcomissao.PresidenteID
	INNER JOIN tvereador t2 ON t2.ID = tcomissao.PresidenteSuplenteID
	INNER JOIN tvereador t3 ON t3.ID = tcomissao.RevisorID
	INNER JOIN tvereador t4 ON t4.ID = tcomissao.RevisorSuplenteID
	INNER JOIN tvereador t5 ON t5.ID = tcomissao.Relator1ID
	INNER JOIN tvereador t6 ON t6.ID = tcomissao.Relator1SuplenteID
	LEFT JOIN tvereador t7 ON t7.ID = tcomissao.Relator2ID
	LEFT JOIN tvereador t8 ON t8.ID = tcomissao.Relator2SuplenteID
	LEFT JOIN tvereador t9 ON t9.ID = tcomissao.Relator3ID
	LEFT JOIN tvereador t10 ON t10.ID = tcomissao.Relator3SuplenteID
";

if ($oComissao->LoadByTipo($tipo)) {
    if (strcmp($tipo, 'comissoes-permanentes') == 0) {
        echo(utf8_encode('<h1>Comissões Permanentes</h1>'));
    }
    ?>

    <h3 name="indice-title" id="indice-title"><span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> <?php echo utf8_encode("Índice");?>:</h3>

    <div class="comissoes">
        <div class="indice row">
            <ul>
                <?php
                $oComissao->Rewind();
                for ($c = 0; $c < $oComissao->NumRows; $c++) {
                    ?>

                    <div class="col-md-6">
                        <li>
                            <a href="comissoes/<?= $tipo; ?>/#comissao<?= $oComissao->ID; ?>"><?= utf8_encode($oComissao->Titulo); ?></a>
                        </li>
                    </div>
                    <?php
                    $oComissao->MoveNext();
                }
                ?>
            </ul>
        </div>
    </div> <!-- orçamentos -->

    <div class="clear"></div>
    <?php
    $oComissao->Rewind();
    $aux = 0;
    for ($c = 0; $c < $oComissao->NumRows; $c++) {

        if ($aux == 0) {
            $class = 'bs-callout-dark-blue';

            $aux++;
        } else if ($aux == 1) {
            $class = 'bs-callout-green';
            $aux++;
        } else if ($aux == 2) {
            $class = 'bs-callout-blue';
            $aux++;
        } else {
            $class = 'bs-callout-red';
            $aux = 0;
        }
        ?>

        <div class="container-box bs-callout <?= $class ?> " id="comissao<?= $oComissao->ID; ?>">
            <h3 class="zwo3Italic"><?= utf8_encode($oComissao->Titulo); ?></h3>
            <h4 class="zwo6">Presidente:</h4>
            <ul>
                <li><?= utf8_encode($oComissao->Presidente); ?></li>
                <li class="suplente"><span>Suplente:</span> <?= utf8_encode($oComissao->PresidenteSuplente); ?></li>
            </ul>
            <h4 class="zwo6">Revisor:</h4>
            <ul>
                <li><?= utf8_encode($oComissao->Revisor); ?></li>
                <li class="suplente"><span class="zwo6">Suplente:</span> <?= utf8_encode($oComissao->RevisorSuplente); ?></li>
            </ul>
            <h4 class="zwo6">Relator:</h4>
            <ul>
                <li><?= utf8_encode($oComissao->Relator1); ?></li>
                <li class="suplente"><span class="zwo6">Suplente:</span> <?= utf8_encode($oComissao->Relator1Suplente); ?></li>
            </ul>
            <?php
            if ($oComissao->Relator2) {
                ?>

                <h4 class="zwo6">Relator:</h4>
                <ul>
                    <li><?= utf8_encode($oComissao->Relator2); ?></li>
                    <li class="suplente"><span class="zwo6">Suplente:</span> <?= utf8_encode($oComissao->Relator2Suplente); ?></li>
                </ul>
            <?php
            }
            ?>
            <?php
            if ($oComissao->Relator3) {
                ?>
                <h4 class="zwo6">Relator:</h4>
                <ul>
                    <li><?= utf8_encode($oComissao->Relator3); ?></li>
                    <li class="suplente"><span class="zwo6">Suplente:</span> <?= utf8_encode($oComissao->Relator3Suplente); ?></li>
                </ul>
            <?php

            }
            ?>
            <?php
            $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

            ?>
            <p><a href="<?php echo $actual_link; ?>#indice-title"> <?php echo (utf8_encode("Voltar ao índice") );?></a></p>
        </div>
        <?php
        $oComissao->MoveNext();
    }
    ?>
<?php
} else {
    ?>
    <p>Nenhum registro encontrado.</p>
<?php
}

?>

    <a href="comissoes/" class="mid">Voltar</a>
<?php

$oMasterPage->Close("PageContent");
$oMasterPage->End();

?>