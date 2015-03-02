<?php

include_once(dirname(__FILE__) . "/config/config.php");

/**
 * Classe utilizada para várias funcionalidades
 * 
 * @author ClickNow <suporte@clicknow.com.br>
 * @copyright Copyright (c), ClickNow
 * @access public
 */
class Util extends Config
{
	public $Week = array("Domingo", "Segunda-Feira", "Terça-Feira", "Quarta-Feira", "Quinta-Feira", "Sexta-Feira", "Sábado");
	public $Month = array("", "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro");
    public $AddressType = array('Outros', 'Aeroporto', 'Alameda', 'Area', 'Avenida', 'Campo', 'Chácara', 'Colônia', 'Condomínio', 'Conjunto', 'Distrito', 'Esplanada', 'Estação', 'Estrada', 'Favela', 'Fazenda', 'Feira', 'Jardim', 'Ladeira', 'Lago', 'Lagoa', 'Largo', 'Loteamento', 'Morro', 'Núcleo', 'Parque', 'Passarela', 'Pátio', 'Praça', 'Quadra', 'Recanto', 'Residencial', 'Rodovia', 'Rua', 'Setor', 'Sítio', 'Travessa', 'Trecho', 'Trevo', 'Vale', 'Vereda', 'Via', 'Viaduto', 'Viela', 'Vila');
	public $UF = array("AC" => "Acre", "AL" => "Alagoas", "AM" => "Amazonas", "AP" => "Amapá", "BA" => "Bahia", "CE" => "Ceará", "DF" => "Distrito Federal", "ES" => "Espírito Santo", "GO" => "Goiás", "MA" => "Maranhão", "MG" => "Minas Gerais", "MS" => "Mato Grosso do Sul", "MT" => "Mato Grosso", "PA" => "Pará", "PB" => "Paraiba", "PE" => "Pernambuco", "PI" => "Piaui", "PR" => "Paraná", "RJ" => "Rio de Janeiro", "RN" => "Rio Grande do Norte", "RO" => "Rondônia", "RR" => "Roraima", "RS" => "Rio Grande do Sul", "SC" => "Santa Catarina", "SE" => "Sergipe", "SP" => "São Paulo", "TO" => "Tocantins");
    public $Country = array("AL" => "Albania", "DZ" => "Algeria", "AS" => "American Samoa", "AD" => "Andorra", "AO" => "Angola", "AI" => "Anguilla", "AG" => "Antigua", "AR" => "Argentina", "AM" => "Armenia", "AW" => "Aruba", "AU" => "Australia", "AT" => "Austria", "AZ" => "Azerbaijan", "BS" => "Bahamas", "BH" => "Bahrain", "BD" => "Bangladesh", "BB" => "Barbados", "BY" => "Belarus", "BE" => "Belgium", "BZ" => "Belize", "BJ" => "Benin", "BM" => "Bermuda", "BT" => "Bhutan", "BO" => "Bolivia", "BW" => "Botswana", "BR" => "Brasil", "VG" => "British Virgin Islands", "BN" => "Brunei", "BG" => "Bulgaria", "BF" => "Burkina Faso", "BI" => "Burundi", "KH" => "Cambodia", "CM" => "Cameroon", "CA" => "Canada", "CV" => "Cape Verde", "KY" => "Cayman Islands", "TD" => "Chad", "CL" => "Chile", "CN" => "China", "CO" => "Colombia", "CG" => "Congo", "CK" => "Cook Islands", "CR" => "Costa Rica", "HR" => "Croatia", "CY" => "Cyprus", "CZ" => "Czech Republic", "DK" => "Denmark", "DJ" => "Djiibouti", "DM" => "Dominica", "DO" => "Dominican Republic", "EC" => "Ecuador", "EG" => "Egypt", "SV" => "El Salvador", "GQ" => "Equatorial Guinea", "ER" => "Eritrea", "EE" => "Estonia", "ET" => "Ethiopia", "FO" => "Faeroe Islands", "FJ" => "Fiji", "FI" => "Finland", "FR" => "France", "GF" => "French Guiana", "PF" => "French Polynesia", "GA" => "Gabon", "GM" => "Gambia", "GE" => "Georgia", "DE" => "Germany", "GH" => "Ghana", "GI" => "Gibraltar", "GR" => "Greece", "GL" => "Greenland", "GD" => "Grenada", "GP" => "Guadeloupe", "GU" => "Guam", "GT" => "Guatemala", "GN" => "Guinea", "GY" => "Guyana", "HT" => "Haiti", "HN" => "Honduras", "HK" => "Hong Kong", "HU" => "Hungary", "IS" => "Iceland", "IN" => "India", "ID" => "Indonesia", "IQ" => "Iraq Republic", "IE" => "Ireland", "IL" => "Israel", "IT" => "Italy", "CI" => "Ivory Coast", "JM" => "Jamaica", "JP" => "Japan", "JO" => "Jordan", "KZ" => "Kazakhstan", "KE" => "Kenya", "KW" => "Kuwait", "KG" => "Kyrgyzstan", "LV" => "Latvia", "LB" => "Lebanon", "LS" => "Lesotho", "LR" => "Liberia", "LI" => "Liechtenstein", "LT" => "Lithuania", "LU" => "Luxembourg", "MO" => "Macau", "MK" => "Macedonia", "MG" => "Madagascar", "MW" => "Malawi", "MY" => "Malaysia", "MV" => "Maldives", "ML" => "Mali", "MT" => "Malta", "MH" => "Marshall Islands", "MQ" => "Martinique", "MR" => "Mauritania", "MU" => "Mauritius", "MX" => "Mexico", "FM" => "Micronesia", "MD" => "Moldova", "MC" => "Monaco", "MS" => "Montserrat", "MA" => "Morocco", "MZ" => "Mozambique", "NA" => "Namibia", "NP" => "Nepal", "AN" => "Netherlands Antilles", "NL" => "Netherlands", "NC" => "New Caledonia", "NZ" => "New Zealand", "NI" => "Nicaragua", "NE" => "Niger", "NG" => "Nigeria", "NO" => "Norway", "OM" => "Oman", "PK" => "Pakistan", "PW" => "Palau", "PA" => "Panama", "PG" => "Papua New Guinea", "PY" => "Paraguay", "PE" => "Peru", "PH" => "Philippines", "PL" => "Poland", "PT" => "Portugal", "PR" => "Puerto Rico", "QA" => "Qatar", "RE" => "Reunion", "RO" => "Romania", "RU" => "Russian Federation", "RW" => "Rwanda", "MP" => "Saipan", "SA" => "Saudi Arabia", "GB" => "Scotland", "SN" => "Senegal", "SC" => "Seychelles", "SG" => "Singapore", "SK" => "Slovak Republic", "SI" => "Slovenia", "ZA" => "South Africa", "KR" => "South Korea", "ES" => "Spain", "LK" => "Sri Lanka", "KN" => "St. Kitts and Nevis", "LC" => "St. Lucia", "VC" => "St. Vincent", "SR" => "Suriname", "SZ" => "Swaziland", "SE" => "Sweden", "CH" => "Switzerland", "SY" => "Syria", "TW" => "Taiwan", "TZ" => "Tanzania", "TH" => "Thailand", "TG" => "Togo", "TT" => "Trinidad and Tobago", "TN" => "Tunisia", "TR" => "Turkey", "TC" => "Turks and Caicos Islands", "VI" => "U S Virgin Islands", "UG" => "Uganda", "UA" => "Ukraine", "AE" => "United Arab Emirates", "GB" => "United Kingdom", "US" => "United States", "UY" => "Uruguay", "UZ" => "Uzbekistan", "VU" => "Vanuatu", "VA" => "Vatican City", "VE" => "Venezuela", "VN" => "Vietnam", "UK" => "Wales", "WF" => "Wallis &amp; Futuna", "YE" => "Yemen", "YU" => "Servia &amp; Montenegro", "ZR" => "Zaire", "ZM" => "Zambia", "ZW" => "Zimbabwe");
    
	/**
     * Construtor da classe
     * 
     * @access public
     * @return void
     */
	public function Util()
	{
		parent::Config();
	}
	
    /**
     * Inicia permissões
     * 
     * @access public
     * @return void
     */
    public static function InitSet()
    {
		if(version_compare(PHP_VERSION, "5.2", "<")) throw new Exception("Desculpe, a versão do PHP deve ser maior ou igual que 5.2");
		if(!function_exists("mysqli_connect")) throw new Exception("Desculpe, a extensão MYSQLI é necessária.");
		if(!function_exists("mail")) throw new Exception("Desculpe, a extensão MAIL é necessária.");
		if(!function_exists("gd_info")) throw new Exception("Desculpe, a extensão GD é necessária.");
		if(!function_exists("curl_init")) throw new Exception("Desculpe, a extensão CURL é necessária.");
		
		ini_set("safe_mode", "Off");
		ini_set("register_globals","Off");
		ini_set("allow_url_fopen", "Off");
		ini_set("max_execution_time", "0");
		ini_set("track_errors", "Off");
		ini_set("display_errors", "Off");
		ini_set("file_uploads", "On");
		ini_set("upload_max_filesize", "100M");
		ini_set("post_max_size", "128M");
		ini_set("memory_limit", "64M");
		session_start();
		set_time_limit(0);
		error_reporting(0);
    }
    
    /**
     * Verifica as variáveis
     * 
     * @access public
     * @return void
     */
    public static function CheckVariables()
    {
		$_SERVER["QUERY_STRING"] = strip_tags($_SERVER["QUERY_STRING"]);
		
		function callback(&$v, $k)
		{
			$v =  Util::HTMLEncode($v);
		}
		
		if(is_array($_GET)) { array_walk_recursive($_GET, "callback"); }
		if(is_array($_POST)) { array_walk_recursive($_POST, "callback"); }
		if(is_array($_REQUEST)) { array_walk_recursive($_REQUEST, "callback"); }
		if(is_array($_COOKIE)) { array_walk_recursive($_COOKIE, "callback"); }
		if(is_array($HTTP_COOKIE_VARS)) { array_walk_recursive($HTTP_COOKIE_VARS, "callback"); }
		if(is_array($HTTP_GET_VARS)) { array_walk_recursive($HTTP_GET_VARS, "callback"); }
		if(is_array($HTTP_POST_VARS)) { array_walk_recursive($HTTP_POST_VARS, "callback"); }
    }
    
    /**
     * Verifica URL
     * 
     * @access public
     * @return void
     */
    public function ForceURL()
    {
    	if((strpos("http://" . $_SERVER["HTTP_HOST"] . $_SERVER["PHP_SELF"], $this->WebURL) === false)
		&& (strpos("https://" . $_SERVER["HTTP_HOST"] . $_SERVER["PHP_SELF"], $this->WebURL) === false))
		{
			header("Location: " . $this->WebURL);
			exit();
		}
	}
	
	/**
	 * Verifica mobile
	 * 
	 * @access public
	 * @param array $Mobiles
	 * @return bool
	 */
	public static function IsMobile($Mobiles = array("iPhone", "webOS", "iPod", "iPad", "BlackBerry"))
	{
		foreach($Mobiles as $Mobile)
		{
			if(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), strtolower($Mobile)))
			{
				return true;
			}
		}
		
		return false;
	}
	
	/**
	 * Remove caracter no primeiro ou último
	 * 
	 * @access public
	 * @param string $Value
	 * @param bool $First {Default: true}
	 * @param bool $Last {Default: true}
	 * @param string $Caracter {Default : "/"}
	 * @return string
	 */
	public static function RemoveCaracter($Value, $First = true, $Last = true, $Caracter = "/")
	{
		if($First)
		{
			while(substr($Value, 0, 1) == $Caracter)
			{
				$Value = substr($Value, 1);
			}
		}
		
		if($Last)
		{
	    	while(substr($Value, strlen($Value) - 1, 1) == $Caracter)
			{
				$Value = substr($Value, 0, strlen($Value) - 1);
			}
		}
		
		return $Value; 
	}
    
    /**
     * Busca Filtros
     * 
     * @access public
     * @param string $Value
     * @param int $Init (Default: 0)
     * @param string $Separator (Default: "/")
     * @return array
     */
    public static function GetFilter($Value, $Init = 0, $Separator = "/")
	{
		$Value = self::RemoveCaracter($Value, true, true, $Separator);
		
	    $ar = array();
	    $arSeparador = explode($Separator, $Value);
	    for($i = $Init; $i < count($arSeparador); $i++)
	    {
	        $ar[$arSeparador[$i]] = $arSeparador[$i+1];
	        $i++;
	    }
	    return $ar;
	}
	
	/**
	 * Define filtros
	 * 
	 * @access public
	 * @param string $Base
	 * @param array $Filter
	 * @param array $Parameter (Default: array())
	 * @param bool $IsQueryString (Default: false)
	 * @param string $Separator (Default: "/")
	 * @return string
	 */
	public static function SetFilter($Base, $Filter, $Parameter = array(), $IsQueryString = false, $Separator = "/")
	{
	    $Base = self::RemoveCaracter($Base, false, true, $Separator);
	    
	    $Filter = ((is_array($Filter)) ? $Filter : array());
	    $Parameter = ((is_array($Parameter)) ? $Parameter : array());
	    
	    $ar = array_merge($Filter, $Parameter);
	    $itens = array();
	    
	    foreach($ar as $key => $value)
	    {
	    	if($key) array_push($itens, $key . (($IsQueryString) ? "=" : $Separator) . $value);
	    }
	    
	    return $Base . (($IsQueryString) ? "?" . implode("&amp;", $itens) : $Separator . implode($Separator, $itens) . $Separator);
	}

    /**
     * Remove o arquivo
     * 
     * @access public
     * @param string $File
     * @return bool
     */
    public function RemoveFile($File)
    {
    	if(is_file($File))
    	{
    		$PathInfo = pathinfo($File);
    		
    		$arGlob = glob($this->ParseDirectory("thumb", $File) . $PathInfo["filename"] . "*." . $PathInfo["extension"]);
    		if(is_array($arGlob))
    		{
	    		foreach($arGlob as $FileTemp)
				{
					unlink($FileTemp);
				}
			}
			
			$arGlob = glob($this->ParseDirectory("recortar-imagem", $File) . $PathInfo["filename"] . "*." . $PathInfo["extension"]);
			if(is_array($arGlob))
    		{
	    		foreach($arGlob as $FileTemp)
				{
					unlink($FileTemp);
				}
			}
			
			return unlink($File);
    	}
    	
    	return false;
    }
    
    /**
     * Corta o texto sem cortar as palavras no meio
     * 
     * @access public
     * @param string $Text 
     * @param int $Limit
	 * @param int $Padding (Default: "...")
	 * @param bool $EndWord (Default: true)
     * @return void
     */
    public static function CutText($Text, $Limit, $Padding = "...", $EndWord = true)
    { 
    	$Text = strip_tags(self::HTMLDecode($Text));
        if(strlen($Text) > $Limit)
		{
			if($EndWord)
			{
				$Limit--;
				$Last = substr($Text, $Limit - 1, 1);
				while($Last != ' ' && $Limit > 0)
				{  
					$Limit--;  
					$Last = substr($Text, $Limit - 1, 1);
				}
				
				$Last = substr($Text, $Limit - 2, 1);
				if($Last == ',' || $Last == ';'  || $Last == ':')
				{
					$Text = substr($Text, 0, $Limit - 2) . $Padding;
				}
				else if($Last == '.' || $Last == '?' || $Last == '!')
				{
					$Text = substr($Text, 0, $Limit - 1);
				}
				else
				{
					$Text = substr($Text, 0, $Limit - 1) . $Padding;
				}
			}
			else
			{
				$Text = substr($Text, 0, $Limit) . $Padding;
			}
       }  
       return $Text;
    }
    
    
    /**
     * Retorna texto alinhado
     * 
     * @access public
     * @param string $Title
     * @param int $TitleCount
     * @param string $Text
     * @param int $TextCount
     * @param int $Count
     * @return string
     */
    public static function TextAlign($Title, $TitleCount, $Text, $TextCount, $Count)
    {
		return self::CutText($Text, ceil($Count - ceil(strlen($Title) / $TitleCount)) * $TextCount); 
    }
    
    /**
     * Retorna a saudação
     * 
     * @access public 
     * @return string
     */
    public static function Greeting()
    {
    	$hour = date("H");
		if ($hour < 12)
		{
			return "Bom dia";
		}
		elseif ($hour < 18)
		{
			return "Boa tarde";
		}
		else
		{
			return "Boa noite";
		}
    }
    
    /**
	 * Formata endereço
	 * 
	 * @access public
	 * @return string
	 */
	public function FormatAddress()
	{
		$sRet = $this->Endereco . ", nº " . $this->Numero;
		$sRet .= (($this->Complemento) ? " - " . $this->Complemento . " - " : " ");
		$sRet .= $this->Bairro . "<br />";
		$sRet .= "CEP: " . $this->CEP . " - ";
		$sRet .= $this->Cidade . " - " . $this->Estado;
		return $sRet;
	}
    
    /**
     * Subistitui os acentos
     * 
     * @access public
	 * @param string $Text
     * @return string
     */
    public static function ReplaceAccent($Text)
	{
	    $From = 'ÀÁÂÃÄÅàáâãäåÒÓÔÕÕÖØòóôõöøÈÉÊËèéêëðÇçÐÌÍÎÏìíîïÙÚÛÜùúûüÑñŠšŸÿýŽž';
	    $To   = 'AAAAAAaaaaaaOOOOOOOooooooEEEEeeeeeCcDIIIIiiiiUUUUuuuuNnSsYyyZz';
	    return strtr($Text, $From, $To);
	}
	
	/**
	 * Prepara texto para pesquisa
	 * 
	 * @access public
	 * @param string $Text
	 * @return string
	 */
	public static function ParseSearch($Text)
	{
		$Text = trim(strtolower(self::ReplaceAccent($Text)));	
		$Text = preg_replace(array("([^a-z0-9 ])i", "[ ]", "/([a|e|i|o|u|c])/i"), array(".", ".*", "[$1]"), $Text);
		
		$Entities = array
		(
			"(a|ã|á|à|ä|â|&atilde;|&aacute;|&agrave;|&auml;|&acirc;|Ã|Á|À|Ä|Â|&Atilde;|&Aacute;|&Agrave;|&Auml;|&Acirc;)",
			"(e|é|è|ë|ê|&eacute;|&egrave;|&euml;|&ecirc;|É|È|Ë|Ê|&Eacute;|&Egrave;|&Euml;|&Ecirc;)",
			"(i|í|ì|ï|î|&iacute;|&igrave;|&iuml;|&icirc;|Í|Ì|Ï|Î|&Iacute;|&Igrave;|&Iuml;|&Icirc;)",
			"(o|õ|ó|ò|ö|ô|&otilde;|&oacute;|&ograve;|&ouml;|&ocirc;|Õ|Ó|Ò|Ö|Ô|&Otilde;|&Oacute;|&Ograve;|&Ouml;|&Ocirc;)",
			"(u|ú|ù|ü|û|&uacute;|&ugrave;|&uuml;|&ucirc;|Ú|Ù|Ü|Û|&Uacute;|&Ugrave;|&Uuml;|&Ucirc;)",
			"(c|ç|Ç|&ccedil;|&Ccedil;)"
		);
		
		$Text = str_replace(array("[a]", "[e]", "[i]", "[o]", "[u]", "[c]"), $Entities, $Text);
		
		return $Text;
	}
	
	/**
     * Remove protocolo
     * 
     * @access public
	 * @param string $Link 
     * @return string
     */
    public static function RemoveProtocolo($Link)
    {
    	return preg_replace("/^[^:]+:\/+(.*)$/", "\\1", $Link);
    }
    
    /**
     * HTML Encode
     * 
     * @access public
	 * @param string $Text
     * @return string
     */
    public static function HTMLDecode($Text)
    {
        return html_entity_decode(html_entity_decode($Text, ENT_QUOTES), ENT_QUOTES);
    }

    /**
     * HTML Decode
     * 
     * @access public
	 * @param string $Text
     * @return string
     */
    public static function HTMLEncode($Text)
    {
        return htmlspecialchars($Text, ENT_QUOTES);
    }
	
	/**
     * Converte data para salvar
     * 
     * @access public
     * @param string $Date
     * @return string
     */
    public static function DateConvert($Date)
    {
        $sepDate = explode(" ", $Date);
        
		$d = explode("/", $sepDate[0]);
        $day = intval($d[0]);
        $month = intval($d[1]);
        $year = intval($d[2]);
        
        $t = explode(":", $sepDate[1]);
        $hour = intval($t[0]);
        $minute = intval($t[1]);
        $second = intval($t[2]);
        
        return "$year-$month-$day $hour:$minute:$second";
    }
    
    /**
     * Formata data para exibir em qualquer formato
     * 
     * @access public
     * @param string $Date
     * @return int
     */
    public static function DateShow($Date)
    {
        $d = date("d", strtotime($Date));
        $m = date("m", strtotime($Date));
        $y = date("Y", strtotime($Date));
        $h = date("H", strtotime($Date));
        $i = date("i", strtotime($Date));
        $s = date("s", strtotime($Date));
        return strtotime("$m/$d/$y $h:$i:$s");
    }
    
    /**
     * Formata data para exibir
     * 
     * @access public
     * @param string $Format
     * @param string $Date
     * @return string
     */
    public function DateFormat($Format, $Date)
    {
    	$Date = $this->DateShow($Date);
    	
		$Format = str_replace("week", "\\" . implode("\\", str_split(substr($this->Week[intval(date("w", $Date))], 0, 3))), $Format);
    	$Format = str_replace("WEEK", "\\" . implode("\\", str_split($this->Week[intval(date("w", $Date))])), $Format);
    	
    	$Format = str_replace("month", "\\" . implode("\\", str_split(substr($this->Month[intval(date("m", $Date))], 0, 3))), $Format);
    	$Format = str_replace("MONTH", "\\" . implode("\\", str_split($this->Month[intval(date("m", $Date))])), $Format);
    	
    	return date($Format, $Date);
    }
    
    /**
     * Formata valor para mostrar
     * 
     * @access public
     * @param string $Decimal
     * @return string
     */
    public static function DecimalShow($Decimal)
    {
        return number_format($Decimal, 2, ',', '.');
    }

    /**
     * Formata valor para salvar
     * 
     * @access public
     * @param string $Decimal
     * @return string
     */
    public static function DecimalConvert($Decimal)
    {
        return str_replace(",", ".", str_replace(".", "", (($Decimal) ? $Decimal : "0,0")));
    }
    
    /**
     * Retorna a extensão de um arquivo
     * 
     * @access public
     * @param string $Path
     * @return string
     */
    public static function GetExtension($Path)
    {
    	return strtolower(end(explode(".", $Path)));
    }
    
    /**
     * Gera um nome genérico
     * 
     * @access public
     * @param int $Length (Default: 20)
     * @return string
     */
    public static function GenerateName($Length = 20)
	{
		$Toquen = md5(uniqid(rand(), true));
        $Name = strtolower(substr($Toquen, 0, $Length));
        return $Name;
	}
	
	/**
     * Cria o diretório
     * 
     * @access public
     * @param string $Directory
     * @return void
     */
    public static function CreateDirectory($Directory)
    {
        $dirs = explode("/", $Directory);
        $dir = substr($_SERVER["DOCUMENT_ROOT"], 0, 1);
        if($dir != DIRECTORY_SEPARATOR)
        {
			$dir = "";
		}
        for ($z = 0; $z < count($dirs); $z++)
        {
            if (trim($dirs[$z]) != "")
            {
                $dir .= $dirs[$z] . "/";

                if (!is_dir($dir))
                {
                    mkdir($dir, 0777);
                    umask(0000);
                	chmod($dir, 0777);
                }
            }
        }
    }
    
	/**
     * Gera o caminho do arquivo disponível
     * 
     * @access public
     * @param string $DirName
     * @param string $Name (Default: null)
     * @param string $Extension
     * @return string
     */
    public function GenerateFilePath($DirName, $Name = null, $Extension)
    {
    	$Path = $this->DirectoryUserFilesPath . $DirName . "/";
    	self::CreateDirectory($Path);
    	
    	$File = "";
    	$b = false;
    	$count = 0;
        while($b == false)
        {
        	$FileName = "";
        	if($Name)
        	{
        		$FileName = $Name;
        		if($count > 0)
        		{
        			$FileName .= "(" . $count . ")";
        		}
        		$count++;
        	}
        	else
        	{
        		$FileName = self::GenerateName();
        	}
        	
        	$File = $Path . $FileName . "." . $Extension;
        	$b = !is_file($File);
        }
        
        return $File;
    }
    
    /**
     * Caminho do arquivo para ser salvo
     * 
     * @access public
     * @param string $File
     * @return string
     */
    public function ParseFilePath($File)
    {
    	return str_replace($this->DirectoryRoot, "", $File);
    }
    
    /**
     * Analisa diretório
     * 
     * @access public
     * @param string $DirName
     * @param string $File
     * @param bool $CreateDirectory (Default: false)
     * @return string
     */
    public function ParseDirectory($DirName, $File, $CreateDirectory = false)
    {
		$PathInfo = pathinfo($File);
		$BaseFile = self::RemoveCaracter(str_replace(array("../", "./", $this->DirectoryRoot, $this->DirectoryUserFilesName, $this->DirectoryUserFilesPath), "", "/" . $PathInfo["dirname"] . "/"));
    	$Directory = $this->DirectoryUserFilesPath . self::RemoveCaracter($DirName) . "/" . $BaseFile . (($BaseFile) ? "/" : "");
		if($CreateDirectory) self::CreateDirectory($Directory);
    	return $Directory;
	}
    
    /**
     * Define mensagem
     * 
     * @access public
	 * @param string $Type
     * @param string $Message (Default: "")
     * @param string $Title (Default: "")
     * @return void
     */
    public static function SetMessage($Type, $Message = "", $Title = "")
    {
        $_SESSION["Message"] = ((!$_SESSION["Message"]) ? array() : $_SESSION["Message"]);
        $_SESSION["Message"][] = array("Title" => $Title, "Message" => $Message, "Type" => $Type);
    }
    
    /**
     * Busca mensagem da sessão
     * 
     * @access public
     * @return string
     */
    public static function GetMessage()
    {
    	$sRet = "";
        if (is_array($_SESSION["Message"]))
        {
			foreach($_SESSION["Message"] as $c => $v)
			{
				$sRet .= self::CreateMessage($v["Type"], $v["Message"], $v["Title"]);
	        }
	        session_unregister("Message");
	    }
	    return $sRet;
    }
    
    /**
     * Cria mensagem
     * 
     * @access public
     * @param string $Type
     * @param string $Message (Default: null)
     * @param string $Title (Default: null)
     * @return string
     */
    public static function CreateMessage($Type, $Message = null, $Title = null)
    {
    	$arTitle = array
		(
			"vermelho" => "Confirmado!",
			"azul" => "Confirmado!",
			"verde" => "Confirmado!",
			"amarelo" => "Atenção!"
		);
		
		$arMessage = array
		(
			"vermelho" => "O <b>Registro</b> foi removido com sucesso.",
			"azul" => "O <b>Registro</b> foi editado com sucesso.",
			"verde" => "O <b>Registro</b> foi cadastrado com sucesso.",
			"amarelo" => "Ocorreu um erro durante esse processo."
		);
		
		$Type = strtolower($Type);
    	$Message = (($Message) ? $Message : $arMessage[$Type]);
		$Title = (($Title) ? $Title : $arTitle[$Type]);
		
		if(!array_key_exists($Type, $arMessage))
		{
			throw new Exception("Tipo inválido.");
		}
		       
		return '<div class="mensagem"><div class="' . $Type . '"><span>' . $Title . '</span>' . $Message . '</div></div>';
    }
    
    /**
     * Força o download
     * 
     * @access public
	 * @param string $Content
     * @param string $Name (Default: null)
     * @param bool $IsFile (Default: true)
     * @return bool
     */
    public static function ForceDownload($Content, $Name = null, $IsFile = true)
    {
    	if($IsFile)
    	{
    		if(!is_file($Content))
			{
				throw new Exception("Arquivo não encontrado.");
			}
			
			chmod($Content, 0777);
			
    		$Name = ((!$Name) ? basename($Content) : $Name);
    		$Extension = strtolower(substr(strrchr($Content, "."), 1));
    		$Lenght = filesize($Content);
    		$Content = file_get_contents($Content);
    	}
    	else
    	{
    		$Extension = strtolower(substr(strrchr($Name, "."), 1));
    		$Lenght = strlen($Content);
    	}
		
		switch ($Extension)
		{
			case "pdf": $ctype="application/pdf"; break;
			case "exe": $ctype="application/octet-stream"; break;
			case "zip": $ctype="application/zip"; break;
			case "doc": $ctype="application/msword"; break;
			case "xls": $ctype="application/vnd.ms-excel"; break;
			case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
			case "gif": $ctype="image/gif"; break;
			case "png": $ctype="image/png"; break;
			case "jpe": case "jpeg":
			case "jpg": $ctype="image/jpg"; break;
			default: $ctype="application/force-download";
		}
		
		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: private", false);
		header("Content-Type: " . $ctype);
		header("Content-Disposition: attachment; filename=\"". $Name ."\";");
		header("Content-Transfer-Encoding: binary");
		header("Content-Length: " . $Lenght);
		echo $Content;
    }
    
    /**
     * Gera chave para formulário
     * 
     * @access public
     * @param string $Name (Default: "")
     * @return string
     */
    public static function GenerateKeyForm($Name = "")
    {
		return '<input type="hidden" id="hidFormKey' . $Name . '" name="hidFormKey' . $Name . '" value="1" />';
    }
    
    /**
     * Verifica chave do formulário
     * 
     * @access public
	 * @param method $Method
     * @param string $Name (Default: "")
     * @return bool
     */
    public static function CheckKeyForm($Method, $Name = "")
    {
		return ($Method && $Method["hidFormKey" . $Name] == "1");
    }
    
    /**
     * Remove itens $_SERVER["QUERY_STRING"]
     * 
     * @access public
	 * @param array $ar (Default: array())
	 * @param bool $encode (Default: false)
     * @return string
     */
    public static function RemoveQueryString($ar = array(), $encode = false)
    {
    	$ret = ""; 
    	$ar = ((is_array($ar)) ? $ar : array());
    	$arParameter = explode("&", $_SERVER["QUERY_STRING"]);
		foreach($arParameter as $v)
		{
			if($v)
			{
				$parans = explode("=", $v);
				if(!in_array($parans[0], $ar))
				{
					$ret .= $v . (($encode) ? "&amp;" : "&");
				}
			}
		}
		return $ret;
    }
    
    /**
     * Prepara template de respsota
     * 
     * @access public
     * @param string $Message {Default: null}
     * @param string $TemplateName {Default: null}
     * @param string $FolderTemplate {Default: "template-resposta"}
     * @param string $FileName {Default: "index.php"}
     * @return string
     */
    public static function TemplateEmail($Message = null, $TemplateName = null, $FolderTemplate = "template-resposta", $FileName = "index.php")
	{
		$File = dirname(dirname(__FILE__)) . "/" . $FolderTemplate . "/" . (($TemplateName) ? $TemplateName . "/" : "") . $FileName;
		if(is_file($File))
		{
			ob_start();
			$_TEMPLATE = $Message;
			$_EXTRA = $Extra;
			include($File);
			$Content = ob_get_contents();
			ob_end_clean();
			
			return $Content;
		}
		else
		{
			return $Message;
		}
	}
	
	/**
	 * Formata tamanho do arquivo
	 * 
	 * @access public
	 * @param int $Size
	 * @param int $Precision (Default: 0)
	 * @return string
	 */
	public static function FormatSize($Size, $Precision = 0)
	{
		if($Size == 0) return "";
		$Sizes = array(" Bytes", " KB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB");
		return (round($Size/pow(1024, ($i = floor(log($Size, 1024)))), $Precision) . $Sizes[$i]);
	}
	
	/**
     * Prepara texto para colcoar na url
     * 
     * @access public
	 * @param string $Text
	 * @param string $Separator (Default: "+")
     * @return string
     */
    public static function PrepareToURL($Text, $Separator = "+")
    {
    	return strtolower(preg_replace(array("/ /", "/([^a-z+0-9-]+)/i"), array($Separator, ""), trim(self::ReplaceAccent($Text))));
    }
    
    /**
     * Gera url amigável
     * 
	 * @access public
     * @param string $Local
	 * @param string $Reference (Default: null)
     * @param string $Title (Default: null)
     * @param string $Extension (Default: "")
     * @param string $Separator (Default: "/")
     * @return string
     */
    public function GenerateFriendlyURL($Local, $Reference = null, $Title = null, $Extension = "", $Separator = "/")
	{
		$Param = "";
		if(is_array($Local))
		{
			foreach($Local as $c => $v)
			{
				$Param .= self::PrepareToURL($v) . $Separator;
			}
		}
		else
		{
			$Param = self::PrepareToURL($Local) . $Separator;
		}
		
		$Reference = (($Reference) ? $Reference . $Separator : "");
		$Title = (($Title) ? self::PrepareToURL($Title) . $Extension : "");
		
		return $this->WebURL . $Param . $Reference . $Title;
	}
	
	/**
	 * Gera Thumbnail
	 * 
	 * @access public
	 * @param string $Image
	 * @param int $Width
	 * @param int $Height
	 * @param string $ImageNotFound (Default: "")
	 * @param bool $Cut (Default: false)
	 * @param bool $Center (Default: false)
	 * @return string
	 */
	public function Thumbnail($Image, $Width, $Height, $ImageNotFound = "", $Cut = false, $Center = false)
	{
		if(!$Image)
		{
			return $ImageNotFound;
		}
		
		try
		{
			$PathInfo = pathinfo($Image);
			
			$arGlob = glob($this->ParseDirectory("recortar-imagem", $Image) . $PathInfo["filename"] . "_" . $Width . "x" . $Height . "_*");
			if(is_array($arGlob))
			{
				foreach($arGlob as $File)
				{
					$Image = $this->ParseFilePath($File);
					$PathInfo = pathinfo($Image);
					break;
				}
			}
			
			$Path = $this->ParseDirectory("thumb", str_replace($this->DirectoryUserFilesName . "recortar-imagem/", $this->DirectoryUserFilesName, $Image), true) . $PathInfo["filename"] . "_" . $Width . "x" . $Height . "_" . (($Cut) ? 1 : 0) . "_" . (($Center) ? 1 : 0) . "." . $PathInfo["extension"];
			
			if(!is_file($Path))
			{
				include_once(dirname(__FILE__) . "/resize.php");
				
				$oResize = new Resize(((is_file($Image)) ? "" : dirname(dirname(__FILE__))) . $Image);
				$oResize->NewWidth = $Width;
				$oResize->NewHeight = $Height;
				$oResize->IsCut = $Cut;
				$oResize->IsCenter = $Center;
				$oResize->Create(false, $Path);
			}
			
			return $this->WebURL . substr($this->ParseFilePath($Path), 1);
		}
		catch(Exception $e)
		{
			return $ImageNotFound;
		} 
	}
	
	/**
	 * Recortar imagem
	 * 
	 * @access public
	 * @param string $Image
	 * @param int $Width
	 * @param int $Height
	 * @param string $AspectRatio (Default: null)
	 * @param int $MinWidth (Default: null)
	 * @param int $MinHeight (Default: null)
	 * @param int $MaxWidth (Default: null)
	 * @param int $MaxHeight (Default: null)
	 * @return void
	 */
	public function CropImage($Image, $Width, $Height, $AspectRatio = null, $MinWidth = null, $MinHeight = null, $MaxWidth = null, $MaxHeight = null)
	{
		if(!$Image) return;
		
		$Width = ((is_array($Width)) ? $Width : array($Width));
		$Height = ((is_array($Height)) ? $Height : array($Height));
		$AspectRatio = ((is_array($AspectRatio)) ? $AspectRatio : array($AspectRatio));
		$MinWidth = ((is_array($MinWidth)) ? $MinWidth : array($MinWidth));
		$MinHeight = ((is_array($MinHeight)) ? $MinHeight : array($MinHeight));
		$MaxWidth = ((is_array($MaxWidth)) ? $MaxWidth : array($MaxWidth));
		$MaxHeight = ((is_array($MaxHeight)) ? $MaxHeight : array($MaxHeight));
		
		if(count($Width) < 1 || count($Height) < 1) return;
		
		$PathInfo = pathinfo($Image);
		$ImageURL = $this->Thumbnail($Image, 950, 500);
		$ImageSource = str_replace($this->WebURL, $this->DirectoryRoot . "/", $ImageURL);
		$ImageSize = getimagesize($ImageSource);
		$ImageWidth = intval($ImageSize[0]);
		$ImageHeight = intval($ImageSize[1]);
		
		?>
		<table class="lista" style="width:auto;">
			<?php
			foreach($Width as $p => $w)
			{
				$ImageCut = glob($this->ParseDirectory("recortar-imagem", $Image) . $PathInfo["filename"] . "_" . $Width[$p] . "x" . $Height[$p] . "_*");
				
				if(is_array($ImageCut) && count($ImageCut) > 0)
				{
					$ImageCutPathInfo = pathinfo($ImageCut[0]);
					$ImageCutPosition = array_reverse(explode("_", $ImageCutPathInfo["filename"]));
					
					$x1 = intval($ImageCutPosition[3]);
					$y1 = intval($ImageCutPosition[2]);
					$x2 = intval($ImageCutPosition[1]);
					$y2 = intval($ImageCutPosition[0]);
				}
				else
				{
					$x1 = 0;
					$y1 = 0;
					$x2 = $ImageWidth;
					$y2 = $ImageHeight;
				}
				
				?>
				<tr>
					<td align="center"><?=$Width[$p];?>x<?=$Height[$p];?></td>
					<td align="center"><a href="javascript:void(0);" onclick="cropImage.init(this, '<?=$this->WebURLAdmin;?>', '<?=$Image;?>', '<?=$ImageURL;?>', '<?=$ImageSource;?>', <?=$ImageWidth;?>, <?=$ImageHeight;?>, <?=intval($Width[$p]);?>, <?=intval($Height[$p]);?>, <?=intval($x1);?>, <?=intval($y1);?>, <?=intval($x2);?>, <?=intval($y2);?>, '<?=$AspectRatio[$p];?>', <?=intval($MinWidth[$p]);?>, <?=intval($MinHeight[$p]);?>, <?=intval($MaxWidth[$p]);?>, <?=intval($MaxHeight[$p]);?>);"><img title="Recortar" alt="Recortar" src="../imgs/botoes/recortar.png" /></a></td>
				</tr>
				<?php
			}
			?>
		</table>
		<?php
	}
	
	/**
	 * Download URL
	 * 
	 * @access public
	 * @param string $Arquivo
	 * @param string $Path (Default: "..")
	 * @return string
	 */
	public function DownloadURL($Arquivo, $Path = "..")
	{
		return $this->WebURL . "library/download.php?path=" . $Path . $Arquivo;
	}
	
	/**
	 * Verifica se conteudo está em branco
	 * 
	 * @access public
	 * @param string $Text
	 * @return bool
	 */
	public static function IsClear($Text)
	{
		$Text = trim(strip_tags(Util::HTMLDecode($Text)));
		return (strlen($Text) <= 1);
	}
}

Util::InitSet();
Util::CheckVariables();

?>