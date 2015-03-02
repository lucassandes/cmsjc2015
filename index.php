<?php

include_once("library/master-page.php");
include_once("library/config/database/tnoticia.php");

include_once("library/config/database/tevento.php");

$oMasterPage = new MasterPage();
$oMasterPage->Init("master_aprovar.php");
$oMasterPage->AddParameter("css", "home/index");
$oMasterPage->AddParameter("pagina", "home");
$oMasterPage->AddParameter("semTitulo", true);
$oMasterPage->Open("PageContent");

?>
    <script language="javascript" type="text/javascript">
        $(function () {
            $(".bannerHome .slider").bxSlider({
                controls: false,
                pager: true,
                pagerSelector: ".bannerHome .nav-slider>div",
                auto: true,
                pause: 10000
            });

            /* $.get("eventos/calendario.php", function (d) {
             $(".agendaEventos .calendario").html(d);
             });

             $.get("eventos/lista.php", function (d) {
             $(".agendaEventos .evento").html(d);
             });*/

        });


    </script>
<?php
/*
$arNoticia = array();

$oNoticiaDestaque = new tnoticia();
$oNoticiaDestaque->SQLWhere = "Destaque = 1 AND (ImagemDestaque != '' AND ImagemDestaque IS NOT NULL)";
$oNoticiaDestaque->SQLOrder = "Data DESC, Hora DESC";
$oNoticiaDestaque->SQLTotal = 5;
if ($oNoticiaDestaque->LoadSQLAssembled()) {
    ?>


    <?php /*
    <div class="bannerHome">
		<div class="nav-slider">
			<div></div>
		</div>
		<ul class="slider">
			<?php
			for ( $c = 0; $c < $oNoticiaDestaque->NumRows; $c ++ ) {
				array_push( $arNoticia, $oNoticiaDestaque->ID );
				?>
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
				<?php
				$oNoticiaDestaque->MoveNext();
			}
			?>
		</ul>
	</div>

    ?>
<?php
}*/
// <div class="col-xs-6 no-padding-left fundo-azul text-center">
//<div class="col-xs-6 no-padding-right fundo-azul text-center">
?>
    <div class="destaques row">
        <div class="col-xs-6  ">
            <a href="http://ged.camarasjc.sp.gov.br/municipe/" target="_blank"><img
                    src="imgs/home/banners/banner_ged.jpg" width="293" alt="Banner Ged"
                    class="img-responsive center-block"/></a>
        </div>

        <div class="col-xs-6">
            <a href="http://www.ceaam.net/sjc/legislacao/" target="_blank"><img
                    src="imgs/home/banners/banner_pesqleis.jpg" alt="" width="293" class="img-responsive center-block"/></a>
        </div>
    </div>


    <div class="clear"></div>



    <div>
    <h2 class="blue">
        <div title="Code: 0xe807" class="the-icons span3"> Últimas Notícias <i class="icon-angle-double-right"></i>
        </div>
    </h2>
    <!-- criando conteúdo estático  <div class="container-box col-md-12"> -->

    <div class="container-box ">
        <?php
        /*********************************************
         *  CONTEÚDO DINAMICO. ÚLTIMAS NOTÍCIAS.
         *********************************************/

        $oNoticia = new tnoticia();
        //$oNoticia->SQLWhere = "(ID != '" . implode("' AND ID != '", $arNoticia) . "')";
        $oNoticia->SQLOrder = "Data DESC, Hora DESC";
        $oNoticia->SQLTotal = 6;
        if ($oNoticia->LoadSQLAssembled()) {
            $i = 0;
            $ultima = false;
            for ($c = 0; $c < $oNoticia->NumRows; $c++) {
                $data = $oNoticia->Titulo;
                echo('
                                <div class="noticia col-md-6">'); ?>
                <span class="data"><?= $oNoticia->DateFormat('d \d\e MONTH \d\e Y', $oNoticia->Data); ?></span>

                <h3><a href="<?= $oNoticia->GenerateURL(); ?>"><?php echo(utf8_encode($oNoticia->Titulo)); ?></a>
                </h3>

                <p><a href="<?= $oNoticia->GenerateURL(); ?>"><?php echo(utf8_encode($oNoticia->Subtitulo)); ?></a>
                </p>
                <?php echo('</div>');
                $oNoticia->MoveNext();
                $i++;
                if ($i == 2) {
                    echo('<div class="clear"></div>');
                    $i = 0;
                }
            }

        }
        ?>


    </div>


    <div class="clearfix"></div>
    <div class="destaques">
        <h2 class="red">
            <div title="Code: 0xe807" class="the-icons span3">Destaques <i class="icon-angle-double-right"></i>
        </h2>
        <div class="col-xs-6 " style="margin-left:-15px;  padding-right: 0;">
            <a href="noticias/3255/divulgacao+dos+editais+do+concurso+publico+da+camara">
                <img
                    src="imgs/home/banners/banner_concurso.jpg"
                    alt="Banner Concurso" class="img-responsive "
                    title="Banner Concurso"/>
            </a>

        </div>
        <div class="col-xs-6 " style="margin-left:15px; padding-right: 0; ">
            <a href="portal-da-transparencia/">
                <img
                    src="imgs/home/banners/banner_transparencia.jpg"
                    alt="Banner Transparência" class="img-responsive "
                    title="Banner Transparência"/>
            </a>
        </div>
        <?php
        /*
        A PARTIR DAQUI
        $oNoticiaDestaque2 = new tnoticia();
        $oNoticiaDestaque2->SQLWhere = "Destaque2 = 1 AND (ImagemDestaque2 != '' AND ImagemDestaque2 IS NOT NULL)";
        $oNoticiaDestaque2->SQLOrder = "Data DESC, Hora DESC";
        $oNoticiaDestaque2->SQLTotal = 3;
        if ($oNoticiaDestaque2->LoadSQLAssembled()) {
        ?>

        <?php
        for ($c = 0;
        $c < $oNoticiaDestaque2->NumRows;
        $c++) {
        array_push($arNoticia, $oNoticiaDestaque2->ID);

        if ($c == 0) {
            echo(' <div class="col-xs-6 " style="margin-left:-15px;  padding-right: 0;">');
        } else {
            echo(' <div class="col-xs-6 " style="margin-left:15px; padding-right: 0; ">');
        }
        ?>



        <a href="<?= $oNoticiaDestaque2->GenerateURL(); ?>">
            <img
                src="<?= $oNoticiaDestaque2->Thumbnail($oNoticiaDestaque2->ImagemDestaque2, 260, 130, "", true, true); ?>"
                alt="<?= $oNoticiaDestaque2->Titulo; ?>" class="img-responsive "
                title="<?= $oNoticiaDestaque2->Titulo; ?>"/>
        </a>
    </div>
    <?php
    $oNoticiaDestaque2->MoveNext();
    }
    ?>

    <?php
    }
    ATÉ AQUI
    ---------------------------------------------------------------*/
        /*
        $oNoticia = new tnoticia();
        //$oNoticia->SQLWhere = "(ID != '" . implode("' AND ID != '", $arNoticia) . "')";
        $oNoticia->SQLOrder = "Data DESC, Hora DESC";
        $oNoticia->SQLTotal = 8;
        if ($oNoticia->LoadSQLAssembled()) {
            ?>
            <div class="noticias">
                <ul>
                    <?php
                    $ultima = false;
                    for ($c = 0; $c < $oNoticia->NumRows; $c++) {
                        ?>
                        <li>
                            <?php
                            if ($ultima != $oNoticia->Data) {
                                ?>
                                <span><?= $oNoticia->DateFormat("d \d\e MONTH \d\e Y", $oNoticia->Data); ?></span>
                                <?php
                                $ultima = $oNoticia->Data;
                            }
                            ?>
                            <h3><a href="<?= $oNoticia->GenerateURL(); ?>"><?= $oNoticia->Titulo; ?></a></h3>
                        </li>
                        <?php
                        $oNoticia->MoveNext();
                    }
                    ?>
                </ul>
            </div>
        <?php
        }
        */
        ?>
    </div>
    <!-- fim destaques -->


    <div class="clearfix"></div>
    <!--<h2 class="blue">TV Câmara <span> >> </span></h2>
     criando conteúdo estático -->
    <!--<div class="container-box col-md-12">


    </div>-->


    <!-- fim conteudo estático -->

    <?php /*
    <div class="bannersInstitucionais">
		<a href="portal-da-transparencia/" class="full"><img src="imgs/home/banners/banner-portal-transparencia.jpg"
		                                                     alt="Portal da Transpar�ncia. Consulte informa��es sobre despesas e receitas extraor�ament�rias"
		                                                     title="Portal da Transpar�ncia. Consulte informa��es sobre despesas e receitas extraor�ament�rias"/></a>
		<a href="orcamento/"><img src="imgs/home/banners/banner-orcamentos.jpg" alt="Or�amento 2013"
		                          title="Or�amento 2013"/></a>
		<a href="http://www.sjc.sp.gov.br/mapa_google_itinerario.aspx" target="_blank"><img
				src="imgs/home/banners/banner-horario-onibus.jpg" alt="Hor�rio e itiner�rios de �nibus"
				title="Hor�rio e itiner�rios de �nibus"/></a>

    <!--<a href="fale-conosco/"><img src="imgs/home/banners/banner-alo-camara.jpg" alt="Al� C�mara! Liga��o gratuita 0800-7702515" title="Al� C�mara! Liga��o gratuita 0800-7702515" /></a>
    <a href="cac/"><img src="imgs/home/banners/banner-cac.jpg" alt="CAC. Centro de Apoio ao Cidad�o" title="CAC. Centro de Apoio ao Cidad�o" /></a> -->

		<div class="clear"></div>
	</div>

	<div class="acessoRapido">
		<div class="sessoes">
			<h2 class="zwo3Italic"><a href="sessoes-plenarias/">Sess�es Plen�rias</a></h2>

			<p>As sess�es de C�mara s�o abertas ao p�blico e ocorrem �s <strong>ter�as e quintas-feiras, a partir das
					17h30.</strong></p>
			<ul>
				<li>Pesquise Pautas e Resultados:</li>
				<li class="pautaResultado"><a href="sessoes-plenarias/sessoes-de-3-feira/">Sess�es de 3� feira:</a></li>
				<li class="pautaResultado"><a href="sessoes-plenarias/sessoes-de-5-feira/">Sess�es de 5� feira:</a></li>
			</ul>
			<ul>
				<li>Sess�o Solene:</li>
				<li><a href="sessoes-plenarias/sessoes-solenes-e-homenagens/proximas-sessoes/">Pr�ximas Sess�es</a></li>
				<li><a href="sessoes-plenarias/sessoes-solenes-e-homenagens/sessoes-anteriores/">Sess�es Anteriores</a>
				</li>
			</ul>
			<p class="botDuvidas"><a href="fale-conosco/"><strong>D�vidas?</strong> Clique Aqui.</a></p>
			<?php /*
        Acesso R�pido
        <ul>
            <li><a href="http://www.sjc.sp.gov.br/" target="_blank">Prefeitura Municipal de S�o Jos� dos Campos</a></li>
            <li><a href="http://www.fccr.org.br/" target="_blank">Funda��o Cultural Cassiano Ricardo</a></li>
            <li><a href="http://www.fundhas.org.br/" target="_blank">Fundhas</a></li>
            <li><a href="http://www.urbam.com.br/" target="_blank">Urbam</a></li>
        </ul>
        */
    ?>
    </div>
    <!--<a href="http://www.camarasjc.sp.gov.br/assista.php" target="_blank" class="aoVivo">
    	<span>
            <strong>Acompanhe a programa��o da TV C�mara</strong>
        	Assista �s sess�es de C�mara em tempo real!
			<b>As ter�as e quintas-feiras, a partir das 17h30.</b>
        </span>
    </a>
-->
    <div class="clear"></div>

    <!-- <div class="leisTV">
         <div class="leis">
             <a href="http://www.ceaam.net/sjc/legislacao/" target="_blank">Pesquise <strong>Leis</strong></a>
             <a href="pesquise-projetos-de-leis/">Pesquise <strong>Projetos de Leis</strong></a>
         </div>
         <div class="tv">
             <a href="tv-camara/"><img src="imgs/home/bot-assista-tv-camara.png" alt="TV C�mara" title="TV C�mara"/></a>
         </div>
     </div> -->



    <!--<div class="agendaEventos">
        <h2>Agenda de Eventos</h2>

        <?php //include ('eventos/calendario2.php'); ?>
       <!-- <div class="calendario">Carregando...</div>

        <div class="clear"></div>
    </div> -->

<?php /*
    <div class="redesSociaisRodape">
		<div class="twitter">
			<h3><a href="http://www.twitter.com/camara_sjc" target="_blank"><img src="imgs/home/tweets.png" alt="Tweets"
			                                                                     title="Tweets"/> @camara_sjc</a></h3>

			<div class="area">
				<ul>
					<li>Carregando...</li>
				</ul>
			</div>
			<a href="http://www.twitter.com/camara_sjc" target="_blank"><img src="imgs/home/follow-twitter.png"
			                                                                 alt="Follow @camara_sjc"
			                                                                 title="Follow @camara_sjc"/></a>
		</div>
		<div class="fb-like-box" data-href="https://www.facebook.com/camarasjc" data-width="370" data-height="570"
		     data-show-faces="true" data-stream="true" data-header="false"></div>
		<div class="clear"></div>
	</div>
	<div id="fb-root"></div>
    */
?>
<?php

$oMasterPage->Close("PageContent");
$oMasterPage->End();

?>