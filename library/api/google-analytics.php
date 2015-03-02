<?php

/**
 * Classe utilizada para gerenciar o Google Analytics
 * Documenta��o {@link http://code.google.com/intl/pt-BR/apis/analytics/docs/}
 * 
 * @author ClickNow <suporte@clicknow.com.br>
 * @copyright Copyright (c), ClickNow
 * @access public
 */
class GoogleAnalytics
{
	const GOOGLE_LOGIN_URL = "https://www.google.com/accounts/ClientLogin";
	const GOOGLE_ANALYTICS_URL = "https://www.google.com/analytics/feeds/";
	
	public $AuthenticationCode = null;
	public $ProfileID = null;
	public $SessionName = "GoogleAnalytics";
	public $StartDate = null;
	public $EndDate = null;
	
	/**
     * Construtor da classe
     * 
     * @access public
     * @param string $Email
     * @param string $Password
     * @param bool $Cache (Default: true)
     * @return void
     */
	public function GoogleAnalytics($Email, $Password, $Cache = true)
	{
		$this->StartDate = date("Y-m-d", mktime(0, 0, 0, date("m") , date("d") - 31, date("Y")));
		$this->EndDate = date("Y-m-d", mktime(0, 0, 0, date("m") , date("d") - 1, date("Y")));
		$this->Authentication($Email, $Password, $Cache);
	}
	
	/**
    * Autentica o e-mail e senha
    * 
    * @access protected
    * @param string $Email
    * @param string $Password
    * @param bool $Cache (Default: true)
    * @return void
    */
	protected function Authentication($Email, $Password, $Cache = true)
	{	
		if($Cache)
		{
			@session_start();
			$this->AuthenticationCode = $_SESSION[$this->SessionName];
		}
		
		if(!$this->AuthenticationCode)
		{
			//dados
			$data = array
			(
	            "accountType" => "GOOGLE",
	            "Email" => $Email,
	            "Passwd" => $Password,
	            "service" => "analytics",
	            "source" => "ClickNow"
	        );
			
			//envia
			$response = $this->Send(self::GOOGLE_LOGIN_URL, $data);
			if ($response)
			{
				preg_match("/Auth=(.*)/", $response, $matches);
				if(isset($matches[1]))
				{
					$this->AuthenticationCode = $matches[1];
					$_SESSION[$this->SessionName] = $this->AuthenticationCode;
					return;
				}
			}
			
			throw new Exception("Falha na autentica��o, por favor verifique seu e-mail e sua senha.");
		}
	}
	
	/**
    * Envia informa��es
	*
	* @access protected
    * @param string $URL
	* @param array $Data (Default: array())
	* @param array $Header (Default: array())
	* @return string
    */
	protected function Send($URL, $Data = array(), $Header = array())
	{
		//verifica url
		if (!isset($URL))
		{
			throw new Exception("URL n�o definida");
		}
		
		//verfica extens�o CURL
		if(!function_exists("curl_init"))
		{
			throw new Exception("Desculpe, a extens�o CURL � necess�ria.");
		}
		
		//envia dados pela fun��o CURL
		$ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $URL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		if (count($Data) > 0)
		{
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $Data);
		}
		else
		{
			array_push($Header, array("application/x-www-form-urlencoded"));
			curl_setopt($ch, CURLOPT_HTTPHEADER, $Header);
		}
		$response = curl_exec($ch);
        $info = curl_getinfo($ch);
        $error = curl_error($ch);
        curl_close($ch);
        
        //verifica retorno
        if($error || $info["http_code"] != "200" || !$response)
        {
        	throw new Exception("Problemas na requisi��o - " . $response);
        }
        
        return $response;
	}
	
	/**
    * Define o profile
    * 
    * @access public
    * @param int $ProfileID
    * @return void
    */
	public function SetProfile($ProfileID)
	{ 
		if (!preg_match("/^ga:\d{1,10}/", $ProfileID))
		{
			throw new Exception("GA Profile ID inv�lido. O formato deve ga:XXXXXX, onde XXXXXX � o n�mero do seu profile.");
		}
		$this->ProfileID = $ProfileID; 
	}
	
	/**
    * Define a data de in�cio e a data de t�rmino
    * 
    * @access public
    * @param date $DataInicio
    * @param date $DataTermino
    * @return void
    */
	public function SetRange($StartDate, $EndDate)
	{
		//valida data de in�cio
		if (!preg_match("/\d{4}-\d{2}-\d{2}/", $StartDate))
		{
			throw new Exception("Formato da data de in�cio inv�lido. (Formato: YYYY-MM-DD)");
		}
		
		//valida data de t�rmino
		if (!preg_match("/\d{4}-\d{2}-\d{2}/", $EndDate))
		{
			throw new Exception("Formato da data de t�rmino inv�lido. (Formato: YYYY-MM-DD)");
		}
		
		//valida per�odo das datas
		if (strtotime($StartDate) > strtotime($EndDate))
		{
			throw new Exception("Per�odo inv�lido. Data de in�cio maior que a data de t�rmino.");
		}
		
		//define data de in�cio e t�rmino
		$this->StartDate = $StartDate;
		$this->EndDate = $EndDate;
	}
	
	/**
    * Rela�rio
    * 
    * @access public
    * @param array $Properties (Default: array())
    * @return array
    */
	public function Report($Properties = array())
	{
		//verifica propriedades
		if (!is_array($Properties) || count($Properties) < 1)
		{
			throw new Exception("Propriedades inv�lidas.");
		}
		
		//formata propriedades
		$parans = array();
		foreach($Properties as $key => $value)
		{
			array_push($parans, urlencode($key) . "=" . urlencode($value));
        }
		
		//url do relat�rio
        $url = self::GOOGLE_ANALYTICS_URL . "data"
				. "?ids=" . urlencode($this->ProfileID)
				. "&start-date=" . urlencode($this->StartDate)
				. "&end-date=" . urlencode($this->EndDate)
				. "&" . implode("&", $parans);
		
		//formata xml
		$result = array();
		$dom = new DOMDocument();
		if($dom->loadXML($this->API($url)))
		{
			$entries = $dom->getElementsByTagName("entry");
			foreach ($entries as $entry)
			{
				$dims = "";
				$mets = array();
				
				$dimensions = $entry->getElementsByTagName("dimension");
				foreach ($dimensions as $dimension)
				{
					$dims .= $dimension->getAttribute("value")."~~";
				}

				$metrics = $entry->getElementsByTagName("metric");
				foreach ($metrics as $metric)
				{
					$name = $metric->getAttribute("name");
					$mets[$name] = $metric->getAttribute("value");
				}
				if($dims)
				{
					$dims = trim($dims,"~~");
					$result[$dims] = $mets;
				}
				else
				{
					$result = $mets;
				}
			}
		}
		return $result;
	}
	
	/**
    * API
    * 
    * @access protected
    * @param string $URL
    * @return string
    */
	protected function API($URL)
	{
		return $this->Send($URL, array(), array("Authorization: GoogleLogin auth=" . $this->AuthenticationCode));
	}
	
	/**
    * Profiles da conta
    * 
    * @access public
    * @return array
    */
	public function Profiles()
	{
		//formata xml
		$profiles = array();
		$dom = new DOMDocument();
		if($dom->loadXML($this->API(self::GOOGLE_ANALYTICS_URL . "accounts/default")))
		{
			$entries = $dom->getElementsByTagName("entry");
			foreach($entries as $entry)
			{
				$tmp = array();
				$tmp["title"] = $entry->getElementsByTagName("title")->item(0)->nodeValue;
				$tmp["id"] = $entry->getElementsByTagName("id")->item(0)->nodeValue;
				foreach($entry->getElementsByTagName("property") as $property)
				{
					if (strcmp($property->getAttribute("name"), "ga:accountId") == 0)
					{
						$tmp["accountId"] = $property->getAttribute("value");
					}    
					if (strcmp($property->getAttribute("name"), "ga:accountName") == 0)
					{
					   $tmp["accountName"] = $property->getAttribute("value");
					}
					if (strcmp($property->getAttribute("name"), "ga:profileId") == 0)
					{
						$tmp["profileId"] = $property->getAttribute("value");
					}
					if (strcmp($property->getAttribute("name"), "ga:webPropertyId") == 0)
					{
						$tmp["webProfileId"] = $property->getAttribute("value");
					}
				}
				array_push($profiles, $tmp);
			}
		}
		return $profiles;
	}
	
	/**
     * Formata valor
     * 
     * @access public
     * @param string $Value
     * @return string
     */
	public function Parse($Value)
	{
		$Value = utf8_decode($Value);
		switch(strtolower($Value))
		{
			case "(not set)": $Value = "(N�o definido)"; break;
			case "(direct)": $Value = "(Direto)"; break;
		}
		return $Value;
	}
	
	/**
    * Calcula Tempo
    * 
    * @access public
    * @param float $v1
    * @param float $v2
    * @param bool $Format (Default: true)
    * @return string
    */
	public function CalculateTime($v1, $v2, $Format = true)
	{
		$horas = 0;
		$minutos = 0;
		$segundos = 0;
		if($v2 > 0)
		{
			$media = ($v1 / $v2);
			$horas = floor($media / 3600);
			$minutos = floor($media / 60);
			$segundos = floor($media - (($horas * 3600) + ($minutos * 60)));
		}
		if($Format)
		{
			return sprintf("%02d:%02d:%02d", $horas , $minutos, $segundos);
		}
		else
		{
			return intval(sprintf("%02d%02d%02d", $horas , $minutos, $segundos));
		}
	}
	
	/**
    * Calcula
    * 
    * @access public
    * @param float $v1
    * @param float $v2
    * @param bool $Multiply (Default: true)
    * @param bool $Format (Default: true)
    * @return string
    */
	public function Calculate($v1, $v2, $Multiply = true, $Format = true)
	{
		if($v2 > 0)
		{
			if($Multiply)
			{
				if($Format)
				{
					return number_format((($v1 / $v2) * 100), 2, ",", ".");
				}
				else
				{
					return (($v1 / $v2) * 100);
				}
			}
			else
			{
				if($Format)
				{
					return number_format(($v1 / $v2), 2, ",", ".");
				}
				else
				{
					return ($v1 / $v2);
				}
			}
		}
		else
		{
			if($Format)
			{
				return number_format($v1, 2, ",", ".");
			}
			else
			{
				return $v1;
			}
		}
	}
}

?>