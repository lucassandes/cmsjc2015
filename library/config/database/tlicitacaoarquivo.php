<?php

include_once(dirname(dirname(__FILE__)) . "/database.php");

/**
 * Classe utilizada para administrar a tabela tlicitacaoarquivo
 * 
 * @author ClickNow <suporte@clicknow.com.br>
 * @copyright Copyright (c), ClickNow
 * @access public
 */
class tlicitacaoarquivo extends Database
{
	protected $TableName = "tlicitacaoarquivo";
	protected $Fields = array("ID", "LicitacaoID", "Titulo", "Arquivo");
	public $ID, $LicitacaoID, $Titulo, $Arquivo;
	
	/**
     * Construtor da classe
     * 
     * @access public
     * @return void
     */
	public function tlicitacaoarquivo()
	{
		parent::Database();
	}
	
	private $SessionName = "LicitacaoArquivo";
	
	/**
	 * Carrega os arquivos por licitação
	 * 
	 * @access public
	 * @param int $LicitacaoID
	 * @return bool
	 */
	public function LoadByLicitacaoID($LicitacaoID)
	{
		$this->SQLWhere = "LicitacaoID = '" . intval($LicitacaoID) . "'";
		$this->SQLOrder = "ID ASC";
		return $this->LoadSQLAssembled();
	}
	
	/**
	 * Remove os arquivos por licitação
	 * 
	 * @access public
	 * @param int $LicitacaoID
	 * @return void
	 */
	public function RemoveFileByLicitacaoID($LicitacaoID)
	{
		if($this->LoadByLicitacaoID($LicitacaoID))
		{
			for($q = 0; $q < $this->NumRows; $q++)
			{
				$this->RemoveFile("../.." . $this->Arquivo);
				$this->MoveNext();
			}
		}
	}
	
	/**
	 * CheckSession
	 * 
	 * @access public
	 * @return bool
	 */
	public function CheckSession()
	{
		return $_SESSION[$this->SessionName . $this->LicitacaoID];
	}
	
	/**
	 * SetSession
	 * 
	 * @access public
	 * @return void
	 */
	public function SetSession()
	{
		$_SESSION[$this->SessionName . $this->LicitacaoID] = $this->ID;
	}
}

?>