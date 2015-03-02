<?php

include_once(dirname(dirname(__FILE__)) . "/util.php");

/**
 * Classe utilizada para calcular preço e prazo de frete do correio {@link http://www.correios.com.br/webservices/}
 * Documentação {@link http://www.correios.com.br/webServices/PDF/SCPP_manual_implementacao_calculo_remoto_de_precos_e_prazos.pdf}
 * 
 * @author ClickNow <suporte@clicknow.com.br>
 * @copyright Copyright (c), ClickNow
 * @access public
 */
class Correios extends Util
{
	const CALCULAR_URL = "http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx";
	const RASTREAR_URL = "http://websro.correios.com.br/sro_bin/txect01$.QueryList?P_LINGUA=001&P_TIPO=001&P_COD_UNI=";
	
	public $TipoServico = array
	(
		41106 => "PAC",
		40010 => "SEDEX",
		40045 => "SEDEX a Cobrar",
		40126 => "SEDEX a Cobrar",
		40215 => "SEDEX 10",
		40290 => "SEDEX Hoje",
		40096 => "SEDEX",
		40436 => "SEDEX",
		40444 => "SEDEX",
		81019 => "E-SEDEX",
		41068 => "PAC",
		40568 => "SEDEX",
		40606 => "SEDEX",
		81868 => "E-SEDEX",
		81833 => "E-SEDEX",
		81850 => "E-SEDEX"
	);
    
	public $nCdEmpresa = null;
	public $sDsSenha = null;
	public $nCdServico = array();
	public $sCepOrigem = null;
	public $sCepDestino = null;
	public $nVlPeso = 0;
	public $nCdFormato = 1;
	public $nVlComprimento = 0;
	public $nVlAltura = 0;
	public $nVlLargura = 0;
	public $nVlDiametro = 0;
	public $sCdMaoPropria = false;
	public $nVlValorDeclarado = 0;
	public $sCdAvisoRecebimento = false;
	
	/**
     * Construtor da classe
     * 
     * @access public
     * @return void
     */
	public function Correios()
	{
		parent::Util();
		$this->nCdServico = array_keys($this->TipoServico);
	}
	
	/**
     * Verifica valores
     * 
     * @access protected
     * @return void
     */
	protected function Check()
	{
		//nCdServico
		if(is_array($this->nCdServico))
		{
			$arDif = array_diff($this->nCdServico, array_keys($this->TipoServico));
			if(count($arDif) > 0)
			{
				throw new Exception("nCdServico inválido - Parâmetro(s) inválido(s): " . implode(", ", $arDif) . " !");
			}
		}
		else
		{
			if(!in_array($this->nCdServico, array_keys($this->TipoServico)))
			{
				throw new Exception("nCdServico inválido - Parâmetros válidos: " . implode(", ", array_keys($this->TipoServico)) . " !");
			}
		}
		
		//sCepOrigem
		if(strlen(ereg_replace("[^0-9]", "", $this->sCepOrigem)) != 8)
		{
			throw new Exception("sCepOrigem inválido!");
		}
		
		//sCepDestino
		if(strlen(ereg_replace("[^0-9]", "", $this->sCepDestino)) != 8)
		{
			throw new Exception("sCepDestino inválido!");
		}
		
		//nVlPeso
		if(!is_numeric($this->nVlPeso) || $this->nVlPeso <= 0)
		{
			throw new Exception("nVlPeso inválido!");
		}
		
		//nCdFormato
		if(!is_int($this->nCdFormato) || ($this->nCdFormato != 1 && $this->nCdFormato != 2))
		{
			throw new Exception("nCdFormato inválido!");
		}
		
		//nVlComprimento
		if(!is_numeric($this->nVlComprimento))
		{
			throw new Exception("nVlComprimento inválido!");
		}
		
		//nVlAltura
		if(!is_numeric($this->nVlAltura))
		{
			throw new Exception("nVlAltura inválido!");
		}
		
		//nVlLargura
		if(!is_numeric($this->nVlLargura))
		{
			throw new Exception("nVlLargura inválido!");
		}
		
		//nVlDiametro
		if(!is_numeric($this->nVlDiametro))
		{
			throw new Exception("nVlDiametro inválido!");
		}
		
		//nVlValorDeclarado
		if(!is_numeric($this->nVlValorDeclarado))
		{
			throw new Exception("nVlValorDeclarado inválido!");
		}
	}
	
	/**
	 * Força valores mínimos e máximos
	 * 
	 * @access protected
	 * @return void
	 */
	protected function Force()
	{
		$this->nVlPeso = (($this->nVlPeso <= 0) ? 0.1 : $this->nVlPeso);
		$this->nVlPeso = (($this->nVlPeso > 30) ? 30 : $this->nVlPeso);
		
		if($this->nCdFormato == 1)
		{
			$this->nVlComprimento = (($this->nVlComprimento < 16) ? 16 : $this->nVlComprimento);
			$this->nVlComprimento = (($this->nVlComprimento > 90) ? 90 : $this->nVlComprimento);
			
			$this->nVlAltura = (($this->nVlAltura < 2) ? 2 : $this->nVlAltura);
			$this->nVlAltura = (($this->nVlAltura > 90) ? 90 : $this->nVlAltura);
			
			$this->nVlLargura = (($this->nVlLargura < 5) ? 5 : $this->nVlLargura);
			$this->nVlLargura = (($this->nVlLargura > 90) ? 90 : $this->nVlLargura);
			
			$this->nVlDiametro = 0;
			
			$this->nVlAltura = (($this->nVlAltura > $this->nVlComprimento) ? $this->nVlComprimento : $this->nVlAltura);
			$this->nVlLargura = (($this->nVlLargura < 11 && $this->nVlComprimento < 25) ? 11 : $this->nVlLargura);
			
			if(($this->nVlComprimento + $this->nVlAltura + $this->nVlLargura) > 160)
			{
				$this->nVlComprimento = 60;
				$this->nVlAltura = 50;
				$this->nVlLargura = 50;
			}
		}
		else
		{
			$this->nVlComprimento = (($this->nVlComprimento < 18) ? 18 : $this->nVlComprimento);
			$this->nVlComprimento = (($this->nVlComprimento > 90) ? 90 : $this->nVlComprimento);
			
			$this->nVlDiametro = (($this->nVlDiametro < 5) ? 5 : $this->nVlDiametro);
			$this->nVlDiametro = (($this->nVlDiametro > 90) ? 90 : $this->nVlDiametro);
			
			if(($this->nVlComprimento + ($this->nVlDiametro * 2) > 104))
			{
				$this->nVlComprimento = 60;
				$this->nVlDiametro = ((104 - $this->nVlComprimento) / 2);
			}
			
			$this->nVlAltura = $this->nVlDiametro;
			$this->nVlLargura = $this->nVlDiametro;
		}
		
		$this->nVlValorDeclarado = (($this->nVlValorDeclarado > 10000) ? 10000 : $this->nVlValorDeclarado);
	}
	
	/**
     * Envia valores para o correio
     * 
     * @access public
     * @param bool $Valid (Default: true)
     * @param bool $Force (Default: true)
     * @return array (CorreiosServico)
     */
	public function Send($Valid = true, $Force = true)
	{
		//verifica valores
		$this->Check();
		
		if($Force)
		{
			$Peso = $this->nVlPeso;
			$this->Force();
		}
		
		//parâmetros
		$query = "?StrRetorno=xml";
		$query .= "&nCdEmpresa=" . $this->nCdEmpresa;
		$query .= "&sDsSenha=" . $this->sDsSenha;
		$query .= "&nCdServico=" . ((is_array($this->nCdServico)) ? implode(",", $this->nCdServico) : $this->nCdServico);
		$query .= "&sCepOrigem=" . ereg_replace("[^0-9]", "", $this->sCepOrigem);
		$query .= "&sCepDestino=" . ereg_replace("[^0-9]", "", $this->sCepDestino);
		$query .= "&nVlPeso=" . $this->nVlPeso;
		$query .= "&nCdFormato=" . $this->nCdFormato;
		$query .= "&nVlComprimento=" . $this->nVlComprimento;
		$query .= "&nVlAltura=" . $this->nVlAltura;
		$query .= "&nVlLargura=" . $this->nVlLargura;
		$query .= "&nVlDiametro=" . $this->nVlDiametro;
		$query .= "&sCdMaoPropria=" . (($this->sCdMaoPropria) ? "S" : "N");
		$query .= "&nVlValorDeclarado=" . $this->nVlValorDeclarado;
		$query .= "&sCdAvisoRecebimento=" . (($this->sCdAvisoRecebimento) ? "S" : "N");
		
		//verfica extensão CURL
		if(!function_exists("curl_init"))
		{
			throw new Exception("Necessário a extensão CURL.");
		}
		
		//envia dados pela função CURL
		$ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::CALCULAR_URL . $query);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$response = curl_exec($ch);
        $info = curl_getinfo($ch);
        $error = curl_error($ch);
        curl_close($ch);
        
        //verifica retorno
        if($error || $info["http_code"] != "200" || !$response)
        {
        	throw new Exception("Problemas na requisição - " . $response);
        }
        
        //processa retorno
        $ar = array();
        $dom = new DOMDocument();
		if($dom->loadXML($response))
		{
			$entries = $dom->getElementsByTagName("cServico");
			foreach ($entries as $entry)
			{
				$oCorreiosServico = new CorreiosServico();
				$oCorreiosServico->Codigo = $entry->getElementsByTagName("Codigo")->item(0)->nodeValue;
				$oCorreiosServico->Tipo = $this->TipoServico[$oCorreiosServico->Codigo];
				$oCorreiosServico->Valor = $entry->getElementsByTagName("Valor")->item(0)->nodeValue;
				$oCorreiosServico->PrazoEntrega = $entry->getElementsByTagName("PrazoEntrega")->item(0)->nodeValue;
				$oCorreiosServico->ValorMaoPropria = $entry->getElementsByTagName("ValorMaoPropria")->item(0)->nodeValue;
				$oCorreiosServico->ValorAvisoRecebimento = $entry->getElementsByTagName("ValorAvisoRecebimento")->item(0)->nodeValue;
				$oCorreiosServico->ValorValorDeclarado = $entry->getElementsByTagName("ValorValorDeclarado")->item(0)->nodeValue;
				$oCorreiosServico->EntregaDomiciliar = $entry->getElementsByTagName("EntregaDomiciliar")->item(0)->nodeValue;
				$oCorreiosServico->EntregaSabado = $entry->getElementsByTagName("EntregaSabado")->item(0)->nodeValue;
				$oCorreiosServico->Erro = $entry->getElementsByTagName("Erro")->item(0)->nodeValue;
				//$oCorreiosServico->MsgErro = $entry->getElementsByTagName("MsgErro")->item(0)->nodeValue;
				$oCorreiosServico->MsgErro = $this->ParseError($oCorreiosServico->Erro);
				
				if($Force && ($Peso - $this->nVlPeso) > 0)
				{
					$oCorreiosServico->Valor = $this->DecimalShow($this->DecimalConvert($oCorreiosServico->Valor) + (($this->DecimalConvert($oCorreiosServico->Valor) * ($Peso - $this->nVlPeso)) / $this->nVlPeso));
				}
				
				if(($Valid && !$oCorreiosServico->Erro) || !$Valid)
				{
					array_push($ar, $oCorreiosServico);
				}
			}
		}
        return $ar;
	}
	
	/**
     * Formata erro
     * 
     * @access protected
     * @param string $Codigo
     * @return string
     */
	protected function ParseError($Codigo)
	{
		switch($Codigo)
		{
			case "0": return "Processamento com sucesso."; break;
			case "-1": return "Código de serviço inválido."; break;
			case "-2": return "CEP de origem inválido."; break;
			case "-3": return "CEP de destino inválido."; break;
			case "-4": return "Peso excedido."; break;
			case "-5": return "O valor declarado não deve exceder R$ 10.000,00."; break;
			case "-6": return "Serviço indisponível para o trecho informado."; break;
			case "-7": return "O valor declarado é obrigatório para este serviço."; break;
			case "-8": return "Este serviço não aceita mão própria."; break;
			case "-9": return "Este serviço não aceita aviso de recebimento."; break;
			case "-10": return "Precificação indisponível para o trecho informado."; break;
			case "-11": return "Para definição do preço deverão ser informados, também, o comprimento, a largura e altura do objeto em centímetros."; break;
			case "-12": return "Comprimento inválido."; break;
			case "-13": return "Largura inválida."; break;
			case "-14": return "Altura inválida."; break;
			case "-15": return "O comprimento não pode ser maior que 60cm."; break;
			case "-16": return "A largura não pode ser maior que 60cm."; break;
			case "-17": return "A altura não pode ser maior que 60cm."; break;
			case "-18": return "A altura não pode ser inferior a 2cm."; break;
			case "-19": return "A altura não pode ser maior que o comprimento."; break;
			case "-20": return "A largura não pode ser inferior a 5cm."; break;
			case "-21": return "A largura não pode ser menor que 11cm, quando o comprimento for menor que 25cm."; break;
			case "-22": return "O comprimento não pode ser inferior a 16cm."; break;
			case "-23": return "A soma resultante do comprimento + largura + altura não deve superar a 150cm."; break;
			case "-24": return "Comprimento inválido."; break;
			case "-25": return "Diâmetro inválido."; break;
			case "-26": return "Informe o comprimento."; break;
			case "-27": return "Informe o diâmetro."; break;
			case "-28": return "O comprimento não pode ser maior que 90cm."; break;
			case "-29": return "O diâmetro não pode ser maior que 90cm."; break;
			case "-30": return "O comprimento não pode ser inferior a 18cm."; break;
			case "-31": return "O diâmetro não pode ser inferior a 5cm."; break;
			case "-32": return "A soma resultante do comprimento + o dobro do diâmetro não deve superar a 104cm."; break;
			case "-33": return "Sistema temporariamente fora do ar. Favor tentar mais tarde."; break;
			case "-34": return "Código administrativo ou senha inválidos."; break;
			case "-35": return "Senha incorreta."; break;
			case "-36": return "Cliente não possui contrato vigente com os Correios."; break;
			case "-37": return "Cliente não possui serviço ativo em seu contrato."; break;
			case "-38": return "Serviço indisponível para este código administrativo."; break;
			case "-888": return "Erro ao calcular a tarifa."; break;
			case "7": return "Serviço indisponível, tente mais tarde."; break;
			case "99": return "Outros erros diversos do .NET."; break;
			default: return "Serviço indisponível, tente mais tarde."; break;
		}
	}
	
	/**
	 * Rastrear
	 * 
	 * @access public
	 * @param string $Codigo
	 * @return array
	 */
	public static function Rastrear($Codigo)
	{
		//verfica extensão CURL
		if(!function_exists("curl_init"))
		{
			throw new Exception("Desculpe, a extensão CURL é necessária.");
		}
		
		//envia dados pela função CURL
		$ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::RASTREAR_URL . $Codigo);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$response = curl_exec($ch);
        $info = curl_getinfo($ch);
        $error = curl_error($ch);
        curl_close($ch);
        
        //verifica retorno
        if($error || $info["http_code"] != "200" || !$response)
        {
        	throw new Exception("Problemas na requisição - " . $response);
        }
        
        //processa retorno
        $matches = array();
        preg_match_all("/<tr><td[^>]*>([^<]*)<\/td><td>([^<]*)<\/td><td>[^>]*>([^<]*)/", $response, $matches);
        $ar = array();
        foreach($matches[0] as $key => $value)
        {
        	array_push($ar, array($matches[1][$key], $matches[2][$key], $matches[3][$key]));
        }
        return $ar;
	}
	
	/**
	 * Descrição
	 * 
	 * @access public
	 * @return string
	 */
	public static function toString()
	{
		return "Correios";
	}
}


/**
 * Classe utilizada para armazenar o retorno do correio
 * 
 * @author ClickNow <suporte@clicknow.com.br>
 * @copyright Copyright (c), ClickNow
 * @access public
 */
class CorreiosServico
{
	public $Codigo = null;
	public $Tipo = null;
	public $Valor = null;
	public $PrazoEntrega = null;
	public $ValorMaoPropria = null;
	public $ValorAvisoRecebimento = null;
	public $ValorValorDeclarado = null;
	public $EntregaDomiciliar = null;
	public $EntregaSabado = null;
	public $Erro = null;
	public $MsgErro = null;
}

?>