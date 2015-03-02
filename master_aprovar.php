<?php

include_once("library/config/database/tparametro.php");
include_once("library/config/database/tevento.php");
include("create-menu.php");
$arParam = tparametro::Load();

$oUtil = new Util();
$oUtil->ForceURL();
?>
<?php include("head-scripts.php"); ?>
<body
    <?php if ($Timeline){ ?>onload="$('#scroll').stop().scrollTo( $('#timeline_<?= ($TimelineID - 2) ?>'), 500);" <?php } ?>>

<?php
include("header.php");
include("top-menu.php");?>


<div class="container dmbs-container">
    <?php include("slider.php"); ?>
    <!-- start content container -->
    <div id="conteudo-principal" class="row dmbs-content dmbs-main">


        <?php /* <h1><a href="<?= $oUtil->WebURL; ?>"><img
                        src="imgs/master/aprovar/logo-camara-municipal-de-sao-jose-dos-campos.png"
                        alt="Portal da C�mara Municipal de S�o Jos� dos Campos"
                        title="Portal da C�mara Municipal de S�o Jos� dos Campos"/></a></h1>
            <ul class="menu <?= (($pagina == "home") ? "menuPadraoHome" : ""); ?>">
                <?php if ($pagina != "home") { ?>
                    <li><a href="<?= $oUtil->WebURL; ?>">Inicial</a></li><?php } ?>
                <li><a href="conheca-a-camara/" <?= (($pagina == "conheca-a-camara") ? 'class="sel"' : "") ?>>Conhe�a a
                        C�mara</a></li>
                <li><a href="vereadores/" <?= (($pagina == "vereadores") ? 'class="sel"' : "") ?>>Vereadores</a></li>
                <li><a href="mesa-diretora/" <?= (($pagina == "mesa-diretora") ? 'class="sel"' : "") ?>>Mesa
                        Diretora</a></li>
                <li><a href="http://www.ceaam.net/sjc/legislacao/" target="_blank">Leis Municipais</a></li>
                <li><a href="localizacao/" <?= (($pagina == "localizacao") ? 'class="sel"' : "") ?>>Localiza��o</a></li>
                <li><a href="fale-conosco/" <?= (($pagina == "fale-conosco") ? 'class="sel"' : "") ?>>Fale Conosco</a>
                </li>
            </ul>
            <div class="busca"></div>
            <p class="redesSociais">
                <a href="https://www.youtube.com/camarasjc" target="_blank"><img src="imgs/geral/botoes/bot-youtube.png"
                                                                                 alt="YouTube" title="YouTube"/></a>
                <a href="https://www.facebook.com/camarasjc" target="_blank"><img
                        src="imgs/geral/botoes/bot-facebook.png"
                        alt="Facebook" title="Facebook"/></a>
                <a href="https://twitter.com/camara_sjc" target="_blank"><img src="imgs/geral/botoes/bot-twitter.png"
                                                                              alt="Twitter" title="Twitter"/></a>
            </p>*/
        ?>


        <div class="col-md-3 hidden-xs hidden-sm dmbs-left">

            <h2 class="green">
                <div title="Assuntos" class="the-icons span3"><i class="icon-menu"></i>Assuntos</div>
            </h2>
            <?php
            create_menu(1);
            include("left-banners.php");
            ?>

        </div>


        <div class="col-md-6  ">
            <div class="conteudo">
                <?php if (!$semTitulo) { ?><h1 class="titulo"><img
                        src="imgs/<?= (($titulo) ? $titulo : $pagina); ?>/titulo.png"
                        alt="<?= (($alt) ? $alt : $PageTitle); ?>"
                        title="<?= (($alt) ? $alt : $PageTitle); ?>"/></h1><?php } ?>
                <?= $PageContent; ?>
                <br/>
            </div>


        </div>

        <div class="col-md-3 ">

            <div class="agendaEventos">
                <h2 class="dark-blue-text">
                    <div title="Code: 0xe807" class="the-icons span3">Agenda de Eventos<i
                            class="icon-angle-double-right"></i></div>
                </h2>

                <?php include('eventos/calendario2.php'); ?>
                <!-- <div class="calendario">Carregando...</div> -->

                <div class="clear"></div>
            </div>

            <div class="clearfix"></div>
            <h2 class="dark-blue-text">
                <div title="Code: 0xe807" class="the-icons span3">Câmara nas Redes Sociais<i
                        class="icon-angle-double-right"></i></div>
            </h2>
            <!-- criando conteúdo estático -->
            <div class="social-tab">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="active facebook-tab"><a href="#facebook-tab" role="tab" data-toggle="tab">Facebook</a>
                    </li>
                    <li class="twitter-tab"><a href="#twitter-tab" role="tab" data-toggle="tab">Twitter</a></li>

                </ul>
            </div>
            <div class="container-box col-md-6 social-box">


                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane active" id="facebook-tab">
                        <div class="fb-like-box center-block" data-href="https://www.facebook.com/camarasjc"
                             data-width="245"
                             data-colorscheme="light" data-show-faces="true" data-header="false" data-stream="false"
                             data-show-border="false">

                        </div>
                    </div>

                    <div class="tab-pane" id="twitter-tab">
                        <a class="twitter-timeline" href="https://twitter.com/camara_sjc"
                           data-widget-id="525698259293990912">Tweets
                            by @camara_sjc</a>
                        <script>!function (d, s, id) {
                                var js, fjs = d.getElementsByTagName(s)[0], p = /^http:/.test(d.location) ? 'http' : 'https';
                                if (!d.getElementById(id)) {
                                    js = d.createElement(s);
                                    js.id = id;
                                    js.src = p + "://platform.twitter.com/widgets.js";
                                    fjs.parentNode.insertBefore(js, fjs);
                                }
                            }(document, "script", "twitter-wjs");</script>


                    </div>

                </div>

            </div>

        </div>


        <!--<div class="col-md-3">
            sad
        </div>-->

        <div class="col-md-12">
            <h2 class="red">
                <div title="Code: 0xe807" class="the-icons span3">TV Câmara<i class="icon-angle-double-right"></i>
            </h2>

            <!--<iframe width="356" height='330' frameborder='0' scrolling="no" src="http://www.cmsjc.net/player.html" class="tv-ao-vivo"></iframe>-->

            <div class="container-box tv-camara-widget">

                <div class="row">
                    <div id="youtubevideos"></div>
                    <p class="text-right" style="margin-right: 15px;">Veja todos os vídeos em nosso canal do YouTube</p>
                    <!--<div class="col-md-7" >

                        <div class="embed-responsive embed-responsive-4by3">
                            <iframe class="embed-responsive-item" src="//www.youtube.com/embed/0E7-hL1f1xg" frameborder="0"
                                    allowfullscreen></iframe>
                        </div>
                    </div>
                    <div class="col-md-5 right-content" >
                        <h3>'Com a Palavra', o chefe da Divisão de Engenharia Civil do ITA, Cláudio Jorge Alves Pinto</h3>

                        <p> Assista a entrevista com o chefe da Divisão de Engenharia Civil do ITA, Cláudio Jorge Alves
                            Pinto.
                            Ele recorda o histórico da aviação regional no país e como o governo federal tem abordado essa
                            questão atualmente. </p>

                        <h4>Assista à outros vídeos</h4>
                            <img src="" />
                        <p><a href="#">Veja todos os programas em nosso canal do YouTube</a></p>
                    </div> -->
                </div>
            </div>
        </div>

    </div>
    <?php /*
        <div class="rodape">
        	<div>
                <ul class="menu <?=(($pagina == "home") ? "menuPadraoHome" : "");?>">
	            	<?php if($pagina != "home") { ?><li><a href="<?=$oUtil->WebURL;?>">Inicial</a></li><?php } ?>
	                <li><a href="conheca-a-camara/" <?=(($pagina == "conheca-a-camara") ? 'class="sel"' : "")?>>Conhe�a a C�mara</a></li>
	                <li><a href="vereadores/" <?=(($pagina == "vereadores") ? 'class="sel"' : "")?>>Vereadores</a></li>
	                <li><a href="mesa-diretora/" <?=(($pagina == "mesa-diretora") ? 'class="sel"' : "")?>>Mesa Diretora</a></li>
	                <li><a href="http://www.ceaam.net/sjc/legislacao/" target="_blank">Leis Municipais</a></li>
	                <li><a href="localizacao/" <?=(($pagina == "localizacao") ? 'class="sel"' : "")?>>Localiza��o</a></li>
	                <li><a href="fale-conosco/" <?=(($pagina == "fale-conosco") ? 'class="sel"' : "")?>>Fale Conosco</a></li>
	            </ul>
                <div class="brasao">
                	<p class="erro">Encontrou algum erro? <a href="comunicar-erros/">Clique aqui e nos avise!</a></p>
                	<address><strong>Endere�o:</strong> Rua Desembargador Francisco Murilo Pinto, 33 - Vila Sta. Luzia - <strong>CEP:</strong> 12209-535 | <strong>Tel:</strong> +55 (12) 3925-6566</address>
					� <?=date("Y");?> C�mara Municipal de S�o Jos� dos Campos - Todos os direitos reservados | <a href="mapa-do-site/">Mapa do Site</a> | <a href="http://www.clicknow.com.br/" target="_blank" title="Desenvolvimento Web: ClickNow�" class="clicknow">Desenvolvimento Web: <strong>ClickNow�</strong></a>
                </div>
            </div>
        </div>
        */
    ?>


</div>

</div>

<?php
include("footer.php");
?>


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">CMSJC</h4>
            </div>
            <div class="modal-body">
                <img src="http://camarasjc2.hospedagemdesites.ws/download/CMSJC_Banners_Internet_850x1400px.jpg" alt="" class="img-responsive visible-xs"/>
                <img src="http://camarasjc2.hospedagemdesites.ws/download/CMSJC_Banners_Internet_800x800px.jpg" alt="" class="img-responsive visible-sm visible-md"/>
                <img src="http://camarasjc2.hospedagemdesites.ws/download/CMSJC_Banners_Internet_1045x760px.jpg" alt="" class="img-responsive visible-lg"/>
            </div>
            <!--<div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Fechar</button>

            </div> -->
        </div>
    </div>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>

<script language="javascript" type="text/javascript" src="js/yt-jquery.js"></script>


<!-- YOUTUBE -->
<script type="text/javascript">
    $(document).ready(function () {
        $('#youtubevideos').youTubeChannel({
            userName: 'camarasjc',
            showPlayer: true,
            playerWidth: "600",
            playerHeight: "400",
            channel: "uploads",
            hideAuthor: true,
            numberToDisplay: 3,
            linksInNewWindow: false
        });
    });

</script>

<!--
<script type="text/javascript">
    (function ($) {
        var $window = $(window),
            $html = $('#menu-bar');

        $window.resize(function resize() {
            if ($window.width() < 768) {
                return $html.removeClass('nav-stacked');
            }
            $html.addClass('nav-stacked');
        }).trigger('resize');
    })(jQuery);
</script> -->
<script type="text/javascript">
    $(document).ready(function(){
        $('#myModal').modal('show');
    });
</script>
</body>
</html>