<?php

include_once("library/config/database/tparametro.php");

$arParam = tparametro::Load();

$oUtil = new Util();
$oUtil->ForceURL();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>TESTE | <?php if($PageTitle) { ?><?=$PageTitle;?> | <?php } ?><?=$oUtil->WebTitle;?></title>
    <base href="<?=$oUtil->WebURL;?>" />
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <meta http-equiv="Content-Language" content="pt-br" />
	<meta name="author" content="ClickNow� � Planejamento, cria��o e desenvolvimento para canais digitais" />
	<meta name="keywords" content="C�mara Municipal, S�o Jos� dos Campos, sjc, vereadores, leis, mesa diretora, sess�es plen�rias, licita��es, audi�ncias p�blicas, cac, portal da transpar�ncia, gabinetes, comiss�es, servi�os" />
	<meta name="description" content="No site da C�mara Municipal de S�o Jos� dos Campos � poss�vel assistir �s sess�es plen�rias, al�m de ter acesso �s leis e aos servi�os prestados." />
	<meta property="og:title" content="<?=(($meta_titulo) ? $meta_titulo : $oUtil->WebTitle);?>" />
    <meta property="og:url" content="<?=(($meta_url) ? $meta_url : $oUtil->WebURL);?>" />
	<meta property="og:image" content="<?=(($meta_image) ? $meta_image : $oUtil->WebURL . "imgs/logo.jpg");?>" />
	<?php if($meta_video) { ?><meta property="og:video" content="<?=$meta_video;?>" /><?php } ?>
    <meta property="og:site_name" content="<?=$oUtil->WebTitle;?>" />
    <meta property="og:description" content="<?=(($meta_description) ? $meta_description : "");?>" />
	<meta name="robots" content="index,follow" />
    <link rel="stylesheet" type="text/css" href="css/geral.css" />
	<link rel="stylesheet" type="text/css" href="css/master/index.css" />
    <?php if(is_file(dirname(__FILE__) . "/" . $secao . "/css/" . $css . ".css")) { ?><link rel="stylesheet" type="text/css" href="css/<?=$css?>.css" /><?php } ?>
    <link rel="stylesheet" type="text/css" href="library/plugins/jquery/lightbox/css/lightbox.css" />
    <link rel="shortcut icon" type="image/png" href="favicon.ico" />
    <script language="javascript" type="text/javascript" src="library/plugins/jquery/geral.js"></script>
    <script language="javascript" type="text/javascript" src="library/plugins/jquery/jquery.js"></script>    
    <script language="javascript" type="text/javascript" src="library/plugins/jquery/jquery.metadata.js"></script>
    <script language="javascript" type="text/javascript" src="library/plugins/jquery/jquery.maskinput.js"></script>
	<script language="javascript" type="text/javascript" src="library/plugins/jquery/jquery.watermarkinput.js"></script>
    <script language="javascript" type="text/javascript" src="library/plugins/jquery/jquery.validate.js"></script>
    <script language="javascript" type="text/javascript" src="library/plugins/jquery/jquery.scrollTo.js"></script>
    <script language="javascript" type="text/javascript" src="library/plugins/jquery/jquery.bxslider.js"></script>
    <script language="javascript" type="text/javascript" src="library/plugins/jquery/jquery.popup.js"></script>
    <script language="javascript" type="text/javascript" src="library/plugins/jquery/jquery.function.js"></script>
    <script language="javascript" type="text/javascript" src="library/plugins/jquery/swfobject.js"></script>
    <script language="javascript" type="text/javascript" src="library/plugins/jquery/lightbox/lightbox.js"></script>
    <script language="javascript" type="text/javascript" src="http://www.clicknow.com.br/crossbrowser/fonte.js"></script>
    <script language="javascript" type="text/javascript">
    	$(function(){
    		init();
			$("a[rel*=lightbox]").lightBox();
    		<?php if($msg) { ?>alert("<?=$msg;?>");<?php } ?>
    	});
	</script>   
	<script language="javascript" type="text/javascript">
		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', 'UA-24531703-23']);
		_gaq.push(['_trackPageview']);

		(function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		})();
	</script> 
</head>
<body <?php if($Timeline){ ?>onload="$('#scroll').stop().scrollTo( $('#timeline_<?=($TimelineID - 2)?>'), 500);" <?php } ?>>
	<div class="tudo">
    	<div class="geral">
        	<h1><a href="<?=$oUtil->WebURL;?>"><img src="imgs/master/logo-camara-municipal-de-sao-jose-dos-campos.png" alt="Portal da C�mara Municipal de S�o Jos� dos Campos" title="Portal da C�mara Municipal de S�o Jos� dos Campos" /></a></h1>
            <ul class="menu <?=(($pagina == "home") ? "menuPadraoHome" : "");?>">
            	<?php if($pagina != "home") { ?><li><a href="<?=$oUtil->WebURL;?>">Inicial</a></li><?php } ?>
                <li><a href="conheca-a-camara/" <?=(($pagina == "conheca-a-camara") ? 'class="sel"' : "")?>>Conhe�a a C�mara</a></li>
                <li><a href="vereadores/" <?=(($pagina == "vereadores") ? 'class="sel"' : "")?>>Vereadores</a></li>
                <li><a href="mesa-diretora/" <?=(($pagina == "mesa-diretora") ? 'class="sel"' : "")?>>Mesa Diretora</a></li>
                <li><a href="http://www.ceaam.net/sjc/legislacao/" target="_blank">Leis Municipais</a></li>
                <li><a href="localizacao/" <?=(($pagina == "localizacao") ? 'class="sel"' : "")?>>Localiza��o</a></li>
                <li><a href="fale-conosco/" <?=(($pagina == "fale-conosco") ? 'class="sel"' : "")?>>Fale Conosco</a></li>
            </ul>
            <div class="busca"></div>
			<p class="redesSociais">
                <a href="https://www.youtube.com/camarasjc" target="_blank"><img src="imgs/geral/botoes/bot-youtube.png" alt="YouTube" title="YouTube" /></a>
                <a href="https://www.facebook.com/camarasjc" target="_blank"><img src="imgs/geral/botoes/bot-facebook.png" alt="Facebook" title="Facebook" /></a>
                <a href="https://twitter.com/camara_sjc" target="_blank"><img src="imgs/geral/botoes/bot-twitter.png" alt="Twitter" title="Twitter" /></a>
            </p>
            <div class="colunaEsquerda">
                <ul class="menuLateral">
                    <li><a href="sessoes-plenarias/" <?=(($pagina == "sessoes-plenarias") ? 'class="sel"' : "")?>>Sess�es Plen�rias</a></li>
                    <li><a href="licitacoes/" <?=(($pagina == "licitacoes") ? 'class="sel"' : "")?>>Licita��es</a></li>
                    <li><a href="comissoes/" <?=(($pagina == "comissoes") ? 'class="sel"' : "")?>>Comiss�es</a></li>
                    <li><a href="<?=substr($arParam["lei-organica-do-municipio"], 1);?>" target="_blank">Lei Org�nica do Munic�pio</a></li>
                    <li><a href="<?=substr($arParam["regimento-interno"], 1);?>" target="_blank">Regimento Interno</a></li>
                    <li><a href="eventos/" <?=(($pagina == "eventos") ? 'class="sel"' : "")?>>Eventos</a></li>
                    <li><a href="audiencias-publicas/" <?=(($pagina == "audiencias-publicas") ? 'class="sel"' : "")?>>Audi�ncias P�blicas</a></li>
                    <li><a href="noticias/" <?=(($pagina == "noticias") ? 'class="sel"' : "")?>>Not�cias</a></li>
                    <li><a href="bancadas-e-liderancas/" <?=(($pagina == "bancadas-e-liderancas") ? 'class="sel"' : "")?>>Bancadas e Lideran�as</a></li>
                    <li><a href="orcamento/" <?=(($pagina == "orcamento") ? 'class="sel"' : "")?>>Or�amento</a></li>
                    <li><a href="cronograma-de-acoes/" <?=(($pagina == "cronograma-de-acoes") ? 'class="sel"' : "")?>>Cronograma Portaria STN 828/2011</a></li>
                    <li><a href="portal-da-transparencia/" <?=(($pagina == "portal-da-transparencia") ? 'class="sel"' : "")?>>Portal da Transpar�ncia</a></li>
                    <li><a href="http://www.sjc.sp.gov.br/mapa_google_itinerario.aspx" target="_blank">Hor�rios e Itiner�rios de �nibus</a></li>
                    <li><a href="tv-camara/" <?=(($pagina == "tv-camara") ? 'class="sel"' : "")?>>TV C�mara</a></li>
                    <li><a href="http://www.ceaam.net/sjc/legislacao/" target="_blank">Pesquise Leis</a></li>
                </ul>
                <ul class="menuLateral menuAmarelo">
                    <li><a href="cac/" <?=(($pagina == "cac") ? 'class="sel"' : "")?>>CAC</a></li>
                    <li><a href="memorial-legislativo/" <?=(($pagina == "memorial-legislativo") ? 'class="sel"' : "")?>>Memorial Legislativo</a></li>
                    <li><a href="programa-de-visita-de-escolas/" <?=(($pagina == "programa-de-visita-de-escolas") ? 'class="sel"' : "")?>>Programa de Visita de Escolas</a></li>
                    <li><a href="http://www.camarasjc.sp.gov.br/promemoria/" target="_blank">Pr�-Mem�ria</a></li>
                    <li><a href="http://200.174.132.60:8080/cmsjc/websis/siapegov/recursos_humanos/fol/veracidade_holerith.php" target="_blank">Autenticidade do Holerith</a></li>
                    <?php /*<li><a href="processo-de-exploracao-mineraria/" <?=(($pagina == "processo-de-exploracao-mineraria") ? 'class="sel"' : "")?>>Processo de Explora��o Miner�ria</a></li>*/ ?>
                    <li><a href="links-institucionais/" <?=(($pagina == "links-institucionais") ? 'class="sel"' : "")?>>Links Institucionais</a></li>
                    <li><a href="downloads/" <?=(($pagina == "downloads") ? 'class="sel"' : "")?>>Downloads</a></li>
                </ul>
                <ul class="banner">
                	<!--<li><a href="fale-conosco/" class="botH193"><img src="imgs/master/banner-lateral/bot-alo-camara.jpg" alt="Al� C�mara! Liga��o Gratuita 0800-7702515" title="Al� C�mara! Liga��o Gratuita 0800-7702515" /></a></li>-->
                    <li><a href="cac/" class="botH110"><img src="imgs/master/banner-lateral/bot-cac.jpg" alt="CAC. Centro de Apoio ao Cidad�o." title="CAC. Centro de Apoio ao Cidad�o." /></a></li>
                    <li><a href="telefones-uteis/" class="botH110"><img src="imgs/master/banner-lateral/bot-telefones.jpg" alt="Telefones �teis" title="Telefones �teis" /></a></li>
                    <li><a href="http://www.camarasjc.sp.gov.br/promemoria/" target="_blank" class="botH110"><img src="imgs/master/banner-lateral/bot-promemoria.jpg" alt="Pr�-Mem�ria S�o Jos� dos Campos" title="Pr�-Mem�ria S�o Jos� dos Campos" /></a></li>
                    <li><a href="http://www.maesdase.org.br/" target="_blank" class="botH110"><img src="imgs/master/banner-lateral/bot-pessoas-desaparecidas.jpg" alt="Pessoas desaparecidas. 0800-7702515" title="Pessoas desaparecidas. 0800-7702515" /></a></li>
                    <li><a href="http://200.174.132.60:8080/cmsjc/websis/siapegov/recursos_humanos/grh/grh_rh_online.php" target="_blank" class="botH110"><img src="imgs/master/banner-lateral/bot-portal-do-servidor.jpg" alt="Portal do Servidor" title="Portal do Servidor" /></a></li>
                    <?php /*<li><a href="processo-de-exploracao-mineraria/" class="botH110"><img src="imgs/master/banner-lateral/bot-exploracao-mineraria.jpg" alt="Processo de Explora��o Miner�ria. S�o Jos� dos Campos" title="Processo de Explora��o Miner�ria. S�o Jos� dos Campos" /></a></li>*/ ?>
                </ul>
            </div>
            <div class="conteudo">
            	<?php if(!$semTitulo) { ?><h1 class="titulo"><img src="imgs/<?=(($titulo) ? $titulo : $pagina);?>/titulo.png" alt="<?=(($alt) ? $alt : $PageTitle);?>" title="<?=(($alt) ? $alt : $PageTitle);?>" /></h1><?php } ?>
				<?=$PageContent;?>
				<br />
            </div>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
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
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>

</body>
</html>