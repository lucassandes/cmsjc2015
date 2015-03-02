<?php

include_once("../library/master-page.php");
include_once("../library/config/database/tvereador.php");

$oMasterPage = new MasterPage();
$oMasterPage->Init("../master.php", utf8_encode("Bancadas e Lideranças / Lideres Partidários"));
$oMasterPage->AddParameter("css", "bancadas-e-liderancas/lideres-partidarios");
$oMasterPage->AddParameter("pagina", "bancadas-e-liderancas");
$oMasterPage->AddParameter("titulo", "bancadas-e-liderancas/lideres-partidarios");
$oMasterPage->Open("PageContent");

?>
<h1><?php echo utf8_encode("Líderes Partidários"); ?></h1>
    <div class="row">
<?php

$oVereador = new tvereador();
$oVereador->SQLField = "tvereador.*, tpartido.Sigla as Partido";
$oVereador->SQLJoin = "INNER JOIN tpartido ON tpartido.ID = tvereador.PartidoID";
$oVereador->SQLWhere = "LiderPartidario = 1 OR LiderGoverno = 1";
$oVereador->SQLOrder = "tpartido.Titulo ASC, LiderGoverno ASC, Nome ASC";
if ($oVereador->LoadSQLAssembled()) {
    ?>



    <?php
    for ($c = 0; $c < $oVereador->NumRows; $c++) {
        switch ($oVereador->Partido) {
            case 'DEM':
                $class = 'bs-callout-blue';
                break;

            case 'PSDB':
                $class = 'bs-callout-dark-blue';
                break;

            case 'PMDB':
                $class = 'bs-callout-black';
                break;
            case 'PT':
                $class = 'bs-callout-red';
                break;

            case 'PPS':
                $class = 'bs-callout-red';
                break;

            case 'PP':
                $class = 'bs-callout-dark-blue';
                break;

            case 'PRB':
                $class = 'bs-callout-green';
                break;

            case 'PROS':
                $class = 'bs-callout-blue';
                break;

            case 'PRP':
                $class = 'bs-callout-blue';
                break;

            case 'PSB':
                $class = 'bs-callout-red';
                break;

            case 'PV':
                $class = 'bs-callout-green';
                break;

            default:
                $class = 'bs-callout-blue';
                break;
        }

        ?>

        <div class="col-md-6 ">
            <div class="box container-box bs-callout <?= $class ?> bancadas-partidarias ">
                <ul>
                    <li>
                        <h3><?= (($oVereador->LiderGoverno) ? "Líder de Governo" : $oVereador->Partido); ?></h3>

                        <p><a href="<?= $oVereador->GenerateURL(); ?>"><?= utf8_encode($oVereador->Nome); ?></a></p>
                    </li>
                </ul>
            </div>
        </div>
        <?php
        $oVereador->MoveNext();
    }

    ?>


<?php
} else {
    ?>
    <br/><p>Nenhum registro encontrado.</p>
<?php
}

?>
</div>
    <div class="clear"></div>
    <a href="bancadas-e-liderancas/" class="voltar">Voltar</a>
<?php

$oMasterPage->Close("PageContent");
$oMasterPage->End();

?>