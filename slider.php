<div id="carousel-banner-principal" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
        <li data-target="#carousel-banner-principal" data-slide-to="0" class="active"></li>
        <li data-target="#carousel-banner-principal" data-slide-to="1"></li>
        <li data-target="#carousel-banner-principal" data-slide-to="2"></li>
        <li data-target="#carousel-banner-principal" data-slide-to="3"></li>
        <li data-target="#carousel-banner-principal" data-slide-to="4"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner">

        <?php
        $arNoticia = array();

        $oNoticiaDestaque = new tnoticia();
        $oNoticiaDestaque->SQLWhere = "Destaque = 1 AND (ImagemDestaque != '' AND ImagemDestaque IS NOT NULL)";
        $oNoticiaDestaque->SQLOrder = "Data DESC, Hora DESC";
        $oNoticiaDestaque->SQLTotal = 5;

        if ($oNoticiaDestaque->LoadSQLAssembled()) {
            ?>


            <?php
            for ($c = 0; $c < $oNoticiaDestaque->NumRows; $c++) {
                array_push($arNoticia, $oNoticiaDestaque->ID);
                ?>
                <div class="item <?php echo '', ($c == 0 ? 'active' : ''); ?>">
                    <!-- image for big devices -->
                    <?php $imgnoticia = "http://camarasjc2.hospedagemdesites.ws/clicknow".$oNoticiaDestaque->ImagemDestaque;
                    //echo $oNoticiaDestaque->ImagemDestaque;
                    // echo $imgnoticia;?>
                    <a href="<?= $oNoticiaDestaque->GenerateURL(); ?>"><img
                            src="<?= $oNoticiaDestaque->Thumbnail($oNoticiaDestaque->ImagemDestaque, 1140, 365, "", true, true); ?>"
                            alt="<?= $oNoticiaDestaque->Titulo; ?>" title="<?= utf8_encode($oNoticiaDestaque->Titulo); ?>" class="hidden-sm hidden-xs"/></a>
                    <!--image for small devices -->

                    <a href="<?= $oNoticiaDestaque->GenerateURL(); ?>"><img
                            src="<?= $oNoticiaDestaque->Thumbnail($oNoticiaDestaque->ImagemDestaque, 720, 400, "", true, true); ?>"
                            alt="<?= $oNoticiaDestaque->Titulo; ?>" title="<?= utf8_encode($oNoticiaDestaque->Titulo); ?>" class="visible-sm visible-xs"/></a>

                    <div class="carousel-caption ">
                        <h3><a href="<?= $oNoticiaDestaque->GenerateURL(); ?>"><?php echo (utf8_encode( $oNoticiaDestaque->Titulo)); ?></a></h3>

                        <p class=" hidden-xs"><a href="<?= $oNoticiaDestaque->GenerateURL(); ?>"><?php echo(utf8_encode( $oNoticiaDestaque->Subtitulo)); ?></a></p>
                    </div>
                </div>
                <?php
                $oNoticiaDestaque->MoveNext();
            }
            ?>
            <?php /*
    <div class="bannerHome">
		<div class="nav-slider">
			<div></div>
		</div>
		<ul class="slider">

				<li>
					<a href="<?= $oNoticiaDestaque->GenerateURL(); ?>"></a>
					<span class="bkg"></span>

					<div class="legenda">
						<div>
							<h2><?= $oNoticiaDestaque->Titulo; ?></h2>
							<?= $oNoticiaDestaque->Subtitulo; ?>
						</div>
					</div>
					<img
						src="<?= $oNoticiaDestaque->Thumbnail( $oNoticiaDestaque->ImagemDestaque, 740, 315, "", true, true ); ?>"
						alt="<?= $oNoticiaDestaque->Titulo; ?>" title="<?= $oNoticiaDestaque->Titulo; ?>"/>
				</li>

		</ul>
	</div>
    */
            ?>
        <?php
        }

        ?>




        <!--
        <div class="item ">
            <img src="<?php //echo $url; ?>images/foto-cortada2.jpg" alt="...">

            <div class="carousel-caption">
                <h3>Aprovado convênio com União para Libertadores 2</h3>

                <p>Com a aprovação, prefeitura firmará convênio com a União para viabilizar nova Copa Libertadores
                    na
                    cidade 2</p>
            </div>
        </div>

        <div class="item ">
            <img src="<?php //echo $url; ?>images/foto-cortada.jpg" alt="...">

            <div class="carousel-caption">
                <h3>Aprovado convênio com União para Libertadores 3</h3>

                <p>Com a aprovação, prefeitura firmará convênio com a União para viabilizar nova Copa Libertadores
                    na
                    cidade 3</p>
            </div>
        </div> -->

    </div>

    <!-- Controls -->
    <a class="left carousel-control" href="#carousel-banner-principal" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left"></span>
    </a>
    <a class="right carousel-control" href="#carousel-banner-principal" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right"></span>
    </a>
</div>
