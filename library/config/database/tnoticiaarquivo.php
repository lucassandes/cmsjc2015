<?php

include_once(dirname(dirname(__FILE__)) . "/database.php");

/**
 * Classe utilizada para administrar a tabela tnoticiaarquivo
 * 
 * @author ClickNow <suporte@clicknow.com.br>
 * @copyright Copyright (c), ClickNow
 * @access public
 */
class tnoticiaarquivo extends Database
{
	protected $TableName = "tnoticiaarquivo";
	protected $Fields = array("ID", "NoticiaID", "Titulo", "Arquivo");
	public $ID, $NoticiaID, $Titulo, $Arquivo;
	
	/**
     * Construtor da classe
     * 
     * @access public
     * @return void
     */
	public function tnoticiaarquivo()
	{
		parent::Database();
	}
	
	/**
	 * Carrega os arquivos por notícia
	 * 
	 * @access public
	 * @param int $NoticiaID
	 * @return bool
	 */
	public function LoadByNoticiaID($NoticiaID)
	{
		$this->SQLWhere = "NoticiaID = '" . intval($NoticiaID) . "'";
		$this->SQLOrder = "ID ASC";
		return $this->LoadSQLAssembled();
	}
	
	/**
	 * Remove os arquivos por notícia
	 * 
	 * @access public
	 * @param int $NoticiaID
	 * @return void
	 */
	public function RemoveFileByNoticiaID($NoticiaID)
	{
		if($this->LoadByNoticiaID($NoticiaID))
		{
			for($q = 0; $q < $this->NumRows; $q++)
			{
				$this->RemoveFile("../.." . $this->Arquivo);
				$this->MoveNext();
			}
		}
	}
}

?>