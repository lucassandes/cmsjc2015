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
	<h1><img src="imgs/home/bem-vindo.png" alt="Bem-Vindo" title="Bem-Vindo" /><br /><span>ao Portal da Câmara Municipal</span> <br/><span>de São José dos Campos</span></h1>
	<p>Este portal foi criado para que a população possa acompanhar os trabalhos da Câmara Municipal de São José dos Campos. Aqui você assiste às sessões de Câmara em tempo real; tem acesso às leis municipais, estaduais e federais; e conhece os serviços oferecidos gratuitamente pelo CAC - Centro de Apoio ao Cidadão "João Paulo II" entre outras informações.</p>
</div>
<ul class="acessoRapido">
	<li>Acesso Rápido</li>
    <li><a href="licitacoes/">Acompanhe as <strong>licitações</strong> em andamento e concluídas.</a></li>
	<li><a href="programa-de-visita-de-escolas/">Programe a <strong>visita de sua escola</strong> à Câmara</a></li>
	<li><a href="http://www.ceaam.net/sjc/legislacao/" target="_blank">Pesquise sobre as <strong>leis</strong> municipais, estaduais e federais.</a></li>
</ul>
<div class="sessoesPlenarias">
	<div class="imgDestaque">
    	<a href="http://www.camarasjc.sp.gov.br/assista.php" title="Ao Vivo" target="_blank">
            <span class="mask">
                <strong>Assista às Sessões</strong><br />
                Assista às sessões de Câmara em tempo real!<br />
                <b>As terças e quintas-feiras, a partir das 17h30.</b>
            </span>
            <img src="imgs/home/sessoes-plenarias/img.jpg" alt="" title="" />
        </a>
    </div>
    <div class="colunaDireita">
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
		<h3 class="zwo3Italic"><a href="noticias/">Última Notícia</a></h3>
	    <div>
	        <a href="<?=$urlNoticia;?>" class="data"><?=$oNoticia->DateFormat("d \d\e MONTH \d\e Y", $oNoticia->Data);?></a>
			<h2><a href="<?=$urlNoticia;?>"><?=$oNoticia->Titulo;?></a></h2>
			<a href="<?=$urlNoticia;?>"><?=$oNoticia->CutText($oNoticia->Descricao, 300);?></a>
	    </div>
	    <p class="vejaMais"><a href="noticias/">Veja Mais Notícias</a></p>
	</div>
	<?php
}

?>
<h2><a href="portal-da-transparencia/" class="portalTransparencia"><img src="imgs/home/bot-portal-transparencia.png" alt="Portal da transparência. Consulte informações sobre despesas e receitas extraorçamentárias" title="Portal da transparência. Consulte informações sobre despesas e receitas extraorçamentárias" /></a></h2>
<p><a href="http://www.peticoesonline.com/peticao/o-vale-pela-paz/525" target="_blank" class="ovale"><img src="imgs/home/o-vale.png" border="0" /></a></p>
<?php

$oMasterPage->Close("PageContent");
$oMasterPage->End();

?>