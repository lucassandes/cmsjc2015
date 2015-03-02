<?php

include_once(dirname(dirname(__FILE__)) . "/library/config/database/tgaleria.php");
include_once(dirname(dirname(__FILE__)) . "/library/config/database/tgaleriafoto.php");

$oGaleria = new tgaleria();
if (!$oGaleria->LoadByChave($GaleriaChave)) {
    $oGaleria->LoadByPrimaryKey($GaleriaID);
}

if ($oGaleria->NumRows > 0) {
    $oGaleriaFoto = new tgaleriafoto();


    if ($oGaleriaFoto->LoadByGaleriaID($oGaleria->ID)) {
        //$path = $path . $oGaleriaFoto->Imagem;
        /*echo $path;

        $path = $path . $oGaleriaFoto->Imagem;
        echo $path;
        //$thumb = Thumbnail($path, 770, 440,"",true);*/
        ?>
        <div class="galeriaFotos">
            <div class="col-md-12"><h3 class="zwo3Italic">Galeria de Fotos</h3></div>


            <?php
            //echo $oGaleriaFoto->Imagem;
            for ($c = 0; $c < $oGaleriaFoto->NumRows; $c++) {

                ?>
                <?php /* <li <?php if (($c + 1) % 6 == 0){ ?>class="noMarginRight"<?php } ?>> */ ?>
                <div class="col-lg-3 col-md-4 col-xs-6 thumb">
                    <a href="<?= $oGaleriaFoto->Thumbnail($oGaleriaFoto->Imagem, 1001, 572); ?>"
                       title="<?= $oGaleriaFoto->Legenda; ?>"  data-toggle="lightbox" data-gallery="multiimages"  data-parent=".galeriaFotos">

                        <img src="<?= $oGaleriaFoto->Thumbnail($oGaleriaFoto->Imagem, 300, 300, "", true); ?>"
                             alt="<?= $oGaleriaFoto->Legenda; ?>" title="<?= $oGaleriaFoto->Legenda; ?>"
                             class="img-responsive"/>
                    </a>
                </div>
                <?php
                $oGaleriaFoto->MoveNext();
            }
            ?>


            <div class="clear"></div>
        </div>
    <?php
    }
}

?>