<?php

/**
 * Classe utilizada para validar
 * 
 * @author ClickNow <suporte@clicknow.com.br>
 * @copyright Copyright (c), ClickNow
 * @access public
 */
class Validator
{
    public $ClassName = "validacao";
    public $Message = array();
    public $MessageDefault = array
	(
		'required' => 'Campo obrigatório.',
		'email' => 'Digite um e-mail válido.',
		'date' => 'Digite uma data válida.',
		'time' => 'Digite uma hora válida.',
		'cpf' => 'Digite um CPF válido.',
		'cnpj' => 'Digite um CNPJ válido.',
		'number' => 'Digite um número válido.',
		'url' => 'Digite uma URL válida.',
		'cep' => 'Digite um CEP válido.',
		'phone' => 'Digite um telefone válido.',
		'expression' => 'Campo inválido.',
		'compare' => 'Campo inválido.',
		'function' => 'Campo inválido',
		'minlength' => 'Digite um valor com no mínimo %s caracteres.',
		'maxlength' => 'Digite um valor com no máximo %s caracteres.',
		'minvalue' => 'Digite um valor maior ou igual a %s.',
		'maxvalue' => 'Digite um valor menor ou igual a %s.',
		'rangelength' => 'Digite um valor entre %s e %s caracteres.',
		'rangevalue' => 'Digite um valor entre %s e %s.',
		'dateequal' => 'Digite um data igual %s.',
		'dategreaterthan' => 'Digite uma data maior que %s.',
		'datelessthan' => 'Digite uma data menor que %s.',
		'dategreaterthanequal' => 'Digite uma data maior ou igual que %s.',
		'datelessthanequal' => 'Digite uma data menor ou igual que %s.'
	);

    /**
     * Construtor da classe
     * 
     * @access public
     * @return void
     */
    public function Validator()
    {
    	
    }

    /**
     * Função que adiciona os campos para validação
     * 
     * @access public
	 * @param string $Name
     * @param string $Value
     * @param bool $Required (Default: true)
     * @param string $Type (Default: null)
     * @param string $Message (Default: null)
     * @param string $Extra (Default: null)
     * @return void
     */
    public function Add($Name, $Value, $Required = false, $Type = null, $Message = null, $Extra = null)
    {
    	//verifica tipo
    	if($Type && !array_key_exists($Type, $this->MessageDefault))
    	{
    		throw new Exception("Tipo inválido.");
    	}
		
		//valida
		$b = true;
        if ($Required == true)
        {
            $b = self::ValidateRequired($Value);
        }
        if ($b && $Value != "")
        {
            switch ($Type)
            {
                case "email": $b = self::ValidateEmail($Value); break;
                case "date": $b = self::ValidateDate($Value); break;
                case "time": $b = self::ValidateTime($Value); break;
                case "cpf": $b = self::ValidateCPF($Value); break;
                case "cnpj": $b = self::ValidateCNPJ($Value); break;
                case "number": $b = self::ValidateNumber($Value); break;
                case "url": $b = self::ValidateURL($Value); break;
                case "cep": $b = self::ValidateCEP($Value); break;
                case "phone": $b = self::ValidatePhone($Value); break;
                case "expression": $b = self::ValidateExpression($Extra, $Value); break;
                case "compare": $b = self::ValidateCompare($Value, $Extra); break;
                case "function": $b = self::ValidateFunction($Value, $Extra); break;
                case "minlength"; $b = self::ValidateMinLength($Value, $Extra); break;
                case "maxlength"; $b = self::ValidateMaxLength($Value, $Extra); break;
                case "minvalue"; $b = self::ValidateMinValue($Value, $Extra); break;
                case "maxvalue"; $b = self::ValidateMaxValue($Value, $Extra); break;                
                case "rangelength"; $b = self::ValidateRangeLength($Value, $Extra); break;
                case "rangevalue"; $b = self::ValidateRangeValue($Value, $Extra); break;
                case "dateequal"; $b = self::ValidateDateEqual($Value, $Extra); break;
                case "dategreaterthan"; $b = self::ValidateDateGreaterThan($Value, $Extra); break;
                case "datelessthan"; $b = self::ValidateDateLessThan($Value, $Extra); break;
                case "dategreaterthanequal"; $b = self::ValidateDateGreaterThanEqual($Value, $Extra); break;
                case "datelessthanequal"; $b = self::ValidateDateLessThanEqual($Value, $Extra); break;
            }
        }
        else
        {
            $Message = (($Message != null) ? $Message : $this->MessageDefault["required"]);
        }
        
        //formata mensagem
        if (!$b)
        {
        	$Message = (($Message != null) ? $Message : $this->MessageDefault[$Type]);
        	switch($Type)
	    	{
	    		case "minlength": $Message = sprintf($Message, $Extra); break;
	            case "maxlength": $Message = sprintf($Message, $Extra); break;
	            case "minvalue": $Message = sprintf($Message, $Extra); break;
	            case "maxvalue": $Message = sprintf($Message, $Extra); break;
	            case "rangelength": $Message = sprintf($Message, $Extra[0], $Extra[1]); break;
	            case "rangevalue": $Message = sprintf($Message, $Extra[0], $Extra[1]); break;
	            case "dateequal": $Message = sprintf($Message, $Extra); break;
	            case "dategreaterthan": $Message = sprintf($Message, $Extra); break;
	            case "datelessthan": $Message = sprintf($Message, $Extra); break;
	            case "dategreaterthanequal": $Message = sprintf($Message, $Extra); break;
	            case "datelessthanequal": $Message = sprintf($Message, $Extra); break;
	    	}
	    	$this->Message[$Name] = $Message;
        }
    }

    /**
     * Função que executa validação
     * 
     * @access public
     * @return bool
     */
    public function Validate()
    {
        return (count($this->Message) < 1);
    }
    
    /**
     * Função que adiciona uma mensagem de erro
     * 
     * @access public
     * @param string $Name
     * @param string $Message
     * @return void
     */
    public function AddMessage($Name, $Message)
    {
    	$this->Message[$Name] = $Message;
    }
    
    /**
     * Função que monta a mensagem de retorno
     * 
     * @access public
     * @param string $Title (Default: "Mensagem")
     * @return string
     */
    public function Create($Title = "Mensagem")
    {
    	if(count($this->Message) > 0)
    	{
    		return '<div class="' . $this->ClassName . '">' . $Title . '<ul><li>' . implode("</li><li>", $this->Message) . '</li></ul></div>';
    	}
    	
    	return "";
    }
	
	/**
     * Methodo de validação(obrigatório)
     * 
     * @access public
     * @param string $Value
     * @return bool
     */
    public static function ValidateRequired($Value)
    {
        return (trim($Value) != "");
    }

    /**
     * Methodo de validação(e-mail)
     * 
     * @access public
     * @param string $Value
     * @return bool
     */
    public static function ValidateEmail($Value)
    {
        return self::ValidateExpression("/^[0-9a-z]+(([\.\-_])[0-9a-z]+)*@[0-9a-z]+(([\.\-])[0-9a-z-]+)*\.[a-z]{2,4}$/i", $Value);
    }

    /**
     * Methodo de validação(data)
     * 
     * @access public
     * @param string $Value
     * @return bool
     */
    public static function ValidateDate($Value)
    {
        $data = explode("/", $Value);
        $d = $data[0];
        $m = $data[1];
        $y = $data[2];
        return checkdate($m, $d, $y);
    }
    
    /**
     * Methodo de validação(hora)
     * 
     * @access public
     * @param string $Value
     * @return bool
     */
    public static function ValidateTime($Value)
    {
        return ereg("^([0-1][0-9]|[2][0-3]):[0-5][0-9]$", $Value);
    }

    /**
     * Methodo de validação(cpf)
     * 
     * @access public
     * @param string $Value
     * @return bool
     */
    public static function ValidateCPF($Value)
    {
        $cpf = str_pad(ereg_replace('[^0-9]', '', $Value), 11, '0', STR_PAD_LEFT);

        if (strlen($cpf) != 11 || $cpf == '00000000000' || $cpf == '11111111111' || $cpf == '22222222222' || $cpf == '33333333333' || $cpf == '44444444444' || $cpf == '55555555555' || $cpf == '66666666666' ||
            $cpf == '77777777777' || $cpf == '88888888888' || $cpf == '99999999999')
        {
            return false;
        }
        else
        {
            for ($t = 9; $t < 11; $t++)
            {
                for ($d = 0, $c = 0; $c < $t; $c++)
                {
                    $d += $cpf{$c} * (($t + 1) - $c);
                }

                $d = ((10 * $d) % 11) % 10;

                if ($cpf{$c} != $d)
                {
                    return false;
                }
            }

            return true;
        }
    }

    /**
     * Methodo de validação(cnpj)
     * 
     * @access public
     * @param string $Value
     * @return bool
     */
    public static function ValidateCNPJ($Value)
    {
        $cnpj = str_pad(ereg_replace('[^0-9]', '', $Value), 14, '0', STR_PAD_LEFT);

        if (strlen($cnpj) != 14 || $cnpj == '00000000000000' || $cpf == '11111111111111' || $cpf == '22222222222222' || $cpf == '33333333333333' || $cpf == '44444444444444' || $cpf == '55555555555555' ||
            $cpf == '66666666666666' || $cpf == '77777777777777' || $cpf == '88888888888888' || $cpf == '99999999999999')
        {
            return false;
        }
        else
        {
            for ($t = 12; $t < 14; $t++)
            {
                for ($d = 0, $p = $t - 7, $c = 0; $c < $t; $c++)
                {
                    $d += $cnpj{$c} * $p;
                    $p = ($p < 3) ? 9 : --$p;
                }

                $d = ((10 * $d) % 11) % 10;

                if ($cnpj{$c} != $d)
                {
                    return false;
                }
            }

            return true;
        }
    }

    /**
     * Methodo de validação(número)
     * 
     * @access public
     * @param string $Value
     * @return bool
     */
    public static function ValidateNumber($Value)
    {
        return is_numeric($Value);
    }

    /**
     * Methodo de validação(url)
     * 
     * @access public
     * @param string $Value
     * @return bool
     */
    public static function ValidateURL($Value)
    {
        return self::ValidateExpression('|^http(s)?://[a-z0-9-]+(\.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $Value);
    }
    
    /**
     * Methodo de validação(cep)
     * 
     * @access public
     * @param string $Value
     * @return bool
     */
    public static function ValidateCEP($Value)
    {
        return self::ValidateExpression('/[0-9]{5}\-[0-9]{3}/', $Value);
    }
    
    /**
     * Methodo de validação(telefone)
     * 
     * @access public
     * @param string $Value
     * @return bool
     */
    public static function ValidatePhone($Value)
    {
        return self::ValidateExpression('/^\([0-9]{2}\) [0-9]{4}-[0-9]{4}$/', $Value);
    }
    
    /**
     * Methodo de validação(expressão)
     * 
     * @access public
     * @param string $Expression
     * @param string $Value
     * @return bool
     */
    public static function ValidateExpression($Expression, $Value)
    {
    	return preg_match($Expression, $Value);
    }
    
    /**
     * Methodo de validação(comparação)
     * 
     * @access public
     * @param string $Value1
     * @param string $Value2
     * @return bool
     */
    public static function ValidateCompare($Value1, $Value2)
    {
    	return ($Value1 == $Value2);
    }
    
    /**
     * Methodo de validação(função)
     * 
     * @access public
     * @param string $Value
     * @param string $Extra
     * @return bool
     */
    public static function ValidateFunction($Value, $Extra)
    {
    	if(function_exists($Extra))
		{
			return $Extra($Value);
		}
		
		return false;
    }
    
	/**
    * Methodo de validação(quantidade de caracteres menor que)
    * 
    * @access public
    * @param string $Value
    * @param string $Extra
    * @return bool
    */ 
    public static function ValidateMinLength($Value, $Extra)
	{
		return (strlen($Value) >= $Extra);
	}
	
	/**
    * Methodo de validação(quantidade de caracteres maior que)
    * 
    * @access public
    * @param string $Value
    * @param string $Extra
    * @return bool
    */ 
	public static function ValidateMaxLength($Value, $Extra)
	{
		return (strlen($Value) <= $Extra);
	}
	
	/**
    * Methodo de validação(valor menor que)
    * 
    * @access public
    * @param string $Value
    * @param string $Extra
    * @return bool
    */ 
	public static function ValidateMinValue($Value, $Extra)
	{
		return ($Value >= $Extra);
	}
	
	/**
    * Methodo de validação(valor maior que)
    * 
    * @access public
    * @param string $Value
    * @param string $Extra
    * @return bool
    */ 
	public static function ValidateMaxValue($Value, $Extra)
	{
		return ($Value <= $Extra);
	}
	
	/**
    * Methodo de validação(entre quantidade de caracteres)
    * 
    * @access public
    * @param string $Value
    * @param string $Extra
    * @return bool
    */ 
	public static function ValidateRangeLength($Value, $Extra)
	{
		return (strlen($Value) >= $Extra[0] && strlen($Value) <= $Extra[1]);
	}
	
	/**
    * Methodo de validação(entre valores)
    * 
    * @access public
    * @param string $Value
    * @param string $Extra
    * @return bool
    */ 
	public static function ValidateRangeValue($Value, $Extra)
	{
		return ($Value >= $Extra[0] && $Value <= $Extra[1]);
	}
	
	/**
    * Methodo de validação(datas iguais)
    * 
    * @access public
    * @param string $Value
    * @param string $Extra
    * @return bool
    */ 
	public static function ValidateDateEqual($Value, $Extra)
	{
		if(!self::ValidateDate($Value) || !self::ValidateDate($Extra))
		{
			return false;
		}
		
		$data1 = explode("/", $Value);
		$data2 = explode("/", $Extra);
		return (mktime(0, 0, 0, $data1[1], $data1[0], $data1[2]) == mktime(0, 0, 0, $data2[1], $data2[0], $data2[2]));
	}
	
	/**
    * Methodo de validação(data maior)
    * 
    * @access public
    * @param string $Value
    * @param string $Extra
    * @return bool
    */ 
	public static function ValidateDateGreaterThan($Value, $Extra)
	{
		if(!self::ValidateDate($Value) || !self::ValidateDate($Extra))
		{
			return false;
		}
		
		$data1 = explode("/", $Value);
		$data2 = explode("/", $Extra);
		return (mktime(0, 0, 0, $data1[1], $data1[0], $data1[2]) > mktime(0, 0, 0, $data2[1], $data2[0], $data2[2]));
	}
	
	/**
    * Methodo de validação(data menor)
    * 
    * @access public
    * @param string $Value
    * @param string $Extra
    * @return bool
    */ 
	public static function ValidateDateLessThan($Value, $Extra)
	{
		if(!self::ValidateDate($Value) || !self::ValidateDate($Extra))
		{
			return false;
		}
		
		$data1 = explode("/", $Value);
		$data2 = explode("/", $Extra);
		return (mktime(0, 0, 0, $data1[1], $data1[0], $data1[2]) < mktime(0, 0, 0, $data2[1], $data2[0], $data2[2]));
	}
	
	/**
    * Methodo de validação(data maior ou igual)
    * 
    * @access public
    * @param string $Value
    * @param string $Extra
    * @return bool
    */ 
	public static function ValidateDateGreaterThanEqual($Value, $Extra)
	{
		if(!self::ValidateDate($Value) || !self::ValidateDate($Extra))
		{
			return false;
		}
		
		$data1 = explode("/", $Value);
		$data2 = explode("/", $Extra);
		return (mktime(0, 0, 0, $data1[1], $data1[0], $data1[2]) >= mktime(0, 0, 0, $data2[1], $data2[0], $data2[2]));
	}
	
	/**
    * Methodo de validação(data menor ou igual)
    * 
    * @access public
    * @param string $Value
    * @param string $Extra
    * @return bool
    */ 
	public static function ValidateDateLessThanEqual($Value, $Extra)
	{
		if(!self::ValidateDate($Value) || !self::ValidateDate($Extra))
		{
			return false;
		}
		
		$data1 = explode("/", $Value);
		$data2 = explode("/", $Extra);
		return (mktime(0, 0, 0, $data1[1], $data1[0], $data1[2]) <= mktime(0, 0, 0, $data2[1], $data2[0], $data2[2]));
	}
}

?>