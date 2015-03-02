<?php

include_once(dirname(dirname(__FILE__)) . "/database.php");

/**
 * Classe utilizada para administrar a tabela ttimelinepresidente
 * 
 * @author ClickNow <suporte@clicknow.com.br>
 * @copyright Copyright (c), ClickNow
 * @access public
 */
class ttimelinepresidente extends Database
{
	protected $TableName = "ttimelinepresidente";
	protected $Fields = array("ID", "Nome", "Periodo", "Imagem", "TimelineID");
	public $ID, $Nome, $Periodo, $Imagem, $TimelineID;
	
	/**
     * Construtor da classe
     * 
     * @access public
     * @return void
     */
	public function ttimelinepresidente()
	{
		parent::Database();
	}
	
	/**
	 * Carrega os imagens por timeline
	 * 
	 * @access public
	 * @param int $TimelineID
	 * @return bool
	 */
	public function LoadByTimelineID($TimelineID)
	{
		$this->SQLWhere = "TimelineID = '" . intval($TimelineID) . "'";
		$this->SQLOrder = "ID ASC";
		return $this->LoadSQLAssembled();
	}
	
	/**
	 * Remove os imagens por timeline
	 * 
	 * @access public
	 * @param int $TimelineID
	 * @return void
	 */
	public function RemoveFileByTimelineID($TimelineID)
	{
		if($this->LoadByTimelineID($TimelineID))
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