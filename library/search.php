<?php

include_once(dirname(__FILE__) . "/util.php");

/**
 * Classe utilizada para procurar
 * 
 * @author ClickNow <suporte@clicknow.com.br>
 * @copyright Copyright (c), ClickNow
 * @access public
 */
class Search extends Util
{
	protected $Word = null;
	protected $WordRegexp = null;
	protected $MaxLength = 0;
	protected $IsBold = true;
	protected $TagBold = "strong";
	public $RemoveSearch = array();
	public $Itens = array();
	
	/**
     * Construtor da classe
     * 
     * @access public
     * @param string $Word
	 * @param int $MaxLength (Default: 0)
	 * @param bool $Bold (Default: true)
	 * @param string $TagBold (Default: strong)
     * @return void
     */
	public function Search($Word, $MaxLength = 0, $IsBold = true, $TagBold = "strong")
	{
		parent::Util();
		$this->Word = $Word;
		$this->WordRegexp = $this->ParseSearch($this->Word);
		$this->MaxLength = $MaxLength;
		$this->IsBold = $IsBold;
		$this->TagBold = $TagBold;
	}
	
	/**
	* Adiciona diretório para procura
	* 
	* @access public
	* @param string $Directory
	* @param bool $Loop (Default: false)
	* @param string $RegexTitle (Default: null)
	* @param string $RegexArea (Default: null)
	* @return void
	*/
	public function AddDirectory($Directory, $Loop = false, $RegexTitle = null, $RegexArea = null)
	{
		while(substr($Directory, -1, 1) == "/") $Directory = substr($Directory, 0, -1);
		
		//verifica o diretório
		if (!is_dir($Directory) || in_array($Directory, $this->RemoveSearch) != false)
		{
			return false;
		}
		
		//adiciona no array para não procurar mais
		array_push($this->RemoveSearch, $Directory);

		//passa pelo diretório
        if ($handle = opendir($Directory))
        {
            chmod($Directory, 0777);
            while (false !== ($file = readdir($handle)))
            {
            	if (is_file($Directory . "/" . $file) && $file != "." && $file != "..")
                {
                    $this->AddFile($Directory . "/" . $file, null, $RegexTitle, $RegexArea);
                }
                if (is_dir($Directory . "/" . $file) && $file != "." && $file != ".." && $Loop)
                {
                    $this->AddDirectory($Directory . "/" . $file, $Loop, $RegexTitle, $RegexArea);
                }
            }
            closedir($handle);
        }
	}
	
	/**
	* Adiciona arquivo para procura
	* 
	* @access public
	* @param string $File
	* @param string $Title (Default: null)
	* @param string $RegexTitle (Default: null)
	* @param string $RegexArea (Default: null)
	* @return void
	*/
	public function AddFile($File, $Title = null, $RegexTitle = null, $RegexArea = null)
	{
		//verifica o arquivo
		if(!is_file($File) || in_array($File, $this->RemoveSearch) != false)
		{
			return false;
		}
		
		//adiciona no array para não procurar mais
		array_push($this->RemoveSearch, $File);
		
		//pega o conteúdo do arquivo
		ob_start();
		include($File);
		$Content = ob_get_contents();
		ob_end_clean();
		
		//adicionar item
		$this->AddItem((($Title) ? $Title : basename($File)), $File, $Content, null, null, $RegexTitle, $RegexArea);
	}
	
	/**
	* Adicionar um item para procura
	* 
	* @access public
	* @param string $Title
	* @param string $URL
	* @param string $Content
	* @param string $ContentSearch (Default: null)
	* @param string $Extra (Default: null)
	* @param string $RegexTitle (Default: null)
	* @param string $RegexArea (Default: null)
	* @return void
	*/
	public function AddItem($Title, $URL, $Content, $ContentSearch = null, $Extra = null, $RegexTitle = null, $RegexArea = null)
	{
		$Content = $this->HTMLDecode($Content);
		$ContentSearch = $this->HTMLDecode($ContentSearch);
			
		//regex titulo
		if(trim($RegexTitle))
		{
			$match = array();
			preg_match($RegexTitle, $Content, $match);
			$Title = $match[1];
		}
		
		//regex conteudo
		if(trim($RegexArea))											
		{
			$match = array();
			preg_match($RegexArea, $Content, $match);
			$Content = $match[1];
		}
		
		//limpa conteudo
		$Content = $this->Clear($Content);
		
		//conteúdo a ser procurado
		$ContentSearch = ((!$ContentSearch) ? $Content : $ContentSearch);
		
		//procura palavra
		$Total = $this->Count($ContentSearch);
		$Position = $this->Position($ContentSearch);
		if($Total > 0)
		{
			//array com os valores
			$ar = array();
			$ar["Title"] = $Title;
			$ar["URL"] = $URL;
			$ar["Content"] = $this->Bold($this->Cut($Content, $Position));
			$ar["ContentSearch"] = $ContentSearch;
			$ar["Count"] = $Total;
			$ar["Position"] = $Position;
			$ar["Extra"] = $Extra;
			
			//add array
			array_push($this->Itens, $ar);
		}
	}
	
	/**
	 * Deixa conteúdo da pesquisa negrito
	 * 
	 * @access protected
	 * @param string $Text
	 * @return string
	 */
	protected function Bold($Text)
	{
		if(!$this->IsBold)
		{
			return $Text;
		}
		
		return preg_replace("/(" . $this->WordRegexp . ")/i", "<" . $this->TagBold . ">\\1</" . $this->TagBold . ">", $Text);
	}
	
	/**
	 * Corta o texto
	 * 
	 * @access protected
	 * @param string $Text
	 * @param int $Position
	 * @param string $Padding (Default: "...")
	 * @return string
	 */
	protected function Cut($Text, $Position, $Padding = "...")
	{ 
		if($this->MaxLength < 1)
		{
			return $Text;
		}
		
		$Position = ($Position - $this->MaxLength);
		$Start = (($Position < 0) ? 0 : $Position);
		$Length = ($this->MaxLength * 2);
		$Text = substr($Text, $Start);
		return $this->CutText($Text, $Length, $Padding);
	}
	
	/**
	 * Retorna a quantidade de palavras encontradas
	 * 
	 * @access protected
	 * @param string $Text
	 * @return int
	 */
	protected function Count($Text)
	{
		$matches = array();
		preg_match_all("/(" . $this->WordRegexp . ")/i", $Text, $matches);
		return count($matches[0]);
	}
	
	/**
	 * Verifica a posição da palavra encontrada
	 * 
	 * @access protected
	 * @param string $Text
	 * @return int
	 */
	protected function Position($Text)
	{
		return strpos($Text, $this->Word);
	}
	
	/**
	 * Limpa texto
	 * 
	 * @access protected
	 * @param string $Text
	 * @return string
	 */
	protected function Clear($Text)
	{
		$ar = array('@<head[^>]*?>.*?</head>@si',
					'@<style[^>]*?>.*?</style>@si',
					'@<script[^>]*?.*?</script>@si',
					'@<object[^>]*?.*?</object>@si',
					'@<embed[^>]*?.*?</embed>@si',
					'@<applet[^>]*?.*?</applet>@si',
					'@<noframes[^>]*?.*?</noframes>@si',
					'@<noscript[^>]*?.*?</noscript>@si',
					'@<noembed[^>]*?.*?</noembed>@si');

		return strip_tags(preg_replace($ar, '', $Text));
	}
	
	/**
	* Ornagina os itens por quantide/título
	* 
	* @access public
	* @return array
	*/
	public function Order()
	{
		function x($a, $b)
		{
			if($a["Count"] == $b["Count"])
			{
				if($a["Position"] == $b["Position"])
				{
					return strcmp ($a["Title"],$b["Title"]);
				}
				if($a["Position"] < $b["Position"])
				{
					return  -1;
				}
				return 1;
			}
			if($a["Count"] > $b["Count"])
			{
				return  -1;
			}
			return 1;
		}
		
		usort($this->Itens, x);
		return $this->Itens;
	}
}
?>