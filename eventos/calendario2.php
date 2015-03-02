<?php

$oEvento = new tevento();
$oEvento->SQLTotal = 4;

?>


<ul class="nav nav-tabs" role="tablist">
    <?php
    function MesLiteral($mes) {
        switch($mes) {
            case 01:
                $mes_atual='Jan';
                break;
            case 02:
                $mes_atual='Fev';
                break;
            case 03:
                $mes_atual='Mar';
                break;

            case 04:
                $mes_atual='Abr';
                break;

            case 05:
                $mes_atual='Mai';
                break;

            case 06:
                $mes_atual='Jun';
                break;

            case 07:
                $mes_atual='Jul';
                break;

            case 08:
                $mes_atual='Ago';
                break;

            case 09:
                $mes_atual='Set';
                break;

            case 10:
                $mes_atual='Out';
                break;

            case 11:
                $mes_atual='Nov';
                break;

            case 12:
                $mes_atual='Dez';
                break;

        }
        return  $mes_atual;
    }


    for ($i = -1; $i < 4; $i++) {
        $dia_ = date('d', strtotime("+" . $i . " days"));
        $mes_ = date('m', strtotime("+" . $i . " days"));
        $mes_literal =  MesLiteral($mes_);

        if ($i == 0) {
            echo(' <li class="active"><a href="#dia' . $i . '-tab" role="tab" data-toggle="tab">' . $dia_ . '<br/><span>'. $mes_literal .'</span></a></li>');
        } else {
            if ($i == 3) {
                echo(' <li class="hidden-md"><a href="#dia' . $i . '-tab" role="tab" data-toggle="tab">' . $dia_ . '<br/><span>'. $mes_literal .'</span></a></li>');
            } else {
                echo(' <li><a href="#dia' . $i . '-tab" role="tab" data-toggle="tab">' . $dia_ . '<br/><span>'. $mes_literal .'</span></a></li>');

            }
        }
    }
    ?>


</ul>

<!-- Tab panes -->
<div class="tab-content container-box no-top-border">
    <?php

    ?>
    <!--<p class="data"><?= $oEvento->DateFormat("d \d\e MONTH \d\e Y", $oEvento->DateConvert($dia_atual . "/" . $mes_atual . "/" . $ano_atual)); ?></p>-->
    <?php
    $i = 1;
    for ($i = -1; $i < 4; $i++) {

        $dia_ = date('d', strtotime("+" . $i . " days"));
        $mes_ = date('m', strtotime("+" . $i . " days"));
        $ano_ = date('Y', strtotime("+" . $i . " days"));


        $oEvento->LoadByDiaMesAno($dia_, $mes_, $ano_);

        if ($i == 0) {
            echo('<div class="tab-pane fade in active" id="dia' . $i . '-tab">');
        } else {
            echo('<div class="tab-pane fade" id="dia' . $i . '-tab">');
        }
        echo('<ul>');
        if ($oEvento->NumRows > 0) {
            ?>

                <?php
                for ($c = 0; $c < $oEvento->NumRows; $c++) {
                    ?>
                    <li>
                        <a href="eventos/?ano=<?= $ano; ?>&amp;mes=<?= $mes; ?>#evento<?= $oEvento->ID; ?>">
                            <?php if ($oEvento->Hora || $oEvento->Local) { ?>
                                <strong><?= $oEvento->Hora; ?><?= (($oEvento->Hora && $oEvento->Local) ? " - " : ""); ?><?php echo(utf8_encode($oEvento->Local)); ?></strong>
                                <br/><?php } ?>
                            <?php echo(utf8_encode($oEvento->Titulo)); ?>
                        </a>
                    </li>
                    <?php
                    $oEvento->MoveNext();
                }
                ?>


        <?php
        } else {

            echo('<li>Sem eventos para esta data.</li>');

        }
        echo('<li> <a href="eventos/?ano=' . $ano_ . '&amp;mes=' . $mes_ . '" class="vejaMaisEventos">Veja Mais Eventos</a></li>');
        echo('</ul></div>');
    }
    ?>

    <!-- tab-pane -->

</div>
