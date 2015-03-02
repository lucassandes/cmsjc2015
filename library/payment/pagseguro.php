<?php

include_once(dirname(dirname(__FILE__)) . "/config/database/tpagseguro.php");

/**
 * Classe utilizada para pagseguro
 * 
 * @author ClickNow <suporte@clicknow.com.br>
 * @copyright Copyright (c), ClickNow
 * @access public
 */
class PagSeguro extends tpagseguro
{
	const PAGSEGURO_NPI = "https://pagseguro.uol.com.br/pagseguro-ws/checkout/NPI.jhtml";
	
	protected $Valor = null;
	
	/**
     * Construtor da classe
     * 
     * @access public
     * @return void
     */
	public function PagSeguro()
	{
		parent::tpagseguro();
		$this->LoadSQLAssembled();
	}
	
	/**
	 * Verifica notificação
	 * 
	 * @access public
	 * @return void
	 */
	public function VerifyNotification()
	{
		//verifica token
		if(!$this->Token)
		{
			throw new Exception("Token inválido.");
		}
		
		//post data
		$data = "Comando=validar&Token=" . $this->Token;
		foreach($_POST as $key => $value)
		{
			$data .= "&" . $key . "=" . ((!get_magic_quotes_gpc()) ? addslashes($value) : $value);
		}
		
		//verfica extensão CURL
		if(!function_exists("curl_init"))
		{
			throw new Exception("Desculpe, a extensão CURL é necessária.");
		}
		
		//envia dados pela função CURL
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, self::PAGSEGURO_NPI);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_TIMEOUT, 20);
		$response = trim(curl_exec($ch));
		curl_close($ch);
		
		//verifica retorno
        if(strtoupper($response) != "VERIFICADO")
        {
        	throw new Exception("Notificação inválida.");
        }
	}
	
	/**
	 * Verifica se o parcelamento sem acréscimo
	 * 
	 * @access private
	 * @return bool
	 */
	private function isSemAcrescimo()
	{
		$arDataInicio = explode("-", $this->DataInicio);
		$arDataTermino = explode("-", $this->DataTermino);
		
		return
		(
			($this->Ativo)
			&& ($this->ParcelamentoSemAcrescimo)
			&& (mktime(0, 0, 0, $arDataInicio[1], $arDataInicio[2], $arDataInicio[0]) <= mktime())
			&& (mktime(0, 0, 0, $arDataInicio[1], $arDataInicio[2], $arDataInicio[0]) < mktime(0, 0, 0, $arDataTermino[1], $arDataTermino[2], $arDataTermino[0]))
			&& ($this->Valor > $this->ValorMinimo || $this->ValorMinimo < 1)
			&& ($this->Valor < $this->ValorMaximo || $this->ValorMaximo < 1)
		);
	}
	
	/**
	 * Verifica se o parcelamento com acréscimo
	 * 
	 * @access private
	 * @return bool
	 */
	private function isComAcrescimo()
	{
		return ($this->Ativo && $this->ParcelamentoComAcrescimo);
	}
	
	/**
	 * Define valor e se necessário multiplica pelo fator
	 * 
	 * @access public
	 * @param decimal $Valor
	 * @return void
	 */
	public function setValor($Valor)
	{
		$this->Valor = $Valor;
		if($this->isSemAcrescimo() && $this->FatorMultiplicador)
		{
			$fator = $this->FatorMultiplicadorLista[$this->QuantidadeParcela - 1];
			$this->Valor = ($Valor * $fator);
		}
	}
	
	/**
	 * Retorna o valor
	 * 
	 * @access public
	 * @return decimal
	 */
	public function getValor()
	{
		return $this->Valor;
	}
	
	/**
	 * Retorna a maior parcela sem juros
	 * 
	 * @access public
	 * @return int
	 */
	public function getMaiorParcelaSemJuros()
	{
		if($this->isSemAcrescimo())
		{
			$ar = array_reverse($this->getParcelamentoSemAcrescimo());
			foreach($ar as $oPagSeguroParcela)
			{
				if(!$oPagSeguroParcela->Juros)
				{
					return $oPagSeguroParcela->Vezes;
				}
			}
		}
		return 0;
	}
	
	/**
	 * Formata o texto sem juros
	 * 
	 * @access public
	 * @param string $Texto (Default: 'em até <strong>%1$dx de R$ %2$s</strong> sem juros no cartão')
	 * @return string
	 */
	public function getTextoSemJuros($Texto = 'em até <strong>%1$dx de R$ %2$s</strong> sem juros no cartão')
	{
		$MaiorParcela = $this->getMaiorParcelaSemJuros();
		if($MaiorParcela)
		{
			return sprintf($Texto, $MaiorParcela, $this->DecimalShow(($this->Valor / $MaiorParcela)));
		}
		else
		{
			return "";
		}
	}
	
	/**
	 * Retorna parcelamento
	 * 
	 * @access public
	 * @return array (Parcela)
	 */
	public function getParcelamento()
	{
		if(!$this->ExibirParcelamento)
		{
			return array();
		}
		
		if($this->isSemAcrescimo())
		{
            return $this->getParcelamentoSemAcrescimo();
		}
		
		else if($this->isComAcrescimo())
		{
            return $this->getParcelamentoComAcrescimo();
        }
	}
	
	/**
	 * Parcelamento sem acréscimo
	 * 
	 * @access private
	 * @return void
	 */
	private function getParcelamentoSemAcrescimo()
	{
		$ar = array();
		for($i = 1; $i <= 12; $i++)
        {
        	$total = (($this->QuantidadeParcela < $i) ? ($this->FatorMultiplicadorLista[$i - $this->QuantidadeParcela - 1] * $this->Valor) : $this->Valor);
        	$valor = ($total / $i);
        	$juros = ($this->QuantidadeParcela < $i);
        	$vezes = $i;
        	
        	$oPagSeguroParcela = new PagSeguroParcela();
        	$oPagSeguroParcela->Vezes = $vezes;
        	$oPagSeguroParcela->Juros = $juros;
        	$oPagSeguroParcela->Valor = $valor;
        	$oPagSeguroParcela->Total = $total;
        	
        	if($oPagSeguroParcela->Valor > $this->ParcelaMinima)
        	{
        		array_push($ar, $oPagSeguroParcela);
        	}
        }
        return $ar;
	}
	
	/**
	 * Parcelamento com acréscimo
	 * 
	 * @access private
	 * @return void
	 */
	private function getParcelamentoComAcrescimo()
	{
		$ar = array();
		$taxa = ($this->Taxa / 100);
        for($i = 1; $i <= 12; $i++)
        {
        	$parcela = (($taxa / (1 - pow((1 + $taxa), ($i * -1)))) * $this->Valor);
        	$total = (($i > 1) ? ($parcela * $i) : $this->Valor);
        	$valor = (($i > 1) ? $parcela : $this->Valor);
        	$juros = ($i > 1);
        	$vezes = $i;
        	
        	$oPagSeguroParcela = new PagSeguroParcela();
        	$oPagSeguroParcela->Vezes = $vezes;
        	$oPagSeguroParcela->Juros = $juros;
        	$oPagSeguroParcela->Valor = $valor;
        	$oPagSeguroParcela->Total = $total;
        	
            if($oPagSeguroParcela->Valor > $this->ParcelaMinima)
        	{
            	array_push($ar, $oPagSeguroParcela);
            }
        }
        return $ar;
	}
	
	/**
	 * Gera
	 * 
	 * @access public
	 * @param object $oPedido
	 * @param object $oCliente
	 * @param array $Itens
	 * @return void
	 */
	public function Generate($oPedido, $oCliente, $Itens)
	{
		?>
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		    <title><?=$oPedido->WebTitle;?></title>
		    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		    <script language="javascript" type="text/javascript" src="<?=$oPedido->WebURL;?>library/plugins/jquery/jquery.js"></script>
		    <script language="javascript" type="text/javascript">
			    $(function(){
			    	$("#frmPagSeguro").submit();
			    });
			</script>
		</head>
		<body>
			<p>Enviando, aguarde...</p>
			
			<!-- PagSeguro -->
			<form action="https://pagseguro.uol.com.br/checkout/checkout.jhtml" method="post" id="frmPagSeguro">
			
				<!-- Informações gerias -->
				<input type="hidden" name="email_cobranca" value="<?=$this->Email;?>" />
				<input type="hidden" name="tipo" value="CP" />
				<input type="hidden" name="moeda" value="BRL" />
				<input type="hidden" name="ref_transacao" value="<?=$oPedido->NumeroPedido;?>" />
				<input type="hidden" name="tipo_frete" value="EN" />
				<input type="hidden" name="encoding" value="ISO-8859-1" />
				
				<!-- Itens -->
				<?php
				$conta = 0;
				foreach($Itens as $c => $v)
				{
					$conta++;
					?>
					<input type="hidden" name="item_id_<?=$conta;?>" value="<?=$c;?>" />
					<input type="hidden" name="item_descr_<?=$conta;?>" value="<?=$v->Titulo;?>" />
					<input type="hidden" name="item_quant_<?=$conta;?>" value="<?=$v->Quantidade;?>" />
					<input type="hidden" name="item_valor_<?=$conta;?>" value="<?=ereg_replace("[^0-9]", "", $oPedido->DecimalShow($v->ValorUnitario));?>" />
					<input type="hidden" name="item_frete_<?=$conta;?>" value="0" />
					<input type="hidden" name="item_peso_<?=$conta;?>" value="0" />
					<?php
				}
				?>
				
				<!-- Frete -->
				<?php
				if($oPedido->ValorFrete > 0)
				{
					$conta++;
					?>
					<input type="hidden" name="item_id_<?=$conta;?>" value="frete" />
					<input type="hidden" name="item_descr_<?=$conta;?>" value="Frete para <?=$oPedido->CEP;?>" />
					<input type="hidden" name="item_quant_<?=$conta;?>" value="1" />
					<input type="hidden" name="item_valor_<?=$conta;?>" value="<?=ereg_replace("[^0-9]", "", $oPedido->DecimalShow($oPedido->ValorFrete));?>" />
					<input type="hidden" name="item_frete_<?=$conta;?>" value="0" />
					<input type="hidden" name="item_peso_<?=$conta;?>" value="0" />
					<?php
				}
				?>
				
				<!-- Dados do Cliente -->
				<input type="hidden" name="cliente_nome" value="<?=$oCliente->Nome;?>" />
				<input type="hidden" name="cliente_cep" value="<?=ereg_replace("[^0-9]", "", $oCliente->CEP);?>" />
				<input type="hidden" name="cliente_end" value="<?=$oCliente->Endereco;?>" />
				<input type="hidden" name="cliente_num" value="<?=$oCliente->Numero;?>" />
				<input type="hidden" name="cliente_compl" value="<?=$oCliente->Complemento;?>" />
				<input type="hidden" name="cliente_bairro" value="<?=$oCliente->Bairro;?>" />
				<input type="hidden" name="cliente_cidade" value="<?=$oCliente->Cidade;?>" />
				<input type="hidden" name="cliente_uf" value="<?=$oCliente->Estado;?>" />
				<input type="hidden" name="cliente_pais" value="<?=$oCliente->Pais;?>" />
				<input type="hidden" name="cliente_ddd" value="<?=ereg_replace("[^0-9]", "", substr($oCliente->Telefone1, 1, 2));?>" />
				<input type="hidden" name="cliente_tel" value="<?=ereg_replace("[^0-9]", "", substr($oCliente->Telefone1, 5, 9));?>" />
				<input type="hidden" name="cliente_email" value="<?=$oCliente->Email;?>" />
			</form>
		</body>
		</html>
		<?php
	}
}

/**
 * Classe utilizada para parcelas do pagseguro
 * 
 * @author ClickNow <suporte@clicknow.com.br>
 * @copyright Copyright (c), ClickNow
 * @access public
 */
class PagSeguroParcela
{
	public $Vezes = null;
	public $Juros = null;
	public $Valor = null;
	public $Total = null;
}

?>