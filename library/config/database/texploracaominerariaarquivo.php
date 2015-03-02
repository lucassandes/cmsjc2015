<?php

include_once(dirname(dirname(__FILE__)) . "/database.php");

/**
 * Classe utilizada para administrar a tabela texploracaominerariaarquivo
 * 
 * @author ClickNow <suporte@clicknow.com.br>
 * @copyright Copyright (c), ClickNow
 * @access public
 */
class texploracaominerariaarquivo extends Database
{
	protected $TableName = "texploracaominerariaarquivo";
	protected $Fields = array("ID", "ExploracaoMinerariaID", "Titulo", "Arquivo");
	public $ID, $ExploracaoMinerariaID, $Titulo, $Arquivo;
	
	/**
     * Construtor da classe
     * 
     * @access public
     * @return void
     */
	public function texploracaominerariaarquivo()
	{
		parent::Database();
	}
	
	/**
	 * Carrega os arquivos por exploração minerária
	 * 
	 * @access public
	 * @param int $ExploracaoMinerariaID
	 * @return bool
	 */
	public function LoadByExploracaoMinerariaID($ExploracaoMinerariaID)
	{
		$this->SQLWhere = "ExploracaoMinerariaID = '" . intval($ExploracaoMinerariaID) . "'";
		$this->SQLOrder = "ID ASC";
		return $this->LoadSQLAssembled();
	}
	
	/**
	 * Remove os arquivos por exploração minerária
	 * 
	 * @access public
	 * @param int $ExploracaoMinerariaID
	 * @return void
	 */
	public function RemoveFileByExploracaoMinerariaID($ExploracaoMinerariaID)
	{
		if($this->LoadByExploracaoMinerariaID($ExploracaoMinerariaID))
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