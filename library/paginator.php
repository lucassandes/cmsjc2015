<?php

/**
 * Classe utilizada para paginar
 * 
 * @author ClickNow <suporte@clicknow.com.br>
 * @copyright Copyright (c), ClickNow
 * @access public
 */
class Paginator
{
	//
	public $Key = null;
	public $TotalRecords = 0;
	public $Total = 0;
	public $TotalPages = 0;
	public $Page = 0;
	public $Limit = 0;
	public $Parameter = null;
	public $ParameterWithPage = null;
	public $URL = null;
	public $Result = null;
	public $LimitPageNumber = 3;
	public $TotalFrom = null;
	public $TotalTo = null;
	public $ForceFormat = false;
	public $Anchor = "";
	
	//Objetos
	public $IsTotal = true;
	public $IsPager = true;
	public $IsFisrt = true;
	public $IsPrev = true;
	public $IsNext = true;
	public $IsLast = true;
	
	//CSS
	public $ClassPager = "paginacao";
	public $ClassPagerSelected = "active";
	public $ClassPagerTotal = "total";
	public $ClassPagerFirst = "primeira";
	public $ClassPagerPrev = "anteriror";
	public $ClassPagerNext = "proxima";
	public $ClassPagerLast = "ultima";
	public $ClassPagerLink = "link";
	
	//Textos
	public $TextPagerTotal = "Total:";
	public $TextPagerTotalRegister = "registro(s) encontrado(s)";
	public $TextPagerFirst = "<span>�</span> Primeira p�gina";
	public $TextPagerPrev = "<span>�</span>Anterior";
	public $TextPagerNext = "Pr�xima <span>�</span>";
	public $TextPagerLast = "�ltima p�gina <span>�</span>";
	public $TextPagerSeparator = "";
	
	/**
     * Construtor da classe
     * 
     * @access public
     * @param int $TotalRecords
	 * @param int $Total (Default: 20)
	 * @param string $Key (Default: "pg")
	 * @param int $Page (Default: null)
	 * @param string $Parameter (Default: null)
	 * @param array $Replace (Default: array("id"))
	 * @param string $Base (Default: null)
     * @return void
     */
	public function Paginator($TotalRecords, $Total = 20, $Key = "pg", $Page = null, $Parameter = null, $Replace = array("id"), $Base = null)
	{
		$Replace = ((!is_array($Replace)) ? array() : $Replace);
		array_push($Replace, $Key);
		$this->TotalRecords = $TotalRecords;
		$this->Total = $Total;
		$this->Key = $Key;
		$this->TotalPages = ceil($this->TotalRecords / $this->Total);
		$this->Page = intval((($Page === null) ? $_GET[$this->Key] : $Page));
		$this->Page = (($this->Page < 0) ? 0 : $this->Page);
		$this->Page = (($this->Page >= $this->TotalPages) ? 0 : $this->Page);
		$this->Limit = ($this->Page * $this->Total);
		$this->ClearParameter((($Parameter !== null) ? $Parameter : $_SERVER["QUERY_STRING"]), $Replace);
		$this->ParameterWithPage = $this->Parameter . $Key . "=" . $this->Page;
		$this->URL = (($Base === null) ? str_replace("?" . $_SERVER["QUERY_STRING"], "", $_SERVER["PHP_SELF"]) . "?" . $this->Parameter . $Key . '=#PG#' : $Base);
		$this->TotalFrom = ($this->Page * $this->Total) + 1;
		$this->TotalTo = ($this->Page + 1) * $this->Total;
		$this->TotalTo = (($this->TotalTo > $this->TotalRecords) ? $this->TotalRecords : $this->TotalTo);
		$this->Create();
	}
	
	/**
	 * Limpa os par�metros
	 * 
	 * @access public
	 * @param string $Parameter
	 * @param array $Replace (Default: array())
	 * @return void
	 */
	public function ClearParameter($Parameter, $Replace = array())
	{
		$arParameter = explode("&", $Parameter);
		foreach($arParameter as $v)
		{
			if($v)
			{
				$parans = explode("=", $v);
				if(!in_array($parans[0], $Replace))
				{
					$this->Parameter .= $v . "&amp;";
				}
			}
		}
	}
	
	/**
	 * Gera html da pagina��o
	 * 
	 * @access public
	 * @return void
	 */
	public function Create()
	{
		//Pagina��o
		$sRet = "";
		$sRet .= '<div class="' . $this->ClassPager . '">';
	
		//Total
	    $sRet .= (($this->IsTotal) ? '<span class="' . $this->ClassPagerTotal . '">' . $this->TextPagerTotal . ' <b>' . $this->TotalRecords . '</b> ' . $this->TextPagerTotalRegister . '</span><span class="' . $this->ClassPagerLink . '">' : '');
	    
	    //Anterior / Primeira
	    $sRet .= (($this->IsFisrt && $this->CheckFirstPage()) ? '<a href="' . $this->GenerateLinkFirstPage() . '" class="' . $this->ClassPagerFirst . '">' . $this->TextPagerFirst . '</a>' : '');
	    $sRet .= (($this->IsNext && $this->CheckPrevPage()) ? '<a href="' . $this->GenerateLinkPrevPage() . '" class="' . $this->ClassPagerPrev . '">' . $this->TextPagerPrev . '</a>' : '');
	    
	    //Links
	    if ($this->TotalPages > 1 && $this->IsPager)
	    {
	    	$arPages = array();
	    	
	    	//...
	    	if($this->Page > $this->LimitPageNumber)
	    	{
	    		array_push($arPages, '<li><a href="' . $this->GenerateLink($this->Page - ($this->LimitPageNumber + 1)) . '">...</a></li>');
	    	}
	
			//p�ginas anteriores
	        for ($d = (($this->Page > $this->LimitPageNumber) ? ($this->Page - $this->LimitPageNumber) : 0); $d < $this->Page; $d++)
	        {
	            array_push($arPages, '<li><a href="' . $this->GenerateLink($d) . '">' . $this->FormatNumer($d + 1) . '</a></li>');
	        }
	
			//pr�ximas p�ginas
	        $iconta = 1;
	        for ($o = $this->Page; $o < $this->TotalPages; $o++)
	        {
	            if ($this->Page == $o)
	            {
	                array_push($arPages, '<li class="' . $this->ClassPagerSelected . '"><span class="' . $this->ClassPagerSelected . '">' . $this->FormatNumer($o + 1) . '</span></li>');
	            }
	            else
	            {
	                if ($iconta > $this->LimitPageNumber)
	                {
	                    array_push($arPages, '<li><a href="' . $this->GenerateLink($o) . '">...</a></li>');
	                    break;
	                }
	                else
	                {
	                    array_push($arPages, '<li><a href="' . $this->GenerateLink($o) . '">' . $this->FormatNumer($o + 1) . '</a></li>');
	                    $iconta += 1;
	                }
	            }
	        }
	        
	        $sRet .= implode($arPages, $this->TextPagerSeparator);
	    }
	    
	    //Pr�xima / �ltima p�gina
	    $sRet .= (($this->IsNext && $this->CheckNextPage()) ? '<a href="' . $this->GenerateLinkNextPage() . '" class="' . $this->ClassPagerNext . '">' . $this->TextPagerNext . '</a>' : '');
		$sRet .= (($this->IsLast && $this->CheckLastPage()) ? '<a href="' . $this->GenerateLinkLastPage() . '" class="' . $this->ClassPagerLast . '">' . $this->TextPagerLast . '</a>' : '');
		
		//Total
	    $sRet .= (($this->IsTotal) ? '</span>' : '');
	    
		//Pagina��o
	    //$sRet .= '</div>';
	
		$this->Result = $sRet;
	}
	
	/**
	 * Formata n�mero da p�gina
	 * 
	 * @access public
	 * @param int $Number
	 * @return string
	 */
	private function FormatNumer($Number)
	{
		return (($this->ForceFormat) ? sprintf("%02d", $Number) : $Number);
	}
	
	/**
	 * Gera o link da pagina��o
	 * 
	 * @access public
	 * @param int $PG (Default: 0)
	 * @return string
	 */
	public function GenerateLink($PG = 0)
	{
		return str_replace("#PG#", $PG, $this->URL) . (($this->Anchor) ? "#" . $this->Anchor : "");
	}
	
	/**
	 * Gera o link para pr�xima p�gina
	 * 
	 * @access public
	 * @return string
	 */
	public function GenerateLinkNextPage()
	{
		return $this->GenerateLink($this->Page + 1);
	}
	
	/**
	 * Gera o link para �ltima p�gina
	 * 
	 * @access public
	 * @return string
	 */
	public function GenerateLinkLastPage()
	{
		return $this->GenerateLink($this->TotalPages - 1);
	}
	
	/**
	 * Gera o link para p�gina anterior
	 * 
	 * @access public
	 * @return string
	 */
	public function GenerateLinkPrevPage()
	{
		return $this->GenerateLink($this->Page - 1);
	}
	
	/**
	 * Gera o link para primeria p�gina
	 * 
	 * @access public
	 * @return string
	 */
	public function GenerateLinkFirstPage()
	{
		return $this->GenerateLink();
	}
	
	/**
	 * Verifica se o link para pr�xima p�gina est� ativo
	 * 
	 * @access public
	 * @return bool
	 */
	public function CheckNextPage()
	{
		return (($this->Page + 1) < $this->TotalPages && $this->TotalPages > 1);
	}
	
	/**
	 * Verifica se o link para �ltima p�gina est� ativo
	 * 
	 * @access public
	 * @return bool
	 */
	public function CheckLastPage()
	{
		return (($this->Page + 1) < $this->TotalPages && $this->TotalPages > 1);
	}
	
	/**
	 * Verifica se o link para p�gina anterior est� ativo
	 * 
	 * @access public
	 * @return bool
	 */
	public function CheckPrevPage()
	{
		return ($this->Page > 0 && $this->TotalPages > 1);
	}
	
	/**
	 * Verifica se o link para primeira p�gina est� ativo
	 * 
	 * @access public
	 * @return bool
	 */
	public function CheckFirstPage()
	{
		return ($this->Page > 0 && $this->TotalPages > 1);
	}
}

?>