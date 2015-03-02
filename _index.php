<?php

include_once("library/master-page.php");
include_once("library/config/database/tnoticia.php");

$oMasterPage = new MasterPage();
$oMasterPage->Init("master.php");
$oMasterPage->AddParameter("css", "home/index");
$oMasterPage->AddParameter("pagina", "home");
$oMasterPage->AddParameter("semTitulo", true);
$oMasterPage->Open("PageContent");

?>
<script language="javascript" type="text/javascript">
	$(function(){
		$.get("eventos/calendario.php", function(d){ $(".agendaEventos .calendario").html(d); });
		$.get("eventos/lista.php", function(d){ $(".agendaEventos .evento").html(d); });
	});
</script>
<div class="bemVindo">
	<h1><img src="imgs/home/bem-vindo.png" alt="Bem-Vindo" title="Bem-Vindo" /><br /><span>ao Portal da C�mara Municipal</span> <br/><span>de S�o Jos� dos Campos</span></h1>
	<p>Este portal foi criado para que a popula��o possa acompanhar os trabalhos da C�mara Municipal de S�o Jos� dos Campos. Aqui voc� assiste �s sess�es de C�mara em tempo real; tem acesso �s leis municipais, estaduais e federais; e conhece os servi�os oferecidos gratuitamente pelo CAC - Centro de Apoio ao Cidad�o "Jo�o Paulo II" entre outras informa��es.</p>
</div>
<ul class="acessoRapido">
	<li>Acesso R�pido</li>
    <li><a href="licitacoes/">Acompanhe as <strong>licita��es</strong> em andamento e conclu�das.</a></li>
	<li><a href="programa-de-visita-de-escolas/">Programe a <strong>visita de sua escola</strong> � C�mara</a></li>
	<li><a href="http://www.ceaam.net/sjc/legislacao/" target="_blank">Pesquise sobre as <strong>leis</strong> municipais, estaduais e federais.</a></li>
</ul>
<div class="sessoesPlenarias">
	<div class="imgDestaque">
    	<a href="http://www.camarasjc.sp.gov.br/assista.php" title="Ao Vivo" target="_blank">
            <span class="mask">
                <strong>Assista �s Sess�es</strong><br />
                Assista �s sess�es de C�mara em tempo real!<br />
                <b>As ter�as e quintas-feiras, a partir das 17h30.</b>
            </span>
            <img src="imgs/home/sessoes-plenarias/img.jpg" alt="" title="" />
        </a>
    </div>
    <div class="colunaDireita">
        <h2 class="zwo3Italic"><a href="sessoes-plenarias/">Sess�es Plen�rias</a></h2>
        <p>As sess�es de C�mara s�o abertas ao p�blico e ocorrem �s <strong>ter�as e quintas-feiras, a partir das 17h30.</strong></p>
        <ul>
	        <li>Pesquise Pautas e Resultados:</li>
			<li class="pautaResultado"><a href="sessoes-plenarias/sessoes-de-3-feira/">Sess�es de 3� feira:</a></li>
			<li class="pautaResultado"><a href="sessoes-plenarias/sessoes-de-5-feira/">Sess�es de 5� feira:</a></li>
        </ul>
        <ul>
        	<li>Sess�o Solene:</li>
			<li><a href="sessoes-plenarias/sessoes-solenes-e-homenagens/proximas-sessoes/">Pr�ximas Sess�es</a></li>
            <li><a href="sessoes-plenarias/sessoes-solenes-e-homenagens/sessoes-anteriores/">Sess�es Anteriores</a></li>
        </ul>
        <p class="botDuvidas"><a href="fale-conosco/"><strong>D�vidas?</strong> Clique Aqui.</a></p>
    </div>
</div>
<div class="agendaEventos">
	<h2>Agenda de Eventos</h2>
    <div class="calendario">Carregando... </div>
    <div class="evento">Carregando...</div>
    <div class="clear"></div>
</div>
<?php

$oNoticia = new tnoticia();
$oNoticia->SQLWhere = "Destaque = 1";
$oNoticia->SQLOrder = "Data DESC, Hora DESC";
$oNoticia->SQLTotal = 1;
if($oNoticia->LoadSQLAssembled())
{
	$urlNoticia = $oNoticia->GenerateURL();
	?>
	<div class="ultimasNoticias">
		<h3 class="zwo3Italic"><a href="noticias/">�ltima Not�cia</a></h3>
	    <div>
	        <a href="<?=$urlNoticia;?>" class="data"><?=$oNoticia->DateFormat("d \d\e MONTH \d\e Y", $oNoticia->Data);?></a>
			<h2><a href="<?=$urlNoticia;?>"><?=$oNoticia->Titulo;?></a></h2>
			<a href="<?=$urlNoticia;?>"><?=$oNoticia->CutText($oNoticia->Descricao, 300);?></a>
	    </div>
	    <p class="vejaMais"><a href="noticias/">Veja Mais Not�cias</a></p>
	</div>
	<?php
}

?>
<h2><a href="portal-da-transparencia/" class="portalTransparencia"><img src="imgs/home/bot-portal-transparencia.png" alt="Portal da transpar�ncia. Consulte informa��es sobre despesas e receitas extraor�ament�rias" title="Portal da transpar�ncia. Consulte informa��es sobre despesas e receitas extraor�ament�rias" /></a></h2>
<p><a href="http://www.peticoesonline.com/peticao/o-vale-pela-paz/525" target="_blank" class="ovale"><img src="imgs/home/o-vale.png" border="0" /></a></p>
<?php

$oMasterPage->Close("PageContent");
$oMasterPage->End();

?>